<?php namespace App\Http\Middleware;

use App\Classes\Code;
use Closure;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;


class ApiToken extends CheckClientCredentials
{
    public $server;

    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    /**
     * 检验token是否正确  过期的token将会在EventServiceProvider事件中被删除
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param array ...$scopes
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next, ...$scopes)
    {
        $psr = (new DiactorosFactory)->createRequest($request);
        try {
            $psr = $this->server->validateAuthenticatedRequest($psr);
        } catch (OAuthServerException $e) {
            return response()->json([
                'code' => Code::UNAUTHORIZED_ERROR,
                'message' => $e->getMessage()
            ]);
        }
        $this->validateScopes($psr, $scopes);
        $user_id = $psr->getAttribute('oauth_user_id');
        $params = $request->all();
        $params['user_info'] = [
            'user_id' => $user_id
        ];
        $request->replace($params);
        return $next($request);
    }

}
