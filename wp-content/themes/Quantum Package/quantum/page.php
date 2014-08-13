<?php get_header(); ?>
<div class="default_top">
    <h2><?php the_title(); ?></h2>
</div>
<div class="content">
<?php
    $dynamic_sidebar = is_active_sidebar("page_sidebar");
    if($dynamic_sidebar){
        echo '<div class="col-md-9">';
    }
    global $post;
    setup_postdata($post);
    the_content();
    if($dynamic_sidebar){
        echo '</div>';
        echo '<div class="col-md-3">';
        dynamic_sidebar("page_sidebar");
        echo '</div>';
    }
?>
</div>
<div class="sidebar1">
	<?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("body").attr("class",$(".body_class_container a").attr("class"));
        $('.accordion li:first-child').find('a').addClass('active').find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');
        $('.accordion li:first-child').find('.section_content').show();

        $('.tabs .tab_buttons > li:first-child').find('a').addClass('active');
        $('.tabs .tab_content li:first-child').show();
    });
</script>
<?php get_footer(); ?>