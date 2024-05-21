<section class="contact-form ">
  <!-- <form action="{$urls.pages.contact}" method="post" {if $contact.allow_file_upload}enctype="multipart/form-data"
            {/if}>  -->
  <form action="{$link->getPageLink('contact')|escape:'html':'UTF-8'}" method="post" class="contact-form-box" {if
    $contact.allow_file_upload}enctype="multipart/form-data" {/if}>
    {if $notifications}
      <div class="col-xs-12 alert {if $notifications.nw_error}alert-danger{else}alert-success{/if}">
        <ul>
          {foreach $notifications.messages as $notif}
            <li>{$notif}</li>
          {/foreach}
        </ul>
      </div>
    {/if}

    {if !$notifications || $notifications.nw_error}


      <section class="form-fields">
        <div class="form-group row no-flow">
          <div class="col-md-6">
            <input class="form-control contactInput" name="firstname"
              placeholder="{l s='Nom & Prénom*' d='Shop.Forms.Help'}" value="{$contact.firstname}">
          </div>
          <div class="col-md-6">
            <input class="form-control contactInput" name="from" type="email" value="{$contact.email}"
              placeholder="{l s='Email address' d='Shop.Forms.Labels'}">
          </div>
        </div>

        <div class="form-group row">

          <div class="col-md-6">
            <input class="form-control contactInput" name="tel" type="text"
              placeholder="{l s='Numero de ligne' d='Shop.Forms.Help'}" value="{$contact.tel}">
          </div>
          <div class="col-md-6">
            <input id="gsm" class="form-control contactInput" name="gsm" type="tel" value="{$contact.gsm}"
              placeholder="{l s='Phone:' d='Shop.Theme.Global'}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <select name="id_contact" id="id_contact" class="form-control form-control-select contactInput ">
              {foreach from=$contact.contacts item=contact_elt}
                <option value="{$contact_elt.id_contact}">{$contact_elt.name} </option>
              {/foreach}
            </select>
          </div>
          <div class="col-md-6">
            <input id="address" class="form-control contactInput" name="address" type="text" value="{$contact.address}"
              placeholder="{l s='Address' d='Shop.Forms.Labels'}">
          </div>

        </div>

        {* {if $contact.orders}
          <div class="form-group row">
            <div class="col-md-6">
              <select id="id-order" name="id_order" class="form-control form-control-select">
                <option value="">{l s='Select reference' d='Shop.Forms.Help'}</option>
                {foreach from=$contact.orders item=order}
                  <option value="{$order.id_order}">{$order.reference}</option>
                {/foreach}
              </select>
            </div>
            <span class="col-md-3 form-control-comment">
              {l s='optional' d='Shop.Forms.Help'}
            </span>
          </div>
        {/if} *}

        <div class="form-group row">

          <div class="col-md-12">
            <textarea class="form-control contactInput" name="message"
              placeholder="{l s='Your message here' d='Shop.Forms.Help'}"
              rows="8">{if $contact.message}{$contact.message}{/if}</textarea>
          </div>

        </div>

        {if isset($id_module)}
          <div class="form-group row">
            <div class="offset-md-3">
              {hook h='displayGDPRConsent' id_module=$id_module}
            </div>
          </div>
        {/if}

        {* {hook h='displayPaCaptcha' posTo='contact'} *}

      </section>

      <footer class="form-footer text-sm-right contactBtn">

        <input type="text" name="url" value="" class="d-none" />
        <input type="hidden" name="token" value="{$token}" />
        <button class="btnContact" type="submit" name="submitMessage">
          <span>{l s='Send' d='Shop.Theme.Actions'}</span>
        </button>
      </footer>
    {/if}

  </form>
</section>