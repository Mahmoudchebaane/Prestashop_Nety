{**
 * 2007-2017 PrestaShop
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
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name="address_form"}
  <div class="js-address-form">
    {include file='_partials/form-errors.tpl' errors=$errors['']}

    <form method="POST" action="{url entity='address' params=['id_address' => $id_address]}"
      data-id-address="{$id_address}"
      data-refresh-url="{url entity='address' params=['ajax' => 1, 'action' => 'addressForm']}">
      <input type="hidden" value="{$id_address}" name="id_address" />
      {block name="address_form_fields"}
        <section class="form-fields">
          {block name='form_fields'}
         
            {foreach from=$formFields item="field"}

              {block name='form_field'}
                {if $page.page_name == 'checkout'}
                  {if ($field.required && $field.name != 'firstname' && $field.name != 'lastname' && $field.name != 'id_country') || $field.name == 'alias' }
                    {form_field field=$field}
                  {* {elseif $field.name =='state'}
             
                    <div class="form-group row no-gutters novform-state">
                      <label class=" col-md-2 form-control-label required">
                        {l s="Gov" d="Shop.Theme.Catalog"}
                      </label>
                      <div class="col-md-8">
                      {$field|dump}
                        <input required id="gouvernoratAddress" class="" name="state" class="form-control"
                          placeholder="{l s="Gov" d="Shop.Theme.Catalog"}" />
                      </div>
                      <div class="col-md-2 form-control-comment right">
                      </div>
                    </div> *}
                  {else}
                    <div class="hidden">
                      {form_field field=$field}
                    </div>
                  {/if}
                {else}
                  {form_field field=$field}
                {/if}

              {/block}
            {/foreach}


          {/block}
        </section>
      {/block}

      {block name="address_form_footer"}
        <footer class="form-footer row no-gutters">
          <div class="col-md-10 offset-md-2">
            <input type="hidden" name="submitAddress" value="1">
            {block name='form_buttons'}
              <button class="btn btn-primary mb-40" type="submit" class="form-control-submit mb-20">
                {l s='Save' d='Shop.Theme.Actions'}
              </button>
            {/block}
          </div>
        </footer>
      {/block}

    </form>
  </div>

{/block}

{block name='hook_before_body_closing_tag'}
  <style>
    .novform-state .select2-container {
      width: 100% !important;
      height: 45px !important;
    }

    .novform-state .select2-container a {
      height: 40px !important;
      background: #fff !important;
      border-color: #e9e9e9 !important;
      font-size: 1.2rem !important;
      padding-left: 20px !important;
      padding-right: 20px !important;
      width: 100% !important;
    }
  </style>
  {* <script type="text/javascript">
    var Ariana = '{l s="Ariana" d="Shop.Theme.Catalog"}';12
    var BenArous = '{l s="Ben Arous" d="Shop.Theme.Catalog"}';13
    var Beja = '{l s="Béja" d="Shop.Theme.Catalog"}';31
    var Bizerte = '{l s="Bizerte" d="Shop.Theme.Catalog"}';23
    var Gabès = '{l s="Gabès" d="Shop.Theme.Catalog"}';81
    var Gafsa = '{l s="Gafsa" d="Shop.Theme.Catalog"}';71
    var Jendouba = '{l s="Jendouba" d="Shop.Theme.Catalog"}';32
    var Kairouan = '{l s="Kairouan" d="Shop.Theme.Catalog"}';41
    var Kasserine = '{l s="Kasserine" d="Shop.Theme.Catalog"}';42
    var Kébili = '{l s="Kébili" d="Shop.Theme.Catalog"}';73
    var Kef = '{l s="Kef" d="Shop.Theme.Catalog"}';33
    var Mahdia = '{l s="Mahdia" d="Shop.Theme.Catalog"}';53
    var Manouba = '{l s="Manouba" d="Shop.Theme.Catalog"}';14
    var Médenine = '{l s="Médenine" d="Shop.Theme.Catalog"}';82
    var Monastir = '{l s="Monastir" d="Shop.Theme.Catalog"}';52
    var Nabeul = '{l s="Nabeul" d="Shop.Theme.Catalog"}';21
    var Sfax = '{l s="Sfax" d="Shop.Theme.Catalog"}';61
    var SidiBouzid = '{l s="Sidi Bouzid" d="Shop.Theme.Catalog"}';43
    var Siliana = '{l s="Siliana" d="Shop.Theme.Catalog"}';34
    var Sousse = '{l s="Sousse" d="Shop.Theme.Catalog"}';51
    var Tataouine = '{l s="Tataouine" d="Shop.Theme.Catalog"}';83
    var Tozeur = '{l s="Tozeur" d="Shop.Theme.Catalog"}';72
    var Tunis = '{l s="Tunis" d="Shop.Theme.Catalog"}';11
    var Zaghouan = '{l s="Zaghouan" d="Shop.Theme.Catalog"}';22
    var noStore ='{l s='Aucune boutique trouvé.'  d="Shop.Theme.Catalog"}';
    var Address = '{l s="Address" d="Shop.Theme.Catalog"}';
    $(document).ready(function() {
      // Initialise gov list
      var govs = [
        { id: 'Ariana', text: Ariana },
        { id: 'Béja', text: Beja },
        { id: 'Ben Arous', text: BenArous },
        { id: 'Bizerte', text: Bizerte },
        { id: 'Gabès', text: Gabès },
        { id: 'Gafsa', text: Gafsa },
        { id: 'Jendouba', text: Jendouba },
        { id: 'Kairouan', text: Kairouan },
        { id: 'Kasserine', text: Kasserine },
        { id: 'Kébili', text: Kébili },
        { id: 'Kef', text: Kef },
        { id: 'Mahdia', text: Mahdia },
        { id: 'Manouba', text: Manouba },
        { id: 'Médenine', text: Médenine },
        { id: 'Monastir', text: Monastir },
        { id: 'Nabeul', text: Nabeul },
        { id: 'Sfax', text: Sfax },
        { id: 'Sidi Bouzid', text: SidiBouzid },
        { id: 'Siliana', text: Siliana },
        { id: 'Sousse', text: Sousse },
        { id: 'Tataouine', text: Tataouine },
        { id: 'Tozeur', text: Tozeur },
        { id: 'Tunis', text: Tunis },
        { id: 'Zaghouan', text: Zaghouan }
      ]
      $('#gouvernoratAddress').select2({ width: '200px', height: '50px', data: govs, value: govs[0].id }).on("change",
        function(e) {
          console.log(e, 'agov addrezs')
        });


    });
  </script> *}
{/block}