{*
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
*}

{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'file_image'}
		<div class="row">
				<div class="col-lg-9">
					{if isset($fields[0]['form']['images'])}
					<div id="LookbookImageBlock">
						<img id="LookbookImage" src="{$image_baseurl}{$fields[0]['form']['images']}" class="img-thumbnail" />
					</div>
					{/if}
					<div class="dummyfile input-group">
						<input id="{$input.name}" type="file" name="{$input.name}" class="hide-file-upload" />
						<span class="input-group-addon"><i class="icon-file"></i></span>
						<input id="{$input.name}-name" type="text" class="disabled" name="filename" readonly />
						<span class="input-group-btn">
							<button id="{$input.name}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
								<i class="icon-folder-open"></i> {l s='Choose a file' mod='novlookbook'}
							</button>
						</span>
					</div>
				</div>
				<script>
				$(document).ready(function(){
					$('#{$input.name}-selectbutton').click(function(e){
						$('#{$input.name}').trigger('click');
					});
					$('#{$input.name}').change(function(e){
						var val = $(this).val();
						var file = val.split(/[\\/]/);
						$('#{$input.name}-name').val(file[file.length-1]);
					});
				});
				</script>
				{if isset($fields[0]['form']['id']) && $fields[0]['form']['id']}
                <input type="hidden" name="slide_id" value="{$fields[0]['form']['id']}" />
                <input type="hidden" name="hotsposts" value="">
				<script type="application/javascript">
					{literal}
					var annotate;
					var response;
					var relative_url = "{/literal}{$fields[0]['form']['get_site_url']}{literal}";
					function InitHotspotBtn() {
						if (jQuery("img#LookbookImage")) {
							var annotObj = jQuery("img#LookbookImage").annotateImage({
								editable: true,
								useAjax: false,
								interdict_areas_overlap: true,
								captions: {"add_btn":"Pin","cancel_btn":"Cancel","delete_btn":"Delete","note_saving_err":"An error occurred saving this hotspot.","note_overlap_err":"Areas should not overlap.","link_text":"Link text","link_href":"Link url","enter_text_err":"Please, enter link text","enter_href_err":"Please, enter link url","link_required_err":"Please, enter link text and link url (with http://)","enter_sku_err":"Please, enter product ID","select_link_type_err":"Please, select link type","prod_dont_exists_err":"The product : ","prod_sku":"Product(post,page) ID:","delete_note_err":"An error occurred deleting this hotspot.","product_page":"Product","other_page":"External"},
								notes: {/literal}{($fields[0]['form']['hotsposts']) ? $fields[0]['form']['hotsposts'] : '[]'}{literal},
								input_field_id: "hotspots"
							});

							var top = Math.round(jQuery("img#LookbookImage").height()/2);
							jQuery(".image-annotate-canvas").append('<div class="hotspots-msg" style="top:' + top + 'px;">Rollover on the image to see hotspots</div>');

							jQuery(".image-annotate-canvas").hover(
								function () {
									ShowHideHotspotsMsg();
								},
								function () {
									ShowHideHotspotsMsg();
								}
							);

							return annotObj;
						}
						else
						{
							return false;
						}
					};

					function save_notes() {
						var notes_obj = JSON.stringify(annotate.notes);
						jQuery("input[name='hotsposts']").val(notes_obj);
						return true;
					}

					jQuery(document).ready(function() {
						annotate = InitHotspotBtn();

						$('.module_form_submit_btn').click(function(e){
							return save_notes();
						});

					});

					{/literal}
				</script>
				{/if}
		</div>
	{/if}
	{$smarty.block.parent}
{/block}