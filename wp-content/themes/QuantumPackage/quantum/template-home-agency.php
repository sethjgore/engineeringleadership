<?php
if(isset($_REQUEST["um_load_more"]) && $_REQUEST["um_load_more"]):
    $arguments = array();
    $arguments["post_type"] = "portfolio";
    $exlucde_cats = get_field("exclude_categories");
    $exlucde_cats_arr = array();
    if($exlucde_cats){
        foreach($exlucde_cats as $cat){
            array_push($exlucde_cats_arr,$cat->slug);
        }
        $filter_categories = array();
        if($_REQUEST['filter'] != 'popular' && $_REQUEST['filter'] != 'recent'){
            $filter_categories = array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $_REQUEST['filter'],
                'operator' => 'IN'
            );
        }
        $arguments["tax_query"] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $exlucde_cats_arr,
                'operator' => 'NOT IN'
            )
        );
		if($filter_categories){
			array_push($arguments["tax_query"],$filter_categories);
		}
    }else{
        if($_REQUEST['filter'] != 'popular' && $_REQUEST['filter'] != 'recent'){
            $filter_categories = array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $_REQUEST['filter'],
                'operator' => 'IN'
            );
            $arguments["tax_query"] = array(
                $filter_categories
            );
        }
    }
    $arguments["posts_per_page"] = get_field("number_of_projects") ? get_field("number_of_projects") : 6;
    /*Recent Posts Order*/
    if($_REQUEST['filter'] == 'popular'){
        $arguments["meta_key"] = "um_project_views";
        $arguments["orderby"] = "meta_value_num";
    }
    $arguments["paged"] = $_REQUEST['um_page'];
    /*Recent Posts Order*/
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
            array_push($terms_html_array,"<span>{$term_name}</span>");
            array_push($terms_id_array,$t->slug);
            $term_classes .= "um_".$t->slug." ";
        }
        $terms_html_array = implode(", ",$terms_html_array);
        ?>
        <div class="project_con col-xs-12 col-sm-6 col-md-4 animated fadeIn">

            <div class="post_thumb_hover_holder">
                <div class="post_thumb_hover">
                    <a href="<?php the_permalink(); ?>">
                        <div class="p_hover_el ">
                            <ul>
                                <?php echo $GLOBALS["um_hover_state"]; ?>
                                <li><?php the_title(); ?></li>
                                <li><?php echo $terms_html_array; ?></li>
                            </ul>
                        </div>
                    </a>
                </div>
            </div>
            <div class="post_thumb">
                <a href="<?php the_permalink(); ?>">
                    <?php if($img): ?>
                        <img src="<?php echo aq_resize($img,350); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID) , '_wp_attachment_image_alt', true); ?>"/>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    <?php
    endwhile;
    if($the_query->post_count):
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                function center_hovers(){
                    $(".project_con").each(function(){
                        var hover_child = $(this).find(".p_hover_el");
                        var hover_parent = $(this).find(".post_thumb_hover");
                        center_vertically(hover_parent,hover_child,0);
                        center_horizontally(hover_parent,hover_child,0);
                    });
                }

                $(".masonry_works").waitForImages(function(){
                    center_hovers();
                });
            });
        </script>
    <?php
    endif;die;endif;
    /*Template Name:Home Agency*/
    get_header();
