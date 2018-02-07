<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\GoodsCatRepository;
use Illuminate\Http\Request;
use Validator;

class GoodsCatController extends Controller
{

    //获取商家商品分类
    public function getGoodsCats(Request $request)
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
        $goodsCatRepository = new GoodsCatRepository();
        $rsData = $goodsCatRepository->getGoodsCats($merchantId);
        return $this->successResponse($rsData);
    }

}