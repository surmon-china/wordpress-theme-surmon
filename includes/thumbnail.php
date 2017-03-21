<?php
/**
	*获取文章缩略图地址
*/
function Bing_post_thumbnail_src(){
	global $post;
	if( $values = get_post_custom_values( 'thumb' ) ){
		$values = get_post_custom_values( 'thumb' );
		$post_thumbnail_src = $values[0];
	}elseif( has_post_thumbnail() ){
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$post_thumbnail_src = $thumbnail_src[0];
	}else{
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		if( empty( $matches[1][0] ) ) $post_thumbnail_src = get_bloginfo( 'template_url' ) . '/images/random/' . mt_rand( 1, 10 ) . '.jpg';
		else $post_thumbnail_src = $matches[1][0];
	}
	return $post_thumbnail_src;
}

/**
	*输出缩略图代码
*/
function Bing_thumbnail( $width, $height = null, $url = null ){
	if( is_null( $url ) ) $url = Bing_post_thumbnail_src();
	if( is_null( $height ) ) $height = $width;
	$tburl = $url;
	if( mpanel( 'timthumb' ) ) $tburl = get_bloginfo( 'template_directory' ) . '/timthumb.php?src=' . $url . '&h=' . $height . '&w=' . $width . '&q=90&zc=1';
	$code = '<img src="' . $tburl . '" class="thumb" width="' . $width . '" height="' . $height . '" title="' . get_the_title() . '" alt="' . get_the_title() . '" />';
	if( $url ) $code = '<a href="' . get_permalink() . '" class="picbox" rel="bookmark" title="' . get_the_title() . '">' . $code . '</a>';
	echo apply_filters( 'Bing_thumbnail', $code, $width, $height, $url );
}

//Page End.
