<?php
namespace app\admin\controller;

use think\facade\View;
use think\facade\Session;
use think\facade\Request;
use app\admin\model\UserModel; // 已正确引入新模型类

class User
{
    public function index()
    {
        // 新增代码：获取当前登录用户信息并传递给模板
        $user_info = Session::get('admin_user');
        if ($user_info) {
            View::assign('user_info', $user_info);
        }

        // 关键修改1：User → UserModel（调用新模型类的静态方法）
        $list = UserModel::order('create_time', 'desc')->paginate(10);
        View::assign('list', $list);
        return View::fetch();
    }

    // 添加用户
    public function add()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            // 关键修改2：User → UserModel（调用新模型类的 create 方法）
            $result = UserModel::create($data);
            if ($result) {
                return json(['code' => 1, 'msg' => '添加成功', 'url' => '/admin/user']);
            } else {
                return json(['code' => 0, 'msg' => '添加失败']);
            }
        }
        return View::fetch();
    }

    // 编辑用户
    public function edit($id)
    {
        // 关键修改3：User → UserModel（调用新模型类的 find 方法）
        $user = UserModel::find($id);
        if (!$user) {
            return json(['code' => 0, 'msg' => '用户不存在']);
        }

        if (Request::isPost()) {
            $data = Request::post();
            // 密码为空则不更新
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $result = $user->save($data); // 模型实例调用 save 方法，不受类名修改影响
            if ($result) {
                return json(['code' => 1, 'msg' => '编辑成功', 'url' => '/admin/user']);
            } else {
                return json(['code' => 0, 'msg' => '编辑失败']);
            }
        }

        View::assign('user', $user);
        return View::fetch();
    }

    // 删除用户
    public function delete($id)
    {
        if ($id == 1) {
            return json(['code' => 0, 'msg' => '超级管理员不能删除']);
        }
        // 关键修改4：User → UserModel（调用新模型类的 destroy 方法）
        $result = UserModel::destroy($id);
        if ($result) {
            return json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }

    // 修改个人资料（当前登录用户）
    public function profile()
    {
        // 从Session获取当前登录用户ID（无需手动传id，避免参数错误）
        $userId = Session::get('admin_user.id');
        $user = UserModel::find($userId);
        
        if (!$user) {
            return json(['code' => 0, 'msg' => '用户不存在']);
        }

        if (Request::isPost()) {
            $data = Request::post();
            // 密码为空则不更新
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $result = $user->save($data);
            if ($result) {
                // 更新Session中的用户信息（避免修改后Session数据不一致）
                Session::set('admin_user', $user->toArray());
                return json(['code' => 1, 'msg' => '资料修改成功', 'url' => '/admin/user/profile']);
            } else {
                return json(['code' => 0, 'msg' => '资料修改失败']);
            }
        }

        View::assign('user', $user);
        return View::fetch('profile'); // 对应模板文件：profile.html
    }
}