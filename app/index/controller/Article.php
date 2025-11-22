<?php
namespace app\index\controller;

use think\facade\View;
use think\facade\Request;
use think\facade\Session;
use app\admin\model\ArticleModel;
use app\admin\model\CategoryModel;
use app\admin\model\UserModel; // 复用后台用户模型

class Article
{
    // 文章发布页面（需前台用户登录）
    public function publish()
    {
        $frontUser = Session::get('front_user');
        if (!$frontUser) {
            return redirect('/index/user/login');
        }
        
        $categories = CategoryModel::where('status', 1)->select();
        View::assign([
            'categories' => $categories,
            'user' => $frontUser
        ]);
        return View::fetch();
    }

    // 处理文章发布（关联当前登录用户）
    public function doPublish()
    {
        $frontUser = Session::get('front_user');
        if (!$frontUser) {
            return json(['code' => 0, 'msg' => '请先登录']);
        }
        
        $data = Request::post([
            'title', 'cid', 'summary', 'content'
        ]);
        $data['create_uid'] = $frontUser['id']; // 关联cms_user的id
        $data['status'] = 1; // 前台发布默认启用
        $data['create_time'] = date('Y-m-d H:i:s');
        
        $article = new ArticleModel();
        $article->save($data);
        return json(['code' => 1, 'msg' => '发布成功', 'url' => '/']);
    }

    // 我的文章列表（查看自己发布的文章）
    public function myList()
    {
        $frontUser = Session::get('front_user');
        if (!$frontUser) {
            return redirect('/index/user/login');
        }
        
        $articles = ArticleModel::where('create_uid', $frontUser['id'])
            ->order('create_time', 'desc')
            ->paginate();
        View::assign('articles', $articles);
        return View::fetch();
    }
}