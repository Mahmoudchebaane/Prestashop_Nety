<?php
/******************
 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package    novtestimonials
 * @version    1.0
 * @author    http://vinovathemes.com/
 * @copyright  Copyright (C) May 2017 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 * *****************/
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('novtestimonials.php');

$context = Context::getContext();
$home_testimonialr = new novtestimonials();
$testimonials = array();

if (!Tools::isSubmit('secure_key') || Tools::getValue('secure_key') != $home_testimonialr->secure_key || !Tools::getValue('action'))
	die(1);

if (Tools::getValue('action') == 'updateTestimonialssPosition' && Tools::getValue('testimonials'))
{

	$testimonials = Tools::getValue('testimonials');

	foreach ($testimonials as $position => $id_novtestimonials)
	{
		$res = Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'novtestimonials` SET `position` = '.(int)$position.'
			WHERE `id_novtestimonials` = '.(int)$id_novtestimonials
		);

	}

	$home_testimonialr->clearCache();
}