<?php
/**
	*主题名字
*/
define( 'THEME_NAME', (string) wp_get_theme() );

/**
	*用于储存路径或一些文件名的主题别名
*/
define( 'THEME_FOLDER', strtolower( trim( THEME_NAME ) ) );

/**
	*主题设置数据库字段名称
*/
define( 'THEME_MPANEL_NAME', 'Bing_mpanel_' . THEME_FOLDER );

//Page End.
