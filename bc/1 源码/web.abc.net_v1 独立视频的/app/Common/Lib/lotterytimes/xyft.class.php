<?php
namespace Lib\lotterytimes;
class xyft {
	function drawtimes(){
		$time=time();
		$time1=strtotime("00:00");
		
		$time2=strtotime("04:05");
		//var_dump($time2);
		
		$name = 'xyft';
		$cjnowtime = cjnowtime($name);
		$nowtime = $time+ $cjnowtime;
		
		$total  = 180;
		$openstart  = '13:04:00';
		$jgtime = 300;
		$yctime = 0;
		$_yct = ceil($yctime/$total);
		$array = array();
		for($i=1;$i<=$total;$i++){
			$start = strtotime($openstart)-$jgtime + ($i-1)*$jgtime + ($i-1)*$_yct;
			$end = strtotime($openstart)+($i-1)*$jgtime + ($_yct*$i);
			$draws[$i] = array('start'=>date('H:i:s',$start),'end'=>date('H:i:s',$end));
		}
		//dump($draws);die;
		$draws[1]['start'] = date('Y-m-d H:i:s',strtotime($draws[$total]['end'])-86400);
		//dump($nowtime );die;
		foreach($draws as $k=>$v){
			
			if($nowtime>strtotime($v['start']) && $nowtime<=strtotime($v['end'])){
				//dump($k);dump($v);die;
				$nowqihao = str_pad($k,3,0,STR_PAD_LEFT);
			//	dump($k);dump($nowqihao);die;
			}
		}//die;
		//dump($nowqihao);die;
		if(!$nowqihao){
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
		}else{
			$nowqihao = str_pad($nowqihao,3,0,STR_PAD_LEFT);
			$nowdraws = [
				'expect'  => date('Ymd',$nowtime).$nowqihao,
				'start'   => date('Y-m-d',$nowtime).' '.$draws[intval($nowqihao)]['start'],
				'end'     => date('Y-m-d',$nowtime).' '.$draws[intval($nowqihao)]['end']
			];
			if(intval($nowqihao)==1){
				$preqihao = str_pad($total,3,0,STR_PAD_LEFT);
				$nowexpecttime = strtotime($draws[$total]['end'])-86400;
				$predraws = [
					'expect' => date('Ymd',$nowexpecttime).$preqihao,
					'start'  => date('Y-m-d',$nowexpecttime).' '.$draws[intval($preqihao)]['start'],
					'end'    => date('Y-m-d',$nowexpecttime).' '.$draws[intval($preqihao)]['end'],
				];
			}else{
				$preqihao = str_pad($nowqihao-1,3,0,STR_PAD_LEFT);;
				$predraws = [
					'expect' => date('Ymd',$nowtime).$preqihao,
					'start'  => date('Y-m-d',$nowtime).' '.$draws[intval($preqihao)]['start'],
					'end'    => date('Y-m-d',$nowtime).' '.$draws[intval($preqihao)]['end'],
				];
			}
		}
		if($time>$time1 && $time<$time2){
			$ymd=substr($predraws['expect'],0,8);
			$qianyitian=strtotime($ymd)-86400;
			$qi=substr($predraws['expect'],8);
			$currExpect=date('Ymd',$qianyitian);
			$predraws['expect']=$currExpect.$qi;
			
		}
		$return = [
			'lastFullExpect'  => $predraws['expect']-1,
			'lastExpect'      => substr($predraws['expect'],-3),
			'currFullExpect'  => $predraws['expect'],
			'currExpect'      => substr($predraws['expect'],-3),
			'remainTime'      => strtotime($nowdraws['end'])-$time-$cjnowtime,
			'openRemainTime'  => $cjnowtime,
		];
		return $return;
	}
}
?>