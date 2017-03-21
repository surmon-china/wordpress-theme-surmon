<?php
/**
	*访问计数
*/
function Bing_statistics_visitors( $cache = false ){
	global $post;
	$id = $post->ID;
	if( $cache ) $id = $_GET['id'];
	if( ( !is_singular() && !$cache ) || !$id ) return;
	if( get_post( $id )->post_status != 'publish' ) return;
	if( defined( 'WP_CACHE' ) && WP_CACHE && !$cache ){
		echo '<script type="text/javascript">jQuery(document).ready(function($){$.get("' . admin_url( 'admin-ajax.php' ) . '", { action: "visitors", id: "' . $id . '" })})</script>';
		return;
	}
	$post_views = (int) get_post_meta( $id, 'views', true );
	if( !update_post_meta( $id, 'views', ( $post_views + 1 ) ) ) add_post_meta( $id, 'views', 1, true );
}
add_action( 'wp_head', 'Bing_statistics_visitors' );
 
/**
	*解决缓存问题
*/
function Bing_statistics_cache(){
	Bing_statistics_visitors( true );
}
add_action( 'wp_ajax_nopriv_visitors', 'Bing_statistics_cache' );
add_action( 'wp_ajax_visitors', 'Bing_statistics_cache' );
 
/**
	*获取计数
*/
function Bing_get_views( $get = true ){
	global $post;
	$views = number_format( (int) get_post_meta( $post->ID, 'views', true ) );
	if( $get ) return $views;
	echo $views;
}

//Page End.
