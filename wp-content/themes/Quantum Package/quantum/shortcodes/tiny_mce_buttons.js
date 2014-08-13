var umb_active_tiny_mce;
(function() {
    /*Accordion*/
    tinymce.PluginManager.add('accordion_btn', function( editor, url ) {
        editor.addButton('accordion_btn', {
            title : 'Accordion',
            image : url+'/img/toggle.png',
            onclick : function() {
                umb_active_tiny_mce = editor;
                tb_show('Accordion', 'admin-ajax.php?action=umb_tabs_wizard&shortcode1=accordiongroup&shortcode2=accordion');
            }
        });
    });
    /*Accordion*/

    /*Toggle*/
    tinymce.PluginManager.add('toggle_btn', function(ed,url){
        ed.addButton('toggle_btn', {
            title : 'Toggle',
            image : url+'/img/toggle.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                tb_show('Toggle', 'admin-ajax.php?action=umb_tabs_wizard&shortcode1=togglegroup&shortcode2=toggle');
            }
        });
    });
    /*Toggle*/

    /*Tabs*/
    tinymce.PluginManager.add('tab_btn', function(editor,url){
        editor.addButton('tab_btn', {
            title : 'Tabs',
            image : url+'/img/tab.png',
            onclick : function() {
                umb_active_tiny_mce = editor;
                tb_show('Tabs', 'admin-ajax.php?action=umb_tabs_wizard&shortcode1=tabgroup&shortcode2=tab');
            }
        });
    });
    /*Tabs*/

    /*Notification*/
    tinymce.PluginManager.add('alert_btn', function(editor,url){
        editor.addButton('alert_btn', {
            title : 'Notification',
            image : url+'/img/notification.png',
            onclick : function() {
                umb_active_tiny_mce = editor;
                tb_show('Notification', 'admin-ajax.php?action=umb_notification_wizard');
            }
        });
    });
    /*Notificaion*/

    /*Dropcap*/
    tinymce.PluginManager.add('dropcap_btn', function(ed,url){
        ed.addButton('dropcap_btn', {
            title : 'Dropcap',
            image : url+'/img/dropcap.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                umb_active_tiny_mce.selection.setContent('[dropcap]'+ed.selection.getContent()+'[/dropcap]');
            }
        });
    });

    tinymce.PluginManager.add('dropcap2_btn', function(ed,url){
        ed.addButton('dropcap2_btn', {
            title : 'Dropcap 2',
            image : url+'/img/dropcap.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                umb_active_tiny_mce.selection.setContent('[dropcap2]'+ed.selection.getContent()+'[/dropcap2]');
            }
        });
    });
    /*Dropcap*/

    /*Highlights*/
    tinymce.PluginManager.add('highlight_btn', function(ed,url){
        ed.addButton('highlight_btn', {
            title : 'Highlight',
            image : url+'/img/dropcap.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                umb_active_tiny_mce.selection.setContent('[highlight]'+ed.selection.getContent()+'[/highlight]');
            }
        });
    });
    /*Highlights*/

    /*Boxed Content*/
    tinymce.PluginManager.add('boxed_btn', function(ed,url){
        ed.addButton('boxed_btn', {
            title : 'Boxed',
            image : url+'/img/paragraph.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                umb_active_tiny_mce.selection.setContent('[boxed]'+ed.selection.getContent()+'[/boxed]');
            }
        });
    });

    tinymce.PluginManager.add('boxed2_btn', function(ed,url){
        ed.addButton('boxed2_btn', {
            title : 'Boxed 2',
            image : url+'/img/paragraph.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                umb_active_tiny_mce.selection.setContent('[boxed2]'+ed.selection.getContent()+'[/boxed2]');
            }
        });
    });
    /*Boxed Content*/

    /*Buttons*/
    tinymce.PluginManager.add('button_btn', function(ed,url){
        ed.addButton('button_btn', {
            title : 'Button',
            image : url+'/img/buttons.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                tb_show('Buttons', 'admin-ajax.php?action=umb_buttons_wizard');
            }
        });
    });
    /*Buttons*/

    /*Video*/
    tinymce.PluginManager.add('video_btn', function(ed,url){
        ed.addButton('video_btn', {
            title : 'Video',
            image : url+'/img/video.png',
            onclick : function() {
                umb_active_tiny_mce = ed;
                tb_show('Video', 'admin-ajax.php?action=umb_video_wizard');
            }
        });
    });
    /*Video*/

    /*Layout*/
    /*tinymce.create('tinymce.plugins.layout', {
     createControl: function(n, cm) {
     switch (n) {
     case 'layout':
     var mlb = cm.createListBox('layout', {
     title : 'Layout',
     onselect : function(v) {
     switch(v){
     case 'full_width' : tinyMCE.activeEditor.selection.setContent("[layout][layout_group][full_width]"+tinyMCE.activeEditor.selection.getContent() +"[/full_width][/layout_group][/layout]");break;
     case 'half_width' : break;
     case 'one_third' : break;
     case 'one_fourth' : break;
     case 'one_sixth' : break;
     }

     }
     });

     // Add some values to the list box
     mlb.add('Full Width', 'full_width');
     mlb.add('Half Width', 'half_width');
     mlb.add('One Third', 'one_third');
     mlb.add('One Fourth', 'one_fourth');
     mlb.add('One Sixth', 'one_sixth');

     // Return the new listbox instance
     return mlb;
     }
     return null;
     }
     });
     tinymce.PluginManager.add('layout', tinymce.plugins.layout);*/
    tinymce.PluginManager.add('um_layout_btn', function(ed,url){
        ed.addButton('um_layout_btn', {
            title : 'Layout',
            type: 'menubutton',
            icon : 'icon dashicons dashicons-screenoptions',
            menu : [
                {
                    text: 'Full Width',
                    value: 'Full Width',
                    onclick: function() {
                        tinyMCE.activeEditor.selection.setContent("[layout][layout_group][full_width]"+tinyMCE.activeEditor.selection.getContent() +"[/full_width][/layout_group][/layout]");
                    }
                },
                {
                    text: 'Half Width',
                    value: 'Half Width',
                    onclick: function() {
                        tinyMCE.activeEditor.selection.setContent("[layout][layout_group][half_width]"+tinyMCE.activeEditor.selection.getContent() +"[/half_width][half_width][/half_width][/layout_group][/layout]");
                    }
                },
                {
                    text: 'One Third',
                    value: 'One Third',
                    onclick: function() {
                        tinyMCE.activeEditor.selection.setContent("[layout][layout_group][one_third]"+tinyMCE.activeEditor.selection.getContent() +"[/one_third][one_third][/one_third][one_third][/one_third][/layout_group][/layout]");
                    }
                },
                {
                    text: 'One Fourth',
                    value: 'One Fourth',
                    onclick: function() {
                        tinyMCE.activeEditor.selection.setContent("[layout][layout_group][one_fourth]"+tinyMCE.activeEditor.selection.getContent() +"[/one_fourth][one_fourth][/one_fourth][one_fourth][/one_fourth][one_fourth][/one_fourth][/layout_group][/layout]");
                    }
                },
                {
                    text: 'One Sixth',
                    value: 'One Sixth',
                    onclick: function() {
                        tinyMCE.activeEditor.selection.setContent("[layout][layout_group][one_sixth]"+tinyMCE.activeEditor.selection.getContent() +"[/one_sixth][one_sixth][/one_sixth][one_sixth][/one_sixth][one_sixth][/one_sixth][one_sixth][/one_sixth][one_sixth][/one_sixth][/layout_group][/layout]");
                    }
                }
            ]
        });
    });
    /*Layout*/

    /*ET Icons*/
    var et_icons = [{"class":".icon-mobile","char":"&#xe000;"},{"class":".icon-laptop","char":"&#xe001;"},{"class":".icon-desktop","char":"&#xe002;"},{"class":".icon-tablet","char":"&#xe003;"},{"class":".icon-phone","char":"&#xe004;"},{"class":".icon-document","char":"&#xe005;"},{"class":".icon-documents","char":"&#xe006;"},{"class":".icon-search","char":"&#xe007;"},{"class":".icon-clipboard","char":"&#xe008;"},{"class":".icon-newspaper","char":"&#xe009;"},{"class":".icon-notebook","char":"&#xe00a;"},{"class":".icon-book-open","char":"&#xe00b;"},{"class":".icon-browser","char":"&#xe00c;"},{"class":".icon-calendar","char":"&#xe00d;"},{"class":".icon-presentation","char":"&#xe00e;"},{"class":".icon-picture","char":"&#xe00f;"},{"class":".icon-pictures","char":"&#xe01;"},{"class":".icon-video","char":"&#xe011;"},{"class":".icon-camera","char":"&#xe012;"},{"class":".icon-printer","char":"&#xe013;"},{"class":".icon-toolbox","char":"&#xe014;"},{"class":".icon-briefcase","char":"&#xe015;"},{"class":".icon-wallet","char":"&#xe016;"},{"class":".icon-gift","char":"&#xe017;"},{"class":".icon-bargraph","char":"&#xe018;"},{"class":".icon-grid","char":"&#xe019;"},{"class":".icon-expand","char":"&#xe01a;"},{"class":".icon-focus","char":"&#xe01b;"},{"class":".icon-edit","char":"&#xe01c;"},{"class":".icon-adjustments","char":"&#xe01d;"},{"class":".icon-ribbon","char":"&#xe01e;"},{"class":".icon-hourglass","char":"&#xe01f;"},{"class":".icon-lock","char":"&#xe020;"},{"class":".icon-megaphone","char":"&#xe021;"},{"class":".icon-shield","char":"&#xe022;"},{"class":".icon-trophy","char":"&#xe023;"},{"class":".icon-flag","char":"&#xe024;"},{"class":".icon-map","char":"&#xe025;"},{"class":".icon-puzzle","char":"&#xe026;"},{"class":".icon-basket","char":"&#xe027;"},{"class":".icon-envelope","char":"&#xe028;"},{"class":".icon-streetsign","char":"&#xe029;"},{"class":".icon-telescope","char":"&#xe02a;"},{"class":".icon-gears","char":"&#xe02b;"},{"class":".icon-key","char":"&#xe02c;"},{"class":".icon-paperclip","char":"&#xe02d;"},{"class":".icon-attachment","char":"&#xe02e;"},{"class":".icon-pricetags","char":"&#xe02f;"},{"class":".icon-lightbulb","char":"&#xe030;"},{"class":".icon-layers","char":"&#xe031;"},{"class":".icon-pencil","char":"&#xe032;"},{"class":".icon-tools","char":"&#xe033;"},{"class":".icon-tools-2","char":"&#xe034;"},{"class":".icon-scissors","char":"&#xe035;"},{"class":".icon-paintbrush","char":"&#xe036;"},{"class":".icon-magnifying-glass","char":"&#xe037;"},{"class":".icon-circle-compass","char":"&#xe038;"},{"class":".icon-linegraph","char":"&#xe039;"},{"class":".icon-mic","char":"&#xe03a;"},{"class":".icon-strategy","char":"&#xe03b;"},{"class":".icon-beaker","char":"&#xe03c;"},{"class":".icon-caution","char":"&#xe03d;"},{"class":".icon-recycle","char":"&#xe03e;"},{"class":".icon-anchor","char":"&#xe03f;"},{"class":".icon-profile-male","char":"&#xe040;"},{"class":".icon-profile-female","char":"&#xe041;"},{"class":".icon-bike","char":"&#xe042;"},{"class":".icon-wine","char":"&#xe043;"},{"class":".icon-hotairballoon","char":"&#xe044;"},{"class":".icon-glob","char":"&#xe045;"},{"class":".icon-genius","char":"&#xe046;"},{"class":".icon-map-pin","char":"&#xe047;"},{"class":".icon-dial","char":"&#xe048;"},{"class":".icon-chat","char":"&#xe049;"},{"class":".icon-heart","char":"&#xe04a;"},{"class":".icon-cloud","char":"&#xe04b;"},{"class":".icon-upload","char":"&#xe04c;"},{"class":".icon-download","char":"&#xe04d;"},{"class":".icon-traget","char":"&#xe04e;"},{"class":".icon-hazardous","char":"&#xe04f;"},{"class":".icon-piechart","char":"&#xe050;"},{"class":".icon-speedometer","char":"&#xe051;"},{"class":".icon-global","char":"&#xe052;"},{"class":".icon-compass","char":"&#xe053;"},{"class":".icon-lifesaver","char":"&#xe054;"},{"class":".icon-clock","char":"&#xe055;"},{"class":".icon-aperture","char":"&#xe056;"},{"class":".icon-quote","char":"&#xe057;"},{"class":".icon-scope","char":"&#xe058;"},{"class":".icon-alarmclock","char":"&#xe059;"},{"class":".icon-refresh","char":"&#xe05a;"},{"class":".icon-happy","char":"&#xe05b;"},{"class":".icon-sad","char":"&#xe05c;"},{"class":".icon-facebook","char":"&#xe05d;"},{"class":".icon-twitter","char":"&#xe05e;"},{"class":".icon-googleplus","char":"&#xe05f;"},{"class":".icon-rss","char":"&#xe060;"},{"class":".icon-tumblr","char":"&#xe061;"},{"class":".icon-linkedin","char":"&#xe062;"},{"class":".icon-dribbble","char":"&#xe063;"}];
    var et_icons_dropdown = [];
    for(var i = 0 ; i < et_icons.length ; i++){
        var icon = et_icons[i];
        //mlb.add(icon.char.replace(".",""),icon.class.replace(".",""));
        et_icons_dropdown.push({
            text : icon.class.replace(".",""),
            value :  icon.class.replace(".","")
        });
    }
    tinymce.PluginManager.add('eticon_btn', function(ed,url){
        ed.addButton('eticon_btn', {
            title : 'ET Icons',
            icon : 'icon dashicons dashicons-editor-code',
            onclick : function() {
                umb_active_tiny_mce = ed;
                ed.windowManager.open( {
                    title: 'Choose The Icon',
                    body: [
                        {
                            type: 'textbox',
                            name: 'fontsize',
                            label: 'Font Size In Pixles'
                        },
                        {
                            type: 'listbox',
                            name: 'icon',
                            label: 'Icons',
                            'values': et_icons_dropdown
                        }],
                    onsubmit: function( e ) {
                        ed.insertContent("[eticon fontsize='"+ e.data.fontsize+"' icon='"+e.data.icon+"'][eticon]");
                    }
                });
            }
        });
    });
    /*ET Icons*/
})();