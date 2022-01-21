<?php
namespace Lib\lotterytimes;
class lhc {
	function drawtimes(){
		$name = 'lhc';
		$cjnowtime = cjnowtime($name);
		$nowtime = time() + $cjnowtime;
		$total  = 120;
		$openstart  = '00:05:00';
		$jgtime = 300;
		$yctime = 0;
		$_yct = ceil($yctime/$total);
		$date = getNextMonthDays(date('Y-m-d H:i:s',time()));
		$nextMonth = date("Y-m",strtotime($date[0]));
		$url1="http://1680660.com/smallSix/queryLotteryDate.do?ym=".date('Y-m');//获取当月开奖时间
		$url2="http://1680660.com/smallSix/queryLotteryDate.do?ym=".$nextMonth;//获取当月开奖时间

		$co1 = _curl($url1);
		$co2 = _curl($url2);
		$RES1 = json_decode($co1,true);
		$RES2 = json_decode($co2,true);
		$result1 = $RES1['result']['data']['kjDate'];
		$result2 = $RES2['result']['data']['kjDate'];
		//获取上一期开奖时间
		$last = M('Kaijiang')->field('opentime,expect')->where("name='lhc'")->order("id DESC")->limit(1)->select();
		foreach($result1 as $k=>$v){
			if($v[1]==0){
				unset($result1[$k]);
			}else{
				$results1[$v[0]] = $v;
			}
		}
		foreach($result2 as $k=>$v){ //下一个月
			if($v[1]==0){
				unset($result2[$k]);
			}else{
				$results2[$v[0]] = $v;
			}
		}
		$lastday = date('Ymd',$last[0]['opentime']);//获取最后台一期开奖日
		$a=1;
		foreach($results1 as $k=>$v){
			$k<10?$d='0'.$k:$d=$k;
			if(date("Ym$d")==$lastday){         //判断上期开奖日
				$nowday = date("Ym").current($results1)[0];//下一期
				$qihao = ($last[0]['expect']+1);
				if(date('m',$last[0]['opentime']) == 12 && count($results1) == $a && date('d')>20 ){ //判断跨年,
					$nowday = (date('Y')+1).'-1-'.reset($results2)[0];
					$qihao = (date('Y')+1)."001";
					$draws = array(
						$qihao => array('start'=>date("Y-m-d H:i:s",$last[0]['opentime']),'end'=>date("Y-m-d H:i:s",($last[0]['opentime']+strtotime($nowday)-strtotime($lastday))))
					);
				}else{
					$draws = array(
						$qihao => array('start'=>date("Y-m-d H:i:s",$last[0]['opentime']),'end'=>date("Y-m-d H:i:s",($last[0]['opentime']+strtotime($nowday)-strtotime($lastday))))
					);
				}
			}elseif(date("Ym$d")>$lastday){
				//判断跨月
				if(!empty($draws)){
					$starttime = end($draws)['end'];
					$endtime = date("Y-m-$d 21:30:00");
					$draws[] = array('start'=>$starttime,'end'=>$endtime);
				}else{
					$firstday = reset($results1)[0];
					$starttime = date("Y-m-d H:i:s",$last[0]['opentime']);
					$endtime = date("Y-m-$firstday 21:30:00");
					$draws[$last[0]['expect']+1] = array('start'=>$starttime,'end'=>$endtime);
				}
			}
			$a++;
		}
		foreach($results2 as $k=>$v){
			$starttime = end($draws)['end'];
			$endtime = date("$nextMonth-$k 21:30:00");
			$draws[] = array('start'=>$starttime,'end'=>$endtime);
		}
		ksort($draws);
		foreach($draws as $k=>$v){
			if($nowtime>strtotime($v['start']) && $nowtime<=strtotime($v['end'])){ //如果当前时间大于开始时间并且小于结束时间
				$nowqihao = $k;  //当前期号
			}
		}
		if(!$nowqihao){  //如果当前期号不存在
			$nowqihao = str_pad(1,3,0,STR_PAD_LEFT);
			$draws[1]['start']   = date('Y-m-d H:i:s',strtotime($draws[$total]['end']));
			$draws[1]['end']   = date('Y-m-d H:i:s',strtotime($draws[1]['end'])+86400);
			$nowdraws = [
				'expect'  => date('Ymd',strtotime($draws[1]['end'])).$nowqihao,
				'start'   => $draws[1]['start'],
				'end'     => $draws[1]['end']
			];
			$preqihao = str_pad($total,3,0,STR_PAD_LEFT);
			$predraws = [
				'expect' => date('Ymd',strtotime($draws[1]['start'])).$preqihao,
				'start'  => date('Y-m-d H:i:s',strtotime($draws[$total]['start'])),
				'end'    => date('Y-m-d H:i:s',strtotime($draws[$total]['end'])),
			];
		}else{   //如果当前期号存在
			$nowdraws = [
				'expect'  => $nowqihao,                //当前期号
				'start'  => $draws[$nowqihao]['start'],//当期开始时间
				'end'    => $draws[$nowqihao]['end'],  //当期结束时间
			];
			$preqihao = $nowqihao-1;
			$predraws = [
				'expect' => $preqihao,
				'start'  => $draws[$nowqihao]['start'],
				'end'    => $draws[$nowqihao]['end'],
			];
		}
		$return = [
			'lastFullExpect'  => $predraws['expect'],
			'lastExpect'      => substr($predraws['expect'],-3),
			'currFullExpect'  => $nowdraws['expect'],
			'currExpect'      => substr($nowdraws['expect'],-3),
			'remainTime'      => strtotime($nowdraws['end'])-time()-$cjnowtime,
			'openRemainTime'  => $cjnowtime,
		];
		return $return;
	}
}
?>