<?php
namespace Kaijiang\Controller;
use Think\Controller;
class KjController extends Controller {
	public function _initialize(){
		header("Content-type: text/html; charset=utf-8");
// 		if(!IS_CLI)exit('IS NOT CMD_CLI,ERROR...');
	}
	function _t($str='',$num=20,$pad =' '){
	    if(PHP_OS != 'Linux'){
            $str = iconv('UTF-8','gbk',$str);
        }
		return str_pad($str,$num,$pad);
	}
	function _title($title='启动结算任务'){
		echo "\n";
		echo $this->_t(str_pad('-',5,'-').$title,22,'-');
		echo "\n";
	}
	function check($totalzxnum=0,$runcount=0){
	    if($runcount==0){
			$this->_title();
		}
		$memberdb    = D('member');
		$fuddetaildb = D('fuddetail');
		$touzhudb    = D('touzhu');
		$DB_PREFIX = C('DB_PREFIX');
		$sql = "select a.*,b.name,b.expect,b.opencode from {$DB_PREFIX}touzhu as a left join {$DB_PREFIX}kaijiang as b on a.cpname = b.name and a.expect = b.expect where a.isdraw = 0 and b.opencode!='' and a.play_type=0 order by a.id desc limit 10";
		$touzhulist = M()->query($sql);
		/*		$touzhulist[0]['opencode']="1,2,3,4,5";
                $touzhulist[0]['typeid']="ssc";
                $touzhulist[0]['tzcode']="0,1,2,3,4,5,6,7,8,9";
                $touzhulist[0]['playid']="bdw5x2m";*/
		//exit;
		$_ZJARRAY = [];
		foreach($touzhulist as $k=>$item) {
            $_kjfile = $dir = COMMON_PATH . "Lib/kaijiang/{$item['typeid']}.class.php";
            if ($_kjfile) {
                $class = "\\Lib\\kaijiang\\{$item[typeid]}";
                $_obj = new $class();
                $playid = $item['playid'];
                $item['iszjokcount'] = 0;
                if (method_exists($_obj, $playid)) {//如果类方法存在
                    $item['iszjokcount'] = $_obj->$playid($item['opencode'], $item['tzcode']);
                }
            }
            $touzhulist[$k] = $item;
        }

        $sql = "select a.*,b.name,b.expect,b.opencode,w.func,w.class1,w.class2,w.class3 from {$DB_PREFIX}touzhu as a left join {$DB_PREFIX}kaijiang as b on a.cpname = b.name and a.expect = b.expect left join {$DB_PREFIX}wanfa_old w on a.playid = w.id where a.play_type = 1 and a.isdraw = 0 and b.opencode!='' order by a.id desc limit 10";
		$oldtouzhulist = M()->query($sql);
        foreach($oldtouzhulist as $k=>$item){
            $play = new \Lib\kaijiang\oldPlay();
            $item['iszjokcount'] = $play->check($item);
            $oldtouzhulist[$k] = $item;
        }
        $touzhulist = array_merge($touzhulist, $oldtouzhulist);
		foreach($touzhulist as $k=>$item){
			//处理中奖信息
			$memint = $touzhuint = $fudint = 0;
			$iskj = $touzhudb->where(['id'=>$item['id']])->getField('isdraw');
			if($iskj!=0){
				continue;
			}
			if($item['iszjokcount'] =='x5'){
				$item['iszjcount'] = 0;
			}else{
				$item['iszjcount'] = $item['iszjokcount'];
			}
			if($item['iszjcount']>=1){//中
				$_typeid0 = $item['typeid'];
				if(strstr($item["mode"],'|')){
					for($i=0;$i<count($item['iszjokcount']);$i++){
						if($item["iszjcount"][$i]>0){
							$item['zjcount'] = $item["iszjcount"][$i];
							break;
						}
					}
				}else{
					$item['zjcount']=$item['iszjokcount'];
				}
				$okamount = self::$_typeid0($item);
				$totalokamount = $okamount + $item['repointamout'];
				$userbalance = $memberdb->where(['id'=>$item['uid']])->getField('balance');
				//事务开始
				$memberdb->startTrans();
				$memint = $memberdb->where(['id'=>$item['uid']])->setInc('balance',$totalokamount);//账户增加金额
				//修改投注为中奖状态
				$touzhuint = $touzhudb->where(['id'=>$item['id']])->setField(['isdraw'=>1,'okcount'=>$item['zjcount'],'okamount'=>$okamount,'opencode'=>$item['opencode']]);

				//账变记录
				$fdata = [];
				$fdata['trano'] = $item['trano'];
				$fdata['uid'] = $item['uid'];
				$fdata['username'] = $item['username'];
				$fdata['type'] = 'reward';
				$fdata['typename'] = '返奖';
				$fdata['amount'] = $okamount;
				$fdata['amountbefor'] = $userbalance;
				$fdata['amountafter'] = $userbalance + $okamount;
				$fdata['oddtime'] = time();
				$fdata['remark'] = $item['cptitle'] .'第'. $item['expect'] . '期-' . $item['playtitle'].'返奖';
				$fudint = $fuddetaildb->data($fdata)->add();

                if ($item['repointamout'] >0){
                    //$userbalance = $memberdb->where(['id'=>$item['uid']])->getField('balance');
                    //账变记录返点
                    $fdata = [];
                    $fdata['trano'] = $item['trano'];
                    $fdata['uid'] = $item['uid'];
                    $fdata['username'] = $item['username'];
                    $fdata['type'] = 'commission';
                    $fdata['typename'] = '返点';
                    $fdata['amount'] = $item['repointamout'];
                    $fdata['amountbefor'] = $userbalance+$okamount;
                    $fdata['amountafter'] = $userbalance +$totalokamount;
                    $fdata['oddtime'] = time();
                    $fdata['remark'] = $item['cptitle'] .'第'. $item['expect'] . '期-' . $item['playtitle'].'中奖返点';
                    $fudint = $fuddetaildb->data($fdata)->add();
                }

				if($memint && $touzhuint && $fudint){
					$memberdb->commit();//提交事物
					$_ZJARRAY[] = $item['username'] . "-" .$item['cptitle'] .'第'. $item['expect'] . '期-' . "中奖金额：".$okamount. "返点：".$item['repointamout'];
				}else{
				    echo $item['id'].'rollback';
					$memberdb->rollback();//事物回滚
				}

			}else if($item['iszjcount']<1){//未中

			    if ($item['repointamout'] >0){
                    $memberdb->startTrans();
                    $userbalance = $memberdb->where(['id'=>$item['uid']])->getField('balance');
                    //账变记录返点
                    $fdata = [];
                    $fdata['trano'] = $item['trano'];
                    $fdata['uid'] = $item['uid'];
                    $fdata['username'] = $item['username'];
                    $fdata['type'] = 'commission';
                    $fdata['typename'] = '返点';
                    $fdata['amount'] = $item['repointamout'];
                    $fdata['amountbefor'] = $userbalance;
                    $fdata['amountafter'] = $userbalance + $item['repointamout'];
                    $fdata['oddtime'] = time();
                    $fdata['remark'] = $item['cptitle'] .'第'. $item['expect'] . '期-' . $item['playtitle'].'未中奖返点'.$item['repointamout'];
                    $fudint = $fuddetaildb->data($fdata)->add();
                    $memint = $memberdb->where(['id'=>$item['uid']])->setInc('balance',$item['repointamout']);//账户增加金额
			    }
				$okamount = -$item['amount'];
				$touzhuint = $touzhudb->where(['id'=>$item['id']])->setField(['isdraw'=>-1,'okcount'=>0,'okamount'=>0,'opencode'=>$item['opencode']]);
				if($item['repointamout']){
				    if($fudint && $memint && $touzhuint){
				        $memberdb->commit();
                    }else{
				        $memberdb->rollback();
                    }
                }
				$_ZJARRAY[] = $item['username'] . "-" .$item['cptitle'] .'第'. $item['expect'] . '期-' . "未中奖,输：".$okamount. "返点：".$item['repointamout'];
			}
			
		}
		if($_ZJARRAY){
			$return = implode("\n",$_ZJARRAY);
		}else{
			 $return =  "未结算";
		}
		 echo auto_charset($return."\n",'utf-8','gbk');
		 sleep(2);
		$runcount++;
		if($runcount==10){
			$runcount=0;
			echo auto_charset("休眠3s",'utf-8','gbk');
			sleep(3);
		}
		if($runcount<8){
			self::check($totalzxnum+1,$runcount);
		}
	}

