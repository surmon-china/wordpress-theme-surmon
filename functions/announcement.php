<?php
/**
	*添加公告文章类型
*/
class Bing_post_announcement{

	//文章类型别名
	public $name = 'announcement';

	//初始化
	function __construct(){
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'manage_edit-' . $this->name . '_columns', array( $this, 'columns' ) );
		add_action( 'manage_' . $this->name . '_posts_custom_column', array( $this, 'column' ) );
		add_action( 'admin_head', array( $this, 'hide_title' ) );
		add_filter( 'post_type_link', array( $this, 'link' ), 1, 2 );
		add_action( 'init', array( $this, 'rewrite' ) );
	}

	//注册
	function register(){
		register_post_type( $this->name, array(
			'labels' => array(
				'name' => __( '公告', 'Bing' ),
				'singular_name' => __( '公告', 'Bing' ),
				'add_new' => __( '添加', 'Bing' ),
				'add_new_item' => __( '添加新公告', 'Bing' ),
				'edit_item' => __( '编辑公告', 'Bing' ),
				'view_item' => __( '编辑公告', 'Bing' ),
				'search_items' => __( '搜索公告', 'Bing' ),
				'not_found' => __( '还没有公告', 'Bing' ),
				'not_found_in_trash' => __( '在回收站中没有发现公告', 'Bing' ),
			),
			'public' => true,
			'menu_position' => 4,
			'supports' => 'editor',
			'taxonomies' => array(),
			'menu_icon' => 'dashicons-format-status',
			'has_archive' => true
		));
	}

	//数据列
	function columns( $columns ){
		return array(
			'cb' => '<input type="checkbox" />',
			$this->name => __( '公告', 'Bing' ),
			'title' => __( '操作', 'Bing' ),
			'date' => __( '时间', 'Bing' )
		);
	}

	//数据列内容
	function column( $column ){
		global $post;
		if( $column == $this->name ) echo mb_strimwidth( strip_tags( $post->post_content ), 0, 500, '...' );		
	}

	//隐藏列表标题
	function hide_title(){
		if( !isset( $_GET['post_type'] ) || $_GET['post_type'] != $this->name ) return;
		echo '<style type="text/css">.row-actions{visibility:visible !important;}.column-title strong{display:none !important;}</style>';
	}

	//自定义固定连接
	function link( $link, $post = 0 ){
		if( $post->post_type == $this->name ) return home_url( $this->name . '/' . $post->ID . '.html' );
		return $link;
	}

	//固定链接伪静态规则
	function rewrite(){
		add_rewrite_rule( $this->name . '/([0-9]+)?.html$', 'index.php?post_type=' . $this->name . '&p=$matches[1]', 'top' );
	}

}
new Bing_post_announcement;

//Page End.
