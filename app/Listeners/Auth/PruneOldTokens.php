<?php

namespace App\Listeners\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Events\RefreshTokenCreated;

class PruneOldTokens
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 删除废除的refresh_tokens
     * @param RefreshTokenCreated $event
     */
    public function handle(RefreshTokenCreated $event)
    {
        //todo 性能提高： 加入队列或其他操作 延时去删除废除的refresh_tokens
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', '!=', $event->accessTokenId)
            ->where('expires_at', '<', Carbon::now())
            ->orWhere('revoked', true)
            ->delete();
    }
}
