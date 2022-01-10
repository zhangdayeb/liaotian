$(document).ready(function () {
	$.fn.dalutoast = function (e) {
        $('<div class="dalutoast">' + e + "</div>").appendTo(document.body);
        var t = setTimeout(function () {
            $(".dalutoast").remove(), clearTimeout(t)
        }, 1500)
    }, $("#copyLink1").click(function (e) {
        var t = new Clipboard(".inviteHref");
        t.on("success", function (e) {
            $("body").dalutoast("复制房间号成功"), $("#bar1").blur()
        }), t.on("error", function (e) {
            $("body").dalutoast("亲，此浏览器不支持，请手动复制粘贴吧")
        })
    })
});