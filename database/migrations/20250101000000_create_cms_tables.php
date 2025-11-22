<?php
use think\migration\Migrator;
use think\migration\db\Column;

class CreateCmsTables extends Migrator
{
    public function up()
    {
        // 1. 用户表（管理员）
        $this->table('user', ['engine' => 'InnoDB', 'comment' => '管理员表'])
            ->addColumn(Column::string('username', 30)->setComment('用户名')->setUnique())
            ->addColumn(Column::string('password', 60)->setComment('密码（bcrypt加密）'))
            ->addColumn(Column::string('nickname', 30)->setComment('昵称'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态：1正常 0禁用'))
            ->addColumn(Column::datetime('create_time')->setDefault('CURRENT_TIMESTAMP')->setComment('创建时间'))
            ->addColumn(Column::datetime('update_time')->setDefault('CURRENT_TIMESTAMP')->setUpdate('CURRENT_TIMESTAMP')->setComment('更新时间'))
            ->create();

        // 2. 分类表
        $this->table('category', ['engine' => 'InnoDB', 'comment' => '文章分类表'])
            ->addColumn(Column::string('name', 50)->setComment('分类名称'))
            ->addColumn(Column::integer('pid')->setDefault(0)->setComment('父分类ID'))
            ->addColumn(Column::integer('sort')->setDefault(100)->setComment('排序'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态：1显示 0隐藏'))
            ->addColumn(Column::datetime('create_time')->setDefault('CURRENT_TIMESTAMP')->setComment('创建时间'))
            ->addColumn(Column::datetime('update_time')->setDefault('CURRENT_TIMESTAMP')->setUpdate('CURRENT_TIMESTAMP')->setComment('更新时间'))
            ->create();

        // 3. 文章表
        $this->table('article', ['engine' => 'InnoDB', 'comment' => '文章表'])
            ->addColumn(Column::integer('cid')->setComment('分类ID'))
            ->addColumn(Column::string('title', 100)->setComment('文章标题'))
            ->addColumn(Column::text('content')->setComment('文章内容'))
            ->addColumn(Column::string('cover', 255)->setDefault('')->setComment('封面图'))
            ->addColumn(Column::integer('view')->setDefault(0)->setComment('阅读量'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态：1发布 0草稿'))
            ->addColumn(Column::integer('create_uid')->setComment('创建人ID'))
            ->addColumn(Column::datetime('create_time')->setDefault('CURRENT_TIMESTAMP')->setComment('创建时间'))
            ->addColumn(Column::datetime('update_time')->setDefault('CURRENT_TIMESTAMP')->setUpdate('CURRENT_TIMESTAMP')->setComment('更新时间'))
            ->create();

        // 4. 系统设置表
        $this->table('setting', ['engine' => 'InnoDB', 'comment' => '系统设置表'])
            ->addColumn(Column::string('key', 50)->setComment('配置键名')->setUnique())
            ->addColumn(Column::text('value')->setComment('配置值'))
            ->addColumn(Column::string('desc', 255)->setDefault('')->setComment('配置描述'))
            ->create();

        // 初始化数据：超级管理员（密码：123456）
        $this->table('user')->insert([
            'username' => 'admin',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'nickname' => '超级管理员',
            'status'   => 1,
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s'),
        ])->save();

        // 初始化数据：默认分类
        $this->table('category')->insert([
            'name' => '默认分类',
            'pid'  => 0,
            'sort' => 100,
            'status' => 1,
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s'),
        ])->save();

        // 初始化数据：系统设置
        $this->table('setting')->insert([
            ['key' => 'site_title', 'value' => 'TP6 CMS', 'desc' => '网站标题'],
            ['key' => 'site_desc', 'value' => '基于ThinkPHP 6.0开发的CMS系统', 'desc' => '网站描述'],
            ['key' => 'site_logo', 'value' => '', 'desc' => '网站Logo'],
        ])->save();
    }

    public function down()
    {
        $this->dropTable('article');
        $this->dropTable('category');
        $this->dropTable('user');
        $this->dropTable('setting');
    }
}