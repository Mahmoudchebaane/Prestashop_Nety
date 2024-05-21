{if $specific_prices}
 {if ($smarty.now|date_format:'%Y-%m-%d %H:%M:%S' < $specific_prices.to )}
  <div class="countdownfree d-flex justify-content-center" data-date="{$specific_prices.to|date_format:'%Y/%m/%d'}"></div>
 {elseif ($specific_prices.to == '0000-00-00 00:00:00') && ($specific_prices.from == '0000-00-00 00:00:00')}
 
 {/if}
{else}
  {* <p>{l s='No specials at this time.' mod='novthemeconfig'}</p> *}
{/if}