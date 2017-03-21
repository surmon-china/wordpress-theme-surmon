<?php
/**
	*CSS 合并压缩
*/
header( 'Content-type: text/css' );
function compress( $buffer ){
	$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
	$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $buffer );
	return $buffer;
}
ob_start( 'compress' );
foreach( glob( '*.css' ) as $filename ) include $filename;
ob_end_flush();
