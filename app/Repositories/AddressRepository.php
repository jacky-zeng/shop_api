<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Address;
use App\Models\Area;

class AddressRepository
{
    use Errors;

    /**
     * 获取省市区名称
     * @param $params
     * @return bool
     */
    public function getProvinceCityArea($params)
    {
        $provinceId = $params['province_id'];
        $cityId     = $params['city_id'];
        $areId      = $params['area_id'];
        $areas = Area::select('id', 'name', 'depth')
            ->whereIn('id', [$provinceId, $cityId, $areId])
            ->get()
            ->toArray();
        foreach ($areas as $area) {
            $has = false;
            if ($provinceId == $area['id'] && $area['depth'] == Area::DEPTH_FIRST) {
                $has = true;
                $params['province'] = $area['name'];
            }
            if ($cityId == $area['id'] && $area['depth'] == Area::DEPTH_SECOND) {
                $has = true;
                $params['city'] = $area['name'];
            }
            if ($areId == $area['id'] && $area['depth'] == Area::DEPTH_THIRD) {
                $has = true;
                $params['area'] = $area['name'];
            }
            if (!$has) {
                return false;
            }
        }
        return $params;
    }

    /**
     * 获取用户收货地址列表
     * @param $userId
     * @return mixed
     */
    public function getAddresses($userId)
    {
        $addressData = Address::where('user_id', $userId)
            ->get()
            ->toArray();
        return $addressData;
    }

    /**
     * 获取用户收货地址详情
     * @param $userId
     * @param $addressId
     * @return bool
     */
    public function getAddressDetail($userId, $addressId)
    {
        $addressData = Address::where([
            'user_id' => $userId,
            'id'      => $addressId
        ])->first();
        if ($addressData) {
            return $addressData->toArray();
        } else {
            $this->error('未查询到相关信息');
            return false;
        }
    }

    /**
     * 新增用户收货地址
     * @param $params
     * @return bool
     */
    public function addAddress($params)
    {
        $userId = array_get($params, 'user_id');
        $checkAddressCount = Address::where('user_id', $userId)->count();
        if($checkAddressCount >= 20) {
            $this->error('收货地址不能超过20个');
            return false;
        }
        $addressData = array(
            'user_id'      => $userId,
            'name'         => $params['name'],
            'sex'          => $params['sex'],
            'mobile'       => $params['mobile'],
            'tag'          => $params['tag'],
            'province_id'  => $params['province_id'],
            'province'     => $params['province'],
            'city_id'      => $params['city_id'],
            'city'         => $params['city'],
            'area_id'      => $params['area_id'],
            'area'         => $params['area'],
            'area_info'    => $params['area_info'],
            'house_number' => $params['house_number']
        );
        $addressMdl = Address::create($addressData);
        if(!count($addressMdl)) {
            return false;
        }
        return true;
    }

    /**
     * 编辑收货地址
     * @param $params
     * @return bool
     */
    public function editAddress($params)
    {
        $userId = array_get($params, 'user_id');
        $addressId = array_get($params, 'address_id');
        $addressData = Address::where(['user_id' => $userId, 'id' => $addressId])
            ->first();
        if(!$addressData) {
            $this->error('不存在该收货地址');
            return false;
        }
        $addressData = array(
            'user_id'      => $userId,
            'name'         => $params['name'],
            'sex'          => $params['sex'],
            'mobile'       => $params['mobile'],
            'tag'          => $params['tag'],
            'province_id'  => $params['province_id'],
            'province'     => $params['province'],
            'city_id'      => $params['city_id'],
            'city'         => $params['city'],
            'area_id'      => $params['area_id'],
            'area'         => $params['area'],
            'area_info'    => $params['area_info'],
            'house_number' => $params['house_number']
        );
        $rsUpdate = Address::where(['user_id' => $userId, 'id' => $addressId])->update($addressData);
        if(!$rsUpdate) {
            return false;
        }
        return true;
    }

    /**
     * 删除用户收货地址
     * @param $userId
     * @param $addressId
     */
    public function delAddress($userId, $addressId)
    {
        Address::where(['user_id' => $userId, 'id' => $addressId])->delete();
    }

}