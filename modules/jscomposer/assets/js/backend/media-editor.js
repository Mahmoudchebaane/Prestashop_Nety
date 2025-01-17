/* =========================================================
 * media-editor.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * WP 3.5 Media manager integration into Visual Composer.
 * ========================================================= */
(function ($) {
    var media = wp.media || {},
//        Attachment = media.model.Attachment,
//        Attachments = media.model.Attachments,
//        Query = media.model.Query,
        l10n = i18nLocale,
        workflows = {};
    // wp.media.controller.VcSingleImage extends featuredImage controller
    // ---------------------------------
//    media.controller.VcSingleImage = {
//        defaults:{
//            id:'vc_single-image',
//            filterable:'uploaded',
//            multiple:false,
//            toolbar:'vc_single-image',
//            title:l10n.set_image,
//            priority:60,
//            syncSelection:false
//        },
//        updateSelection:function () {
//            var selection = this.get('selection'),
//                id = media.VcSingleImage.getData(),
//                attachment;
//            if ('' !== id && -1 !== id) {
//                attachment = Attachment.get(id);
//                attachment.fetch();
//            }
//            selection.reset(attachment ? [ attachment ] : []);
//        }
//    };
//    media.controller.VcGallery = media.controller.VcSingleImage.extend({
//        defaults:_.defaults({
//            id:'vc_gallery',
//            title:l10n.add_images,
//            toolbar:'main-insert',
//            filterable:'uploaded',
//            library:media.query({type:'image'}),
//            multiple:'add',
//            editable:true,
//            priority:60,
//            syncSelection:false
//        }, media.controller.VcSingleImage.defaults),
//        updateSelection:function () {
//            var selection = this.get('selection'),
//                ids = media.vc_editor.getData(),
//                attachments;
//            if ('' !== ids && -1 !== ids) {
//                attachments = _.map(ids.split(/,/), function (id) {
//                    return Attachment.get(id);
//                });
//            }
//            selection.reset(attachments);
//        }
//    });

    media.VcSingleImage = {
        getData:function () {
            return this.$hidden_ids.val();
        },
        set:function (selection) {

            this.$img_ul.html(_.template($('#vc_settings-image-block').html(), selection.attributes));

            this.$clear_button.show();

            this.$hidden_ids.val(selection.get('id')).trigger('change');
            return false;
        },
        frame:function (element) {
            this.element = element;

            this.$button = $(this.element);
            this.$block = this.$button.closest('.edit_form_line');
            this.$hidden_ids = this.$block.find('.gallery_widget_attached_images_ids');
            this.$img_ul = this.$block.find('.gallery_widget_attached_images_list');
            this.$clear_button = this.$img_ul.next();

            // TODO: Refactor this all params as template
            
            if (this._frame)
                return this._frame;
            this._frame = wp.media({
                state:'vc_single-image',
                states:[ new wp.media.controller.VcSingleImage() ]
            });
            this._frame.on('toolbar:create:vc_single-image', function (toolbar) {
                this.createSelectToolbar(toolbar, {
                    text:l10n.set_image
                });
            }, this._frame);

            this._frame.state('vc_single-image').on('select', this.select);
            return this._frame;
        },
        select:function () {
            var selection = this.get('selection').single();
            wp.media.VcSingleImage.set(selection ? selection : -1);
        }
    };

//    media.view.MediaFrame.VcGallery = media.view.MediaFrame.Post.extend({
//        // Define insert-vc state.
//        createStates:function () {
//            var options = this.options;
//
//            // Add the default states.
//            this.states.add([
//                // Main states.
//                new media.controller.VcGallery()
//            ]);
//        },
//        // Removing let menu from manager
//        bindHandlers:function () {
//            media.view.MediaFrame.Select.prototype.bindHandlers.apply(this, arguments);
//            this.on('toolbar:create:main-insert', this.createToolbar, this);
//
//            var handlers = {
//                content:{
//                    'embed':'embedContent',
//                    'edit-selection':'editSelectionContent'
//                },
//                toolbar:{
//                    'main-insert':'mainInsertToolbar'
//                }
//            };
//
//            _.each(handlers, function (regionHandlers, region) {
//                _.each(regionHandlers, function (callback, handler) {
//                    this.on(region + ':render:' + handler, this[ callback ], this);
//                }, this);
//            }, this);
//        },
//        // Changing main button title
//        mainInsertToolbar:function (view) {
//            var controller = this;
//
//            this.selectionStatusToolbar(view);
//
//            view.set('insert', {
//                style:'primary',
//                priority:80,
//                text:l10n.add_images,
//                requires:{ selection:true },
//
//                click:function () {
//                    var state = controller.state(),
//                        selection = state.get('selection');
//
//                    controller.close();
//                    state.trigger('insert', selection).reset();
//                }
//            });
//        }
//    });
//    media.vc_editor = _.clone(media.editor);
    media.vc_editor = _.extend(
//            media.vc_editor, 
    {
        $vc_editor_element:null,
        getData:function () {
            var $button = wp.media.vc_editor.$vc_editor_element,
                $block = $button.closest('.edit_form_line'),
                $hidden_ids = $block.find('.gallery_widget_attached_images_ids');
            return $hidden_ids.val();
        },
        insert:function (images) {
            var $button = wp.media.vc_editor.$vc_editor_element,
                $block = $button.closest('.edit_form_line'),
                $hidden_ids = $block.find('.gallery_widget_attached_images_ids'),
                $img_ul = $block.find('.gallery_widget_attached_images_list'),
                $clear_button = $img_ul.next(),
                $thumbnails_string = '';

            _.each(images, function (image) {
                $thumbnails_string += _.template($('#vc_settings-image-block').html(), image);
            });
            $hidden_ids.val(_.map(images,function (image) {
                return image.id;
            }).join(',')).trigger('change');
            $img_ul.html($thumbnails_string);
        },
        open:function (id) {
            var workflow, editor;

            id = this.id(id);

            workflow = this.get(id);

            // Initialize the editor's workflow if we haven't yet.
            if (!workflow)
                workflow = this.add(id);

            return workflow.open();
        },
        add:function (id, options) {
            var workflow = this.get(id);
            if (workflow)
                return workflow;

            workflow = workflows[ id ] = new media.view.MediaFrame.VcGallery(_.defaults(options || {}, {
                state:'vc_gallery',
                title:l10n.add_images,
                library:{ type:'image' },
                multiple:true
            }));
            workflow.on('insert', function (selection) {
                var state = workflow.state(),
                    data = [];

                selection = selection || state.get('selection');
                if (!selection)
                    return;

                this.insert(_.map(selection.models, function (model) {
                    return model.attributes;
                }));
            }, this);
            return workflow;
        },
        loadSingle: function(gallery_input_field, gallery_sortable, iframe_img){
            gallery_input_field.val(iframe_img[0]);
            gallery_sortable.html('<li class="added"><img rel="'+iframe_img[0]+'" src="'+iframe_img[1]+'"><a href="#" class="icon-remove"></a></li>');
        },
        loadBackgroundImage: function(gallery_input_field, background_markap, iframe_img){   
            background_markap = background_markap.selector;
            
            if(background_markap == null || background_markap == ""){
                background_markap = ".vc_background-image > ul.vc_image";
               }
            $(background_markap).html('<li class="added"><div class="inner" style="width: 75px; height: 75px; overflow: hidden;text-align: center;">    <img src="'+iframe_img[1]+'" data-image-id="'+iframe_img[0]+'" class="vc_ce-image"> <a href="#" class="icon-remove"></a> </div></li>');
           
        },
        init:function () {
            var Class = this;
    
            $('body').off('click.vcGalleryWidget').on('click.vcGalleryWidget', '.gallery_widget_add_images', function (event) {
                var $this = $(this),
                    editor = 'visual-composer',
                    title = 'VC Media', 
                    gallery_input_field = $this.parent().children('input.gallery_widget_attached_images_ids'),
                    gallery_sortable = $this.parent().find('.gallery_widget_attached_images > ul.gallery_widget_attached_images_list.ui-sortable');
                    
                    var background_markap = $this.parent().find('.vc_background-image > ul.vc_image'); 
                    var backImage = $this.attr('use-back');
                    
                    var single = $this.attr('use-single');
                    
                    var params = "&view=dialog&TB_iframe=true&height=450&width=960";
		//params = encodeURI(params);
                    var url = vc_mediaAjaxUrl+params;
                    
                    tb_show(title,url);

                    window.getVCMedia = function(iframe_img) {
                        if(iframe_img[0] !== undefined){ 
                             
                            if(single === 'true' && backImage === 'true'){
                                
                                Class.loadBackgroundImage(gallery_input_field, background_markap, iframe_img); 
                            }else if(single === 'true'){ 
                               Class.loadSingle(gallery_input_field, gallery_sortable, iframe_img);
                            }else{
                                var existVal = gallery_input_field.val();
                                if(existVal !== ''){
                                    var images = existVal.split(',');
                                   
                                    if(_.indexOf(images,iframe_img[0]) === -1){
                                        images[images.length] = iframe_img[0];
                                        gallery_input_field.val(images.join(','));
                                        gallery_sortable.append('<li class="added"><img rel="'+iframe_img[0]+'" src="'+iframe_img[1]+'"><a href="#" class="icon-remove"></a></li>');
                                    }
                                }else{
                                    Class.loadSingle(gallery_input_field, gallery_sortable, iframe_img);
                                }
                            }
                            
                        } 
                        tb_remove();
                    };
                    
                    
//                wp.media.vc_editor.$vc_editor_element = $(this);
//                if ($this.attr('use-single') === 'true') {
//                    wp.media.VcSingleImage.frame(this).open('vc_editor');
//                    return;
//                }
//                event.preventDefault();
//                $this.blur();
//                wp.media.vc_editor.open(editor);
            });
        }
    });
    _.bindAll(media.vc_editor, 'open');
    $(document).ready(function () {
        media.vc_editor.init();
    });
}(jQuery));