<?php
return [
    // 应用名称
    'app_name'        => 'TP6_CMS',
    // 应用地址
    'app_host'        => env('app.host', ''),
    // 应用调试模式
    'app_debug'       => true,
    'show_error_msg'   => true,
    // config/app.php
    'auto_multi_app' => true, // 启用多应用模式，框架才会识别 index 模块
    // 应用Trace
    'app_trace'       => true,
    // 应用模式状态
    'app_status'      => 'debug',
    // 是否支持多模块
    'multi_module'    => true,
    // 入口自动绑定模块
    'auto_bind_module' => false,
    // 注册的根命名空间
    'root_namespace'  => [],
    // 默认输出类型
    'default_return_type' => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return_type' => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler' => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler' => 'callback',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',
    // 是否开启多语言
    'lang_switch_on'  => false,
    // 默认语言
    'default_lang'    => 'zh-cn',
    // 应用类库后缀
    'class_suffix'    => false,
    // 控制器类后缀
    'controller_suffix' => false,
    // 路由配置文件（支持配置多个）
    'route_config_file' => ['route'],
    // 表单请求类型伪装变量
    'var_method'      => '_method',
    // 表单ajax伪装变量
    'var_ajax'        => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'        => '_pjax',
    // 是否开启请求缓存
    'request_cache'   => false,
    // 请求缓存有效期
    'request_cache_expire' => null,
    // 全局请求缓存排除规则
    'request_cache_except' => [],
    // 默认控制器名
    'default_controller' => 'Index',
    // 默认操作名
    'default_action'  => 'index',
    // 默认验证器
    'default_validate' => '',
    // 默认的空控制器名
    'empty_controller' => 'Error',
    // 操作方法后缀
    'action_suffix'   => '',
    // 自动搜索控制器
    'controller_auto_search' => false,
    // 允许的请求类型
    'allow_method_list' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
    // 跨域请求允许的Origin
    'allow_origin'    => [],
    // 跨域请求允许的Method
    'allow_method'    => [],
    // 跨域请求允许的Header
    'allow_header'    => [],
    // 跨域请求允许的Credentials
    'allow_credentials' => false,
    // 跨域请求的缓存时间
    'max_age'         => 0,
    // 控制器的默认中间件
    'controller_middleware' => [],
    // 全局中间件
    'middleware'      => [
        \app\middleware\CheckLogin::class, // 后台登录验证中间件
    ],
    // 插件配置
    'plugin'          => [],
    // 扩展配置
    'extend_config'   => [],

    'auto_load_config' => [
        'captcha', // 确保包含这行，自动加载扩展的captcha配置
    ],

    // 分页配置
    'paginate' => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 10,
        // 自定义分页模板（指向我们创建的 bootstrap5.html）
        'template'  => app()->getRootPath() . 'app/common/view/paginate/bootstrap5.html',
    ],

    'route_annotation' => false,
];