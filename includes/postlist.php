<?php
/**
	*主循环内容
*/
function Bing_postlist_loop( $number = false, $cat = false, $pic = false ){
	wp_reset_query();
	if( is_archive() || is_search() )://如果是文档归档页面  以及搜索结果页面
?>
		<div class="archive-header">
			<div class="main"><?php echo Bing_archive_header( null, null, true ); ?></div>
		</div>
<?php
	endif;
	if( have_posts() ):
		if( $pic ) $picclass = ' listpic';
		else $picclass = '';
		echo '<ul class="postlist' . $picclass . '">';
		while( have_posts() ):
			the_post();
			Bing_postlist_li( $pic );
		endwhile;
		echo '</ul><div claas="clear"></div>';
		Bing_get_pagenavi( false, false, '<div class="pagenavi"><div class="main">', '<div class="clear"></div></div></div>' );
	else:
		echo '<article class="post_nolist">';
			_e( '暂时没有您想要的结果呦，建议使用检索功能或替换更加精准的关键词', 'Bing' );
		echo '</article>';
	endif;
}

/**
	*列表样式（定义主文章列表的遍历样式）
*/
function Bing_postlist_li(){
	global $post;
	$type = $post->post_type;
?>
	<li <?php post_class( 'display' ); ?>>
		<?php if( $type == 'announcement' ): ?>

			<div class="avatar" title="<?php the_author(); ?>"><?php echo get_avatar( get_the_author_meta( 'email' ), '74' ); ?><?php the_author_nickname(); ?>：<?php the_time('m-d'); ?></div>

			<div class="main context"><?php echo $post->post_content; ?></div>
		<?php else: ?>
			<div class="main">
				<div class="main_img"><?php if( mpanel( 'thumbnail' ) ) Bing_thumbnail( 300, 180 ); ?><?php Bing_postmeta(); ?></div>
				<div class="main_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
				<p class="summary"><?php
	$content = get_the_content();
	$trimmed_content = wp_trim_words( $content, 500, '...' );
	echo $trimmed_content;
?><i class="summary_more"></i></p>
			</div>
		<?php endif; ?>
	</li>
<?php
}

/**
	*信息样式（遍历模块的底部小按钮）
*/
function Bing_postmeta(){
?>
	<div class="postmeta">
		<span class="auth"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
		<span class="time"><i class="fa fa-clock-o"></i><?php the_time( 'n-j' ); ?></span>
		<span class="eye"><i class="fa fa-eye"></i><?php Bing_get_views( false ); ?></span>
		<span class="comm"><i class="fa fa-comments-o"></i><?php comments_popup_link( '' . __( '沙发', 'Bing' ), '2', '%', '', '' . __( '禁评', 'Bing' ) ); ?></span>
		<span class="cate"><i class="fa fa-list"></i><?php the_category(', ') ?></span>
		<?php the_tags( '<span class="tag"><i class="fa fa-tags"></i>', '&nbsp;&nbsp;', '</span>' ); ?>
	</div>
<?php
}

//Page End.