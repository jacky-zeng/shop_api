<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use DB;

class QueryLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment() !== 'production') {
            DB::enableQueryLog();
        }
        return $next($request);
    }

    public function terminate()
    {
        if (app()->environment() !== 'production') {
            $queries = DB::getQueryLog();
            if (!empty($queries)) {
                foreach ($queries as $query) {
                    $queryStr = $query['query'];
                    $bindings = $query['bindings'];
                    if (!empty($bindings)) {
                        foreach ($bindings as $binding) {
                            if (is_object($binding)) {
                                try {
                                    $binding = $binding->format('Y-m-d H:i:s');
                                } catch (\Exception $ex) {
                                    $binding = '?';
                                }
                            }
                            $queryStr = str_replace_first('?', "'" . $binding . "'", $queryStr);
                        }
                    }
                    Log::info($queryStr);
                }
            }
        }
    }
}
