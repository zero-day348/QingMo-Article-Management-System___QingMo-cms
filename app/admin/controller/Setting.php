<?php
namespace app\admin\controller;

use think\facade\View;
use think\facade\Request;
use app\admin\model\SettingModel; // 已正确引入新模型类

class Setting
{
    // 系统设置页面
    public function index()
    {
        // 关键修改1：Setting → SettingModel（调用新模型类的 select 方法）
        $settings = SettingModel::select();
        $config = [];
        foreach ($settings as $item) {
            $config[$item->key] = $item->value;
        }
        View::assign('config', $config);
        return View::fetch();
    }

    // 保存设置
    public function save()
    {
        if (Request::isPost()) {
            $data = Request::post();
            foreach ($data as $key => $value) {
                // 关键修改2：Setting → SettingModel（调用新模型类的 where+update 方法）
                SettingModel::where('key', $key)->update(['value' => $value]);
            }
            return json(['code' => 1, 'msg' => '保存成功']);
        }
        return json(['code' => 0, 'msg' => '请求方式错误']);
    }
}