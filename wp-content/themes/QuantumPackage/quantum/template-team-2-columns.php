<?php
/*Template Name:Team 2 Columns*/
get_header();
?>

    <div class="col-sm-12 row page_top">
        <h2><?php the_field("page_heading"); ?></h2>
    </div>
    <div class="grid_4_team row">

        <?php
        $team = get_field("team");
        if($team):
            foreach($team as $key => $member):
                ?>
                <div class="team_con_g col-sm-6 animated fadeIn">
                    <div class="post_thumb_g">
                        <div class="post_thumb_hover_holder_g">
                            <div class="post_thumb_hover_g">
                                <span class="helper"></span>
                                <div class="hover_social">
                                    <ul>
                                        <?php
                                        $social = $member["social_networks"];
                                        if($social):
                                            foreach($social as $r):
                                                ?>
                                                <li><a href="<?php echo $r["social_network_url"]; ?>"><i class="fa <?php echo $r["social_network"]; ?>"></i></a></li>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php if($member["image"]): ?>
                            <img src="<?php echo aq_resize($member["image"],555,409,true); ?>" alt=""/>
                        <?php endif; ?>
                    </div>
                    <div class="team_desc">
                        <h2><?php echo $member["name"]; ?></h2>
                        <h3><?php echo $member["position"]; ?></h3>
                        <div class="clearfix"></div>
                        <p><?php echo $member["description"]; ?></p>
                    </div>
                </div>
				<?php if(($key + 1) % 2 == 0 && $key != 0): ?>
					<div class="clearfix"></div>
            <?php
					endif;
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
            $("body").attr("class",$(".body_class_container a").attr("class"));
            function center_hovers(){
                $(".team_con_g").each(function(){
                    var hover_child = $(this).find(".hover_social");
                    var hover_parent = $(this).find(".post_thumb_hover_g");
                    //center_vertically(hover_parent,hover_child,0);
                    center_horizontally(hover_parent,hover_child,20);
                });
            }

            $(".inner_content").waitForImages(function(){
                center_hovers();
            });

            $(window).smartresize(function(){
                center_hovers();
            });
        });
    </script>
    <style type="text/css">
        .helper{
            display: inline-block;
            height: 50%;
            vertical-align: middle;
        }
    </style>
<?php get_footer(); ?>