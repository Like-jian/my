<?php
namespace app\common\logic;
use \think\Db;

class TmpsLogic{
    public $table='tmps';
    public function getList(){
        return Db::name($this->table)->select();
    }
}