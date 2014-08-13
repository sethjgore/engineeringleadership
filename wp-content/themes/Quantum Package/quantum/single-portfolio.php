<?php
    /*Set Post Views*/
        $meta_values = get_post_meta( $post->ID , "um_project_views" , true);
        if($meta_values){
            $meta_values += $meta_values;
            update_post_meta( $post->ID , "um_project_views" , $meta_values);
        }else{
            add_post_meta( $post->ID , "um_project_views" , 1 , true);
        }
    /*Set Post Views*/
    $portfolio_layout = get_field("portfolio_layout");
    if($portfolio_layout == "case-study"){
        get_template_part("portfolio","case-study");
    }elseif($portfolio_layout == "gallery"){
        get_template_part("portfolio","gallery");
    }else{
        get_template_part("portfolio","projects-page");
    }
?>