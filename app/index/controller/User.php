<?php
namespace app\index\controller;

use think\facade\View;
use think\facade\Request;
use think\facade\Session;
use app\admin\model\UserModel; // 复用后台用户模型
// 1. 引入验证码类
use think\captcha\facade\Captcha;

class User
{
    // 前台登录页面
    public function login()
    {
        return View::fetch();
    }

    // 2. 新增方法：生成验证码图片
    public function captcha()
    {
        // 直接调用验证码类的 create 方法输出验证码图片
        return Captcha::create();
    }

    // 处理前台登录（仅允许role=2的前台用户登录）
    public function doLogin()
    {
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);

        // 3. 先验证验证码
        $code = Request::post('code');
        if (!Captcha::check($code)) {
            // 验证码错误，返回提示
            return json(['code' => 0, 'msg' => '验证码错误']);
        }

        // 验证码通过后，再验证用户名和密码
        $username = Request::post('username');
        $password = Request::post('password');
        
        // 仅查询role=2的前台用户
        $user = UserModel::where(['username' => $username, 'role' => 2])->find();

        if (!$user || !password_verify($password, $user->password)) {
            return json(['code' => 0, 'msg' => '用户名或密码错误']);
        }
        if ($user->status != 1) {
            return json(['code' => 0, 'msg' => '账号已禁用']);
        }
        
        // 写入前台用户会话
        Session::set('front_user', $user->toArray());
        return json(['code' => 1, 'msg' => '登录成功', 'url' => '/']);
    }

    // 前台用户退出
    public function logout()
    {
        Session::delete('front_user');
        return redirect('/index/user/login');
    }
}