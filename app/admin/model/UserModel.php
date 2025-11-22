<?php
namespace app\admin\model;

use think\Model;

class UserModel extends Model
{
    protected $table = 'cms_user';
    protected $autoWriteTimestamp = false;
}