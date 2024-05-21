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
{extends file='layouts/layout-maintenance.tpl'}

{block name='stylesheets'}

  <style type="text/css">
    /* #main {
      text-align: center;
    } */

    .maintenacePage .logo img {
      height: auto;
      width: 200px;
    }

    .comingImg {
      width: 45%;
      height: auto;
      margin-top: 100px;
    }

    .maintenaceSection {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .contactMaintenance {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;

      margin-top: 50px;
    }

    .contactMaintenance span {
      color: white;
      font-weight: 500;
      font-size: 15px;
      font-family: 'Azo Sans', sans-serif;
      margin-left: 10px;
    }

    .contactMaintenance img {
      height: 30px;
      width: auto;
    }

    .maintenaceSection p {
      color: white;
      font-weight: 600;
      font-size: 25px;
      text-shadow: 0px 7px 8px #00000029;
      font-family: 'Helvetica Neue', sans-serif;
      margin-left: 10px;
      text-transform: uppercase;
      letter-spacing: 3px;
    }

    .contactDetail {
      display: flex;
      align-items: center;
      margin: 0 25px;
    }

    @media (max-width:992px) {
      .comingImg {
        width: 60%;
      }

      /* .contactMaintenance {
        width: 100%;
      } */
    }

    @media (max-width:768px) {
      .contactMaintenance {
        flex-direction: column;
        align-items: flex-start;
        align-content: center;
      }


      .contactDetail {
        margin: 10px;
      }

      .comingImg {
        margin-top: 200px;
        width: 80%;
      }
    }

    @media (max-width:576px) {
      .comingImg {
        width: 100%;
        margin-top: 100px;
      }
    }
  </style>
{/block}

{block name='content'}

  <section id="main" class="">

    {block name='page_header_container'}
      <header class="page-header">
        {block name='page_header_logo'}
          <div class="logo"><img src="{$shop.logo}" alt="logo"></div>
        {/block}
        {block name='hook_maintenance'}
          {$HOOK_MAINTENANCE nofilter}
        {/block}
        {block name='page_header'}

          {* <h1>{block name='page_title'}{l s='We\'ll be back soon.' d='Shop.Theme.Errors'}{/block}</h1> *}
        {/block}
      </header>
    {/block}

    {block name='page_content_container'}
      <section id="content" class="page-content page-maintenance maintenaceSection">
        {block name='page_content'}
          <img src="/themes/vinova_nuranium/assets/img/comingSoon.png" alt="maintenance" class="comingImg">
          {$maintenance_text nofilter}

          <div class="contactMaintenance">
            <div class="contactDetail">
              <img src="/themes/vinova_nuranium/assets/img/msg.png">
              <span>contact@nety.tn</span>
            </div>
            <div class="contactDetail">

              <img src="/themes/vinova_nuranium/assets/img/fb.png">
              <span>Nety</span>
            </div>

            <div class="contactDetail">
              <img src="/themes/vinova_nuranium/assets/img/tel.png">
              <span>73820930</span>
            </div>
          </div>
        {/block}
      </section>
    {/block}

    {block name='page_footer_container'}
      <div style="    position: fixed;    bottom: 0;right: 0;">
        <img src="/themes/vinova_nuranium/assets/img/design1.png" height="350px" />
      </div>
    {/block}

  </section>

{/block}