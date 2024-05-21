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

{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="nov_contact block-contact style-3{if !empty($el_class)}{$el_class}{/if}">
  {if !empty($nov_phone)}
  <div class="phone d-flex align-items-center">
    <span class="icon_info">
    <i class="icon_phone"></i>
    </span>
    <div>
      <p class="title_contact">{l s='Call Us Now' mod='novmanagevcaddons' } :</p>
      <span class="font-weight-bold contact_phone">{$nov_phone}</span>
    </div>
  </div>
  {/if}
  {if !empty($nov_address)}
  <div class="address d-flex align-items-center">
    <span class="icon_info">
    <i class="icon_address"></i>
    </span>
    <div>
    <p class="font-weight-bold title_contact">{l s='Address' mod='novmanagevcaddons' } :</p> 
    <p class="text">{$nov_address}</p>
    </div>
  </div>
  {/if}
  {if !empty($nov_email)}
  <div class="email d-flex align-items-center">
    <span class="icon_info">
    <i class="icon_email"></i>
    </span>
    <div>
    <p class="font-weight-bold title_contact">{l s='Email' mod='novmanagevcaddons' } :</p>
    <p class="text">{$nov_email}</p>
    </div>
  </div>
  {/if}
</div>