<?php
/**
	*垃圾评论拦截
*/
class Bing_anti_spam{

	//初始化
	function __construct(){
		add_action( 'template_redirect', array( $this, 'tb' ), 1 );
		add_action( 'init', array( $this, 'gate' ), 1 );
		add_filter( 'preprocess_comment', array( $this, 'sink' ), 1 );
	}

	//修改评论表单
	function tb(){
		if( is_singular() ) ob_start( create_function( '$input', 'return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#", "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>", $input );' ) );
	}

	//过滤数据
	function gate(){
		if( !empty( $_POST['w'] ) && empty( $_POST['comment'] ) ) $_POST['comment'] = $_POST['w'];
		else{
			$request = $_SERVER['REQUEST_URI'];
			$referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : __( '隐瞒', 'Bing' );
			$IP = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] . __( '（通过代理）', 'Bing' ) : $_SERVER['REMOTE_ADD'];
			$way = isset( $_POST['w'] ) ? __( '手动操作', 'Bing' ) : __( '未经过评论表单', 'Bing' );
			$spamcom = isset( $_POST['comment'] ) ? $_POST['comment'] : null;
			$_POST['spam_confirmed'] = sprintf( __( "请求：%s\n来路：：%s\nIP：%s\n方式：%s\n内容：%s\n记录成功", 'Bing' ), $request, $referer, $IP, $way, $spamcom );
		}
	}

	//检测评论
	function sink( $comment ){
		if ( !empty( $_POST['spam_confirmed'] ) ){
			if( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;
			die;
		}
		return $comment;
	}

}
if( mpanel( 'comment_anti' ) && !current_user_can( 'level_0' ) ) new Bing_anti_spam;

/**
	*阻止不包含中文的评论
*/
function Bing_spam_chinese_comments( $comment ){
	$pattern = '/[一-龥]/u';
	if( !preg_match( $pattern, $comment['comment_content'] ) ) wp_die( __( '请在评论里包含中文' , 'Bing' ) );
	return $comment;
}
if( mpanel( 'comment_anti_chinese' ) ) add_filter( 'preprocess_comment', 'Bing_spam_chinese_comments' );

/**
	*评论邮件通知
*/
function Bing_comment_mail_notify( $comment_id ){
	$comment = get_comment( $comment_id );
	$parent_id = $comment->comment_parent ? $comment->comment_parent : null;
	$spam_confirmed = $comment->comment_approved;
	if( !$parent_id || $spam_confirmed == 'spam' ) return;
	$wp_email = 'no-reply@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER['SERVER_NAME'] ) );
	$to = trim( get_comment( $parent_id )->comment_author_email );
	$subject = sprintf( __( '你在 [%s] 的评论有回复啦！', 'Bing' ), get_the_title( $comment->comment_post_ID ) );
	$message = '<div><div style="color:#555;font:12px/1.5 \'Microsoft Yahei\',Tahoma,Helvetica,Arial,sans-serif;width:600px;margin:50px auto;border:1px solid #e9e9e9;border-top:none;box-shadow:0 0px 0px #aaaaaa;"><table border="0" cellspacing="0" cellpadding="0"><tbody><tr valign="top" height="2"><td width="190" bgcolor="#0B9938"></td><td width="120" bgcolor="#9FCE67"></td><td width="85" bgcolor="#EDB113"></td><td width="85" bgcolor="#FFCC02"></td><td width="130" bgcolor="#5B1301" valign="top"></td></tr></tbody></table><div style="padding: 0 15px 8px;"><h2 style="border-bottom:1px solid #e9e9e9;font-size:14px;font-weight:normal;padding:10px 0 10px;"><span style="color: #12ADDB">&gt; </span>' . sprintf( __( '您在 %s 的评论有回复啦！', 'Bing' ), '<a style="text-decoration:none;color:#12ADDB;" href="' . get_option( 'home' ) . '" title="' . get_option( 'name' ) . '" target="_blank">' . get_option( 'name' ) . '</a>' ) . '</h2><div style="font-size:12px;color:#777;padding:0 10px;margin-top:18px">' . sprintf( __( '%s 同学，您曾在《 %s 》中发表评论：', 'Bing' ), trim( get_comment( $parent_id )->comment_author ), get_the_title( $comment->comment_post_ID ) ) . '<p style="background-color:#f5f5f5;padding:10px 15px;margin:18px 0">' . nl2br( get_comment( $parent_id )->comment_content ) . '</p><p>' . sprintf( __( '%s 给您的回复如下：', 'Bing' ), trim( $comment->comment_author ) ) . '</p><p style="background-color:#f5f5f5;padding:10px 15px;margin:18px 0">' . nl2br( $comment->comment_content ) . '</p><p>' . sprintf( __( '您可以 %s点击查看完整的回复内容%s，欢迎再次光临 %s！', 'Bing' ), '<a style="text-decoration:none;color:#12addb" href="' . htmlspecialchars( get_comment_link( $parent_id ) ) . '" title="' . __( '点击查看完整的回复内容', 'Bing' ) . '" target="_blank">', '</a>', '<a style="text-decoration:none;color:#12addb" href="' . get_option( 'home' ) . '" title="' . get_option( 'name' ) . '" target="_blank">' . get_option( 'name' ) . '</a>' ) . '</p></div></div><div style="color:#888;padding:10px;border-top:1px solid #e9e9e9;background:#f5f5f5;"><p style="margin:0;padding:0;">© <a style="color:#888;text-decoration:none;" href="' . get_option( 'home' ) . '" title="' . get_option( 'name' ) . '" target="_blank">' . get_option( 'name' ) . '</a> - ' . __( '邮件自动生成，请勿直接回复！', 'Bing' ) . '</p></div></div></div>';
	$from = 'From: "' . get_option( 'name' ) . '" <' . $wp_email . '>';
	$headers = "$from\nContent-Type: text/html; charset=" . get_option( 'blog_charset' ) . "\n";
	wp_mail( $to, $subject, $message, $headers );
}
if( mpanel( 'comment_email_notify' ) ) add_action( 'comment_post', 'Bing_comment_mail_notify' );

