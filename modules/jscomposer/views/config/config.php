<?php

if ( ! defined( '_PS_VERSION_' ) ) {
    exit;
}
session_start();

JsComposer::validate();

$ps_base_path = preg_split('/modules/', dirname(__FILE__));

require_once($ps_base_path[0].'/config/config.inc.php');
require_once($ps_base_path[0].'/init.php');

if(Module::isInstalled('jscomposer') && !class_exists('JsComposer')){
    Module::getInstanceByName('jscomposer');
}

mb_internal_encoding('UTF-8');
$base_url = Tools::getHttpHost(true);
$upload_dir = __PS_BASE_URI__.'modules/jscomposer/uploads/';
$current_path = _PS_ROOT_DIR_.'/modules/jscomposer/uploads/'; 
$thumbs_base_path = _PS_ROOT_DIR_.'/modules/jscomposer/uploads/'; 
$MaxSizeUpload=100;
$default_language="en";
$icon_theme="ico"; 
$show_folder_size=false;
$show_sorting_bar=true; 
$loading_bar=true; 
$transliteration=false;  
$image_max_width=0;
$image_max_height=0;
$image_resizing=false;
$image_resizing_width=0;
$image_resizing_height=0;
$default_view=0;
$ellipsis_title_after_first_row=true;

$delete_files=true;
$create_folders=true;
$delete_folders=true;
$upload_files=true;
$rename_files=true;
$rename_folders=true;
$duplicate_files=true;

$ext_img = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'); //
$ext=array_merge($ext_img); 
$aviary_active=false;
$aviary_key="dvh8qudbp6yx2bnp";
$aviary_secret="m6xaym5q42rpw433";
$aviary_version=3;
$aviary_language='en';
$file_number_limit_js=500;
$hidden_folders = array();
$hidden_files = array('config.php');
$java_upload=false;
$JAVAMaxSizeUpload=200; //Gb
$fixed_image_creation                   = false;
$fixed_path_from_filemanager            = array('../test/','../test1/');
$fixed_image_creation_name_to_prepend   = array('','test_'); 
$fixed_image_creation_to_append         = array('_test',''); 
$fixed_image_creation_width             = array(300,400);
$fixed_image_creation_height            = array(200,''); 
$relative_image_creation                = false; 
$relative_path_from_current_pos         = array('thumb/','thumb/'); 
$relative_image_creation_name_to_prepend= array('','test_'); 
$relative_image_creation_name_to_append = array('_test',''); 
$relative_image_creation_width          = array(300,400); 
$relative_image_creation_height         = array(200,''); 
