<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //支付方式类型（1-支付宝 2-微信）
    const PAY_TYPE_ALI = 1;
    const PAY_TYPE_WX  = 2;
    public static $_PAY_TYPE = [
        self::PAY_TYPE_ALI => '支付宝',
        self::PAY_TYPE_WX  => '微信'
    ];

    //订单状态：1(默认):待支付 2:待配送 3:已配送 4:已送达(已完成) 5:用户已取消订单 6:商家取消订单 7:系统自动取消 8:后台取消
    const ORDER_STATUS_INIT             = 1;
    const ORDER_STATUS_PAYED            = 2;
    const ORDER_STATUS_DELIVERY         = 3;
    const ORDER_STATUS_RECEIVE          = 4;
    const ORDER_STATUS_USER_CANCEL      = 5;
    const ORDER_STATUS_MERCHANT_CANCEL  = 6;
    const ORDER_STATUS_SYSTEM_CANCEL    = 7;
    const ORDER_STATUS_ADMIN_CANCEL     = 8;
    public static $_ORDER_STATUS = [
        self::ORDER_STATUS_INIT            => '待支付',
        self::ORDER_STATUS_PAYED           => '待配送',
        self::ORDER_STATUS_DELIVERY        => '已配送',
        self::ORDER_STATUS_RECEIVE         => '已送达',
        self::ORDER_STATUS_USER_CANCEL     => '用户已取消订单',
        self::ORDER_STATUS_MERCHANT_CANCEL => '商家取消订单',
        self::ORDER_STATUS_SYSTEM_CANCEL   => '系统自动取消',
        self::ORDER_STATUS_ADMIN_CANCEL    => '后台取消'
    ];

    //付款状态：0(默认):未付款;1:已付款;
    const PAY_STATUS_NO  = 0;
    const PAY_STATUS_YES = 1;
    public static $_PAY_STATUS = [
        self::PAY_STATUS_NO  => '未付款',
        self::PAY_STATUS_YES => '已付款'
    ];

    //退款状态 0未退款 1退款中 2已退款
    const REFUND_STATUS_INIT = 0;
    const REFUND_STATUS_ING  = 1;
    const REFUND_STATUS_OK   = 2;
    public static $_REFUND_STATUS = [
        self::REFUND_STATUS_INIT => '未退款',
        self::REFUND_STATUS_ING  => '退款中',
        self::REFUND_STATUS_OK   => '已退款'
    ];

    //结算状态 0未结算 1已结算
    const SETTLEMENT_STATUS_NO   = 0;
    const SETTLEMENT_STATUS_YES  = 1;
    public static $_SETTLEMENT_STATUS = [
        self::SETTLEMENT_STATUS_NO   => '未结算',
        self::SETTLEMENT_STATUS_YES  => '已结算'
    ];

    //关联订单商品表
    public function orderGoods()
    {
        $this->hasMany(OrderGood::class, 'order_id', 'id');
    }

}
