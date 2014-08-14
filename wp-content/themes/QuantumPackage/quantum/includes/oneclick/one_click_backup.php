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
	require_once "wordpress-importer.php";
	um_do_the_import();return false;
    require "parsers.php";
    $parser = new WXR_Parser();
    $dir = dirname(__FILE__);
    $file = $dir."/demo.xml";
	$img_file = $dir."/demo.jpg";
    $data = $parser->parse($file);
	$wp_upload_dir = wp_upload_dir();
	copy($img_file,$wp_upload_dir["path"]."/um_imgfile.jpg");
	$img_file = $wp_upload_dir["path"]."/um_imgfile.jpg";
	/*Insert All Categories,Terms and Tags */
		/*Insert Categories*/
			if($data && $data["categories"]){
				foreach($data["categories"] as $um_cat){
					wp_insert_term($um_cat["cat_name"],'category',array(
						'name' =>  $um_cat["cat_name"],
						'slug' => $um_cat["category_nicename"],
						'description' => $um_cat["category_description"],
						'term_id' => $um_cat["term_id"],
						'parent' => $um_cat["category_parent"]
					));							
				}
			}
		/*Insert Categories*/
		/*Insert Tags*/
			if($data && $data["tags"]){
				foreach($data["tags"] as $um_cat){
					wp_insert_term($um_cat["tag_name"],'post_tag',array(
						'name' =>  $um_cat["tag_name"],
						'slug' => $um_cat["tag_nicename"],
						'description' => $um_cat["tag_description"]
					));							
				}
			}
		/*Insert Tags*/
		/*Insert Other Terms*/
			if($data && $data["terms"]){
				foreach($data["terms"] as $um_cat){
					if(taxonomy_exists($um_cat["term_taxonomy"])){
						wp_insert_term($um_cat["term_name"],$um_cat["term_taxonomy"],array(
							'name' =>  $um_cat["term_name"],
							'slug' => $um_cat["term_nicename"],
							'description' => $um_cat["term_description"],
							'parent' => $um_cat["term_parent"]
						));		
					}
				}
			}
		/*Insert Other Terms*/
	/*Insert All Categories,Terms and Tags */
	/*Insert All Attachments And Make Them The Logo Image*/
	if($data && $data["posts"]){
		foreach($data["posts"] as $um_post){
			if($um_post["post_type"] == "attachment"){
				// $filename should be the path to a file in the upload directory.
				$filename = $img_file;

				// The ID of the post this attachment is for.
				$parent_post_id = 37;

				// Check the type of tile. We'll use this as the 'post_mime_type'.
				$filetype = wp_check_filetype( basename( $filename ), null );

				// Get the path to the upload directory.
				$wp_upload_dir = wp_upload_dir();

				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
					'post_mime_type' => $filetype['type'],
					'post_title'     => $um_post['post_title'],
					'post_id'     => $um_post['post_id'],
					'post_author'     => $um_post['post_author'], /*TO-DO : Get the default admin author*/
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Insert the attachment.
				$attach_id = wp_insert_attachment( $attachment, $filename);

				// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
				require_once( ABSPATH . 'wp-admin/includes/image.php' );

				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id, $attach_data );
			}else{
				/*Insert Normal Posts*/
				$um_post["post_author"] = "1"; /*TO-DO : Get the default admin author*/
				$um_post["post_status"] = $um_post["status"]; /*TO-DO : Get the default admin author*/
				$this_post = wp_insert_post($um_post);
				/*Insert Custom Fields*/
				if($um_post["postmeta"]){
					foreach($um_post["postmeta"] as $meta){
						add_post_meta($this_post, $meta["key"] , $meta["value"]);
					}
				}
				/*Insert Custom Fields*/
				/*Insert Post Terms*/
				if($um_post["terms"]){
					foreach($um_post["terms"] as $terms){
						wp_set_post_terms( $this_post, $terms['slug'] , $terms['domain'] ) ;
					}
				}
				/*Insert Post Terms*/
			}
		}
	}
	/*Insert All Attachments And Make Them The Logo Image*/
    /*echo "<textarea>";
    echo json_encode($data);
    echo "</textarea>";*/
    return false;
    if(isset($_REQUEST["um_do_import"]) && $_REQUEST["um_do_import"]){
        //require_once("oneclick/wordpress-importer.php");
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