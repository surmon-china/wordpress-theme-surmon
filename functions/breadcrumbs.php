<?php
/**
	*面包屑导航
*/
function Bing_breadcrumbs( $before = '', $after = '', $at = '', $delimiter = '<i class="fa fa-angle-right"></i>' ){
	if( is_home() || is_front_page() ) return;
	echo $before;
		echo '<div itemscope itemtype="http://schema.org/WebPage" id="breadcrumb" class="bc94">';
		global $post;
		$homeLink = home_url();
		echo $at;
		echo '<a itemprop="breadcrumb" href="' . $homeLink . '"><i class="fa fa-home"></i>' . __('首页', 'Bing') . '</a> ' . $delimiter . ' ';
		if( is_category() ){
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category( $thisCat );
			$parentCat = get_category( $thisCat->parent );
			if( $thisCat->parent != 0 ){
				$cat_code = get_category_parents( $parentCat, true, ' ' . $delimiter . ' ' );
				echo $cat_code = str_replace( '<a', '<a itemprop="breadcrumb"', $cat_code );
			}
			echo single_cat_title( '', false );
		}elseif( is_day() ){
			echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
			echo '<a itemprop="breadcrumb"  href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
			echo get_the_time( 'd' );
		}elseif( is_month() ){
			echo '<a itemprop="breadcrumb" href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
			echo get_the_time( 'F' );
		}elseif( is_year() ) echo get_the_time( 'Y' );
		elseif( is_single() && !is_attachment() ){
			if( get_post_type() != 'post' ){
				$post_type = get_post_type_object( get_post_type() );
				$slug = $post_type->rewrite;
				echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo __( '正文', 'Bing' );
			}else{
				$cat = get_the_category();
				$cat = $cat[0];
				$cat_code = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
				echo $cat_code = str_replace( '<a', '<a itemprop="breadcrumb"', $cat_code );
				echo __( '正文', 'Bing' );
			}
		}elseif( is_attachment() ){
			$parent = get_post( $post->post_parent );
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			echo '<a itemprop="breadcrumb" href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo get_the_title();
		}elseif( is_page() && !$post->post_parent ) echo get_the_title();
		elseif( is_page() && $post->post_parent ){
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while( $parent_id ){
				$page = get_page( $parent_id );
				$breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
		          foreach( $breadcrumbs as $crumb ) echo $crumb . ' ' . $delimiter . ' ';
			echo get_the_title();
		}elseif( is_search() ) printf( __( '搜索：%s', 'Bing' ) , get_search_query() );
		elseif( is_tag() ) printf( __( '标签：%s', 'Bing' ) , single_tag_title( '', false ) );
		elseif( is_author() ){
			global $author;
			$userdata = get_userdata( $author );
			printf( __( '作者：%s', 'Bing' ), $userdata->display_name );
		}elseif( is_404() ) echo '404';
		elseif( !is_single() && !is_page() && get_post_type() != 'post' ){
			$post_type = get_post_type_object( get_post_type() );
			echo $post_type->labels->singular_name;
		}
		if( get_query_var( 'paged' ) ) if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo sprintf( __( '（第 %s 页）', 'Bing' ), get_query_var( 'paged' ) );
		echo '</div>';
	echo $after;
}

//Page End.
