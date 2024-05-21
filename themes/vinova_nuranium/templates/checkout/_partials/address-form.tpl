{extends file='customer/_partials/address-form.tpl'}

{block name='form_field'}
  
    {$smarty.block.parent}

{/block}

{block name='form_fields' append}
  <input type="hidden" name="saveAddress" value="{$type}">
  {if $type === "delivery"}
    <div class="form-group row">
      <div class="col-md-10 offset-md-2">
        <input name="use_same_address" type="checkbox" value="1" {if $use_same_address} checked {/if}>
        <label>{l s='Use this address for invoice too' d='Shop.Theme.Checkout'}</label>
      </div>
    </div>
  {/if}
  
{/block}

{block name='form_buttons'}
  {if !$form_has_continue_button}
    <a class="js-cancel-address cancel-address pull-xs-right"
    href="{url entity='order' params=['cancelAddress' => {$type}]}">{l s='Cancel' d='Shop.Theme.Actions'}</a>
    <button type="submit" class="continue btn btn-primary pull-xs-right">{l s='Save' d='Shop.Theme.Actions'}</button>   
  {else}
    <form>
      {if $customer.addresses|count > 0}
        <a class="js-cancel-address cancel-address pull-xs-right"
          href="{url entity='order' params=['cancelAddress' => {$type}]}">{l s='Cancel' d='Shop.Theme.Actions'}</a>
      {/if}
      <button type="submit" class="continue btn btn-primary pull-xs-right" name="confirm-addresses" value="1">
        {l s='Continue' d='Shop.Theme.Actions'}
      </button>
    </form>
  {/if}
{/block}