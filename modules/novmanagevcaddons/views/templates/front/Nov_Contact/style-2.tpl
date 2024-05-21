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

<div class="nov_contact style-2{if !empty($el_class)}{$el_class}{/if}">
	{if !empty($nov_address)}<div class="address d-flex align-items-center"><span class="icon_contact"><i class="novicon_address"></i></span><span>{$nov_address}</span></div>{/if}
	{if !empty($nov_phone)}<div class="phone d-flex align-items-center"><span class="icon_contact"><i class="novicon_phone"></i></span><span>{$nov_phone}</span></div>{/if}
	{if !empty($nov_email)}<div class="email d-flex align-items-center"><span class="icon_contact"><i class="novicon_email"></i></span><span>{$nov_email}</span></div>{/if}
	{if !empty($nov_open)}<div class="open d-flex align-items-center"><span class="icon_contact"><i class="novicon_open"></i></span><span>{$nov_open}</span></div>{/if}
</div>