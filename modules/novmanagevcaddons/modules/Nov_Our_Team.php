<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Our_Team")) {

    class Nov_Our_Team {

        public $vcaddonsinstance, $context;

        function __construct() {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_our_team", array($this, "nov_our_team_shortcode"));
            JsComposer::add_shortcode('nov_our_team_item',array($this,'nov_our_team_item_shortcode'));
        }

        function nov_our_team_init() {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Our_Team'), 'Style');

            $screennumber = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6'
            );

            if (function_exists("vc_map")) {
                vc_map(
                    array(
                        "name" => $vc->l("Nov Our Team"),
                        "base" => "nov_our_team",
                        "class" => "vc_nov_our_team",
                        "icon" => "vc_nov_our_team",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a our team list"),
                        "as_parent" => array('only' => 'nov_our_team_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "content_element" => true,
                        "show_settings_on_create" => true,
                        "js_view" => 'VcColumnView',
                        "params" => array(
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Title'),
                                'param_name' => 'title',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Sub title'),
                                'param_name' => 'sub_title'
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of Our Team.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'el_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            ),
                        )
                    )
                );
                vc_map(
                    array(
                        "name" => $vc->l("Nov Our Team Item"),
                        "base" => "nov_our_team_item",
                        "class" => "vc_nov_our_team_item",
                        "icon" => "vc_nov_our_team_item",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a our team item"),
                        "as_child" => array('only' => 'nov_our_team'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                        "show_settings_on_create" => true,
                        "params" => array(
                            array(
                                'type' => 'attach_image',
                                'heading' => $vc->l('Avatar'),
                                'param_name' => 'avatar',
                                'admin_label' => false,
                                'description' => $vc->l('Upload the your avatar')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Name'),
                                'param_name' => 'name',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Info'),
                                'param_name' => 'info',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Phone'),
                                'param_name' => 'phone',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Email'),
                                'param_name' => 'email',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textarea',
                                'holder' => 'div',
                                'heading' => $vc->l('Description'),
                                'param_name' => 'content_our_team_item'
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Facebook'),
                                'param_name' => 'facebook',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Twitter'),
                                'param_name' => 'twitter',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Youtube'),
                                'param_name' => 'youtube',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Google'),
                                'param_name' => 'google',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Dribbble'),
                                'param_name' => 'dribbble',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Instagram'),
                                'param_name' => 'instagram',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Flickr'),
                                'param_name' => 'flickr',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Pinterest'),
                                'param_name' => 'pinterest',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('LinkedIn'),
                                'param_name' => 'linkedIn',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Skype'),
                                'param_name' => 'skype',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Vimeo'),
                                'param_name' => 'vimeo',
                                'admin_label' => true
                            )
                        )
                    )
                );
            }
        }

        function nov_our_team_shortcode($atts, $content = null) {
            $output = $content_our_team = $title = $el_class = $css_class = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'display_type' => '',
                'content_our_team' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass( $el_class );

            $content_our_team = JsComposer::do_shortcode($content);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'content_our_team' => $content_our_team,
                    'display_type' => $display_type,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Our_Team/'. $display_type .'.tpl', 'novmanagevcaddons'));

            return $output;
        }
        function nov_our_team_item_shortcode($atts, $content = null) {
            $output = $content_our_team_item = '';
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'avatar' => '',
                'name' => '',
                'info' => '',
                'phone' => '',
                'email' => '',
                'content_our_team' => '',
                'content_our_team_item' => JsComposer::do_shortcode($content_our_team_item),
                'facebook' => '',
                'twitter' => '',
                'youtube' => '',
                'google' => '',
                'dribbble' => '',
                'instagram' => '',
                'flickr' => '',
                'pinterest' => '',
                'linkedIn' => '',
                'skype' => '',
                'vimeo' => '',

            ), $atts));

            $social = '';
            if(isset($facebook) && !empty($facebook)){
                $social .= '<li class="d-inline-block"><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
            }
            if(isset($twitter) && !empty($twitter)){
                $social .= '<li class="d-inline-block"><a href="'.$twitter.'"><i class="fa fa-twitter"></a></i></li>';
            }
            if(isset($youtube) && !empty($youtube)){
                $social .= '<li class="d-inline-block"><a href="'.$youtube.'"><i class="fa fa-youtube-play"></a></i></li>';
            }
            if(isset($google) && !empty($google)){
                $social .= '<li class="d-inline-block"><a href="'.$google.'"><i class="fa fa-google-plus"></a></i></li>';
            }
            if(isset($dribbble) && !empty($dribbble)){
                $social .= '<li class="d-inline-block"><a href="'.$dribbble.'"><i class="fa fa-dribbble"></a></i></li>';
            }
            if(isset($instagram) && !empty($instagram)){
                $social .= '<li class="d-inline-block"><a href="'.$instagram.'"><i class="fa fa-instagram"></a></i></li>';
            }
            if(isset($flickr) && !empty($flickr)){
                $social .= '<li class="d-inline-block"><a href="'.$flickr.'"><i class="fa fa-flickr"></a></i></li>';
            }
            if(isset($pinterest) && !empty($pinterest)){
                $social .= '<li class="d-inline-block"><a href="'.$pinterest.'"><i class="fa fa-pinterest"></a></i></li>';
            }
            if(isset($linkedIn) && !empty($linkedIn)){
                $social .= '<li class="d-inline-block"><a href="'.$linkedIn.'"><i class="fa fa-linkedIn"></a></i></li>';
            }
            if(isset($skype) && !empty($skype)){
                $social .= '<li class="d-inline-block"><a href="'.$skype.'"><i class="fa fa-skype"></a></i></li>';
            }
            if(isset($vimeo) && !empty($vimeo)){
                $social .= '<li class="d-inline-block"><a href="'.$vimeo.'"><i class="fa fa-vimeo"></a></i></li>';
            }


            $output ='<div class="item col">';
            $output .='<div class="block_ourteam mb-25">';
            $output .='<div class="avatar mb-20">';
            $output .='<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($avatar) . '" class="img-fluid" />';
            $output .='</div>';
            $output .='<div class="block_info">';
            $output .='<div class="name"> '.$name.'</div>';
            $output .='<div class="info mb-10"> '.$info.'</div>';
            $output .='<div class="content"> '.$content_our_team_item.'</div>';
            if(isset($phone) && !empty($phone)){
                $output .='<div class="phone mt-10 mb-5"> '.$phone.'</div>';
            }
            if(isset($email) && !empty($email)){
                $output .='<div class="email mb-10"> '.$email.'</div>';
            }
            $output .='</div>';
            $output .='</div>';
            $output .='<ul class="block_social list-unstyled">'.$social.'</ul>';
            $output .='</div>';

            return $output;
        }
    }
    // end class
    // new nov_our_team;
}

//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nov_our_team extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nov_our_team_item extends WPBakeryShortCode {
    }
}