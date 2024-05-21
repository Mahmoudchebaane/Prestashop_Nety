/******************
 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package    novtestimonials
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) May 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/

$(document).ready(function(){

	if (typeof(novtestimonials_speed) == 'undefined')
		novtestimonials_speed = 500;
	if (typeof(novtestimonials_pause) == 'undefined')
		novtestimonials_pause = 3000;
	if (typeof(novtestimonials_loop) == 'undefined')
		novtestimonials_loop = true;
    if (typeof(novtestimonials_width) == 'undefined')
        novtestimonials_width = 779;


	if (!!$.prototype.bxTestimonialsr)
		$('#novtestimonials').bxTestimonialsr({
			useCSS: false,
			maxTestimonialss: 1,
			testimonialWidth: novtestimonials_width,
			infiniteLoop: novtestimonials_loop,
			hideControlOnEnd: true,
			pager: false,
			autoHover: true,
			auto: novtestimonials_loop,
			speed: parseInt(novtestimonials_speed),
			pause: novtestimonials_pause,
			controls: true
		});

    $('.novtestimonials-description').click(function () {
        window.location.href = $(this).prev('a').prop('href');
    });

	if ($('#htmlcontent_top').length > 0)
		$('#homepage-testimonialr').addClass('col-xs-8');
	else
		$('#homepage-testimonialr').addClass('col-xs-12');
});