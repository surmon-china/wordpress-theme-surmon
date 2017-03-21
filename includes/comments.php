<?php
/**
	*评论列表样式
*/
function Bing_comment_list( $comment, $args, $depth ){
	$GLOBALS['comment'] = $comment;
	global $commentcount, $wpdb, $post;
	if( !$commentcount ){
		$comments = $wpdb->get_results( "SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent" );
		$cnt = count( $comments );
		$page = get_query_var( 'cpage' );
		$cpp = get_option( 'comments_per_page' );
        if( ceil( $cnt / $cpp ) == 1 || ( $page > 1 && $page  == ceil( $cnt / $cpp ) ) ) $commentcount = $cnt + 1;
		else $commentcount = $cpp * $page + 1;
	}
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
						comment_reply_link( wp_parse_args( $args, array(
							'reply_text' => '@Ta',
							'add_below' => $add_below,
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						) ) );
						?>
					</span>
				<?php endif; ?>
				<?php if( !$parent_id = $comment->comment_parent ) printf( '<div class="floor">#%1$s</div>', --$commentcount ); ?>
			</div>
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span style="color:#C00;font-style:inherit;"><?php _e( '您的评论正在等待审核中', 'Bing' ); ?>...</span>
			<?php endif; ?>
		</div>
		<div class="clear"></div>
<?php
}

/**
	*评论列表结束
*/
function Bing_end_comment_list(){
	echo '</li>';
}

//Page End.
