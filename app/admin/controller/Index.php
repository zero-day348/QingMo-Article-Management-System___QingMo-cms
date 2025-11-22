<?php
namespace app\admin\controller;

use think\facade\View;
use think\facade\Session;
// 关键修改1：替换所有旧模型类名引用为新的 XXXModel
use app\admin\model\ArticleModel;
use app\admin\model\CategoryModel;
use app\admin\model\UserModel;

class Index
{
    // 后台首页
    public function index()
    {
        $user = Session::get('admin_user');

        // 统计数据
        $data = [
            // 关键修改2：同步替换模型类名调用
            'article_count' => ArticleModel::count(),
            'category_count' => CategoryModel::count(),
            'user_count' => UserModel::count(),
            'user_info' => $user,
        ];
        View::assign($data);
        return View::fetch();
    }

    // 欢迎页
    public function welcome()
    {
        return View::fetch();
    }
}