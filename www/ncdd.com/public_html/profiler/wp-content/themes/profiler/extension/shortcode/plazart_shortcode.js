/*global themeprefix: false, tinymce: false */
// JavaScript Document
(function () {
    "use strict";
    tinymce.create('tinymce.plugins.plazart.shortcode', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init:function (ed, url) {
            // Register command
            ed.addCommand(themeprefix + '_command_column', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-column.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-column.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-column.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_list', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-list.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-list.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-list.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_accordion', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-accordion.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-accordion.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-accordion.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_tabs', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-tabs.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-tabs.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-tabs.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_youtube', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-youtube.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-youtube.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-youtube.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_vimeo', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-vimeo.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-vimeo.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-vimeo.delta_height', 0), 10),
                    inline:1
                });
            });
            ed.addCommand(themeprefix + '_command_dropcap', function () {
                ed.windowManager.open({
                    file:url + '/plazart-shortcode-dropcap.php',
                    width:450 + parseInt(ed.getLang('plazart-shortcode-dropcap.delta_width', 0), 10),
                    height:450 + parseInt(ed.getLang('plazart-shortcode-dropcap.delta_height', 0), 10),
                    inline:1
                });
            });

            ed.addButton('services', {
                title : 'services',
                image : url+'/images/services.png',
                onclick: function() {
                    create_service();
                    jQuery.fancybox({
                        'type': 'inline',
                        'title' : 'Services',
                        'href'  : '#create_service',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    }) ;
                }
            });
            ed.addButton('download', {
                title : 'Download',
                image : url+'/images/download.png',
                onclick: function() {
                    create_download();
                    jQuery.fancybox({
                        'type': 'inline',
                        'title' : 'Download',
                        'href'  : '#create_download',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    }) ;
                }
            });
            ed.addButton('awards', {
                title : 'Awards',
                image : url+'/images/Awards.png',
                onclick: function() {
                    create_Awards();
                    jQuery.fancybox({
                        'type': 'inline',
                        'title' : 'Awards',
                        'href'  : '#create_Awards',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    }) ;
                }
            });
            ed.addButton('working', {
                title : 'working',
                image : url+'/images/working.png',
                onclick: function() {
                    create_working();
                    jQuery.fancybox({
                        'type': 'inline',
                            'title' : 'Working hour',
                        'href'  : '#create_working',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    }) ;
                }
            });
            ed.addButton('skill', {
                title : 'Skill',
                image : url+'/images/icon_skills-trans.png',
                onclick: function() {
                    create_skill();
                    jQuery.fancybox({
                        'type': 'inline',
                            'title' : 'Add Skill',
                        'href'  : '#create_skill',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    }) ;
                }
            });
            ed.addButton('pricing', {
                title  : 'pricing',
                image  : url + '/images/price_money.png',
                onclick: function() {
                    create_pricing() ;
                    jQuery.fancybox({
                        'type'  : 'inline',
                        'title' : 'pricing',
                        'href'  : '#create_pricing',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    })
                }
            }) ;

            ed.addButton('button_p', {
                title  : 'button',
                image  : url + '/images/button.png',
                onclick: function() {
                    create_button() ;
                    jQuery.fancybox({
                        'type'  : 'inline',
                        'title' : 'button',
                        'href'  : '#create_button',
                        helpers: {
                            title: {
                                type : 'over',
                                position: 'top'
                            }
                        }
                    })
                }
            }) ;
            ed.addButton('alert_one',{title:'Add alert one',image:url + '/images/alert.png',
                onclick:function(){
                    ed.focus();
                    ed.selection.setContent('[alert_one background="1 or 2 or 3"]content[/alert_one]');
                }
            });
            ed.addButton('alert_two',{title:'Add alert two',image:url + '/images/alert2.png',
                onclick:function(){
                    ed.focus();
                    ed.selection.setContent('[alert_two background="1 or 2 or 3" title="title for alert" description="this is description"] [button size="default" color="green" embossed="embossed" link="#" icon="fa-twitter"]button name[/button][/alert_two]');
                }
            });
            ed.addButton('title',{title:'Add title',image:url + '/images/title.png',
                onclick:function(){
                    ed.focus();
                    ed.selection.setContent('[title name="name for title"]');
                }
            });
            ed.addButton('contact_info',{title:'Add Contact info',image:url + '/images/Mail -2.png',
                onclick:function(){
                    ed.focus();
                    ed.selection.setContent('[contact_info title="title" address="address"  telephone="01 45 48 55 25" mobile="01 45 48 55 25" email="abc@gmail.com"]');
                }
            });


            /*
             ==========
             end js add button
             ==========
             */
            ed.addButton('column', {title:'Add Column', cmd:themeprefix + '_command_column', image:url + '/images/column.png' });
            ed.addButton('list', {title:'Add List', cmd:themeprefix + '_command_list', image:url + '/images/list.png' });
            ed.addButton('accordion', {title:'Add Accordion', cmd:themeprefix + '_command_accordion', image:url + '/images/accordion.png' });
            ed.addButton('tabs', {title:'Add Tabs', cmd:themeprefix + '_command_tabs', image:url + '/images/tab.png' });
            ed.addButton('youtube', {title:'Add Youtube', cmd:themeprefix + '_command_youtube', image:url + '/images/youtube.png' });
            ed.addButton('vimeo', {title:'Add Vimeo', cmd:themeprefix + '_command_vimeo', image:url + '/images/vimeo.png' });
            ed.addButton('dropcap', {title:'Add Dropcap', cmd:themeprefix + '_command_dropcap', image:url + '/images/dropcap.png' });


        },
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        /*
         createControl:function (n, cm) {
         return null;
         },
         */
        createControl:function () {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo:function () {
            return {
                longname:'Plazart TinyMCE Shortcode',
                author:'Plazart',
                authorurl:'http://templaza.com',
                infourl:'http://templaza.com',
                version:tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('divider', tinymce.plugins.plazart.shortcode);
})();

/*===================================
 * button
 ====================================*/
function create_button(){
    if(jQuery('#create_button').length){
        jQuery('#create_button').remove();
    }
// creates a form to be displayed everytime the button is clicked
// you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="create_button" class="create_button">\
                        <div>\
                        </div>\
                        <div id="button-us">\
                        <table id="button-table" class="form-table">\
                        <tr>\
                            <th><label for="client-label-content">Size button</label></th>\
                             <td><select class="size">\
                             <option value="default">default</option>\
                             <option value="small">Small</option>\
                             <option value="large">Large</option>\
                             <option value="huge">Huge</option>\
                             </select></td>\
                        </tr>\
                        <tr>\
                            <th><label for="client-label-content">Color button</label></th>\
                             <td><select class="color">\
                                    <option value="green">green</option>\
                                     <option value="orange">orange</option>\
                                     <option value="darklight">darklight</option>\
                                     <option value="yellow">yellow</option>\
                                     <option value="red">red</option>\
                                     <option value="gray">gray</option>\
                             </select></td>\
                        </tr>\
                        <tr>\
                            <th><label for="client-label-content">Embossed button</label></th>\
                             <td><select class="embossed">\
                             <option value="embossed">Show</option>\
                             <option value="no">None</option>\
                             </select></td>\
                            </td>\
                        </tr>\
                         <tr>\
                            <th><label for="button-label-content">\
                            <a href="http://fontawesome.io/icons/" target="_blank">Click here fontawesome</a>\
                            <span class="alt_label">\
                            Profiler Theme supports Awesome font, you click on link to go to Awsome font site and choose suitable class. After that you can fill in textbox Ex: fa-twitter\
                            </span></th>\
                            <td><input type="text" id="icon_button" class="" value="" placeholder="fa-twitter" name="icon_button" /></td>\
                        </tr>\
                        <tr>\
                            <th><label for="button-label-content">Button Link</label></th>\
                             <td><input type="text" id="text_link" class="" value="" placeholder="Button link" name="text_link" /></td>\
                        </tr>\
                        <tr>\
                            <th><label for="button-label-content">Button Name</label></th>\
                             <td><input type="text" id="text_name" class="" value="" placeholder="Button Name" name="text_name" /></td>\
                        </tr>\
                    </table>\
                    </div>\
                    <p class="submit">\
			<input type="button" id="button-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();
    jQuery('#button-submit').click(function(){
        var $preview    = '';
        var $size       = jQuery('.size').val();
        var $color      = jQuery('.color').val();
        var $embossed   = jQuery('.embossed').val();
        var $text_link  = jQuery('#text_link').val();
        var $text_name  = jQuery('#text_name').val();
        var $icon       = jQuery('#icon_button').val();
        $preview        = '[button_p size="'+$size+'" color="'+$color+'" embossed="'+$embossed+'" link="'+$text_link+'" icon="'+ $icon +'"]'+$text_name+'[/button_p]';
        tinyMCE.activeEditor.execCommand('mceInsertcontent',0,$preview);
        jQuery.fancybox.close();
    });
}
/*===================================
 * Pricing
 ====================================*/
function create_pricing(){
    if(jQuery('#create_pricing').length){
        jQuery('#create_pricing').remove();
    }
// creates a form to be displayed everytime the button is clicked
// you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="create_pricing" class="create_pricing">\
                        <div>\
                        </div>\
                        <div id="button-us">\
                        <table id="button-table" class="form-table">\
                        <tr>\
                            <th><label for="client-label-content">Style</label></th>\
                             <td><select class="style">\
                             <option value="1">1</option>\
                             <option value="0">0</option>\
                             </select></td>\
                        </tr>\
                        <tr>\
                            <th><label for="client-label-content">Title</label></th>\
                             <td><input type="text" id="pricing_title" class="" value="" placeholder="" name="pricing_title" /></td>\
                        </tr>\
                        <tr>\
                            <th><label for="client-label-content">Cost</label></th>\
                             <td><input type="text" id="pricing_cost" class="" value="" placeholder="" name="pricing_cost" /></td>\
                        </tr>\
                        </table>\
                        <div id="pricing_content">\
                        <div class="pricing_item">\
                        <table class="form-table">\
                        <tr>\
                            <th><label for="button-label-content">pricing content</label></th>\
                             <td><input type="text" class="text_content" value="" placeholder="" name="text_content" /></td>\
                        </tr>\
                        </table><a class="pricing-remove no-remove"></a>\
                        </div>\
                        </div>\
                    </div><p><input type="button" id="add_pring" class="button-primary" value="Add item" name="add_pring" /></p>\
                    <p class="submit">\
			<input type="button" id="pring-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();
    jQuery('#add_pring').click(function (){
        var $pre = jQuery('.pricing_item').first().clone();
        $pre.find('input').val(' ');
        jQuery('#pricing_content').append($pre);

        $pre.find('.pricing-remove').addClass('not-remove').removeClass('no-remove');
        jQuery('.not-remove').click(function() {
            jQuery(this).parent().remove();
        })
    });
    jQuery('#pring-submit').click(function(){
        var $preview ='';
        jQuery('.text_content').each(function(){
            var $content = jQuery(this).val();
            $preview += '<br>'+'[pricing_item]'+$content+'[/pricing_item]' ;
        }) ;
        var $title = jQuery('#pricing_title').val();
        var $cost = jQuery('#pricing_cost').val();
        var $style = jQuery('.style').val();
        var  $preview_sh        = '[pricing style="'+$style+'" title="'+$title+'" cost="'+$cost+'"]'+$preview+'<br>'+'[/pricing]';
        tinyMCE.activeEditor.execCommand('mceInsertcontent',0,$preview_sh);
        jQuery.fancybox.close();
    });
}
// create_skill
function create_skill() {
    if ( jQuery('#create_skill').length ){
        jQuery('#create_skill').remove();
    }
    form = jQuery('<div id="create_skill">\
                        <div id="tzskill">\
                            <div class="skill-item">\
                                <table class="form-table">\
                                    <tr>\
                                        <th><label>Background time</label></th>\
                                        <td>\
                                        <select Class="skill-background">\
                                             <option value="default">default</option>\
                                             <option value="red">red</option>\
                                             <option value="green">green</option>\
                                             <option value="yellow">yellow</option>\
                                             <option value="gray">gray</option>\
                                        </select>\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <th><label>progress</label></th>\
                                        <td>\
                                        <select Class="skill-progress">\
                                             <option value="100">100%</option>\
                                             <option value="90">90%</option>\
                                             <option value="80">80%</option>\
                                             <option value="70">70%</option>\
                                             <option value="60">60%</option>\
                                             <option value="50">50%</option>\
                                             <option value="40">40%</option>\
                                             <option value="30">30%</option>\
                                             <option value="20">20%</option>\
                                             <option value="10">10%</option>\
                                        </select>\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <th><label>Title</label></th>\
                                        <td><input type="text" class="skill-title skill-input" size="36" name="skill-time" value=""></td>\
                                    </tr>\
                                </table>\
                            </div>\
                        </div>\
                        <input type="button" id="skill-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
                    </div>');

    form.appendTo('body').hide();

    jQuery('#skill-submit').click(function(){
        var $preview              =  '';
        var $title                =  jQuery('.skill-title').val();
        var $progress             =  jQuery('.skill-progress').val();
        var $background           =  jQuery('.skill-background').val();
        $preview       = '[skill title="' + $title + '" progress="' + $progress + '" background="' + $background + '"]' ;
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, $preview);
        jQuery.fancybox.close();

    });
}
// create_working
function create_working(){

    if ( jQuery('#create_working').length ){
        jQuery('#create_working').remove();
    }
    form = jQuery('<div id="create_working">\
                        <div id="tzworking">\
                            <div class="working-item">\
                                <table class="form-table">\
                                    <tr>\
                                        <th><label>Background time</label></th>\
                                        <td>\
                                        <select Class="wodrk-background">\
                                             <option value="green">green</option>\
                                             <option value="orange">orange</option>\
                                             <option value="darklight">darklight</option>\
                                             <option value="yellow">yellow</option>\
                                             <option value="cyan">cyan</option>\
                                             <option value="red">red</option>\
                                             <option value="gray">gray</option>\
                                        </select>\
                                        </td>\
                                    </tr>\
                                    <tr>\
                                        <th><label>Time</label></th>\
                                        <td><input type="text" class="work-time work-input" size="36" name="work-time" value=""></td>\
                                    </tr>\
                                    <tr>\
                                        <th><label>Title</label></th>\
                                        <td><input type="text" class="work-title work-input" size="36" name="work-title" value=""></td>\
                                    </tr>\
                                    <tr>\
                                        <th><label>Excerpt</label></th>\
                                        <td><input type="text" class="work-excerpt work-input" size="36" name="work-excerpt" value=""></td>\
                                    </tr>\
                                </table>\
                            </div>\
                        </div>\
                        <input type="button" id="excerpt-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
                    </div>');

    form.appendTo('body').hide();

    jQuery('#excerpt-submit').click(function(){
       var $preview   = '';
       var $time      = jQuery('.work-time').val();
       var $title     = jQuery('.work-title').val();
       var $excerpt   = jQuery('.work-excerpt').val();
       var $backg     = jQuery('.wodrk-background').val();
       $preview       = '[working title="' + $title + '" time="' + $time + '" excerpt="' + $excerpt + '" background_time="' +$backg+ '"]' ;
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, $preview);
       jQuery.fancybox.close();

    });

}


/* =================================
 * Awards
 ===================================*/
function create_Awards(){
    if(jQuery('#create_Awards').length){
        jQuery('#create_Awards').remove();
    }
    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="create_Awards" class="awards-container">\
                        <div id="awards-us">\
                        <div class="awards-item">\
                        <a class="service-remove no-remove"></a>\
                        <table id="awards-table" class="form-table">\
                            <th><label for="awards-label-content">Upload Image:</label></th>\
                             <td><input id="upload_image" class="awards_data_image awards-item-input" type="text" size="36" name="upload_image" value="" /><button class="upload_awards button" rel="11" type="button">Upload Image</button></td>\
                             <td></td>\
                            </td>\
                        </tr>\
                        <tr>\
                            <th><label for="awards-class">content:</label></th>\
                            <td><textarea rows="5" class="awards_textarea" placeholder="content"></textarea><br />\
                            </td>\
                        </tr>\
                    </table>\
                    </div></div>\
                    <p>\
                    <input type="button" id="add_item_awards" class="button-primary" value="Add item" name="submit" />\
                    </p>\
                    <p class="submit">\
			<input type="button" id="awards-image-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();
    // service item
    var $countitem = jQuery('.upload_awards').length;
    if($countitem==1){
        jQuery('.upload_awards').on("click",function() {
            jQuery('.fancybox-overlay').css('z-index',100);
            tb_show('', 'media-upload.php?type=image&TB_iframe=1');
            window.send_to_editor = function(html) {
                imgurl = jQuery('img',html).attr('src');
                jQuery('#upload_image').val(imgurl);
                tb_remove();
            }

        });
    }
    jQuery('#add_item_awards').bind("click",function() {

        var item_clone = jQuery('.awards-item').first().clone();
        var $random = 1 + Math.floor(Math.random() * 600000000);
        item_clone.find('input').val('');
        item_clone.find('.service-remove').addClass('remove_awards_item').removeClass('no-remove');
        item_clone.find('.awards_data_image').attr('id',$random);
        jQuery('#awards-us').append(item_clone);
        jQuery('.upload_awards').on("click",function() {
            jQuery('.fancybox-overlay').css('z-index',100);
            var field_id = jQuery(this).parent().parent().parent().find('.awards_data_image').attr('id');
            tb_show('', 'media-upload.php?type=image&TB_iframe=1');
            window.send_to_editor = function(html) {
                imgurl = jQuery('img',html).attr('src');
                jQuery('#' + field_id).val(imgurl);
                tb_remove();
            }

        });
        jQuery('.remove_awards_item').click(function(){
            jQuery(this).parent().remove();
        });
    });
    jQuery('#awards-image-submit').click(function () {
        var $preview_code = '';
        jQuery('#awards-us .awards-item').each(function() {
            var $image   = jQuery(this).find('.awards_data_image').val();
            var  $awards_content = jQuery(this).find('.awards_textarea').val();

            $preview_code +='[awards_item image="' + $image + '"]' + $awards_content + '[/awards_item]';
        });
        var shortcode = '[awards]'+$preview_code + '[/awards]';
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
        jQuery.fancybox.close();

    });
    // closes fancybox
    jQuery.fancybox.close();

}
/* =================================
 * Service
 ===================================*/
function create_service(){
    if(jQuery('#create_service').length){
        jQuery('#create_service').remove();
    }
    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="create_service" class="service-container">\
                        <div id="service-us">\
                        <div class="service-item">\
                        <a class="service-remove no-remove"></a>\
                        <table id="service-table" class="form-table">\
                            <th><label for="service-label-content">Upload Image:</label></th>\
                             <td><input id="upload_image" class="service_data_image service-item-input" type="text" size="36" name="upload_image" value="" /><button class="upload_service button" rel="11" type="button">Upload Image</button></td>\
                             <td></td>\
                            </td>\
                        </tr>\
                        <tr>\
                        <th><label for="service-shape">title:</label></th>\
                        <td><input class="service-item-input service_title" type="text" size="36" placeholder="title for service" value="" />\
                        </td>\
			            </tr>\
                        <tr>\
                            <th><label for="service-class">content:</label></th>\
                            <td><textarea rows="5" class="service_textarea" placeholder="content"></textarea><br />\
                            </td>\
                        </tr>\
                    </table>\
                    </div></div>\
                    <p>\
                    <input type="button" id="add_item_service" class="button-primary" value="Add item" name="submit" />\
                    </p>\
                    <p class="submit">\
			<input type="button" id="service-image-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();
    // service item
    var $countitem = jQuery('.upload_service').length;
    if($countitem==1){
        jQuery('.upload_service').on("click",function() {
            jQuery('.fancybox-overlay').css('z-index',100);
            tb_show('', 'media-upload.php?type=image&TB_iframe=1');
            window.send_to_editor = function(html) {
                imgurl = jQuery('img',html).attr('src');
                jQuery('#upload_image').val(imgurl);
                tb_remove();
            }

        });
    }
    jQuery('#add_item_service').bind("click",function() {

        var item_clone = jQuery('.service-item').first().clone();
        var $random = 1 + Math.floor(Math.random() * 600000000);
        item_clone.find('input').val('');
        item_clone.find('.service-remove').addClass('remove_service_item').removeClass('no-remove');
        item_clone.find('.service_data_image').attr('id',$random);
        jQuery('#service-us').append(item_clone);
        jQuery('.upload_service').on("click",function() {
            jQuery('.fancybox-overlay').css('z-index',100);
            var field_id = jQuery(this).parent().parent().parent().find('.service_data_image').attr('id');
            tb_show('', 'media-upload.php?type=image&TB_iframe=1');
            window.send_to_editor = function(html) {
                imgurl = jQuery('img',html).attr('src');
                jQuery('#' + field_id).val(imgurl);
                tb_remove();
            }

        });
        jQuery('.remove_service_item').click(function(){
            jQuery(this).parent().remove();
        });
    });
    jQuery('#service-image-submit').click(function () {
        var $preview_code = '';
        jQuery('#service-us .service-item').each(function() {
            var $image   = jQuery(this).find('.service_data_image').val();
            var $service_title = jQuery(this).find('.service_title').val();
            var  $service_content = jQuery(this).find('.service_textarea').val();

            $preview_code +='[service_item image="' + $image + '" title=" ' + $service_title + ' "]' + $service_content + '[/service_item]';
        });
        var shortcode = '[services]'+$preview_code + '[/services]';
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
        jQuery.fancybox.close();

    });
    // closes fancybox
    jQuery.fancybox.close();

}

/* =================================
 * create_download
 ===================================*/
function create_download(){
    if(jQuery('#create_download').length){
        jQuery('#create_download').remove();
    }
    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this
    var form = jQuery('<div id="create_download" class="download-container">\
                        <div id="download-us">\
                        <div class="download-item">\
                        <a class="download-remove no-remove"></a>\
                        <table id="download-table" class="form-table">\
                        <tr>\
                        <th><label for="download-shape">title:</label></th>\
                        <td><input class="download-item-input download_title" type="text" size="36" placeholder="title for download" value="" />\
                        </td>\
			            </tr>\
                        <tr>\
                            <th><label for="download-class">content:</label></th>\
                            <td><textarea rows="5" class="download_content" placeholder="content"></textarea><br />\
                            </td>\
                        </tr>\
                        <tr>\
                            <th><label for="button-label-content">Button Link</label></th>\
                             <td><input type="text" id="text_link" class="button_link" value="" placeholder="Button link" name="text_link" /></td>\
                        </tr>\
                        <tr>\
                            <th><label for="button-label-content">Button Name</label></th>\
                             <td><input type="text" id="text_name" class="button_name" value="" placeholder="Button Name" name="text_name" /></td>\
                        </tr>\
                    </table>\
                    </div></div>\
                    <p class="submit">\
			<input type="button" id="download-image-submit" class="button-primary" value="Insert Shortcode" name="submit" />\
		</p>\
		</div>');

    var table = form.find('table');
    form.appendTo('body').hide();
    // service item
    jQuery('#download-image-submit').click(function () {
        var $preview_code = '';
            var $title     = jQuery('.download_title').val();
            var $content   = jQuery('.download_content').val();
            var $name      = jQuery('.button_name').val();
            var $link      = jQuery('.button_link').val();
        var shortcode = '[download title="'+$title+'" button_name="'+$name+'" button_link="'+$link+'"]'+ $content + '[/download]';
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
        jQuery.fancybox.close();

    });
    // closes fancybox
    jQuery.fancybox.close();

}


