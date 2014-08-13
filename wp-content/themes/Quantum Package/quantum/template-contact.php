<?php
$captcha = true;
if(isset($_REQUEST["um_name"]) && isset($_REQUEST["um_email"]) && isset($_REQUEST["um_message"])){
    $name = $_REQUEST["um_name"];
    $email = $_REQUEST["um_email"];
    $message = $_REQUEST[""];
    $to_email = get_field("contact_form_email");

    $subject = "[".get_bloginfo('name')."] - ".$email;
    $message = "
            Name : {$name},
            Email : {$email}

            $message
        ";
    $captcha = true;
    if(class_exists("ReallySimpleCaptcha")){
        $captcha_instance = new ReallySimpleCaptcha();
        $captcha = $captcha_instance->check( $_REQUEST["um_prefix"] , $_REQUEST["um_captcha"] );
        $captcha_instance->remove( $_REQUEST["um_prefix"] );
    }
    if($captcha){
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n";
        wp_mail($to_email,$subject,$message,$headers);
        if(class_exists("ReallySimpleCaptcha")){
            wp_die("E-mail Send <a href='#' onclick='history.go(-1);'>Back to page</a>");
        }
    }else{
        wp_die("Wrong Captcha <a href='#' onclick='history.go(-1);'>Back to page</a>");
    }
    die;
}
/*Template Name:Contact*/
get_header();
?>
    <div class="col-sm-12 row page_top" id="top_contact">
        <h2><?php echo get_field("get_in_touch") ? get_field("get_in_touch") : __("Get in touch with us","um_lang"); ?></h2>
    </div>
    <div class="clearfix"></div>
    <?php if(get_field("map_type") == "Custom Map"): ?>
    <div class="svg_map row col-xs-12">
            <?php
                $points = get_field("custom_map");
                $points = json_decode($points,true);
                if($points):
                    foreach($points as $p):
            ?>
            <div class="svg_marker" style="left: <?php echo $p["position"]["left"]; ?>%;top: <?php echo $p["position"]["top"]; ?>%;">
                <i class="fa fa-map-marker"></i>
                <p><?php echo $p["city"]; ?></p>
            </div>
            <?php
                    endforeach;
                endif;
            ?>
            <img class="map" src="<?php echo get_template_directory_uri(); ?>/assets/img/map.svg">
    </div>
    <?php else: ?>
    <div id="map" class="google_map google-maps">

    </div>
    <?php endif; ?>
    <div class="sidebar1 row col-sm-12">
        <div class="widget col-sm-4">
            <div class="widget_title">
                <h5><?php _e("Contact info","um_lang"); ?></h5>
            </div>
            <div class="widget_content">
                <p>
                    <?php the_field("contact_info"); ?>
                </p>
                <ul class="get_in_touch">
                    <?php if(get_field("address")): ?>
                    <li><i class="fa fa-home"></i><p><?php the_field("address"); ?></p></li>
                    <?php
                        endif;
                        if(get_field("email")):
                    ?>
                    <li><i class="fa fa-envelope"></i><p><?php the_field("email"); ?></p></li>
                        <?php
                        endif;
                    if(get_field("phone")):
                    ?>
                    <li><i class="fa fa-phone"></i><p><?php the_field("phone"); ?></p></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="widget col-sm-8">
            <div class="widget_title">
                <h5><?php _e("Get in touch","um_lang"); ?></h5>
            </div>
            <div class="widget_content">
                <form action="<?php the_permalink(); ?>" class="contact-widget contact_page_form <?php echo class_exists("ReallySimpleCaptcha") ? "captcha" : ""; ?>">
                    <p><input type="text" name="um_name" id="w-name" placeholder="<?php _e("Name","um_lang"); ?>"></p>
                    <p><input type="email" name="um_email" id="w-email" placeholder="<?php _e("Email","um_lang"); ?>"></p>
                    <p><textarea name="um_message" id="w-message" placeholder="<?php _e("Message","um_lang"); ?>"></textarea></p>
                    <?php if(class_exists("ReallySimpleCaptcha")):?>
                        <p class="captcha">
                            <?php
                            $captcha_instance = new ReallySimpleCaptcha();
                            $word = $captcha_instance->generate_random_word();
                            $prefix = mt_rand();
                            $img = $captcha_instance->generate_image( $prefix, $word );
                            $img = plugins_url()."/really-simple-captcha/tmp/".$img;
                            ?>
                            <img src="<?php echo $img; ?>"/><br/><br/>
                            <input type="text" name="um_captcha" placeholder="<?php _e("Type the captcha","um_lang"); ?>"/>
                            <input type="hidden" name="um_prefix" value="<?php echo $prefix; ?>"/>
                        </p>
                    <?php endif; ?>
                    <p><input type="submit" class="button_u" name="w-send" id="w-send" value="<?php _e("Send","um_lang"); ?>"></p>
                </form>
                <div class="success-message">
                    <?php the_field("success_message"); ?>
                </div>
            </div>
        </div>
    </div>
	<?php if(get_field("display_footer") != "Disabled"): ?>
    <div class="sidebar1">
        <?php dynamic_sidebar('sidebar');wp_reset_postdata(); ?>
    </div>
	<?php endif; ?>	
    <?php $map = get_field("google_map"); ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            if($("#map").length){
                initialize();
            }
            function calculate_height(){
                var img = $("img.map");
                var ratio = 1110 / 500;
                var height = img.width() / ratio;
                img.css("height",Math.ceil(height));
            }
            $(".svg_map").waitForImages(function(){
                calculate_height();
            });
            $(window).resize(function(){
                calculate_height();
            });
        });
        var map;
        function initialize() {
            var mapOptions = {
                zoom: parseInt('<?php the_field("map_zoom"); ?>'),
                center: new google.maps.LatLng(parseFloat("<?php echo $map["lat"]; ?>"), parseFloat("<?php echo $map["lng"]; ?>")),
                scrollwheel: false,
                styles: [
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 65
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 51
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            },
                            {
                                "saturation": -100
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 30
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 40
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            },
                            {
                                "saturation": -100
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": -25
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#ffff00"
                            },
                            {
                                "saturation": -97
                            },
                            {
                                "lightness": -25
                            }
                        ]
                    }
                ]
            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var marker = new google.maps.Marker({
                title : "<?php echo $map["address"]; ?>",
                position: new google.maps.LatLng(parseFloat("<?php echo $map["lat"]; ?>"), parseFloat("<?php echo $map["lng"]; ?>")),
                map: map
            });
        }
    </script>
<?php get_footer(); ?>