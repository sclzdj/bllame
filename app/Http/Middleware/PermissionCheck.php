<?php

namespace App\Http\Middleware;

use App\Servers\MenuServer;
use App\Servers\PermissionServer;
use Closure;
use Grpc\Server;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth('admin')->id()>1 && auth('admin')->user()->status=='0'){
            auth('admin')->logout();
            return redirect('/admin/login')->with('danger','账号已被禁用');
        }
        if(!PermissionServer::isAccess()){
            return redirect(MenuServer::getHomeUrl())->with('danger','权限不足');
        }
        return $next($request);
    }
}
