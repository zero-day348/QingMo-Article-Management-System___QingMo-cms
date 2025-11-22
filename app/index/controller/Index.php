<?php
namespace app\index\controller;

use think\facade\View;
use think\facade\Request;
use app\admin\model\ArticleModel;
use app\admin\model\CategoryModel;

class Index
{
    // 1. 前台首页（原有逻辑不变）
    public function index()
    {
        $categories = CategoryModel::where('status', 1)->order('sort', 'desc')->select();
        $newArticles = ArticleModel::where('status', 1)->order('create_time', 'desc')->limit(10)->select();
        $hotArticles = ArticleModel::where('status', 1)->order('create_time', 'desc')->limit(8)->select();
        
        View::assign([
            'categories' => $categories,
            'newArticles' => $newArticles,
            'hotArticles' => $hotArticles,
            'site_title' => '轻墨站点 - 首页',
        ]);
        return View::fetch();
    }

    // 2. 所有文章列表（原 Article 控制器的逻辑迁移过来）
    public function article()
    {
        $articles = ArticleModel::where('status', 1)
            ->order('create_time', 'desc')
            ->paginate([
                'list_rows' => 10,
                'query' => Request::get()
            ]);

        $categories = CategoryModel::where('status', 1)->order('sort', 'desc')->select();

        View::assign([
            'categories' => $categories,
            'articles' => $articles,
            'site_title' => '所有文章 - 列表页',
        ]);
        // 模板还是用之前的 list.html
        return View::fetch();
    }

    // 3. 分类页（原有逻辑不变，参数接收id）
    public function category()
    {
        $id = Request::get('id'); // 直接获取GET参数id
        $category = CategoryModel::where(['id' => $id, 'status' => 1])->find();
        if (!$category) {
            abort(404, '分类不存在或已禁用');
        }

        $articles = ArticleModel::where(['cid' => $id, 'status' => 1])
            ->order('create_time', 'desc')
            ->paginate([
                'list_rows' => 10,
                'query' => Request::get()
            ]);

        $categories = CategoryModel::where('status', 1)->order('sort', 'desc')->select();

        View::assign([
            'categories' => $categories,
            'category' => $category,
            'articles' => $articles,
            'site_title' => $category->name . ' - 分类页',
        ]);
        return View::fetch();
    }

    // 4. 文章详情页（原有逻辑不变，参数接收id）
    public function detail()
    {
        $id = Request::get('id'); // 直接获取GET参数id
        $article = ArticleModel::where(['id' => $id, 'status' => 1])->find();
        if (!$article) {
            abort(404, '文章不存在或已下架');
        }

        $category = CategoryModel::find($article->cid);
        $categories = CategoryModel::where('status', 1)->order('sort', 'desc')->select();
        // 修正后的上一篇查询：先查状态，再查ID小于当前ID，按ID降序
        $prevArticle = ArticleModel::where('status', 1)
            ->where('id', '<', $id)  // 单独写范围条件，避免解析错误
            ->order('id', 'desc')
            ->find();

        // 修正后的下一篇查询：先查状态，再查ID大于当前ID，按ID升序
        $nextArticle = ArticleModel::where('status', 1)
            ->where('id', '>', $id)
            ->order('id', 'asc')
            ->find();

        View::assign([
            'categories' => $categories,
            'article' => $article,
            'category' => $category,
            'prevArticle' => $prevArticle,
            'nextArticle' => $nextArticle,
            'site_title' => $article->title . ' - 详情页',
        ]);
        return View::fetch();
    }

    // 新增：文章搜索功能（修复 summary 字段不存在 + whereOr 语法）
public function search()
{
    // 1. 获取搜索关键词（GET参数）
    $keyword = trim(Request::get('keyword', ''));
    if (empty($keyword)) {
        // 关键词为空时跳转到所有文章列表
        return redirect('/index/index/article');
    }

    // 2. 查询搜索结果（预加载分类关联）
    $articles = ArticleModel::with('category') // 新增预加载关联
        ->where('status', 1)
        ->where(function($query) use ($keyword) {
            $query->where('title', 'like', "%{$keyword}%")
                ->whereOr('content', 'like', "%{$keyword}%");
        })
        ->order('create_time', 'desc')
        ->paginate([
            'list_rows' => 10,
            'query' => Request::get()
        ]);

    // 3. 获取分类列表（保持导航栏分类正常显示）
    $categories = CategoryModel::where('status', 1)->order('sort', 'desc')->select();

    // 4. 传递变量到模板
    View::assign([
        'categories' => $categories,
        'articles' => $articles,
        'keyword' => $keyword, // 回显搜索关键词
        'total' => $articles->total(), // 结果总数
        'site_title' => "搜索结果：{$keyword} - 轻墨CMS站点"
    ]);

    // 5. 渲染搜索结果模板
    return View::fetch('search');
}
}