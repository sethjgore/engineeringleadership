(function($){
	
	
	/*
	*  acf/setup_fields
	*
	*  This event is triggered when ACF adds any new elements to the DOM. 
	*
	*  @type	function
	*  @since	1.0.0
	*  @date	01/01/12
	*
	*  @param	event		e: an event object. This can be ignored
	*  @param	Element		postbox: An element which contains the new HTML
	*
	*  @return	N/A
	*/
	
	$(document).live('acf/setup_fields', function(e, postbox){
		
		$(postbox).find('.my-field-class').each(function(){
			

			
		});
	
	});

    var cur_point = "";
    var calc_point_pos = function(point){
        point = $(point);
        var x = $(point).position().top / $(point).parent().height() * 100;
        var y = $(point).position().left / $(point).parent().width() * 100;
        //point.attr("data-top",parseInt(x));
        //point.attr("data-left",parseInt(y));
        return {
            top : x,
            left : y
        };
    };

    function construct_data(parent){
        /*Get All Points And Collect Data*/
        var points = [];
        parent.find(".um_svg_marker").each(function(){
            var position = calc_point_pos($(this));
            var city = $(this).attr("data-city");
            var point_data = {
                position : position,
                city : city
            };
            points.push(point_data);
        });
        points = JSON.stringify(points);
        parent.find("#udrg_json_container").val(points);
        /*Get All Points And Collect Data*/
    }

    jQuery(document).ready(function($){
        function construct_dragable(){
            $("a.um_svg_marker").draggable({
                containment: "parent",
                scroll: false,
                stop : function(event,ui){
                    construct_data(ui.helper.parent().parent());
                }
            });
        }
        construct_dragable();
        $("body").on("click","a.um_svg_marker",function(){
            cur_point = $(this).eq(0);
            $(".um_ui_drag_dialog").find("#um_city_name").val($(this).attr("data-city"));
            $(".um_ui_drag_dialog").dialog({
                modal : true,
                close : function(event,ui){

                }
            });
        });
        $("body").on("click","#um_point_save",function(e){
            e.preventDefault();
            var city = $(this).parent().find("#um_city_name").val();
            cur_point.attr("data-city",city);
            $(".um_ui_drag_dialog").dialog("close");
            construct_data(cur_point.parent().parent());
        });
        $("body").on("click","#um_point_delete",function(e){
            e.preventDefault();
            $(".um_ui_drag_dialog").dialog("close");
            var parent = cur_point.parent().parent();
            cur_point.remove();
            construct_data(parent);
        });
        $("body").on("dblclick",".um-ui-container",function(e){
            e.preventDefault();
            $(this).append("<a href='#' style='top:0%;left:0%;' class='um_svg_marker'><i class='fa fa-map-marker'></i></a>");
            construct_dragable();
        });
    });

})(jQuery);
var Base64 = {

    // private property
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
                this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

        }

        return output;
    },

    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }

        }

        output = Base64._utf8_decode(output);

        return output;

    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

}
