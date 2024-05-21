{extends file='page.tpl'}

{block name='page_content_container' prepend}
  <section id="content-hook_order_confirmation" class="card">
    <div class="card-block d-flex flex-wrap">
      <div class="row">
        <div class="col-md-12"
          style="display: flex;flex-direction: column;align-items: flex-start;justify-content: space-between;">
          {block name='order_confirmation_header'}
            <h3 class="h1 card-title">
              <span class="d-flex align-items-start pb-10">
                <i class="fa fa-check-circle"></i>
                <div>
                  <span class="d-flex" style="padding-bottom:10px;">
                    {l s='Thank you' d='Shop.Theme.Checkout'}&nbsp;
                    <p>{$customer.firstname}&nbsp;{$customer.lastname}</p>
                  </span>
                  {l s='Your order is saved successffuly ' d='Shop.Theme.Checkout'}

                </div>
              </span>

            </h3>
          {/block}
          <div class="order-right w-100 align-items-start pt-0">
            <span class="">
              {* {l s='Order reference: %reference%' d='Shop.Theme.Checkout' sprintf=['%reference%' => $order.details.reference]} *}
              {l s='Order reference:'   d='Shop.Theme.Checkout'}&nbsp;
              <p>{$order.details.reference}</p>
            </span>
          </div>
          <p class="confirmationText">
            {l s='Your order will be delivered very soon' d='Shop.Theme.Checkout'}
            <br>
            {l s='For any questions or additional information, please contact our Customer service.' d='Shop.Theme.Checkout'}
          </p>

          <a href='/' class="continue">{l s='Back to home' d='Shop.Theme.Checkout'}</a>
          <p class='email-confirmation d-none'>
            {l s='An email has been sent to your mail address %email%.' d='Shop.Theme.Checkout' sprintf=['%email%' => $customer.email]}
            {if $order.details.invoice_url}
              {* [1][/1] is for a HTML tag. *}
              {l
                                              s='You can also [1]download your invoice[/1]'
                                              d='Shop.Theme.Checkout'
                                              sprintf=[
                                                '[1]' => "<a href='{$order.details.invoice_url}'>",
              '[/1]' => "</a>"
              ]
              }
            {/if}
          </p>

          {* {block name='hook_order_confirmation'}
            {$HOOK_ORDER_CONFIRMATION nofilter}
          {/block} *}

        </div>

      </div>
      <div class="order-right">
        <img src='/img/confirmImg.png' alt='confirmation-order' class="imgConfirmation">

      </div>
    </div>
  </section>
{/block}

{block name='page_content_container'}
  <section id="content" class="page-content page-order-confirmation card d-none">
    <div class="card-block">
      <div class="">

        {block name='order_confirmation_table'}
          {include
                file='checkout/_partials/order-confirmation-table.tpl'
                products=$order.products
                subtotals=$order.subtotals
                totals=$order.totals
                labels=$order.labels
                add_product_link=false
              }
        {/block}

        {block name='order_details'}
          <h3 class="h3 card-title">{l s='Order details' d='Shop.Theme.Checkout'}:</h3>
          <div id="order-details" class="col-md-6 ">
            <ul>
              <li>
                {l s='Order reference: %reference%' d='Shop.Theme.Checkout' sprintf=['%reference%' => $order.details.reference]}
              </li>
              <li>{l s='Payment method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.details.payment]}
              </li>
              {if !$order.details.is_virtual}
                <li>
                  {l s='Shipping method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.carrier.name]}<br>
                  <em>{$order.carrier.delay}</em>
                </li>
              {/if}
            </ul>
          </div>
        {/block}

      </div>
    </div>
  </section>
  <div class="row spacing-10 d-none">
    <div class="{if $nov_customer.logged}col-12{else}col-md-6{/if}">
      {block name='hook_payment_return'}
        {if ! empty($HOOK_PAYMENT_RETURN)}
          <section id="content-hook_payment_return" class="card definition-list">
            <div class="card-block">
              <div class="row spacing-10">
                <div class="col-md-12">
                  {$HOOK_PAYMENT_RETURN nofilter}
                </div>
              </div>
            </div>
          </section>
        {/if}
      {/block}
    </div>
    {block name='customer_registration_form'}
      {if $customer.is_guest}
        <div class="col-md-6">
          <div id="registration-form" class="card">
            <div class="card-block">
              <h4 class="h4">{l s='Save time on your next order, sign up now' d='Shop.Theme.Checkout'}</h4>
              {render file='customer/_partials/customer-form.tpl' ui=$register_form}
            </div>
          </div>
        </div>
      {/if}
    {/block}
  </div>


  {block name='hook_order_confirmation_1'}
    {hook h='displayOrderConfirmation1'}
  {/block}

  {* {block name='hook_order_confirmation_2'}
    <section id="content-hook-order-confirmation-footer">
      {hook h='displayOrderConfirmation2'}
    </section>
  {/block} *}
{/block}