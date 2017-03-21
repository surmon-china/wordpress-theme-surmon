<?php
/**
	*文章存档
*/
function Bing_page_archive(){
	$output = get_option( 'Bing_archives_list' );
	if( $output ){
		echo $output;
		return;
	}
	query_posts( 'posts_per_page=-1&ignore_sticky_posts=1&post_type=post' );
	if( have_posts() ):
		echo '<ul class="archive">';
		$year = 0;
		$mon = 0;
		$i = 0;
		$j = 0;
		while( have_posts() ):
			the_post();
			$year_tmp = get_the_time( 'Y' );
			$mon_tmp = get_the_time( 'm' );
			$y = $year;
			$m = $mon;
			if( $mon != $mon_tmp && $mon > 0 ) $output .= '</ul></li>';
			if( $year != $year_tmp && $year > 0 ) $output .= '</ul>';
			if( $year != $year_tmp ){
				$year = $year_tmp;
				$output .= '<h3 class="year">' . sprintf( __( '%s 年', 'Bing' ), $year ) . '</h3><ul class="mon_list">';
			}
			if( $mon != $mon_tmp ){
				$mon = $mon_tmp;
				$output .= '<li><h4 class="al_mon">' . sprintf( __( '%s 月', 'Bing' ), $mon ) . '</h4><ul class="post_list">';
			}
			$output .= '<li>'. get_the_time( __( 'd日：', 'Bing' ) ) . '<a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		endwhile;
		$output .= '</ul></li></ul></ul>';
	endif;
	update_option( 'Bing_archives_list', $output );
	echo $output;
}

/**
	*清除文章存档缓存
*/
function Bing_page_archive_clear_cache(){
	delete_option( 'Bing_archives_list' );
}
add_action( 'save_post', 'Bing_page_archive_clear_cache' );
