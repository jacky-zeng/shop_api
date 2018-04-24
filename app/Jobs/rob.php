<?php

namespace App\Jobs;

use App\Repositories\OrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class rob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;

    /**
     * rob constructor.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->attempts() >= 3) { // 返回失败次数
            $this->release(10); // 将任务放回到队列,10秒后次执行
        } else {
            $this->queueRobMysql($this->user_id);
        }
    }

    /**
     * 数据入库
     * @param $user_id
     * @return bool
     */
    public function queueRobMysql($user_id)
    {
        $params          = [
            'user_id'       => 1,
            'address_id'    => 1,
            'merchant_id'   => 1,
            'pay_type'      => 1,
            'order_message' => '实际下单用户是'.$user_id,
            'products'      => [
                'product_id' => 1,
                'goods_num'  => 1,
            ],
        ];
        $orderRepository = new OrderRepository();

        $rs = $orderRepository->checkAndCreateOrder($params);

        return $rs;
    }

}