?>
    <?php
        $slider = get_field("slider");
        if($slider):
    ?>
    <div class="container agency_slider" id="agency_slider">
        <div class="a_slider_bullets">
            <ul>
                <li><a class="active_a_bullet" href="#"></a></li>
                <li><a href="#"></a></li>
            </ul>
        </div>
        <div class="a_slide col-sm-12">
            <?php foreach($slider as $slide): ?>
            <div class="row single_slide">
                <div class="a_slide_caption">
                    <h2 class="animated <?php echo $slide["big_heading_animation"]; ?>"><?php echo $slide["big_heading"]; ?></h2>
                    <p class="animated <?php echo $slide["small_heading_animation"]; ?>"><?php echo $slide["small_heading"]; ?></p>
                    <?php if($slide["button_url"] && $slide["button_text"]): ?>
                        <a class="animated button_u <?php echo $slide["button_animation"]; ?>" href="<?php echo $slide["button_url"]; ?>"><?php echo $slide["button_text"]; ?></a>
                    <?php endif; ?>
                </div>
                <?php if($slide["image"]): ?>
                <div class="a_slide_image col-sm-12 <?php echo $slide["image_animation"]; ?>">
                    <img src="<?php echo aq_resize($slide["image"],1080); ?>" alt="<?php echo get_post_meta(um_get_id_from_src($slide["image"]) , '_wp_attachment_image_alt', true); ?>"/>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
         </div>
    </div>

    <?php
        endif;
        $repeater = get_field("services");
        if($repeater):
    ?>
    <div class="agency_services_holder container">
        <div class="agency_services row">
            <div class="col-sm-12 a_title_top">
                <h2><?php the_field("what_we_do_label"); ?></h2>
            </div>
            <div class="clearfix"></div>
            <?php
                if($repeater):
                    foreach($repeater as $key=>$r):
            ?>
                <div class="col-md-4 single_a_s">
                    <i class="<?php echo str_replace(".","",$r["icon"]); ?>"></i>
                    <a href="<?php echo $r["url"]; ?>"><?php echo $r["name"]; ?></a>
                    <p><?php echo $r["description"]; ?></p>
                </div>
				<?php if(($key + 1) % 3 == 0 && $key != 0): ?>
				<div class="clearfix"></div>
            <?php
					endif;
                    endforeach;
                endif;
            ?>
        </div>
    </div>
    <?php endif; ?>

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
    /*Recent Posts Order*/
    if(get_field("order_of_projects") != "Recent"){
		$arguments["meta_key"] = "um_project_views";
		$arguments["orderby"] = "meta_value_num";
	}
    /*Recent Posts Order*/
    $the_query = new WP_Query( $arguments );
    if($the_query->have_posts()):
    ?>
    <div class="masonry-holder container" id="projects">
        <div class="col-sm-12 a_title_top">
           <h2><?php the_field("our_portfolio_label"); ?></h2>
        </div>
        <div class="filters">
            <ul class="col-sm-12">
                <li><a class="filter_popular" href="#"><?php _e("Popular","um_lang"); ?></a></li>
                <li><a class="filter_recent" href="#"><?php _e("Recent","um_lang"); ?></a></li>
                <li><a class="show_sort_categories" href="#"><?php _e("Category","um_lang"); ?><i class="fa fa-sort"></i></a>
                    <div class="filter_category">
                        <ul>
                            <?php
                            $exlucde_cats = get_field("exclude_categories");
                            $exlucde_cats_arr = array();
                            if($exlucde_cats){
                                foreach($exlucde_cats as $cat){
                                    array_push($exlucde_cats_arr,$cat->term_id);
                                }
                            }
                            $list_terms = get_terms("portfolio_category",array('exclude'=>$exlucde_cats_arr));
                            foreach($list_terms as $term):
                                ?>
                                <li><a class="filter_cat" href="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="masonry_works load_posts">
            <?php
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
                    array_push($terms_html_array,"<span>{$term_name}</span>");
                    array_push($terms_id_array,$t->slug);
                    $term_classes .= "um_".$t->slug." ";
                }
                $terms_html_array = implode(", ",$terms_html_array);
                ?>
                <div class="project_con col-xs-12 col-sm-6 col-md-4 animated fadeIn">

                    <div class="post_thumb_hover_holder">
                        <div class="post_thumb_hover">
                            <a href="<?php the_permalink(); ?>">
                                <div class="p_hover_el ">
                                    <ul>
                                        <?php echo $GLOBALS["um_hover_state"]; ?>
                                        <li><?php the_title(); ?></li>
                                        <li><?php echo $terms_html_array; ?></li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="post_thumb">
                        <a href="<?php the_permalink(); ?>">
                            <?php if($img): ?>
                                <img src="<?php echo aq_resize($img,350); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID) , '_wp_attachment_image_alt', true); ?>"/>
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
    </div>
    <?php endif; ?>

    <?php
        $clients = get_field("clients");
        if($clients):
    ?>
    <div class="container clients_container" id="clients">
        <div class="col-sm-12 a_title_top">
            <h2><?php the_field("client_heading"); ?></h2>
        </div>
        <?php
            foreach($clients as $r):
                ?>
                <div class="col-md-3 single_client animated fadeInUp">
                    <div class="logo_holder">
                        <span class="helper_full"></span>
                        <a target="_blank" href="<?php echo $r["client_url"]; ?>">
                            <img src="<?php echo $r["client_logo"]; ?>" alt=""/>
                        </a>
                    </div>
                </div>
            <?php
            endforeach;
        ?>
    </div>
    <?php endif; ?>
	<?php if(get_field("display_footer") != "Disabled"): ?>
    <div class="container sidebar1">
        <?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
    </div>
	<?php endif; ?>
		
    <script type="text/javascript">
        String.prototype.repeat = function( num ){
            return new Array( num + 1 ).join( this );
        }
        paged_projects = 1;
        filter = '<?php echo get_field("order_of_projects") == "Recent" ? "recent" : "popular"; ?>';
        jQuery(document).ready(function($){
            $("body").attr("class",$(".body_class_container a").attr("class"));
            function center_hovers(){
                $(".project_con").each(function(){
                    var hover_child = $(this).find(".p_hover_el");
                    var hover_parent = $(this).find(".post_thumb_hover");
                    center_vertically(hover_parent,hover_child,0);
                    center_horizontally(hover_parent,hover_child,0);
                });
            }

            $(".inner_content").waitForImages(function(){
                $(".masonry_works").masonry({
                    itemSelector: '.project_con'
                });
                center_hovers();
            });

            /*Make Slider Bullets*/
            var num_of_slides = $(".single_slide").length;
            var bullets_string = '<li><a href="#"></a></li>'.repeat(num_of_slides);
            var single_bullet = $(bullets_string);
            single_bullet.eq(0).find("a").addClass("active_a_bullet");
            //$(".a_slider_bullets ul").html(single_bullet);
            /*Make Slider Bullets*/

            /*Make Slider Navigation*/
            $(".a_slider_bullets ul li a").click(function(e){
                e.preventDefault();
                if($(this).hasClass("active_a_bullet")){
                    return false;
                }
                $(".active_a_bullet").removeClass("active_a_bullet");
                $(this).addClass("active_a_bullet");
                var index = $(this).parent().index();
                var visible_slide = $(".single_slide:visible");
                var cur_slide = $(".single_slide").eq(index);
                /*Hide Visible Slide And Remove Animation Classes*/
                visible_slide.hide();
                visible_slide.find("animated").removeClass("animated");
                /*Show Cur Slide And Animate Elements*/
                cur_slide.show();
                cur_slide.find("h2,p,a,.a_slide_image").addClass("animated");
            });
            /*Make Slider Navigation*/

            /*Make Slider Navigate By Swipe*/
            $(".a_slide_image").swipe({
                swipeLeft:function(event, direction, distance, duration, fingerCount) {
					/*Play Previous Slide*/
					var cur_bullet = $(".agency_slider").find("a.active_a_bullet");
					var next_bullet = cur_bullet.parent().prev().children("a");
					if(!next_bullet.length){
						next_bullet = $(".agency_slider").find("div.a_slider_bullets ul li:last a");
					}
					next_bullet.trigger("click");
                },
				swipeRight:function(event, direction, distance, duration, fingerCount){
					/*Play Next Slide*/
					var cur_bullet = $(".agency_slider").find("a.active_a_bullet");
					var next_bullet = cur_bullet.parent().next().children("a");
					if(!next_bullet.length){
						next_bullet = $(".agency_slider").find("div.a_slider_bullets ul li:eq(0) a");
					}
					next_bullet.trigger("click");
				}
            });
            /*Make Slider Navigate By Swipe*/
			
			/*Make Slider Autoslide*/
			<?php if(get_field("slider_autoslide") != "Disabled"): ?>
			var is_hover = false;
			$(".agency_slider").hover(function(){
				is_hover = true;
			},function(){
				is_hover = false;
			});
			
			function play_next_slide(){
				if(!is_hover){
					var cur_bullet = $(".agency_slider").find("a.active_a_bullet");
					var next_bullet = cur_bullet.parent().next().children("a");
					if(!next_bullet.length){
						next_bullet = $(".agency_slider").find("div.a_slider_bullets ul li:eq(0) a");
					}
					next_bullet.trigger("click");
				}
				setTimeout(function(){
					play_next_slide();
				},8000);
			}
			setTimeout(function(){
				play_next_slide();
			},8000);
			/*Make Slider Autoslide*/
			<?php endif; ?>
            $(window).smartresize(function(){
                center_hovers();
            });
        });
    </script>
<?php get_footer(); ?>