/**
	*更改表情路径
*/
function Bing_smilies_src( $img_src, $img ){
	return get_bloginfo( 'template_directory' ) . '/images/smilies/' . $img;
}
add_filter( 'smilies_src', 'Bing_smilies_src', 1, 2 ); 

/**
	*评论作者链接新窗口打开
*/
function Bing_comment_author_link(){
	$url = get_comment_author_url();
	$author = get_comment_author();
	if( empty( $url ) || $url == 'http://' ) return $author;
	return '<a href="' . $url . '" rel="external nofollow" target="_blank" class="url">' . $author . '</a>';
}
if( mpanel( 'comment_author_link_newtab' ) ) add_filter( 'get_comment_author_link', 'Bing_comment_author_link', 8 );

/**
	*禁止没有头像的用户评论
*/
function Bing_validate_gravatar_comment( $comment ){
	$headers = @get_headers( 'http://www.gravatar.com/avatar/' . md5( strtolower( trim( $comment['comment_author_email'] ) ) ) . '?d=404' );
	if( preg_match( '|200|', $headers[0] ) ) return $comment;
	wp_die( __( '请使用有头像的邮箱', 'Bing' ) );
}
if( mpanel( 'validate_gravatar_comment' ) ) add_filter( 'preprocess_comment', 'Bing_validate_gravatar_comment' );

/**
	*回复的评论加 @
*/
function Bing_comment_add_at( $comment_text, $comment = null ){
	if( $comment->comment_parent > 0 ) return '<a class="comment_at" href="#comment-' . $comment->comment_parent . '">@' . get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
	return $comment_text;
}
if( mpanel( 'comment_add_at' ) ) add_filter( 'comment_text' , 'Bing_comment_add_at', 20, 2 );

/**
	*Ajax 评论改造报错
*/
function Bing_ajax_comment_die(){
	return 'Bing_ajax_comment_die_func';
}

/**
	*Ajax 评论改造报错回调函数
*/
function Bing_ajax_comment_die_func( $message ){
	header( 'HTTP/1.0 500 Internal Server Error' );
	header( 'Content-Type: text/plain;charset=UTF-8' );
	exit( $message );
}

//Page End.
