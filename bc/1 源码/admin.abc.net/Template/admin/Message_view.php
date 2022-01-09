{include file="Public/meta" /}
<title>查看消息详情</title>
</head>
<body>
<article class="page-container">
		<div class="row cl">

            <div class="formControls col-xs-12 col-sm-12">
                <h1 style="text-align: center">{$info.Title}</h1>
            </div>
		</div>
    <hr/>
    <div class="row cl">

        <div class="formControls col-xs-12 col-sm-12">
            {$info.Message}
        </div>
    </div>


</article>

{include file="Public/footer" /}

</body>
</html>