<?php
namespace app\middleware;

use think\facade\Session;
use think\facade\Redirect;

class CheckLogin
{
    public function handle($request, \Closure $next)
    {
        // 排除登录页和验证码接口
        $except = ['admin/login/index', 'admin/login/captcha', 'admin/login/logout'];
        if (!in_array($request->controller() . '/' . $request->action(), $except)) {
            if (!Session::has('admin_user')) {
                return Redirect::to('/admin/login')->remember();
            }
        }
        return $next($request);
    }
}