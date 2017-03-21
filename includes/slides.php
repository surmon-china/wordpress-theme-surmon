<?php
/**
	*幻灯片样式
*/
function Bing_slides( $number = 5, $top = false, $cat = array() ){
	global $paged;
	if( $paged !== 0 ) return;
	$args = array( 'showposts' => $number );
	$top == 'top' ? $args['post__in'] = get_option( 'sticky_posts' ) : $args['ignore_sticky_posts'] = 1;
	if( $cat ) $args['category__not_in'] = $cat;
	query_posts( $args );
	if( have_posts() ):
?>
		<article class="slides owl-carousel">
<?php
			while( have_posts() ):
				the_post();
?>
				<div>
					<?php Bing_thumbnail( 620, 200 ); ?>
					<h3 class="title"><?php the_title(); ?></h3>
				</div>
			<?php endwhile; ?>
		</article>
<?php
	endif;
	wp_reset_query();
}

//Page End.
