<aside id="sidebar">
<div class="search_box">
		<?php get_search_form(); ?>
		<a href="<?php bloginfo( 'url' ); ?>/feed" rel="nofollow" target="_blank"><div class="follow">Feed</div></a>
		<a href="http://user.qzone.qq.com/794939078/main" rel="nofollow" target="_blank"><div class="follow" id="qz">Follow</div></a>
	</div>
<div id="sidebar_main">
<ul class="sidebar_post_list">
<?php $result = $wpdb->get_results("SELECT ID,post_title FROM $wpdb->posts where post_status='publish' and post_type='post' ORDER BY ID DESC LIMIT 0 , 13");
foreach ($result as $post) {
setup_postdata($post);
$postid = $post->ID;
$title = $post->post_title;
?>
<li><i class="sidebar_post_list_num"></i><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>"><?php echo $title ?></a></li>
<?php } ?>
</ul>
<div class="sidebar_date">
<span id="sidebar_time"></span>
<script src="<?php bloginfo('template_url'); ?>/js/sidebar_time.js"></script>
<?php get_calendar(); ?></div>
<div id="sidebar_fixed">
<div class="sidebar_fixed_ad"><a href="http://surmon.me/go/aliyun" target="_blank" rel="nofollow"><img src="http://surmon.me/wp-content/themes/Surmon/images/aliyun_sidebar_ad.gif" id="imgToGray"></a></div>
 <?php $html = '<ul class="sidebar_tag">';
foreach (get_tags( array('number' => 45, 'orderby' => 'count', 'order' => 'DESC', 'hide_empty' => false) ) as $tag){
        $tag_link = get_tag_link($tag->term_id);
        $html .= "<a href='{$tag_link}' title='查看有关 {$tag->name} 的文章' class='{$tag->slug}'>";
        $html .= "<li>{$tag->name} ({$tag->count})</li></a>";
}
$html .= '</ul>';
echo $html; ?>
</div>
</div>
</aside>