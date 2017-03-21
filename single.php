<?php get_header(); ?>
<?php if ( is_single()) { ?>
<script>
$(".post_prev a, .post_next a").css("display","block");
</script>
<?php } ?>
<section id="container">
<span class="post_prev"><?php previous_post_link('%link') ?></span>
<span class="post_next"><?php next_post_link('%link') ?></span>
<script>
$(function(){
if($("#sidebar").css('display') == 'none'){
   $("#sidebar").css('display','block');
   $("#sidebar").animate({width:"330px",opacity:"1",display:"block"},1000);
   }
})
</script>
	<?php the_post(); ?>
	<article class="post_main">
		<header>
			<?php if( mpanel( 'breadcrumbs' ) ) Bing_breadcrumbs( '<div class="post_map">', '</div>', __( '当前位置：', 'Bing' ) ); ?>
			<?php the_title( '<h2 class="title">', '</h2>' ); ?>
		</header>
		<div class="main article context"><?php the_content(); ?></div>
	</article>
<div class="post_meta">本文由&nbsp;<?php the_author_posts_link(); ?>&nbsp;于&nbsp;<?php the_time( 'Y年-n月-j日' ); ?>&nbsp;发布在&nbsp;[&nbsp;<?php the_category(', ') ?>&nbsp;]&nbsp;分类下，当前已被围观&nbsp;<?php Bing_get_views( false ); ?>&nbsp;次<br/><i></i>相关标签：<?php the_tags( '', '&nbsp;&nbsp;', '' ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i></i>原文链接
：<a href="<?php the_permalink() ?>" title="<?php the_title(); ?> - 原文链接"><?php the_permalink() ?></a></div><!--标签等信息的调用-->

<div class="share" >
<span title="将本文分享至..."><i class="fa fa-plus"></i></span>
<a target="_blank" rel="nofollow" href="http://v.t.sina.com.cn/share/share.php?&url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" title="新浪微博"><i class="icon-weibo"></i></a>   
<a target="_blank" rel="nofollow" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>&desc=&summary=&site=" title="QQ空间"><i class="icon-qzone"></i></a>  
<a target="_blank" rel="nofollow" href="http://www.douban.com/recommend/?url=<?php the_permalink(); ?>&title=<?php the_title(''); ?>"  title="豆瓣"><i class="icon-douban"></i></a>   
<a target="_blank" rel="nofollow" href="http://www.kaixin001.com/rest/records.php?url=<?php the_permalink(); ?>&style=11&content=<?php the_title(''); ?>&stime=&sig="  title="开心网"><i class="icon-kx001"></i></a>   
<a target="_blank" rel="nofollow" href="http://share.renren.com/share/buttonshare?link=<?php the_permalink(); ?>&title=<?php the_title(''); ?>" title="人人网"><i class="icon-renren"></i></a>   
<a target="_blank" rel="nofollow" href="http://cang.baidu.com/do/add?iu=<?php the_permalink(); ?>&it=<?php the_title(''); ?>&linkid=hjm6y313aqz" title="百度云资源分享"><i class="icon-baidu"></i></a>   
<a target="_blank" rel="nofollow" href="<?php bloginfo( 'url' ); ?>/feed" title="订阅本站"><i class="fa fa-rss"></i></a>   
</div>  
	<?php do_action( 'article-after' ); ?><!--//相关文章函数的调用-->
	<?php if( comments_open() ) comments_template( '', true ); ?>
</section>
<?php get_footer(); ?>