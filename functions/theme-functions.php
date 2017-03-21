<?php
/**
	*选项调用
*/
function exclude_category_home( $query ) {  
    if ( $query->is_home ) {//是否首页  
        $query->set( 'cat', '-5' );  //排除的指定分类id排除了Theme分类的文章
    }  
    return $query;  
}  
add_filter( 'pre_get_posts', 'exclude_category_home' );  
//二维码占位
function Bing_print_qrcode( $size = 150, $get = false ){}

function mpanel( $name ){
	return $GLOBALS['mpanel']->get( $name );
}
update_option('image_default_link_type', 'none');
/**
	*建立菜单
*/
function Bing_register_nav_menus(){
	register_nav_menus( array(
		'header_menu' => __( '顶部菜单', 'Bing' ),
	));
}
add_action( 'init', 'Bing_register_nav_menus' );

/**
	*语言本地化
*/
function Bing_theme_localize(){
	load_theme_textdomain( 'Bing', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'Bing_theme_localize', 1 );

/**
	*空菜单回调函数
*/
function Bing_menu_null_fallback(){
	$homeclsss = is_home() ? ' class="current-menu-item"' : '';
	echo '<ul id="topmenu"><li' . $homeclsss . '><a href="' . get_bloginfo( 'url' ) . '"><i class="fa fa-home"></i>' . __( '首页', 'Bing' ) . '</a></li><li><a href="' . admin_url( 'nav-menus.php' ) . '"><i class="fa fa-plus-circle"></i>' . __( '添加菜单', 'Bing' ) . '</a></li></ul>';
}

/**
	*网页标题修改
*/
function Bing_wp_title( $title, $sep ){
	global $paged, $page;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description' );
	if( $site_description && ( is_home() || is_front_page() ) ) $title .= ' ' . $sep . ' ' . $site_description;
	if( $paged >= 2 || $page >= 2 ) $title .= ' ' . $sep . ' ' . sprintf( __( '第 %s 页', 'Bing' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'Bing_wp_title', 10, 2 );

/**
	*其它语言转换成唯一英文数字 ID
*/
function Bing_language_id( $string ){
	return str_replace( '%', '', sanitize_title( $string ) );
}

/**
	*摘要文字截取
*/
function Bing_strip_strimwidth( $string, $number = 500 ){
	if( function_exists( 'mb_strimwidth' ) ) return mb_strimwidth( strip_tags( $string ), 0, $number, '...' );
}

/**
	*获取网页描述
*/
function Bing_site_description( $home ){
	global $post;
	$description = '';
	if( is_home() || is_front_page() ) $description = $home;
	elseif( is_category() ) $description = strip_tags( trim( category_description() ) );
	elseif( is_tag() ) $description = sprintf( __( '与标签 %s 相关联的文章列表', 'Bing' ), single_tag_title( '', false ) );
	elseif( is_single() || is_page() ) $description = $post->post_excerpt ? $post->post_excerpt . '...' : $description = mb_strimwidth( strip_tags( $post->post_content ), 0, 260, '' ) . '...';
	return trim( $description );
}

/**
	*打印网页描述元标记
*/
function Bing_site_description_meta(){
	if( is_404() ) return;
	echo '<meta name="description" content="' . Bing_site_description( mpanel( 'site_description' ) ) . '" />';
}
add_action( 'wp_head', 'Bing_site_description_meta' );

/**
	*添加特色缩略图支持
*/
function Bing_add_post_thumbnails(){
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'Bing_add_post_thumbnails' );

/**
	*调用侧边栏
*/
add_action( 'get_footer', 'get_sidebar', 1, 0 );

/**
	*添加 IE8 兼容性脚本

*/
function Bing_add_ie_script(){
	echo '<!--[if lte IE 8]><script type="text/javascript" src="' . get_bloginfo( 'template_directory' ) . '/js/ie8.js"></script><![endif]--><!--[if lte IE 8]><link rel="stylesheet" href="' . get_bloginfo( 'template_directory' ) . '/ie8.css" type="text/css" media="all" /><![endif]-->';
}
add_action( 'wp_head', 'Bing_add_ie_script', 12 );

/**
	*挂载脚本

*/
function Bing_enqueue_scripts(){
	if( is_admin() ) return;

	//移除插件添加的 jQuery
	wp_deregister_script( 'jquery' );

	//jQuery
	wp_register_script( 'jquery', mpanel( 'jquery_cdn' ) ? '//libs.baidu.com/jquery/1.8.3/jquery.min.js' : get_bloginfo( 'template_directory' ) . '/js/jquery.min.js' );

	//Owl Carousel
	wp_register_script( 'owl_carousel', mpanel( 'owl_carousel_cdn' ) ? 'http://cdn.bootcss.com/owl-carousel/1.32/owl.carousel.min.js' : get_bloginfo( 'template_directory' ) . '/js/owl.carousel.min.js', array( 'jquery' ) );	

	//Global
	wp_register_script( 'global', get_bloginfo( 'template_directory' ) . '/js/global.min.js', array( 'jquery', 'owl_carousel' ) );
	wp_localize_script( 'global', 'BingGlobal', array(
		'admin-ajax' => admin_url( 'admin-ajax.php' ),
		'tooltip' => (bool) mpanel( 'tooltip' ),
		'cookiehash' => COOKIEHASH,
		'commentloading' => __( '正在提交', 'Bing' ),
		'commentsuccess' => __( '提交成功', 'Bing' ),
		'ajax_error' => __( '网页加载失败！', 'Bing' ),
		'ajax' => (bool) mpanel( 'ajax' ),
		'ajax_comm' => (bool) mpanel( 'ajax_comm' ),
	));
	wp_enqueue_script( 'global' );

	//添加Style样式

	wp_register_style( 'style', get_bloginfo( 'template_directory' ) . '/style.css' );

	wp_enqueue_style( 'style' );

	//Font Awesome
	wp_register_style( 'font-awesome', mpanel( 'font_awesome_cdn' ) ? 'http://cdn.bootcss.com/font-awesome/4.1.0/css/font-awesome.min.css' : get_bloginfo( 'template_directory' ) . '/font-awesome.css' );
	wp_enqueue_style( 'font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'Bing_enqueue_scripts' );

/**
	*添加 Favicon
*/
function Bing_add_favicon(){
	$url = get_bloginfo( 'template_directory' ) . '/images/favicon.ico';
	$userurl = mpanel( 'favicon_url' );
	if( !empty( $userurl ) ) $url = $userurl;
	echo '<link rel="shortcut icon" href="' . $url . '" type="image/x-icon" />';
}
if( mpanel( 'favicon' ) ) add_action( 'wp_head', 'Bing_add_favicon' );


/**
	*修改主循环
	*修改内容
		*添加公告文章类型
		*取消置顶文章
		*排除置顶文章
*/
function Bing_main_loop_control( $query ){
	if( !$query->is_main_query() || !$query->is_home ) return;
	$query->set( 'post_type', array( 'post', 'announcement' ) );
	if( mpanel( 'home_loop_top' ) == 'none' ) $query->set( 'ignore_sticky_posts', 1 );
	if( mpanel( 'home_loop_top' ) == 'hide' ) $query->set( 'post__not_in', get_option( 'sticky_posts' ) );
}
add_action( 'pre_get_posts', 'Bing_main_loop_control' );

/**
	*头像缓存
*/
function Bing_avatar_cache( $avatar ){
	$tmp = strpos( $avatar, 'http' );
	$g = substr( $avatar, $tmp, strpos( $avatar, '\'', $tmp ) - $tmp );
	$tmp = strpos( $g, 'avatar/' ) + 7;
	$f = substr( $g, $tmp, strpos( $g, '?', $tmp ) - $tmp );
	$w = get_bloginfo( 'template_directory' );
	$path = TEMPLATEPATH . '/avatar';
	$e = $path . '/' . $f . '.png';
	$t = 24 * 60 * 60 * mpanel( 'avatar_cache_day' );
	if( !is_file( $e ) || ( time() - filemtime( $e ) ) > $t ) copy( htmlspecialchars_decode( $g ), $e );
	else $avatar = strtr( $avatar, array( $g => $w . '/avatar/' . $f . '.png' ) );
	if( filesize( $e ) < 500 ) copy( TEMPLATEPATH . '/images/default-avatar.png', $e );
	return $avatar;
}
if( mpanel( 'avatar_cache' ) ) add_filter( 'get_avatar', 'Bing_avatar_cache' );

/**
	*存档头部信息
*/
function Bing_archive_header( $before = null, $after = null, $descriptioneacho = false ){
	if( is_author() ){
		global $author;
		$userdata = get_userdata( $author );
		$name = '<i class="fa fa-user"></i>' . $userdata->display_name;
		$description = get_the_author_meta( 'description' );
	}elseif( is_tag() ){
		$name = '<i class="fa fa-tags"></i>' . single_cat_title( '', false );
		$description = sprintf( __( '标签 %s 的文章', 'Bing' ), single_cat_title( '', false ) );
	}
	elseif( is_date() ){
		if( is_day() ) $name = get_the_time( 'Y' ) . __( '年', 'Bing' ) . get_the_time( 'm' ) . __( '月', 'Bing') . get_the_time( 'd' ) . __( '日', 'Bing' );
		if( is_month() ) $name = get_the_time( 'Y' ) . __( '年', 'Bing' ) . get_the_time( 'm' ) . __( '月', 'Bing');
		if( is_year() ) $name = get_the_time( 'Y' ) . __( '年', 'Bing' );
		$description = sprintf( __( '%s的文章', 'Bing' ), $name );
		$name = '<i class="fa fa-calendar"></i>' . $name;
	}elseif( is_search() ){
		$name = '<i class="fa fa-search"></i>' . get_search_query();
		$description = sprintf( __( '关键词 “%s” 的搜索结果', 'Bing' ), get_search_query() );
	}else{
		$name = '<i class="fa fa-folder-open-o"></i>' . single_cat_title( '', false ) . '<a class="rss" title="' . __( 'RSS 订阅此分类', 'Bing' ) . '" href="' . get_category_feed_link( get_query_var( 'cat' ) ) . '"><i class="fa fa-rss"></i></a>';
		$description = category_description();
		if( empty( $description ) ) $description = sprintf( __( '分类 %s 的文章', 'Bing' ), single_cat_title( '', false ) );
	}
	if( $name && !$descriptioneacho ) return $before . $name . $after;
	if( $description && $descriptioneacho ) echo $before . $description . $after;
}

/**
	*搜索结果只限文章

*/
function Bing_search_filter_page( $query ){
	if( $query->is_search ) $query->set( 'post_type', 'post' );
	return $query;
}
if( mpanel( 'search_filter_page' ) ) add_filter( 'pre_get_posts', 'Bing_search_filter_page' );

/**
	*搜索结果只有一篇文章时自动跳转到文章
	*代码来自网络
*/
function Bing_search_one_redirect(){
	global $wp_query;
	if( $wp_query->post_count == 1 && $wp_query->max_num_pages == 1 && $wp_query->is_search ){
		wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		exit;
	}
}
if( mpanel( 'search_one_redirect' ) ) add_action( 'template_redirect', 'Bing_search_one_redirect' );

/**
	*移除头部无用信息
*/
function Bing_remove_head_refuse(){
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );	
}
if( mpanel( 'remove_head_refuse' ) ) add_action( 'after_setup_theme', 'Bing_remove_head_refuse' );

/**
	*关闭离线编辑器接口

*/
function Bing_remove_xmlrpc(){
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	add_filter( 'xmlrpc_enabled', '__return_false' );
}
if( mpanel( 'remove_xmlrpc' ) ) add_action( 'after_setup_theme', 'Bing_remove_xmlrpc' );

/**
	*添加文章其它内容钩子
*/
function Bing_the_content_hook( $content ){
	if( is_single() ) return apply_filters( 'the_content_extra', $content );
	return $content;
}
add_filter( 'the_content', 'Bing_the_content_hook', 22 );

/**
	*添加相关文章板块
*/
function Bing_add_related_posts(){
	echo '<article class="related-posts"><div class="main"><ul>';
		$post_num = 10;
		$post_id = array();
		$exclude_id = array( $GLOBALS['post']->ID );
		$i = 0;
		$posttags = get_the_tags();
		if( $posttags ){
			$tags = array();
			foreach( $posttags as $tag ) $tags[] = $tag->term_id;
			query_posts( array(
				'tag__in' => $tags,
				'post__not_in' => $exclude_id,
				'caller_get_posts' => 1,
				'orderby' => 'rand',
				'posts_per_page' => $post_num
			) );
			while( have_posts() ){
				the_post();
				echo '<li>';
					if( mpanel( 'thumbnail' ) ) Bing_thumbnail( 111, 120 );
					$title = get_the_title();
					echo '<span><a rel="bookmark" class="title" href="' . get_permalink() . '" title="' . $title . '">' . $title . '</a></span>';
				echo '</li>';
				$i++;
			}
			wp_reset_query();
		}
		if( $i < $post_num ){
			query_posts( array(
				'post__not_in' => $exclude_id,
				'caller_get_posts' => 1,
				'orderby' => 'rand',
				'posts_per_page' => $post_num - $i
			) );
			while( have_posts() ){
				the_post();
				echo '<li>';
					if( mpanel( 'thumbnail' ) ) Bing_thumbnail( 111, 120 );
					$title = get_the_title();
					echo '<span><a rel="bookmark" class="title" href="' . get_permalink() . '" title="' . $title . '">' . $title . '</a></span>';
				echo '</li>';
			}			
			wp_reset_query();
		}
	$previous = get_previous_post() ? get_previous_post_link( '%link' ) : __( '本文已经是最旧文章', 'Bing' );
	$next = get_next_post() ? get_next_post_link( '%link' ) : __( '本文已经是最新文章', 'Bing' );
	echo '</ul><div class="clear"></div></div></article>';
}
if( mpanel( 'related_posts' ) ) add_filter( 'article-after', 'Bing_add_related_posts', 8 );

/**
	*阻止站内文章互相 Pingback
*/
function Bing_noself_pingback( $links ){
	foreach( $links as $l => $link ) if( strpos( $link, get_option( 'home' ) === 0 ) ) unset( $links[$l] );
}
if( mpanel( 'noself_pingback' ) ) add_action( 'pre_ping', 'Bing_noself_pingback' );

/**
	*文章内容全部链接新窗口打开

*/
function Bing_autoblank( $content ){
	return str_replace( '<a', '<a target="_blank"', $content );
}
if( mpanel( 'autoblank' ) ) add_filter( 'the_content', 'Bing_autoblank', 13 );

/**
	*文章内容外链添加 nofollow 并在新窗口打开

*/
function Bing_nf_url_parse( $content ){
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if( preg_match_all( "/$regexp/siU", $content, $matches, PREG_SET_ORDER ) ){
		if( !empty( $matches ) ){
			$srcUrl = get_option( 'siteurl' );
			for( $i=0;$i < count( $matches );$i++ ){
				$tag = $matches[$i][0];
				$tag2 = $matches[$i][0];
				$url = $matches[$i][0];
				$noFollow = '';
				$pattern = '/target\s*=\s*"\s*_blank\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if( count( $match ) < 1 ) $noFollow .= ' target="_blank" '; 
				$pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
				preg_match( $pattern, $tag2, $match, PREG_OFFSET_CAPTURE );
				if( count( $match ) < 1 ) $noFollow .= ' rel="nofollow" ';
				$pos = strpos( $url, $srcUrl );
				if( $pos === false ){
					$tag = rtrim( $tag, '>' );
					$tag .= $noFollow . '>';
					$content = str_replace( $tag2, $tag, $content );
				}
			}
		}
	}
	$content = str_replace( ']]>', ']]>', $content );
	return $content;
}
if( mpanel( 'nf_url_parse' ) ) add_filter( 'the_content', 'Bing_nf_url_parse', 14 );

/**
	*添加前台 CSS

*/
function Bing_add_css_action(){
	if( !has_action( 'css' ) ) return;
	echo '<style>';
		do_action( 'css' );
	echo '</style>';
}
add_action( 'wp_head', 'Bing_add_css_action', 12 );

/**
	*自定义头部代码
*/
function Bing_custom_head_code(){
	echo mpanel( 'head_code' );
}
if( mpanel( 'head_code' ) ) add_action( 'wp_head', 'Bing_custom_head_code', 14 );

/**
	*自定义底部代码

*/
function Bing_custom_footer_code(){
	echo mpanel( 'footer_code' );
}
if( mpanel( 'footer_code' ) ) add_action( 'wp_footer', 'Bing_custom_footer_code', 14 );

//Page End.