<?php
/**
	*主题简码
*/
class Bing_shortcode{

	//初始化
	function __construct(){
		foreach( array( 'archive', 'mostactive' ) as $name ) add_shortcode( 'page_' . $name, array( $this, $name ) );
		foreach( array( 'ads' ) as $name ) add_shortcode( $name, array( $this, $name ) );
	}

	//文章归档
	function archive(){
		Bing_page_archive();
	}

	//读者墙
	function mostactive(){
		Bing_get_mostactive( 0, 0 );
	}

	//简码广告
	function ads(){
		Bing_ads_html( 'ads' );
	}

}
new Bing_shortcode;

//Page End.
