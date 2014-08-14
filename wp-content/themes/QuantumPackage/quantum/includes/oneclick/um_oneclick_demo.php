<?php
/*Custom Code*/
function um_do_the_import(){
    //check_admin_referer( 'import-wordpress' );
    $um_importer = new Um_WP_Import();
    $um_importer->fetch_attachments = true;
    $um_importer->id = 1;
	$dir = dirname(__FILE__);
    $file = $dir."/demo.xml";
    set_time_limit(0);
    $um_importer->import( $file );
}

add_action( 'admin_menu', 'register_my_page' );
function register_my_page(){
    add_menu_page( 'One Click Demo Install', 'One Click Demo', 'manage_options', 'umbrella_one_click_install', 'my_page_function', "" );
}

function my_page_function(){
    if(isset($_REQUEST["um_do_import"]) && $_REQUEST["um_do_import"]){
		require_once "wordpress-importer.php";
        um_do_the_import();
    }else{
        ?>
        <div class="wrap">
            <h2>Umbrella One Click Demo Installer</h2><br/>
            <a class="add-new-h2" href="?page=umbrella_one_click_install&um_do_import=1">Do The Import</a>
        </div>
    <?php
    }
}
/*Custom Code*/