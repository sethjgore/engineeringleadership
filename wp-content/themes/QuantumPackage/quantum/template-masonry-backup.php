<?php
get_header();
?>
    <div class="col-sm-12 home_top">
        <?php if(get_field("heading_text")): ?>
            <h2><?php the_field("heading_text"); ?></h2>
        <?php endif; ?>
        <?php if(get_field("subheading_text")): ?>
            <p><?php the_field("subheading_text"); ?></p>
        <?php endif; ?>
        <?php if(get_field("button_text") && get_field("button_url")): ?>
            <a class="button_u" href="<?php the_field("button_url"); ?>"><?php the_field("button_text"); ?></a>
        <?php endif; ?>
    </div>
    <div class="filters">
        <ul class="col-sm-12">
            <li><a href="#"><?php _e("Popular","um_lang"); ?></a></li>
            <li><a href="#"><?php _e("Recent","um_lang"); ?></a></li>
            <li><a href="#"><?php _e("Category","um_lang"); ?><i class="fa fa-sort"></i></a>
                <div class="filter_category">
                    <ul>
                        <li><a class="active" href="">Design</a></li>
                        <li><a href="">Development</a></li>
                        <li><a href="">Photography</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="masonry_works">

        <?php
        $arguments = array();
        $arguments["post_type"] = "portfolio";
        $exlucde_cats = get_field("exclude_categories");
        $exlucde_cats_arr = array();
        if($exlucde_cats){
            foreach($exlucde_cats as $cat){
                array_push($exlucde_cats_arr,$cat->slug);
            }
            $arguments["tax_query"] = array(array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $exlucde_cats_arr,
                'operator' => 'NOT IN'
            ));
        }
        $arguments["posts_per_page"] = get_field("number_of_projects") ? get_field("number_of_projects") : 6;
        $the_query = new WP_Query( $arguments );
        while ( $the_query->have_posts() ) :  $the_query->the_post();
            global $post;
            setup_postdata($post);
            $img = get_post_featured_image_src();
            $terms = wp_get_post_terms( $post->ID,"portfolio_category" );
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
            <div class="project_con col-sm-4">

                <div class="post_thumb_hover_holder">
                    <div class="post_thumb_hover">
                        <a href="#">
                            <div class="p_hover_el ">
                                <ul>
                                    <li><i class="fa fa-arrow-right"></i></li>
                                    <li>Fashion Model</li>
                                    <li><span>Photography</span></p></li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="post_thumb">
                    <a href="#">
                        <?php if($img): ?>
                            <img src="<?php echo aq_resize($img,350); ?>" alt=""/>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12 load_more_btn">
        <?php if($the_query->max_num_pages > 1): ?>
            <a class="button_u" href="#"><i class="fa fa-repeat"></i><?php _e("Load More","um_lang"); ?></a>
        <?php endif;wp_reset_postdata(); ?>
    </div>
    <div class="sidebar1 col-sm-12">
        <div class="widget col-sm-4">
            <div class="widget_title">
                <h5>About us</h5>
            </div>
            <div class="widget_content">
                <p>
                    This is Photoshop's version  of Lorem Ipsum.
                    Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin,
                    lorem quis bibendum auctor, nisi elit consequat ipsum, nec
                    sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate
                </p>
            </div>
        </div>
        <div class="widget col-sm-4">
            <div class="widget_title">
                <h5>From the blog</h5>
            </div>
            <div class="widget_content">
                <ul class="blog-recent-posts">
                    <li>
                        <a href="#">Latest web design trends</a>
                        <p><i class="fa  fa-angle-right"></i>27 Sep in <a href="#">Articles</a>                    </p></li>
                    <li>
                        <a href="#">How to draw realistic characters</a>
                        <p><i class="fa  fa-angle-right"></i>27 Sep in <a href="#">Articles</a>                    </p></li>
                    <li>
                        <a href="#">Designers Anonymous – Fika</a>
                        <p><i class="fa  fa-angle-right"></i>27 Sep in <a href="#">Articles</a>                    </p></li>
                </ul>
            </div>
        </div>
        <div class="widget col-sm-4">
            <div class="widget_title">
                <h5>Get in touch</h5>
            </div>
            <div class="widget_content">
                <form action="" class="contact-widget" data-contact_form_id="">
                    <p><input type="text" name="w-name" id="w-name" placeholder="Name"></p>
                    <p><input type="email" name="w-email" id="w-email" placeholder="Email"></p>
                    <p><textarea name="w-message" id="w-message" placeholder="Message"></textarea></p>
                    <p><input type="submit" class="button_u" name="w-send" id="w-send" value="Send"></p>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            function center_hovers(){
                $(".project_con").each(function(){
                    var hover_child = $(this).find(".p_hover_el");
                    var hover_parent = $(this).find(".post_thumb_hover");
                    center_vertically(hover_parent,hover_child,0);
                    center_horizontally(hover_parent,hover_child,20);
                });
            }

            $(".masonry_works").waitForImages(function(){
                var container = document.querySelector('.masonry_works');
                var msnry = new Masonry( container, {
                    itemSelector: '.project_con'
                });
                center_hovers();
            });
            $(window).smartresize(function(){
                center_hovers();
            });
        });
    </script>
<?php get_footer(); ?>