<?php
    /*Template Name:Home Fullscreen*/
    get_header();
?>
<div id="slides">
    <ul class="slides-container">
        <?php
            $slider = get_field("slider");
            if($slider):
                foreach($slider as $slide):
        ?>
        <li>
            <?php if($slide["image"]): ?>
                <img src="<?php echo $slide["image"]; ?>" alt="<?php echo get_post_meta(um_get_id_from_src($slide["image"]) , '_wp_attachment_image_alt', true); ?>"/>
            <?php endif; ?>
            <div class="img_overlay" style="opacity: <?php echo get_field("overlay_opacity") ? get_field("overlay_opacity") : "0.5"; ?>;background: <?php echo get_field("overlay_color") ? get_field("overlay_color") : "#000"; ?>"></div>
            <div class="capture <?php echo $slide["captions_skin"] == "Dark" ? "dark-captions" : "";?>">
                <h2 class="<?php echo $slide["big_label_animation"]; ?>"><?php echo $slide["big_label"]; ?></h2>
                <h3 class="<?php echo $slide["small_label_animation"]; ?>"><?php echo $slide["small_label"]; ?></h3>
                <br style="clear: both"/>
                <?php if($slide["button_text"] && $slide["button_url"]): ?>
                    <a class="button_s <?php echo $slide["button_animation"]; ?>" href="<?php echo $slide["button_url"]; ?>"><?php echo $slide["button_text"]; ?></a>
                <?php endif; ?>
            </div>
        </li>
        <?php
                endforeach;
            endif;
        ?>
    </ul>
    <nav class="slides-navigation">
		<a href="#" class="next"><i class="fa fa-arrow-right"></i></a>
		<a href="#" class="prev"><i class="fa fa-arrow-left"></i></a>
	</nav>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var slides = $("#slides");
        $("body").attr("class",$(".body_class_container a").attr("class"));
        $(".inner_content").waitForImages(function(){
            slides.superslides({
                animation : "fade",
                pagination : false,
                play : <?php echo count($slider) > 1 ? "8000" : "0"; ?>
            });
            animate_slides();
            /*Swipe*/
            slides.swipe({
                swipe:function(event, direction, distance, duration, fingerCount) {
                    if(slides.superslides('size') > 1){
                        if(direction == 'right'){
                            slides.superslides('animate' , 'prev');
                        }else{
                            slides.superslides('animate' , 'next');
                        }
                    }
                }
            });
            /*Swipe*/
            /*Animate Captions And Button*/
            function animate_slides(){
                var cur_slide = $(".capture:eq("+slides.superslides('current')+")");
                /*Animate Heading*/
                $("div.capture h2").removeClass("animated");
                /*Animate Paragraph*/
                $("div.capture h3").removeClass("animated");
                /*Animate Anchors*/
                $("div.capture a").removeClass("animated");
                window.setTimeout(function(){
                    cur_slide.find("h2").addClass("animated");
                    cur_slide.find("h3").addClass("animated");
                    cur_slide.find("a").addClass("animated");
                },500);
            }
            slides.on("animated.slides",animate_slides);
            /*Animate Captions And Button*/
        });
    });
</script>
<?php get_footer(); ?>