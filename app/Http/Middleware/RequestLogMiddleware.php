<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;

class RequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$requestLog = new RequestLog();

		$requestLog->url = request()->url();
		$requestLog->request_body = $request->all();
		$requestLog->created_at = now();

        $response = $next($request);

		$requestLog->response_body = $response->content();
		$requestLog->updated_at = now();
		$requestLog->save();

		return $response;
    }
}
