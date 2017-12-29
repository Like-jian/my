<?php
namespace app\admin\controller;
use \think\Controller;
use \app\common\logic\GoodsLogic;
use \app\common\logic\TmpsLogic;
use \think\Db;

class Goods extends Controller{
    public function addeditGoods(){
        if($goods_id=input('id')){
            $goods=new GoodsLogic();
            $goods_info=$goods->getInfo($goods_id);
            $this->assign('goods',$goods_info);
        }
        $tmp=new TmpsLogic();
        $tmp_list=$tmp->getList();
        $this->assign('tmps',$tmp_list);
        return $this->fetch('add');
    }
    //商品列表
    public function goodsList(){
        $goods=new GoodsLogic();
        //分页，1条记录一页
        $goods_list=$goods->getListPaginate(10);
        $this->assign('goodsList',$goods_list);
        $this->assign('page',$goods_list->render());
        return $this->fetch();
    }
    public function ajaxGoodsList(){
       
        $goods=new GoodsLogic();
        $goods_list=$goods->getListPaginate($where,10);
        $this->assign('goodsList',$goods_list);
        $this->assign('page',$goods_list->render());
        return $this->fetch();
    }

    //商品搜索
    public function search(){ 
        
        input('tmp')?$where['tmp']=input('tmp'):'';
        input('c_web')?$where['c_web']=input('c_web'):'';
        input('start_time')?$where['addtime']=['between',[strtotime(input('start_time')),strtotime(input('end_time'))]]:'';
        input('key_word')?$where['name']=['like','%'.input('key_word').'%']:'';
        
        if(input('page')){
            $where=session('where');
        }
        if(!isset($where)){
            return $this->error('请输入条件');
        }
        session('where',$where);
        $goods=new GoodsLogic();
        //分页，1条记录一页
        $goods_list=$goods->getListSearchPaginate($where,10);
        $this->assign('goodsList',$goods_list);

        $this->assign('page',$goods_list->render());
        return $this->fetch('GoodsList');
    }

    public function addGoods(){
        //增加商品
        $data['name']=input('goods_name');
        $data['price']=input('price');
        $data['img']=input('img');
        $data['sku']=input('sku');
        $data['c_web']=input('c_web');
        $data['web']=input('web');
        $data['px']=input('facebook');
        $data['supplier']=input('supplier');
        $data['size']=json_encode(input('goods_size/a'));
        //颜色与数组合并转json
        $color=input('goods_color/a');
        $color_img=input('color_img/a');
        foreach ($color as $k => $v) {
            $colorArr[$k]=['color'=>$v,'img'=>$color_img[$k]];
        }

        $data['color']=json_encode($colorArr);
        $data['gift_size']=json_encode(input('gift_size/a'));

        $gift_color=input('gift_color/a');
        $gift_img=input('gift_img/a');
        foreach ($gift_color as $k => $v) {
            $gift_colorArr[$k]=['color'=>$v,'img'=>$gift_img[$k]];
        }

        $data['gift_color']=json_encode($gift_colorArr);
        $data['content']=input('editorValue');
        
        $goods=new GoodsLogic();
        if($id=input('id')){
            $goods_id=$goods->save($id,$data);
        }else{
            $goods_id=$goods->add($data);
        }
        
        $this->success('保存成功',url('addeditGoods', ['id' => $goods_id]));
    }

    public function del(){
        $id=input('id');
        $goods=new GoodsLogic();
        $result=$goods->del($id);
        if($result){
            $return=['code'=>'1','msg'=>'删除成功'];
        }else{
            $return=['code'=>'0','msg'=>'删除失败'];
        }
        return $return;
    }
    public function upload(){

    }
}