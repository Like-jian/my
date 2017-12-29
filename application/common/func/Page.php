<?php
namespace \app\common\func;
use \think\Db;
 
 //自制分页类
class Page {
    public $totpages;
    public $nowpage;
    public $lastpage;
    public $firstpage;
    public $nextpage;
    public $prevpage;
    public $table;
    public $rows;
    public $totrows;
    public $pagesArr;

    public function init($table,$rows){
        $this->table=$table;
        $this->rows=$rows;
        $this->totrows=Db::name($table)->count();
        $this->totpages=$totrows/$this->rows;
        if($totrows%$this->rows)
    }

    public function index(){

    }
    public function echoPagesArr{
        return $this->pagesArr=[$lastpage,]
    }
}