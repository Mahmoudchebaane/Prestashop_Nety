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
{extends file='page.tpl'}

{block name='page_title'}
  {l s='Reset your password' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
  <form action="{$urls.pages.password}" method="post" id='myform'>

    <section class="form-fields renew-password">

      <div class="email inputLabel" style="font-weight: 600;display: flex;margin-bottom: 30px;">
        {l s='Email address: %email%'  d='Shop.Theme.Customeraccount'  sprintf=['%email%' => $customer_email|stripslashes]}
      </div>

      <div class="container-fluid">


        <style>
          .btneyes {
            background: transparent;
            border: 1px solid #ba95d6;
            color: #292b2c;
            height: 40px;
            border-left: none;
            border-bottom-right-radius: 10px;
            border-top-right-radius: 10px;
          }

          .btneyes:lang(ar) {
            border-bottom-right-radius: 0px;
            border-top-right-radius: 0px;
            color: #292b2c;
            background: transparent;
            border: 1px solid #ba95d6;
            height: 40px;
            border-right: none;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
          }

          .inputeyes {
            border-bottom-right-radius: 0px !important;
            border-top-right-radius: 0px !important;
            border-bottom-left-radius:  10px !important;
            border-top-left-radius:  10px !important;
            height: 40px !important;
          }

          .inputeyes:lang(ar) {
            border-bottom-right-radius: 10px !important;
            border-top-right-radius: 10px !important;
            border-bottom-left-radius: 0px !important;
            border-top-left-radius: 0px !important;
            height: 40px;
          }
        </style>
        <div class="row  ">
          <label class="col-md-4  pl-15  text-right inputLabel">{l s='New password' d='Shop.Forms.Labels'}</label>
          <div class="col-md-6 col-lg-4   ">
            <div class=" input-group js-parent-focus">
              <input class="form-control js-child-focus js-visible-password inputeyes" type="password"
                data-validate="isPasswd" name="passwd" value="">
              <button class="btn btneyes" type="button" data-action="show-password">
                <i class='zmdi zmdi-eye-off'></i>
              </button>
            </div>
            <div class='text-danger text-left mb-15 mt-15' id='pswError1'></div>
          </div>
        </div>


        <div class="row  ">
          <label
            class="col-md-4 pl-15   text-right inputLabel">{l s='Confirmation password' d='Shop.Forms.Labels'}</label>
          <div class="col-md-6 col-lg-4   ">
            <div class="input-group js-parent-focus">
              <input class="form-control inputeyes js-child-focus js-visible-password" type="password"
                data-validate="isPasswd" name="confirmation" value="">
              <button class="btn btneyes" type="button" data-action="show-password">
                <i class='zmdi zmdi-eye-off'></i>
              </button>
            </div>
            <div class='text-danger text-left mb-15 mt-15' id='pswError'></div>
          </div>
        </div>

        <input type="hidden" name="token" id="token" value="{$customer_token}">
        <input type="hidden" name="id_customer" id="id_customer" value="{$id_customer}">
        <input type="hidden" name="reset_token" id="reset_token" value="{$reset_token}">

        <div class="row  ">
          <label class="col-md-4"> </label>
          <div class="col-md-6 col-lg-4 text-left  ">
            <button class="SubscriptionBtn " type="submit" name="submit" class="col-md-6 col-lg-4  text-right  ">
              {l s='Change Password' d='Shop.Theme.Actions'}
            </button>
          </div>
        </div>
    </section>
  </form>

 
{/block}
{block name="footer"}{/block}


{block name='hook_before_body_closing_tag'}

  <script>
    var missingPass = '{l s='This field is required' d='Shop.Theme.Customeraccount'}';
    var matchPass = '{l s='Passwords are not matching' d='Shop.Theme.Customeraccount'}';
    var weak =  '{l s="Weak password!"  d='Shop.Theme.Customeraccount'}';
    var twoParam='{l s='You should fill in the fields'  d='Shop.Theme.Customeraccount'}';
    $('#myform').submit(function(evt) {
      console.log('test', ($("input[name='passwd']").val()).length)
      $('#pswError').text('');
      $('#pswError1').text('');
      if ($("input[name='passwd']").val() == '' && $("input[name='confirmation']").val() == '') {
        $('#pswError').text(twoParam);
        evt.preventDefault();
      } else if ($("input[name='passwd']").val() == '') {
        $('#pswError1').text(missingPass);
        evt.preventDefault();
      } else if (($("input[name='passwd']").val()).length < 6) {
        $('#pswError1').text(weak);
        evt.preventDefault();
      } else if ($("input[name='confirmation']").val() == '') {
        $('#pswError').text(missingPass);
        evt.preventDefault();
      } else if ($("input[name='passwd']").val() != $("input[name='confirmation']").val()) {
        $('#changePassBtn').attr('disabled', true);
        $('#pswError').text(matchPass);
        evt.preventDefault();
      } else {
        $('#pswError').text('');
        return true
      }
    });
  </script>

{/block}