{**
 * 2007-2019 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
*}

{if $novconfig.novthemeconfig_social_in_footer == 1}
    <div class="social list-social nov-socials">
        <ul class="list-unstyled mb-0 p-0">
            {if isset($novconfig.novthemeconfig_social_facebook) && $novconfig.novthemeconfig_social_facebook}
            <li class="social_facebook"><a href="{$novconfig.novthemeconfig_social_facebook}" target="_blank"><span>Facebook</span><i class="fa fa-facebook"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_twitter) && $novconfig.novthemeconfig_social_twitter}
            <li class="social_twitter"><a href="{$novconfig.novthemeconfig_social_twitter}" target="_blank"><span>Twitter</span><i class="fa fa-twitter"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_youtube) && $novconfig.novthemeconfig_social_youtube}
            <li class="social_youtube"><a href="{$novconfig.novthemeconfig_social_youtube}" target="_blank"><span>Youtube</span><i class="fa fa-youtube-play"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_google) && $novconfig.novthemeconfig_social_google}
            <li class="social_google"><a href="{$novconfig.novthemeconfig_social_google}" target="_blank"><span>Google</span><i class="fa fa-google-plus"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_dribbble) && $novconfig.novthemeconfig_social_dribbble}
            <li class="social_dribbble"><a href="{$novconfig.novthemeconfig_social_dribbble}" target="_blank"><span>Dribbble</span><i class="fa fa-dribbble"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_instagram) && $novconfig.novthemeconfig_social_instagram}
            <li class="social_instagram"><a href="{$novconfig.novthemeconfig_social_instagram}" target="_blank"><span>Instagram</span><i class="fa fa-instagram"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_flickr) && $novconfig.novthemeconfig_social_flickr}
            <li class="social_flickr"><a href="{$novconfig.novthemeconfig_social_flickr}" target="_blank"><span>Flickr</span><i class="fa fa-flickr"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_pinterest) && $novconfig.novthemeconfig_social_pinterest}
            <li class="social_pinterest"><a href="{$novconfig.novthemeconfig_social_pinterest}" target="_blank"><span>Pinterest</span><i class="fa fa-pinterest"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_linkedIn) && $novconfig.novthemeconfig_social_linkedIn}
            <li class="social_linkedin"><a href="{$novconfig.novthemeconfig_social_linkedIn}" target="_blank"><span>Linkedin</span><i class="fa fa-linkedin"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_skype) && $novconfig.novthemeconfig_social_skype}
            <li class="social_skype"><a href="{$novconfig.novthemeconfig_social_skype}" target="_blank"><span>Skype</span><i class="fa fa-skype"></i></a></li>
            {/if}
            {if isset($novconfig.novthemeconfig_social_vimeo) && $novconfig.novthemeconfig_social_vimeo}
            <li class="social_vimeo"><a href="{$novconfig.novthemeconfig_social_vimeo}" target="_blank"><span>Vimeo</span><i class="fa fa-vimeo"></i></a></li>
            {/if}
        </ul>
    </div>
{/if}