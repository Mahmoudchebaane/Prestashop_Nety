{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{extends file="helpers/form/form.tpl"}

{block name="input"}

        {if $input.type == "select" && $input.name == "mega_menu_type"}
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
            <script type="text/javascript">
            $(function(){
                $(window).on('load',function(){
                    $('select[name="{$input.name}"]').trigger('change');
                });
            });
            </script>

            </div>
    </div>
<script src="http:////ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://www.marteki.com/jquery/css/southstreet/jquery-ui-1.7.1.custom.css" type="text/css" media="screen" />
<style type="text/css">
		 
		.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
		.ui-sortable-placeholder * { visibility: hidden; }
		.elementbar {  display: block;   height:100px; }
		.elementbar div { float: left; display: block;   padding-left: 10px; font: bold 10pt "Arial",sans-serif; }
		.elementbar div:hover { cursor: pointer; }
		.elementbar div img { padding-right: 3px; vertical-align: text-bottom; }
		.element { display: block; width: 90%;  }
		.element-dragging { background: #fff; border: 1px dotted #000; }
		.element-txt {} 
		.element-img {} 
		.element-txtimg {} 
		#pagecontent { clear: both; border-top: 2px solid #000;}
		
	.elemtxt{	
	}
.inner_row {
padding: 0px 6px 0px 5px;
border-radius: 5px;
display: block;
border: 1px solid #e3e3e3;
border-left: 0px;
border-right: 0;
height: 54px;
border-radius: 4px 4px 4px 0px;
}
	.box { background-color:#ccc;}
.first_box {

border-left: 0px;
margin-bottom: 20px;
}
.img {
width: 45px;
float: left;
border-right: 1px solid#fff;
height: 48px;
margin-left: -6px;
}
.img span {
width: 50%;
float: right;
height: 52px;
line-height: 38px;
/* margin-top: 9px; */
text-align: left;
padding: 1px;
background-color: #e3e3e3;
}
.icon {
height: 42px;
/* margin: 2px; */
width: 50%;
vertical-align: middle;
float: left;
}
.button_menu {
color: #555;
background-color: #fff;
border-color: #ccc;
display: inline-block;
margin-bottom: 0;
font-weight: normal;
text-align: center;
vertical-align: middle;
cursor: pointer;
background-image: none;
white-space: nowrap;
padding: 3px 4px;
font-size: 12px;
line-height: 1.42857;
border-radius: 3px;
border: solid 1px #e6e6e6;
background-color: #fff;
-webkit-border-radius: 5px;
}
 
.button_control {
color: #555;
background-color: #fff;
border-color: #ccc;
display: inline-block;
margin-bottom: 0;
font-weight: normal;
text-align: center;
vertical-align: middle;
cursor: pointer;
background-image: none;
 
white-space: nowrap;
padding: 2px 6px;
font-size: 12px;
line-height: 1.42857;
border: solid 1px #e6e6e6;
background-color: #fff;
-webkit-border-radius: 5px 5px 0px 0px;
border-radius: 5px 5px 0px 0px;
-webkit-box-shadow: rgba(0,0,0,0.1) 0 2px 0,#fff 0 0 0 3px inset;
box-shadow: rgba(0,0,0,0.1) 0 2px 0,#fff 0 0 0 3px inset;
}

.img_1 ,.img_2 {    display: inline-block;
     }
 
span { text-align:center; font-family:Arial, Helvetica, sans-serif; padding: 0 10px; font-size:12px; }
.midel_text { float:left; font-family:Arial, Helvetica, sans-serif; font-size:20px; margin:5px;   color:#3c4048; }
.last_icon {  float:right;width: 18px; }
.row_menu { position: relative;}

.new_row_add  , .row_menu{
background-color: #fff;
border: 1px dashed silver;
-webkit-border-radius: 3px;
border-radius: 3px;
padding: 10px 20px;
font-size: 1.3em;
text-align: center;
margin-bottom: 20px;
clear: both;
}
.elementbar { display: none; }
.ui-widget-content{ border:none;}
.row_control{
 
position: absolute;
left: -19px;
top: 0px;
width: 25px;
height: 100px;
/* background-color: #e2e2e2; */
border: 1px 1px 1px 0px;
border-color: #e3e3e3;
border: 1px solid #e3e3e3;
border-right: 0px;
margin-top: 10px;
background-color: #fff;
}
.row_control a{
	color: #000;
}
.row_control a i{
	font-size: 20px;
padding-bottom: 8px;
padding-left: 5px;
padding-top: 5px;
}
.col-md-2 .midel_text, .col-md-1 .midel_text {
	display: none;
	}
	</style>
		<div class="elementbar row">
		<div class="row_menu row" >
		<div class="row_control">
 

<a class="row_control_drag" href="#"><i class="icon-move"></i></a>
<a class="row_control_edit" href="#"  data-toggle="modal" data-target="#row_edit_control_1"><i class="icon-edit"></i></a>
<a class="row_control_delete" href="#"><i class="icon-trash"></i></a>
</div>
		<input type="hidden" name="max_column[]" class="max_column" value="1">
		<input type="hidden" name="current_column[]" class="current_column" value="1">
		 <div class="col-md-4 element element-txt first_box  ui-helper-clearfix ui-corner-all">
		 <div class="inner_row">
						<input type="hidden" name="testimonial_name_1" class="name" value="1">	  
                        <input type="hidden" name="testimonial_size_1" class="size" value="4">  
                      <div class="img">
                                <div class="icon">
                                    <div class="img_1 button_menu"><a class="layout_plus" href="#"><i class="icon-plus-sign"></i></a></div>
                                    <div class="img_2 button_menu"><a class="layout_minus" href="#"><i class="icon-minus-sign"></i></a></div>
                                </div>
                                  <span>1/4</span>
                        </div>
                                <div class="midel_text">
                                    Feature box
                                </div>
             <div class="last_icon">
                        <a href="#" class="delete_column button_control"><i class="icon-trash"></i></a>
                          <a href="#" href="#" class="edit_column button_control"
   data-toggle="modal"
   data-target="#basicModal_0" ><i class="icon-pencil"></i></a>
           </div>
	 	
	 <div class="modal fade" id="basicModal_0" tabindex="-1" role="dialog" aria-labelledby="basicModal_0" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
						<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">This module is Untrusted</h4>
			</div>
			
			

<div class="modal-body">
<select name="link_type" class=" fixed-width-xl" id="link_type">
<option value="LNK">LINK</option>
<option value="SUP" selected="selected">Supplier</option>
<option value="MAN">Manufacturer</option>
<option value="CAT">Categories</option>
<option value="PRD">Products</option>																																																				 
<option value="PRD">Products</option>
<option value="CMS_PAGE">CMS Page</option>
<option value="CMS_CAT">CMS Category</option>
</select>
<select name="link_MAN" class=" fixed-width-xl" id="link_SUP">
<option value="SUP1">Fashion Supplier</option>
</select>
<select name="link_CMS_PAGE" class=" fixed-width-xl" id="link_CMS_PAGE">
<option value="CMS_PAGE1">Delivery</option>
<option value="CMS_PAGE2">Legal Notice</option>
<option value="CMS_PAGE3">Terms and conditions of use</option>
<option value="CMS_PAGE4">About us</option>
<option value="CMS_PAGE5">Secure payment</option>
</select>
	 
 </div>
	</div>
</div>
</div>


	</div>	 
 
	 	</div> 
	 		<div class="row-margin-bottom new_row_add">
				<a class="add_new_column" href="#" >
					<i class="icon-plus"></i> Add New Column
				</a>
			</div>
	
			</div>
			
	</div >
 
	</div>
	<div id="pagecontent">
 
		<div class="row container_4">
			 	 
		 
		</div>
	 
	 

	<div class="row_menu">

<div class="row_control">

<a class="row_control_drag" href="#"><i class="icon-move"></i></a>
<a class="row_control_edit" href="#" data-toggle="modal" data-target="#row_edit_control_2"><i class="icon-edit"></i></a>
<a class="row_control_delete" href="#" ><i class="icon-trash"></i></a>
</div>
<div class="col-md-4 element element-txt first_box data-toggle="modal" data-target="#row_edit_control_1"i-widget ui-widget-content ui-helper-clearfix ui-corner-all">
<div class="inner_row">
						<input type="hidden" name="testimonial_name_1" class="name" value="1">	  
                        <input type="hidden" name="testimonial_size_1" class="size" value="4">  
                      <div class="img">
                                <div class="icon">
                                    <div class="img_1 button_menu"><a class="layout_plus" href="#"><i class="icon-plus-sign"></i></a></div>
                                    <div class="img_2 button_menu"><a class="layout_minus" href="#"><i class="icon-minus-sign"></i></a></div>
                                </div>
                                  <span>1/4</span>
                        </div>
                                <div class="midel_text">
                                    Feature box
                                </div>
                    <div class="last_icon">
                        <a href="#" class="delete_column button_control"><i class="icon-trash"></i></a>
                          <a href="#" href="#" class="edit_column button_control"
   data-toggle="modal"
   data-target="#basicModal_1" ><i class="icon-pencil"></i></a>
           </div>
	 	
	 <div class="modal fade" id="basicModal_1" tabindex="-1" role="dialog" aria-labelledby="basicModal_1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
						<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">This module is Untrusted</h4>
			</div>
			
			

<div class="modal-body">
<select name="link_type" class=" fixed-width-xl" id="link_type">
<option value="LNK">LINK</option>
<option value="SUP" selected="selected">Supplier</option>
<option value="MAN">Manufacturer</option>
<option value="CAT">Categories</option>
<option value="PRD">Products</option>																																																				 
<option value="PRD">Products</option>
<option value="CMS_PAGE">CMS Page</option>
<option value="CMS_CAT">CMS Category</option>
</select>
<select name="link_MAN" class=" fixed-width-xl" id="link_SUP">
<option value="SUP1">Fashion Supplier</option>
</select>
<select name="link_CMS_PAGE" class=" fixed-width-xl" id="link_CMS_PAGE">
<option value="CMS_PAGE1">Delivery</option>
<option value="CMS_PAGE2">Legal Notice</option>
<option value="CMS_PAGE3">Terms and conditions of use</option>
<option value="CMS_PAGE4">About us</option>
<option value="CMS_PAGE5">Secure payment</option>
</select>
	 
 </div>
	</div>
</div>
</div>
<!-- start for row edit modal-->
<div class="modal fade" id="row_edit_control_2" tabindex="-1" role="dialog" aria-labelledby="row_edit_control_2" aria-hidden="true">
<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Row Customization</h4>
			</div>
			
		
			<div class="modal-body">
			   <div class="form-wrapper">
        <div class="form-group">
            <div id="conf_id_PS_LANG_DEFAULT">
                <label class="control-label col-lg-3"><span class=
                "label-tooltip" data-html="true" data-original-title=
                "The default language used in your shop." data-toggle="tooltip"
                title="">Backgound</span></label>

                <div class="col-lg-9">
                    <select class="form-control fixed-width-xxl row_custoization_bg_opt"  name="PS_LANG_DEFAULT">
                        <option value="0"> none </option>
                        <option  selected="selected"  value="1"> image </option>
                    </select>
                </div>
            </div>
        </div>
        <script type="text/javascript">
	        	$(function() {


	        		var selected_val = $(".row_custoization_bg_opt  option:selected").val();
	        		 
	        		if(selected_val==1){
		        			$(".row_custoization_bg_opt").parents('.form-group').siblings('.option_bg_image').show();
		        			$(".row_custoization_bg_opt").parents('.form-group').siblings('.option_bg_color').hide();
		        		}
		        		else{
		        			$(".row_custoization_bg_opt").parents('.form-group').siblings('.option_bg_image').hide();
		        			$(".row_custoization_bg_opt").parents('.form-group').siblings('.option_bg_color').show();
		        		}


				$(".row_custoization_bg_opt").on('change', function (e) {
				   var valueSelected = this.value;
		        		
		        		if(this.value==1){
		        			$(this).parents('.form-group').siblings('.option_bg_image').show();
		        			$(this).parents('.form-group').siblings('.option_bg_color').hide();
		        		}
		        		else{
		        			$(this).parents('.form-group').siblings('.option_bg_image').hide();
		        			$(this).parents('.form-group').siblings('.option_bg_color').show();
		        		}

		        	})

	        })
        </script>
         <div class="form-group option_bg_image" >
          <label class="control-label col-lg-3"><span class="label-tooltip"
            data-html="true" data-original-title=
            "Set the maximum size of product short description (in characters)."
            data-toggle="tooltip" title="">Image Url</span></label>
         <div class="col-lg-3">
          <input class="form-control" name="PS_PRODUCT_SHORT_DESC_LIMIT" size="100" type="text" value="">
          </div>
          <div class="col-lg-2">
          <select name="link_type" class=" fixed-width-md" >
			<option value="repeat">repeat</option>
			<option value="repeat-x">repeat-x</option>
			<option value="repeat-y">repeat-y</option>
			<option value="no-repeat">no-repeat</option>
			<option value="initial">initial</option>
			<option value="inherit">inherit</option>
			 
          </select>
          </div>
           <div class="col-lg-2">
          <select name="link_type" class=" fixed-width-md" >
			<option value="left top">left top</option>
			<option value="left center">left center</option>
			<option value="left bottom">left bottom</option>
			<option value="right top">right top</option>
			<option value="right center">right center</option>
			<option value="right bottom">right bottom</option>
			<option value="center top">center top</option>
			<option value="center center">center center</option>
			<option value="center bottom">center bottom</option>
			 
          </select>
          </div>
             <div class="col-lg-2">
          <select name="link_type" class=" fixed-width-md" >
			<option value="scroll">scroll</option>
			<option value="fixed">fixed</option>
			<option value="local">local</option>
			<option value="initial">initial</option>
			<option value="inherit">inheritr</option>
 
			 
          </select>
          </div>
         </div>
    <div class="form-group option_bg_color" >
        <div id="conf_id_PS_PRODUCT_SHORT_DESC_LIMIT">
            <label class="control-label col-lg-3"><span class="label-tooltip"
            data-html="true" data-original-title=
            "Set the maximum size of product short description (in characters)."
            data-toggle="tooltip" title="">Border</span></label>

            <div class="col-lg-3">
                <div class="input-group">
                    <input class="form-control" name=
                    "PS_PRODUCT_SHORT_DESC_LIMIT" class="fixed-width-lg" size="5" type="text" value=
                    "0"> <span class="input-group-addon ">px</span>
                </div>
            </div>
             <div class="col-lg-3">
                <div class="input-group">
                    <select class="form-control fixed-width-lg" id="PS_CURRENCY_DEFAULT" name="PS_CURRENCY_DEFAULT">
                        <option selected="selected" value="1">
                            solid
                        </option>
                    </select>
                </div>


            </div>
  <div class="col-lg-3">
                <div class="input-group">
                    <input type="color" data-hex="true" class="color mColorPickerInput lg" name="label_bg_color" value="" />
                    </select>
                </div>


            </div>

        </div>
    </div>
        <div class="form-group">
            <div id="conf_id_PS_DIMENSION_UNIT">
                <label class="control-label col-lg-3 required"><span  title="">Padding</span></label>
 		 
              <div class="col-lg-2">
                <div class="input-group">
                <span class="input-group-addon"><i class="icon-arrow-up"></i></span>
                    <input class="form-control" name="PS_PRODUCT_SHORT_DESC_LIMIT" size="5" type="text" value="0"> <span class="input-group-addon">px</span>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="input-group">
                <span class="input-group-addon"><i class="icon-arrow-right"></i></span>
                    <input class="form-control" name="PS_PRODUCT_SHORT_DESC_LIMIT" size="5" type="text" value="0"> <span class="input-group-addon">px</span>
                </div>
            </div>
          
         
        

            </div>
        </div>


        <div class="form-group">
        	<div class=" col-lg-3"></div>
        	    <div class="col-lg-2">
                <div class="input-group">
                <span class="input-group-addon"><i class="icon-arrow-left"></i></span>
                    <input class="form-control" name="PS_PRODUCT_SHORT_DESC_LIMIT" size="5" type="text" value="0"> <span class="input-group-addon">px</span>
                </div>
            </div>
             <div class="col-lg-2">
                <div class="input-group">
                <span class="input-group-addon"><i class="icon-arrow-down"></i></span>
                    <input class="form-control" name="PS_PRODUCT_SHORT_DESC_LIMIT" size="5" type="text" value="0"> <span class="input-group-addon">px</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div id="conf_id_PS_CURRENCY_DEFAULT">
                <label class="control-label col-lg-3"><span class=
                "label-tooltip" data-html="true" data-original-title=
                "The default currency used in your shop. - If you change the default currency, you will have to manually edit every product price."
                data-toggle="tooltip" title="">Custom Css</span></label>

                <div class="col-lg-9">
                     <textarea name="custom_css_1"  id="custom_css_1"  ></textarea>
                </div>
            </div>
        </div>
    </div>
			</div>
		</div>	
</div>
</div>

<!-- end for row edit modal-->
		 	</div> 
			</div>
			<div class="col-md-4 element element-txt first_box ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="inner_row">
						<input type="hidden" name="testimonial_name_1" class="name" value="1">	  
                        <input type="hidden" name="testimonial_size_1" class="size" value="4">  
                      <div class="img">
                                <div class="icon">
                                    <div class="img_1 button_menu "><a class="layout_plus" href="#"><i class="icon-plus-sign"></i></a></div>
                                    <div class="img_2 button_menu"><a class="layout_minus" href="#"><i class="icon-minus-sign"></i></a></div>
                                </div>
                                  <span>1/4</span>
                        </div>
                                <div class="midel_text">
                                    Feature box
                                </div>
                   <div class="last_icon">
                        <a href="#" class="delete_column button_control"><i class="icon-trash"></i></a>
                          <a href="#" href="#" class="edit_column button_control"
   data-toggle="modal"
   data-target="#basicModal_2" ><i class="icon-pencil"></i></a>
           </div>
	 	
	 <div class="modal fade" id="basicModal_2" tabindex="-1" role="dialog" aria-labelledby="basicModal_2" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
						<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">This module is Untrusted</h4>
			</div>
			
			

<div class="modal-body">
<select name="link_type" class=" fixed-width-xl" id="link_type">
<option value="LNK">LINK</option>
<option value="SUP" selected="selected">Supplier</option>
<option value="MAN">Manufacturer</option>
<option value="CAT">Categories</option>
<option value="PRD">Products</option>																																																				 
<option value="PRD">Products</option>
<option value="CMS_PAGE">CMS Page</option>
<option value="CMS_CAT">CMS Category</option>
</select>
<select name="link_MAN" class=" fixed-width-xl" id="link_SUP">
<option value="SUP1">Fashion Supplier</option>
</select>
<select name="link_CMS_PAGE" class=" fixed-width-xl" id="link_CMS_PAGE">
<option value="CMS_PAGE1">Delivery</option>
<option value="CMS_PAGE2">Legal Notice</option>
<option value="CMS_PAGE3">Terms and conditions of use</option>
<option value="CMS_PAGE4">About us</option>
<option value="CMS_PAGE5">Secure payment</option>
</select>
	 
 </div>
	</div>
</div>
</div>
		 
	 </div>
			</div>
			<div class="col-md-4 element element-txt first_box ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
			<div class="inner_row">
						<input type="hidden" name="testimonial_name_1" class="name" value="1">	  
                        <input type="hidden" name="testimonial_size_1" class="size" value="4">  
                      <div class="img">
                                <div class="icon">
                                    <div class="img_1 button_menu"><a class="layout_plus" href="#"><i class="icon-plus-sign"></i></a></div>
                                    <div class="img_2 button_menu"><a class="layout_minus" href="#"><i class="icon-minus-sign"></i></a></div>
                                </div>
                                  <span>1/4</span>
                        </div>
                                <div class="midel_text">
                                    Feature box
                                </div>
                 <div class="last_icon">
                        <a href="#" class="delete_column button_control"><i class="icon-trash"></i></a>
                          <a href="#" href="#" class="edit_column button_control"
   data-toggle="modal"
   data-target="#basicModal_3" ><i class="icon-pencil"></i></a>
           </div>
	 	
	 <div class="modal fade" id="basicModal_3" tabindex="-1" role="dialog" aria-labelledby="basicModal_3" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
						<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">This module is Untrusted</h4>
			</div>
			
			

<div class="modal-body">
<select name="link_type" class=" fixed-width-xl" id="link_type">
<option value="LNK">LINK</option>
<option value="SUP" selected="selected">Supplier</option>
<option value="MAN">Manufacturer</option>
<option value="CAT">Categories</option>
<option value="PRD">Products</option>																																																				 
<option value="PRD">Products</option>
<option value="CMS_PAGE">CMS Page</option>
<option value="CMS_CAT">CMS Category</option>
</select>
<select name="link_MAN" class=" fixed-width-xl" id="link_SUP">
<option value="SUP1">Fashion Supplier</option>
</select>
<select name="link_CMS_PAGE" class=" fixed-width-xl" id="link_CMS_PAGE">
<option value="CMS_PAGE1">Delivery</option>
<option value="CMS_PAGE2">Legal Notice</option>
<option value="CMS_PAGE3">Terms and conditions of use</option>
<option value="CMS_PAGE4">About us</option>
<option value="CMS_PAGE5">Secure payment</option>
</select>
	 
 </div>
	</div>
</div>
</div>
		 </div>
			</div>
<div   class="row-margin-bottom new_row_add">
				<a class="add_new_column" href="#"  >
					<i class="icon-plus"></i> Add New Column
				</a>
			</div>

	</div>
	</div>
<div class="row">
<div  class="row-margin-bottom new_row_add">
				<a  id="add_new_row" href="#"  >
					<i class="icon-plus"></i> Add New Row
				</a>
			</div>
</div>

<div class="row">	
<div class="col-lg-12">
	
 
<script type="text/javascript">
	$(function() {
		$("#add_new_row").live('click', function(e){
			 
		e.preventDefault();

var clone_elm =$(".elementbar .row_menu").clone();

 
$("#pagecontent").prepend(clone_elm);

//now need to change the id and data so that modal call is applicable

//var new_modal_id = $(this).parent().parent().children('.modal').attr('id');

 
	});

$(".add_new_column").live('click', function(e){

e.preventDefault();


	var clone_elm =$(".elementbar .row_menu .first_box").clone();


	

  	//var current_colum = $(this).parent().parent().children(".total_column");// pa
  	//if(current_colum+1<=12)
  		$(this).parent().parent().prepend(clone_elm);
});
$(".delete_column").live('click', function(e){
e.preventDefault();
$(this).parent().parent().remove();

	 
});

	$(".elementbar div, .elementbar div img").disableSelection();
	$("#pagecontent").sortable({
			connectWith: '#pagecontent',
			cursor: 'move', 
			handle: ".row_control",
      		cancel: ".portlet-toggle",
			cursorAt: { top: 0, left: 0 }, 
			placeholder: 'ui-sortable-placeholder',
			tolerance: 'pointer' 
	});
	 
		$(".layout_minus").live('click',function(e){
		e.preventDefault();
			var parent_element = $(this).parents('.first_box');
			
			var element_size = parent_element.children('.inner_row').children(".size");// pa
			 
			 var current_grid_no  =  element_size.val();
			
			 var current_class =  "col-md-" + current_grid_no;
		
	 var new_grid_no ;
	 var new_class="col-md-";
	 	if(parseInt(current_grid_no)<=12) {

	 		 new_grid_no = parseInt(current_grid_no)-1;
			
			 
			if(new_grid_no<1)
				new_grid_no = 1
				
				 element_size.val( new_grid_no);
			new_class +=   new_grid_no;
		}
			var status_colum = $(this).parents('.img').children("span");// pa;// pa
			$(status_colum).html(new_grid_no+"/12");
		//console.log(new_class);
		parent_element.removeClass(current_class).addClass(new_class);
		
	});
	
		$(".layout_plus").live('click',function(e){
		
			e.preventDefault();
			var parent_element = $(this).parents('.first_box');
			var element_size = parent_element.children('.inner_row').children(".size");// pa
			 
			 var current_grid_no  =  element_size.val();
			
			 var current_class =  "col-md-" + current_grid_no;
		
		//console.log(current_grid_no);
	 var new_grid_no ;
	 var new_class="col-md-";

	 //now we need to find the total grid

	 var total_parent_column = $(this).parents('.row_menu').children('.first_box');

	 
	 var total_column_grid=0;

		//console.log(total_column_grid);
		
		 	if(parseInt(current_grid_no)>=1 || parseInt(current_grid_no)<=12) {

		 		new_grid_no = parseInt(current_grid_no)+1;
		

			$( total_parent_column).each(function( index ) {
				total_column_grid += parseInt($( this ).children('.inner_row').children(".size").val());

			});
		if(parseInt(total_column_grid)<=12){

				if(new_grid_no>12)
					new_grid_no = 12
				
				element_size.val( new_grid_no);
				
					
				new_class +=   new_grid_no;

		var status_colum = $(this).parents('.img').children("span");// pa;// pa
			
		$(status_colum).html(new_grid_no+"/12");
		//console.log(new_class);
		parent_element.removeClass(current_class).addClass(new_class);

		 
		}else{

			alert("total grid must withing 12 grid");
			 
		}
	}

	});
	
});
</script>

            {/if}
    
        {if $input.type == 'id_parent_hidden'}
            {if isset($input.saved) && !empty($input.saved)}
                
                {$id_parent = $input.saved}            
            {else}
                    {$id_parent = 0}
            {/if}
            <div class="hide">
                <input type="hidden" name="{$input.name}" id="{$input.name}" value="{$id_parent}">
            </div>

        {elseif $input.type == 'links_block'} 

            <script type="text/javascript">        
            $(function(){

                function hideElem(elem){

                    elem.hide(300);
                }
                function showElem(elem){
                    elem.show(300);
                }
                var parentElem = $('[name="link_type"]');

                parentElem.on('change',function(){
                    var child = $('.link_'+$(this).children('option:selected').val());
                    
                    hideElem($('[class^="link_"]').not('[name="'+$(this).attr('name')+'"]'));
                    hideElem($('ul#link_CAT').parents('.form-group'));
                    
                    if($(this).children('option:selected').val() == 'CAT'){                    
                        showElem($('ul#link_CAT').parents('.form-group'));
                    }else
                        showElem(child);

                });
                parentElem.trigger('change');

            });
            </script>
            <div class="link_LNK">
                <input type="text" class="fixed-width-xl" name="link_LNK" id="link_LNK" value="{if isset($input.saved.link)}{$input.saved.link}{/if}" />            
            </div>
            
            {if isset($input.options.PRD_GRP) && !empty($input.options.PRD_GRP)}
                <div class="link_PRD_GRP">

                <select name="link_PRD_GRP_select" class=" fixed-width-xl" id="link_PRD_GRP_select" multiple="true">
                    {foreach $input.options.PRD_GRP as $catkey=>$catname}
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>
                <input type="hidden" name="link_PRD_GRP" id="link_PRD_GRP" value="{$input.saved.link}" />
                <script type="text/javascript">
                    $(function(){
                        var defVal = $('input#link_PRD_GRP').val();
                        if(defVal.length){
                            var ValArr = defVal.split(',');
                            for(var n in ValArr){                                
                                $( "select#link_PRD_GRP_select" ).children('option[value="'+ValArr[n]+'"]').attr('selected','selected');
                            }
                        }
                        $( "select#link_PRD_GRP_select" ).select2( { placeholder: "{l s='Select Products' mod='smartmegamenu'}", width: 200, tokenSeparators: [',', ' '] } ).on('change',function(){
                            var data = $(this).select2('data');
                            var select = $(this);
                            var field = select.next('input#link_PRD_GRP');
                            var saved = '';
                            select.children('option').attr('selected',null);

                            if(data.length)
                                $.each(data, function(k,v){
                                    var selected = v.id;   
                                    select.children('option[value="'+selected+'"]').attr('selected','selected');
                                    if(k > 0)
                                        saved += ',';
                                    saved += selected;                                
                                });
                             field.val(saved);   
                        });
                    });
                </script>
                </div>
            {/if}        
            {if !empty($input.options.PRD)}
                <div class="link_PRD">

                <select name="link_PRD" class=" fixed-width-xl" id="link_PRD">
                    {foreach $input.options.PRD as $catkey=>$catname}
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>
                
                </div>
            {/if}        
            {if !empty($input.options.CMS_PAGE)}
                <div class="link_CMS_PAGE">            
                <select name="link_CMS_PAGE" class=" fixed-width-xl" id="link_CMS_PAGE">
                    {foreach $input.options.CMS_PAGE as $catkey=>$catname}                    
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>            
                </div>
            {/if}
            
            {if !empty($input.options.CMS_CAT)}
                <div class="link_CMS_CAT">            
                <select name="link_CMS_CAT" class=" fixed-width-xl" id="link_CMS_CAT">
                    {foreach $input.options.CMS_CAT as $catkey=>$catname}                    
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>            
                </div>
            {/if}
            
            {if !empty($input.options.MAN)}
                <div class="link_MAN">            
                <select name="link_MAN" class=" fixed-width-xl" id="link_MAN">
                    {foreach $input.options.MAN as $catkey=>$catname}                    
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>            
                </div>
            {/if}
            
            {if !empty($input.options.SUP)}
                <div class="link_SUP">            
                <select name="link_MAN" class=" fixed-width-xl" id="link_SUP">
                    {foreach $input.options.SUP as $catkey=>$catname}                    
                        {$selected = ''}
                        {if isset($input.saved.link) && $input.saved.link == $catkey}
                            {$selected = 'selected'}
                        {/if}
                        <option {$selected} value="{$catkey}">{$catname}</option>
                    {/foreach}
                </select>            
                </div>
            {/if}




        {else}
            {if isset($input.parent)}
            <script type="text/javascript">

            $(function(){
                function hideElem(elem){

                    elem = elem.parents('div.form-group');

                    if(elem.hasClass("translatable-field")){                   
                        elem = elem.parents('div.form-group');
                    }

                    elem.hide(300);
                }
                function showElem(elem){
                    elem = elem.parents('div.form-group');

                    if(elem.hasClass("translatable-field")){
                        elem = elem.parents('div.form-group');
                    }

                    elem.show(300);
                }
                function getElemLang(elemname){
                    var felem = $('[name="'+elemname+'"]');
                    if(felem.length < 1){
                        if($('[name="'+elemname+'_{$languages[0].id_lang}"]').length > 0)
                        return elemname+'_{$languages[0].id_lang}';
                    }
                    return elemname;
                }

                if($('[name="{$input.parent}"]:checked').val() == 1){
                    showElem($('.{$input.parent}_child'));
                }else
                    hideElem( $('.{$input.parent}_child'));

                $('[name="{$input.parent}"]').on('change',function(){
                    if($(this).is(':checked') && $(this).val() == 1){
                        showElem($('.{$input.parent}_child'));
                    }else{
                       hideElem( $('.{$input.parent}_child'));
                    }
                });
                {if isset($input.parent1)}
                    var parent1 = $('[name="{$input.parent1}"]');
                    if(parent1.children('option:selected').val() == '{$input.parent1_active_value}'){
                        showElem($('[name="'+getElemLang('{$input.name}')+'"]'));
                    }else
                        hideElem($('[name="'+getElemLang('{$input.name}')+'"]'));

                    parent1.on('change',function(){

                        if($(this).children('option:selected').val() == '{$input.parent1_active_value}'){                
                            showElem($('[name="'+getElemLang('{$input.name}')+'"]'));
                        }else{
                            hideElem($('[name="'+getElemLang('{$input.name}')+'"]'));

                        }
                    });

                {/if}

            });
            </script>


            <div class="{$input.parent}_child">
                {$smarty.block.parent}
                </div>
                {else}
            {$smarty.block.parent}
                {/if}
        {/if}

{/block}
   

      