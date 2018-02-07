<?php namespace app\Http\Controllers\Api\User;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use App\Repositories\AddressRepository;
use Illuminate\Http\Request;
use Validator;

class AddressController extends Controller
{

    //获取用户收货地址列表
    public function getAddresses(Request $request)
    {
        $params = $request->all();
        $userId = array_get($params, 'user_info.user_id');
        $addressRepository = new AddressRepository();
        $rsData = $addressRepository->getAddresses($userId);
        return $this->successResponse($rsData);
    }

    //获取用户收货地址详情
    public function getAddressDetail(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'address_id'          => 'required|integer'
        ],[
            'address_id.required' => '地址id不能为空',
            'address_id.integer'  => '地址id格式有误'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $userId     = array_get($params, 'user_info.user_id');
        $addressId  = $params['address_id'];
        $addressRepository = new AddressRepository();
        $rs = $addressRepository->getAddressDetail($userId, $addressId);
        if (!$rs) {
            return $this->errorResponse($addressRepository->firstErrorMessage('获取用户收货地址详情失败'), Code::SYSTEM_ERROR);
        }
        return $this->successResponse($rs);
    }

    //新增用户收货地址
    public function addAddress(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'name'        => 'required',
            'sex'         => 'nullable|in:0,1,2',
            'mobile'      => 'required|regex:/^1[34578]\d{9}$/',
            'tag'         => 'nullable|in:0,1,2,3',
            'province_id' => 'required|integer',
            'city_id'     => 'required|integer',
            'area_id'     => 'required|integer',
            'area_info'   => 'required',
        ], [
            'name.required'        => '姓名不能为空',
            'sex.in'               => '性别格式有误',
            'mobile.required'      => '手机号不能为空',
            'mobile.regex'         => '手机号格式有误',
            'tag.in'               => '标签格式有误',
            'province_id.required' => '省id不能为空',
            'province_id.integer'  => '省id格式有误',
            'city_id.required'     => '市id不能为空',
            'city_id.integer'      => '市id格式有误',
            'area_id.required'     => '区id不能为空',
            'area_id.integer'      => '区id格式有误',
            'area_info.required'   => '详细地址不能为空',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $params['user_id']      = array_get($params, 'user_info.user_id');
        $params['sex']          = array_get($params, 'sex', 0);
        $params['tag']          = array_get($params, 'tag', 0);
        $params['house_number'] = array_get($params, 'house_number', '');

        $addressRepository = new AddressRepository();
        // 获取省市区名称
        $params = $addressRepository->getProvinceCityArea($params);
        if (!$params) {
            return $this->errorResponse('省市区id有误', Code::PARAMETER_ERROR);
        }
        $rs = $addressRepository->addAddress($params);
        if (!$rs) {
            return $this->errorResponse($addressRepository->firstErrorMessage('新增用户收货地址失败'), Code::SYSTEM_ERROR);
        }
        return $this->successResponse();
    }

    //编辑用户收货地址
    public function editAddress(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'address_id'  => 'required|integer',
            'name'        => 'required',
            'sex'         => 'nullable|in:0,1,2',
            'mobile'      => 'required|regex:/^1[34578]\d{9}$/',
            'tag'         => 'nullable|in:0,1,2,3',
            'province_id' => 'required|integer',
            'city_id'     => 'required|integer',
            'area_id'     => 'required|integer',
            'area_info'   => 'required',
        ], [
            'address_id.required'  => '地址id不能为空',
            'address_id.integer'   => '地址id格式有误',
            'name.required'        => '姓名不能为空',
            'sex.in'               => '性别格式有误',
            'mobile.required'      => '手机号不能为空',
            'mobile.regex'         => '手机号格式有误',
            'tag.in'               => '标签格式有误',
            'province_id.required' => '省id不能为空',
            'province_id.integer'  => '省id格式有误',
            'city_id.required'     => '市id不能为空',
            'city_id.integer'      => '市id格式有误',
            'area_id.required'     => '区id不能为空',
            'area_id.integer'      => '区id格式有误',
            'area_info.required'   => '详细地址不能为空',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $params['user_id']      = array_get($params, 'user_info.user_id');
        $params['sex']          = array_get($params, 'sex', 0);
        $params['tag']          = array_get($params, 'tag', 0);
        $params['house_number'] = array_get($params, 'house_number', '');

        $addressRepository = new AddressRepository();
        // 获取省市区名称
        $params = $addressRepository->getProvinceCityArea($params);
        if (!$params) {
            return $this->errorResponse('省市区id有误', Code::PARAMETER_ERROR);
        }
        $rs = $addressRepository->editAddress($params);
        if (!$rs) {
            return $this->errorResponse($addressRepository->firstErrorMessage('编辑用户收货地址失败'), Code::SYSTEM_ERROR);
        }
        return $this->successResponse();
    }

    //删除用户收货地址
    public function delAddress(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'address_id'  => 'required|integer'
        ], [
            'address_id.required'  => '地址id不能为空',
            'address_id.integer'   => '地址id格式有误'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), Code::PARAMETER_ERROR);
        }
        $userId    = array_get($params, 'user_info.user_id');
        $addressId = $params['address_id'];
        $addressRepository = new AddressRepository();
        $addressRepository->delAddress($userId, $addressId);
        return $this->successResponse();
    }

}