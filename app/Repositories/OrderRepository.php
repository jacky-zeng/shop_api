<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Good;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Product;
use Cache;
use DB;

class OrderRepository
{
    use Errors;

    private $queryOrder;

    /**
     * 查询初始化
     * @return Order
     */
    public function initOrderQuery()
    {
        $this->queryOrder = new Order();
        return $this->queryOrder;
    }

    /**
     * 根据用户id
     * @param $userId
     */
    public function byUserId($userId)
    {
        $this->queryOrder = $this->queryOrder->where('user_id', $userId);
    }

    /**
     * 根据订单状态
     * @param $orderStatus
     */
    public function byOrderStatus($orderStatus)
    {
        $this->queryOrder = $this->queryOrder->where('order_status', $orderStatus);
    }

    /**
     * 获取订单列表
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function getOrders($page, $pageSize)
    {
        $orderColumn = [
            'id',
            'order_number',
            //'out_number',         //订单编号，外部支付时使用，有些外部支付系统要求特定的订单编号
            'user_id',
            'merchant_id',
            'total_amount',         //订单总价格(单位元)
            'order_amount',         //需要支付的订单金额(单位元)
            'send_amount',          //配送费(单位元)
            'pay_type',             //支付方式类型（1-支付宝 2-微信）
            'order_status',         //订单状态：1(默认):待支付 2:待配送 3:已配送 4:已送达(已完成) 5:用户已取消订单 6:商家取消订单 7:系统自动取消 8:后台取消
            'pay_status',           //付款状态：0(默认):未付款;1:已付款;
            'refund_status',        //退款状态 0未退款 1退款中 2已退款
            'order_message',        //订单留言
            'settlement_status',    //结算状态 0未结算 1已结算
            //'province_id',        //收货省id;
            //'city_id',            //收货市id
            //'area_id',            //收货区id
            //'province',           //收货省
            //'city',               //收货市
            //'area',               //收货区
        ];
        $orderGoodsColumn = [
            'id',
            'order_id',
            'order_number',
            'goods_id',
            'product_id',
            'goods_name',
            'goods_image',
            'price',
            'goods_num',
            'sku_detail'
        ];
        $orderData = $this->queryOrder
            ->with(['orderGoods' => function ($orderGoodsQuery) use ($orderGoodsColumn) {
                $orderGoodsQuery->select($orderGoodsColumn);
            }])
            ->Paginate($pageSize, $orderColumn, 'page', $page)
            ->toArray();
        $orderData = format_page($orderData);
        return $orderData;
    }

    /**
     * 获取用户订单详情
     * @param $userId
     * @param $orderNumber
     * @return array|bool
     */
    public function getOrderDetail($userId, $orderNumber)
    {
        $orderColumn = [
            'id',
            'order_number',
            //'out_number',         //订单编号，外部支付时使用，有些外部支付系统要求特定的订单编号
            'user_id',
            'merchant_id',
            'total_amount',         //订单总价格(单位元)
            'order_amount',         //需要支付的订单金额(单位元)
            'send_amount',          //配送费(单位元)
            'pay_type',             //支付方式类型（1-支付宝 2-微信）
            'order_status',         //订单状态：1(默认):待支付 2:待配送 3:已配送 4:已送达(已完成) 5:用户已取消订单 6:商家取消订单 7:系统自动取消 8:后台取消
            'pay_status',           //付款状态：0(默认):未付款;1:已付款;
            'refund_status',        //退款状态 0未退款 1退款中 2已退款
            'order_message',        //订单留言
            'settlement_status',    //结算状态 0未结算 1已结算
            //'province_id',        //收货省id;
            //'city_id',            //收货市id
            //'area_id',            //收货区id
            //'province',           //收货省
            //'city',               //收货市
            //'area',               //收货区
        ];
        $orderGoodsColumn = [
            'id',
            'order_id',
            'order_number',
            'goods_id',
            'product_id',
            'goods_name',
            'goods_image',
            'price',
            'goods_num',
            'sku_detail'
        ];
        $orderData = Order::with(['orderGoods' => function ($orderGoodsQuery) use ($orderGoodsColumn) {
            $orderGoodsQuery->select($orderGoodsColumn);
        }])->where([
            'user_id'      => $userId,
            'order_number' => $orderNumber
        ])->first($orderColumn);
        if ($orderData) {
            return $orderData->toArray();
        } else {
            $this->error('未查询到相关信息');
            return false;
        }
    }

