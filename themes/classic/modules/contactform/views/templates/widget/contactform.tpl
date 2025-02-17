<section class="contact-form ">
  <!-- <form action="{$urls.pages.contact}" method="post" {if $contact.allow_file_upload}enctype="multipart/form-data"
            {/if}>  -->
  <form action="{$link->getPageLink('contact')|escape:'html':'UTF-8'}" method="post" {if
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
            <input class="form-control contactInput" name="name" placeholder="{l s='Name*' d='Shop.Forms.Help'}" required>
          </div>
          <div class="col-md-6">
            <input class="form-control contactInput" name="from" type="email" value="{$contact.email}" required
              placeholder="{l s='Email*' d='Shop.Forms.Help'}">
          </div>
        </div>

        <div class="form-group row">
          <!-- <label class="col-md-3 form-control-label" for="email">{l s='Email address'
                                        d='Shop.Forms.Labels'}</label> -->
          <div class="col-md-6">
            <input class="form-control contactInput" name="tel" type="text"
              placeholder="{l s='Tel Fix ADSL' d='Shop.Forms.Help'}">
          </div>
          <div class="col-md-6">
            <input id="gsm" class="form-control contactInput" name="gsm" type="tel" required
              placeholder="{l s='GSM*' d='Shop.Forms.Help'}">
          </div>
        </div>

        <div class="form-group row">
          <!-- <label class="col-md-3 form-control-label" for="email">{l s='Email address'
                        d='Shop.Forms.Labels'}</label> -->
          <div class="col-md-6">
            <select name="id_contact" id="id_contact" class="form-control form-control-select contactInput ">
              {foreach from=$contact.contacts item=contact_elt}
                <option value="{$contact_elt.id_contact}">{$contact_elt.name} </option>
              {/foreach}
            </select>
          </div>
          <div class="col-md-6">
            <input id="address" class="form-control contactInput" name="address" type="text"
              placeholder="{l s='Addresse Postale' d='Shop.Forms.Help'}">
          </div>


        </div>

        {if $contact.orders}
          <div class="form-group row">
            <!-- <label class="col-md-3 form-control-label" for="id-order">{l s='Order reference'
                        d='Shop.Forms.Labels'}</label> -->
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
        {/if}

        <div class="form-group row">
          <!-- <label class="col-md-3 form-control-label" for="contactform-message">{l s='Message' d='Shop.Forms.Labels'}</label> -->
          <!-- <div class="col-md-12">
                    <textarea id="contactform-message" class="form-control contactInput" name="message" required
                        placeholder="{l s='Message' d='Shop.Forms.Help'}"
                        rows="3">{if $contact.message}{$contact.message}{/if}</textarea>
                </div> -->

          <div class="col-md-12">
            <textarea class="form-control contactInput" name="message" placeholder="{l s='Message*' d='Shop.Forms.Help'}"
              required rows="8">{if $contact.message}{$contact.message}{/if} </textarea>
          </div>

        </div>

        {if isset($id_module)}
          <div class="form-group row">
            <div class="offset-md-3">
              {hook h='displayGDPRConsent' id_module=$id_module}
            </div>
          </div>
        {/if}

      </section>

      <footer class="form-footer text-sm-right contactBtn">
        <style>
          input[name=url] {
            display: none !important;
          }
        </style>
        {* <div>
          <script src='https://www.google.com/recaptcha/api.js?hl=fr'></script>
          <div class="g-recaptcha" data-sitekey="6Lds730kAAAAAFXrfpwDNfR-jeKFsLy-V_qTb3Zs" required>
          </div>
        </div> *}
        <input type="text" name="url" value="" />
        <input type="hidden" name="token" value="{$token}" />
        <!-- <input class="btn btn-primary" type="submit" name="submitMessage"
                    value="{l s='Send' d='Shop.Theme.Actions'}"> -->
        <button class="btnContact" type="submit" name="submitMessage">
          <!-- <img class="img-fluid" src="{_THEME_IMG_DIR_}img-send.png" alt="img"> -->
          <span>{l s='Send' d='Shop.Theme.Actions'}</span>
        </button>
      </footer>
    {/if}

  </form>
</section>