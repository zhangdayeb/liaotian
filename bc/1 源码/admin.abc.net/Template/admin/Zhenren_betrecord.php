{include file="Public/meta" /}

<meta http-equiv="refresh" content="180">
</head>
<body>
获取<span class="nums">{$nums}</span>条{$code}投注记录,每3分钟自动获取一次 <button onclick="getData()" style="padding:5px 10px">刷新</button>
{include file="Public/footer" /}
<script>
function getData(){
	 window.location.reload();

}
$(function(){
	
	setTimeout("getData()",'180000');
});

</script>
</body>
</html>