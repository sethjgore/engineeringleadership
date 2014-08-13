<?php if(!isset($_REQUEST["um_ajax_load_site"])): ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <?php if(get_field("smartphone_logo","options")): ?>
        <link rel="shortcut icon" href="<?php the_field("smartphone_logo","options") ?>" type="image/x-icon">
    <?php endif; ?>
    <?php if(get_field("favicon","options")): ?>
        <link rel="icon" href="<?php the_field("favicon","options") ?>" type="image/x-icon">
    <?php endif; ?>
    <title><?php bloginfo('name'); ?> | <?php if(is_home() || is_front_page()){ bloginfo("description"); } wp_title("",true,""); ?></title>

    <script type="text/javascript">
        var um_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        var paged_projects = 0;
        var blog_page = 0;
        var filter = 'popular'; /*popular,recent,any kind of categories*/
        var ajax_site = <?php echo get_field("ajax_site","options") == "Disabled" ? "false" : "true"; ?>;
		<?php
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
            echo "ajax_site = 0;";
        }
        ?>
    </script>
	<!--[if IE]>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css" media="screen" type="text/css" />
    <![endif]-->
    <?php wp_head(); ?>
</head>
<?php
    $portfolio_gallery = isset($GLOBALS["portfolio_gallery"]) && $GLOBALS["portfolio_gallery"] ? "portfolio_gallery" : "";
?>
<body <?php body_class($portfolio_gallery); ?>>
<div class="top-border"></div>
<div class="bottom-border"></div>
<div class="left-border"></div>
<div class="right-border"></div>
    <div class="loader">
      <div class="loading"> </div>
    </div>
<div class="header <?php echo get_field("center_menu","options") == "Enabled" ? "container menu_centered" : ""; ?>">
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_field("site_logo") ? get_field("site_logo") : get_field("main_logo","options"); ?>" alt=""/>
        </a>
    </div>
	<div class="responsive_logo">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo get_field("mobile_logo","options") ? get_field("mobile_logo","options") : get_field("main_logo","options"); ?>" alt=""/>
        </a>
    </div>
    <div class="right_header">

        <div class="menu">
            <?php
				$main_menu_class = get_field("mobile_menu","option") == "Select" ? "select_menu_activated" : "collapse ";
                wp_nav_menu( array(
                        'menu'              => 'primary',
                        'theme_location'    => 'main_menu',
                        'depth'             => 6,
                        'container'         => 'div',
                        'container_class'   => 'navbar-collapse navHeaderCollapse '.$main_menu_class,
                        'menu_class'        => 'nav navbar-nav navbar-left',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                );
				if(get_field("mobile_menu","option") == "Select"){
					wp_nav_menu( array(
							'menu'              => 'primary',
							'theme_location'    => 'main_menu',
							'depth'             => 6,
							'container'         => 'div',
							'items_wrap'      => '<select id="%1$s" class="%2$s">%3$s</select>',
							'container_class'   => 'select_drop_down',
							'menu_class'        => '',
							'walker'            => new select_menu_walker())
					);
				}
            ?>
        </div>
		<?php if(is_woocommerce_active() && get_field("cart_header","options") != "Disabled"): ?>
        <div class="cart_icon">
            <a href="#">
                <div class="count_pr"><p><?php global $woocommerce;echo $woocommerce->cart->cart_contents_count; ?></p></div>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                <path id="shopping-bag-2-icon" d="M361.5,215.333V432h-211V215.333H361.5 M391.5,185.333h-271V462h271V185.333L391.5,185.333z
                     M204,160.333V132c0-28.673,23.327-52,52-52s52,23.327,52,52v28.333h30V132c0-45.287-36.713-82-82-82s-82,36.713-82,82v28.333H204z"
                    />
                </svg>
            </a>
			<div class="cart_contents fadeInUp animated"><?php the_widget("WC_Widget_Cart"); ?></div>
        </div>
		<?php endif; ?>
        <div class="social-icons">
            <?php
                $repeater = get_field("social_networks","options");
                if($repeater):
                    foreach($repeater as $r):
            ?>
                <a href="<?php echo $r["social_network_url"]; ?>" target="_blank"><i class="fa <?php echo $r["social_network"]; ?>"></i></a>
            <?php
                    endforeach;
                endif;
            ?>
        </div>
        <?php if(get_field("mobile_menu","option") != "Select"): ?>
		<button class="navbar-toggle navbar-toggle-color" data-toggle="collapse" data-target=".navHeaderCollapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
		<?php endif; ?>
        <?php
            /*wp_nav_menu(array(
                    'theme_location' => 'main_menu',
                    'items_wrap'     => '<div class="responsive_menu"><form><select onchange="if (this.value) window.location.href=this.value">%3$s</select></form></div>',
                    'container'      => false,
                    'walker'         => new Walker_Responsive_Menu())
            );*/
        ?>
    </div>
</div>
<div class="clearfix"></div>
<div class="container inner_content">
<?php //the_widget("WC_Widget_Cart"); ?>
<?php endif; ?>