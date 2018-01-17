<?php

namespace App\Listeners\Auth;

use Carbon\Carbon;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Token;

class RevokeOldTokens
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 删除旧的token
     * @param AccessTokenCreated $event
     */
    public function handle(AccessTokenCreated $event)
    {
        //todo 性能提高： 加入队列或其他操作 延时去删除旧的token
        Token::where('id', '!=', $event->tokenId)
            ->where('user_id', $event->userId)
            ->where('client_id', $event->clientId)
            ->where('expires_at', '<', Carbon::now())
            ->orWhere('revoked', true)
            ->delete();
    }

}
