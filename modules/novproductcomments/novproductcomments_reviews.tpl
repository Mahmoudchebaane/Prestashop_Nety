 {*
/******************

 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package   	novblockwishlist
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 
 * *****************/
*}
<div class="product-comments">	
	<div class="star_content">
	{section name="i" start=0 loop=5 step=1}
		{if $averageTotal le $smarty.section.i.index}
			<div class="star"></div>
		{else}
			<div class="star star_on"></div>
		{/if}
	{/section}
	</div>
	<span>{l s='%s Reviews'|sprintf:$averageTotal mod='novproductcomments'}</span>
</div>