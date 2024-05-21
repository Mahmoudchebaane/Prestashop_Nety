{*/******************
 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package    novtestimonials
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) May 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/
*}
<div class="panel"><h3><i class="icon-list-ul"></i> {l s='Testimonialss list' mod='novtestimonials'}
	<span class="panel-heading-action">
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure=novtestimonials&addTestimonials=1">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
				<i class="process-icon-new "></i>
			</span>
		</a>
	</span>
	</h3>
	<div id="testimonialsContent">
		<div id="testimonials">
			{foreach from=$testimonials item=testimonial}
				<div id="testimonials_{$testimonial.id_novtestimonials}" class="panel">
					<div class="row">
						<div class="col-lg-1">
							<span><i class="icon-arrows "></i></span>
						</div>
						<div class="col-md-3">
							{$testimonial.name}
						</div>
						<div class="col-md-3">
							<img src="{$image_baseurl}{$testimonial.image}" alt="" class="img-thumbnail" />
						</div>
						<div class="col-md-5">
							<h4 class="pull-left">
								#{$testimonial.id_novtestimonials} 
								{if $testimonial.is_shared}
									<div>
										<span class="label color_field pull-left" style="background-color:#108510;color:white;margin-top:5px;">
											{l s='Shared testimonial' mod='novtestimonials'}
										</span>
									</div>
								{/if}
							</h4>
							<div class="btn-group-action pull-right">
								{$testimonial.status}
								
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=novtestimonials&id_novtestimonials={$testimonial.id_novtestimonials}">
									<i class="icon-edit"></i>
									{l s='Edit' mod='novtestimonials'}
								</a>
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=novtestimonials&delete_id_novtestimonials={$testimonial.id_novtestimonials}">
									<i class="icon-trash"></i>
									{l s='Delete' mod='novtestimonials'}
								</a>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>
</div>