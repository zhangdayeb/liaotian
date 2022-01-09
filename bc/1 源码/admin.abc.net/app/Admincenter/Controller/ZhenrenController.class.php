<?php
namespace Admincenter\Controller;
use Think\Controller;
class ZhenrenController extends Controller {
	
	function merchant(){
		$api = new  \Org\Util\Biapi();
		$data=$api->BusinessBalance();
		if($data &&$data['retCode']==0){
			$data=$data['retMsg'][0];
		}else{
			die("获取出错");
		}
		//var_dump($data);
		/* $BbinService=new \Org\Util\BbinService();
		 $ret=$BbinService->credit();
		 if($ret&&$ret['Code']==0){
			  $bbcredit=$ret['Data']['Credit'];
		 }else{
			 $bbcredit="---";
		 }
		
		 $AgService=new \Org\Util\AgService();
		 $ret=$AgService->credit();
	
		 if($ret&&$ret['Code']==0){
			  $agcredit=$ret['credit'];
		 }else{
			 $agcredit="---";
		 }
		 $LegService=new \Org\Util\LegService();
		 $ret=$LegService->credit();
	
		 if($ret&&$ret['Code']==0){
			  $legcredit=$ret['credit'];
		 }else{
			 $legcredit="---";
		 }
		 
		$this->assign('bbcredit',$bbcredit);
		$this->assign('legcredit',$legcredit);
		$this->assign('agcredit',$agcredit);*/
		$this->assign('data',$data);
		$this->display();
	}
	function transrecord(){
		$condition=array();
		$transType=I("transType");
		$sDate=I("sDate");
		$eDate=I("eDate");
		
		if($transType){
			$condition['trans.transType']=$transType;
			$this->assign('transType',$transType);
		}
		$username=I("username");
		if($username){
			$condition['mem.username']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['trans.transTime']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['trans.transTime']=array("egt",$sDate);
		}elseif($eDate){
			$condition['trans.transTime']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		$count      = D("Transrecord")->alias("trans")->join("caipiao_member mem on mem.id=trans.uid")->where($condition)->count();
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Transrecord")->alias("trans")->join("caipiao_member mem on mem.id=trans.uid")->where($condition)->order("trans.transID desc")->select();
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();
	}
	
	function agztreport(){
	
	
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['PlayerName']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['WagersDate']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['WagersDate']=array("egt",$sDate);
		}elseif($eDate){
			$condition['WagersDate']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		$count      = D("Agbetrecord")->where($condition)->group("PlayerName")->count();
	
		
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Agbetrecord")->field("PlayerName,count(*) nums,sum(NetAmount) TNetAmount,sum(ValidBetAmount) TValidBetAmount,sum(BetAmount) TBetAmount")->where($condition)->group("PlayerName")->select();

		
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();

	}
	
	function bbtzreport(){
		
		
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['UserName']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['BetTime']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['BetTime']=array("egt",$sDate);
		}elseif($eDate){
			$condition['BetTime']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		
		$count      = D("Bbbetrecord")->where($condition)->group("UserName")->count();
		
	
		
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Bbbetrecord")->field("UserName,count(*) nums,sum(Payoff) TNetAmount,sum(BetAmount) TValidBetAmount,sum(BetAmount) TBetAmount")->where($condition)->group("UserName")->select();
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();
	

	}
    
	function sstzreport(){
		
		
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['account_code']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['date_created']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['date_created']=array("egt",$sDate);
		}elseif($eDate){
			$condition['date_created']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		
		$count      = D("Ssbetrecord")->where($condition)->group("account_code")->count();
		
	
		
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Ssbetrecord")->field("account_code,count(*) nums,sum(win_amt) TNetAmount,sum(wager_stake) TValidBetAmount")->where($condition)->group("account_code")->select();
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();
	

	}

	function ztrecord(){
	
	
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['username']=$username;
			$this->assign('username',$username);
		}
		$type=I("type");
		if($type){
			$condition['type']=$type;
			$this->assign('type',$type);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['betTime']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['betTime']=array("egt",$sDate);
		}elseif($eDate){
			$condition['betTime']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		$count      = D("zrbetrecord")->where($condition)->count();
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("zrbetrecord")->where($condition)->order("id desc")->select();
		
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();

	}
	
	function bbtzrecord(){
		
		
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['UserName']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['BetTime']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['BetTime']=array("egt",$sDate);
		}elseif($eDate){
			$condition['BetTime']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		$count      = D("Bbbetrecord")->where($condition)->count();
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Bbbetrecord")->where($condition)->order("bbId desc")->select();
		
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();
	

	}
	function sstzrecord(){
	
	
		$condition=array();
		
		$sDate=I("sDate");
		$eDate=I("eDate");
		
	   
		$username=I("username");
		if($username){
		
			$condition['account_code']=$username;
			$this->assign('username',$username);
		}
		if($sDate){
			$this->assign('sDate',$sDate);
			$sDate=date("$sDate 00:00:00");
		}
		if($eDate){
			$this->assign('eDate',$eDate);
			$eDate=date("$eDate 23:59:59");
			
		}
		if($sDate&&$eDate){
			$condition['date_created']=array(array("egt",$sDate),array("elt",$eDate),"and");
		}elseif($sDate){
			$condition['date_created']=array("egt",$sDate);
		}elseif($eDate){
			$condition['date_created']=array("elt",$eDate);
		}
		
		
		$_pagasize  = 10;
		$count      = D("Ssbetrecord")->where($condition)->count();
		$Page       = new \Think\Page($count,$_pagasize);
		$show       = $Page->show();
		$dataList=D("Ssbetrecord")->where($condition)->order("ssId desc")->select();
		
		$this->assign('totalcount',$count);
		$this->assign('list',$dataList);
		$this->assign('page',$show);
		$this->display();

	}
	
	
	function getrecords(){
		$this->display();
		

	}
	
	public function betrecord(){
			$db=M('zrbetrecord');
			$time=time();
			$platformCode=I('code');
			if(!in_array($platformCode,['ag','bb','ky','ss']))exit('code 错误');
			//获取12小时的记录
			$start_time=$time-60*60*12;
			$end_time=$time;
			//最新100条
			$limit='100';
			$page_index=0;
		  //获取下注记录
		   $obj=new \Org\Util\Biapi();
		   $list=$obj->GetMerchantReport($platformCode,$start_time,$end_time,$time,$page_index,$limit);
		   //var_dump($list);die;
		   $data=[];
		   if($list){

			   if($platformCode=='ag'){
				    foreach($list['data'] as $v){
						$betOrderNo=$v['betOrderNo'];
						   preg_match("/([0-9]{10})/",$v['betTime'],$betTime);
						   if(!$db->where(['betOrderNo'=>$betOrderNo])->find()){
								$data[]=['username'=>$v['username'],
								'betAmount'=>$v['betAmount'],
								'validBetAmount'=>$v['validBetAmount'],
								'winAmount'=>$v['winAmount'],
								'netPnl'=>$v['netPnl'],
								'betTime'=>$betTime[1],
								'gameCode'=>$v['gameCode'],
								'betOrderNo'=>$betOrderNo,
								'type'=>$platformCode
								];
						   }
					
					}
			   }
			    if($platformCode=='bb'){
				    foreach($list['data'] as $v){
						$betOrderNo=$v['WagersID'];
						   preg_match("/([0-9]{10})/",$v['WagersDate'],$betTime);
						   if(!$db->where(['betOrderNo'=>$betOrderNo])->find()){
								$data[]=['username'=>$v['UserName'],
								'betAmount'=>$v['BetAmount'],
								'validBetAmount'=>$v['Commissionable'],
								'winAmount'=>$v['Payoff'],
								'netPnl'=>$v['Payoff'],
								'betTime'=>$betTime[1],
								'gameCode'=>$v['GameType'],
								'betOrderNo'=>$betOrderNo,
								'type'=>$platformCode
								];
						   }
					
					}
				   
			   }
			   
			   if($platformCode=='ky'){
				    foreach($list['data'] as $v){
						$betOrderNo=$v['WagersID'];
						   preg_match("/([0-9]{10})/",$v['time'],$betTime);
						   if(!$db->where(['betOrderNo'=>$betOrderNo])->find()){
								$data[]=['username'=>$v['player_name'],
								'betAmount'=>$v['bet'],
								'validBetAmount'=>$v['bet'],
								'winAmount'=>$v['win'],
								'netPnl'=>$v['win'],
								'betTime'=>$betTime[1],
								'gameCode'=>$v['game_id'],
								'betOrderNo'=>$betOrderNo,
								'type'=>$platformCode
								];
						   }
					
					}
				   
			   }
			   
			   
			   if($platformCode=='ss'){
				   exit('体育无法采集');
				  // dump($list);die;
				    foreach($list['data'] as $v){
						$betOrderNo=$v['transactionid'];
						   preg_match("/([0-9]{10})/",$v['BetTime'],$betTime);
						   if(!$db->where(['betOrderNo'=>$betOrderNo])->find()){
								$data[]=['username'=>$v['account_code'],
								'betAmount'=>$v['BetAmount'],
								'validBetAmount'=>$v['ValidBet'],
								'winAmount'=>$v['BetOnWin'],
								'netPnl'=>$v['BetOnWin'],
								'betTime'=>$betTime[1],
								'gameCode'=>$v['GameName'],
								'betOrderNo'=>$betOrderNo,
								'type'=>$platformCode
								];
						   }
					
					}
				   
			   }
			  
			$db->addAll($data);
		   }
			$this->assign('nums',count($list['data']));
			$this->assign('code',$platformCode);
		   $this->display();
		
	}
	
	public function Bbbetrecord(){
		
		  
		   $this->display();
		
	}
	public function Ssbetrecord(){
		
		  
		   $this->display();
		
	}
	public function Kybetrecord(){
		
		  
		   $this->display();
		
	}
	
	
	public function getAgRecord(){
		 date_default_timezone_set("UTC");
		    $n=0;
		   $startDate=date("Y-m-d 00:00:00");
		   $endDate=date("Y-m-d H:i:s");
		   $AgService=new \Org\Util\AgService();
		   $recordList=$AgService->betrecord($startDate,$endDate,1,500);
		   $zxrecordList=$recordList['Data']["Records"];
		   $dataList=array();
		   try{
			  foreach($zxrecordList as $record){
				  
				   $BillNo=$record['BillNo'];
				  //判断记录是否存在
				   $enx=D("Agbetrecord")->where(array("BillNo"=>$BillNo))->count();
				   if(empty($enx)){
					   $n++;
					   $dataList[]=array("DataType"=>$record['DataType'],"BillNo"=>$record['BillNo'],"NetAmount"=>$record['NetAmount'],
						"GameType"=>$record['GameType'],"BetAmount"=>$record['BetAmount'],
						"ValidBetAmount"=>$record['ValidBetAmount'],"Flag"=>$record['Flag'],"BetTime"=>$record['BetTime']
						,"TableCode"=>$record['TableCode'],"RecalcuTime"=>$record['RecalcuTime'],"LoginIP"=>$record['LoginIP'],
						"PlayerName"=>$record['PlayerName'],"AgentCode"=>$record['AgentCode'],"GameCode"=>$record['GameCode'],
						"CreateDate"=>$record['CreateDate'],"Round"=>$record['Round'],"BeforeCredit"=>$record['BeforeCredit']);
						
				   }
			   }
		       D("Agbetrecord")->addAll($dataList); 
	
		   }catch(Exception $e){
			   $n=0;
		   }
		   $ret=array('code'=>1,"nums"=>$n);
		   $this->ajaxReturn($ret);
	}
		 
	 public function getBbrecord(){//获取下注记录
	     date_default_timezone_set("UTC");
	       $n=0;
		   $nDate=date("Y-m-d");
		   $nTime=date("H:i:s");
		   $BbinService=new \Org\Util\BbinService();
		   $recordList=$BbinService->getGameRecord($nDate, "00:00:00" , $nTime, 3,'','',1,500);
		   $zxrecordList=$recordList['Data'];
		   $dataList=array();
		   try{
			  foreach($zxrecordList as $record){
				  
				   $WagersID=$record['WagersID'];
				  //判断记录是否存在
				   $enx=D("Bbbetrecord")->where(array("WagersID"=>$WagersID))->count();
				   if(empty($enx)){
					   $n++;
					   $dataList[]=array("UserName"=>$record['UserName'],"WagersID"=>$record['WagersID'],
						"WagersDate"=>$record['WagersDate'],"SerialID"=>$record['SerialID'],
						"RoundNo"=>$record['RoundNo'],"GameType"=>$record['GameType'],"WagerDetail"=>$record['WagerDetail']
						,"GameCode"=>$record['GameCode'],"Result"=>$record['Result'],"Card"=>$record['Card'],
						"BetAmount"=>$record['BetAmount'],"Origin"=>$record['Origin'],"Commissionable"=>$record['Commissionable'],
						"Payoff"=>$record['Payoff'],"ExchangeRate"=>$record['ExchangeRate']);
						
				   }
			   }
		       D("Bbbetrecord")->addAll($dataList); 
		   }catch(Exception $e){
			   $n=0;
		   }
		   $ret=array('code'=>1,"nums"=>$n);
		   $this->ajaxReturn($ret);
		  
		
	}

	public function getSsRecord(){
		 date_default_timezone_set("UTC");
		    $n=0;
		   $startDate=date("Y-m-d 00:00:00");
		   $endDate=date("Y-m-d H:i:s");
		   $AgService=new \Org\Util\SsService();
		   $recordList=$AgService->betrecord($startDate,$endDate,1,500);
		   $zxrecordList=$recordList['Data']["Records"];
		   $dataList=array();
		   try{
			  foreach($zxrecordList as $record){
				  
				   $transactionid=$record['transactionid'];
				  //判断记录是否存在
				   $enx=D("Ssbetrecord")->where(array("transactionid"=>$transactionid))->count();
				   if(empty($enx)){
					   $n++;
					   $dataList[]=array("play_type"=>$record['play_type'],"transactionid"=>$record['transactionid'],"account_code"=>$record['account_code'],
						"date_created"=>$record['date_created'],"match_index"=>$record['match_index'],
						"bet_type_code"=>$record['bet_type_code'],"Team_bet_code"=>$record['Team_bet_code'],"handicap"=>$record['handicap'],"wager_odds"=>$record['wager_odds'],"odds_type"=>$record['odds_type'],"wager_stake"=>$record['wager_stake'],"win_amt"=>$record['win_amt'],
						"final_stake"=>$record['final_stake'],"ref_id"=>$record['ref_id'],"playtype_index"=>$record['playtype_index'],
						"league_name"=>$record['league_name'],"teamA_name"=>$record['teamA_name'],"teamB_name"=>$record['teamB_name'],"final_score"=>$record['final_score'],"prefix_code"=>$record['prefix_code']);
						
				   }
			   }
		       D("Ssbetrecord")->addAll($dataList); 
	
		   }catch(Exception $e){
			   $n=0;
		   }
		   $ret=array('code'=>1,"nums"=>$n);
		   $this->ajaxReturn($ret);
	}
		 
	
	}