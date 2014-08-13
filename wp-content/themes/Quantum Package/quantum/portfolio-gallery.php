<?php
$GLOBALS["portfolio_gallery"] = true;
get_header();
$slider = get_field("slider");
if($slider):
/*Get Page By Template*/
$projects_page_url = "";
$the_query = new WP_Query( array(
    "posts_per_page" => 1,
    "post_type" => "page",
    "meta_query" => array(
        "relation" => "OR",
        array(
            "key" => "_wp_page_template",
            "value" => "template-projects-gallery.php"
        ),
        array(
            "key" => "_wp_page_template",
            "value" => "home",
            "compare" => "LIKE"
        )
    )
) );
if ( $the_query->have_posts() ){
    $the_query->the_post();
    $projects_page_url = get_permalink();
}
wp_reset_postdata();
/*Get Page By Template*/
?>
<a class="back_button" href="<?php echo $projects_page_url; ?>"><i class="fa fa-times"></i></a>
<?php
		$next_prev = get_field("next_prev","options") == "Enabled";
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		if($next_post && $next_prev):
?>
		<a class="next_prev next_post" href="<?php echo get_permalink($next_post->ID); ?>"><i class="fa fa-arrow-right"></i></a>
<?php
		endif;
		if($prev_post && $next_prev):
?>
		<a class="next_prev prev_post" href="<?php echo get_permalink($prev_post->ID); ?>"><i class="fa fa-arrow-left"></i></a>
<?php
		endif;
?>
<div class="fotorama" data-auto="false">
    <?php foreach($slider as $slide): ?>
		<?php 
			$postid = um_get_id_from_src( $slide["image"] );
			$img_post = get_post($postid);
		?>
        <img data-caption="<?php echo $img_post->post_excerpt; ?>" src="<?php echo $slide["image"]; ?>"/>
    <?php endforeach; ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("body").attr("class",$(".body_class_container a").attr("class"));
        show_loader();
        $(".inner_content").waitForImages(function(){
            $('.fotorama').fotorama({
                width : '100%',
                height : '97%',
                fit : '<?php the_field("image_resize"); ?>',
                nav : 'thumbs',
                transition : '<?php the_field("transition"); ?>'
            });
            hide_loader();
        });
    });
</script>
<?php
    endif;
    get_footer();
?>