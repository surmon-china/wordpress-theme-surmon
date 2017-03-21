<?php
/**
	*后台选项
*/

//左边菜单
function Bing_mpanel_menu(){
	return array(
		'general' => __( '基本设置', 'Bing' ),
		'home' => __( '首页内容', 'Bing' ),
		'admin' => __( '后台设置', 'Bing' ),
		'optimization' => __( '优化配置', 'Bing' ),
		'comment' => __( '评论系统', 'Bing' ),
		'footer' => __( '底部内容', 'Bing' ),
		'ads' => __( '广告设置', 'Bing' ),
		'social' => __( '社交网络', 'Bing' ),
		'advanced' => __( '高级功能', 'Bing' )
	);
}

//选项
function Bing_mpanel_panel(){
	global $mpanel;

	//基本设置
	mpanel_page();

		//Favicon
		mpanel_group( 'Favicon' );

			//使用 Favicon
			mpanel_item( array(
				'name' => __( '使用 Favicon', 'Bing' ),
				'id' => 'favicon',
				'type' => 'checkbox',
				'open' => 'favicon_url',
				'default' => true
			) );

			//使用 Favicon
			mpanel_item( array(
				'name' => __( '自定义 Favicon', 'Bing' ),
				'id' => 'favicon_url',
				'type' => 'upload'
			) );

		mpanel_gend();

		//Logo
		mpanel_group( 'Logo' );

			//显示图片 Logo
			mpanel_item( array(
				'name' => __( '显示图片 Logo', 'Bing' ),
				'id' => 'logo',
				'type' => 'checkbox',
				'open' => 'logo_url',
				'default' => true
			) );

			//自定义 Logo
			mpanel_item( array(
				'name' => __( '自定义 Logo', 'Bing' ),
				'id' => 'logo_url',
				'type' => 'upload',
				'explain' => __( 'Logo 尺寸为 80px × 80px' )
			) );

		mpanel_gend();

		//缩略图设置
		mpanel_group( __( '缩略图设置', 'Bing' ) );

			//显示缩略图
			mpanel_item( array(
				'name' => __( '显示缩略图', 'Bing' ),
				'id' => 'thumbnail',
				'type' => 'checkbox',
				'open' => array( 'thumbnailhover', 'timthumb' ),
				'default' => true
			) );

			//Timthumb 裁剪缩略图
			mpanel_item( array(
				'name' => __( 'Timthumb 裁剪缩略图', 'Bing' ),
				'id' => 'timthumb',
				'type' => 'checkbox',
				'default' => true
			) );

			//Timthumb 帮助
			mpanel_item( array(
				'name' => __( '开启裁剪缩略图之后如果你的文章图片是外链的，请将外链的图片域名添加到主题目录的 “timthumb-config.php” 文件，打开文件可以看到添加方法', 'Bing' ),
				'type' => 'help'
			) );

		mpanel_gend();
		
		//使用 Tooltip
		mpanel_group( 'Tooltip' );

			//使用 Tooltip
			mpanel_item( array(
				'name' => __( '使用 Tooltip', 'Bing' ),
				'id' => 'tooltip',
				'type' => 'checkbox',
				'default' => true
			) );	

		mpanel_gend();

		//Ajax
		mpanel_group( 'Ajax' );

			//全站 Ajax
			mpanel_item( array(
				'name' => __( '全站 Ajax', 'Bing' ),
				'id' => 'ajax',
				'type' => 'checkbox',
				'default' => true
			) );

			//Ajax 评论
			mpanel_item( array(
				'name' => __( 'Ajax 评论', 'Bing' ),
				'id' => 'ajax_comm',
				'type' => 'checkbox',
				'default' => true
			) );

		mpanel_gend();

		//面包屑导航
		mpanel_group( __( '面包屑导航', 'Bing' ) );

			//开启面包屑导航
			mpanel_item( array(
				'name' => __( '开启面包屑导航', 'Bing' ),
				'id' => 'breadcrumbs',
				'default' => true,
				'type' => 'checkbox'
			) );

		mpanel_gend();

	mpanel_pend();

	//首页内容
	mpanel_page();

		//幻灯片
		mpanel_group( '幻灯片' );

			//显示幻灯片
			mpanel_item( array(
				'name' => __( '显示幻灯片', 'Bing' ),
				'id' => 'slides',
				'open' => array( 'slides_post', 'slides_number' ),
				'type' => 'checkbox'
			) );

			//幻灯片文章数量
			mpanel_item( array(
				'name' => __( '幻灯片文章数量', 'Bing' ),
				'id' => 'slides_number',
				'type' => 'number',
				'default' => 5
			) );

			//幻灯片文章获取方式
			mpanel_item( array(
				'name' => __( '幻灯片文章获取方式', 'Bing' ),
				'id' => 'slides_post',
				'type' => 'radio',
				'option' => array(
					'new' => __( '最新文章', 'Bing' ),
					'top' => __( '置顶文章', 'Bing' )
				),
				'default' => 'new'
			) );	

		mpanel_gend();		

		//置顶文章
		mpanel_group( '置顶文章' );

			//首页主循环置顶文章
			mpanel_item( array(
				'name' => __( '首页主循环置顶文章', 'Bing' ),
				'id' => 'home_loop_top',
				'type' => 'radio',
				'option' => array(
					'default' => __( '正常置顶', 'Bing' ),
					'none' => __( '让置顶的不置顶', 'Bing' ),
					'hide' => __( '排除置顶文章', 'Bing' )
				),
				'default' => 'default'
			) );	

		mpanel_gend();

	mpanel_pend();

	//后台设置
	mpanel_page();

		//回复评论
		mpanel_group( __( '回复评论', 'Bing' ) );

			//后台回复评论表情插入
			mpanel_item( array(
				'name' => __( '后台回复评论表情插入', 'Bing' ),
				'id' => 'admin_smiley',
				'type' => 'checkbox',
				'default' => true,
				'help' => __( '开启后在后台回复评论的时候会在回复框上添加一个表情插入按钮，以弥补后台回复评论无法直接插入表情的缺点。', 'Bing' )
			) );

			//后台回复评论快捷键
			mpanel_item( array(
				'name' => __( '后台回复评论快捷键', 'Bing' ),
				'id' => 'admin_reply_shortcuts',
				'type' => 'checkbox',
				'default' => true,
				'help' => __( '开启后在后台回复评论的时候可以使用 [ ctrl + enter ] 来提交，提高效率。', 'Bing' )
			) );

		mpanel_gend();

		//编辑
		mpanel_group( __( '编辑', 'Bing' ) );

			//后台文章编辑器功能增强
			mpanel_item( array(
				'name' => __( '后台文章编辑器功能增强', 'Bing' ),
				'id' => 'editor_buttons',
				'type' => 'checkbox',
				'default' => true,
			) );

		mpanel_gend();

	mpanel_pend();

	//优化配置
	mpanel_page();

		//文章
		mpanel_group( __( '文章', 'Bing' ) );

			//阻止站内文章互相 Pingback
			mpanel_item( array(
				'name' => __( '阻止站内文章互相 Pingback', 'Bing' ),
				'id' => 'noself_pingback',
				'type' => 'checkbox',
				'default' => true,
				'help' => __( '不了解可搜索 Pingback 了解相关内容', 'Bing' )
			) );

			//显示相关文章
			mpanel_item( array(
				'name' => __( '显示相关文章', 'Bing' ),
				'id' => 'related_posts',
				'type' => 'checkbox',
				'default' => true
			) );

		mpanel_gend();

		//头部元信息
		mpanel_group( __( '头部元信息', 'Bing' ) );

			//移除头部无用信息
			mpanel_item( array(
				'name' => __( '移除头部无用信息', 'Bing' ),
				'id' => 'remove_head_refuse',
				'type' => 'checkbox',
				'default' => true,
				'help' => __( 'WordPress 在头部输出了一些无用的信息，开启后会把他们移除', 'Bing' )
			) );

			//关闭离线编辑器接口
			mpanel_item( array(
				'name' => __( '关闭离线编辑器接口', 'Bing' ),
				'id' => 'remove_xmlrpc',
				'type' => 'checkbox',
				'help' => __( '如果你使用 WordPress 的后台编辑器可以开启此选项保证安全', 'Bing' )
			) );

			//网站描述
			mpanel_item( array(
				'name' => __( '网站描述', 'Bing' ),
				'id' => 'site_description',
				'type' => 'textarea',
				'default' => __( '优化建议：不超过 140 个字', 'Bing' )
			) );

		mpanel_gend();

		//阅读
		mpanel_group( __( '阅读', 'Bing' ) );

			//文章内链接全部在新窗口打开
			mpanel_item( array(
				'name' => __( '文章链接全部在新窗口打开', 'Bing' ),
				'id' => 'autoblank',
				'type' => 'checkbox'
			) );			

			//文章内容外链添加 nofollow 并在新窗口打开
			mpanel_item( array(
				'name' => __( '文章外链添加 nofollow 并在新窗口打开', 'Bing' ),
				'id' => 'nf_url_parse',
				'type' => 'checkbox',
				'default' => true
			) );

		mpanel_gend();

		//搜索
		mpanel_group( __( '搜索', 'Bing' ) );

			//搜索结果只包括文章
			mpanel_item( array(
				'name' => __( '搜索结果只包括文章', 'Bing' ),
				'id' => 'search_filter_page',
				'type' => 'checkbox'
			) );			

			//如果搜索结果只有一篇文章则跳转到这篇文章
			mpanel_item( array(
				'name' => __( '如果搜索结果只有一篇文章则跳转到这篇文章', 'Bing' ),
				'id' => 'search_one_redirect',
				'type' => 'checkbox',
				'default' => true
			) );

		mpanel_gend();

		//Cdn
		mpanel_group( __( 'Cdn', 'Bing' ) );

			foreach( array( 'jquery' => 'jQuery', 'font_awesome' => 'Font Awesome', 'owl_carousel' => 'Owl Carousel' ) as $id => $name ){
				mpanel_item( array(
					'name' => sprintf( __( '%s 使用 Cdn', 'Bing' ), $name ),
					'id' => $id . '_cdn',
					'type' => 'checkbox',
					'help' => __( '使用 Cdn 可以提高网站加载速度，减少服务器压力，开启后不会影响任何事情', 'Bing' )
				) );
			}

		mpanel_gend();

	mpanel_pend();

	//评论系统
	mpanel_page();

		//垃圾评论
		mpanel_group( __( '垃圾评论', 'Bing' ) );

			//垃圾评论拦截
			mpanel_item( array(
				'name' => __( '垃圾评论拦截', 'Bing' ),
				'id' => 'comment_anti',
				'type' => 'checkbox',
				'help' => __( '开启前请关闭 Akismet 插件', 'Bing' )
			) );

			//拦截不包含中文的评论
			mpanel_item( array(
				'name' => __( '拦截不包含中文的评论', 'Bing' ),
				'id' => 'comment_anti_chinese',
				'type' => 'checkbox'
			) );

			//禁止没有头像的用户评论
			mpanel_item( array(
				'name' => __( '禁止没有头像的用户评论', 'Bing' ),
				'id' => 'validate_gravatar_comment',
				'type' => 'checkbox',
				'help' => __( '谨慎开启。开启之后如果评论用户的邮箱没有 Gravatar 头像将会被禁止', 'Bing' )
			) );

		mpanel_gend();

		//评论邮件通知
		mpanel_group( __( '评论邮件通知', 'Bing' ) );

			//评论邮件通知
			mpanel_item( array(
				'name' => __( '评论邮件通知', 'Bing' ),
				'id' => 'comment_email_notify',
				'type' => 'checkbox',
				'help' => __( '当用户的评论被回复之后自动发送一封邮件提醒', 'Bing' )
			) );

		mpanel_gend();

		//回复评论加 @
		mpanel_group( __( '回复评论加 @', 'Bing' ) );

			//回复评论加 @
			mpanel_item( array(
				'name' => __( '回复评论加 @', 'Bing' ),
				'id' => 'comment_add_at',
				'type' => 'checkbox',
				'default' => true,
				'help' => __( '回复的评论会在前面加上 @ 回复的人，@ 不会被写入数据库，也就是说使用主题之前的评论也有效', 'Bing' )
			) );

		mpanel_gend();

		//评论链接
		mpanel_group( __( '评论链接', 'Bing' ) );

			//评论作者链接新窗口打开
			mpanel_item( array(
				'name' => __( '评论作者链接新窗口打开', 'Bing' ),
				'id' => 'comment_author_link_newtab',
				'type' => 'checkbox',
				'help' => __( '评论作者的链接在新窗口打开，以免流失访客', 'Bing' )
			) );

		mpanel_gend();

	mpanel_pend();

	//底部内容
	mpanel_page();

		//页脚文本区域（一）
		mpanel_group( __( '页脚横幅区域（一）', 'Bing' ) );

			//页脚文本区域（一）
			mpanel_item( array(
				'id' => 'foot_text1',
				'type' => 'bigtext',
				'default' => __( '此处为横幅区域', 'Bing' )
			) );

		mpanel_gend();

		//页脚文本区域（二）
		mpanel_group( __( '页脚文本区域（二）', 'Bing' ) );

			//页脚文本区域（二）
			mpanel_item( array(
				'id' => 'foot_text2',
				'type' => 'bigtext',
				'default' => __( '© 2015-2015 司马萌 Power by <a href="http://cn.wordpress.org" rel="external" target="_blank">WordPress</a> | Theme <a href="http://www.bgbk.org" rel="external" target="_blank">Bing-blog</a>', 'Bing' )
			) );

		mpanel_gend();

	mpanel_pend();

	//广告设置
	mpanel_page();

		foreach( array( 'header' => __( '全站头部', 'Bing' ), 'content_top' => __( '文章内容顶部', 'Bing' ), 'content_bottom' => __( '文章内容尾部', 'Bing' ), 'content' => __( '文章内容', 'Bing' ), 'shortcode' => sprintf( __( '简码 %s 的广告', 'Bing' ), '[ads]' ) ) as $id => $name ){
			$id = 'ads_' . $id . '_';
			mpanel_group( $name );

				//显示广告
				mpanel_item( array(
					'name' => __( '显示广告', 'Bing' ),
					'id' => $id . 'display',
					'type' => 'checkbox'
				) );

				//广告图片
				mpanel_item( array(
					'name' => __( '广告图片', 'Bing' ),
					'id' => $id . 'img',
					'type' => 'upload'
				) );

				//广告链接
				mpanel_item( array(
					'name' => __( '广告链接', 'Bing' ),
					'id' => $id . 'url',
					'type' => 'text'
				) );

				//鼠标停放时提示的文本
				mpanel_item( array(
					'name' => __( '鼠标停放时提示的文本', 'Bing' ),
					'id' => $id . 'alt',
					'type' => 'text'
				) );

				//在新窗口打开链接
				mpanel_item( array(
					'name' => __( '在新窗口打开链接', 'Bing' ),
					'id' => $id . 'tab',
					'type' => 'checkbox',
					'default' => true
				) );

				//自定义广告代码
				mpanel_item( array(
					'name' => __( '自定义广告代码', 'Bing' ),
					'id' => $id . 'code',
					'type' => 'textarea',
					'help' => __( '如果这里留空则使用上边的图片广告，否则使用此代码', 'Bing' )
				) );

				//自动下架
				mpanel_item( array(
					'name' => __( '自动下架', 'Bing' ),
					'id' => $id . 'date',
					'type' => 'date',
					'help' => __( '如果这里不留空则在此日期后自动下架广告', 'Bing' )
				) );

			mpanel_gend();		
		}

	mpanel_pend();

	//社交网络
	mpanel_page();

		//网站相关
		mpanel_group( __( '网站相关', 'Bing' ) );

			//建站日期
			mpanel_item( array(
				'name' => __( '建站日期', 'Bing' ),
				'id' => 'found_date',
				'type' => 'date',
				'help' => __( '输入您建立此网站的时间，此内容用来统计', 'Bing' ),
				'default' => '2015-7-01'
			) );

		mpanel_gend();

		//国内社交网络
		mpanel_group( __( '国内社交网络', 'Bing' ) );

			//国内社交网络帮助
			mpanel_item( array(
				'name' => __( '如果要填写网址请包括 http://，下同', 'Bing' ),
				'type' => 'help'
			) );

			//国内社交网络帮助2
			mpanel_item( array(
				'name' => __( '下边所有选项都是选填，尽可能将有的都填上', 'Bing' ),
				'type' => 'help'
			) );

			//新浪微博
			mpanel_item( array(
				'name' => __( '新浪微博', 'Bing' ),
				'id' => 'weibo_url',
				'type' => 'text',
				'default' => 'http://weibo.com/*******'
			) );

			//腾讯微博
			mpanel_item( array(
				'name' => __( '腾讯微博', 'Bing' ),
				'id' => 't_weibo_url',
				'type' => 'text',
				'default' => 'http://t.qq.com/********'
			) );
		mpanel_gend();

		//站长信息
		mpanel_group( __( '站长信息', 'Bing' ) );

			//邮箱
			mpanel_item( array(
				'name' => __( '邮箱', 'Bing' ),
				'id' => 'email',
				'type' => 'text',
				'default' => 'admin@xxxxx.com'
			) );

			//QQ
			mpanel_item( array(
				'name' => __( 'QQ 号', 'Bing' ),
				'id' => 'qq',
				'type' => 'text',
				'default' => '88888888'
			) );

			//RSS 地址
			mpanel_item( array(
				'name' => __( 'RSS 地址', 'Bing' ),
				'id' => 'rss_url',
				'type' => 'text',
				'default' => get_bloginfo( 'rss2_url' )
			) );

		mpanel_gend();

	mpanel_pend();

	//高级功能
	mpanel_page();

		//头像缓存
		mpanel_group( __( '头像缓存', 'Bing' ) );

			//头像缓存
			mpanel_item( array(
				'name' => __( '头像缓存', 'Bing' ),
				'id' => 'avatar_cache',
				'type' => 'checkbox',
				'open' => 'avatar_cache_day'
			) );

			//缓存天数
			mpanel_item( array(
				'name' => __( '缓存天数', 'Bing' ),
				'id' => 'avatar_cache_day',
				'type' => 'number',
				'default' => 15
			) );

		mpanel_gend();
		//自定义头部代码
		mpanel_group( __( '自定义头部代码', 'Bing' ) );

			//自定义头部代码
			mpanel_item( array(
				'id' => 'head_code',
				'type' => 'bigtext'
			) );

		mpanel_gend();

		//自定义页脚代码
		mpanel_group( __( '自定义页脚代码', 'Bing' ) );

			//自定义页脚代码
			mpanel_item( array(
				'id' => 'footer_code',
				'type' => 'bigtext'
			) );

		mpanel_gend();

		//自定义全局 CSS
		mpanel_group( __( '自定义全局 CSS', 'Bing' ) );

			//自定义全局 CSS
			mpanel_item( array(
				'id' => 'custom_css',
				'type' => 'bigtext'
			) );

		mpanel_gend();

		//导出设置
		mpanel_group( __( '导出设置', 'Bing' ) );

			//自定义导出设置头部代码
			mpanel_item( array(
				'id' => 'export',
				'type' => 'bigtext'
			) );

		mpanel_gend();

		//导入设置
		mpanel_group( __( '导入设置', 'Bing' ) );

			//导入设置
			mpanel_item( array(
				'id' => 'import',
				'type' => 'bigtext'
			) );

		mpanel_gend();

	mpanel_pend();
}

//Page End.
