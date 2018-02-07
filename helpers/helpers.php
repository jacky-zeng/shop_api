<?php

/**
 * 格式化分页数据
 * @param int $trade_table
 * @return string
 */
if (!function_exists('format_page')) {
    function format_page($data)
    {
        $resData = array();
        $resData['page'] = array_get($data,'current_page');
        $resData['page_size'] = array_get($data,'per_page');
        $resData['total'] = array_get($data,'total');
        $resData['total_page'] = array_get($data,'last_page');
        $resData['list'] = array_get($data,'data');
        return $resData;
    }
}