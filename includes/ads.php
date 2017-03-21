<?php
/**
	*输出广告代码
*/
function Bing_ads_html( $name, $get = true, $before = '', $after = '' ){
	$id = 'ads_' . $name . '_';
	if( !mpanel( $id . 'display' ) ) return;
	$time = mpanel( $id . 'date' );
	if( $time && current_time( 'timestamp' ) > strtotime( $time ) ) return;
	$adscode = '<div class="ads ads_' . $name . '">';
		$code = mpanel( $id . 'code' );
		if( $code ) $adscode .= $code;
		else{
			$target = mpanel( $id . 'tab' ) ? ' target="_blank"' : '';
			$alt = mpanel( $id . 'alt' );
			$alt = $alt ? ' title="' . $alt . '" alt="' . $alt . '"' : '';
			$adscode .= '<a href="' . esc_url( mpanel( $id . 'url' ) ) . '" class="adsurl"><img src="' . esc_url( mpanel( $id . 'img' ) ) . '"' . $target . $alt . ' /></a>';
		}
	$adscode .= '</div>';
	$adscode = $before . $adscode . $after;
	if( $get ) return $adscode;
	echo $adscode;
}

/**
	*添加文章广告
*/
function Bing_add_post_ads( $content ){
	return Bing_ads_html( 'content_top' ) . Bing_ads_html( 'content' ) . $content . Bing_ads_html( 'content_bottom' );
}
add_filter( 'the_content_extra', 'Bing_add_post_ads', 12 );

//Page End.
