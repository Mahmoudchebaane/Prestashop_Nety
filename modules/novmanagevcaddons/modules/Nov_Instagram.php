<?php

/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */
if (!class_exists("Nov_Instagram")) {

    class Nov_Instagram
    {

        public $vcaddonsinstance, $context;

        function __construct()
        {
            $this->vcaddonsinstance = novmanagevcaddons::getInstance();
            $this->context = Context::getContext();

            JsComposer::add_shortcode("nov_instagram", array($this, "nov_instagram_shortcode"));
        }

        function nov_instagram_init()
        {
            $vc = vc_manager();
            $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Instagram'), 'Style');

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
                        "name" => $vc->l("Nov Instagram"),
                        "base" => "nov_instagram",
                        "class" => "vc_nov_instagram",
                        "icon" => "vc_nov_instagram",
                        "category" => $vc->l("Vinova Items"),
                        "description" => $vc->l("Add a instagram list."),
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
                                'heading' => $vc->l('Title Align'),
                                'param_name' => 'title_align',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => 'left',
                                    '2' => 'center',
                                    '3' => 'right'
                                ),
                                'description' => $vc->l('Select text alignment.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Title Style'),
                                'param_name' => 'title_style',
                                'admin_label' => true,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4'
                                ),
                                'description' => $vc->l('Select title style.')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('User Id'),
                                'param_name' => 'user_id',
                                'value' => '',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Access Token'),
                                'param_name' => 'access_token',
                                'value' => '',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Limit'),
                                'param_name' => 'limit',
                                'value' => '12',
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Display style'),
                                'param_name' => 'display_type',
                                'admin_label' => true,
                                'value' => $style,
                                'description' => $vc->l('Select type of instagram list.')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Number row'),
                                'param_name' => 'number_row',
                                'admin_label' => false,
                                'std' => '1',
                                'value' => array(
                                    '1' => '1',
                                    '2' => '2',
                                    '3' => '3'
                                ),
                                'description' => $vc->l('Select Number row for instagram List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Show Arrows'),
                                'param_name' => 'show_arrows',
                                'description' => $vc->l('If checked row will be set to show arrows slider.'),
                                'value' => array($vc->l('Yes') => 'true'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Show dots'),
                                'param_name' => 'show_dots',
                                'description' => $vc->l('If checked row will be set to show dots slider.'),
                                'value' => array($vc->l('Yes') => 'true'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => $vc->l('Autoplay'),
                                'param_name' => 'autoplay',
                                'description' => $vc->l('If checked row will be set to autoplay slider.'),
                                'value' => array($vc->l('Yes') => 'true'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Desktop: Number manu per line'),
                                'param_name' => 'xl_number',
                                'std' => '4',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Tablet: Number manu per line'),
                                'param_name' => 'md_number',
                                'std' => '3',
                                'value' => $screennumber

                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Mobile: Number manu per line'),
                                'param_name' => 'number',
                                'std' => '2',
                                'value' => $screennumber
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => $vc->l('Spacing'),
                                'param_name' => 'spacing',
                                'std' => '0',
                                'value' => array(
                                    '0' => '0',
                                    '5' => '5',
                                    '10' => '10',
                                    '15' => '15',
                                    '20' => '20',
                                    '25' => '25',
                                    '30' => '30',
                                ),
                                'description' => $vc->l('Select Number row for instagram List type slider.'),
                                "dependency" => array('element' => 'display_type', 'value' => array('slider-type', 'slider-type-1', 'slider-type-2'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => $vc->l('Extra class name'),
                                'param_name' => 'el_class',
                                'description' => $vc->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.')
                            )
                        )
                    )
                );
            }
        }

        function http($url, $method, $postfields = NULL)
        {
            $this->http_info = array();
            $ci = curl_init();
            /* Curl settings */
            curl_setopt($ci, CURLOPT_URL, $url);
            curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ci, CURLOPT_TIMEOUT, 90);
            curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ci, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ci, CURLOPT_HEADER, false);

            switch ($method) {
                case 'POST':
                    curl_setopt($ci, CURLOPT_POST, TRUE);
                    if (!empty($postfields)) {
                        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    }
                    break;
                case 'DELETE':
                    curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                    if (!empty($postfields)) {
                        $url = "{$url}?{$postfields}";
                    }
            }

            $response = curl_exec($ci);
            if (!$response) {
                throw new Exception(__('Error: The access_token provided is invalid.', 'sw_core'));
            }
            curl_close($ci);
            $response = json_decode($response);
            return $response;
        }

        public function Get_Instagram_Gallery($userid, $access_token, $number)
        {
            $url = 'https://api.instagram.com/v1/users/' . $userid . '/media/recent?access_token=' . $access_token . '&count=' . $number;
            $data = $this->http($url, 'GET');
            return $data;
        }

        function nov_instagram_shortcode($atts, $content = null)
        {
            $output = $title = $el_class = $css_class = '';
            $manus = array();
            $vc = vc_manager();
            extract(JsComposer::shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'title_align' => '',
                'title_style' => '1',
                'user_id' => '',
                'access_token' => '',
                'limit' => '12',
                'display_type' => 'grid-type',
                'number_row' => '',
                'show_arrows' => '',
                'show_dots' => '',
                'autoplay' => '',
                'xl_number' => '',
                'md_number' => '',
                'number' => '',
                'spacing' => '',
                'el_class' => ''
            ), $atts));

            $el_class = novmanagevcaddons::getExtraClass($el_class);

            $show_arrows = ($show_arrows == 'true') ? 'true' : 'false';
            $show_dots = ($show_dots == 'true') ? 'true' : 'false';
            $autoplay = ($autoplay == 'true') ? 'true' : 'false';

            //content instagram
            $instagram = $this->Get_Instagram_Gallery($user_id, $access_token, $limit);
            $url = array();
            $images = array();
            foreach ($instagram->data as $key => $img) {
                $url[$key] = $img->link;
                $images[$key] = $img->images;
                $user[$key] = $img->user;
            }

            //echo"<pre>".print_r($instagram->data);die();

            $column = novmanagevcaddons::get_classnumbercolumn($xl_number, $md_number, $number);

            $context = Context::getContext();
            $context->smarty->assign(
                array(
                    'manus' => $manus,
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'title_align' => $title_align,
                    'title_style' => $title_style,
                    'url' => $url,
                    'images' => $images,
                    'user' => $user,
                    'xl' => $xl_number,
                    'md' => $md_number,
                    'xs' => $number,
                    'column' => $column,
                    'number_row' => $number_row,
                    'spacing' => $spacing,
                    'show_arrows' => $show_arrows,
                    'show_dots' => $show_dots,
                    'autoplay' => $autoplay,
                    'el_class' => $el_class
                )
            );

            $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Instagram/' . $display_type . '.tpl', 'novmanagevcaddons'));

            return $output;
        }
    }
    // end class
    // new nov_instagram;
}
