<?php
namespace app\common\logic;
use \think\Db;

/**
* 商品模型类
*/
class GoodsLogic 
{
	private $table='goods';

    //获取商品所有信息 
    //int $id 商品id
    //return array $info 商品数组信息
	public function getInfo($id){
        $info=Db::name($this->table)->where('id',$id)->find();
        $info['color']= (!empty($info['color'])) ? json_decode($info['color'],true) : '';
        $info['size']= (!empty($info['size'])) ? json_decode($info['size'],true) : '';
        $info['gift_color']= (!empty($info['gift_color'])) ? json_decode($info['gift_color'],true) : '';
        $info['gift_size']= (!empty($info['gift_size'])) ? json_decode($info['gift_size'],true) : '';
        return $info;
	}
    //获取商品列表
    public function getList(){
        return $list=Db::name($this->table)->select();
    }
    //获取商品列表 分页
    public function getListPaginate($pages){
        return $list=Db::name($this->table)->paginate($pages);
    }

    //获取商品列表 分页
    public function getListSearchPaginate($whereStr,$pages){
        return $list=Db::name($this->table)->where($whereStr)->paginate($pages);
    }


    //获取商品某字段的信息
	public function getField($id,$arr){
        $info=Db::name($this->table)->where('id',$id)->field($arr)->find();
        if(isset($info['color'])) {
            $info['color']= (!empty($info['color'])) ? json_decode($info['color'],true) : '';
            $info['color']=$this->key($info['color']);
        }
        if(isset($info['size'])) {
            $info['size']= (!empty($info['size'])) ? json_decode($info['size'],true) : '';
        }
        if(isset($info['gift_color'])) {
            $info['gift_color']= (!empty($info['gift_color'])) ? json_decode($info['gift_color'],true) : '';
            $info['gift_color']=$this->key($info['gift_color']);
        }
        if(isset($info['gift_size'])) {
            $info['gift_size']= (!empty($info['gift_size'])) ? json_decode($info['gift_size'],true) : '';
        }
        return $info;
    }

    public function add($data){
        $data['addtime']=$_SERVER['REQUEST_TIME'];
        return Db::name($this->table)->insertGetId($data);
    }

    public function del($id){
        return Db::name($this->table)->delete($id);
    }

    public function save($id,$data){
        if(Db::name($this->table)->where('id',$id)->update($data)){
            return $id;
        }
    }

    //讲color数组键值改为对应键
    public function key($arr){
        foreach ($arr as $k => $v) {
            $arr2[$v['color']]=$v;
        }
        return $arr2;
    }
}