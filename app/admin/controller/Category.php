<?php
namespace app\admin\controller;

use think\facade\View;
use think\facade\Request;
use app\admin\model\CategoryModel; // 已正确引入新分类模型

class Category
{
    // 分类列表
    public function index()
    {
        // 关键修改1：Category → CategoryModel（查询分类列表）
        $list = CategoryModel::order('sort', 'desc')->select();
        View::assign('list', $list);
        return View::fetch();
    }

    // 添加分类
    public function add()
    {
        if (Request::isPost()) {
            $data = Request::post();
            // 关键修改2：Category → CategoryModel（创建分类）
            $result = CategoryModel::create($data);
            if ($result) {
                return json(['code' => 1, 'msg' => '添加成功', 'url' => '/admin/category']);
            } else {
                return json(['code' => 0, 'msg' => '添加失败']);
            }
        }

        // 新增代码：查询所有分类，用于渲染父分类下拉框
        $list = CategoryModel::order('sort', 'desc')->select();
        View::assign('list', $list); // 将分类列表传递给模板

        return View::fetch();
    }

    // 编辑分类
    public function edit($id)
    {
        // 关键修改3：Category → CategoryModel（查询单个分类）
        $category = CategoryModel::find($id);
        if (!$category) {
            return json(['code' => 0, 'msg' => '分类不存在']);
        }

        if (Request::isPost()) {
            $data = Request::post();
            $result = $category->save($data); // 模型实例方法无需修改
            if ($result) {
                return json(['code' => 1, 'msg' => '编辑成功', 'url' => '/admin/category']);
            } else {
                return json(['code' => 0, 'msg' => '编辑失败']);
            }
        }

        // 新增代码：查询所有分类，用于渲染父分类下拉框
        $list = CategoryModel::order('sort', 'desc')->select();
        View::assign('list', $list); // 传递分类列表给模板

        View::assign('category', $category);
        return View::fetch();
    }

    // 删除分类
    public function delete($id)
    {

        // 关键修改：直接获取GET/POST参数id，不依赖路径参数
        $id = Request::param('id');
        if (empty($id)) {
            return json(['code' => 0, 'msg' => '参数错误']);
        }

        // 关键修改4：Category → CategoryModel（检查子分类）
        $hasChild = CategoryModel::where('pid', $id)->count();
        if ($hasChild) {
            return json(['code' => 0, 'msg' => '该分类下有子分类，无法删除']);
        }

        // 关键修改5：Article → ArticleModel（检查关联文章，同步之前的模型改名）
        $hasArticle = \app\admin\model\ArticleModel::where('cid', $id)->count();
        if ($hasArticle) {
            return json(['code' => 0, 'msg' => '该分类下有文章，无法删除']);
        }

        // 关键修改6：Category → CategoryModel（删除分类）
        $result = CategoryModel::destroy($id);
        if ($result) {
            return json(['code' => 1, 'msg' => '删除成功']);
        } else {
            return json(['code' => 0, 'msg' => '删除失败']);
        }
    }
}