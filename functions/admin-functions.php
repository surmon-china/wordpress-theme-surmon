<?php
/**
	*后台评论快捷键回复
	*Ctrl + Enter 提交回复
*/
function Bing_admin_comment_ctrlenter(){
	echo '<script type="text/javascript">jQuery(document).ready(function(e){e("textarea").keypress(function(t){(t.ctrlKey&&t.which==13||t.which==10)&&e("#replybtn").click()})})</script>';
}
if( mpanel( 'admin_reply_shortcuts' ) ) add_action( 'admin_footer', 'Bing_admin_comment_ctrlenter' );

/**
	*增强默认编辑器
*/
function Bing_editor_buttons( $buttons ){
	array_push( $buttons, 'fontselect', 'fontsizeselect', 'backcolor', 'underline', 'hr', 'sub', 'sup', 'cut', 'copy', 'paste', 'cleanup', 'wp_page', 'newdocument' );
	return $buttons;
}
if( mpanel( 'editor_buttons' ) ) add_filter( 'mce_buttons_3', 'Bing_editor_buttons' );

/**
	*后台评论回复添加表情
*/
function Bing_ajax_smiley_scripts(){
	echo '<script type="text/javascript">function grin(e){var t;e=" "+e+" ";if(!document.getElementById("replycontent")||document.getElementById("replycontent").type!="textarea")return!1;t=document.getElementById("replycontent");if(document.selection)t.focus(),sel=document.selection.createRange(),sel.text=e,t.focus();else if(t.selectionStart||t.selectionStart=="0"){var n=t.selectionStart,r=t.selectionEnd,i=r;t.value=t.value.substring(0,n)+e+t.value.substring(r,t.value.length),i+=e.length,t.focus(),t.selectionStart=i,t.selectionEnd=i}else t.value+=e,t.focus()}jQuery(document).ready(function(e){var t="";e("#comments-form").length&&e.get(ajaxurl,{action:"ajax_data_smiley"},function(n){t=n,e("#qt_replycontent_toolbar input:last").after("<br>"+t)})})</script>';
}
if( mpanel( 'admin_smiley' ) ) add_action( 'admin_head', 'Bing_ajax_smiley_scripts' );

/**
	*搜索结果只有一篇文章时自动跳转到文章
*/
function Bing_redirect_single_post(){
	if( !is_search() ) return;
	global $wp_query;
	if( $wp_query->post_count === 1 && $wp_query->max_num_pages === 1 ){
		wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		exit;
	}
}
if( mpanel( 'search_one_redirect' ) ) add_action( 'template_redirect', 'Bing_redirect_single_post' );

//Page End.
