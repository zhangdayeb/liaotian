<?php
namespace Mobile\Controller;
use Think\Controller;
class OtherController extends CommonController {
    public function __construct(){
		parent::__construct();
	}
	public function xuanmei(){
	    $this->display();
	}
	public function info(){
		if(!$this->userinfo || $this->userinfo['islogin']!=1){
			session('member_sessionid',NULL);
			session('member_auth_id',NULL);
			redirect(U('Public/login'));
			exit;
		}
		$configs = M('setting')->select();
		$uid = M('member')->where(['id'=>session('member_auth_id')])->find();
		if($uid['showav'] == 0){
		    $khdd = $configs[118]["value"]; 
		    echo "<script>alert('$khdd');avascript:history.back(-1);</script>";
		}
		$source = '';
		if($this->userinfo['showav']){
		    $data = videodata();
		    foreach ($data as $item){
		        if($item['id']==$_REQUEST['id']){
		            $source = $item['video_link'];
		            $img = $item['image_link'];
		            break;
		        }
		    }
		}
		$this->assign('source',$source);
		$this->assign('img',$img);
		
	    $this->display();
	}
    public function type(){
		if(!$this->userinfo || $this->userinfo['islogin']!=1){
			session('member_sessionid',NULL);
			session('member_auth_id',NULL);
			redirect(U('Public/login'));
			exit;
		}
		if($_REQUEST['type']==2){
		    $list = rmdata();
		}elseif($_REQUEST['type']==3){
		    $list = gcdata();
		}elseif($_REQUEST['type']==4){
		    $list = rhdata();
		}elseif($_REQUEST['type']==5){
		    $list = omdata();
		}
		$this->assign('list',$list);
	    $this->display();
    }
}