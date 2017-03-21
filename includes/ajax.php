<?php
/**
	*Ajax 评论
*/
function Bing_ajax_comment(){
	global $wpdb;
	add_filter( 'wp_die_ajax_handler', 'Bing_ajax_comment_die' );
	$comment_post_ID = isset( $_POST['comment_post_ID'] ) ? (int) $_POST['comment_post_ID'] : 0;
	$post = get_post( $comment_post_ID );
	$invalidtext = __( '检测为非法提交的评论', 'Bing' );
	if( empty( $post->comment_status ) ){
		do_action( 'comment_id_not_found', $comment_post_ID );
		wp_die( $invalidtext );
	}
	$status = get_post_status( $post );
	$status_obj = get_post_status_object( $status );
    if( !comments_open( $comment_post_ID ) ){
		do_action( 'comment_closed', $comment_post_ID );
		wp_die( __( '对不起，评论已关闭', 'Bing' ) );
	}elseif( 'trash' == $status ){
		do_action( 'comment_on_trash', $comment_post_ID );
		wp_die( $invalidtext );
	}elseif( !$status_obj->public && !$status_obj->private ){
		do_action( 'comment_on_draft', $comment_post_ID );
		wp_die( $invalidtext );
	}elseif( post_password_required( $comment_post_ID ) ){
		do_action( 'comment_on_password_protected', $comment_post_ID );
		wp_die( __( '密码保护状态', 'Bing' ) );
	}else do_action( 'pre_comment_on_post', $comment_post_ID );
	$comment_author = ( isset( $_POST['author'] ) ) ? trim( strip_tags( $_POST['author'] ) ) : null;
	$comment_author_email = ( isset( $_POST['email'] ) ) ? trim( $_POST['email'] ) : null;
	$comment_author_url = ( isset( $_POST['url'] ) ) ? trim( $_POST['url'] ) : null;
	$comment_content = ( isset( $_POST['comment'] ) ) ? trim( $_POST['comment'] ) : null;
	$user = wp_get_current_user();
	if( $user->exists() ){
		if( empty( $user->display_name ) ) $user->display_name = $user->user_login;
		$comment_author = $wpdb->escape( $user->display_name );
		$comment_author_email = $wpdb->escape( $user->user_email );
		$comment_author_url = $wpdb->escape( $user->user_url );
		$user_ID = $wpdb->escape( $user->ID );
		if( current_user_can( 'unfiltered_html' ) ){
			if( wp_create_nonce( 'unfiltered-html-comment_' . $comment_post_ID ) != $_POST['_wp_unfiltered_html_comment'] ){
				kses_remove_filters();
				kses_init_filters();
			}
		}
	}elseif( get_option( 'comment_registration' ) || $status == 'private' ) wp_die( __( '您必须登录才能发表评论', 'Bing' ) );
	$comment_type = null;
	if( get_option( 'require_name_email' ) && !$user->exists() ){
		if( strlen( $comment_author_email ) < 6 || !$comment_author ) wp_die( __( '请填写正确的昵称和邮箱', 'Bing' ) );
        elseif( !is_email( $comment_author_email ) ) wp_die( __( '请使用一个有效的邮箱', 'Bing' ) );
	}
	if( !$comment_content ) wp_die( __( '请输入评论', 'Bing' ) );
	$dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
	if( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
	$dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
	if( $wpdb->get_var( $dupe ) ) wp_die( __( '您发表的评论重复了', 'Bing' ) );
	if( $lasttime = $wpdb->get_var( $wpdb->prepare( "SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author ) ) ){
		$time_lastcomment = mysql2date( 'U', $lasttime, false );
		$time_newcomment  = mysql2date( 'U', current_time( 'mysql', 1 ), false );
		$flood_die = apply_filters( 'comment_flood_filter', false, $time_lastcomment, $time_newcomment );
		if( $flood_die ) wp_die( __( '您评论的速度太快了，休息一会儿吧', 'Bing' ) );
	}
	$comment_parent = isset( $_POST['comment_parent'] ) ? absint( $_POST['comment_parent'] ) : 0;
	$commentdata = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );
	$comment_id = wp_new_comment( $commentdata );
	$comment = get_comment( $comment_id );
	do_action( 'set_comment_cookies', $comment, $user );
	$comment_depth = 1;
	$tmp_c = $comment;
	while( $tmp_c->comment_parent != 0 ){
		$comment_depth++;
		$tmp_c = get_comment( $tmp_c->comment_parent );
	}
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
			<?php $add_below = 'div-comment'; ?>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email ); ?>
				<strong class="author"><?php comment_author_link();edit_comment_link( '[' . __( '编辑', 'Bing' ) . ']', '', '' ); ?>：</strong>
				<span class="datetime"><?php comment_date( 'Y-m-d' ) ?> <?php comment_time(); ?></span>
				<?php if( $comment->comment_approved != '0' ): ?>
					<span class="reply">
						<?php
						if( !isset( $args ) ) $args = array( 'max_depth' => null );
						if( !isset( $depth ) ) $depth = '';
						comment_reply_link( wp_parse_args( $args, array(
							'reply_text' => '@Ta',
							'add_below' => $add_below,
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						) ) );
						?>
					</span>
				<?php endif; ?>
			</div>
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span style="color:#C00;font-style:inherit;"><?php _e( '您的评论正在等待审核中', 'Bing' ); ?>...</span>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
<?php
	die();
}
add_action( 'wp_ajax_nopriv_ajax_comment', 'Bing_ajax_comment' );
add_action( 'wp_ajax_ajax_comment', 'Bing_ajax_comment' );

/**
	*获取后台评论回复表情插入按钮代码
*/
function Bing_ajax_data_smiley(){
	$url = get_bloginfo( 'template_directory' ) . '/images/smilies/icon_';
	foreach( array( '?' => 'question', 'razz' => 'razz', 'sad' => 'sad', 'evil' => 'evil', '!' => 'exclaim', 'smile' => 'smile', 'oops' => 'redface', 'grin' => 'biggrin', 'eek' => 'surprised', 'shock' => 'eek', '???' => 'confused', 'cool' => 'cool', 'lol' => 'lol', 'mad' => 'mad', 'twisted' => 'twisted', 'roll' => 'rolleyes', 'wink' => 'wink', 'idea' => 'idea', 'arrow' => 'arrow', 'neutral' => 'neutral', 'cry' => 'cry', 'mrgreen' => 'mrgreen' ) as $key => $value ) echo '<a href="javascript:grin(\':' . $key . ':\')"><img src="' . $url . $value . '.gif" alt="' . $key . '" /></a> ';
	die;
}
add_action( 'wp_ajax_nopriv_ajax_data_smiley', 'Bing_ajax_data_smiley' );
add_action( 'wp_ajax_ajax_data_smiley', 'Bing_ajax_data_smiley' );

/**
	*判断全站 Ajax
*/
function Bing_is_ajax(){
	return isset( $_GET['action'] ) && $_GET['action'] == 'ajax_container' && mpanel( 'ajax' ) && !is_admin();
}

/**
	*全站 Ajax
*/
function Bing_ajax_header(){
	remove_action( 'get_footer', 'get_sidebar', 1 );
	add_action( 'get_footer', '_ajax_wp_die_handler', 1, 0 );
	Bing_statistics_visitors();
	nocache_headers();
	echo '<script type="text/javascript">var title = "' . esc_js( wp_title( '|', false, 'right' ) ) . '";var qrcode = "' . esc_js( Bing_print_qrcode( 150, ture ) ) . '";</script>';
}
if( Bing_is_ajax() ) add_action( 'get_header', 'Bing_ajax_header', 1 );

//Page End.