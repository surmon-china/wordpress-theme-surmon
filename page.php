<?php get_header(); ?>
<section id="container">
	<?php the_post(); ?>
	<article <?php post_class( 'display' ); ?>>
		<header>
			<?php if( mpanel( 'breadcrumbs' ) ) Bing_breadcrumbs( '<div class="right">', '</div>', __( '当前位置：', 'Bing' ) ); ?>
			<?php the_title( '<h2 class="title">', '</h2>' ); ?>
		</header>
		<div class="main article context"><?php the_content(); ?></div>
	</article>
	<?php if( comments_open() ) comments_template( '', true ); ?>
</section>
<?php get_footer(); ?>