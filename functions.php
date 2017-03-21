<?php
/**
	*@package surmon
	*@author surmon@qq.com
	*@link http://surmon.me
	*Attention 用户请不要编辑此文件，添加代码请到与此文件同级的 custom-functions.php
*/
//Config
require( TEMPLATEPATH . '/theme-config.php' );

//Panel
foreach( array( 'functions', 'panel', 'ui' ) as $name ) require( TEMPLATEPATH . '/mpanel/mpanel-' . $name . '.php' );

//Functions
foreach( array( 'theme-functions', 'admin-functions', 'pagenavi', 'shortcode', 'breadcrumbs', 'visitors', 'comments', 'announcement', 'page-functions') as $name ) require( TEMPLATEPATH . '/functions/' . $name . '.php' );

//Custom
@include( TEMPLATEPATH . '/custom-functions.php' );

//Content
foreach( array( 'thumbnail', 'postlist', 'slides', 'ads', 'comments', 'style', 'ajax' ) as $name ) include( TEMPLATEPATH . '/includes/' . $name . '.php' );

//Theme End.
