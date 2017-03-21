<?php
if( basename( $_SERVER['SCRIPT_FILENAME'] ) == 'comments.php' ) die;
if( !empty( $post->post_password ) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ){
	echo '<div class="display"><div class="main"><p class="nocomments">' . __( '必须输入密码，才能查看评论！', 'Bing' ) . '</p></div></div>';
	return;
}
$oddcomment = '';
?>
<article class="comments" id="comments">
	<div class="main">
		<?php
		if( $comments ):
		?>
			<div class="commentshow">
				<ol class="commentlist">
					<?php wp_list_comments( 'type=comment&callback=Bing_comment_list&end-callback=Bing_end_comment_list&max_depth=23' ); ?>
				</ol>
				<nav class="commentnav">
					<div class="pagenavi"><?php paginate_comments_links( 'prev_text=«&next_text=»' ); ?></div>
					<div class="clear"></div>
				</nav>
			</div>
		<?php
		elseif( $post->comment_status != 'open' ):
			echo '<p class="nocomments">' . __( '评论被关闭', 'Bing' ) . '</p>';
		endif;
		if( $post->comment_status == 'open' ):
		?>
			<div id="respond_box">
				<div id="respond">
				<?php
				if( get_option( 'comment_registration' ) && !$user_ID ):
					echo '<p>' . sprintf( __( '您必须 %s 才能发布留言', 'Bing' ), '<a href="' . get_option( 'siteurl' ) . '/wp-login.php?redirect_to=' . urlencode( get_permalink() ) . ' [ 登录 ] </a>">' ) . '</p>';
				else:
				?>
					<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">
						<div class="comment-textarea">
							<?php if( !$user_ID ): ?>
								<div id="comment-author-info">
									<p class="info">
										<input type="text" name="author" id="author" class="commenttext" placeholder="<?php _e( '昵称' , 'Bing' );if ($req) echo " *"; ?>" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
										<label for="author">昵称<?php if( $req ) echo " *"; ?></label>
									</p>
									<p class="info">
										<input type="text" name="email" id="email" class="commenttext" placeholder="<?php _e( '邮箱' , 'Bing' );if ($req) echo " *"; ?>" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
										<label for="email">邮箱<?php if( $req ) echo " *"; ?> </label>
									</p>
									<p class="info last">
										<input type="text" name="url" id="url" class="commenttext" placeholder="<?php _e( '网址' , 'Bing' ); ?>" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
										<label for="url">网址</label>
									</p>
								</div>
							<?php endif; ?>
							<textarea name="comment" class="textarea" id="comment" placeholder="<?php _e( '输入评论内容...', 'Bing' ); ?>" tabindex="4" cols="50" rows="5"></textarea>
							<div class="clear"></div>
						</div>
						<p>
							<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e( '提交', 'Bing' ); ?>（Ctrl + Enter）" />
							<?php comment_id_fields(); ?>
						</p>
						<div class="smiley">
							<i class="fa fa-smile-o"></i>
							<div id="smileybox"><?php _e( '正在加载表情...', 'Bing' ); ?></div>
						</div>
						<?php if( $user_ID ): ?>
							<p class="user">
								<a href="<?php echo admin_url( 'profile.php' ); ?>"><?php echo $user_identity; ?></a>
								<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="out" title="<?php _e( '登出', 'Bing' ); ?>">[<?php _e( '登出', 'Bing' ); ?>]</a>
							</p>
						<?php endif; ?>
						<?php do_action( 'comment_form', $post->ID ); ?>
					</form>
				<?php endif; ?>
			</div>
		</div>
		<div class="clear"></div>
		<?php endif; ?>
	</div>
</article>