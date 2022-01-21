<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends CommonController {
	public function __construct(){
		parent::__construct();
	}
	function index(){
		$configs = M('setting')->select();
		$uid = M('member')->where(['id'=>session('member_auth_id')])->find();
		if($uid['showav'] == 0){
		    $msg = $configs[118]["value"]; 
		    $khdd = "mizhu.toast('".$msg."', 4000);";
		    $m = '0'; 
		  //  echo "<script>alert('$khdd');avascript:history.back(-1);</script>";
		}else {
		    $khdd = "javascript:location.href = '/Other.info.do?id="; 
		    $m = '1'; 
		}
// 		$khdd = "javascript:location.href = '/Other.info.do?id="; 
        // $khdd = "mizhu.toast('已取消关注', 6000);";
		$_t = time();
		$cplist = M('caipiao')->where(array('isopen'=>1))->cache(300)->order('allsort asc')->limit(11)->select();
		$gglist = M('Gonggao')->field('id,title,oddtime')->cache(300)->order("id DESC")->find();
		$this->assign('gglist',$gglist);
		$this->cplist  = $cplist;
		$data = indexdata();
		$this->assign('khdd',$khdd);
		$this->assign('m',$m);
        $this->assign('om',$data[0]['live']);
        $this->assign('rh',$data[1]['live']);
        $this->assign('yz',$data[2]['live']);
        $this->assign('gc',$data[3]['live']);
        $this->assign('rm',$data[4]['live']);
		$this->display();
	}

	function lotteryHall()
	{
		$cplist = M('caipiao')->where(array('isopen'=>1))->order('allsort asc')->select();
		$cplist2 = M('caipiao')->where(array('isopen'=>1))->order('listorder asc')->cache(300)->select();
		$this->assign('cplist',$cplist);
		$this->assign('cplist2',$cplist2);
		$this->display();
	}
	
	function video(){
        $this->display();
    }

}
?>