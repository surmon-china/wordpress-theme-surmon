<?php
/**
	*输出 CSS 代码
*/
function Bing_print_css( $selector, $style = array(), $width = null ){
	if( $width ) echo '@media screen and (max-width:' . $width . 'px){';
	if( is_array( $selector ) ){
		$i = 0;
		$last = count( $selector );
		foreach( $selector as $value ){
			$i++;
			echo $value;
			if( $i !== $last ) echo ',';
		}
	}else echo $selector;
	echo '{';
	foreach( $style as $key => $value ) echo $key . ':' . $value . ';';
	echo '}';
	if( $width ) echo '}';
}

/**
	*用户选项输出 CSS
	*输出内容
		*自定义 Logo
		*修改侧边栏位置
*/
function Bing_mpanel_style(){
	if( mpanel( 'logo' ) ){
		$url = mpanel( 'logo_url' );
		if( $url ) Bing_print_css( '.logo', array( 'background-image' => 'url(' . $url . ')' ) );
	}else{
	}
	if( mpanel( 'sidebar_position' ) == 'left' ){
		Bing_print_css( '#container', array( 'float' => 'right' ) );
		Bing_print_css( '#sidebar', array( 'float' => 'left' ) );
	}
}
add_action( 'css', 'Bing_mpanel_style', 14 );

/*
	*用户自定义 CSS
*/
function Bing_user_css(){
	echo mpanel( 'custom_css' );
}
add_action( 'css', 'Bing_user_css', 16 );

//Page End.
