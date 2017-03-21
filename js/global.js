/**
	*Global
*/
(function($, options){
	$(function(){

		//初始化事件
		init();

		//快捷键提交评论
		$(document).keypress(function(e){
			var s = $('#respond #submit');
			if( e.ctrlKey && e.which == 13 || e.which == 10 ){ 
				s.click();
				document.body.focus();
				return;
			}
			if( e.shiftKey && e.which==13 || e.which == 10 ) s.click();
		});

	//启动事件
	function init(){//回调函数内重调其他构造函数
		tooltip();//提示工具
		comment_cookie();//评论cookie
		ajax_comment();//评论AJAX
		smiley_box();//评论表情框框
		ajax();//全站ajax
		slides();//幻灯片
	}

	//配置幻灯片
	function slides(){
		var set = function(){
			var s = $('.slides .owl-pagination > div');//获取到div
			s.css( 'width', 100 / s.length + '%' );
		}
		$('.slides').owlCarousel({
			slideSpeed: 300,//速度，0.3秒一张图
			paginationSpeed: 400,//
			singleItem: true,
			autoPlay: true,//自动播放OK
			afterUpdate: set,
			afterInit: set
		});
	}

	//评论表情框
	function smiley_box(){
		var smb = $('#smileybox'),
			ajax = $('.smiley i.fa'),
			i = $('#respond .smiley i');
		ajax.unbind('click');
		i.unbind('click');
		ajax.one('click', function(){
			$.get( options['admin-ajax'] + '?action=ajax_data_smiley', function( data ){
				smb.html( data );
			});
		});
		i.click(function(){
			smb.slideToggle(200);
			return false;
		});
		$(document).click(function(){
			smb.slideUp(200);
		});			
	}

	//Tooltip
	function tooltip(){//函数开始
		if( !options['tooltip'] ) return;//如果tooltip没有被开启，则直接反馈空，即什么都不生效
		s = $('.picbox:not(.slides .picbox),.sidebar_tag a,.main_title a,.post_meta a,.context.main p a,.related-posts ul li span a,.share a,.pagenavi a,.postmeta a,.archive-header a.rss,.widget_readers a,.widget_tags a');
		//捕捉到所有适合的和排除掉不适合的a标签的dom元素，将其存储为s
		$(s).unbind('mouseover');//清空s绑定的鼠标移入事件
		$(s).unbind('mouseout');//清空S绑定的鼠标移出事件
		$('#tooltip').remove();//清空tooltip元素
		$(s).mouseover(function(){//给s元素绑定鼠标移入事件
			if( !this.title ) return;//假如当前元素即（被包装过的s元素）的值为空，则反馈空白，即毛线都没有
			$(this).data('tptitle', this.title);//貌似是创建一组数据，将S元素的title属性存储给tptitle
			this.title = '';//然后清空s元素的title元素
			$('body').append( '<div id="tooltip">'+ $(this).data('tptitle') +'</div>' );
			//给body即页面元素添加整体div，此div中包含其title的文字内容
			$('#tooltip').css({//给tootip的div添加css，注意css的格式
				'left': $(this).offset().left + $(this).outerWidth( false ) / 2 - $('#tooltip').outerWidth( false ) / 2,
					//此div距离等于文档的宽度距离的一般减去自己宽度的一半，即自己的中心点也就是文档区域的中心点
				'top': $(this).offset().top - 8
					//此div距离顶部的距离的为文档元素的顶部8像素的位置
			});
		});
		$(s).mouseout(function(){//绑定s元素的鼠标移出事件
			if( !$(this).data('tptitle') ) return;//如果title的属性为空也就是说上面已经反馈空白，则此时亦返回空白
			$('#tooltip').remove();//同时删除掉这个div
			this.title = $(this).data('tptitle');//然后将title的值重新赋予此s元素本身
		});
	}

	//缓存评论 Cookie
	function comment_cookie(){
		var a = $('#author'),
			e = $('#email'),
			u = $('#url');
		if( a.val() || e.val() || u.val() ) return;
		function getCookie( name ){
			name = name+'_'+options['cookiehash']
			var arr = document.cookie.split('; ');
			var i = 0;
			for( i=0; i<arr.length; i++ ){
				var arr2 = arr[i].split('=');
				if( arr2[0]==name ) return unescape(decodeURI(arr2[1]));
			}
			return '';
		}
		a.val( getCookie('comment_author') );
		e.val( getCookie('comment_author_email') );
		u.val( getCookie('comment_author_url') );
	}

	//Ajax
	function ajax(){
		if( !window.history || !window.history.pushState || !options['ajax'] ) return;
		$('a.comment-reply-link,.archive-header a.rss').attr( 'noajax', true );
		var ajaxClick = $('a[target!=_blank][noajax!=true]'),
			nav = $('#topmenu li a,#bottommenu li a'),
			ajaxSearch = $('form.search-form'),
			url,
			data;
		ajaxClick.unbind( 'click' );
		ajaxSearch.unbind( 'submit' );
		nav.click(function(){
			nav.each(function(){
				$(this).parent('li').removeClass('current current-menu-item current-menu-parent current_page_item current-post-ancestor');
			});
			$(this).parent('li').addClass('current');
		});
		ajaxSearch.submit(function(){
			url = $(this).attr('action');
			data = $(this).serialize() + '&action=ajax_container';
		});
		ajaxClick.click(function(){
			url = $(this).attr('href');
			data = 'action=ajax_container';
		});
		var func = function(){
			if( this.hostname && ( this.pathname.indexOf('/wp-admin/') != -1 || this.hostname != document.domain ) ) return;
			$('#container').fadeTo( 500, 0.3 );
			$('body').animate({
				scrollTop: 0
			}, 120 );
			$.ajax({
				url: url,
				data: data,
				type: 'GET',
				success: function( data ){
					$('#container').fadeTo( 200, 1 );
					$('#container').html( data );
					url = url.replace( '?action=ajax_container', '' );
					var state = {
						url: url,
						title: title,
						html: data
					};
					history.pushState( state, '', url );
					$('.fixedbox .qrcodeimg').html( qrcode );
					document.title = title;
					window.addEventListener( 'popstate', function( e ){
						if( e.state ){
							document.title = e.state.title;
							$('#container').html( e.state.html );
						}
						$('body').animate({
							scrollTop: 0
						}, 120 );
					});
					var hash = window.location.hash; 
					if( hash && $(hash).length != 0 && $(hash).offset().top ){
						$('body').animate({
							scrollTop: $(hash).offset().top
						}, 120 );
					}
					init();
				},
				error: function(){
					$('#container').fadeTo( 200, 1 );
					alert( options['ajax_error'] );
				}
			});
			return false;
		}
		ajaxClick.click( func );
		ajaxSearch.submit( func );
	}

	/**
	 * WordPress jQuery-Ajax-Comments v1.0 by Bigfa.
	 * URI: http://fatesinger.com/jquery-ajax-comments
	 * Thanks Willin Kan
	 * Require Jquery 1.7+
	 */
	function ajax_comment(){
		if( !options['ajax_comm'] ) return;
		var $commentform = $('#commentform'),	   
			txt1 = '<div class="clear"></div><div id="loading">'+options['commentloading']+'...</div>',
			txt2 = '<div id="error">#</div>',
			txt3 = '">'+options['commentsuccess'], 
			num = 0,
			comm_array =[],
			$comments = $('#comments-title'),
			$cancel = $('#cancel-comment-reply-link'),
			cancel_text = $cancel.text(),
			$submit = $('#commentform #submit'); $submit.attr('disabled', false),
			$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		$('#comment').after( txt1 + txt2 ); $('#loading').hide(); $('#error').hide();
		
		/** submit */
		$(document).off('submit', '#commentform');
		$(document).on("submit", "#commentform",
		function() {
			editcode();
			$('#loading').slideDown();
			$submit.attr('disabled', true).fadeTo('slow', 0.5);
			/** Ajax */
			$.ajax( {
				url: options['admin-ajax'],
				data: $(this).serialize() + "&action=ajax_comment",
				type: $(this).attr('method'),

				error: function(request) {
					$('#loading').slideUp();
					$('#error').slideDown().html(request.responseText);
					setTimeout(function() {$submit.attr('disabled', false).fadeTo('slow', 1); $('#error').slideUp();}, 3000);
					},

				success: function(data) {
					
					$('#loading').hide();
					comm_array.push($('#comment').val());
					$('textarea').each(function() {this.value = ''});
					var t = addComment, cancel = t.I('cancel-comment-reply-link'), temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId), post = t.I('comment_post_ID').value, parent = t.I('comment_parent').value;

					// comments
					if ( $comments.length ) {
						n = parseInt($comments.text().match(/\d+/));
						$comments.text($comments.text().replace( n, n + 1 ));
					}

					// show comment
					new_htm = '" id="new_comm_' + num + '"></';
					new_htm = ( parent == '0' ) ? ('\n<ol style="clear:both;" class="commentlist' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');

					ok_htm = '\n<span class="success" id="success_' + num + txt3;
					ok_htm += '</span><span></span>\n';

					$('#respond').before(new_htm);
					$('#new_comm_' + num).hide().append(data);
					$('#new_comm_' + num + ' li').append(ok_htm);
					$('#new_comm_' + num).fadeIn(4000);

					$body.animate( { scrollTop: $('#new_comm_' + num).offset().top - 200}, 900);
					countdown(); num++ ;
					cancel.style.display = 'none';
					cancel.onclick = null;
					t.I('comment_parent').value = '0';
					if ( temp && respond ) {
						temp.parentNode.insertBefore(respond, temp);
						temp.parentNode.removeChild(temp)
					}
				}
			}); // end Ajax
			return false;
		}); // end submit

		/** comment-reply.dev.js */
		addComment = {
			moveForm : function(commId, parentId, respondId, postId, num) {
				var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');
				t.respondId = respondId;
				postId = postId || false;

				if ( !t.I('wp-temp-form-div') ) {
					div = document.createElement('div');
					div.id = 'wp-temp-form-div';
					div.style.display = 'none';
					respond.parentNode.insertBefore(div, respond)
				}

				!comm ? ( 
					temp = t.I('wp-temp-form-div'),
					t.I('comment_parent').value = '0',
					temp.parentNode.insertBefore(respond, temp),
					temp.parentNode.removeChild(temp)
				) : comm.parentNode.insertBefore(respond, comm.nextSibling);

				$body.animate( { scrollTop: $('#respond').offset().top - 180 }, 400);

				if ( post && postId ) post.value = postId;
				parent.value = parentId;
				cancel.style.display = '';

				cancel.onclick = function() {
					var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

					t.I('comment_parent').value = '0';
					if ( temp && respond ) {
						temp.parentNode.insertBefore(respond, temp);
						temp.parentNode.removeChild(temp);
					}
					this.style.display = 'none';
					this.onclick = null;
					return false;
				};

				try { t.I('comment').focus(); }
				catch(e) {}

				return false;
			},

			I : function(e) {
				return document.getElementById(e);
			}
		}; // end addComment

		var wait = 15, submit_val = $submit.val();
		function countdown() {
			if ( wait > 0 ) {
				$submit.val(wait); wait--; setTimeout(countdown, 1000);
			} else {
				$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
				wait = 15;
		  }
		}
		function editcode() {
			var a = "",
			b = $("#comment").val(),
			start = b.indexOf("<code>"),
			end = b.indexOf("</code>");
			if (start > -1 && end > -1 && start < end) {
				a = "";
				while (end != -1) {
					a += b.substring(0, start + 6) + b.substring(start + 6, end).replace(/<(?=[^>]*?>)/gi, "&lt;").replace(/>/gi, "&gt;");
					b = b.substring(end + 7, b.length);
					start = b.indexOf("<code>") == -1 ? -6: b.indexOf("<code>");
					end = b.indexOf("</code>");
					if (end == -1) {
						a += "</code>" + b;
						$("#comment").val(a)
					} else if (start == -6) {
						myFielde += "&lt;/code&gt;"
					} else {
						a += "</code>"
					}
				}
			}
			var b = a ? a: $("#comment").val(),
			a = "",
			start = b.indexOf("<pre>"),
			end = b.indexOf("</pre>");
			if (start > -1 && end > -1 && start < end) {
				a = a
			} else return;
			while (end != -1) {
				a += b.substring(0, start + 5) + b.substring(start + 5, end).replace(/<(?=[^>]*?>)/gi, "&lt;").replace(/>/gi, "&gt;");
				b = b.substring(end + 6, b.length);
				start = b.indexOf("<pre>") == -1 ? -5: b.indexOf("<pre>");
				end = b.indexOf("</pre>");
				if (end == -1) {
					a += "</pre>" + b;
					$("#comment").val(a)
				} else if (start == -5) {
					myFielde += "&lt;/pre&gt;"
				} else {
					a += "</pre>"
				}
			}
		}
	}

})(jQuery, BingGlobal);

//插入表情
function grin(a) {
	var b;
	a = " " + a + " ";
	if (document.getElementById("comment") && document.getElementById("comment").type == "textarea") {
		b = document.getElementById("comment")
	} else {
		return false
	}
	if (document.selection) {
		b.focus();
		sel = document.selection.createRange();
		sel.text = a;
		b.focus()
	} else if (b.selectionStart || b.selectionStart == "0") {
		var c = b.selectionStart;
		var d = b.selectionEnd;
		var e = d;
		b.value = b.value.substring(0, c) + a + b.value.substring(d, b.value.length);
		e += a.length;
		b.focus();
		b.selectionStart = e;
		b.selectionEnd = e
	} else {
		b.value += a;
		b.focus()
	}
}