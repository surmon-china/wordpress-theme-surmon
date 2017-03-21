<?php if( Bing_is_ajax() ) return; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta name="Author" Content="司马萌,surmon@qq.com">
        <meta name="Copyright" Content="本页版权归Surmon.me所有,All Rights Reserved">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" >
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="keywords" content="马赐崇,Surmon,司马萌,司马萌萌,Nocower-One主题,Wordpress-One主题模板"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
<!--百度异步统计代码-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?ca9a9485c2a0802d91ed716a700d6464";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!--百度异步统计代码-->
<script src="<?php bloginfo('template_url'); ?>/js/scroll.js"></script>
<script type="text/javascript">
    if(screen.width > 960)  //获取屏幕的的宽度
    {
     var jjsc = document.createElement( 'script' );
     var jpsc = document.createElement( 'script' );
     var plsc = document.createElement( 'script' );
     var cvsc = document.createElement( 'script' );
     jjsc.type = 'text/javascript';
     jpsc.type = 'text/javascript';
     plsc.type = 'text/javascript';
     cvsc.type = 'text/javascript';
     jjsc.src = 'http://surmon.me/wp-content/themes/Surmon/js/jquery.jplayer.min.js';
     jpsc.src = 'http://surmon.me/wp-content/themes/Surmon/js/jplayer.playlist.min.js';
     plsc.src = 'http://surmon.me/wp-content/themes/Surmon/js/player.list.js';
     cvsc.src = 'http://surmon.me/wp-content/themes/Surmon/js/Canvas_bg.js';
     $("head").append(jjsc);
     $("head").append(jpsc);
     $("head").append(plsc);
     $("head").append(cvsc);
     $(function(){FSS("rootbg", "canvasBg");});
    }
    else{
     var msc = document.createElement( 'script' );
     msc.type = 'text/javascript';
     msc.src = 'http://surmon.me/wp-content/themes/Surmon/js/mobile.js';
     $("head").append(msc);
    }
</script>
</head>
<body <?php body_class(); ?>>
<div id="rootbg"><div id="canvasBg"></div></div>
<div id="removeCanvas"><p></p><span></span></div>
<div id="romoveCanvasTitle"><span></span><p>你可以选择点击以关闭H5背景动画，以提高浏览器运行效能</p></div>
<div class="start"></div>
<div id="wap_menu_all">
<span>搜索：</span>
<form method="get" class="search-form" action="/" >
		<input class="wap_search-text" name="s" list="tag" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search...', 'Bing' ); ?>" x-webkit-speech lang="zh-CN" required maxlength=15 />
		<input class="wap_search-submit span-search" alt="search" type="submit" value="Search"/>
	</form>
<span>分类：</span>
<?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'container' => false, 'items_wrap' => '<ul id="wap_menu">%3$s</ul>', 'fallback_cb' => 'Bing_menu_null_fallback' ) ); ?>
<span>标签：</span>
 <?php $html = '<ul id="wap_tag">';
foreach (get_tags( array('number' => 45, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => false) ) as $tag){
        $tag_link = get_tag_link($tag->term_id);
        $html .= "<a href='{$tag_link}' title='查看有关 {$tag->name} 的文章' class='{$tag->slug}'>";
        $html .= "<li>{$tag->name} ({$tag->count})</li></a>";
}
$html .= '</ul>';
echo $html; ?>
</div>
<section id="wrapper" data-menu-position="close">
<div id="go">
<div class="wap_top_menu">
<div class="wap_top_menu_bar">
<span class="top_menu_btn"><i class="fa fa-reorder"></i></span>
<span class="wap_top_menu_bar_title"><?php bloginfo( 'description' ); ?></span>
<a href="<?php bloginfo( 'url' ); ?>/guestbook"><i class="fa fa-list-alt"></i></a>
</div>
</div>
		<header id="header">
			<div class="box-area">
				<div class="logo_plus">
                                 <a href="<?php bloginfo( 'url' ); ?>/about" title="<?php bloginfo( 'description' ); ?>">
                               <div class="logo">
                                 </div></a>
                                 </div>
		<div class="header_nothing"></div>
<div class="header_right">
  <div class="music-player">
  <div class="info">
 <!--[if IE 8]>
Yesterday You Said Tomorrow.
<![endif]-->
    <div class="center"><div class="jp-playlist"><ul><li></li></ul><div class="current jp-current-time">00:00</div></div>
    <div class="progress-base">
    <div class="progress jp-seek-bar"><span class="jp-play-bar" style="width:0%"></span></div>
    </div>
  </div>
  </div>
  <div class="controls">
    <div class="play-controls">
      <span  class="icon-previous jp-previous" title="Previous"><i class="fa fa-fast-backward"></i></span>
      <span  class="icon-play jp-play" title="Play"><i class="fa fa-play"></i></span>
      <span  class="icon-pause jp-pause" title="Pause"><i class="fa fa-pause"></i></span>
      <span  class="icon-next jp-next" title="Next"><i class="fa fa-fast-forward"></i></span>
    </div>
    <div class="volume-level jp-volume-bar">
      <span class="jp-volume-bar-value" style="width: 0%"></span>
    </div>
  </div>
  </div>
  <div id="jquery_jplayer" class="jp-jplayer"></div>
<nav class="nav topnav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
<?php wp_nav_menu( array( 'theme_location' => 'header_menu', 'container' => false, 'items_wrap' => '<ul id="topmenu">%3$s</ul>', 'fallback_cb' => 'Bing_menu_null_fallback' ) ); ?>
</nav>
<div class="header_nothing_right"></div>
			</div>
</div>
		</header>
</div>
		<div id="main">
			<div class="box-area">
			<?php Bing_ads_html( 'header', false, '<div class="header_ad">', '</div>' ); ?>