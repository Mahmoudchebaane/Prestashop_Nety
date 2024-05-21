 {*
/******************

 * Vinova Themes  Framework for Prestashop 1.7.x 
 * @package   	novblockcomments
 * @version   	1.0
 * @author   	http://vinovathemes.com/
 * @copyright 	Copyright (C) October 2013 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <info@vinovathemes.com>.All rights reserved.
 * @license   GNU General Public License version 1
 
 * *****************/
*}

{if ( (($nbComments == 0 && $too_early == false && ($logged || $allow_guests)) || ($nbComments != 0)))}
<div id="product_comments_block_extra">
	{if $nbComments != 0}
	<div class="comments_note">
		<span>{l s='Review' mod='novproductcomments'}: </span>
		<div class="star_content clearfix">
		{section name="i" start=0 loop=5 step=1}
			{if $averageTotal le $smarty.section.i.index}
				<div class="star"></div>
			{else}
				<div class="star star_on"></div>
			{/if}
		{/section}
		</div>
	</div>
	{/if}

	<div class="comments_advices">
		{if $nbComments != 0}
		<a href="#" class="comments_advices_tab"><i class="fa fa-comments"></i>{l s='Read reviews' mod='novproductcomments'} ({$nbComments})</a>
		{/if}
		{if ($too_early == false AND ($logged OR $allow_guests))}
		<a class="open-comment-form" data-toggle="modal" data-target="#new_comment_form" href="#"><i class="fa fa-edit"></i>{l s='Write a review' mod='novproductcomments'}</a>
		{/if}
	</div>
</div>
{/if}
<!--  /Module NovProductComments -->
