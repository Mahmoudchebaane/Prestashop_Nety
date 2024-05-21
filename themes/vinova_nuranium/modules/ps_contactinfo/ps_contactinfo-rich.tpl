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
  {if $novconfig.novthemeconfig_contact_layout == '1'}
  <div class="contact-rich">
    {if $novconfig.novthemeconfig_contact_phone}
    <div class="block d-flex align-self-stretch">
      <div class="icon_phone"></div>
      <div class="data">
        <div class="title_contact_rich mb-5">{l s='Call Customer Services ' d='Modules.Contactinfo'}:</div>
        <div class="">
          <a class="phone_number"
            href="tel:{$novconfig.novthemeconfig_contact_phone}">{$novconfig.novthemeconfig_contact_phone}</a>
          {if $novconfig.novthemeconfig_contact_phone_2}
          <a class="phone_number"
            href="tel:{$novconfig.novthemeconfig_contact_phone_2}">&nbsp;-&nbsp;{$novconfig.novthemeconfig_contact_phone_2}</a>
          {/if}
        </div>
      </div>
    </div>
    {/if}
    <div class="block mt-30 d-flex align-self-stretch">
      <div class="icon_address"></div>
      <div class="data">
        <div class="title_contact_rich">{l s='Address' d='Modules.Contactinfo'}:</div>
        <div class="block-content">{$novconfig.novthemeconfig_contact_address nofilter}</div>
      </div>
    </div>
    {if $novconfig.novthemeconfig_contact_email}
    <div class="block d-flex align-self-stretch email mt-35">
      <div class="icon_email"></div>
      <div class="data">
        <div class="title_contact_rich">{l s='Email' d='Modules.Contactinfo'}:</div>
        <div class="block-content">
          <a href="mailto:{$novconfig.novthemeconfig_contact_email}">{$novconfig.novthemeconfig_contact_email}</a>
          {if $novconfig.novthemeconfig_contact_email_2}
          &nbsp;-&nbsp;<a
            href="mailto:{$novconfig.novthemeconfig_contact_email_2}">{$novconfig.novthemeconfig_contact_email_2}</a>
          {/if}
        </div>
      </div>
    </div>
    {/if}
  </div>
  {else}
  <div class="contact-rich row no-fullwidth">
    {if $novconfig.novthemeconfig_contact_phone}
    <div class="block d-flex align-self-stretch col-md-4">
      <div class="icon_phone"></div>
      <div class="data">
        <div class="title_contact_rich mb-5">{l s='Call Customer Services ' d='Modules.Contactinfo'}:</div>
        <div class="">
          <a class="phone_number"
            href="tel:{$novconfig.novthemeconfig_contact_phone}">{$novconfig.novthemeconfig_contact_phone}</a>
          {if $novconfig.novthemeconfig_contact_phone_2}
          <a class="phone_number"
            href="tel:{$novconfig.novthemeconfig_contact_phone_2}">&nbsp;-&nbsp;{$novconfig.novthemeconfig_contact_phone_2}</a>
          {/if}
        </div>
      </div>
    </div>
    {/if}
    <div class="block d-flex align-self-stretch col-md-4">
      <div class="icon_address"></div>
      <div class="data">
        <div class="title_contact_rich">{l s='Address' d='Modules.Contactinfo'}:</div>
        <div class="block-content">{$novconfig.novthemeconfig_contact_address nofilter}</div>
      </div>
    </div>
    {if $novconfig.novthemeconfig_contact_email}
    <div class="block d-flex align-self-stretch email col-md-4">
      <div class="icon_email"></div>
      <div class="data">
        <div class="title_contact_rich">{l s='Email' d='Modules.Contactinfo'}:</div>
        <div class="block-content">
          <a href="mailto:{$novconfig.novthemeconfig_contact_email}">{$novconfig.novthemeconfig_contact_email}</a>
          {if $novconfig.novthemeconfig_contact_email_2}
          &nbsp;-&nbsp;<a
            href="mailto:{$novconfig.novthemeconfig_contact_email_2}">{$novconfig.novthemeconfig_contact_email_2}</a>
          {/if}
        </div>
      </div>
    </div>
    {/if}
  </div>
  {/if}