<?php
error_reporting(0);
if ( ! isset( $content_width ) ){ $content_width = 900; }
add_action( 'after_setup_theme', 'umbrella_theme_setup' );
function umbrella_theme_setup(){
	add_theme_support( 'woocommerce' );
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    load_theme_textdomain('um_lang', get_template_directory() . '/lang');
}

/*Includes*/
define( 'ACF_LITE' , true );
include_once('acf/acf.php' );
include_once('includes/addons/acf-repeater/acf-repeater.php');
include_once('includes/addons/acf-flexible-content/acf-flexible-content.php');
include_once('includes/addons/acf-options-page/acf-options-page.php' );
require_once "includes/custom-fields.php";
require_once "includes/aq_resizer.php";
require_once "includes/wp_bootstrap_walker.php";
require_once "includes/et_icons.php";
require_once "shortcodes/shortcodes.php";
require_once "widgets/widgets.php";
//require_once "includes/dropdown-walker.php";
require_once "includes/google-fonts.php";
require_once "includes/oneclick/um_oneclick_demo.php";
require_once "includes/woocommerce-twitterbootstrap.php";
require_once "includes/wp_select_menu_walker.php";
/*Includes*/

/*Field Types*/
add_action('acf/register_fields', 'my_register_fields');
function my_register_fields(){
    include_once('includes/ui-drag/ui_drag-v4.php');
    include_once('includes/advanced-custom-fields-code-area-field/acf_code_area-v4.php');
}
/*Field Types*/

/*Register Menu*/
add_action('init', 'register_my_menus');

function register_my_menus()
{
    register_nav_menus(
        array(
            'main_menu' => __('Main Menu', "um-lang")
        )
    );
}
/*Register Menu*/

/*Register Option Pages*/
if (function_exists("register_options_page")) {
    register_options_page('Main');
    register_options_page('Branding');
    register_options_page('Social');
}
/*Register Option Pages*/

/*Register Portfolio Post Types*/
add_action("init","um_post_types");
function um_post_types(){
    $rewrite = array();
    $rewrite["slug"] = "portfolio";
    $rewrite["with_front"] = true;

    register_post_type('portfolio',
        array(
            'labels' => array(
                'name' => __( "Portfolio" ,"um_lang"),
                'singular_name' => __( "Portfolios" , "um_lang" )
            ),
            'public' => true,
            'supports' => array('title','editor','thumbnail','comments','author'),
            'rewrite' => $rewrite
        )
    );

    register_post_type( 'contact_form',
        array(
            'labels' => array(
                'name' => __( "Contact Forms" ,"um_lang"),
                'singular_name' => __( "Contact Form" , "um_lang" )
            ),
            'public' => true,
            'supports' => array('title')
        )
    );

    register_taxonomy('portfolio_category',array (
        0 => 'portfolio',
    ),array( 'hierarchical' => true, 'label' => 'Portfolio Category','show_ui' => true,'query_var' => 'portfolio_category' ,'singular_label' => 'Portfolio Category' , 'rewrite' => array('slug'=>'portfolio_category') ) );

}
/*Register Portfolio Post Types*/

/*is WooCommerce active*/
if(!function_exists('is_woocommerce_active')){
	function is_woocommerce_active(){
		global $woocommerce;
		return $woocommerce instanceof WooCommerce;
	}
}
/*is WooCommerce active*/

