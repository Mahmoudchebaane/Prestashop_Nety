{extends file='checkout/_partials/steps/checkout-step.tpl'}

{block name='step_content'}

  {if !$customer.is_logged}
    <ul class="nav nav-inline m-y-2">
      <li class="nav-item">
        <a class="nav-link {if !$show_login_form}active{/if}" data-toggle="tab" href="#checkout-guest-form" role="tab">
          {if $guest_allowed}
            {l s='New customer' d='Shop.Theme.Checkout'}
          {else}
            {l s='Create an account' d='Shop.Theme.Customeraccount'}
          {/if}
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {if $show_login_form}active{/if}" data-link-action="show-login-form" data-toggle="tab"
          href="#checkout-login-form" role="tab">
          {l s='Already a customer? Log in' d='Shop.Theme.Actions'}
        </a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane {if !$show_login_form}active{/if}" id="checkout-guest-form" role="tabpanel">
        {render file='checkout/_partials/customer-form.tpl' ui=$register_form guest_allowed=$guest_allowed}
      </div>
      <div class="tab-pane {if $show_login_form}active{/if}" id="checkout-login-form" role="tabpanel">
        <div class="block-form-login">
          {hook h='displayLoginSocialAnywhere'}
          <p class="text-center mb-15 d-none">{l s='Or Insert your account information:' d='Shop.Theme.Checkout'}</p>
          {render file='checkout/_partials/login-form.tpl' ui=$login_form}
        </div>
      </div>
    </div>
  {else}
    <div class="m-y-2">
      <span>
        {l s='Connected as' d='Shop.Theme.Checkout'}&nbsp;
        <a class="account" href="{$urls.pages.my_account}" rel="nofollow"
          title="{l s='Log me out' d='Shop.Theme.Customeraccount'}">{$customer.firstname}&nbsp;{$customer.lastname}</a>
      </span>
      <br>
      <span>
        {l s='It is not you?' d='Shop.Theme.Checkout'}
        <a class="logout" href="{$urls.actions.logout}" rel="nofollow"
          title="{l s='Log me out' d='Shop.Theme.Customeraccount'}">
          {l s='log out' d='Shop.Theme.Actions'}</a>
        </a>
      </span>
    </div>
  {/if}
{/block}