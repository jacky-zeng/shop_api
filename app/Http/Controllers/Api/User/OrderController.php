<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{

    //获取用户订单列表
    public function getOrders(Request $request)
    {
        $params    = $request->all();
        $validator = Validator::make($params, [
            'order_status'         => 'nullable|in:1,2,3,4,5,6,7,8',
            'page'                 => 'nullable|integer',
            'page_size'            => 'nullable|integer'
        ],[
            'order_status.in'      => '订单状态格式错误',
            'page.integer'         => '页码格式有误',
            'page_size.integer'    => '每页条数格式有误'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $userId       = array_get($params, 'user_info.user_id');
        $orderStatus  = array_get($params, 'order_status');
        $page         = array_get($params, 'page', 1);
        $pageSize     = array_get($params, 'page_size', 10);
        $orderRepository = new OrderRepository();
        $orderRepository->initOrderQuery();
        $orderRepository->byUserId($userId);                     //根据用户id
        if($orderStatus) {
            $orderRepository->byOrderStatus($orderStatus);       //根据订单状态
        }
        $rsData = $orderRepository->getOrders($page, $pageSize);
        return $this->successResponse($rsData);
    }

    //获取用户订单详情
    public function getOrderDetail(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'order_number' => 'required'
        ], [
            'order_number.required' => '订单号不能为空'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $userId = array_get($params, 'user_info.user_id');
        $orderNumber = $params['order_number'];
        $orderRepository = new OrderRepository();
        $rsData = $orderRepository->getOrderDetail($userId, $orderNumber);
        if (!$rsData) {
            return $this->errorResponse($orderRepository->firstErrorMessage('获取订单详情失败'), Code::SYSTEM_ERROR);
        }
        return $this->successResponse($rsData);
    }

    //创建订单
    public function createOrder(Request $request)
    {
        //传入参数示例：
        //{
        //  "address_id":1,
        //  "merchant_id": 1,
        //  "pay_type":1,
        //  "products": [
        //    {
        //      "product_id": 1,
        //      "goods_num": 1
        //    },
        //    {
        //      "product_id": 2,
        //      "goods_num": 2
        //    },
        //    {
        //      "product_id": 3,
        //      "goods_num": 3
        //    }
        //  ]
        //}
        $params = $request->all();
        // 商品id,商品数量
        $validator = Validator::make($params, [
            'address_id'            => 'required|integer',
            'merchant_id'           => 'required|integer',
            'pay_type'              => 'required|int:1,2',
            'products'              => 'required|array',
            'products.*.product_id' => 'required|integer',
            'products.*.goods_num'  => 'required|integer',
        ], [
            'address_id.required'            => '收货地址id不能为空',
            'address_id.integer'             => '收货地址id格式错误',
            'merchant_id.required'           => '商家id不能为空',
            'merchant_id.integer'            => '商家id格式错误',
            'pay_type.required'              => '支付类型不能为空',
            'pay_type.int'                   => '支付类型格式错误',
            'products.required'              => '商品数据不能为空',
            'products.array'                 => '商品数据格式错误',
            'products.*.product_id.required' => '商品数据的商品规格id不能为空',
            'products.*.goods_num.required'  => '商品数据的商品数量不能为空',
            'products.*.product_id.integer'  => '商品数据的商品规格id格式错误',
            'products.*.goods_num.integer'   => '商品数据的商品数量格式错误',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $userId                  = array_get($params, 'user_info.user_id');
        $params['user_id']       = $userId;
        $params['order_message'] = array_get($params, 'order_message');  //订单留言
        $orderRepository = new OrderRepository();
        $rs = $orderRepository->checkAndCreateOrder($params);
        if(!$rs) {
            return $this->errorResponse($orderRepository->firstErrorMessage('创建订单失败'), Code::SYSTEM_ERROR);
        }
        return $this->successResponse();
    }

}