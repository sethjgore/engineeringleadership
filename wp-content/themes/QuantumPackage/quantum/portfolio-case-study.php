<?php get_header(); ?>
    <div class="col-sm-12 row page_top top_project">
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
				<a href="<?php echo get_permalink($next_post->ID); ?>"><?php _e("Next Post","um_lang"); ?></a>
		<?php
				endif;
				if($prev_post && $next_prev):
		?>
				<a href="<?php echo get_permalink($prev_post->ID); ?>"><?php _e("Previous Post","um_lang"); ?></a>
		<?php
				endif;
		?>
    </div>
    <div class="row">
        <div class="project_desc col-sm-12 col-md-3">
            <h4><?php _e("Description","um_lang"); ?></h4>
            <?php
                global $post;
                setup_postdata($post);
                the_content();

            $services = get_field("project_brief");
            if($services && !post_password_required()):
            ?>
            <h4><?php the_field("project_services_brief_text"); ?></h4>
            <ul class="pp_services">
                <?php foreach($services as $service): ?>
                    <li><i class="fa fa-arrow-right"></i><?php echo $service["item"]; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php
                endif;
                if(get_field("project_button_text") && get_field("project_button_url")):
            ?>
                <a href="<?php the_field("project_button_url"); ?>" class="button_u"><?php the_field("project_button_text"); ?></a>
            <?php endif; ?>
        </div>

        <div class="project-images col-sm-12 col-md-9">
            <?php
                $slider = get_field("slider");
                if($slider && !post_password_required()):
            ?>
            <ul>
                <?php foreach($slider as $slide): ?>
                    <?php if($slide["video_url"]): ?>
                        <li class="video_embedd_case_study"><?php echo getVideoEmbed($slide["video_url"]); ?></li>
                    <?php elseif($slide["image"]): ?>
                        <li>
							<img data-original="<?php echo get_field("disable_image_resize") == "Enabled" ? $slide["image"] : aq_resize($slide["image"],848); ?>" alt=""/>
							<?php 
								$postid = um_get_id_from_src( $slide["image"] );
								$img_post = get_post($postid);
								if($img_post->post_excerpt){
									echo "<h3>".$img_post->post_excerpt."</h3>";
								}
							?>
						</li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <div class="appreciate">
                <?php
                $coockie_offset = 'um_liked_'.$post->ID;
                $liked = isset($_COOKIE[$coockie_offset]) && $_COOKIE[$coockie_offset] ? "liked" : "";
                ?>
                <a href="#" class="like_post <?php echo $liked; ?>" data-postid="<?php echo $post->ID; ?>"><i class="icon-heart"></i><?php _e("Appreciate","um_lang"); ?></a>
                <div class="appr_count"><?php echo get_likes(); ?></div>
            </div>
            <div class="share_this">
                <ul>
                    <li><a href="<?php the_permalink(); ?>" class="facebook_share"><i class="fa fa-facebook"></i><?php _e("Share","um_lang"); ?></a></li>
                    <li><a href="<?php the_permalink(); ?>" class="twitter_share"><i class="fa fa-twitter"></i><?php _e("Tweet","um_lang"); ?></a></li>
                    <li><a href="<?php the_permalink(); ?>" class="pinteres_share" data-image="<?php echo get_post_featured_image_src(); ?>"><i class="fa fa-pinterest"></i><?php _e("Pin","um_lang"); ?></a></li>
                </ul>
            </div>
        </div>
    </div>

	<!--<a id="go_to_top" href="#"><i class="fa fa-arrow-up"></i></a>-->
	<style>
		#go_to_top{
			position: fixed;
			bottom: 50px;
			right: 50px;
			display: block;
			height: 40px;
			width: 40px;
			background-color: #8fd0cc;
			color: #fff;
			text-align: center;
			padding-top: 10px;
		}
	</style>
	<script>
	jQuery(document).ready(function($){
		$(".project-images ul li img").lazyload({
			effect : "fadeIn"
		});
	});
	</script>
<?php get_footer(); ?>