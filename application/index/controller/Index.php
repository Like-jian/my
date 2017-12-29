<?php
namespace app\index\controller;
use \think\Controller;
use \app\common\logic\OrdersLogic;

class Index extends Controller
{
    public function index()
    {
        //获取域名 $domain=getdomain();
        //获取域名对应的商品  $row=getgoods($domain)
        //获取商品对应的模板 $tmp=$row['tmp'];
        //输出该模板和assign商品信息$this->assin();
        
        //域名
        
        $domain = getDomain();
        $row = getGoods($domain);
        $this->assign('good',$row);
        $tmp=$row['tmp'];
        $tmp = basename($tmp,".html");
        return $this->fetch($tmp);
    }

    //下单页面
    public function order(){
        $goods_id=input('id');
        $goodsLogic=new \app\common\logic\GoodsLogic();
        $info=$goodsLogic->getInfo($goods_id);
        $this->assign('info',$info);
        $this->assign('size',$info['size']);
        $this->assign('color',$info['color']);
        $this->assign('gift_size',$info['gift_size']);
        $this->assign('gift_color',$info['gift_color']);
        return $this->fetch();
    }

    //提交添加订单
    public function submitOrder(){
        $post=input("post.");
        $data['user'] = $post['name'];//用户名
        $data['mobile'] = $post['mob'];//手机号
        $data['email'] = $post['email'];//邮箱
        // $data['price'] = $post['price'];
        $data['add_time'] = $_SERVER['REQUEST_TIME'];//下单时间
        $data['shipping_price'] = 0;//发货状态
        $data['total_price'] = $post['price'];//总价
        $data['area'] = $post['province'];//地区
        $data['city'] = $post['city'];//市
        $data['address'] = $post['address'];//详细地址
        $data['goods_name'] = $post['product'];//商品全称
        $data['user_note'] = $post['guest'];//用户留言
        $data['pay_name'] = '货到付款';//支付方式

        $data['good_id'] = input('id');//商品id
        $data['color'] = $post['chanpin1'];//商品颜色
        $data['good_num'] = $post['mun'];//数量
        $data['good_size'] = $post['size'];//尺寸
        $data['gift_id'] = input('id');//赠品id
        $data['gift_color'] = $post['fcolor'];//赠品颜色
        $data['gift_num'] = $post['mun'];//赠品数量和商品数量一致
        $data['gift_size'] = $post['fsize'];//赠品尺寸

        //添加订单
        $order=new \app\common\logic\OrdersLogic();
        $result=$order->insertOrder($data);
        if(!$result['code']=='4'){
            $this->error($result['msg']);
        }
         return redirect('successOrder')->with('order_id',$result['order_id']);
        
    }

    //成功页面 订单详细页面
    public function successOrder(){
        $order_id=session('order_id');
        //跳转到查询页面
        if(empty($order_id))
            return redirect('findOrder');
        $order=new \app\common\logic\OrdersLogic();
        $goods=new \app\common\logic\GoodsLogic();
        $order_info=$order->getInfo($order_id);
        $goods_info=$goods->getField($order_info['good_id'],['color','gift_color','img']);
        $this->assign('time',date("Y-m-d H:i:s",$order_info['add_time']));
        $this->assign('order_sn',$order_info['order_sn']);
        $this->assign('data',$order_info);
        $this->assign('goods',$goods_info);
        return $this->fetch();
    }



    //查询订单
    public function findOrder(){
        $post=input('post.');
        if(isset($post['is_ajax']) && $post['is_ajax']=='1'){
            $order=new \app\common\logic\OrdersLogic();
            $order_info=$order->search("mobile={$post['mobile']}");
            $this->assign('order',$order_info);
            return $this->fetch('search_ajax');
        }
        if(input('id','')){
            return redirect('successOrder')->with('order_id',input('id'));
        }
        return $this->fetch();
    }
}
