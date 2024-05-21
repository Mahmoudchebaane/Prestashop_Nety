{*
/******************
 * Vinova Login Social for Prestashop 1.7.x 
 * @package    novloginsocial
 * @version    1.0.0
 * @author     Vinovathemes
 * @copyright  Copyright (C) May 2019 vinovathemes.com <@emai:vinovathemes@gmail.com>
 * <vinovathemes@gmail.com>.All rights reserved.
 * @license    GNU General Public License version 1
 * *****************/
*}

{if $facebook_status || $google_status || $twitter_status}
<div class="block-sociallogin text-center">
    <div class="title_sociallogin">{l s='Login using social network' mod='novloginsocial'}:</div>
    <div class="content_sociallogin">
        {if $facebook_status}
            <a {if $type_social}
                    onclick="SocialPopup('{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'facebook', 'page' => $page]}')"
                {else}
                    href="{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'facebook', 'page' => $page]}"
                {/if}
               class="btn btn-sociallogin-facebook">
                <i class="zmdi zmdi-facebook"></i>
                {l s='Facebook' mod='novloginsocial'}
            </a>
        {/if}

        {if $twitter_status}
            <a {if $type_social}
                    onclick="SocialPopup('{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'twitter', 'page' => $page]}')"
                {else}
                    href="{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'twitter', 'page' => $page]}"
                {/if}
               class="btn btn-sociallogin-twitter">
                <i class="zmdi zmdi-twitter"></i>
                {l s='Twitter' mod='novloginsocial'}
            </a>
        {/if}

        {if $google_status}
            <a {if $type_social}
                    onclick="SocialPopup('{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'google', 'page' => $page]}')"
                {else}
                    href="{url entity='module' name='novloginsocial' controller='authenticate' params=['provider' => 'google', 'page' => $page]}"
                {/if}
               class="btn btn-sociallogin-google">
                <i class="zmdi zmdi-google-old"></i>
                {l s='Google' mod='novloginsocial'}
            </a>
        {/if}
    </div>
</div>
{/if}