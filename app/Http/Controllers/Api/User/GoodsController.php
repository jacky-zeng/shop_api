<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Jobs\rob;
use App\Repositories\GoodsRepository;
use Illuminate\Http\Request;
use Redis;
use Validator;

class GoodsController extends Controller
{

    //获取商家所有商品 （暂时认为是外卖商品 不分页）
    public function getGoods(Request $request)
    {
        $params    = $request->all();
        $validator = Validator::make($params, [
            'merchant_id'          => 'required|integer'
        ],[
            'merchant_id.required' => '商家id不能为空',
            'merchant_id.integer'  => '商家id格式有误'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $merchantId = $params['merchant_id'];
        $goodsRepository = new GoodsRepository();
        $rsData = $goodsRepository->getGoods($merchantId);
        return $this->successResponse($rsData);
    }

    //设置抢购库存
    public function setRushBuyStocks(Request $request)
    {
        $params    = $request->all();
        $validator = Validator::make($params, [
            'stocks'   => 'required|integer',
        ], [
            'stocks.required'   => '抢购库存不能为空',
            'stocks.integer'    => '抢购库存格式有误',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $goodsRepository = new GoodsRepository();

        $rs = $goodsRepository->setRushBuyStocks($params);
        if (! $rs) {
            return $this->errorResponse('设置失败', Code::SYSTEM_ERROR);
        }

        return $this->successResponse();
    }

    //开始抢购
    public function createRob()
    {
        $goodsRepository = new GoodsRepository();

        $rs   = $goodsRepository->createRob();
        $list = [
            'users'   => Redis::lrange('users', 0, -1),
            'list'    => Redis::lrange('list', 0, -1),
            'is_high' => Redis::get('is_high'),
        ];
        if (! $rs) {
            return $this->errorResponse($goodsRepository->firstErrorMessage('抢购失败'), Code::SYSTEM_ERROR, $list);
        }
        $this->dispatch((new rob($rs))->delay(20)); //delay表示延迟队列执行 20秒
        return $this->successResponse($list);
    }

    //开始抢购(不支持高并发)
    public function createBadRob()
    {
        $goodsRepository = new GoodsRepository();

        $rs   = $goodsRepository->createBadRob();
        $list = [
            'users'   => Redis::lrange('users', 0, -1),
            'list'    => Redis::lrange('list', 0, -1),
            'is_high' => Redis::get('is_high'),
        ];
        if (! $rs) {
            return $this->errorResponse($goodsRepository->firstErrorMessage('抢购失败'), Code::SYSTEM_ERROR, $list);
        }

        return $this->successResponse($list);
    }

}