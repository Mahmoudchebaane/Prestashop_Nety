document.addEventListener('contextmenu', (e) => e.preventDefault());

function ctrlShiftKey(e, keyCode) {
  return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
}

document.onkeydown = (e) => {

  // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
  if (
    event.keyCode === 123 ||
    // event.keyCode === 46 ||
    ctrlShiftKey(e, 'I') ||
    ctrlShiftKey(e, 'J') ||
    ctrlShiftKey(e, 'C') ||
    (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
  )
    return false;
};

document.addEventListener('contextmenu', (e) => e.preventDefault());
document.onkeydown = (e) => {
  if (event.keyCode === 46) {  
    $('#paybtn').off('click');
    
    evt.preventDefault();
    swal({
      text: 'nope',
      icon: "error",
    })
    $('#paybtn').prop('disabled', true);
    return false
  }
}

//payment steps displays
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById('payStep2').style.display = 'none'
  document.getElementById('payStep1').style.display = 'block'
});
const BreakError = {};

function checkboxchange(e, order_pay) {
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
      if (element.getAttribute('data-id') < order_pay) {
        return true;
      }
      return false;
    });

    console.log('condUnChecked == ', condUnChecked); // 👉️ 0
    if (condUnChecked == 0) {
      e.checked = false
      swal({
        text: previousInvoice,
        icon: "warning",
      })
    } else {
      totaltopay = totaltopay + parseFloat(e.id);
      // idLists.push(order_pay)
      $('#chk_option_error').addClass('hidden');
    }

  } else {

    totaltopay = totaltopay - parseFloat(e.id)
    Boxes.forEach((box) => {
      if (box.getAttribute('data-id') > order_pay && box.checked) {
        swal({
          text: previousInvoice,
          icon: "warning",
        })
        totaltopay = totaltopay - parseFloat(box.id)
        e.checked = false
        box.checked = false

      }

    })
  }
  if (totaltopay <= 0) {
    $('#paybtn').prop('disabled', true);
  } else {
    $('#paybtn').prop('disabled', false);
  }
  $(".total").html(Total + ': &emsp; ' + totaltopay.toFixed(3) + TND);
  $("input[name='totalammount']").val(totaltopay.toFixed(3));
};
//Go to payment Btn function
function handleData() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
  if (!checkedOne) {
    $('#chk_option_error').removeClass('hidden');
    return false;
  } else {
    $('#chk_option_error').addClass('hidden');
    return true;
  }
}
//display invoice list btn click
var listfact = "", order_pay = 0, totaltopay = 0; var idLists = []
function goToPayment(identif, event) {
  $(event.target).prop('disabled', true);
  $.ajax({
    url: my_ajax_url,
    data: {
      type_identif: identif,
      identifiant: $("input[name='identif" + identif + "']").val().trim(),
      action: 'GetFactures'
    },
    dataType: 'json',
    success: function (jsonData) {

      if (jsonData.success) {
       
        if (jsonData.data.factures != null) {
          if (!jsonData.showfacture) {
            $('#paybtn').addClass('disabled')
            $('#paybtn').prop('disabled', true);
            $('#paybtn').attr('disabled', true)
            $('#paybtn').css("pointer-events", "none");
            $('#paybtn').css("cursor", "not-allowed");
            $('#paybtn').css("opacity", "0.5");
            swal({
              // title: messageDeleteTitle,
              text: revendeur,
              icon: "warning",
              // buttons: true,
              // buttons: [messageDeleteCancelText, messageDeleteConfirmText],
              // dangerMode: true,
            })
            $('#paybtn').addClass('disabled')
            $('#paybtn').prop('disabled', true);
            $('#paybtn').attr('disabled', true)
            $('#paybtn').css("pointer-events", "none");
            $('#paybtn').css("cursor", "not-allowed");
            $('#paybtn').css("opacity", "0.5");
          }
          //list of invoices return null (factures==null)
          jsonData.data.factures.forEach(function callback(element, index) {
            var checked = "";
            if (index == 0 || element.typeFacture == "avoire") {
              totaltopay += element.total_ttc;
              checked = "checked";
            }
            //if invoice type : avoir
            if (element.typeFacture == "avoire") {
              listfact += '<div  class="d-flex w-100">' + '<div class="avoirCheckbox factureCheckbox " for="formCheckChecked">' + '<div class="detailFacture">' + '<div class="leftText">' + '<div class="d-flex align-items-center d-xs-block">' + '<p class="numFacture">' + numavoir + ': ' + element.ref_facture + ' </br>' +
                '</div>' + '</div>' + '<div class="rightText">' + '<p class="prixFacture"><span style="direction:ltr !important" >' + element.total_ttc.toFixed(3) + '</span>' + TND + '</span></p> ' + '</div>' + '</div>' +
                '<a type="button" class="btn btn-lg btn-default" href="data:application/pdf;base64,' + encodeURI(element.pdf_facture) + '" target="_blank" type="application/pdf"  download="Facture N°' + element.ref_facture + '.pdf" >' + btnfact + ' <i class="zmdi font-size-17 hidden-sm-down zmdi-eye"></i></a>' + '</div>' + '<input class="ticBox" type="checkbox" id="' + element.total_ttc + '" value="' + element.ref_facture + '" name="factures[]" ' + checked + ' style="pointer-events : none; opacity: 0.5;"  />' + '</div>';
            } else {
              //if invoice type : invoice
              if (jsonData.showfacture) {
                //first invoice paid: return list of all invoices 
                order_pay++
                document.querySelector('#paybtn').setAttribute('disabled', true);
                $('#paybtn').prop('disabled', true);
                listfact += '<div  class="d-flex w-100 ">' + '<div class="factureCheckbox" for="formCheckChecked">' + '<div class="detailFacture">' + '<div class="leftText">' + '<div class="d-flex align-items-center d-xs-block">' + '<p class="numFacture">' + numfact + ': ' + element.ref_facture + ' </br><span class="text-muted font-size-12"> ' + Du + '&nbsp' + element.dateDeDebut + '&nbsp' + Au + '&nbsp' + element.dateDeFin + '</span></p>' +
                  '</div>' + '</div>' + '<div class="rightText">' + '<p class="prixFacture">' + element.total_ttc.toFixed(3) + TND + '</p> ' + '<p class="payerAvant">' + payerAvant + ': ' + element.echeance + '</p>' + '</div>' + '</div>' +
                  '<a type="button" class="btn btn-lg btn-default" href="data:application/pdf;base64,' + encodeURI(element.pdf_facture) + '" target="_blank" type="application/pdf"  download="Facture N°' + element.ref_facture + '.pdf" >' + btnfact + ' <i class="zmdi font-size-17 hidden-sm-down zmdi-eye"></i></a>' + '</div>' + '<input class="ticBox"   type="checkbox"  id="' + element.total_ttc + '" value="' + element.ref_facture + '" name="factures[]" ' + checked + ' onclick="checkboxchange(this,' + order_pay + ')"  data-id=' + order_pay + '  />' + '</div>';
                $('#paybtn').prop('disabled', true);
              } else {
                //first invoice unpaid: disable all invoices and return a message              
                $('#paybtn').prop('disabled', true);
                listfact += '<div  class="d-flex w-100">' + '<div class="factureCheckbox" for="formCheckChecked">' + '<div class="detailFacture">' + '<div class="leftText">' + '<div class="d-flex align-items-center d-xs-block">' + '<p class="numFacture">' + numfact + ': ' + element.ref_facture + ' </br><span class="text-muted font-size-12"> ' + Du + '&nbsp' + element.dateDeDebut + '&nbsp' + Au + '&nbsp' + element.dateDeFin + '</span></p>' +
                  '</div>' + '</div>' + '<div class="rightText">' + '<p class="prixFacture">' + element.total_ttc.toFixed(3) + TND + '</p> ' + '<p class="payerAvant">' + payerAvant + ': ' + element.echeance + '</p>' + '</div>' + '</div>' +
                  '<a type="button" class="btn btn-lg btn-default" href="data:application/pdf;base64,' + encodeURI(element.pdf_facture) + '" target="_blank" type="application/pdf"  download="Facture N°' + element.ref_facture + '.pdf" >' + btnfact + ' <i class="zmdi font-size-17 hidden-sm-down zmdi-eye"></i></a>' + '</div>' + '<input class="ticBox" disabled=true type="checkbox" id="' + element.total_ttc + '" value="' + element.ref_facture + '" name="factures[]" ' + checked + ' onclick="checkboxchange(this,' + order_pay + ')"  data-id=' + order_pay + '  />' + '</div>';
              }
            }
          });
        }
        else {
          //list of invoices return null (factures==null)
          swal({
            // title: messageDeleteTitle,
            text: noInvoices,
            icon: "warning",
            // buttons: true,
            // buttons: [messageDeleteCancelText, messageDeleteConfirmText],
            // dangerMode: true,
          })
          // alert(noInvoices)
        }

        if (totaltopay <= 0) {
          //if total: invoice + avoir < 0
          $('#paybtn').prop('disabled', true);
        } else {
          //if total: invoice + avoir > 0
          $('#paybtn').prop('disabled', false);
        }

        $("#fact_list").html('');
        if (!jsonData.showfacture) {
          var divRevendeur = '<div class="alert alert-danger">' + revendeur + '</div>'
          $("#fact_list").html(divRevendeur + listfact)
        } else {
          $("#fact_list").html(listfact);
        }


        var pied = '<div><p  class=" mb-5 mr-10 font-weight-bold font-size-19 text-black" >' + Client + ': &nbsp; ' + jsonData.data.client.name + '</p>' + '<p> ' + numfixe + ': ' + jsonData.data.client.num_fixe + '</p></div>' + '<p class="total">' + Total + ': &emsp; <span style="direction:ltr !important" >' + totaltopay.toFixed(3) + '</span>' + TND + '</p>' + '<input type="hidden" name="numfixe" value="' + jsonData.data.client.num_fixe + '"/>' + '<input type="hidden" name="clientname" value="' + jsonData.data.client.name + '"/>' + '<input type="hidden" name="refabonn" value="' + jsonData.data.client.ref_abonnement + '"/>'
          + '<input type="hidden" name="totalammount" value="' + totaltopay.toFixed(3) + '"/>';

        $("#info_pied").html('');
        $("#info_pied").html(pied);
        document.getElementById('payStep1').style.display = 'none'
        document.getElementById('payStep2').style.display = 'block'
      } else {
        $('div.errormsg').remove();
        if (jsonData.code == 'NOF') {
          $(event.target).after('<div class="text-danger font-size-18 errormsg">' + NOF + '</div>');
        } else if (jsonData.code == 'NC') {
          $(event.target).after('<div class="text-danger font-size-18 errormsg">' + NC + '</div>');
        } else if (jsonData.code == 'NL') {
          $(event.target).after('<div class="text-danger font-size-18 errormsg">' + NL + '</div>');
        }
        else if (jsonData.code == 'NF') {
          $(event.target).after('<div class="text-danger font-size-18 errormsg">' + NF + '</div>');
        } else {
          $(event.target).after('<div class="text-danger font-size-18 errormsg">' + EROR + '</div>');
        }
        $(event.target).prop('disabled', false);
      }

    },
    error: function (error) {
      $(this).prop('disabled', false);
      console.log(error);
    }
  });
}




let checkboxes = document.querySelectorAll('input[type="checkbox"]');
$('#paybtn').click(function (evt) {
 
  var idLists = []
  var totalTest = 0
  var Boxes = document.querySelectorAll('input[type="checkbox"]');
  Boxes.forEach(element => {
    if (element.checked) {
      idLists.push(element.getAttribute('data-id'))
    }
  })

  ////data-id =1 is not found
  if (idLists[0] != 1) {   
    evt.preventDefault();
    swal({
      text: previousInvoice,
      icon: "warning",
    })
    $('#paybtn').prop('disabled', true);
  }
  else {
    if (idLists.length == 1 && idLists[0] == 1) {
      return true
    }
    else {
      for (i = 0; i < idLists.length; i++) {
        if (idLists[0] != idLists[1] - 1) {
          evt.preventDefault();
          swal({
            text: previousInvoice,
            icon: "warning",
          })
          $('#paybtn').prop('disabled', true);
          
        }
        else {
          
          continue
        }
      }
    }

  }

});






