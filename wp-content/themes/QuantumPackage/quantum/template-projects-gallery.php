<?php
/*Template Name:Projects Gallery*/
get_header();
?>

    <div class="horizontal_gallery row" >
        <div class="long_gallery_holder">
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
            ?>
            <div class="single_gallery_holder">
                <a href="<?php the_permalink(); ?>">
                   <div class="single_gallery"
                        style="background: url('<?php echo get_post_featured_image_src(); ?>') no-repeat center center;"
                       >
                       <div class="sg_title">
                           <h2><?php the_title(); ?></h2>
                       </div>

                   </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
			var is_scrolling = false;
			var scrolltimer = setTimeout(function(){},10);
            $("body").attr("class",$(".body_class_container a").attr("class"));
            $(".inner_content").waitForImages(function(){
                function fit_galleries_to_screen(){
                    var single_height = $(window).height() - 140;
                    $(".horizontal_gallery , .single_gallery").css("height",single_height);
                    $(".single_gallery").each(function(){
                        var parent = $(this);
                        var child = parent.find(".sg_title h2");
                        center_vertically(parent,child,0);
                    });
					var long_gallery_holder_width = $(".single_gallery").width() * $(".single_gallery_holder").length;
					$(".long_gallery_holder").css("width",long_gallery_holder_width);
                }
                fit_galleries_to_screen();
                $(window).smartresize(function(){
                    fit_galleries_to_screen();
                });
				$(".horizontal_gallery").scroll(function(){
					clearTimeout(scrolltimer);
					is_scrolling = true;
					scrolltimer = setTimeout(function(){
						is_scrolling = false;
					},1000);
				});
				$(".single_gallery_holder a").click(function(e){
					if(is_scrolling){
						e.preventDefault();
						e.stopPropagation()
					}
				});
                $(".horizontal_gallery").niceScroll({
                    cursorwidth : 8,
                    touchbehavior : true,
                    cursoropacitymin : 1
                });
            });
        });
    </script>
<?php get_footer(); ?>