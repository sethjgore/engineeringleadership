if(ajax_site){
	var history_count = 0;
    jQuery(document).ready(function($){

        /*Ajax Navigation*/
        $("body").on("click","ul.nav li a",function(e){
            if($(this).attr("target") || !ajax_site || $(this).attr("href") == "#" || $(this).parent().hasClass("menu-item-language")){
                return true;
            }
            e.preventDefault();
            show_loader();
            var url = jQuery(this).attr("href");
            var this_item = $(this);
            $.post(url, { um_ajax_load_site: true }, function (data){
                $(".inner_content").waitForImages(function(){
                    hide_loader();
                });
                changeURL(url);
                history_count = 1;
                $("li.current-menu-item").removeClass("current-menu-item active");
                this_item.parent().addClass("current-menu-item active");
                $("div.inner_content").html(data);
                scrollOnTop();
            }).error(function () {
                window.location = url;
                hide_loader();
            });
        });

        var ajax_button_selectors = [
            ".load_posts a",
            ".top_project a",
            ".horizontal_gallery a",
            ".blog_posts a",
            ".singlepost_info a",
            ".filter_category_blog a"
        ];

        $("body").on("click",ajax_button_selectors.toString(),function(e){
            if($(this).attr("target") || !ajax_site || $(this).attr("href") == "#"){
                return true;
            }
            e.preventDefault();
            var url = $(this).attr("href");
            load_data(url);
        });
        /*Ajax Navigation*/
    });
    /*Ajax Load*/
    function changeURL(path){
        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState(null, path , path);
        }else{
            window.location.hash = '#!' + path;
        }
    }

    function load_data(url){
        show_loader();
        jQuery(".nicescroll-rails").remove();
        jQuery.post(url, { um_ajax_load_site: true }, function (data) {
            hide_loader();
            changeURL(url);
            jQuery("div.inner_content").html(data);
            history_count = 1;
            scrollOnTop();
            //get_body_class(url);
        }).error(function () {
            hide_loader();
            window.location = url;
        });
    }

    window.onpopstate = function (event) {
        var url = document.URL;
		show_loader();
        jQuery(".nicescroll-rails").remove();
        jQuery.post(url, { um_ajax_load_site: true }, function (data) {
            hide_loader();
            jQuery("div.inner_content").html(data);
            history_count = 1;
            scrollOnTop();
            //get_body_class(url);
        }).error(function () {
            hide_loader();
            window.location = url;
        });
    };

    //IF - If hash is included than redirect to
    if(window.location.hash != ''){
        var hash = window.location.hash;
        hash = hash.replace('#!', " ")
        window.location = hash;
    }

    jQuery(document).ajaxSend(function(event, jqxhr, settings) {
        //show_loader();
    }).ajaxComplete(function(event, jqxhr, settings) {
        jQuery(".inner_content").waitForImages(function(){
            hide_loader();
        });
    })

    function scrollOnTop(){
        jQuery("html, body").animate({ scrollTop: "0px" });
    }
}
/*Ajax Load*/