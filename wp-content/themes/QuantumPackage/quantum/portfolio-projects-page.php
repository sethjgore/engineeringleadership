<?php get_header(); ?>
    <div class="col-sm-12  row page_top top_project single_project">
        <h2><?php wp_title(""); ?></h2>
        <?php
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
        <i class="fa fa-folder-o"> </i> <?php echo $terms_html_array; ?>
		<?php
				$next_prev = get_field("next_prev","options") == "Enabled";
				$next_post = get_next_post();
				$prev_post = get_previous_post();
				if( ($next_post || $prev_post) && $next_prev){
					echo '<br/><i class="fa fa-arrows-h"> </i>';
				}
				if($next_post && $next_prev):
		?>
				<a href="<?php echo get_permalink($next_post->ID); ?>"><?php _e("Next Project","um_lang"); ?></a>
		<?php
				endif;
				if($prev_post && $next_prev):
		?>
				<a href="<?php echo get_permalink($prev_post->ID); ?>"><?php _e("Previous Project","um_lang"); ?></a>
		<?php
				endif;
		?>
    </div>
    <div class="clearfix"></div>
    <?php
        $slider = get_field("slider");
        if($slider):
    ?>
    <div class="col-sm-12  row project_slider">
        <div class="pr_slider_arrows">
            <div class="sl_arrow_l">
                <a href="#" class="prev"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="sl_arrow_r">
                <a href="#" class="next"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
        <ul>
            <?php foreach($slider as $slide): ?>
                    <?php if($slide["video_url"]): ?>
                        <li class="video_embedd"><?php echo getVideoEmbed($slide["video_url"]); ?></li>
                    <?php elseif($slide["image"]): ?>
                        <li class='animated fadeIn'>
							<?php 
								$postid = um_get_id_from_src( $slide["image"] );
								$img_post = get_post($postid);
								if($img_post->post_excerpt){
									echo "<h3>".$img_post->post_excerpt."</h3>";
								}
							?>
							<img src="<?php echo get_field("disable_image_resize") == "Enabled" ? $slide["image"] : aq_resize($slide["image"],1110); ?>" alt=""/>
						</li>
                    <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="row col-sm-12 bullets-pr-slider">
        <ul>

        </ul>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="row col-sm-12">
        <div class="row project_desc col-md-6 col-sm-8 sp_margin">
            <h4><?php _e("Description","um_lang"); ?></h4>
            <?php
                global $post;
                setup_postdata($post);
                the_content();
                if(get_field("project_button_text") && get_field("project_button_url")):
            ?>
               <a href="<?php the_field("project_button_url"); ?>" class="button_u"><?php the_field("project_button_text"); ?></a>
            <?php endif; ?>
        </div>
        <?php
            $services = get_field("project_brief");
            if($services):
        ?>
        <div class="project_desc col-sm-3 row sp_margin col-sm-offset-1">
            <h4><?php the_field("project_services_brief_text"); ?></h4>
            <ul class="pp_services">
                <?php foreach($services as $service): ?>
                    <li><i class="fa fa-arrow-right"></i><?php echo $service["item"]; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="appreciate ap2 col-sm-12 col-md-2">
            <?php
                $coockie_offset = 'um_liked_'.$post->ID;
                $liked = isset($_COOKIE[$coockie_offset]) && $_COOKIE[$coockie_offset] ? "liked" : "";
            ?>
            <a href="#" class="like_post <?php echo $liked; ?>" data-postid="<?php echo $post->ID; ?>"><i class="icon-heart"></i><?php _e("Appreciate","um_lang"); ?></a>
            <div class="appr_count"><?php echo get_likes(); ?></div>
        </div>
        <div class="col-sm-12 row button_u_2">

        </div>
        <div class="col-sm-12 row">
            <div class="share_this">
                <ul>
                    <li><a href="<?php the_permalink(); ?>" class="facebook_share"><i class="fa fa-facebook"></i><?php _e("Share","um_lang"); ?></a></li>
                    <li><a href="<?php the_permalink(); ?>" class="twitter_share"><i class="fa fa-twitter"></i><?php _e("Tweet","um_lang"); ?></a></li>
                    <li><a href="<?php the_permalink(); ?>" class="pinteres_share" data-image="<?php echo get_post_featured_image_src(); ?>"><i class="fa fa-pinterest"></i><?php _e("Pin","um_lang"); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("body").attr("class",$(".body_class_container a").attr("class"));
            /*Remove min-height if there are images*/
            if(!$(".project_slider ul li:not('.video_embedd')").length){
                $(".project_slider ul li.video_embedd").addClass("iframe-min-height");
                $(".project_slider ul li.video_embedd iframe").addClass("iframe-min-height");
            }
            /*Remove min-height if there are images*/

            /*Slider Navigation*/
			function pause_all_videos(){
				var player = $(".project_slider ul li:visible iframe");
				if(player.length){
					playPuaseVideo(player);
				}
			}
            $("a.next").click(function(e){
                e.preventDefault();
				pause_all_videos();
                var cur_slide = $(".project_slider ul li:visible");
                var next_slide = cur_slide.next();
                if(!next_slide.length){
                    next_slide = $(".project_slider ul li:first-child");
                }
                cur_slide.stop(true,true).hide();
				next_slide.stop(true,true).show();
				$(".bullets-pr-slider ul li a.active_bullet").removeClass("active_bullet");
				$(".bullets-pr-slider ul li:eq("+next_slide.index()+") a").addClass("active_bullet");
            });

            $("a.prev").click(function(e){
                e.preventDefault();
				pause_all_videos();
                var cur_slide = $(".project_slider ul li:visible");
                var next_slide = cur_slide.prev();
                if(!next_slide.length){
                    next_slide = $(".project_slider ul li:last");
                }
                cur_slide.stop(true,true).hide();
				next_slide.stop(true,true).show();
				$(".bullets-pr-slider ul li a.active_bullet").removeClass("active_bullet");
				$(".bullets-pr-slider ul li:eq("+next_slide.index()+") a").addClass("active_bullet");
            });

            /*Slider Navigation*/
			
			/*Make Slider Navigate By Swipe*/
            $(".project_slider").swipe({
                swipeLeft:function(event, direction, distance, duration, fingerCount) {
					/*Play Previous Slide*/
					var cur_bullet = $("a.active_bullet");
					var next_bullet = cur_bullet.parent().prev().children("a");
					if(!next_bullet.length){
						next_bullet = $("div.bullets-pr-slider ul li:last a");
					}
					next_bullet.trigger("click");
                },
				swipeRight:function(event, direction, distance, duration, fingerCount){
					/*Play Next Slide*/
					var cur_bullet = $("a.active_bullet");
					var next_bullet = cur_bullet.parent().next().children("a");
					if(!next_bullet.length){
						next_bullet = $("div.bullets-pr-slider ul li:eq(0) a");
					}
					next_bullet.trigger("click");
				}
            });
            /*Make Slider Navigate By Swipe*/
			
            var num_of_slides = $(".project_slider ul li").length;
            for(var i = 0 ; i < num_of_slides ; i++){
                $(".bullets-pr-slider ul").append('<li><a href="#"></a></li>');
            }
            $(".bullets-pr-slider ul li:eq(0) a").addClass("active_bullet");
            $(".bullets-pr-slider ul li a").click(function(e){
                e.preventDefault();
				pause_all_videos();
                if($(this).hasClass("active_bullet")){
                    return false;
                }
                var cur_slide = $(".project_slider ul li:visible");
                var next_slide = $(".project_slider ul li:eq("+$(this).parent().index()+")");
                cur_slide.stop(true,true).fadeOut("fast",function(){
                    next_slide.stop(true,true).fadeIn("fast");
                });
                $(".bullets-pr-slider ul li a.active_bullet").removeClass("active_bullet");
                $(this).addClass("active_bullet");
            });
            $(".inner_content").waitForImages(function(){
                //make_slider_height();
				$(".project_slider ul li").imgLiquid({
					fill:false
				});
            });
			<?php if(get_field("auto_slide") == "Enabled"): ?>
			var is_slider_hovered = false;
			$("div.project_slider").hover(function(){ is_slider_hovered = true; },function(){ is_slider_hovered = false; });			
			window.setTimeout(function(){
				slider_auto_slide();
			},5000);			
			function slider_auto_slide(){
				if(!is_slider_hovered){
					var cur_slide = $(".project_slider ul li:visible");
					var next_slide = cur_slide.next();
					if(!next_slide.length){
						next_slide = $(".project_slider ul li:first-child");
					}
					cur_slide.stop(true,true).fadeOut("fast",function(){
						next_slide.stop(true,true).fadeIn("fast");
						$(".bullets-pr-slider ul li a.active_bullet").removeClass("active_bullet");
						$(".bullets-pr-slider ul li:eq("+next_slide.index()+") a").addClass("active_bullet");
					});
				}
				window.setTimeout(function(){
					slider_auto_slide();
				},5000);
			}
			<?php endif; ?>
            function make_slider_height(){
				var visible_slide = $(".project_slider").find("ul li:visible");
				$(".project_slider").find("ul li").show();
                //$(".project_slider").find("ul").removeAttr("style");
                //var highet_element = get_talles_object($(".project_slider").find("ul li"));
                //$(".project_slider").find("ul").css("height",highet_element+"px");
				$(".project_slider").find("ul li:not(.video_embedd)").each(function(){
					var child = $(this);
					var parent = $(this).parent();
					center_horizontally(parent,child,0);
					center_vertically(parent,child,0);
				});
				$(".project_slider").find("ul li").hide();
				visible_slide.show();
            }
            function center_bullets(){
                var parent = $(".bullets-pr-slider");
                var child = parent.find("ul");
                center_horizontally(parent,child,0);
            }
            center_bullets();
            $(window).resize(function(){
                //make_slider_height();
                center_bullets();
            });
        });
    </script>
<?php get_footer(); ?>