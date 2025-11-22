<?php
namespace app\admin\controller;

use think\facade\Session;
use think\facade\View;
use think\facade\Redirect;
use think\facade\Request;
// 关键修改1：替换旧模型引用为 UserModel
use app\admin\model\UserModel;
use think\captcha\facade\Captcha;

class Login
{
    // 登录页面
    public function index()
    {
        if (Session::has('admin_user')) {
            return Redirect::to('/admin/index');
        }
        return View::fetch();
    }

    // 登录验证
    public function check()
    {
        $username = Request::post('username');
        $password = Request::post('password');
        $code     = Request::post('code');

        // 验证验证码
        if (!Captcha::check($code)) {
            return json(['code' => 0, 'msg' => '验证码错误']);
        }

        // 验证用户：关键修改2：User → UserModel（查询用户数据）
        $user = UserModel::where('username', $username)->find();
        if (!$user || !password_verify($password, $user->password)) {
            return json(['code' => 0, 'msg' => '用户名或密码错误']);
        }

        if ($user->status != 1) {
            return json(['code' => 0, 'msg' => '账号已被禁用']);
        }

        // 保存登录状态
        Session::set('admin_user', $user->toArray());

        return json(['code' => 1, 'msg' => '登录成功', 'url' => '/admin/index']);
    }

    // 退出登录
    public function logout()
    {
        Session::delete('admin_user');
        // 替换 Redirect::to() 为 redirect() 助手函数
        return redirect('/admin/login');
    }

    // 验证码
    public function captcha()
    {
        return Captcha::create();
    }
}