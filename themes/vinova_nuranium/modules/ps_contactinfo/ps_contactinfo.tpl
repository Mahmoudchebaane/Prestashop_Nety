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
* @author PrestaShop SA <contact@prestashop.com>
  * @copyright 2007-2015 PrestaShop SA
  * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}

  <div class="block-contact">
    {if $novconfig.novthemeconfig_contact_phone}
    <div class="phone d-flex align-items-center">
      <span class="icon_info">
        <i class="icon_phone"></i>
      </span>
      <div>
        {* [1][/1] is for a HTML tag. *}
        <p class="text">{l s='Call Customer Services, We Support 24/7' d='Modules.Contactinfo' } :</p>
        <span class="font-weight-bold contact_phone">{$novconfig.novthemeconfig_contact_phone}</span>
      </div>
    </div>
    {/if}
    {if $novconfig.novthemeconfig_contact_address}
    <div class="address d-flex align-items-center">
      <span class="icon_info">
        <i class="icon_address"></i>
      </span>
      <div>
        <p class="font-weight-bold title_contact">{l s='Address' d='Modules.Contactinfo' } :</p>
        <p class="text">{$novconfig.novthemeconfig_contact_address}</p>
      </div>
    </div>
    {/if}
    {if $novconfig.novthemeconfig_contact_address_2}
    <div class="address d-flex align-items-center">
      <span class="icon_info">
        <i class="icon_address"></i>
      </span>
      <div>
        <p class="font-weight-bold title_contact">{l s='Address2' d='Modules.Contactinfo' } :</p>
        <p class="text">{$novconfig.novthemeconfig_contact_address_2}</p>
      </div>
    </div>
    {/if}
    {if $novconfig.novthemeconfig_contact_email}
    <div class="email d-flex align-items-center">
      <span class="icon_info">
        <i class="icon_email"></i>
      </span>
      <div>
        <p class="font-weight-bold title_contact">{l s='Email' d='Modules.Contactinfo' } :</p>
        <p class="text">{$novconfig.novthemeconfig_contact_email}</p>
      </div>
    </div>
    {/if}

    {if $contact_infos.fax}
    <div class="fax d-flex">
      <span class="icon_info">
        <i class="fa fa-fax"></i>
      </span>
      {* [1][/1] is for a HTML tag. *}
      <div>{l s='Fax: [1]%fax%[/1]' sprintf=[ '[1]' => '<span>', '[/1]' => '</span>', '%fax%' => $contact_infos.fax ]
        d='Modules.Contactinfo' }</div>
    </div>
    {/if}
  </div>