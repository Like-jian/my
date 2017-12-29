<?php
namespace app\admin\controller;
use \think\Controller;
use \app\common\logic\GoodsLogic;
use \think\Db;
use \think\Request;
/**
* 
*/
class Uploadify extends Controller
{
    
    public function upload(){
        $id=input('id');
        $file = Request::instance()->file($id);
        $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS .'upload'.DS.'image');
        if($info){
            return ['code'=>'1','filename'=>  '/static/upload/image/'.$info->getSavename()];
        }else{
            return ['code'=>'0','msg'=>$file->getError()];
        }

        
    }
}