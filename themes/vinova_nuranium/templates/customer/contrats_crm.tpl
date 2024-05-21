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
{extends file='customer/page.tpl'}
{block name='head_seo'}
  <title>{block name='head_seo_title'}{l s='My contracts' d='Shop.Theme.Customeraccount'}{/block}</title>
{/block}
{block name='page_title'}
  {l s='My contracts' d='Shop.Theme.Customeraccount'}
{/block}


{block name='page_content'}
  <div class=" container p-0 userInvoice  ">
    <div class="block_content-right ml-0 flex-column">
      <div class="topProfile">
        <div id="identity-link">
          <span class="link-name"> {block name='page_title'}{/block}</span>
        </div>
      </div>

      <div class="p-5">
        <table class="table table-bordered table-striped table-responsive" id="table-contrat" cellspacing="0"
          width="100%">
          <thead>
            <tr>
              <th scope="col">{l s='Contract reference' d='Shop.Theme.Customeraccount'}</th>
              <th scope="col">{l s='Offre' d='Shop.Theme.Customeraccount'}</th>
              <th scope="col">{l s='Start date' d='Shop.Theme.Customeraccount'}</th>
              <th scope="col">{l s='State' d='Shop.Theme.Customeraccount'}</th>
              <th scope="col">{l s='Actions' d='Shop.Theme.Customeraccount'}</th>
            </tr>
          </thead>
          <tbody id="tableContrat"></tbody>
        </table>
      </div>
    </div>
    {* Get options Modal: antivirus *}
    <div class="modal fade" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalTitle"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="optionsModalTitle">{l s='Options to activate' d='Shop.Theme.Customeraccount'}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped table-responsive" id="table-contrat" cellspacing="0"
              width="100%">
              <thead>
                <tr>
                  <th scope="col">{l s='Designation' d='Shop.Theme.Customeraccount'}</th>
                  <th scope="col">{l s='Code' d='Shop.Theme.Customeraccount'}</th>
                </tr>
              </thead>
              <tbody id="tableOptions">
                <td scope="col" style="text-align:center">Antivirus Bitdefender</td>
                <td scope="col">
                  <button id="retreiveBtn" onclick='retreiveKey()'>
                    {* <i class="fa fa-download"></i> *}
                    {l s='Retreive' d='Shop.Theme.Customeraccount'}
                  </button>
                  <div id='antivirusKey'></div>
                </td>
              </tbody>
            </table>
          </div>
          {* <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div> *}
        </div>
      </div>
    </div>


    <div class="clearfix"></div>

    {block name='hook_before_body_closing_tag'}
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer>
      </script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"
        defer></script>
      <script type="text/javascript">
        var amount = "{l s='Amount to be paid' d='Shop.Theme.Customeraccount'}"
        var referenceContrat = "{l s='Contract reference' d='Shop.Theme.Customeraccount'}"
        var dateDebut = "{l s='Start date' d='Shop.Theme.Customeraccount'}"
        var etat = "{l s='State' d='Shop.Theme.Customeraccount'}"
        var next = "{l s='Next' d='Shop.Theme.Customeraccount'}";
        var first = "{l s='First' d='Shop.Theme.Customeraccount'}";
        var last = "{l s='Last' d='Shop.Theme.Customeraccount'}";
        var search = "{l s='Search' d='Shop.Theme.Customeraccount'}";
        var reference = "{l s='Reference' d='Shop.Theme.Customeraccount'}";
        var Offre = "{l s='Offre' d='Shop.Theme.Customeraccount'}";
        var prev =" {l s='Previous' d='Shop.Theme.Customeraccount'}";
        var due = "{l s='Due date' d='Shop.Theme.Customeraccount'}";
        var visualization = "{l s='Visualization' d='Shop.Theme.Customeraccount'}";
        var consulter = "{l s='Consulter' d='Shop.Theme.Customeraccount'}";
        var display = "{l s='Display' d='Shop.Theme.Customeraccount'}";
        var proccessing = "{l s='Loading' d='Shop.Theme.Customeraccount'}";
        var zero = "{l s= "No result found" d='Shop.Theme.Customeraccount'}";
        var to = "{l s= "to" d='Shop.Theme.Customeraccount'}";
        var showing= "{l s= "Showing" d='Shop.Theme.Customeraccount'}";
        var sur = "{l s= "of" d='Shop.Theme.Customeraccount'}";
        var filtred = "{l s= "filtered from" d='Shop.Theme.Customeraccount'}";
        var total = "{l s= "elements" d='Shop.Theme.Customeraccount'}";
        var entries = "{l s= "No entries found" d='Shop.Theme.Customeraccount'}";
        var encours = "{l s= "En cours" d='Shop.Theme.Customeraccount'}";
        var alertContrat = "{l s= "Error downloading contract" d='Shop.Theme.Customeraccount'}";
        var Options = "{l s= "Options" d='Shop.Theme.Customeraccount'}";
        var designation = "{l s= "Designation" d='Shop.Theme.Customeraccount'}";
        var nokey= "{l s= "No key available" d='Shop.Theme.Customeraccount'}";
        var errorKey= "{l s= "Service unavailable, try again later" d='Shop.Theme.Customeraccount'}";


        $('#contact-link').ready(function() {
          $('tableContrat').innerHTML = ``;
          $.ajax({
            data: {
              ajax: true,
              action: 'listContrat',
            },
            dataType: 'json'
          }).done(function(response) {
            if (response.success) {
              // console.log('data', response.data)
              liste = response.data
              if (liste != []) {
                // $('tableContrat').innerHTML +=
                $('#table-contrat').DataTable({
                  // processing: true,
                  bDestroy: true,
                  data: liste,
                  ajax: function(liste, callback) {
                    setTimeout(function() {
                      callback({
                        draw: liste.draw,
                        data: liste,
                      });
                    }, 5);
                  },
                  lengthMenu: [10, 25, 50, 75, 100],
                  paging: false,
                  searching: false,
                  info: false,
                  columns: [{
                      "data": "ref_contrat",
                      render: function(data) {
                        return "<span class='colLabel'>" + reference + "</span>&nbsp;" + data
                      }
                    },
                    {
                      "data": "nameOffre",
                      render: function(data) {
                        return "<span class='colLabel'>" + Offre + "</span>&nbsp;" + data
                      }
                    },
                    {
                      "data": "date_contrat",
                      "defaultContent": '',
                      render: function(data) {
                        return "<span class='colLabel'>" + dateDebut + "</span>&nbsp;" + data.split('T')[0]
                      }

                    },
                    {
                      "data": "etat",
                      "defaultContent": '',
                      render: function(data) {
                        return "<span class='colLabel'>" + etat + "</span>&nbsp;" + encours
                      }
                    },
                    {
                      "data": null,
                      "defaultContent": '',
                      render: function(data) {
                        if (data.haveContrat) {
                          return "<div class='contractBtn'><button type='button' data-toggle='modal' data-target='#optionsModal'>" +
                            Options + "</button>" +
                            "<button class='pdfContract' onclick=pdf(`" + data.ref_contrat +
                            "`)>" + '<i class="fa fa-download" aria-hidden="true"></i></button>' + "</div>"
                        } else {
                          return "<button disabled onclick=pdf(`" + data.ref_contrat + "`)>" +
                            consulter + "</button>"
                        }
                      },

                    }
                  ],
                  responsive: true,
                  language: {
                    url: "/js/datatable_lang/{$language.iso_code}.json",  
                  }
                })
              } else {
                $('tableContrat').innerHTML += 'pas de contrat trouvé'
              }
            } else {
              $('tableContrat').innerHTML += 'pas de contrat trouvé'
            }
          }).fail(function(error) {
            console.log('error:', error)
          })
        })

        function base64URLtoFile(base64URL, fileName, type) {
          const byteString = atob(base64URL);
          const byteArray = new Uint8Array(byteString.length);
          var type
          for (let i = 0; i < byteString.length; i++) {
            byteArray[i] = byteString.charCodeAt(i);
          }
          if (byteString.includes('PDF')) { type = { type: 'application/pdf' } } else { type = { type: 'image/jpeg' } }
          const blob = new Blob([byteArray], type);
          const link = document.createElement('a');
          link.href = URL.createObjectURL(blob);
          link.download = fileName;
          link.click();
        }

        function pdf(ref_contrat) {
          $.ajax({
            data: {
              ajax: true,
              action: 'PdfContrat',
              reference: ref_contrat
            },
            dataType: 'json'
          }).done(function(response) {
            if (response.success) {
              const base64URL = response.data;
              const fileName = "Contrat réf " + ref_contrat;
              base64URLtoFile(base64URL, fileName);
            } else {
              console.log("error pdf")

            }
          }).fail(function(error) {
            console.log('error:', error)
          })

        }

        function retreiveKey() {
          document.getElementById('antivirusKey').innerHTML = ``
          $.ajax({
            data: {
              ajax: true,
              action: 'GetKey',
            },
            dataType: 'json'
          }).done(function(response) {
            console.log('test', response)
            if (response.success) {
              if (response.code == 'SUCCESS') {
                document.getElementById('retreiveBtn').style.display = "none";
                document.getElementById('antivirusKey').innerHTML += response.message
              } else {
                document.getElementById('retreiveBtn').style.display = "none";
                document.getElementById('antivirusKey').innerHTML += nokey
              }
            } else {
              document.getElementById('retreiveBtn').style.display = "none";
              document.getElementById('antivirusKey').innerHTML += errorKey
            }
          }).fail(function(error) {
            console.log('error:', error)

          })
        }
      </script>

      <style>
        #contratsCRM footer,
        #facturesCRM footer {
          padding: 14rem 0 0;
        }
      </style>
    {/block}
{/block}