    /**
     * 创建订单号
     * @return string
     */
    private function createOrderNumber()
    {
        $key = 'create_order_number';
        $index = Cache::increment($key, 1);
        if ($index >= 999) {
            Cache::put($key, 0, 1);  //防止订单号越来越长
        }
        $index = sprintf('%03d', $index);
        return date('YmdHiss', time()) . $index;
    }

    /**
     * 检验用户购买的数据+创建订单  （创建订单唯一入口）
     * @param $params
     * @return bool
     */
    public function checkAndCreateOrder($params)
    {
        //步骤一 获取结算数据(商品信息，商家信息，收货地址信息)
        $orderCommitList = $this->getOrderCommitList($params);
        //步骤二 校验结算数据
        if (!$this->checkAddress($orderCommitList)) {
            return false;
        }
        if (!$this->checkMerchant($orderCommitList)) {
            return false;
        }
        if (!$this->checkProduct($params, $orderCommitList)) {
            return false;
        }
        //步骤三 创建订单
        if (!$this->createOrder($params, $orderCommitList)) {
            return false;
        }
        return true;
    }

    /**
     * 校验收货地址
     * @param $orderCommitList
     * @return bool
     */
    private function checkAddress($orderCommitList)
    {
        if(empty($orderCommitList['address'])){
            $this->error('不存在该收货地址');
            return false;
        }
        return true;
    }

    /**
     * 检验商家
     * @param $orderCommitList
     * @return bool
     */
    private function checkMerchant($orderCommitList)
    {
        if (empty($orderCommitList['merchant'])) {
            $this->error('不存在该商家');
            return false;
        }
        if ($orderCommitList['merchant']['is_shelves'] != Merchant::IS_SHELVES_YES) {
            $this->error('该商家已下架');
            return false;
        }
        if ($orderCommitList['merchant']['business_status'] != Merchant::BUSINESS_STATUS_YES) {
            $this->error('该商家已打烊');
            return false;
        }
        return true;
    }

    /**
     * 检验商品 并更新订单结算数据(加入商品总价,商品购买数量)
     * @param $params
     * @param $orderCommitList
     * @return bool
     */
    private function checkProduct($params, &$orderCommitList)
    {
        if (empty($orderCommitList['cart'])) {
            $this->error('含有不存在的商品');
        }
        $products = $params['products'];
        $productsAmount = 0.0;
        foreach ($products as $product) {
            foreach ($orderCommitList['cart'] as $key => $orderProduct) {
                if ($product['product_id'] == $orderProduct['id']) {
                    if ($orderProduct['is_del'] != Good::IS_DEL_NO) {
                        $this->error('含有不存在的商品');
                        return false;
                    }
                    if ($orderProduct['shelves_status'] != Good::SHELVES_STATUS_YES) {
                        $this->error('含有已下架的商品');
                        return false;
                    }
                    if ($orderProduct['sale_status'] != Good::SALE_STATUS_YES) {
                        $this->error('含有已停售的商品');
                        return false;
                    }
                    if ($product['goods_num'] > $orderProduct['stocks']) {
                        $this->error('商品库存不足');
                        return false;
                    }
                    $orderCommitList['cart'][$key]['goods_num'] = $product['goods_num'];
                    $productsAmount += $product['goods_num'] * $orderProduct['price'];
                }
            }
        }
        if($productsAmount < $orderCommitList['merchant']['min_delivery']){
            $this->error('未达到最低配送费');
            return false;
        }
        $orderCommitList['products_amount'] = $productsAmount;
        return true;
    }