    protected function lhc($res){
	
		$okamount = 0;
		if(strstr($res["mode"],'|')){
			$mode = explode('|',$res["mode"]);
			for($i=0;$i<count($mode);$i++){
				if($res["iszjcount"][$i]>0){
					$okamount +=($res['amount']/$res['itemcount'])*$mode[$i]*$res['beishu']*$res['iszjokcount'][$i];
				}
			}
		}else{
			$okamount = ($res['amount']/$res['itemcount'])*$res['mode']*$res['beishu']*$res['iszjokcount'];
		}
		
		return $okamount;
	}
	
	protected function ssc($res){
		$okamount = 0;
		/*$rules = M('wanfa')->where(['typeid'=>$res['typeid'],'playid'=>$res['playid']])->find();
		if($rules){
			$defaultfandian = 0.13;
			$userinfo = [];
			$userinfo = M('member')->where(['id'=>$res['uid']])->find();
			$fandian = $userinfo['fandian'];
			if($rules['rate']>0){
				$amount = $res['mode']*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}else{
				$amount = (($rules['maxjj']/2) - ($defaultfandian-($fandian/100-$res['repoint']/100)) * $rules['totalzs'])*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}
		}else{

		}*/
//		投注金额/投注注数*奖金*中奖注数
//		exit('('.$res['amount'].'/'.$res['itemcount'].')*'.$res['mode'].'*'.$res['zjcount']);
//		$okamount = ($res['amount']/$res['itemcount'])*$res['mode']*$res['zjcount'];
		$okamount =$res['mode']*$res['zjcount']*$res['beishu']*$res['yjf'];
		return $okamount;
	}
	protected function k3($res){
		$okamount = 0;
		/*$rules = M('wanfa')->where(['typeid'=>$res['typeid'],'playid'=>$res['playid']])->find();
		if($rules){
			$defaultfandian = 0.13;
			$userinfo = [];
			$userinfo = M('member')->where(['id'=>$res['uid']])->find();
			$fandian = $userinfo['fandian'];
			if($rules['rate']>0){
				$amount = $res['mode']*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}else{
				$amount = (($rules['maxjj']/2) - ($defaultfandian-($fandian/100-$res['repoint']/100)) * $rules['totalzs'])*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}
		}else{

		}*/
		$okamount = ($res['amount']/$res['itemcount'])*$res['mode']*$res['zjcount'];
		return $okamount;
	}
	protected function x5($res){
		$okamount = 0;
		if(strstr($res["mode"],'|')){
			$amount = explode('|',$res["mode"]);
			for($i=0;$i<count($amount);$i++){
				if($res['iszjokcount'][$i]!=0){
					$okamount = $amount[$i]*$res['iszjokcount'][$i]*$res['beishu']*$res['yjf'];
			 }
			}
		}else{

			$okamount =$res['mode']*$res['zjcount']*$res['beishu']*$res['yjf'];
		}
		return $okamount;
	}
	protected function kl10f($res){
		$okamount = 0;
		$rules = M('wanfa')->where(['typeid'=>$res['typeid'],'playid'=>$res['playid']])->find();
		if($rules){
			$defaultfandian = 0.13;
			$userinfo = [];
			$userinfo = M('member')->where(['id'=>$res['uid']])->find();
			$fandian = $userinfo['fandian'];
			if($rules['rate']>0){
				$amount = $res['mode']*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}else{
				$amount = (($rules['maxjj']/2) - ($defaultfandian-($fandian/100-$res['repoint']/100)) * $rules['totalzs'])*$res['yjf']*$res['beishu'];
				$okamount = $amount*$res['zjcount'];
			}
		}else{

		}
		return $okamount;
	}
	protected function pk10($res){
		$okamount = 0;
		/*		$rules = M('wanfa')->where(['typeid'=>$res['typeid'],'playid'=>$res['playid']])->find();
                if($rules){
                    $defaultfandian = 0.13;
                    $userinfo = [];
                    $userinfo = M('member')->where(['id'=>$res['uid']])->find();
                    $fandian = $userinfo['fandian'];
                    if($rules['rate']>0){
                        $amount = $res['mode']*$res['yjf']*$res['beishu'];
                        $okamount = $amount*$res['zjcount'];
                    }else{
                        $amount = (($rules['maxjj']/2) - ($defaultfandian-($fandian/100-$res['repoint']/100)) * $rules['totalzs'])*$res['yjf']*$res['beishu'];
                        $okamount = $amount*$res['zjcount'];
                    }
                }else{

                }*/
		$okamount =$res['mode']*$res['zjcount']*$res['beishu']*$res['yjf'];
		return $okamount;
	}
	protected function dpc($res){
		$okamount = 0;
		/*		$rules = M('wanfa')->where(['typeid'=>$res['typeid'],'playid'=>$res['playid']])->find();
                if($rules){
                    $defaultfandian = 0.13;
                    $userinfo = [];
                    $userinfo = M('member')->where(['id'=>$res['uid']])->find();
                    $fandian = $userinfo['fandian'];
                    if($rules['rate']>0){
                        $amount = $res['mode']*$res['yjf']*$res['beishu'];
                        $okamount = $amount*$res['zjcount'];
                    }else{
                        $amount = (($rules['maxjj']/2) - ($defaultfandian-($fandian/100-$res['repoint']/100)) * $rules['totalzs'])*$res['yjf']*$res['beishu'];
                        $okamount = $amount*$res['zjcount'];
                    }
                }else{

                }*/
		$okamount =$res['mode']*$res['zjcount']*$res['beishu']*$res['yjf'];
		return $okamount;
	}
	protected function keno($res){
		$okamount = 0;
		if(strstr($res["mode"],'|')){
			$amount = explode('|',$res["mode"]);
			for($i=0;$i<count($amount);$i++){
				if($res["iszjcount"][$i]>0){
					$okamount = $okamount+($amount[$i]*$res["iszjcount"][$i])*$res['beishu']*$res['yjf'] ;
					break;
				}
			}
		}else{
			$okamount =$res['mode']*$res['zjcount']*$res['beishu']*$res['yjf'];
		}
		return $okamount;

	}
	protected function xy28($res){

	}
//删除两天前的开奖
	protected function delete2daykj(){
		$day = date('Y-m-d',time());
		$odaytime = strtotime($day)-86400*2;
		$map = [];
		$map['opentime'] = ['elt',$odaytime];
		M('kaijiang')->where($map)->delete();
	}
	protected function gettrano($rand=4){
		$rand = (intval($rand)>0 and intval($rand)<=6)?intval($rand):4;
		$trano = strtoupper(self::rand_string(3,0)).date('ymdHis').self::rand_string($rand,1);
		return $trano;
	}
	protected function rand_string($len=6,$type=0,$addChars='') {
		$String      = new \Org\Util\String;
		$randString  = $String->randString($len,$type,$addChars);
		return $randString;
	}
}