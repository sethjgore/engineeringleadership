<?php
if(isset($_REQUEST["um_load_more"]) && $_REQUEST["um_load_more"]):
    while ( $wp_query->have_posts() ) :  $wp_query->the_post();
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
        ?>
        <div class="col-md-6 one_post col-sm-12 col-xs-12 animated fadeInUp">
            <div class="post_thumb_b">
                <a href="<?php the_permalink(); ?>">
                    <div class="post_thumb_b_holder">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
                <?php
                $img = get_post_featured_image_src();
                if($img):
                    ?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo aq_resize($img,200,200,true); ?>" alt="" class="img-circle"/></a>
                <?php endif; ?>
            </div>
            <div class="post_title_b">
                <a href="<?php the_permalink(); ?>" class="post_title_b_a"><?php the_title(); ?></a>
                <i class="fa fa-folder-o"> </i><?php echo $terms_html_array; ?>
            </div>
        </div>
<?php
endwhile;
die;
endif;
/*Template Name:Blog*/
get_header();
?>
    <div class="col-sm-12 row page_top" id="blog_top">
        <h2><?php wp_title(""); ?></h2>
        <div class="sort_blog_posts">
            <a class="show_sort_categories" href="#"><?php _e("Filter categories","um_lang"); ?><i class="fa fa-sort"></i></a>
            <div class="filter_category filter_category_blog">
                <ul>
                    <?php
                    $list_terms = get_terms("category");
                    foreach($list_terms as $term):
                        ?>
                        <li><a href="<?php echo get_term_link($term->slug,$term->taxonomy); ?>"><?php echo $term->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
         </div>
    </div>

    <div class="row blog_posts">
        <?php
            while ( $wp_query->have_posts() ) :  $wp_query->the_post();
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
        ?>
        <div class="col-md-6 one_post col-sm-12 col-xs-12 animated fadeInDown">
                <div class="post_thumb_b">
                  <a href="<?php the_permalink(); ?>">
                      <div class="post_thumb_b_holder">
                        <i class="fa fa-arrow-right"></i>
                      </div>
                  </a>
                  <?php
                    $img = get_post_featured_image_src();
                    if($img):
                  ?>
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo aq_resize($img,200,200,true); ?>" alt="" class="img-circle"/></a>
                  <?php endif; ?>
                </div>
                <div class="post_title_b">
                     <a href="<?php the_permalink(); ?>" class="post_title_b_a"><?php the_title(); ?></a>
                     <i class="fa fa-folder-o"> </i><?php echo $terms_html_array; ?>
                </div>
        </div>
        <?php endwhile; ?>
    </div>
    <div class="clearfix"></div>
	<?php if($wp_query->max_num_pages > 1): ?>
    <div class="col-sm-12 load_more_btn">
        <a class="button_u load_more_blog" href="#"><i class="fa fa-repeat"></i><?php _e("Load More","um_lang"); ?></a>
    </div>
	<?php endif; ?>
    <div class="sidebar1">
        <?php dynamic_sidebar('sidebar'); ?>
    </div>
    <script type="text/javascript">
        blog_page = 1;
    </script>
<?php get_footer(); ?>