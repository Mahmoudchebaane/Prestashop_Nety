<?php

if (!class_exists('Ultimate_Icon_Timeline')) {

    class Ultimate_Icon_Timeline {

        public $vcaddonsinstance, $context;

        function __construct() {

            $this->vcaddonsinstance = jscomposer::getInstance();
            $this->context = Context::getContext();
//		 	add_action('admin_init', array($this, 'add_icon_timeline'));
            JsComposer::add_shortcode('icon_timeline', array($this, 'icon_timeline'));
            JsComposer::add_shortcode('icon_timeline_item', array(&$this, 'icon_timeline_item'));
            JsComposer::add_shortcode('icon_timeline_sep', array(&$this, 'icon_timeline_sep'));
            JsComposer::add_shortcode('icon_timeline_feat', array(&$this, 'icon_timeline_feat'));

        }

        function icon_timeline_scripts() {
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/masonry.min.js");
            $this->context->controller->addJS("{$this->vcaddonsinstance->_url_ultimate}assets/min-js/custom.min.js");
        }

        function icon_timeline_styles() {
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/animate.min.css"); 
            $this->context->controller->addCSS("{$this->vcaddonsinstance->_url_ultimate}assets/min-css/timeline.min.css");
        }

        function add_icon_timeline() {
            $vc = vc_manager();
            if (function_exists('vc_map')) {
                vc_map(
                        array(
                            "name" => $vc->l("Timeline"),
                            "base" => "icon_timeline",
                            "class" => "vc_timeline",
                            "icon" => "vc_timeline_icon",
                            "category" => $vc->l("Ultimate VC Addons"),
                            "description" => $vc->l("Timeline of old memories and events."),
                            "as_parent" => array('only' => 'icon_timeline_item,icon_timeline_sep,icon_timeline_feat',),
                            "content_element" => true,
                            "show_settings_on_create" => false,
                            "params" => array(
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Height"),
                                    "param_name" => "timeline_style",
                                    "value" => array(
                                        'Non-optimized (CSS)' => 'csstime',
                                        'Optimized with JavaScript' => 'jstime',
                                    ),
                                    "description" => $vc->l("How would you like the height of timeline.")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Connecter Line Style"),
                                    "param_name" => "timeline_line_style",
                                    "value" => array(
                                        'Dotted' => 'dotted',
                                        'Solid ' => 'solid',
                                        'Dashed ' => 'dashed',
                                    ),
                                    "description" => $vc->l("Select the style of  line that connects timeline items.")
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Color of Connecter Line:"),
                                    "param_name" => "timeline_line_color",
                                    "value" => "",
                                    "description" => $vc->l("Select the color for the line that connects timeline items."),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background color for timeline item block / container:"),
                                    "param_name" => "time_block_bg_color",
                                    "value" => "",
                                    "description" => $vc->l(" Give a background color to the timeline item block."),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Select font color of items separator:"),
                                    "param_name" => "time_sep_color",
                                    "value" => "",
                                    "description" => $vc->l("Select font color of items separator."),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Select background color for items separator:"),
                                    "param_name" => "time_sep_bg_color",
                                    "value" => "",
                                    "description" => $vc->l("Select the background color for item separator."),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Timeline Layout:"),
                                    "param_name" => "timeline_layout",
                                    "value" => array(
                                        "Full Width " => "",
                                        "Custom Width " => "timeline-custom-width",
                                    ),
                                    "description" => $vc->l("Select Layout of Timeline."),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Custom Width"),
                                    "param_name" => "custom_width",
                                    "value" => 200,
                                    "suffix" => "px",
                                    "description" => $vc->l("Provide custom width for each block"),
                                    "dependency" => Array("element" => "timeline_layout", "value" => array("timeline-custom-width")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Hover animation:"),
                                    "param_name" => "tl_animation",
                                    "value" => array(
                                        "None" => "",
                                        "Slide Out" => "tl-animation-slide-out",
                                        "Slide Up" => "tl-animation-slide-up",
                                        "Slide Down" => "tl-animation-slide-down",
                                        "Shadow" => "tl-animation-shadow",
                                    ),
                                    "description" => $vc->l("Hover animation can be given to the timeline item blocks."),
                                ),
                                array(
                                    "type" => "heading",
                                    "param_name" => "notification",
                                    'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
                                ),
                            ),
                            "js_view" => 'VcColumnView'
                ));
                // Add list item
                vc_map(
                        array(
                            "name" => $vc->l("Items Separator"),
                            "base" => "icon_timeline_sep",
                            "class" => "vc_timeline_sep",
                            "icon" => "vc_timeline_sep_icon",
                            "category" => $vc->l('Timeline'),
                            "content_element" => true,
                            "as_child" => array('only' => 'icon_timeline'),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("separator Text"),
                                    "param_name" => "time_sep_title",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Provide the text for this timeline Separator."),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "time_sep_color",
                                    "heading" => $vc->l("Color")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Border Style"),
                                    "param_name" => "line_style",
                                    "value" => array(
                                        "None" => "",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "line_color",
                                    "heading" => $vc->l("Border color"),
                                    "dependency" => Array("element" => "line_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "line_width",
                                    "heading" => "Border width",
                                    "value" => "1",
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "line_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "line_radius",
                                    "heading" => "Border radius",
                                    "value" => "5",
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "line_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "param_name" => "seperator_title_font",
                                    "heading" => "Font Family",
                                    "value" => "",
                                    "dependency" => Array("element" => "time_sep_title", "not_empty" => true),
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "seperator_title_font_style",
                                    "value" => "",
                                    "dependency" => Array("element" => "time_sep_title", "not_empty" => true),
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "heading" => "Font size",
                                    "param_name" => "font_size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "time_sep_title", "not_empty" => true),
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                ),
                            )
                        )
                );
                vc_map(
                        array(
                            "name" => $vc->l("Timeline Item"),
                            "base" => "icon_timeline_item",
                            "class" => "vc_timeline_item",
                            "icon" => "vc_timeline_item_icon",
                            "category" => $vc->l('Timeline'),
                            "content_element" => true,
                            "as_child" => array('only' => 'icon_timeline'),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Title"),
                                    "param_name" => "time_title",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Provide the title for this timeline item."),
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "title_text_typography",
                                    "heading" => $vc->l("Title settings"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "title_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "title_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "title_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "title_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "textarea_html",
                                    "class" => "",
                                    "heading" => $vc->l("Description"),
                                    "param_name" => "content",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Provide some description."),
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "desc_text_typography",
                                    "heading" => $vc->l("<h2>Description settings</h2>"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "desc_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "desc_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "desc_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "desc_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon to display:"),
                                    "param_name" => "icon_type",
                                    "value" => array(
                                        "No Icon" => 'noicon',
                                        "Font Icon Manager" => "selector",
                                        "Custom Image Icon" => "custom",
                                    ),
                                    "description" => $vc->l("Use an existing font icon</a> or upload a custom image.")
                                ),
                                array(
                                    "type" => "icon_manager",
                                    "class" => "",
                                    "heading" => $vc->l("Select Icon "),
                                    "param_name" => "icon",
                                    "value" => "",
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "attach_image",
                                    "class" => "",
                                    "heading" => $vc->l("Upload Image Icon:"),
                                    "param_name" => "icon_img",
                                    "value" => "",
                                    "description" => $vc->l("Upload the custom image icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Image Width"),
                                    "param_name" => "img_width",
                                    "value" => 48,
                                    "min" => 16,
                                    "max" => 512,
                                    "suffix" => "px",
                                    "description" => $vc->l("Provide image width"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Size of Icon"),
                                    "param_name" => "icon_size",
                                    "value" => 32,
                                    "min" => 12,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("How big would you like it?"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Color"),
                                    "param_name" => "icon_color",
                                    "value" => "#DE5034",
                                    "description" => $vc->l("Give it a nice paint!"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Style"),
                                    "param_name" => "icon_style",
                                    "value" => array(
                                        "Circle Background" => "circle",
                                        "Square Background" => "square",
                                        "Design your own" => "advanced",
                                    ),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background Color"),
                                    "param_name" => "icon_color_bg",
                                    "value" => "#fff",
                                    "description" => $vc->l("Select background color for icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Border Style"),
                                    "param_name" => "icon_border_style",
                                    "value" => array(
                                        "None" => "",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "description" => $vc->l("Select the border style for icon."),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color"),
                                    "param_name" => "icon_color_border",
                                    "value" => "#dbdbdb",
                                    "description" => $vc->l("Select border color for icon."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Width"),
                                    "param_name" => "icon_border_size",
                                    "value" => 1,
                                    "min" => 1,
                                    "max" => 10,
                                    "suffix" => "px",
                                    "description" => $vc->l("Thickness of the border."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Radius"),
                                    "param_name" => "icon_border_radius",
                                    "value" => 500,
                                    "min" => 1,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Background Size"),
                                    "param_name" => "icon_border_spacing",
                                    "value" => 50,
                                    "min" => 30,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Animation"),
                                    "param_name" => "icon_animation",
                                    "value" => array(
                                        $vc->l("No Animation") => "",
                                        $vc->l("Swing") => "swing",
                                        $vc->l("Pulse") => "pulse",
                                        $vc->l("Fade In") => "fadeIn",
                                        $vc->l("Fade In Up") => "fadeInUp",
                                        $vc->l("Fade In Down") => "fadeInDown",
                                        $vc->l("Fade In Left") => "fadeInLeft",
                                        $vc->l("Fade In Right") => "fadeInRight",
                                        $vc->l("Fade In Up Long") => "fadeInUpBig",
                                        $vc->l("Fade In Down Long") => "fadeInDownBig",
                                        $vc->l("Fade In Left Long") => "fadeInLeftBig",
                                        $vc->l("Fade In Right Long") => "fadeInRightBig",
                                        $vc->l("Slide In Down") => "slideInDown",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Bounce In") => "bounceIn",
                                        $vc->l("Bounce In Up") => "bounceInUp",
                                        $vc->l("Bounce In Down") => "bounceInDown",
                                        $vc->l("Bounce In Left") => "bounceInLeft",
                                        $vc->l("Bounce In Right") => "bounceInRight",
                                        $vc->l("Rotate In") => "rotateIn",
                                        $vc->l("Light Speed In") => "lightSpeedIn",
                                        $vc->l("Roll In") => "rollIn",
                                    ),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                    "description" => $vc->l("Like CSS3 Animations? We have several options for you!")
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Apply link to:"),
                                    "param_name" => "time_link_apply",
                                    "value" => array(
                                        "None" => "",
                                        "Complete box" => "box",
                                        "Box Title" => "title",
                                        "Display Read More" => "more",
                                    ),
                                    "description" => $vc->l("Select the element for link.", "icon-box")
                                ),
                                array(
                                    "type" => "vc_link",
                                    "class" => "",
                                    "heading" => $vc->l("Add Link"),
                                    "param_name" => "time_link",
                                    "value" => "",
                                    "dependency" => Array("element" => "time_link_apply", "value" => array("more", "title", "box")),
                                    "description" => $vc->l("Provide the link that will be applied to this timeline.")
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Read More Text"),
                                    "param_name" => "time_read_text",
                                    "value" => "Read More",
                                    "description" => $vc->l("Customize the read more text."),
                                    "dependency" => Array("element" => "time_link_apply", "value" => array("more")),
                                ),
                                // Customize everything
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Add extra class name that will be applied to the timeline, and you can use this class for your customizations."),
                                ),
                            )
                        )
                );
                vc_map(
                        array(
                            "name" => $vc->l("Timeline Featured Item"),
                            "base" => "icon_timeline_feat",
                            "class" => "vc_timeline_feat",
                            "icon" => "vc_timeline_feat_icon",
                            "category" => $vc->l('Timeline'),
                            "content_element" => true,
                            "as_child" => array('only' => 'icon_timeline'),
                            "params" => array(
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Title"),
                                    "param_name" => "time_title",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Provide the title for this timeline item."),
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "title_text_typography",
                                    "heading" => $vc->l("<h2>Title settings</h2>"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "title_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "title_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "title_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "title_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "textarea_html",
                                    "class" => "",
                                    "heading" => $vc->l("Description"),
                                    "param_name" => "content",
                                    "admin_label" => true,
                                    "value" => "",
                                    "description" => $vc->l("Provide some description."),
                                ),
                                array(
                                    "type" => "text",
                                    "param_name" => "desc_text_typography",
                                    "heading" => $vc->l("<h2>Description settings</h2>"),
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts",
                                    "heading" => "Font Family",
                                    "param_name" => "desc_font",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "ultimate_google_fonts_style",
                                    "heading" => "Font Style",
                                    "param_name" => "desc_font_style",
                                    "value" => "",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "number",
                                    "param_name" => "desc_font_size",
                                    "heading" => "Font size",
                                    "value" => "",
                                    "suffix" => "px",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "param_name" => "desc_font_color",
                                    "heading" => "Color",
                                    "group" => "Typography"
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon to display:"),
                                    "param_name" => "icon_type",
                                    "value" => array(
                                        "No Icon" => 'noicon',
                                        "Font Icon Manager" => "selector",
                                        "Custom Image Icon" => "custom",
                                    ),
                                    "description" => $vc->l("Use an existing font icon</a> or upload a custom image.")
                                ),
                                array(
                                    "type" => "icon_manager",
                                    "class" => "",
                                    "heading" => $vc->l("Select Icon "),
                                    "param_name" => "icon",
                                    "value" => "",
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "attach_image",
                                    "class" => "",
                                    "heading" => $vc->l("Upload Image Icon:"),
                                    "param_name" => "icon_img",
                                    "value" => "",
                                    "description" => $vc->l("Upload the custom image icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Image Width"),
                                    "param_name" => "img_width",
                                    "value" => 48,
                                    "min" => 16,
                                    "max" => 512,
                                    "suffix" => "px",
                                    "description" => $vc->l("Provide image width"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("custom")),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Size of Icon"),
                                    "param_name" => "icon_size",
                                    "value" => 32,
                                    "min" => 12,
                                    "max" => 72,
                                    "suffix" => "px",
                                    "description" => $vc->l("How big would you like it?"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Color"),
                                    "param_name" => "icon_color",
                                    "value" => "#DE5034",
                                    "description" => $vc->l("Give it a nice paint!"),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Style"),
                                    "param_name" => "icon_style",
                                    "value" => array(
                                        "Circle Background" => "circle",
                                        "Square Background" => "square",
                                        "Design your own" => "advanced",
                                    ),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Background Color"),
                                    "param_name" => "icon_color_bg",
                                    "value" => "#fff",
                                    "description" => $vc->l("Select background color for icon."),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Icon Border Style"),
                                    "param_name" => "icon_border_style",
                                    "value" => array(
                                        "None" => "",
                                        "Solid" => "solid",
                                        "Dashed" => "dashed",
                                        "Dotted" => "dotted",
                                        "Double" => "double",
                                        "Inset" => "inset",
                                        "Outset" => "outset",
                                    ),
                                    "description" => $vc->l("Select the border style for icon."),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "colorpicker",
                                    "class" => "",
                                    "heading" => $vc->l("Border Color"),
                                    "param_name" => "icon_color_border",
                                    "value" => "#dbdbdb",
                                    "description" => $vc->l("Select border color for icon."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Width"),
                                    "param_name" => "icon_border_size",
                                    "value" => 1,
                                    "min" => 1,
                                    "max" => 10,
                                    "suffix" => "px",
                                    "description" => $vc->l("Thickness of the border."),
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Border Radius"),
                                    "param_name" => "icon_border_radius",
                                    "value" => 500,
                                    "min" => 1,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "dependency" => Array("element" => "icon_border_style", "not_empty" => true),
                                ),
                                array(
                                    "type" => "number",
                                    "class" => "",
                                    "heading" => $vc->l("Background Size"),
                                    "param_name" => "icon_border_spacing",
                                    "value" => 50,
                                    "min" => 30,
                                    "max" => 500,
                                    "suffix" => "px",
                                    "description" => $vc->l("Spacing from center of the icon till the boundary of border / background"),
                                    "dependency" => Array("element" => "icon_style", "value" => array("advanced")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Animation"),
                                    "param_name" => "icon_animation",
                                    "value" => array(
                                        $vc->l("No Animation") => "",
                                        $vc->l("Swing") => "swing",
                                        $vc->l("Pulse") => "pulse",
                                        $vc->l("Fade In") => "fadeIn",
                                        $vc->l("Fade In Up") => "fadeInUp",
                                        $vc->l("Fade In Down") => "fadeInDown",
                                        $vc->l("Fade In Left") => "fadeInLeft",
                                        $vc->l("Fade In Right") => "fadeInRight",
                                        $vc->l("Fade In Up Long") => "fadeInUpBig",
                                        $vc->l("Fade In Down Long") => "fadeInDownBig",
                                        $vc->l("Fade In Left Long") => "fadeInLeftBig",
                                        $vc->l("Fade In Right Long") => "fadeInRightBig",
                                        $vc->l("Slide In Down") => "slideInDown",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Slide In Left") => "slideInLeft",
                                        $vc->l("Bounce In") => "bounceIn",
                                        $vc->l("Bounce In Up") => "bounceInUp",
                                        $vc->l("Bounce In Down") => "bounceInDown",
                                        $vc->l("Bounce In Left") => "bounceInLeft",
                                        $vc->l("Bounce In Right") => "bounceInRight",
                                        $vc->l("Rotate In") => "rotateIn",
                                        $vc->l("Light Speed In") => "lightSpeedIn",
                                        $vc->l("Roll In") => "rollIn",
                                    ),
                                    "dependency" => Array("element" => "icon_type", "value" => array("selector", "custom")),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "class" => "",
                                    "heading" => $vc->l("Apply link to:"),
                                    "param_name" => "time_link_apply",
                                    "value" => array(
                                        "None" => "",
                                        "Complete box" => "box",
                                        "Box Title" => "title",
                                        "Display Read More" => "more",
                                    ),
                                    "description" => $vc->l("Select the element for link.", "icon-box")
                                ),
                                array(
                                    "type" => "vc_link",
                                    "class" => "",
                                    "heading" => $vc->l("Add Link"),
                                    "param_name" => "time_link",
                                    "value" => "",
                                    "dependency" => Array("element" => "time_link_apply", "value" => array("more", "title", "box")),
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Read More Text"),
                                    "param_name" => "time_read_text",
                                    "value" => "Read More",
                                    "description" => $vc->l("Customize the read more text."),
                                    "dependency" => Array("element" => "time_link_apply", "value" => array("more")),
                                ),
                                array(
                                    "type" => "textfield",
                                    "class" => "",
                                    "heading" => $vc->l("Extra Class"),
                                    "param_name" => "el_class",
                                    "value" => "",
                                    "description" => $vc->l("Add extra class name that will be applied to the timeline, and you can use this class for your customizations."),
                                ),
                                array(
                                    "type" => "dropdown",
                                    "heading" => "Arrow position",
                                    "param_name" => "arrow_position",
                                    "value" => array(
                                        "Top" => "top",
                                        "Bottom" => "bottom"
                                    )
                                ),
                            )
                        )
                );
            }//endif
        }

        function icon_timeline($atts, $content = null) {
            //wp_enqueue_script('masonry',plugins_url('../assets/min-js/',__FILE__).'masonry.min.js', array('jquery'), false, true);
            $this->icon_timeline_scripts();
            $this->icon_timeline_styles();
            $timeline_line_color = $timeline_line_style = '';
            extract(JsComposer::shortcode_atts(array(
                        'timeline_style' => '',
                        'timeline_line_color' => '',
                        'timeline_line_style' => '',
                        'time_sep_bg_color' => '',
                        'time_sep_color' => '',
                        'time_block_bg_color' => '',
                        'timeline_layout' => '',
                        'tl_animation' => '',
                        'custom_width' => '',
                            ), $atts));
            $data = $cw = $line_style = $output = '';
            if ($timeline_layout == 'timeline-custom-width') {
                $cw = 'data-timeline-cutom-width="' . $custom_width . '"';
            }
            if ($time_sep_color != '') {
                $time_sep_color = 'data-time_sep_color="' . $time_sep_color . '"';
            }
            if ($time_sep_bg_color != '') {
                $time_sep_bg_color = 'data-time_sep_bg_color="' . $time_sep_bg_color . '"';
            }
            if ($time_block_bg_color != '') {
                $time_block_bg_color = 'data-time_block_bg_color="' . $time_block_bg_color . '"';
            }
            if ($timeline_line_color != '') {
                $line_style = 'border-right-style:' . $timeline_line_style . ';';
            }
            if ($timeline_line_style != '') {
                $line_style .='border-right-color:' . $timeline_line_color . ';';
            }
            if ($timeline_style == 'jstime') {
                $output .= '<div class="' . $timeline_style . ' timeline_preloader" style="opacity:0;width:35px;margin:auto;margin-top:30px;"><img style="box-shadow:none;" alt="timeline_pre_loader" src="' . jscomposer::plugins_url('assets/img/timeline_pre-loader.gif') . '" /></div>';
                $output .= '<div class="smile-icon-timeline-wrap  ' . $timeline_style . ' ' . $timeline_layout . ' ' . $tl_animation . '" ' . $cw . ' ' . $time_sep_bg_color . ' ' . $time_block_bg_color . ' ' . $time_sep_color . ' style="opacity:0">';
            } else {
                $output .= '<div class="smile-icon-timeline-wrap  ' . $timeline_style . ' ' . $timeline_layout . ' ' . $tl_animation . '" ' . $cw . ' ' . $time_sep_bg_color . ' ' . $time_block_bg_color . ' ' . $time_sep_color . '>';
            }
            $output .= '<div class="timeline-line " style="' . $line_style . '"><z></z></div>';
            $output .='<div class="timeline-wrapper">';
            $output .= JsComposer::do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        function icon_timeline_sep($atts, $content = null) {
            $time_sep_title = $time_sep_color = $time_sep_bg_color = $animation = $el_class = $line_style = $line_color = $icon_style = $seperator_style = '';
            extract(JsComposer::shortcode_atts(array(
                        'time_sep_title' => '. . .',
                        'time_sep_color' => '',
                        'time_sep_bg_color' => '',
                        'line_style' => '',
                        'time_block_bg_color' => '',
                        'line_color' => '',
                        'line_width' => '',
                        'line_radius' => '',
                        'el_class' => '',
                        'font_size' => '',
                        'seperator_title_font' => '',
                        'seperator_title_font_style' => ''
                            ), $atts));
            //$li_prefix = '<div class="timeline-block separator'.$el_class.'">';
            //$li_suffix = '</div>';	
            if ($time_sep_color != '')
                $seperator_style .= 'color:' . $time_sep_color . ';';
            if ($line_style != '')
                $seperator_style .= 'border-style:' . $line_style . ';';
            if ($line_color != '')
                $seperator_style .= 'border-color:' . $line_color . ';';
            if ($line_width != '')
                $seperator_style .= 'border-width:' . $line_width . 'px;';
            if ($line_radius != '')
                $seperator_style .= 'border-radius:' . $line_radius . 'px;';
            if ($font_size != '')
                $seperator_style .= 'font-size:' . $font_size . 'px;';
            if ($seperator_title_font != '') {
                $font_family = get_ultimate_font_family($seperator_title_font);
                $seperator_style .= 'font-family:' . $font_family . ';';
                $args = array(
                    $seperator_title_font
                );
                enquque_ultimate_google_fonts($args);
                if ($seperator_title_font_style != '') {
                    $font_style = get_ultimate_font_family($seperator_title_font_style);
                    $seperator_style .= $font_style;
                }
            }
            $output = '</div>';
            $output .= '
				<div class="timeline-separator-text ' . $el_class . '" data-sep-col="' . $time_sep_color . '" data-sep-bg-col="' . $time_sep_bg_color . '"><span class="sep-text" style="' . $seperator_style . '">' . $time_sep_title . '</span></div><div class="timeline-wrapper ">';
            //$li_prefix = '<div class="timeline-block separator '.$el_class.'">';
            //$li_suffix = '</div>';			
            $style = '';
            //	$style .= $time_sep_bg_color!='' ?  'background:'.$time_sep_bg_color.';' : '';
            //	$style .= $time_sep_color!='' ?  'color:'.$time_sep_color.';' : '';
            //$output .='<div class="ult-timeline-title '.$el_class.' " style="'.$style.'">'.$time_sep_title.'</div>';
            return $output;
        }

        function icon_timeline_feat($atts, $content = null) {
            $icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $time_title = $time_link = $time_link_apply = $time_read_text = $time_icon = $time_icon_color = $time_icon_bg_color = $time_position = $font_size = $line_color = $animation = $icon_border_style = $icon_border_size = $border_color = $title_style = $desc_style = '';
            $font_args = array();
            extract(JsComposer::shortcode_atts(array(
                        'icon_type' => '',
                        'icon' => '',
                        'icon_img' => '',
                        'img_width' => '',
                        'icon_size' => '',
                        'icon_color' => '',
                        'icon_style' => '',
                        'icon_color_bg' => '',
                        'icon_color_border' => '',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'icon_border_radius' => '',
                        'icon_border_spacing' => '',
                        'icon_link' => '',
                        'icon_animation' => '',
                        'time_title' => '',
                        'title_font' => '',
                        'title_font_style' => '',
                        'title_font_size' => '',
                        'title_font_color' => '',
                        'desc_font' => '',
                        'desc_font_style' => '',
                        'desc_font_size' => '',
                        'desc_font_color' => '',
                        //'time_position' => '',
                        'time_link' => '',
                        'time_link_apply' => '',
                        'time_read_text' => '',
                        'el_class' => '',
                        //parent atts				
                        'font_size' => '',
                        'line_color' => '',
                        //SEp
                        'time_sep_color' => '',
                        'time_sep_bg_color' => '',
                        'line_style' => '',
                        'time_block_bg_color' => '',
                        'line_color' => '',
                        'arrow_position' => ''
                            ), $atts));
            $html = '';
            $line_style = $custom_style = $bg_cls = '';
            $box_icon = JsComposer::do_shortcode('[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_link="' . $icon_link . '" icon_animation="' . $icon_animation . '"]');
            if ($icon_color_bg == "")
                $bg_cls .= 'tl-icon-no-bg';
            if ($line_color != '')
                $line_style = 'border-right-color:' . $line_color . ';';
            if ($font_size != '') {
                $line_style.='top:' . ($font_size * 2) . 'px;';
            }
            /* title */
            if ($title_font != '') {
                $font_family = get_ultimate_font_family($title_font);
                $title_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $title_font);
            }
            if ($title_font_style != '')
                $title_style .= get_ultimate_font_style($title_font_style);
            if ($title_font_size != '')
                $title_style .= 'font-size:' . $title_font_size . 'px;';
            if ($title_font_color != '')
                $title_style .= 'color:' . $title_font_color . ';';
            /* description */
            if ($desc_font != '') {
                $font_family = get_ultimate_font_family($desc_font);
                $desc_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $desc_font);
            }
            if ($desc_font_style != '')
                $desc_style .= get_ultimate_font_style($desc_font_style);
            if ($desc_font_size != '')
                $desc_style .= 'font-size:' . $desc_font_size . 'px;';
            if ($desc_font_color != '')
                $desc_style .= 'color:' . $desc_font_color . ';';
            enquque_ultimate_google_fonts($font_args);
            $li_prefix = '<div class="timeline-block ' . $el_class . '"><div class="timeline-dot"></div><div class="ult-timeline-arrow"><s></s><l></l></div>';
            $li_suffix = '</div>';
            $style = ($time_icon_color !== '') ? ' color:' . $time_icon_color . ';' : ' ';
            $style .= ($time_icon_bg_color !== '') ? ' background:' . $time_icon_bg_color . ';' : ' ';
            $style .= ($font_size !== '') ? ' font-size:' . $font_size . 'px;' : ' ';
            $icon_pad = '';
            $header_block_style = '';
            $icon = '<div class="timeline-icon-block"' . $icon_pad . '><div class="ult-timeline-icon ' . $bg_cls . '" style="' . $style . '">';
            if ($icon_type != 'noicon')
                $icon .= $box_icon; //'<i  style="'.$icon_style.'" class="'.$time_icon.'" ></i>';
            $icon .= '</div> <!-- icon --></div>';
            $link_sufix = $link_prefix = '';
            if ($time_link != '') {
                $href = vc_build_link($time_link);
                $link_prefix = '<a href = ' . $href['url'] . '>';
                $link_sufix = '</a>';
            }
            $vv_link = '';
            if ($time_link != '') {
                $href = vc_build_link($time_link);
                $link_prefix = '<a class="tl-desc-a" href = ' . $href['url'] . '>';
                $vv_link = $href['url'];
                $link_sufix = '</a>';
            }
            $header = '';
            $header .= '<div class="timeline-header-block" ' . $header_block_style . '>
							<div class="timeline-header" style="">';
            $header .= '<h3 class="ult-timeline-title" style="' . $title_style . '">' . $time_title . '</h3>';
            if ($time_link_apply != '' && $time_link_apply == 'title') {
                $header = $link_prefix . $header . $link_sufix;
                //$header.='<a href="'.$vv_link.'" class="link-title"></a>';
            }
            $header .= '<p style="' . $desc_style . '">' . JsComposer::do_shortcode($content) . '</p>';
            if ($time_link_apply != '' && $time_link_apply == 'more') {
                $header = $header . '<p>' . $link_prefix . $time_read_text . $link_sufix . '</p>';
            }
            $header .= '</div> <!-- header --></div>';
            $contt = '';
            if ($time_link_apply != '' && $time_link_apply == 'box') {
                $contt.='<a href="' . $vv_link . '" class="link-box"></a>';
                //$li_prefix = $link_prefix.$li_prefix;
                //$li_suffix = $link_sufix.$li_suffix;
            }
            $icon_wrap_preffix = '<div class="timeline-icon-block">';
            $icon_wrap_suffix = '</div>';
            $heading_preffix = '<div class="timeline-header-block">';
            $heading_suffix = '</div>';
            $html = $icon . $header;
            $feat_spl = '</div>';
            if ($arrow_position == 'bottom') // featured item at top
                $ext_class = 'feat-top';
            else
                $ext_class = '';
            $feat_spl .= '<div class="timeline-feature-item feat-item ' . $ext_class . '">';
            $contt.='<div class="feat-dot ' . $ext_class . '"><div class="timeline-dot"></div></div><div class="ult-timeline-arrow ' . $ext_class . '"><s></s><l></l></div>' . $html;
            $contt .='</div><div class="timeline-wrapper ">';
            $feat_spl .=$contt;
            return $feat_spl;
        }

        function icon_timeline_item($atts, $content = null) {
            $icon_type = $icon_img = $img_width = $icon = $icon_color = $icon_color_bg = $icon_size = $icon_style = $icon_border_style = $icon_border_radius = $icon_color_border = $icon_border_size = $icon_border_spacing = $icon_link = $el_class = $icon_animation = $time_title = $time_link = $time_link_apply = $time_read_text = $time_icon = $time_icon_color = $time_icon_bg_color = $time_position = $font_size = $line_color = $animation = $icon_border_style = $icon_border_size = $border_color = $title_style = $desc_style = '';
            $font_args = array();
            extract(JsComposer::shortcode_atts(array(
                        'icon_type' => '',
                        'icon' => '',
                        'icon_img' => '',
                        'img_width' => '',
                        'icon_size' => '',
                        'icon_color' => '',
                        'icon_style' => '',
                        'icon_color_bg' => '',
                        'icon_color_border' => '',
                        'icon_border_style' => '',
                        'icon_border_size' => '',
                        'icon_border_radius' => '',
                        'icon_border_spacing' => '',
                        'icon_link' => '',
                        'icon_animation' => '',
                        'time_title' => '',
                        'title_font' => '',
                        'title_font_style' => '',
                        'title_font_size' => '',
                        'title_font_color' => '',
                        'desc_font' => '',
                        'desc_font_style' => '',
                        'desc_font_size' => '',
                        'desc_font_color' => '',
                        //'time_position' => '',
                        'time_link' => '',
                        'time_link_apply' => '',
                        'time_read_text' => '',
                        'el_class' => '',
                        //parent atts				
                        'font_size' => '',
                        'line_color' => '',
                            ), $atts));
            $html = '';
            $line_style = $custom_style = $bg_cls = '';
            $box_icon = JsComposer::do_shortcode('[just_icon icon_type="' . $icon_type . '" icon="' . $icon . '" icon_img="' . $icon_img . '" img_width="' . $img_width . '" icon_size="' . $icon_size . '" icon_color="' . $icon_color . '" icon_style="' . $icon_style . '" icon_color_bg="' . $icon_color_bg . '" icon_color_border="' . $icon_color_border . '"  icon_border_style="' . $icon_border_style . '" icon_border_size="' . $icon_border_size . '" icon_border_radius="' . $icon_border_radius . '" icon_border_spacing="' . $icon_border_spacing . '" icon_link="' . $icon_link . '" icon_animation="' . $icon_animation . '"]');
            if ($icon_color_bg == "")
                $bg_cls .= 'tl-icon-no-bg';
            if ($line_color != '')
                $line_style = 'border-right-color:' . $line_color . ';';
            if ($font_size != '') {
                $line_style.='top:' . ($font_size * 2) . 'px;';
            }
            /* title */
            if ($title_font != '') {
                $font_family = get_ultimate_font_family($title_font);
                $title_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $title_font);
            }
            if ($title_font_style != '')
                $title_style .= get_ultimate_font_style($title_font_style);
            if ($title_font_size != '')
                $title_style .= 'font-size:' . $title_font_size . 'px;';
            if ($title_font_color != '')
                $title_style .= 'color:' . $title_font_color . ';';
            /* description */
            if ($desc_font != '') {
                $font_family = get_ultimate_font_family($desc_font);
                $desc_style .= 'font-family:' . $font_family . ';';
                array_push($font_args, $desc_font);
            }
            if ($desc_font_style != '')
                $desc_style .= get_ultimate_font_style($desc_font_style);
            if ($desc_font_size != '')
                $desc_style .= 'font-size:' . $desc_font_size . 'px;';
            if ($desc_font_color != '')
                $desc_style .= 'color:' . $desc_font_color . ';';
            enquque_ultimate_google_fonts($font_args);
            $li_prefix = '<div class="timeline-block ' . $el_class . '"><div class="timeline-dot"></div><div class="ult-timeline-arrow"><s></s><l></l></div>';
            $li_suffix = '</div>';
            $style = ($time_icon_color !== '') ? ' color:' . $time_icon_color . ';' : ' ';
            $style .= ($time_icon_bg_color !== '') ? ' background:' . $time_icon_bg_color . ';' : ' ';
            $style .= ($font_size !== '') ? ' font-size:' . $font_size . 'px;' : ' ';
            $icon_pad = '';
            $header_block_style = '';
            $icon = '<div class="timeline-icon-block"><div class="ult-timeline-icon ' . $bg_cls . '" style="' . $style . '">';
            if ($icon_type != 'noicon')
                $icon .= $box_icon; //'<i  style="'.$icon_style.'" class="'.$time_icon.'" ></i>';
            $icon .= '</div> <!-- icon --></div>';
            $link_sufix = $link_prefix = '';
            $vv_link = '';
            if ($time_link != '') {
                $href = vc_build_link($time_link);
                $link_prefix = '<a class="tl-desc-a" href = ' . $href['url'] . '>';
                $vv_link = $href['url'];
                $link_sufix = '</a>';
            }
            $header = '';
            $header .= '<div class="timeline-header-block" ' . $header_block_style . '>
							<div class="timeline-header" style="">';
            $header .= '<h3 class="ult-timeline-title" style="' . $title_style . '">' . $time_title . '</h3>';
            if ($time_link_apply != '' && $time_link_apply == 'title') {
                //$header = $link_prefix.$header.$link_sufix;
                $header.='<a href="' . $vv_link . '" class="link-title"></a>';
            }
            $header .= '<p style="' . $desc_style . '">' . JsComposer::do_shortcode($content) . '</p>';
            if ($time_link_apply != '' && $time_link_apply == 'more') {
                $header = $header . '<p>' . $link_prefix . $time_read_text . $link_sufix . '</p>';
            }
            $header .= '</div> <!-- header --></div>';
            if ($time_link_apply != '' && $time_link_apply == 'box') {
                $header.='<a href="' . $vv_link . '" class="link-box"></a>';
                //$li_prefix = $link_prefix.$li_prefix;
                //$li_suffix = $link_sufix.$li_suffix;
            }
            $icon_wrap_preffix = '<div class="timeline-icon-block">';
            $icon_wrap_suffix = '</div>';
            $heading_preffix = '<div class="timeline-header-block">';
            $heading_suffix = '</div>';
            $html = $li_prefix . $icon . $header . $li_suffix;
            return $html;
        }

    }

}
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_icon_timeline extends WPBakeryShortCodesContainer {
        
    }

    class WPBakeryShortCode_icon_timeline_item extends WPBakeryShortCode {
        
    }

}
// if(class_exists('Ultimate_Icon_Timeline'))
// {
// 	$Ultimate_Icon_Timeline = new Ultimate_Icon_Timeline();
// }