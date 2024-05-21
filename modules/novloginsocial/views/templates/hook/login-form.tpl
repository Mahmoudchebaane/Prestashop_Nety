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

{block name='login_form'}

  {block name='login_form_errors'}
    <div class="row no-gutters">
      <div class="col-md-10 offset-md-2">
        {include file='_partials/form-errors.tpl' errors=$errors['']}
      </div>
    </div>
  {/block}

  <form class="login-form-popup" action="{block name='login_form_actionurl'}{$action}{/block}" method="post">

    <section>
      {block name='login_form_fields'}
        {foreach from=$formFields item="field"}
          {block name='form_field'}
            {form_field field=$field}
          {/block}
        {/foreach}
      {/block}
      <div class="forgot-password mt-25 mb-25">
        <i class="zmdi zmdi-email"></i>&nbsp;
        {l s='Forgot your' d='Shop.Theme.Customeraccount'}&nbsp;
        <a href="{$urls.pages.password}" rel="nofollow">
          <span>{l s='Password' d='Shop.Theme.Customeraccount'}</span>&nbsp;?
        </a>
      </div>
    </section>

    {block name='login_form_footer'}
      <footer class="form-footer clearfix">
        <div class="row no-gutters">
          <div class="col-md-10 offset-md-2">
            <input type="hidden" name="submitLogin" value="1">
            {block name='form_buttons'}
              <button class="btn btn-primary" data-link-action="sign-in" type="submit" class="form-control-submit">
                {l s='Login' d='Shop.Theme.Actions'}
              </button>
            {/block}
          </div>
        </div>
      </footer>
    {/block}

  </form>
{/block}