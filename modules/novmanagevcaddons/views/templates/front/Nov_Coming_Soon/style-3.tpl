{*
/******************
 * Vinova Themes Framework for Prestashop 1.7.x
 * @package    novmanagevcaddons
 * @version    1.0.0
 * @author     http://vinovathemes.com/
 * @copyright  Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <vinovathemes@gmail.com>.All rights reserved.
 * @license    GNU General Public License version 1
 * *****************/
*}

<div class="nov-coming-soon style-3">
	<div class="row flex-xl-row-reverse no-gutters h-100">
		<div class="col-xl-6"><div class="image_animate h-100">{$img nofilter}</div></div>
		<div class="col-xl-6 d-flex justify-content-xl-end align-items-xl-center mt-lg-30 pl-lg-70 pl-xs-30">
			<div>
				<div class="title_1">{$title_1}</div>
				<div class="title_2 mb-5">{$title_2}</div>
				<div class="des">{$description nofilter}</div>
				<div class="comingsoon d-flex position-static text-center"
				data-date="{$date|date_format:'%Y/%m/%d'}"
				data-days="{l s='Days' d='Shop.Theme.Comingsoon'}"
				data-hours="{l s='Hours' d='Shop.Theme.Comingsoon'}"
				data-min="{l s='Minutes' d='Shop.Theme.Comingsoon'}"
				data-seconds="{l s='Seconds' d='Shop.Theme.Comingsoon'}">
				</div>
				<div class="d-flex">
					<div class="nov-btn type-1">
						<a href="">Pre-Order Now</a>
					</div>
					<div class="nov-btn type-2">
						<a href="">Pre-Order Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>