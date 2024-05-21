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

{extends file='page.tpl'}

{block name='page_content'}
    {if isset($message)}
    <h1 class="h1 page-title"><span>{l s='Problem with login' mod='novloginsocial'}</span></h1>
    <p class="alert alert-warning">{l s='There is some problem with login. Please use traditional login/registration' mod='novloginsocial'}</p>
    {else}
        {if $popup}
            <script type="text/javascript">
                {literal}
                    window.opener.location.reload();
                    self.close();
                {/literal}
            </script>
        {/if}
    {/if}
{/block}

