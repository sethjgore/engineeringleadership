jQuery(document).ready(function($){

    $(document).on("click","body",function(e){
        $("div.filter_category").stop(true,true).fadeOut("fast")
    });

    $("body").on("click","a.show_sort_categories",function(e){
        e.preventDefault();
        e.stopPropagation();
        $("div.filter_category").stop(true,true).fadeToggle("fast");
    });
	
	/*Select Drop-down menu navigation*/
	$("div.select_drop_down select").change(function(){
		var url = $(this).find("option:selected").data("url");
		window.location = url;
	});
	/*Select Drop-down menu navigation*/
	
	/*Add to cart product, update cart totals*/
	$("body").on("added_to_cart",function(fragments){
		/*Refresh Cart Totals*/
		$.post(um_ajaxurl,{ action : "um_get_cart_totals" } , function(data){
			$("div.count_pr p").text(data);
		});
		/*Refresh Cart Totals*/
	});
	/*Add to cart product, update cart totals*/
	
    /*Back To Projects Page*/
    $("body").on("click","a.back_button",function(e){
        if(typeof window.history.pushState == 'function' && window.history.length > 1){
            history.go(-1);
        }else{
            window.location = $(this).attr("href");
        }
        e.preventDefault();
        e.stopPropagation();
    });
    /*Back To Projects Page*/

    /*Filter Projects*/

        /*Filter Popular*/
        $("body").on("click","a.filter_popular",function(e){
            e.preventDefault();
            /*Hide Posts And Show Spinner*/
            $(".load_posts > div").hide();
            $(".load_posts").css("height","200px");
            $(".load_posts").append("<div class='spinner'></div>");
            /*Hide Posts And Show Spinner*/
            $("a.filter_cat.active").removeClass("active");
            filter = 'popular';
            paged_projects = 1;
            var url = window.location.href;
            var ajax_data = {
                um_page : paged_projects,
                filter : filter,
                um_load_more : true
            };
            $.post(url,ajax_data,function(data){
                $(".load_posts").css("height","auto");
                if($(".load_posts").hasClass("masonry_works")){
                    var data = $(data);
                    $(".load_posts").html(data);
                    $(".load_posts").waitForImages(function(){
                        $(".masonry_works").masonry( 'destroy' );
                        $(".masonry_works").masonry({
                            itemSelector: '.project_con'
                        });
                    });
                }else{
                    $(".load_posts").html(data);
                }
                $("div.load_more_btn").show();
            });
        });
        /*Filter Popular*/

        /*Filter Recent*/
        $("body").on("click","a.filter_recent",function(e){
            e.preventDefault();
            /*Hide Posts And Show Spinner*/
            $(".load_posts > div").hide();
            $(".load_posts").css("height","200px");
            $(".load_posts").append("<div class='spinner'></div>");
            /*Hide Posts And Show Spinner*/
            $("a.filter_cat.active").removeClass("active");
            filter = 'recent';
            paged_projects = 1;
            var url = window.location.href;
            var ajax_data = {
                um_page : paged_projects,
                filter : filter,
                um_load_more : true
            };
            $.post(url,ajax_data,function(data){
                $(".load_posts").css("height","auto");
                if($(".load_posts").hasClass("masonry_works")){
                    var data = $(data);
                    $(".load_posts").html(data);
                    $(".load_posts").waitForImages(function(){
                        $(".masonry_works").masonry( 'destroy' );
                        $(".masonry_works").masonry({
                            itemSelector: '.project_con'
                        });
                    });
                }else{
                    $(".load_posts").html(data);
                }
                $("div.load_more_btn").show();
            });
        });
        /*Filter Recent*/

        /*Filter Category*/
        $("body").on("click","a.filter_cat",function(e){
            e.preventDefault();
            e.stopPropagation();
            /*Hide Posts And Show Spinner*/
            $(".load_posts > div").hide();
            $(".load_posts").css("height","200px");
            $(".load_posts").append("<div class='spinner'></div>");
            /*Hide Posts And Show Spinner*/
            $("a.filter_cat.active").removeClass("active");
            $(this).addClass("active");
            filter = $(this).attr("href");
            paged_projects = 1;
            var url = window.location.href;
            var ajax_data = {
                um_page : paged_projects,
                filter : filter,
                um_load_more : true
            };
            $.post(url,ajax_data,function(data){
                $(".load_posts").css("height","auto");
                if($(".load_posts").hasClass("masonry_works")){
                    var data = $(data);
                    $(".load_posts").html(data);
                    $(".load_posts").waitForImages(function(){
                        $(".masonry_works").masonry( 'destroy' );
                        $(".masonry_works").masonry({
                            itemSelector: '.project_con'
                        });
                    });
                }else{
                    $(".load_posts").html(data);
                }
                $("div.filter_category").stop(true,true).fadeToggle("fast");
                $("div.load_more_btn").show();
            });
        });
        /*Filter Category*/

    /*Filter Projects*/

    /*Load More Projects*/
    $("body").on("click","div.load_more_btn a:not('.load_more_blog')",function(e){
        e.preventDefault();
        $(this).parent().addClass("spinner_visible");
        var url = window.location.href;
        paged_projects++;
        var ajax_data = {
			paged : paged_projects,
            um_page : paged_projects,
            filter : filter,
            um_load_more : true
        };
        $.post(url,ajax_data,function(data){
            $(".spinner_visible").removeClass("spinner_visible");
            if($.trim(data)){
                if($(".load_posts").hasClass("masonry_works")){
                    var data = $(data);
                    $(".load_posts").append(data);
                    $(".load_posts").waitForImages(function(){
                        $(".load_posts").masonry( 'appended', data );
                    });
                }else{
                    $(".load_posts").append(data);
                }
                $("div.load_more_btn").show();
            }else{
                $("div.load_more_btn").stop(true,true).fadeOut("fast");
            }
        }).error(function(){
			$("div.load_more_btn").stop(true,true).fadeOut("fast");
		});
    });
    /*Load More Projects*/

    /*Load More Blog*/
    $("body").on("click","a.load_more_blog",function(e){
        e.preventDefault();
        var url = window.location.href;
        blog_page++;
        var ajax_data = {
            paged : blog_page,
            um_load_more : true
        };
        $.post(url,ajax_data,function(data){
            if($.trim(data)){
                $("div.blog_posts").append(data);
            }else{
                $("div.load_more_btn").stop(true,true).fadeOut("fast");
            }
        });
    });
    /*Load More Blog*/

    /*Like Post*/
    $("body").on("click","a.like_post",function(e){
        e.preventDefault();
        var postid = $(this).data("postid");
        if(!getCookie("um_liked_"+postid)){
            var this_anchor = $(this);
            var ajax_data = {
                um_post_id : postid,
                action : "um_like_post"
            };
            $.post(um_ajaxurl,ajax_data,function(data){
                this_anchor.next().text(data);
                this_anchor.addClass("liked");
                setCookie("um_liked_"+postid,"true",365);
            });
        }
    });
    /*Like Post*/

    /*Contact Form*/
    $("body").on("submit","form.contact_page_form",function(e){
        var name = $(this).find("#w-name");
        var email = $(this).find("#w-email");
        var message = $(this).find("#w-message");
        var url = $(this).attr("action");
        var return_state = true;
        var form = $(this);
        if(name.val() == ""){
            name.addClass("error");
            return_state = false;
        }
        if(email.val() == "" || !validateEmail(email.val())){
            email.addClass("error");
            return_state = false;
        }
        if(message.val() == ""){
            message.addClass("error");
            return_state = false;
        }
        if(return_state){
            if($(this).hasClass("captcha")){
                return true;
            }
            var data = {
                um_name : name.val(),
                um_email : email.val(),
                um_message : message.val()
            }
            $.post(url,data,function(data){
                form.fadeOut("normal",function(){
                    form.next(".success-message").fadeIn("normal");
                });
            });
        }
        return false;
    });

    $("body").on("submit","form.contact-widget:not(.contact_page_form)",function(e){
        var name = $(this).find("#w-name");
        var email = $(this).find("#w-email");
        var message = $(this).find("#w-message");
        var search_form = $(this).data("contact_form_id");
        var url = um_ajaxurl;
        var return_state = true;
        var form = $(this);
        if(name.val() == ""){
            name.addClass("error");
            return_state = false;
        }
        if(email.val() == "" || !validateEmail(email.val())){
            email.addClass("error");
            return_state = false;
        }
        if(message.val() == ""){
            message.addClass("error");
            return_state = false;
        }

        if(return_state){
            var data = {
                um_name : name.val(),
                um_email : email.val(),
                um_message : message.val(),
                um_search_form : search_form,
                action : "um_send_email"
            }
            $.post(url,data,function(data){
                form.fadeOut("normal",function(){
                    form.next().fadeIn("normal");
                });
            });
        }
        return false;
    });

    $("body").on("click","form.contact_page_form input, form.contact_page_form textarea , form.contact-widget input , form.contact-widget textarea",function(){
        $(this).removeClass();
    });
    /*Contact Form*/

    /*Social Media Share*/
    $("body").on("click","a.facebook_share",function(e){
        e.preventDefault();
        winHeight = 400;
        winWidth = 600;
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        var title = "Facebook";
        var descr = "Share On Facebook";
        var url = $(this).attr("href");
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    });

    $("body").on("click","a.twitter_share",function(e){
        e.preventDefault();
        var width  = 575,
            height = 400,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                ',width='  + width  +
                ',height=' + height +
                ',top='    + top    +
                ',left='   + left;

        window.open("https://twitter.com/intent/tweet?url="+url, 'Tweet', opts);
    });

    $("body").on("click","a.pinteres_share",function(e){
        e.preventDefault();
        e.preventDefault();
        var width  = 575,
            height = 600,
            left   = ($(window).width()  - width)  / 2,
            top    = ($(window).height() - height) / 2,
            url    = this.href,
            opts   = 'status=1' +
                ',width='  + width  +
                ',height=' + height +
                ',top='    + top    +
                ',left='   + left;
        var img = $(this).data("image");
        window.open("http://www.pinterest.com/pin/create/button/?url="+url+"&media="+img, 'Pinterest', opts);
    });
    /*Social Media Share*/

	$(window).load(function(){
        hide_loader();
        var main_logo = $("div.logo img");
        var logo_parent = $("div.logo");
		
		var responsive_logo = $("div.responsive_logo img");
		var responsive_logo_parent = $("div.responsive_logo");
		
        center_vertically(logo_parent,main_logo,0);
        //center_horizontally(responsive_logo_parent,responsive_logo,0);
	});

    /*Shortcodes*/

    /*Accordions*/

    $("body").on("click","ul.accordion li > a",function(e){
        e.preventDefault();
        var parent = $(this).closest("ul.accordion");
        var this_element = $(this);
        parent.find("a.active").removeClass("active").find('i').addClass('icon-plus-sign').removeClass('icon-minus-sign').parent().siblings(".section_content").stop(true,true).slideUp({
            duration : 200 ,
            complete : function(){
                this_element.addClass("active").find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign').parent().siblings(".section_content").stop(true,true).slideDown({

                });
            }
        });
    });

    /*Tabs*/

    $("body").on("click","div.tabs ul.tab_buttons li > a",function(e){
        e.preventDefault();
        var parent = $(this).parent().parent();
        var this_index = $(this).parent().index();
        parent.find("a").removeClass("active");
        $(this).addClass("active");
        parent.next().children("li").stop(true,true).fadeOut({
            duration : 200 ,
            complete : function(){
                parent.next().children("li").eq(this_index).stop(true,true).fadeIn({
                    duration : 200
                });
            }
        });
    });

    /*Toggles*/
    $("body").on("click",".toggle li > a",function(e){
        e.preventDefault();
        var section_content = $(this).siblings(".section_content");
        if($(this).hasClass("active")){
            $(this).removeClass("active").find('i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        }else{
            $(this).addClass("active").find('i').removeClass('icon-plus-sign').addClass('icon-minus-sign');
        }
        section_content.stop(true,true).slideToggle({
            duration : 200
        });
    });

    $("body").on("click","div.alert_container a.close",function(e){
        e.preventDefault();
        $(this).parent().fadeOut({
            duration : 800
        });
    });
    /*Alerts*/

    /*Shortcodes*/
});

