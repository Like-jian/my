<?php 
namespace app\common\logic;
use \think\Db;

/**
 * array $data 订单数组
 * array $result return 
 */

class OrdersLogic {
    private $table='orders';
    public function insertOrder($data){
    //code 1姓名 2詳細地址 3手機
        if(!isset($data['user'])){
            return $result=['code'=>'1','msg'=>'請填寫姓名'];
        }
        if(!isset($data['address'])){
            return $result=['code'=>'2','msg'=>'請填寫詳細地址'];
        }
        if(!isset($data['mobile'])){
            return $result=['code'=>'3','msg'=>'請填寫手機'];
        }
        $data['order_sn']=$this->get_order_sn();
        $data['area']=getArea($data['area']);
        $data['city']=getArea($data['city']);
        //获取商品信息
        $goodsLogic=new \app\common\logic\GoodsLogic();
        $goods_info= $goodsLogic->getField($data['good_id'],['c_web','sku','supplier']);
        $data['sku']=$goods_info['sku'];
        $data['c_web']=$goods_info['c_web'];
        $data['supplier']=$goods_info['supplier'];


        if($id=Db::name($this->table)->insertGetId($data)){
            return $result=['code'=>'4','msg'=>'訂單提交成功','order_sn'=>$data['order_sn'],'order_id'=>$id];
        }
        return $result=['code'=>'0','msg'=>'寫入系統失敗'];
    }

    /**
     * 获取订单信息
     */
    public function getInfo($id){
        return Db::name($this->table)->where('order_id',$id)->find();
    }

    public function edit($id,$data){
        return Db::name($this->table)->where('order_id',$id)->update($data);
    }

    /**
     * 获取订单信息
     */
    public function getAllInfo(){
        return Db::name($this->table)->limit(0,15)->select();
    }

    public function search($str){
        $info= Db::name($this->table)->where($str)->select();
        foreach ($info as $k => $v) {
            $info[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
        }
        return $info;
    }

    /**
     * 获取订单编号 order_sn
     * @return string
     */
    public function get_order_sn()
    {
        $order_sn = null;
        // 保证不会有重复订单号存在
        while(true){
            $order_sn = date('YmdHis').rand(1000,9999); // 订单编号         
            $order_sn_count = Db::name('orders')->where("order_sn",$order_sn)->count();
            if($order_sn_count == 0)
                break;
        }
        
        return $order_sn;
    }
}