<?php
    if(isset($_REQUEST["um_load_more"]) && $_REQUEST["um_load_more"]):
		if(is_tax()){
			$the_query = $wp_query;
		}else{
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
		}
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
            <div class="project_con_g col-sm-6 animated">
                <div class="post_thumb_g">
                    <div class="post_thumb_hover_holder_g">
                        <div class="post_thumb_hover_g">
                            <a href="<?php the_permalink(); ?>">
                                <div class="p_hover_el_g">
                                    <ul>
                                        <?php echo $GLOBALS["um_hover_state"]; ?>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php if($img): ?>
                        <a href="<?php the_permalink(); ?>"> <img src="<?php echo aq_resize($img,540,390,true); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID) , '_wp_attachment_image_alt', true); ?>"/></a>
                    <?php endif; ?>
                </div>
                <div class="post_title_g g2">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <p>
                        <i class="fa fa-angle-right"></i><?php echo get_the_date("d M"); ?>
                        <?php echo $terms_html_array ? __("in","um_lang")." ".$terms_html_array : ""; ?>
                    </p>
                </div>
            </div>
    <?php
        endwhile;
        if($the_query->post_count):
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            function center_hovers(){
                $(".project_con_g").each(function(){
                    var hover_child = $(this).find(".p_hover_el_g ul");
                    var hover_parent = $(this).find(".post_thumb_hover_g");
                    center_vertically(hover_parent,hover_child,0);
                    center_horizontally(hover_parent,hover_child,40);
                });
            }

            $(".inner_content").waitForImages(function(){
                center_hovers();
                if(typeof animateProjects === 'function'){
                    animateProjects();
                }
            });
        });
    </script>
<?php
endif;die;endif;
/*Template Name:Home Grid 2 Columns*/
get_header();
?>
    <div class="col-sm-12 home_top">
		<?php
			if(is_tax()):
			$portfolio_category = get_query_var("portfolio_category");
			$portfolio_category = get_term_by("slug",$portfolio_category,"portfolio_category");
		?>
		<h2><?php echo $portfolio_category->name; ?></h2>
		<?php endif; ?>
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
    <?php if(!is_tax()): ?>
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
	<?php endif; ?>
    <div class="clearfix"></div>
    <div class="grid_4_works load_posts">
        <?php
			if(is_tax()){
				$the_query = $wp_query;
			}else{
				$arguments = array();
				$arguments["post_type"] = "portfolio";
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
			}
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
            <div class="project_con_g col-sm-6 animated">
                <div class="post_thumb_g">
                    <div class="post_thumb_hover_holder_g">
                        <div class="post_thumb_hover_g">
                            <a href="<?php the_permalink(); ?>">
                                <div class="p_hover_el_g">
                                    <ul>
                                        <?php echo $GLOBALS["um_hover_state"]; ?>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php if($img): ?>
                        <a href="<?php the_permalink(); ?>"> <img src="<?php echo aq_resize($img,540,390,true); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id($post->ID) , '_wp_attachment_image_alt', true); ?>"/></a>
                    <?php endif; ?>
                </div>
                <div class="post_title_g g2">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <p>
                        <i class="fa fa-angle-right"></i><?php echo get_the_date("d M"); ?>
                        <?php echo $terms_html_array ? __("in","um_lang")." ".$terms_html_array : ""; ?>
                    </p>
                </div>
            </div>
        <?php endwhile; ?>

    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12 load_more_btn">
        <?php if($the_query->max_num_pages > 1): ?>
        <a class="button_u load_more" href="#"><i class="fa fa-repeat"></i><?php _e("Load More","um_lang"); ?></a>
        <div class="spinner"></div>
        <?php endif;wp_reset_postdata(); ?>
    </div>
	<?php if(get_field("display_footer") != "Disabled"): ?>
    <div class="sidebar1">
        <?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
    </div>
	<?php endif; ?>
    <script type="text/javascript">
        paged_projects = 1;
        filter = '<?php echo get_field("order_of_projects") == "Recent" ? "recent" : "popular"; ?>';
        var animateProjects;
        jQuery(document).ready(function($){
            show_loader();
            $("body").attr("class",$(".body_class_container a").attr("class"));
            function center_hovers(){
                $(".project_con_g").each(function(){
                    var hover_child = $(this).find(".p_hover_el_g ul");
                    var hover_parent = $(this).find(".post_thumb_hover_g");
                    center_vertically(hover_parent,hover_child,0);
                    center_horizontally(hover_parent,hover_child,40);
                });
            }

            animateProjects = function(){
                $('.project_con_g:not(".umScaleIn")').each(function(i) {
                    var el = $(this);
                    setTimeout(function() {
                        el.addClass('umScaleIn');
                    }, i * 600);
                });
            }

            $(".inner_content").waitForImages(function(){
                center_hovers();
                animateProjects();
                hide_loader();
            });

            $(window).smartresize(function(){
                center_hovers();
            });
        });
    </script>
<?php get_footer(); ?>