<?php
/**
 * Created by PhpStorm.
 * User: quhongli
 * Date: 2020/4/24
 * Time: 19:16
 */

namespace Admincenter\Controller;
use Think\Controller;

class MessageController extends CommonController
{
    public function __construct(){
        parent::__construct();
    }
    public function Messagelist(){
        $RecID=I('RecID');
        $map=[];
        if($RecID){
            $map['a.RecID'][]=[['eq',$RecID],['eq',"*"], ['like','%"'.$RecID.'"%'],'or'];
            $this->assign('RecID',$RecID);
        }

        $count=M('message a')
            ->join('caipiao_messagetext b on a.MessageID=b.id','left')

            ->where($map)
            ->count();
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();


        $res=M('message a')
            ->join('caipiao_messagetext b on a.MessageID=b.id','left')
            ->where($map)
            ->field('a.*,b.Message,b.PDate,b.Title')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('a.id desc')
            ->select();
       // var_dump($res);
        $this->assign('count',$count);
        $this->assign('page',$show);

        $this->assign('list',$res);
        $this->display();

    }
    /*添加*/
    public function add(){
        if(IS_POST){
            $data=[];

            $arr=[];
            $arr['RecID']='*';
            $post=$_POST;

            if(!$post['title']){
                return  $this->error("标题不得为空");
            }
           if($post['RecID'] and strpos($post['RecID'],'|')==false){
               /*先查询用户是否存在  如果是单发 批量发不用查询*/
                   if(!M('member')->where(['id'=>$post['RecID']])->find()){
                      return  $this->error("此会员不存在，请检查后重试");
                   }
               $arr['RecID']=$post['RecID'];

           }else{
                if($post['RecID'])
               $arr['RecID']=json_encode(explode('|',$post['RecID']));
           }

           $data['Title']= $post['title'];
           $data['Message']= htmlspecialchars_decode($post['content']);
           $data['PDate']= time();
            /*先插入caipiao_messagetext 再 caipiao_message关联*/
            $int1 =  M('messagetext')->add($data);
            $arr['MessageID']=$int1;
            $int2 =  M('message')->add($arr);
        if($int1 && $int2){
            return  $this->success("成功");
        }
            return  $this->error("失败");
        }else{

            $this->display();
        }
    }
    /*编辑*/
    public function edit(){
        $map=[];
        $map['a.id']=I('id');
        $res=M('message a')
            ->join('caipiao_messagetext b on a.MessageID=b.id','left')
            ->where($map)
            ->field('a.*,b.Message,b.PDate,b.Title,b.id bid')
            ->find();

        if(!$res){
            return  $this->error("查询失败,数据不存在或 已被删除");
        }
        $this->assign('info',$res);
        $this->display();

    }
    /*编辑提交*/
    public function editdo(){
        $post=$_POST;
        if(!M('messagetext')->where(['id'=>$post['id']])->find()){
            return  $this->error("数据查询失败,数据不存在或 已被删除");
        }
        $int=M('messagetext')->where(['id'=>$post['id']])->save(['Message'=>$post['content'],'Title'=>$post['title']]);
        if($int){
            return  $this->success("修改成功");
        }else{
            return  $this->error("数据修改失败,数据需要变动才能修改成功");
        }
    }
    /*删除*/
    public function del(){
        $id=I('id');

        if($id && $res=M('message')->where(['id'=>$id])->find()){
           $int=M('message')->where(['id'=>$id])->delete();
           $int2=M('messagetext')->where(['id'=>$res['MessageID']])->delete();
          // var_dump($int,$int2);
           if($int && $int2){
               return  $this->success("成功");
           }
            return  $this->error("失败,数据不存在或 已被删除");
        }else{
            return  $this->error("失败,数据不存在或 已被删除");
        }
    }
    /*查看*/
    public function view(){

        $map=[];
        $map['a.id']=I('id');
        $res=M('message a')
            ->join('caipiao_messagetext b on a.MessageID=b.id','left')
            ->where($map)
            ->field('a.*,b.Message,b.PDate,b.Title')
            ->find();

        if(!$res){
            return  $this->error("查询失败,数据不存在或 已被删除");
        }

        $this->assign('info',$res);
        $this->display();
    }
}