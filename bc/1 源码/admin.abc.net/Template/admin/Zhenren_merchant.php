{include file="Public/meta" /}
<title>真人商户信息管理</title>
</head>
<body>
<nav class="breadcrumb">

<a class="btn btn-success radius r btn-refresh" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<div class="mt-5">
    <form method="post" action="">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		
		<tbody>
			
          <tr class="text-c">
			
                <td>AG余额</td>
				<td>{$data['AG']}</td>
				
			</tr>
			<tr class="text-c">
			
                <td>KY余额</td>
				<td>{$data['KY']}</td>
				
			</tr>
			  <<tr class="text-c">
			
                <td>BBIN余额</td>
				<td>{$data['BB']}</td>
				
			</tr>
			
			<tr class="text-c">
			
                <td>ss余额</td>
				<td>{$data['SS']}</td>
				
			</tr><!--
			
			<tr class="text-c">
			
                <td>EG余额</td>
				<td>{$data['EG']}</td>
				
			</tr>
			<tr class="text-c">
			
                <td>OG余额</td>
				<td>{$data['OG']}</td>
				
			</tr>
			
			<tr class="text-c">
			
                <td>MT余额</td>
				<td>{$data['MT']}</td>
				
			</tr>
			
			<tr class="text-c">
			
                <td>MW余额</td>
				<td>{$data['MW']}</td>
				
			</tr>
			<tr class="text-c">
			
                <td>SA余额</td>
				<td>{$data['SA']}</td>
				
			</tr>
			<tr class="text-c">
			
                <td>AB余额</td>
				<td>{$data['AB']}</td>
				
			</tr>
			<tr class="text-c">
			
                <td>BG</td>
				<td>{$data['BG']}</td>
				
			</tr>
           <tr class="text-c">
			
                <td>IG余额</td>
				<td>{$data['IG']}</td>
				
			</tr>-->
		</tbody>
	</table>

    </form>
	</div>
</div>
{include file="Public/footer" /}
</body>
</html>