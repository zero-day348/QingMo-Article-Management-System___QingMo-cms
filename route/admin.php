<?php
use think\facade\Route;

Route::get('test-frame', function () {
    return 'ThinkPHP框架路由正常';
});

// 1. 登录相关路由（不需要中间件，直接访问）
Route::group('admin', function () {
    Route::get('login', 'admin/Login/index');       // 登录页
    Route::post('login/check', 'admin/Login/check');// 登录验证
    Route::get('login/captcha', 'admin/Login/captcha');// 验证码
    Route::get('login/logout', 'admin/Login/logout');// 退出
});

// 后台路由分组
Route::group('admin', function () {
    // 首页
    Route::get('index', 'admin/Index/index');
    Route::get('index/welcome', 'admin/Index/welcome');

    // 文章管理
    Route::get('article', 'admin/Article/index');
    Route::get('article/add', 'admin/Article/add');
    Route::post('article/add', 'admin/Article/add');
    Route::get('article/edit/:id', 'admin/Article/edit');
    Route::post('article/edit/:id', 'admin/Article/edit');
    Route::get('article/delete/:id', 'admin/Article/delete');

    // 分类管理
    Route::get('category', 'admin/Category/index');
    Route::get('category/add', 'admin/Category/add');
    Route::post('category/add', 'admin/Category/add');
    Route::get('category/edit/:id', 'admin/Category/edit');
    Route::post('category/edit/:id', 'admin/Category/edit');
    Route::get('category/delete/:id', 'admin/Category/delete');

    // 用户管理
    Route::get('user', 'admin/User/index');
    Route::get('user/add', 'admin/User/add');
    Route::post('user/add', 'admin/User/add');
    Route::get('user/edit/:id', 'admin/User/edit');
    Route::post('user/edit/:id', 'admin/User/edit');
    Route::get('user/delete/:id', 'admin/User/delete');

    // 系统设置
    Route::get('setting', 'admin/Setting/index');
    Route::post('setting/save', 'admin/Setting/save');
})->middleware(\app\middleware\CheckLogin::class);

// 1. 首页：URL / → 映射到 index模块/Index控制器/index方法
Route::get('/', 'index/Index/index');

// 2. 所有文章列表：URL /article → 映射到 index模块/Index控制器/article方法
Route::get('/article', 'index/Index/article');

// 3. 分类页：URL /category → 映射到 index模块/Index控制器/category方法（接收id参数）
Route::get('/category', 'index/Index/category');

// 4. 文章详情页：URL /detail → 映射到 index模块/Index控制器/detail方法（接收id参数）
Route::get('/detail', 'index/Index/detail');

// ################## 新增前台用户路由 ##################
// 登录页面
Route::get('/index/user/login', 'index/User/login');
// 处理登录请求
Route::post('/index/user/doLogin', 'index/User/doLogin');
// 退出登录
Route::get('/index/user/logout', 'index/User/logout');

// ################## 新增前台文章发布路由 ##################
// 发布文章页面
Route::get('/index/article/publish', 'index/Article/publish');
// 处理文章发布请求
Route::post('/index/article/doPublish', 'index/Article/doPublish');
// 我的文章列表
Route::get('/index/article/myList', 'index/Article/myList');