/*Custom Functions*/
var show_loader = function(){
    jQuery(".loader").show();
}

var hide_loader = function(){
    jQuery(".loader").hide();
}
var get_talles_object = function(el){
    var maxHeight = -1;
    jQuery(el).each(function() {
        maxHeight = maxHeight > jQuery(this).height() ? maxHeight : jQuery(this).height();
    });
    return maxHeight;
}

var get_widest_object = function(el){
    var maxWidth = -1;
    jQuery(el).each(function() {
        maxWidth = maxWidth > jQuery(this).width() ? maxWidth : jQuery(this).width();
    });
    return maxWidth;
}

var center_horizontally = function(parent,child,offset){
    var this_img = jQuery(child);
    var parent_width = parseInt(parent.width() / 2);
    var this_img_width = parseInt(this_img.width() / 2);
    this_img.css("margin-left",(parent_width - this_img_width) - offset + "px");
}

var center_vertically = function(parent,child,offset){
    var this_img = jQuery(child);
    var parent_height = parseInt(parent.height() / 2);
    var this_img_height = parseInt(this_img.height() / 2);
    this_img.css("margin-top",(parent_height - this_img_height) - offset + "px");
}

/*Custom Functions*/
function playPuaseVideo(player){
    pasueVimeo(player);
    pasueYoutube(player);
}
function pasueVimeo(player) {
    pauseAllVimeos();
    player = player.find("iframe.vimeo").get(0);
    if (player) {
        player = player.contentWindow;
        player.postMessage('{"method":"play"}', '*');
    }
}

function pasueYoutube(player) {
    pauseAllYoutubes();
    player = player.find("iframe.youtube").get(0);
    if (player) {
        player = player.contentWindow;
        var func = "playVideo";
        player.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
    }
}

function pauseAllYoutubes() {
    var youtube_players = jQuery("iframe.youtube");
    for (var i = 0; i < youtube_players.length; i++) {
        var youtube_player = youtube_players[i];
        youtube_player = youtube_player.contentWindow;
        var func = "pauseVideo";
        youtube_player.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
    }
}

function pauseAllVimeos() {
    var youtube_players = jQuery("iframe.vimeo");
    for (var i = 0; i < youtube_players.length; i++) {
        var youtube_player = youtube_players[i];
        youtube_player = youtube_player.contentWindow;
        youtube_player.postMessage('{"method":"pause"}', '*');
    }
}
/*Custom Functions*/
/*Custom Functions*/

function setCookie(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1)
    {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1)
    {
        c_value = null;
    }
    else
    {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}