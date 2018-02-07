<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\MerchantRepository;
use Illuminate\Http\Request;
use Validator;

class MerchantController extends Controller
{

    //获取商家列表
    public function getMerchants(Request $request)
    {
        $params    = $request->all();
        $validator = Validator::make($params, [
            'category_id'          => 'required',
            'sort'                 => 'nullable|in:1,2,3',
            'page'                 => 'nullable|integer',
            'page_size'            => 'nullable|integer'
        ],[
            'category_id.required'     => '商家所属分类不能为空',
            'sort.in'                  => '排序方式格式有误',
            'page.integer'             => '页码格式有误',
            'page_size.integer'        => '每页条数格式有误'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $merchantRepository = new MerchantRepository();
        $merchantRepository->initMerchantQuery();
        $categoryId   = $params['category_id'];
        $sort         = array_get($params, 'sort');
        $merchantName = array_get($params, 'merchant_name');
        $page         = array_get($params, 'page', 1);
        $pageSize     = array_get($params, 'page_size', 10);

        $merchantRepository->byCategoryId($categoryId);          //根据商家id
        if($sort) {
            $merchantRepository->bySort($sort);                  //排序规则
        }
        if($merchantName) {
            $merchantRepository->byMerchantName($merchantName);  //根据商家名称
        }
        $rsData = $merchantRepository->getMerchantData($page, $pageSize);
        return $this->successResponse($rsData);
    }

}