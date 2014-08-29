<div class="body_class_container">
    <?php
        $portfolio_gallery = isset($GLOBALS["portfolio_gallery"]) && $GLOBALS["portfolio_gallery"] ? "portfolio_gallery" : "";
    ?>
    <a <?php body_class($portfolio_gallery); ?>></a>
</div>
<div class="container affilations__box">
    <div class="row">
        <div class="col-sm-12">
            <h3>Affilations</h3>
        </div>
        <div class="col-md-3">
                    <p>ASTD & GBR</p>
<img src="http://clients.hatchit.co/engineeringleadership/wp-content/uploads/2014/08/shrm_astd.png" class="attachment-medium" alt="shrm_astd">

        </div>
        <div class="col-md-3">
            <p>Louisiana Engineering Society</p>
<img src="http://clients.hatchit.co/engineeringleadership/wp-content/uploads/2014/08/LES-fixed.jpg" class="attachment-medium" alt="shrm_astd">

        </div>
        <div class="col-md-3">
            <p>National Society of Professional Engineers</p>
<img src="http://clients.hatchit.co/engineeringleadership/wp-content/uploads/2014/08/NSPE-fixed.jpg" class="attachment-medium" alt="shrm_astd">

        </div>
        <div class="col-md-3">
            <p>American Society of Civil Engineers</p>
<img src="http://clients.hatchit.co/engineeringleadership/wp-content/uploads/2014/08/ASCE-fixed.jpg" class="attachment-medium" alt="shrm_astd">

        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        <?php if(isset($_REQUEST["um_ajax_load_site"])): ?>
            $("title").text("<?php bloginfo('name'); ?> | <?php if(is_home() || is_front_page()){ bloginfo("description"); } wp_title("",true,""); ?>");
        <?php endif; ?>
        $('.accordion li:first-child').find('a').addClass('active').find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
        $('.accordion li:first-child').find('.section_content').show();

        $('.tabs .tab_buttons > li:first-child').find('a').addClass('active');
        $('.tabs .tab_content li:first-child').show();
        $("body").attr("class",$(".body_class_container a").attr("class"));
		$(".logo img").attr("src","<?php echo get_field("site_logo") ? get_field("site_logo") : get_field("main_logo","options"); ?>");
        $( document.body ).trigger("post-load");
        $('body').waitForImages(function(){
            <?php if(isset($_REQUEST["um_ajax_load_site"]) && $_REQUEST["um_ajax_load_site"]): ?>
                if($(".navHeaderCollapse").is(":visible")){
                    $(".navHeaderCollapse").collapse('hide');
                }
            <?php endif; ?>
        });
    });
</script>
<?php if(!isset($_REQUEST["um_ajax_load_site"])): ?>
</div>
<?php if(get_field("custom_css","options")): ?>
    <style type="text/css">
        <?php the_field("custom_css","options"); ?>
    </style>
<?php endif; ?>
<?php if(get_field("custom_javascript","options")): ?>
    <script type="text/javascript">
        <?php the_field("custom_javascript","options"); ?>
    </script>
<?php endif; ?>
<?php if(get_field("google_analytics_tracking_code","options")): ?>
    <?php the_field("google_analytics_tracking_code","options"); ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
<?php endif; ?>