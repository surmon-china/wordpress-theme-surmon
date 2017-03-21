<?php
/**
	*主题设置
*/
class Bing_mpanel{

	//设置默认值
	public $original = array();

	//选项分页 ID
	public $page = 0;

	//选项组 ID
	public $group = 0;

	//验证随机数 ID
	public $nonce;

	//初始化
	function __construct(){
		$this->nonce = THEME_FOLDER . '_mpanel_nonce';
		if( isset( $_GET['activated'] ) ) add_action( 'load-themes.php', array( $this, 'redirect' ), 99 );
		add_action( 'mpanel_content', array( $this, 'save' ) );
		add_action( 'wp_ajax_mpanel-save', array( $this, 'save' ) );
		add_action( 'mpanel_content', array( $this, 'register_scripts' ), 9 );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_bar_menu', array( $this, 'add_top_menu' ), 100 );
	}

	//启用主题自动跳转
	function redirect(){
		wp_redirect( admin_url( 'admin.php?page=mpanel' ) );
		die;
	}

	//数组数据处理
	function clean( &$value ){
		$value = addslashes( stripslashes( htmlspecialchars( $value ) ) );
	}

	//保存设置
	function save(){
		if( !( $_GET['page'] == 'mpanel' || $_POST['action'] == 'mpanel-save' ) || !isset( $_POST ) || !is_super_admin() || !wp_verify_nonce( $_POST['mpanel_noncename'], $this->nonce ) ) return;
		$content = $_POST;
		if( $content['mpanel-restore-settings'] ){
			delete_option( THEME_MPANEL_NAME );
			return;
		}
		$json = json_decode( base64_decode( $content['mpanel-import'] ), true );
		if( $content['mpanel-import'] && is_array( $json ) && !empty( $json ) ){
			update_option( THEME_MPANEL_NAME, $json );
			return;
		}
		if( !isset( $content['mpanel'] ) ) return;
		$content = $content['mpanel'];
		unset( $content['mpanel-export'] );
		array_walk_recursive( $content, array( $this, 'clean' ) );
		update_option( THEME_MPANEL_NAME, $content );
		unset( $this->options );
		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) wp_die( '1' );
	}

	//创建页面
	function add_menu(){
		add_menu_page(
			sprintf( __( '%s 设置', 'Bing' ), THEME_NAME ),
			THEME_NAME,
			'install_themes',
			'mpanel',
			array( $this, 'ui' ),
			'dashicons-awards'
		);
	}

	//在顶部工具栏创建菜单
	function add_top_menu( $meta = true ){
		if( !is_user_logged_in() || !is_super_admin() || !is_admin_bar_showing() ) return;
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id' => 'mpanel',
			'title' => THEME_NAME,
			'href' => admin_url( 'admin.php?page=mpanel' )

		));
	}

	//挂载脚本
	function register_scripts(){
		$url = get_template_directory_uri() . '/mpanel';
		wp_register_style( 'mpanel-style', $url . '/css/css.php' );
		wp_enqueue_style( 'mpanel-style' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_script( 'mpanel-main', $url . '/js/mpanel.js', array( 'jquery', 'wp-color-picker' ), '', true );
	}

	//获取设置
	function get( $name ){
		$content = (array) get_option( THEME_MPANEL_NAME );
		if( !isset( $content[$name] ) ) return;
		$content = $content[$name];
		if( is_string( $content ) ) $content = htmlspecialchars_decode( stripslashes( $content ) );
		return $content;
	}

	//设置界面
	function ui(){
		do_action( 'mpanel_content' );
		echo '<div id="mlan_welcome"></div><div id="mpanel-wrap">';
			ob_start();
			echo '<form method="post" action="" id="mpanel-form">';
				echo '<div class="mpanel-menu-box"><h1 class="mpanel-logo"></h1><ul class="mpanel-menu">';
					$i = 0;
					foreach( Bing_mpanel_menu() as $id => $value ){
						$i++;
						echo '<li class="' . $id . ' no' . $i . '">' . $value . '</li>';
					}
				echo '</ul></div>';
				$mpanel_save = '<input name="mpanel-save" type="submit" class="mpanel-submit mpanel-save" value="' . __( '保存设置', 'Bing' ) . '" />';
				wp_nonce_field( $this->nonce, 'mpanel_noncename' );
				echo $mpanel_save . '<div class="mpanel-mian-panel">';
				Bing_mpanel_panel();
			$mpanel_foot = '<form method="post" action="" id="mpanel-form-restore-settings"><input type="submit" name="mpanel-restore-settings" title="' . __( '恢复初始设置', 'Bing' ) . '" onclick="return confirm( \'' . __( '所有目前的设置都会被恢复到初始状态，无法恢复。你确定？', 'Bing') . '\' ) ? true : false;" value="' . __( '恢复初始设置', 'Bing' ) . '" class="mpanel-submit mpanel-restore-settings"></form>';
			$mpanel_save = '<input name="mpanel-save" type="submit" class="mpanel-submit mpanel-save2" value="' . __( '保存设置', 'Bing' ) . '" />';
			echo '</div>' . $mpanel_save . '</form>' . $mpanel_foot;
			array_walk_recursive( $this->original, array( $this, 'clean' ) );
			if( add_option( THEME_MPANEL_NAME, $this->original ) ){
				ob_clean();
				echo '<h1 id="mpanel-renovate">' . __( '五秒钟页面如果没有自动刷新请手动刷新页面！', 'Bing' ) . '</h1><script type="text/javascript">window.location.reload();</script>';
			}
		echo '</div>';
		echo '<div id="mpanel-load"></div>';
	}

}
$mpanel = new Bing_mpanel;

//Page End.
