<?php
namespace app\admin\controller;

use think\facade\View;
use think\facade\Request;
use think\facade\Redirect;
use app\admin\model\ArticleModel; // 已引入新模型类
use app\admin\model\CategoryModel; // 已引入新模型类
use think\facade\Session;

class Article
{
    // 文章列表
    public function index()
    {
        $where = [];
        $cid = Request::get('cid', 0);
        if ($cid) {
            $where[] = ['cid', '=', $cid];
        }
        $title = Request::get('title', '');
        if ($title) {
            $where[] = ['title', 'like', "%{$title}%"];
        }

        // 关键修改1：Article → ArticleModel（调用新模型类）
        $list = ArticleModel::with('category') // 需确保 ArticleModel 中定义了 category 关联方法
            ->where($where)
            ->order('create_time', 'desc')
            ->paginate([
                'list_rows' => 10,
                'query'     => Request::get()
            ]);

        // 关键修改2：Category → CategoryModel（调用新模型类）
        $categoryList = CategoryModel::where('status', 1)->select();
        
        View::assign([
            'list' => $list,
            'categoryList' => $categoryList,
            'cid' => $cid,
            'title' => $title,
        ]);
        return View::fetch();
    }

    // 添加文章
    public function add()
    {
        if (Request::isPost()) {
            $data = Request::post();
            $data['create_uid'] = Session::get('admin_user.id');
            // 关键修改3：Article → ArticleModel（调用新模型类的 create 方法）
            $result = ArticleModel::create($data);
            if ($result) {
                return json(['code' => 1, 'msg' => '添加成功', 'url' => '/admin/article']);
            } else {
                return json(['code' => 0, 'msg' => '添加失败']);
            }
        }

        // 关键修改4：Category → CategoryModel（调用新模型类）
        $categoryList = CategoryModel::where('status', 1)->select();
        View::assign('categoryList', $categoryList);
        return View::fetch();
    }

    // 编辑文章
    public function edit($id)
    {
        // 关键修改5：Article → ArticleModel（调用新模型类的 find 方法）
        $article = ArticleModel::find($id);
        if (!$article) {
            return Redirect::to('/admin/article')->with('error', '文章不存在');
        }

        if (Request::isPost()) {
            $data = Request::post();
            $result = $article->save($data); // 模型实例调用 save 方法，不受类名修改影响
            if ($result) {
                return json(['code' => 1, 'msg' => '编辑成功', 'url' => '/admin/article']);
            } else {
                return json(['code' => 0, 'msg' => '编辑失败']);
            }
        }

        // 关键修改6：Category → CategoryModel（调用新模型类）
        $categoryList = CategoryModel::where('status', 1)->select();
        View::assign([
            'article' => $article,
            'categoryList' => $categoryList,
        ]);
        return View::fetch();
    }

    // 删除文章
    public function delete($id)
    {
        // 关键修改7：Article → ArticleModel（调用新模型类的 destroy 方法）
        $result = ArticleModel::destroy($id);
        if ($result) {
            return json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }
}