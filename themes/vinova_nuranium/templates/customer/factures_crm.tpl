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
    <title>{block name='head_seo_title'}{l s='List of invoices' d='Shop.Theme.Customeraccount'}{/block}</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">

{/block}
{block name='page_title'}
    {l s='List of invoices' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
    <div class=" container p-0 userInvoice  ">

        <form onsubmit="return handleData()" method="POST">
            <div class="block_content-right ml-0 flex-column">

                <div class="topProfile">
                    <div id="identity-link" style="display: flex; justify-content: space-between;">
                        <span class="link-name  "> {block name='page_title'}{/block}</span>

                        <div id="paysection">
                            <span class="payammount">{l s='Total à payer' d='Shop.Theme.Customeraccount' } : <span
                                    id="totalpay">0.000</span> {l s='TND'  d='Shop.Theme.Customeraccount' } </span>
                            <button class="mr-3 btn btn-pay" type="button" data-toggle="modal"
                                data-target="#blockcart-modal" onclick="$('#totalpaymodal').text(totaltopay.toFixed(3));"
                                id="listpaybtn">{l s='Payer facture(s) selectionnée(s)' d='Shop.Theme.Customeraccount' }
                            </button>

                        </div>
                    </div>
                </div>

                <div class="p-5">
                    <table class="table table-bordered  table-responsive " id="mytable-facture" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th scope="col">{l s='Reference' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Reference' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Type' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Date debut' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Date fin' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Amount to be paid' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Due date' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='State' d='Shop.Theme.Customeraccount'}</th>
                                <th scope="col">{l s='Visualization' d='Shop.Theme.Customeraccount'}</th>
                            </tr>
                        </thead>
                        <tbody id="tableFacture"></tbody>

                    </table>
                </div>

            </div>
            <div id="blockcart-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <h3 class="p-4">{l s='Confirmation paiement'  d='Shop.Theme.Customeraccount' } </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="zmdi zmdi-close"></i>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="row p-4">
                                <div class="typeCarte col ">
                                    <div class="d-flex flex-wrap justify-content-left ">
                                        <span
                                            class="payammount  font-weight-bold font-size-16">{l s='Total à payer' d='Shop.Theme.Customeraccount' }
                                            : <span id="totalpaymodal">0.000</span>
                                            {l s='TND'  d='Shop.Theme.Customeraccount' }
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="totalammount" value="0" />
                            <div class="row p-4">
                                <div class="typeCarte col ">
                                    <div class="d-flex flex-wrap justify-content-left ">
                                        <p class=" mb-5 mr-0 font-size-15 text-black nowrap">
                                            {l s='Paiement par:' mod='paiementfacture' }</p>
                                        <div class="d-flex flex-wrap justify-content-center ">
                                            <div class="form-check custom-control custom-radio custom-control-inline"
                                                style=" margin:0 20px">
                                                <input class="form-check-input" type="radio" name="paiement"
                                                    value="Carte bancaire" checked>
                                                <label
                                                    class="form-check-label paiementLabel pt-3 font-size-15 font-weight-bold "
                                                    for="carte">{l s='Carte bancaire' mod='paiementfacture' }</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary backToShopping " class="close"
                                    data-dismiss="modal" aria-label="Close" id="show-previous-image">
                                    {l s='Annuler' d='Shop.Theme.Customeraccount' }
                                </button>

                                <button class="btn btn-primary  goToCart" type="submit"
                                    name="listpaybtn">{l s='Confirmer' d='Shop.Theme.Customeraccount' }
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
        </form>



        <div class="clearfix"></div>
        {block name='hook_before_body_closing_tag'}
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"
                defer>
            </script>

            <script type="text/javascript" charset="utf8"
                src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js" defer></script>
            <script src="/js/sweetalert.min.js"></script>
            <script type="text/javascript">
                var my_ajax_url ="{$urls.current_url}&ajax=true&action=listFacture" ;
                var etat = "{l s='State' d='Shop.Theme.Customeraccount'}";
                var facture = "{l s='Facture' d='Shop.Theme.Customeraccount'}"
                var avoir = "{l s='Avoir' d='Shop.Theme.Customeraccount'}"
                var dateFin = "{l s='Date fin' d='Shop.Theme.Customeraccount'}"
                var dateDebut = "{l s='Date debut' d='Shop.Theme.Customeraccount'}"
                var echeance = "{l s='Due date' d='Shop.Theme.Customeraccount'}"
                var amount = "{l s='Amount to be paid' d='Shop.Theme.Customeraccount'}"
                var next = "{l s='Next' d='Shop.Theme.Customeraccount'}";
                var first = "{l s='First' d='Shop.Theme.Customeraccount'}";
                var last = "{l s='Last' d='Shop.Theme.Customeraccount'}";
                var search = "{l s='Search' d='Shop.Theme.Customeraccount'}";
                var reference = "{l s='Reference' d='Shop.Theme.Customeraccount'}";
                var typeFacture = "{l s='Type' d='Shop.Theme.Customeraccount'}";
                var prev =" {l s='Previous' d='Shop.Theme.Customeraccount'}";
                var due = "{l s='Due date' d='Shop.Theme.Customeraccount'}";
                var visualization = "{l s='Visualization' d='Shop.Theme.Customeraccount'}";
                var consulter = "{l s='Télécharger votre facture ' d='Shop.Theme.Customeraccount'  }";
                var display = "{l s='Display' d='Shop.Theme.Customeraccount'}";
                var proccessing = "{l s='Loading' d='Shop.Theme.Customeraccount'}";
                var zero = "{l s= "No result found" d='Shop.Theme.Customeraccount'}";
                var to = "{l s= "to" d='Shop.Theme.Customeraccount'}";
                var showing= "{l s= "Showing" d='Shop.Theme.Customeraccount'}";
                var sur = "{l s= "of" d='Shop.Theme.Customeraccount'}";
                var filtred = "{l s= "filtered from" d='Shop.Theme.Customeraccount'}";
                var total = "{l s= "elements" d='Shop.Theme.Customeraccount'}";
                var entries = "{l s= "No entries found" d='Shop.Theme.Customeraccount'}";
                var unpaid = "{l s= "unpaid" d='Shop.Theme.Customeraccount'}";
                var paid = "{l s= "paid" d='Shop.Theme.Customeraccount'}";
                var alertPdf = "{l s= "Error downloading invoice" d='Shop.Theme.Customeraccount'}";
                var numavoir = "{l s='Avoir N° ' d='Shop.Theme.Customeraccount'}";
                var numfact = "{l s='Facture N° ' d='Shop.Theme.Customeraccount'}";
                var previousInvoice ="{l s='Please pay the old bills first.' d='Shop.Theme.Customeraccount'}";
                var revendeur = "{l s='Please head to the nearest Nety point of sale to complete the subscription process' d='Shop.Theme.Customeraccount'}"
                $(document).ready(function() {
                    totaltopay = 0;
                    totalavoir = 0;
                    order_pay = 0;
                    testpagechange = false;
                    $('#listpaybtn').prop('disabled', true);
                    var dt = $('#mytable-facture').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        order: ['3', 'desc'],
                        searching: true,
                        autoWidth: false,
                        lengthMenu: [25, 50, 100],
                        ajax: {
                            type: 'POST',
                            url: my_ajax_url,
                            data: {
                                ajax: true,
                                action: 'listFacture'
                            },
                            dataSrc: function(data) {
                                return data.data;
                            }
                        },
                        columns: [{
                                'searchable': false,
                                "targets": [0],
                                'orderable': false,
                                'render': function(data, type, full, meta) {
                                    var result = '';
                                    var showFacture = false;
                                    $.ajax({
                                        url: my_ajax_url,
                                        data: {
                                            ajax: true,
                                            action: 'listFacture',
                                        },
                                        dataType: 'json',
                                        success: function(response) {
                                            if (!response.showFacture) {
                                                $('#mytable-facture input[type=checkbox]')
                                                    .attr('disabled', true)
                                                $('#mytable-facture input[type=checkbox]')
                                                    .prop('disabled', true)
                                                swal({
                                                    text: revendeur,
                                                    icon: "warning",
                                                })
                                                $('#notifications container').innerHtml =
                                                    `<div class="alert alert-warning">` +
                                                    revendeur + `</div>`
                                            }
                                        }
                                    })
                                    if (full.typeFacture == 'avoir') {
                                        if (!full.etat_facture) {
                                            totaltopay += parseFloat(full.montant_payer);
                                            result =
                                                '<input type="checkbox" id=' + full.montant_payer +
                                                ' class="classavoir" name="factures[]" value="' +
                                                full.ref_facture +
                                                '" checked  />' + numavoir + full.ref_facture;
                                        } else {
                                            result = "<span  class='classavoir'> </span>" + numavoir +
                                                full.ref_facture;

                                        }
                                    } else {
                                        if (!full.etat_facture) {
                                            order_pay++
                                            result =
                                                '<input type="checkbox" id=' + full.montant_payer +
                                                ' class="classfact" name="factures[]" onchange="handleClickCheckbox(this,' +
                                                parseFloat(full.montant_payer) + ',' + order_pay +
                                                ' )" data-id=' + order_pay + '   value="' + full
                                                .ref_facture + '"/> ' + numfact + full.ref_facture;
                                        } else {
                                            result = "<span  class='classfact'> </span>" + numfact +
                                                full.ref_facture;
                                        }
                                    }
                                    if (meta.settings.json.data.length == meta.row + 1) {
                                        if (testpagechange) { totaltopay = totalavoir }
                                        $('#totalpay').text(totaltopay.toFixed(3));
                                    }
                                    return result
                                }
                            },
                            {
                                "visible": false,
                                "targets": [1],
                                'orderable': true,
                                "data": "ref_facture",
                                render: function(data) {
                                    return "<span class='colLabel'>" + reference + "</span>&nbsp;" +
                                        data
                                }
                            },
                            {
                                "data": "typeFacture",
                                'searchable': false,
                                "visible": false,
                                "targets": [2],
                                'orderable': false,
                                render: function(data) {
                                    if (data == 'avoir') return "<span class='colLabel'>" +
                                        typeFacture + "</span>&nbsp;" + avoir
                                    else
                                        return "<span class='colLabel'>" + typeFacture +
                                            "</span>&nbsp;" + facture
                                }
                            },
                            {
                                "data": "dateDeDebut",
                                "targets": [3],
                                render: function(data) {
                                    if (data != null) return "<span class='colLabel'>" + dateDebut +
                                        "</span>&nbsp;" + data
                                    else return '-'
                                }
                            },
                            {
                                "data": "dateDeFin",
                                "targets": [4],
                                render: function(data) {
                                    if (data != null) return "<span class='colLabel'>" + dateFin +
                                        "</span>&nbsp;" + data
                                    else return '-'
                                }
                            },
                            {
                                "data": "montant_payer",
                                "targets": [5],
                                render: function(data) {
                                    return "<span class='colLabel'>" + amount +
                                        "</span>&nbsp;<span style='direction:ltr !important'>" +
                                        data +
                                        "</span>"
                                }
                            },
                            {
                                "data": "date_echeance",
                                "targets": [6],
                                render: function(data) {
                                    if (data != null) return "<span class='colLabel'>" + echeance +
                                        "</span>&nbsp;" + data
                                    else return '-'
                                }
                            },
                            {
                                "data": "etat_facture",
                                "targets": [7],
                                "defaultContent": "",
                                'searchable': false,
                                'orderable': false,
                                render: function(data, type, row) {
                                    if (data) return "<span class='colLabel'>" + etat + "</span>" + paid
                                    return "<span class='colLabel' > " + etat + " </span>" + unpaid

                                }
                            },
                            {
                                "data": "ref_facture",
                                "targets": 7,
                                render: function(data, type, row) {
                                    return "<button type='button' onclick='pdf(`" + data + "`,`" + row
                                        .typeFacture +
                                        "`)'>" + consulter + "</button>"
                                }

                            }
                        ],
                        initComplete: function(settings, json) {
                            totalavoir = totaltopay;
                            $('#totalpay').text(totaltopay.toFixed(3));


                        },
                        language: {
                            url: "/js/datatable_lang/{$language.iso_code}.json",  
                        }
                    }).on('xhr.dt', function(e, settings, data, json) {
                        data.recordsTotal = data.recordsTotal;
                        data.recordsFiltered = data.recordsFiltered;
                        totaltopay = totalavoir;
                        if (totalavoir < 0) testpagechange = true;
                        $('#totalpay').text(totaltopay.toFixed(3));
                    }).on('preXhr.dt', function(e, settings, data) {
                        data.start = data.start;
                        data.length = data.length;
                        data.order = data.order;
                    });
                });

                function handleClickCheckbox(e, data, order_pay) {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    var unCheckedBoxes = []
                    var Boxes = []
                    //liste of non-checked invoices
                    checkboxes.forEach((facture) => {
                        if (facture.getAttribute('id') > 0) {
                            if (!facture.checked) {
                                unCheckedBoxes.push(facture)
                            }
                        }
                    })
                    checkboxes.forEach((facture) => {
                        if (facture.getAttribute('id') > 0) {
                            if (facture.checked) {
                                Boxes.push(facture)
                            }
                        }
                    })
                    if (e.checked) {
                        const condUnChecked = unCheckedBoxes.findIndex(element => {
                            if (element.getAttribute('data-id') > order_pay) {
                                return true;
                            }
                            return false;
                            console.log('tesst22', order_pay, element.getAttribute('data-id'))
                        });

                        console.log('condUnChecked == ', condUnChecked); // 👉️ 0
                        if (condUnChecked != -1) {
                            e.checked = false
                            swal({
                                text: previousInvoice,
                                icon: "warning",
                            })
                        } else {
                            totaltopay = totaltopay + data;
                            console.log('total to pay', totaltopay)
                            $('#chk_option_error').addClass('hidden');
                        }
                    } else {
                        totaltopay = totaltopay - data
                        Boxes.forEach((box) => {
                            if (box.getAttribute('data-id') < order_pay && box.checked) {
                                console.log('1111111')
                                totaltopay = totaltopay - parseFloat(box.id)
                                e.checked = false
                                box.checked = false
                                swal({
                                    text: previousInvoice,
                                    icon: "warning",
                                })

                            }
                        })
                    }
                    if (totaltopay <= 0) {
                        $('#listpaybtn').prop('disabled', true);
                    } else {
                        $('#listpaybtn').prop('disabled', false);
                        $("input[name='totalammount']").val(totaltopay.toFixed(3));
                    }
                    $('#totalpay').text(totaltopay.toFixed(3));
                };

                function handleData() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
                    if (!checkedOne) {
                        return false;
                    } else {
                        return true;
                    }
                }

                function pdf(ref_facture, typeFacture) {
                    $.ajax({
                        data: {
                            ajax: true,
                            action: 'ConsulterFacture',
                            ref_facture: ref_facture,
                            typeFacture: typeFacture
                        },
                        dataType: 'json'
                    }).done(function(response) {
                        if (response.success) {
                            const linkSource = `data:application/pdf;base64,` + response.data;
                            const downloadLink = document.createElement("a");
                            const fileName = "Facture N" + ref_facture + ".pdf";
                            downloadLink.type = "button"
                            downloadLink.href = linkSource;
                            downloadLink.download = fileName;
                            downloadLink.click();
                            return downloadLink
                        } else {
                            console.log("error pdf")
                            alert(alertPdf)
                        }
                    }).fail(function(error) {
                        // console.log('error:', error) 
                        alert(alertPdf)
                    })

                }
                document.addEventListener('contextmenu', (e) => e.preventDefault());

                function ctrlShiftKey(e, keyCode) {
                    return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
                }

                document.onkeydown = (e) => {

                    // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
                    if (
                        event.keyCode === 123 ||
                        ctrlShiftKey(e, 'I') ||
                        ctrlShiftKey(e, 'J') ||
                        ctrlShiftKey(e, 'C') ||
                        (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
                    )
                        return false;
                };
                []

                let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                $('#listpaybtn').click(function(evt) {
                    evt.preventDefault();
                    var idLists = []
                    var totalTest = 0
                    var Boxes = document.querySelectorAll('input[type="checkbox"]');
                    Boxes.forEach(element => {
                        if (element.checked) {
                            console.log('total pay', totaltopay);
                            idLists.push(element.getAttribute('data-id'))
                        }
                    })
                    console.log('cccc', idLists, Boxes.length, checkboxes);
                    ////data-id =1 is not found
                    if (idLists[0] != 1) {
                        console.log('eeeee')
                        evt.preventDefault();
                        swal({
                            text: previousInvoice,
                            icon: "warning",
                        })
                        $('#listpaybtn').prop('disabled', true);
                    } else {
                        if (idLists.length == 1 && idLists[0] == 1) {
                            return true
                        } else {
                            for (i = 0; i < idLists.length; i++) {
                                if (idLists[0] != idLists[1] - 1) {
                                    evt.preventDefault();
                                    swal({
                                        text: previousInvoice,
                                        icon: "warning",
                                    })
                                    $('#listpaybtn').prop('disabled', true);

                                } else {
                                    evt.preventDefault();
                                    console.log('continue', idLists[0], idLists[1] - 1)
                                    continue
                                }
                            }
                        }

                    }
                    console.log('idList111s', idLists);
                });
            </script>


        {/block}
{/block}