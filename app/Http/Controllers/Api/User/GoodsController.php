<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\GoodsRepository;
use Illuminate\Http\Request;
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

}