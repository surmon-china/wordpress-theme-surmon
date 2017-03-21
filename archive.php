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
	<?php Bing_postlist_loop(); ?>
</section>
<?php get_footer(); ?>