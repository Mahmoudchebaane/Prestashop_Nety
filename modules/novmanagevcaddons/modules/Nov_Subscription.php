<?php
/*
 * Add-on Name: Vinova Manage VC Addons
 * Add-on URI: http://vinovathemes.com
 */

if (!class_exists("Nov_Subscription")) {

  class Nov_Subscription {

    public $vcaddonsinstance, $context;

    function __construct() {
      $this->vcaddonsinstance = novmanagevcaddons::getInstance();
      $this->context = Context::getContext();

      JsComposer::add_shortcode("nov_subscription", array($this, "nov_subscription_shortcode"));
    }

    function nov_subscription_init() {
      $vc = vc_manager();
      $style = novmanagevcaddons::nov_getfile(novmanagevcaddons::get_module_dir('views/templates/front/Nov_Subscription'), 'Style');

      if (function_exists("vc_map")) {
        vc_map(
          array(
            "name" => $vc->l("Nov Subscription"),
            "base" => "nov_subscription",
            "class" => "vc_nov_subscription",
            "icon" => "vc_nov_subscription",
            "category" => $vc->l("Vinova Items"),
            "description" => $vc->l("Add a subscription."),
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
                'type' => 'textfield',
                'heading' => $vc->l('Description title'),
                'param_name' => 'desc_title'
              ),
              array(
                'type' => 'attach_image',
                'class' => '',
                'heading' => $vc->l('Icon'),
                'param_name' => 'email_icon',
                'value' => '',
                'admin_label' => false,
                'description' => $vc->l('Upload the icon you want.'),
                "dependency" => array('element' => 'display_type', 'value' => array('style-2', 'style-3', 'style-4'))
              ),
              array(
                'type' => 'dropdown',
                'heading' => $vc->l('Display style'),
                'param_name' => 'display_type',
                'admin_label' => true,
                'value' => $style,
                'description' => $vc->l('Select type of map.')
              ),
              array(
                'type' => 'colorpicker',
                'heading' => $vc->l( 'Background Color'),
                'param_name' => 'accent_color',
                'description' => $vc->l( 'Select background color for your element.'),
                'value' => array( $vc->l( 'Yes') => 'true' ),
                "dependency" => array('element' => 'display_type', 'value' => array('style-3'))
              ),
              array(
                'type' => 'colorpicker',
                'heading' => $vc->l( 'Background Button'),
                'param_name' => 'bg_button',
                'description' => $vc->l( 'Select background color for button.'),
                'value' => array( $vc->l( 'Yes') => 'true' ),
                "dependency" => array('element' => 'display_type', 'value' => array('style-3'))
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

    function nov_subscription_shortcode($atts, $content = null) {
      $output = $title = $desc_title =$email_icon = $el_class = $css_class = '';
      $link = new Link();
      $vc = vc_manager();
      extract(JsComposer::shortcode_atts(array(
        'title' => '',
        'sub_title' => '',
        'desc_title' => '',
        'accent_color' => '',
        'bg_button' => '',
        'email_icon' => '',
        'display_type' => '',
        'el_class' => ''
      ), $atts));

      $el_class = novmanagevcaddons::getExtraClass( $el_class );

      $subs_icon = '<img src="' . JsComposer::$_url . 'uploads/' . JsComposer::get_media_thumbnail_url($email_icon) . '" class="img-fluid" />';

      $context = Context::getContext();
      if(Module::isInstalled('ps_emailsubscription') && Module::isEnabled('ps_emailsubscription')) {
        $ps_emailsubscription = Module::getInstanceByName('ps_emailsubscription');
        $context->smarty->assign('nov_emailsubscription',$ps_emailsubscription->getWidgetVariables('displayHome', array()));
      } else {
          $context->smarty->assign('nov_emailsubscription', '');
      }

      $context->smarty->assign(
        array(
          'title' => $title,
          'link'  => $link,
          'sub_title' => $sub_title,
          'desc_title' => $desc_title,
          'accent_color' => $accent_color,
          'bg_button' => $bg_button,
          'subs_icon' => $subs_icon,
          'el_class' => $el_class
        )
      );

      $output .= $context->smarty->fetch(JsComposer::getTPLPath('Nov_Subscription/'. $display_type .'.tpl', 'novmanagevcaddons'));

      if(isset($css) && !empty($css)){
        $css_out = '<style>'.$css.'</style>';
        $output .= $css_out;
      }

      return $output;
    }

  }
  // end class
  // new nov_subscription;
}
