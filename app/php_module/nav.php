<?php
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/app/wp-load.php');
?>
<?php 
    $headerNav = array(
	'theme_location'  => 'nav',
	'menu'            => '',
	'container'       => '',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'menu',
	'menu_id'         => 'nav-menu',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '<i class="aa"></i>',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
	);
?>
<?php
    echo wp_nav_menu( $headerNav );
    print(wp_nav_menu( $headerNav ));
?>
<?php wp_nav_menu( $headerNav ); ?>