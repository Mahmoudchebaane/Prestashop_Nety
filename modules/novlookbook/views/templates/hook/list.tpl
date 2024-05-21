{*
 * Vinova Themes Framework for Prestashop 1.6.x
 * @author      http://vinovathemes.com/
 * @copyright   Copyright (C) October 2017 vinovathemes.com <@email:vinovathemes@gmail.com>
 * @license   GNU General Public License version 1
 * @version     1.0
 * @package     novlookbook
 * <info@vinovathemes.com>.All rights reserved.
*}

<div class="panel"><h3><i class="icon-list-ul"></i> {l s='Lookbook list' d='Modules.Imageslider.Admin'}
	<span class="panel-heading-action">
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure=novlookbook&addSlide=1">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add new' d='Admin.Actions'}" data-placement="left" data-html="true">
				<i class="process-icon-new "></i>
			</span>
		</a>
	</span>
	</h3>
	<div id="slidesContent">
		<div id="slides">
			{foreach from=$slides item=slide}
				<div id="slides_{$slide.id_slide}" class="panel">
					<div class="row">
						<div class="col-lg-1">
							<span><i class="icon-arrows "></i></span>
						</div>
						<div class="col-md-2">
							<img src="{$image_baseurl}{$slide.image}" alt="{$slide.title}" class="img-thumbnail" />
						</div>
						<div class="col-md-9">
							<h4 class="pull-left">
								#{$slide.id_slide} - {$slide.title}
							</h4>
							<div class="btn-group-action pull-right">
								{$slide.status}

								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=novlookbook&id_slide={$slide.id_slide}">
									<i class="icon-edit"></i>
									{l s='Edit' d='Admin.Actions'}
								</a>
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=novlookbook&delete_id_slide={$slide.id_slide}">
									<i class="icon-trash"></i>
									{l s='Delete' d='Admin.Actions'}
								</a>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>
</div>
