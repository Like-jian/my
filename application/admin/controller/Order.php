<?php
namespace app\admin\controller;
use \think\Controller;
use \app\common\logic\OrdersLogic;
use \think\Db;

class Order extends Controller{
    public function index(){
        return $this->fetch();
    }

    public function edit(){
        $id=input('id');
        $data=input('post.');
        $order=new OrdersLogic();
        $result=$order->edit($id,$data);
        if($result){
            $this->success('保存成功');
        }else{
            $this->error('没有更改内容或保存失败');
        }
        
    }

    public function ajaxindex(){
        $order=new OrdersLogic();
        $order_list=$order->getAllInfo();
        $this->assign('order_list',$order_list);
        return $this->fetch();
    }

    //订单详情
    public function detail(){
        $id=input('id');
        $order=new OrdersLogic();
        $order_info=$order->getInfo($id);
        $this->assign('order',$order_info);
        return $this->fetch();
    }
    /**
     * 导出excel表格
     */
    public function export_order(){
        //搜索条件
        $where='1=1';$field=input('field/a');
        
        $c_web=input('c_web','');
        if($c_web){
            $where.=" AND c_web = '$c_web' ";
        }
        $user=input('user','');
        if($user){
            $where.=" AND user = '$user' ";
        }
        $order_sn=input('order_sn','');
        if($order_sn){
            $where.=" AND order_sn = '$order_sn' ";
        }
        $timegap = input('timegap');
        if($timegap){
            $gap = explode('-', $timegap);
            $begin = strtotime($gap[0]);
            $end = strtotime($gap[1]);
            $where .= " AND add_time>$begin and add_time<$end ";
        }
        $shipping_status=input('shipping_status','');
        
        if($shipping_status!=''){
            $where.=" AND shipping_status = '$shipping_status' ";
        }
        $order_by=input('order_by','order_id');
        if($order_by=='2'){
            $order_by='order by add_time';
        }elseif ($order_by=='3') {
            $order_by='order by total_price';
        }elseif ($order_by=='1') {
            $order_by='order by order_id';
        }
        $sort=input('sort','');
        if($sort=='1'){
            $sort='desc';
        }elseif ($sort=='0') {
            $sort='';
        }
        $len=count($field);
        $fieldStr='';
        $th='';
        //替换单词为文字
        $find=['order_id','order_sn','order_status','shipping_status','user','area','city','address','mobile','email','pay_name','shipping_price','total_price','add_time','user_note','goods_name','good_id','gift_color','color','good_num','good_size','gift_id','gift_size','gift_num','sku','supplier','c_web'];
        $replace=['订单id','订单编号','订单状态','发货状态','收货人','地区','市','详细地址','手机','邮箱','支付方式','邮费','总价','下单时间','留言','商品名','商品id','赠品颜色','商品颜色','数量','尺寸','赠品id','赠品尺寸','赠品数量','SKU','供应商','二级域名网站'];
        $fieldArr=str_replace($find, $replace, $field);
        foreach ($fieldArr as $k => $v) {
            $th.="<td>$v</td>";
        }

        foreach ($field as $k => $v) {
            if($len-1!=$k){
                $fieldStr.=" $v, ";
            }else{
                $fieldStr.=" $v ";
            }
        }
        //组合sql
        $sql="select $fieldStr from orders where $where  $order_by $sort";
        $list=\think\Db::query($sql);
        $table="<table><tr>$th</tr>";
        foreach ($list as $k => $v) {
            $table.="<tr>";
            //循环$field目的是是表头和内容排列的顺序一致
            foreach ($field as $key => $value) {
                if($value=="add_time"){
                    $add_time=date("Y-m-d H:i",$v['add_time']);
                    $table.="<td>$add_time</td>";
                }else{
                    $table.="<td>$v[$value]</td>";
                }
            }
            $table.="</tr>";
        }
        $table.="</table>";
        downloadExcel($table,'订单');
    }
}