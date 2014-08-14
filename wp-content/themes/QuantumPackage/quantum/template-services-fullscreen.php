<?php
/*Template Name:Services Full Screen*/
get_header();
?>
<div class="demo-1">
    <div id="slider" class="sl-slider-wrapper">

        <div class="sl-slider">
            <?php
                $repeater = get_field("services_fullscreen");
                $navigation = "";
                $first_child = " class='nav-dot-current'";
                if($repeater):
                    foreach($repeater as $r):
                        $navigation .= "<span {$first_child}></span>";
                        if($r["skin"] == "white"):
            ?>
            <div class="sl-slide bg-1" data-orientation="<?php echo $r["orientation"] == "Horizontal" ? "horizontal" : "vertical";?>" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                <?php elseif($r["skin"] == "green"): ?>
            <div class="sl-slide bg-2" data-orientation="<?php echo $r["orientation"] == "Horizontal" ? "horizontal" : "vertical";?>" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                <?php elseif($r["skin"] == "pink"): ?>
            <div class="sl-slide bg-3" data-orientation="<?php echo $r["orientation"] == "Horizontal" ? "horizontal" : "vertical";?>" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
				<?php else: ?>
            <div class="sl-slide bg-4" data-orientation="<?php echo $r["orientation"] == "Horizontal" ? "horizontal" : "vertical";?>" data-slice1-rotation="-5" data-slice2-rotation="25" data-slice1-scale="2" data-slice2-scale="1">
                <?php endif; ?>
                <div class="sl-slide-inner" <?php if($r["skin"] == "custom"): ?> style="background-color:<?php echo $r["skin_color"];?>" <?php endif;?>>
                    <div class="deco" <?php if($r["skin"] == "custom"): ?> style="border-color:<?php echo $r["skin_circle_color"];?>" <?php endif;?>>
						<i class="<?php echo str_replace(".","",$r["icon"]); ?>"></i>
					</div>
                    <h2><?php echo $r["title"]; ?></h2>
                    <blockquote><p><?php echo $r["description"]; ?></p><cite><?php echo $r["author"]; ?></cite></blockquote>
                </div>
            </div>
            <?php
                        $first_child = "";
                    endforeach;
                endif;
            ?>

        </div><!-- /sl-slider -->

        <nav id="nav-arrows" class="nav-arrows">
            <span class="nav-arrow-prev"><?php _e("Previous","um_lang"); ?></span>
            <span class="nav-arrow-next"><?php _e("Next","um_lang"); ?></span>
        </nav>

        <nav id="nav-dots" class="nav-dots">
            <?php echo $navigation; ?>
        </nav>

    </div><!-- /slider-wrapper -->
</div>
<script type="text/javascript">
        jQuery(document).ready(function($){
            $("body").attr("class",$(".body_class_container a").attr("class"));
            var Page = (function() {

                var $navArrows = $( '#nav-arrows' ),
                    $nav = $( '#nav-dots > span' ),
                    slitslider = $( '#slider' ).slitslider( {
                        onBeforeChange : function( slide, pos ) {

                            $nav.removeClass( 'nav-dot-current' );
                            $nav.eq( pos ).addClass( 'nav-dot-current' );

                        }
                    } ),

                    init = function() {

                        initEvents();

                    },
                    initEvents = function() {

                        // add navigation events
                        $navArrows.children( ':last' ).on( 'click', function() {

                            slitslider.next();
                            return false;

                        } );

                        $navArrows.children( ':first' ).on( 'click', function() {

                            slitslider.previous();
                            return false;

                        } );

                        $nav.each( function( i ) {

                            $( this ).on( 'click', function( event ) {

                                var $dot = $( this );

                                if( !slitslider.isActive() ) {

                                    $nav.removeClass( 'nav-dot-current' );
                                    $dot.addClass( 'nav-dot-current' );

                                }

                                slitslider.jump( i + 1 );
                                return false;

                            } );

                        } );

                    };

                return { init : init };

            })();

            Page.init();

            /**
             * Notes:
             *
             * example how to add items:
             */

            /*

             var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');

             // call the plugin's add method
             ss.add($items);

             */
        });
    </script>
<?php get_footer(); ?>