    /**
     * 创建订单
     * @param $params
     * @param $orderCommitList
     * @return bool
     */
    private function createOrder($params, $orderCommitList)
    {
        $userId       = $params['user_id'];
        $orderMessage = $params['order_message'];
        $merchantId   = $params['merchant_id'];
        $payType      = $params['pay_type'];
        $sendAmount   = $orderCommitList['merchant']['fee'];
        $totalAmount  = $orderCommitList['products_amount'] + $sendAmount;
        $orderNumber  = $this->createOrderNumber();
        $orderData = [
            'order_number'  => $orderNumber,
            'user_id'       => $userId,
            'merchant_id'   => $merchantId,
            'total_amount'  => $totalAmount,
            'order_amount'  => $totalAmount,
            'send_amount'   => $sendAmount,
            'pay_type'      => $payType,
            'order_message' => $orderMessage,
            'name'          => $orderCommitList['address']['name'],
            'sex'           => $orderCommitList['address']['sex'],
            'mobile'        => $orderCommitList['address']['mobile'],
            'tag'           => $orderCommitList['address']['tag'],
            'province_id'   => $orderCommitList['address']['province_id'],
            'city_id'       => $orderCommitList['address']['city_id'],
            'area_id'       => $orderCommitList['address']['area_id'],
            'province'      => $orderCommitList['address']['province'],
            'city'          => $orderCommitList['address']['city'],
            'area'          => $orderCommitList['address']['area'],
            'area_info'     => $orderCommitList['address']['area_info'],
            'house_number'  => $orderCommitList['address']['house_number'],
        ];
        DB::beginTransaction();
        //步骤一   插入到订单表
        $orderMdl = Order::create($orderData);
        if(!count($orderMdl)){
            DB::rollBack();
            $this->error('创建订单失败');
            return false;
        }
        $orderId = $orderMdl->id;
        //步骤二  插入到订单商品表
        foreach ($orderCommitList['cart'] as $orderProduct) {
            $orderGoodsData = [
             'order_id'     => $orderId,
             'order_number' => $orderNumber,
             'goods_num'    => $orderProduct['goods_num'],
             'product_id'   => $orderProduct['id'],
             'price'        => $orderProduct['price'],
             'goods_id'     => $orderProduct['goods']['id'],
             'goods_name'   => $orderProduct['goods']['name'],
             'goods_image'  => $orderProduct['goods']['goods_image'],
             'sku_detail'   => $orderProduct['goods']['sku_detail'],
            ];
            $orderGoodsMdl = OrderGood::create($orderGoodsData);
            if(!count($orderGoodsMdl)){
                DB::rollBack();
                $this->error('创建订单失败');
                return false;
            }
        }
        DB::commit();
        return true;
    }

    /**
     * 获取购物结算列表
     * @param $params
     * @return array
     */
    private function getOrderCommitList($params)
    {
        $merchantId = $params['merchant_id'];
        $userId     = $params['user_id'];
        $addressId  = $params['address_id'];
        $productIds = array_column($params['products'], 'product_id');
        //商品信息
        $goodsColumn = [
            'id',
            'name',
            'goods_image',
            'is_sku',
            'sku_detail',
            'description',
        ];
        $productsColumn = [
            'id',
            'goods_id',
            'merchant_id',
            'goods_category_id',
            'sku_name',
            'price',
            'stocks',
            'is_del',
            'shelves_status',
            'sale_status'
        ];
        $productList = Product::with(['goods' => function ($goodsQuery) use ($goodsColumn) {
            $goodsQuery->select($goodsColumn);
        }])
            ->where('merchant_id', $merchantId)
            ->whereIn('id', $productIds)
            ->get($productsColumn)
            ->toArray();
        //商家信息
        $merchantData = Merchant::where('id', $merchantId)
            ->first(['id', 'name', 'business_status', 'logo','average_time', 'is_shelves', 'fee', 'min_delivery']);
        //收货地址信息
        $addressData = app(AddressRepository::class)->getAddressDetail($userId, $addressId);

        $orderCommitList = [
            'cart'     => $productList,
            'merchant' => $merchantData ? $merchantData->toArray() : [],
            'address'  => $addressData ? $addressData : []
        ];
        return $orderCommitList;
    }

}