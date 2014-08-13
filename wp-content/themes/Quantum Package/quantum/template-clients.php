<?php
/*Template Name:Clients*/
get_header();
?>
    <div class="row col-sm-12 page_top">
       <h2><?php the_field("page_heading"); ?></h2>
    </div>
    <div class="row clients_container">
        <?php
            $repeater = get_field("clients");
            if($repeater):
                foreach($repeater as $r):
        ?>
            <div class="col-md-3 single_client animated fadeInUp">
                <div class="logo_holder">
                    <span class="helper_full"></span>
                    <a href="<?php echo $r["client_url"]; ?>">
                        <img src="<?php echo $r["client_logo"]; ?>" alt=""/>
                    </a>
                </div>
            </div>
        <?php
                endforeach;
            endif;
        ?>
    </div>
	<?php if(get_field("display_footer") != "Disabled"): ?>
    <div class="sidebar1">
        <?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
    </div>
	<?php endif; ?>	
    <script type="text/javascript">
        jQuery(document).ready(function($){
            function center_hovers(){
                $(".single_client").each(function(){
                    var hover_child = $(this).find(".logo_holder a img");
                    var hover_parent = $(this).find(".logo_holder");
                    center_vertically(hover_parent,hover_child,0);
                    //center_horizontally(hover_parent,hover_child,0);
                });
            }

            $(".inner_content").waitForImages(function(){
                //center_hovers();
            });

            $(window).smartresize(function(){
                //center_hovers();
            });
        });
    </script>
<?php get_footer(); ?>