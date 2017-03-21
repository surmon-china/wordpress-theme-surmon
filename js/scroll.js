$(function(){
	//定义获取图片函数
	function findQrCode(){
			//获取当前页面二维码地址
			var nowUrlQrCodeSrc = 'http://qr.liantu.com/api.php?&bg=eeeeee&w=150&fg=aaaaaa&el=m&m=5&text='+ window.location.href ;
			var tophtml="<div id=\"izl_rmenu\" class=\"izl-rmenu\"><a href=\"tencent://Message/?Uin=794939078&websiteName=surmon.me=&Menu=yes\" target=\"_blank\" class=\"btn btn-qq\"><i class=\"fa fa-comments\"></i></a><div class=\"btn btn-wx\"><i class=\"fa fa-qrcode\"></i><img class=\"pic\" src=\""+ nowUrlQrCodeSrc + "\" /></div><div class=\"btn btn-top\"><i class=\"fa fa-chevron-up\"></i></div></div>";
			$("#top").html(tophtml);
			$("#izl_rmenu").each(function(){
				$(this).find(".btn-wx").mouseenter(function(){
					$(this).find(".pic").fadeIn("fast");
				});
				$(this).find(".btn-wx").mouseleave(function(){
					$(this).find(".pic").fadeOut("fast");
				});
				$(this).find(".btn-phone").mouseenter(function(){
					$(this).find(".phone").fadeIn("fast");
				});
				$(this).find(".btn-phone").mouseleave(function(){
					$(this).find(".phone").fadeOut("fast");
				});
				$(this).find(".btn-top").click(function(){
					$("html, body").animate({
						"scroll-top":0
					},"fast");
				});
			});
	}
	findQrCode();
	$('#container').ajaxComplete(findQrCode);

	//返回顶部按钮事件
	var lastRmenuStatus=false;
	$(window).scroll(function(){
		var _top=$(window).scrollTop();
		if(_top>300){
			$("#izl_rmenu").data("expanded",true);
		}else{
			$("#izl_rmenu").data("expanded",false);
		}
		if($("#izl_rmenu").data("expanded")!=lastRmenuStatus){
			lastRmenuStatus=$("#izl_rmenu").data("expanded");
			if(lastRmenuStatus){
				$("#izl_rmenu .btn-top").slideDown();
			}else{
				$("#izl_rmenu .btn-top").slideUp();
			}
		}
	});

	//全局链接点击后自动回顶部事件
	//Ajax请求成功后自调
	$('#container').ajaxComplete(clickTotop);
	function clickTotop(){
		$('a[target!=_blank][noajax!=true]').click(function(){
			$("html, body").animate({
				"scroll-top":0
			},"fast");
		});
	}
	//加载完成自调
	clickTotop();

	
	//定义侧边栏自动浮动事件
	//添加ajax重载事件
	$('#container').ajaxComplete(asideScroll);
	function asideScroll(){
		//定义侧边栏自动浮动事件
	    //找到要浮动的元素  
	    var $sidebarFixed = $("#sidebar_fixed");
	    //计算出此元素的高度
	    var sidebarFixedHeight = parseInt($sidebarFixed.height());
	    //检测此元素相对于文档Document原点的绝对位置，并且这个值是不变化的
	    var sidebarFixedDocHeight = parseInt($sidebarFixed.offset().top);
	    //获取顶部偏移值,定义为顶部的偏移值高度
	    var topPadding = 135;
	    //获取底部栏目距离顶部的距离，用来判断和浮动元素之间的距离关系,这个值是固定的，网页加载完就可以获取
	    var footerDocHeight = parseInt($("#footer").offset().top); 
	    $(window).scroll(function() { //给全局窗口即浏览器窗口绑定滚动触发事件
	    	//解决特殊情况BUG，判断边栏在显示时才生效
			if ($('#sidebar').css('display') != 'none') {
		        	//并且这个距离小于底部通栏距离顶部的距离（即边栏的浮动范围则执行下面
		            if (footerDocHeight >= $(window).scrollTop() - topPadding + sidebarFixedDocHeight) {
		                //实时的需要的高度应该是：
		                //滚动条高度 - 默认文档距顶绝对位置 （此时结果应该为一个随着滚动条移动的相对数，保持为0，故） +  顶部的偏移值
		                //此处赋值是为了给回弹事件使用
		                var nowMarginTop = $(window).scrollTop() - sidebarFixedDocHeight + topPadding;
		                if (nowMarginTop > 0) {
		                	$sidebarFixed.css({ top: '125px','position':'fixed',marginTop:0});
		                	$sidebarFixed.attr('data-fixed',nowMarginTop);
		                }
		                if(nowMarginTop <= 0){
		                	$sidebarFixed.css({ top: '0px','position':'relative',marginTop:0});
		                	$sidebarFixed.attr('data-fixed',0);
		                }
		            }else{ 
		            	//获取到预存储在H5标签中的变量
		            	var sidebarFixedMarginTop = $sidebarFixed.attr('data-fixed');
		            	$sidebarFixed.css({position:'relative',top:0,marginTop:sidebarFixedMarginTop +'px'});
		        	}
		        }
	    });
	}
	//加载完成自调
	asideScroll();

});
console.log("%c Yesterday  You  said  tomorrow %c Just do it .", "color:#666;font-weight:400;font-size:45px;font-family:Century Gothic;letter-spacing: 0.2px;","color:#666;font-size:13px;font-family:Century Gothic;letter-spacing: 0.1px;")