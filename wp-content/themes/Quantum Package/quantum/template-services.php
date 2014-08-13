<?php
/*Template Name:Services*/
get_header();
?>
    <div class="col-sm-12 row page_top">
		<h2><?php the_field("page_heading"); ?></h2>
    </div>
    <?php
        $repeater = get_field("services");
        if($repeater):
            $right = true;
            $aligment = get_field("aligment");
            $align_class = "";
            foreach($repeater as $r):
                if($aligment == "Left"){
                    $align_class = "service_l";
                }elseif($aligment == "Right"){
                    $align_class = "service_r";
                }else{
                    if($right){
                        $align_class = "service_r";
                        $right = false;
                    }else{
                        $align_class = "service_l";
                        $right = true;
                    }
                }
    ?>
                <div class="<?php echo $align_class; ?> s_global row">
                    <?php if($align_class == "service_l" && $r["service_image"]): ?>
                        <div class="col-sm-6 s_img service_row fadeInLeft">
                            <img src="<?php echo aq_resize($r["service_image"],555,321,true); ?>" alt="<?php echo get_post_meta(um_get_id_from_src($r["service_image"]) , '_wp_attachment_image_alt', true); ?>"/>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-5 s_desc service_row <?php echo $align_class == "service_l" ? "fadeInRight" : "fadeInLeft"; ?>">
                        <i class="<?php echo str_replace(".","",$r["icon"]); ?>"></i>
                        <h4><?php echo $r["name"]; ?></h4>
                        <p><?php echo nl2br($r["description"]); ?></p>
                    </div>
                    <?php if($align_class == "service_r" && $r["service_image"]): ?>
                        <div class="col-md-offset-1 col-sm-6 s_img service_row fadeInRight">
                            <img src="<?php echo aq_resize($r["service_image"],555,321,true); ?>" alt="<?php echo get_post_meta(um_get_id_from_src($r["service_image"]) , '_wp_attachment_image_alt', true); ?>"/>
                        </div>
                    <?php endif; ?>
                </div>
    <?php
            endforeach;
        endif;
    ?>
	<?php if(get_field("display_footer") != "Disabled"): ?>
    <div class="sidebar1">
        <?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
    </div>
	<?php endif; ?>	
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("body").attr("class",$(".body_class_container a").attr("class"));
            $(".s_global").waypoint(function(){
                $(this).find(".service_row").addClass("animated");
            },{
                triggerOnce : true,
                offset : 500
            });
        });
    </script>
<?php get_footer(); ?>