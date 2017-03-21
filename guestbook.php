<?php
/*
Template Name: Guestbook
*/
?>
<?php get_header(); ?>
<section id="container">
<script>
$(function(){
if($("#sidebar").css('display') == 'none'){
   $("#sidebar").css('display','block');
   $("#sidebar").animate({width:"330px",opacity:"1",display:"block"},1000);
   }
})
</script>
	<?php the_post(); ?>
	<article>
		<div class="guestbook_content">
		<?php the_content(); ?>
		</div>
	</article>
	<?php if( comments_open() ) comments_template( '', true ); ?>
</section>
<?php get_footer(); ?>