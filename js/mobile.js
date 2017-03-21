$(function(){
	$("#sidebar").remove();
	if(screen.width <= 600){
		$("img:not(.aligncenter)").remove();
	}
var wrapper = $("#wrapper");
$(".top_menu_btn").click(function(){
var dmp=wrapper.attr("data-menu-position");
if(dmp == "open"){//如果菜单是打开状态
wrapper.attr("data-menu-position","close");//将内容元素的自定义属性值设置为关闭
$("#wap_menu_all").css({transform: "translate(0px,-100%)",transition:"all 0.4s"});//将菜单元素的顶部间距设置为隐藏状态，即跑到九霄云外
}else if(dmp == "close"){//如果菜单是关闭状态
$("#wap_menu_all").css({display:"block"});//则将菜单的属性设置为显示（一般用于初次初始化使用）
$("#wap_menu_all").css({transform: "translate(0px,0%)",transition:"all 0.4s"});//然后让其距离顶部至原生距离，即显示效果
wrapper.attr("data-menu-position","open");//将内容元素的自定义属性值设置为打开
}
});
$("#wap_menu_all a").click(function(){
console.log("此时说明测试到了点击");
var dmp=wrapper.attr("data-menu-position");
console.log(dmp+"此时显示的是实时监测的状态");
if(dmp == "open"){//如果菜单是打开状态
console.log("此时应该是可以执行了");
wrapper.attr("data-menu-position","close");//将内容元素的自定义属性值设置为关闭
$("#wap_menu_all").css({transform: "translate(0px,-100%)",transition:"all 0.4s"});//将菜单元素的顶部间距设置为隐藏状态，即跑到九霄云外
console.log("此时执行完毕");
}
});
})