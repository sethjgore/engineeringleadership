<?php
    get_header();
    if(has_post_thumbnail()):
?>
    <div class=" singlepost_top">
        <img src="<?php echo get_post_featured_image_src(); ?>"/>
    </div>
<?php endif; ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class("container"); ?>>
        <div class="col-sm-12 singlepost_container ">
        <div class=" singlepost_desc col-sm-3 row">

            <div class="singlepost_info">
                <ul>
                    <li>
                        <?php
                            $author = $post->post_author;
                            $author = $user = get_user_by( "id" , $author );
                        ?>
                        <div class="author_avatar">
                            <?php echo get_avatar($author->data->user_email,80); ?>
                        </div>
                        <i class="fa fa-user"></i>
                        <p><?php echo $author->data->display_name; ?></p>
                    </li>
                    <li>
                        <i class="fa fa-folder-o"></i>
                        <?php
                        $terms = wp_get_post_terms( $post->ID,"category" );
                        $terms_html_array = array();
                        $terms_id_array = array();
                        $term_classes = "";
                        foreach($terms as $t){
                            $term_name = $t->name;
                            $term_link = get_term_link($t->slug,$t->taxonomy);
                            array_push($terms_html_array,"<a href='{$term_link}'>{$term_name}</a>");
                            array_push($terms_id_array,$t->slug);
                            $term_classes .= "um_".$t->slug." ";
                        }
                        $terms_html_array = implode(", ",$terms_html_array);
                        echo $terms_html_array;
                        ?>
                    </li>
                    <li>
                        <i class="fa fa-calendar-o"></i>
                        <p><?php echo get_the_date("d F Y"); ?></p>
                    </li>

                </ul>

            </div>
        </div>
        <div class="row singlepost_content col-sm-12 col-md-8">
            <div class="singlepost_title">
              <h2><?php wp_title(""); ?></h2>
            </div>
            <div class="singlepost_body">
                <?php
                    global $post;
                    setup_postdata($post);
                    the_content();
                ?>
                <div class="row tags">
                    <h5 class="section-title"><?php _e("Tags","um_lang"); ?></h5>
                    <?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
                    <?php wp_link_pages(); ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
     </div>

    <div class="clearfix"></div>
		<div class="singlepost-comments">
		
			<?php comments_template(); ?>
		   
		</div>
    </div>
<?php get_footer(); ?>