/*Sidebars*/
function um_sidebar_widgets_init(){
	register_sidebar( array(
        'name' => __('Shop' , "um_lang"),
        'id' => 'shop',
        'description' => __( 'Shop' ,"um_lang" ),
        'before_widget' => '<div id="%1$s" class="um_widget widget col-sm-12 %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ) );
	
	register_sidebar( array(
        'name' => __('Default Page Sidebar' , "um_lang"),
        'id' => 'page_sidebar',
        'description' => __( 'Sidebar' ,"um_lang" ),
        'before_widget' => '<div id="%1$s" class="um_widget widget col-sm-12 %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<div class="widget_title"><h5>',
        'after_title' => '</h5></div>',
    ) );
	
    register_sidebar( array(
        'name' => __('Sidebar' , "um_lang"),
        'id' => 'sidebar',
        'description' => __( 'Sidebar' ,"um_lang" ),
        'before_widget' => '<div id="%1$s" class="um_widget widget col-sm-4 %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<div class="widget_title"><h5>',
        'after_title' => '</h5></div>',
    ) );
}

add_action( 'widgets_init', 'um_sidebar_widgets_init' );
/*Sidebars*/

/*Contact Form Ajax*/
add_action('wp_ajax_um_send_email', 'um_send_email');
add_action('wp_ajax_nopriv_um_send_email', 'um_send_email');

function um_send_email(){
    $name = $_REQUEST["um_name"];
    $email = $_REQUEST["um_email"];
    $message = $_REQUEST["um_message"];
    $search_form = $_REQUEST["um_search_form"];
    $to_email = get_field("receiving_e-mal",$search_form);

    $subject = "[".get_bloginfo('name')."] - ".$email;
    $message = "
            Name : {$name},
            Email : {$email}

            $message
        ";
    wp_mail($to_email,$subject,$message);
    die;
}
/*Contact Form Ajax*/

/*Return Cart Total Items*/
function um_get_cart_totals(){
	global $woocommerce;echo $woocommerce->cart->cart_contents_count;
	die;
}

add_action('wp_ajax_um_get_cart_totals', 'um_get_cart_totals');
add_action('wp_ajax_nopriv_um_get_cart_totals', 'um_get_cart_totals');
/*Return Cart Total Items*/

/*Get Post Featured Image SRC*/
function get_post_featured_image_src($post_id = null){
    if(!$post_id){
        global $post;
        $post_id = $post->ID;
    }
    if(has_post_thumbnail($post_id)){
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
        return $image[0];
    }else{
        return "";
    }
}
/*Get Post Featured Image SRC*/

/*Get Video Embedd*/
function getVideoEmbed($vurl,$height = "100%",$width="100%"){
    $image_url = parse_url($vurl);
    // Test if the link is for youtube
    $youtube_autoplay = get_field("video_autoplay","options") == "Enabled" ? "&autoplay=1" : "";
    if($image_url['host'] == 'www.youtube.com' || $image_url['host'] == 'youtube.com'){
        $array = explode("&", $image_url['query']);
        return '<iframe class="youtube" src="http://www.youtube.com/embed/' . substr($array[0], 2) . '?wmode=transparent&enablejsapi=1'.$youtube_autoplay.'" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></iframe>'; // Returns the youtube iframe embed code
        // Test if the link is for the shortened youtube share link
    } else if($image_url['host'] == 'www.youtu.be' || $image_url['host'] == 'youtu.be'){
        $array = ltrim($image_url['path'],'/');
        return '<iframe class="youtube" src="http://www.youtube.com/embed/' . $array . '?wmode=transparent&enablejsapi=1'.$youtube_autoplay.'" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></iframe>'; // Returns the youtube iframe embed code
        // Test if the link is for vimeo
    } else if($image_url['host'] == 'www.vimeo.com' || $image_url['host'] == 'vimeo.com'){
        $hash = substr($image_url['path'], 1);
        return '<iframe class="vimeo" src="http://player.vimeo.com/video/' . $hash . '?title=0&byline=0&portrait=0&api=1'.$youtube_autoplay.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowfullscreen></iframe>'; // Returns the vimeo iframe embed code
    }
}
/*Get Video Embedd*/

/*Get Likes*/
function get_likes($set = false,$postid = null){
    global $post;
    $post_id = $postid ? $postid : $post->ID;
    $views = get_post_meta($post_id, "umbrella_post_likes", true);
    if($set){
        $views = intval($views) + 1;
        if($views){
            update_post_meta($post_id, "umbrella_post_likes" , $views );
        }else{
            add_post_meta($post_id, "umbrella_post_likes" , 1 );
        }
    }
    return $views ? number_format($views, 0, ' ', ' ') : 0;
}

add_action('wp_ajax_um_like_post', 'um_like_post');
add_action('wp_ajax_nopriv_um_like_post', 'um_like_post');

function um_like_post(){
    $post_id = $_REQUEST["um_post_id"];
    echo get_likes(true,$post_id);
    wp_reset_postdata();
    die;
}
/*Get Likes*/

/*Enqueue Admin Font Awesome*/
add_action( 'admin_init', 'um_admin_init' );
function um_admin_init() {
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
}
/*Enqueue Admin Font Awesome*/

/*Add post view meta on post publish*/
add_action("save_post","um_publish_post");
function um_publish_post($post_id){
    $meta_values = get_post_meta( $post_id, "um_project_views" , true);
    if(!$meta_values){
        add_post_meta( $post_id , "um_project_views" , 1 , true);
    }
}
/*Add post view meta on post publish*/

/*Hover State*/
if(get_field("hover_logo","options")){
$um_hover_state = '<li><img src="'.get_field("hover_logo","options").'"></li>';
}else{
$um_hover_state = '<li><i class="fa fa-arrow-right"></i></li>';
}
global $um_hover_state;
/*Hover State*/

/*Get IMG id from src*/
function um_get_id_from_src($url){
	global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$url'";
		$id = $wpdb->get_var($query);
		return $id;
}
/*Get IMG id from src*/

/*Enqueue Scripts And Styles*/
function um_enq_my_scripts(){
    $d = get_template_directory_uri();
    /*Styles*/
        wp_enqueue_style("bootstrap", $d . "/assets/css/bootstrap.css", false, "1.0");
        wp_enqueue_style("font-awesome", $d . "/assets/css/font-awesome.min.css", false, "1.0");
        wp_enqueue_style("font-awesome", $d . "/assets/css/font-awesome.min.css", false, "1.0");
        wp_enqueue_style("fotorama", $d . "/assets/css/fotorama.css", false, "1.0");
        wp_enqueue_style("et-icons", $d . "/assets/css/et-line.css", false, "1.0");
        wp_enqueue_style("superslides", $d . "/assets/css/superslides.css", false, "1.0");
        wp_enqueue_style("animate", $d . "/assets/css/animate.css", false, "1.0");
        wp_enqueue_style("main_style", $d . "/assets/css/style.css", false, "1.0");
        wp_enqueue_style("adjustements", $d . "/assets/css/adjust.css", false, "1.0");
        wp_enqueue_style("ie10", $d . "/assets/css/ie10.css", false, "1.0");
		 if(
            (function_exists("is_woocommerce") && is_woocommerce()) ||
            (function_exists("is_cart") && is_cart()) ||
            (function_exists("is_account_page") && is_account_page()) ||
            /*(basename(get_page_template()) == "page.php") ||*/
            (function_exists("is_checkout") && is_checkout())
        ){
            wp_enqueue_style("woocommerce_css", $d . "/assets/css/woocommerce.css", false, "1.0");
        }
        /*Google Font*/
        $font = get_field("google_fonts","options");
        if($font && $font != "--None--"){
            $font = $GLOBALS["UM_GOOGLEFONTS"][$font];
            $font_name = str_replace(" ","+",$font["family"]);
            $font_variants = "";
            $font_subset = "";
            if($font["variants"]){
                $font_variants = implode($font["variants"],",");
                $font_variants = ":".$font_variants;
            }
            if($font["subsets"]){
                $font_subset = implode($font["subsets"],",");
                $font_subset = "&subset=".$font_subset;
            }
            $font_url = "http://fonts.googleapis.com/css?family={$font_name}{$font_variants}{$font_subset}";
            wp_enqueue_style("google_fonts",$font_url,false);
            wp_enqueue_style("dynamic_css",get_template_directory_uri()."/assets/css/dynamic.php?font=".$font["family"],false);
        }else{
            wp_enqueue_style("google_fonts_font", "http://fonts.googleapis.com/css?family=Raleway:400,300,200,100,500,600,700,800,900", false, "1.0");
        }
        /*Google Font*/
        /*Google Font Ittalic*/
        $font_ittalic = get_field("google_fonts_italic","options");
        if($font_ittalic && $font_ittalic != "--None--"){
            $font_ittalic = $GLOBALS["UM_GOOGLEFONTS"][$font_ittalic];
            $font_name = str_replace(" ","+",$font_ittalic["family"]);
            $font_variants = "";
            $font_subset = "";
            if($font_ittalic["variants"]){
                $font_variants = implode($font_ittalic["variants"],",");
                $font_variants = ":".$font_variants;
            }
            if($font_ittalic["subsets"]){
                $font_subset = implode($font_ittalic["subsets"],",");
                $font_subset = "&subset=".$font_subset;
            }
            $font_url = "http://fonts.googleapis.com/css?family={$font_name}{$font_variants}{$font_subset}";
            wp_enqueue_style("google_fonts_italic",$font_url,false);
            wp_enqueue_style("dynamic_css_font_italic",get_template_directory_uri()."/assets/css/dynamic.php?italic_font=".$font_ittalic["family"],false);
        }else{
            wp_enqueue_style("google_fonts_italic", "http://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic,900italic&subset=latin,latin-ext,cyrillic", false, "1.0");
        }
        /*Google Font Ittalic*/
        if(get_field("skin_mode","options") == "Dark"){
            wp_enqueue_style("dark_skin", $d . "/assets/css/dark-skin.css", false, "1.0");
        }
        if(get_field("brand_color","options")){
            wp_enqueue_style("brand_color",$d ."/assets/css/dynamic.php?brand_color=".urlencode(get_field("brand_color","options")),false);
        }
        /*Heading Sizes*/
        $heading_options = Array();
        if(get_field("heading_1_font_size","options")){
            $heading_options["heading_1_font_size"] = get_field("heading_1_font_size","options");
        }if(get_field("heading_2_font_size","options")){
            $heading_options["heading_2_font_size"] = get_field("heading_2_font_size","options");
        }if(get_field("heading_3_font_size","options")){
            $heading_options["heading_3_font_size"] = get_field("heading_3_font_size","options");
        }if(get_field("heading_4_font_size","options")){
            $heading_options["heading_4_font_size"] = get_field("heading_4_font_size","options");
        }if(get_field("heading_5_font_size","options")){
            $heading_options["heading_5_font_size"] = get_field("heading_5_font_size","options");
        }if(get_field("heading_6_font_size","options")){
            $heading_options["heading_6_font_size"] = get_field("heading_6_font_size","options");
        }
        $heading_options = http_build_query($heading_options);
        if($heading_options){
            wp_enqueue_style("dynamic_css_headings",get_template_directory_uri()."/assets/css/dynamic.php?".$heading_options,false);
        }
		if(get_field("background_image","options")){
			$repeat = get_field("bg_repeat","options") ? get_field("bg_repeat","options") : "no-repeat";
			wp_enqueue_style("dynamic_css_bgimage",get_template_directory_uri()."/assets/css/dynamic.php?bg=".urlencode(get_field("background_image","options"))."&repeat=".$repeat,false);
		}
		if(get_field("border_color","options")){
			wp_enqueue_style("border_color_dynamic",get_template_directory_uri()."/assets/css/dynamic.php?border_color=".urlencode(get_field("border_color","options")),false);
		}
        /*Heading Sizes*/
        /*White Borders*/
        if(get_field("white_borders","options") == "Disabled"){
            wp_enqueue_style("dynamic_css_white_border",get_template_directory_uri()."/assets/css/dynamic.php?white_borders=true",false);
        }
        /*White Borders*/
    /*Styles*/
    wp_enqueue_style("default_style",get_stylesheet_uri(),false);

    /*Scripts*/
    wp_enqueue_script("jquery");
    wp_enqueue_script( 'comment-reply' );
    wp_enqueue_script( 'googl_maps',"https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&ver=1",array(),1.0,true);
    wp_enqueue_script( 'jQuery_migrate',"http://code.jquery.com/jquery-migrate-1.2.1.js",array(),1.0,true);
	wp_enqueue_script("youtube_api", "http://www.youtube.com/iframe_api" ,array(),1.0,false);
    wp_enqueue_script( 'modernizer', $d ."/assets/js/modernizr.js",array(),1.0,true);
    wp_enqueue_script( 'jquery.easing', $d ."/assets/js/jquery.easing.min.js",array(),1.0,true);
    wp_enqueue_script( 'jquery.lazyload', $d ."/assets/js/jquery.lazyload.min.js",array(),1.0,true);
    wp_enqueue_script( 'jquery.slitslider', $d ."/assets/js/jquery.slit-slider.js",array(),1.0,true);
    wp_enqueue_script( 'bootstrap', $d ."/assets/js/bootstrap.min.js",array(),1.0,true);
    if(get_field("smooth_scrolling","options") != "Disabled"){
        wp_enqueue_script( 'smoothscroll', $d ."/assets/js/jquery.smoothscroll.js",array(),1.0,true);
    }
    wp_enqueue_script( 'masonry', $d ."/assets/js/jquery.masonry.js",array(),1.0,true);
    wp_enqueue_script( 'waypoints', $d ."/assets/js/waypoints.min.js",array(),1.0,true);
    wp_enqueue_script( 'nicescroll', $d ."/assets/js/jquery.nicescroll.js",array(),1.0,true);
    wp_enqueue_script( 'fotorama', $d ."/assets/js/fotorama.js",array(),1.0,true);
    wp_enqueue_script( 'swipe', $d ."/assets/js/jquery.swipe.js",array(),1.0,true);
    wp_enqueue_script( 'waitforimages', $d ."/assets/js/jquery.waitforimages.js",array(),1.0,true);
    wp_enqueue_script( 'imgfit', $d ."/assets/js/imgLiquid-min.js",array(),1.0,true);
    wp_enqueue_script( 'respond', $d ."/assets/js/respond.js",array(),1.0,true);
    wp_enqueue_script( 'smartresize', $d ."/assets/js/jquery.smartresize.js",array(),1.0,true);
    wp_enqueue_script( 'superslides', $d ."/assets/js/jquery.superslides.min.js",array(),1.0,true);
    wp_enqueue_script( 'um_script', $d ."/assets/js/script.js",array(),1.0,true);
    wp_enqueue_script( 'ajax_site', $d ."/assets/js/ajax_site.js",array(),1.0,true);
    /*Scripts*/
}
add_action( 'wp_enqueue_scripts', 'um_enq_my_scripts' );
/*Enqueue Scripts And Styles*/

/*WooCommerce*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'um_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'um_theme_wrapper_end', 10);
add_action('woocommerce_sidebar','um_theme_sidebar');

function um_theme_wrapper_start() {
	$class = is_dynamic_sidebar("shop") ? "col-md-9" : "col-md-12";
    echo '<div id="um_container" class="'.$class.' row">';
}

function um_theme_wrapper_end() {
    echo "</div>";
}

function um_theme_sidebar(){
    //echo '</div>';
}
/*WooCommerce*/

/*Documentation Option Page*/
add_action('admin_menu', 'register_my_custom_submenu_page' , 99);

function register_my_custom_submenu_page() {
    add_submenu_page( 'acf-options-main', 'Documentation', 'Documentation', 'manage_options', 'admin.php?page=acf-options-documentation', 'um_documentation_menu_callback' );
}

function um_documentation_menu_callback(){
    ?>
    <div class="icon32" id="icon-options-general"><br></div>
    <h2><?php _e("Documentation","um_lang"); ?></h2>
    <iframe width="100%" height="800px" src="http://documentation.umbrella.al/quantum-documentation/" frameborder="0"></iframe>
<?php
}
/*Documentation Option Page*/

/*Auto Theme Updates*/
$api_url = 'http://themes.umbrella.al/themes/';
if(function_exists('wp_get_theme')){
    $theme_data = wp_get_theme(get_option('template'));
    $theme_version = $theme_data->Version;
} else {
    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
}
$theme_base = get_option('template');
$purchase_key = get_field("themeforest_purchase_key","options");
if($purchase_key){
	add_filter('pre_set_site_transient_update_themes', 'check_for_update');
}

function check_for_update($checked_data) {
    global $wp_version, $theme_version, $theme_base, $api_url , $purchase_key;

    $request = array(
        'slug' => $theme_base,
        'version' => $theme_version
    );
    // Start checking for an update
    $send_for_check = array(
        'body' => array(
            'action' => 'theme_update',
            'request' => serialize($request),
            'api-key' => md5(get_bloginfo('url')),
            'purchase_key' => $purchase_key
        ),
        'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
    );
    $raw_response = wp_remote_post($api_url, $send_for_check);
    if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
        $response = unserialize($raw_response['body']);

    // Feed the update data into WP updater
    if (!empty($response))
        $checked_data->response[$theme_base] = $response;
    return $checked_data;
}

// Take over the Theme info screen on WP multisite
add_filter('themes_api', 'my_theme_api_call', 10, 3);

function my_theme_api_call($def, $action, $args) {
    global $theme_base, $api_url, $theme_version, $api_url;

    if ($args->slug != $theme_base)
        return false;

    // Get the current version

    $args->version = $theme_version;
    $request_string = prepare_request($action, $args);
    $request = wp_remote_post($api_url, $request_string);

    if (is_wp_error($request)) {
        $res = new WP_Error('themes_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
    } else {
        $res = unserialize($request['body']);

        if ($res === false)
            $res = new WP_Error('themes_api_failed', __('An unknown error occurred'), $request['body']);
    }

    return $res;
}

if (is_admin())
    $current = get_transient('update_themes');
/*Auto Theme Updates*/