<script>	
	//投注页面记录切换
	$('.touzhu_tab li.li').click(function(){
		
			var i = $(this).index();//下标第一种写法
            $(this).addClass('li_curr').siblings().removeClass('li_curr');
			//内容切换
			 $('.game_body').removeClass('game_body_curr').eq(i).addClass('game_body_curr');
			 //获取记录 插入
			 $.ajax({
				  url: '/apijiekou.gettouzhulog.do',
				  type: 'post',
				  dataType: 'json', 
					data:{'name':cpname},			  
				  success: function (data) {
					//循环
					if(data.sign==true){
						html='<div data-tab-panel-1 class="am-tab-active "><div data-am-widget="list_news" class="am-list-news am-list-news-default" ><div class="am-list-news-bd"><ul class="am-list">';

						data=data.data;
						for(var j = 0,len = data.length; j < len; j++){
							//alert(data[j]['id'])
							html+='<li class="am-g am-list-item-dated" style="font-size:14px;margin:10px 0px;">';
							
							html+='<p class="am-cf"><span class="what_type am-fl">'+data[j]['cptitle']+'('+data[j]['expect']+'期)</span>';
									if(data[j]['isdraw']==0)
										html+='<em class="money am-fr" style="color:#666" >未开奖</em></p>';
									if(data[j]['isdraw']==1)
										html+='<em class="money am-fr" style="color:red" >已中奖</em></p>';
									if(data[j]['isdraw']==-1)
										html+='<em class="money am-fr" style="color:green" >未中奖</em></p>';
									if(data[j]['isdraw']==-2)
										html+='<em class="money am-fr" style="color:green" >已撤单</em></p>';
							html+='<p class="am-cf billrecord_time" style="font-size:14px"><span class="what_type am-fl"><font style="color:red;">投注号码：</font><hr>'+data[j]['playtitle']+'--('+data[j]['tzcode']+')</span></p>';
							html+='<p class="am-cf billrecord_time" style="font-size:14px"><span class="what_type am-fl">金额:'+data[j]['amount']+',注数:'+data[j]['itemcount']+',中奖金:'+data[j]['okamount']+',中注数:'+data[j]['okcount']+'</span>'
									if(data[j]['isdraw']==0)html+='<var class="money am-fr" style="color:red; font-style:normal" onClick="Order_chedan(\''+data[j]['id']+'\',\''+data[j]['trano']+'\',this)" >撤单</var>';
							html+='</p>';
						}
							html+='</li>';
						html+='	</ul></div></div></div>';
						$('#touzhu_log_body').html(html)
					}else{
						alert(data.message)
					}
						
					},
				  fail: function (err) {
						alert('数据获取失败请稍候重试')
				  }
			  
			})
	})
//获取余额
$('#user_money').html('{$userinfo.balance}');
setInterval('getUserMoeny()',10000);
var i=0;
$('#user_money').click(function(){
		i++;
		if(i%2==0){
			getUserMoeny();
		}else{
			$('#user_money').html('***');
		}
		

});
function getUserMoeny(){
	if(i%2==0 ||i==0){
	 $.ajax({
				  url: '/apijiekou.getUserMoeny.do',
				  type: 'post',
				  dataType: 'json', 		  
				  success: function (data) {
					
					if(data.sign==true){
						$('#user_money').html(data.data.balance);
					}else{
						alert(data.data.message)
					}
						
					},
				  fail: function (err) {
						alert('数据获取失败请稍候重试')
				  }
			  
			})
	
	}
}


</script>