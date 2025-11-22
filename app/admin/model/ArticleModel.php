<?php
namespace app\admin\model;

use think\Model;

class ArticleModel extends Model
{
    protected $table = 'cms_article';
    protected $autoWriteTimestamp = false;

    // 关联分类
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'cid', 'id');
    }
}