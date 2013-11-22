var t = 0;
var timer;

function rnd() {
	var l = $("#list").val().replace(/ +/g, " ").replace(/^ | $/g, "").split(" ");
	if (l.length == 1) return alert("没有人会上来～");
	if (!t) {
		$("h1").html($("h1")[0].innerHTML.replace("！", "？"));
		$("#btn").val("停止");
		timer = setInterval(function () {
			var r = Math.ceil(Math.random() * l.length);
			$("#what").html(l[r - 1]);
			var rTop = Math.ceil(Math.random() * $(document).height());
			var rLeft = Math.ceil(Math.random() * ($(document).width() - 50));
			var rSize = Math.ceil(Math.random() * (37 - 14) + 14);
			$("<span></span>").html($("#what").html()).addClass("temp").hide().css({
				"top": rTop,
				"left": rLeft,
				"color": "rgba(0,0,0,." + Math.random() + ")",
				"fontSize": rSize + "px"
			}).appendTo("#wrapper").fadeIn("slow", function () {
				$(this).fadeOut("slow", function () {
					$(this).remove();
				});
			});
		}, 50);
		t = 1;
	} else {
		$("h1").html($("h1")[0].innerHTML.replace("？", "！"));
		$("#btn").val("开始");
		clearInterval(timer);
		t = 0;
	}
}

function cfg() {
	t ? alert("你想干什么？") : $("#popbox-wrapper").fadeIn();
}

function cls() {
	$("#popbox-wrapper").fadeOut();
}

document.onkeydown = function enter(e) {
	var e = e || event;
	if (e.keyCode == 13 && $("#popbox-wrapper").css("display") == "none") {
		rnd();
	}
}
