/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/


$.validator.setDefaults({ ignore: ":hidden" });

$.validator.addMethod("checkExist", function (value, element) {
    var existe = false;
    var response;
    $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': my_ajax_url,
        'data': {
            ajax: true,
            action: 'CheckExist',
            identifiant: $("input[name='identifiant']").val()
        },
        'success': function (data) {
            response = data;
        }
    });
    if (response) {
        if (response.data.verif == "false") {
            existe = false;
        } else {
            existe = true;
        }
    }

    return existe
}, IdentifiantExist);
jQuery.validator.addMethod("fixTest", function (value, element) {
    return this.optional(element) || /^[7]{1}[0-9]{7}$/.test(value);
}, telFixeInvalid);

jQuery.validator.addMethod("myphone", function (value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
}, formatInvalid);



var msg;
var dynamicErrorMsg = function () {
    return msg;
}
jQuery.validator.addMethod("mynumeric", function (value, element) {

    if ($("select[name='type_identifiant']").val() == "2") {
        msg = Letters;
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    } else if ($("select[name='type_identifiant']").val() == "3") {
        msg = Letters;
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }
    else {
        msg = formatInvalid;
        return this.optional(element) || /^[0-9]+$/.test(value);
    }
}, dynamicErrorMsg);


$.validator.addMethod("extension", function (value, element, param) {
    param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif|pdf";
    return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
}, ValidFile);


$(function () {


    if ($("#Modalnotif")) {
        $("#Modalnotif").modal('show');
        //    $("#Modalnotif").modal({show: true});
    }

    $('div.codeverifciation').hide();
    $('#captcha_error').text('');
    // Generate captcha on page load
    generateCaptcha();
    // Handle captcha refresh button click
    $("#refresh-captcha").click(function () {
        generateCaptcha();
        $("#captcha-input").val("");
    });

    var datagov = [] = $.map(listgouvernerat, function (obj) {
        return { id: obj.abreviation, text: obj.gouvernorat_name };
    });

    $("input[name='villeid']").select2({ width: '100%', data: [] }).on('change', function (e) {
        $("input[name='codepostale']").select2({ width: '100%', data: [] });
        $.ajax({
            url: my_ajax_url,
            data: {
                ajax: true,
                abrev_ville: e.val,
                action: 'GetCodePostal'
            },
            dataType: 'json',
            success: function (jsonData) {
                var data = [] = $.map(jsonData, function (obj) {
                    return { id: obj.abreviation, text: obj.name + ' | ' + obj.code };
                });
                $("input[name='codepostale']").select2({ data: data, width: '100%' }).val('').trigger("change");
            }
        });
    });
    $("input[name='codepostale']").select2({ width: '100%', data: [] });
    $("select[name='type_identifiant']").select2({ width: '100%' });
    $("input[name='gouvernoratid']").select2({ width: '100%', data: datagov }).on('change', function (e) {
        $("input[name='villeid']").select2({ width: '100%', data: [] });
        $("input[name='codepostale']").select2({ width: '100%', data: [] });
        var selectedgov = listgouvernerat.find(o => o.abreviation === e.val);
        var idgov = selectedgov.gouvernorat_id;

        $.ajax({
            url: my_ajax_url,
            data: {
                ajax: true,
                idgov: idgov,
                action: 'GetVille'
            },
            dataType: 'json',
            success: function (jsonData) {

                var data = [] = $.map(jsonData, function (obj) {

                    return { id: obj.abreviation, text: obj.ville_name };
                });
                $("input[name='villeid']").select2({ data: data, width: '100%' }).val('').trigger("change");
            }
        });
    });
    $("input[name='telfixe']").attr('type', 'hidden');

    $("div.rowfix").hide();

    $('#inlineRadioOui').on("click", function () {
        $("input[name='telfixe']").attr('type', 'text');
        $("div.rowfix").show();

    });

    $('#inlineRadioNon').on("click", function () {
        $("input[name='telfixe']").attr('type', 'hidden');
        $("div.rowfix").hide();
        $("input[name='telfixe']").val('');

    });


    $("#formDA").validate({
        onkeyup: false,
        onfocusout: function (element) { if ($(element).attr('name') == 'identifiant') $(element).valid(); },
        onclick: false,
        rules: {
            email: {
                email: true
            },
            identifiant: {
                required: true,
                minlength: function () {
                    if ($("select[name='type_identifiant']").val() == "1") {
                        return 8;
                    }
                    else if ($("select[name='type_identifiant']").val() == "3") { return 6 }
                    else {
                        return 13;
                    }
                },
                maxlength: function () {
                    if ($("select[name='type_identifiant']").val() == "1") {
                        return 8;
                    }
                    else if ($("select[name='type_identifiant']").val() == "3") { return 12 }
                    else {
                        return 13;
                    }
                },
                mynumeric: true,
                checkExist: true
            },
            photocin1: {
                required: true,
                extension: true
            },
            photocin2: {
                required: true,
                extension: true
            },
            codeadresse: {
                required: true
            },
            telfixe: {
                fixTest: true
            },
            telmobile: {
                myphone: true
            }
        },
        messages: { // identifiant: {checkExist : "Identifiant déja utilisé"},
            codeadresse: "Veuillez cliquer sur votre emplacement sur la carte. "
        },
        highlight: function (element) {
            var elem = $(element);
            elem.closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if ($('#sms_error'))
                $('#sms_error').text('');

            if (element.parent('.form-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });


    /* This code handles all of the navigation stuff.
  ** Probably leave it. Credit to https://bootsnipp.com/snippets/featured/form-wizard-and-validation
  */
    var navListItems = $('div.setup-panel div a'),
        navItemsTitle = $('div.setup-panel div p')
    allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');
    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this), isValid = true;

        if (!$item.hasClass('disabled')) {

            var stepNumber = $item.attr("href").match(/\d+/);

            stepNumber = stepNumber[0];
            stepNumber = stepNumber - 1;
            while (stepNumber > 0) {
                var lastStep = $("#step-" + stepNumber);
                var listInputs = lastStep.find("input,select,textarea").not(':hidden');

                for (var i = 0; i < listInputs.length; i++) {
                    if (!$(listInputs[i]).valid()) {
                        isValid = false; break;
                    }
                }
                stepNumber = stepNumber - 1;
            }

            if (isValid) { // navListItems.removeClass('btn-step').addClass('btn-outline-step');
                navListItems.removeClass('btn-step');
                navItemsTitle.removeClass('active-title');
                $item.next().addClass('active-title');
                navListItems.addClass('btn-outline-step');
                $item.removeClass('btn-outline-step');
                $item.addClass('btn-step');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();

                if ($item.hasClass('beforelaststep')) {
                    setconfirmsection();
                }
            }


        }


    });

    /* Handles validating using jQuery validate.
  */
    allNextBtn.click(function () {


        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input,select,textarea").not(':hidden'),
            isValid = true;

        // Loop through all inputs in this form group and validate them.
        for (var i = 0; i < curInputs.length; i++) {

            if (!$(curInputs[i]).valid()) {
                isValid = false;
            }
        }
        if (isValid) { // Progress to the next page.
            nextStepWizard.removeClass('disabled').trigger('click');
        }

    });
    $('div.setup-panel div a.btn-step').trigger('click');
});


$('#confirmbtn').on("click", function () {

    $('#captcha_error').text('');
    // Validate captcha
    var captchaInput = $("#captcha-input").val();
    var captchaCode = sessionStorage.getItem("captchaCode");
    if (captchaInput != captchaCode) {
        $("#captcha_error").text(MsgErrorCaptcha);
    } else {
        $('#sms_error').text('');
        $('div.codeverifciation').show();
        $('#confirmbtn').parent().remove();
        $('#renvoyersms').removeClass('d-none');
        $('#sms_error').text('');
        $.ajax({
            url: my_ajax_url,
            data: {
                ajax: true,
                action: 'GetCode',
                numtel: $("input[name='telmobile']").val(),
                codesms: false
            },
            dataType: 'json',
            success: function (response) { // console.log('send sms respopnse' ,response);
                if (response.success) {
                    $('#sms_error').text('');
                } else {
                    $('#sms_error').text('Echec : ' + response.message);
                }
            }
        });
    }

});

$('#renvoyersms').on("click", function () {

    $('#sms_error').text('');
    $.ajax({
        url: my_ajax_url,
        data: {
            ajax: true,
            action: 'GetCode',
            numtel: $("input[name='telmobile']").val(),
            codesms: false
        },
        dataType: 'json',
        success: function (response) { // console.log('send sms respopnse' ,response);
            if (response.success) {
                $('#sms_error').text('');
            } else {
                $('#sms_error').text('Echec : ' + response.message);
            }
        }
    });

});

$('#submitDA').on("click", function () {
    document.getElementById('submitDA').setAttribute('disabled', '');
    $('#submitDA').addClass('disabled');
    $('#sms_error').text('');
    $.ajax({
        url: my_ajax_url,
        data: {
            ajax: true,
            action: 'CheckCode',
            numtel: $("input[name='telmobile']").val(),
            codesms: $("input[name='codemobile']").val()
        },
        dataType: 'json'

    }).done(function (response) {
        if (response.success) {
            $('#sms_error').text('');
            $("#submit").click();
            return false;
        } else {
            document.getElementById('submitDA').removeAttribute('disabled');
            $('#submitDA').removeClass('disabled');
            // $('#sms_error').text('Echec : ' + response.message);
            switch (response.message) {
                case 1: $('#sms_error').text(echec + ' : ' + MsgError);
                case 2: $('#sms_error').text(echec + ' : ' + MsgValid);
                case 3: $('#sms_error').text(echec + ' : ' + MsgExpire);
                case 4: $('#sms_error').text(echec + ' : ' + MsgInvalid);


                default: null;
            }

        }

    }).fail(function (error) {
        document.getElementById('submitDA').removeAttribute('disabled');
        $('#submitDA').removeClass('disabled');
    });

});

document.getElementById("formDA").onkeypress = function (e) {
    var key = e.charCode || e.keyCode || 0;
    if (key == 13) {
        e.preventDefault();
    }
}

function setconfirmsection() {
    $("#debit").text($("input[name='produitid']:checked").parent().text());
    $("#period").text($("input[name='periodpaiement_id']:checked").parent().text());
    $("#identifiant").text($("input[name='identifiant']").val());
    $("#numtel").text($("input[name='telmobile']").val());
    $("#nom").text($("input[name='first_name']").val());
    $("#prenom").text($("input[name='last_name']").val());
    $("#email").text($("input[name='email']").val());
    $("#residence").text($("input[name='locataire']:checked").parent().text());
    $("#codpostal").text($("input[name='codepostale']").select2('data').text);
    // $("#codpostal").text($("input[name='codepostale']").val());
    $("#adr").text($("textarea[name='adresse']").val());
    $("#gov").text($("input[name='gouvernoratid']").select2('data').text);
    $("#ville").text($("input[name='villeid']").select2('data').text);
    $("#numfixe").text($("input[name='telfixe']").val());

}


// Define the function generateCaptcha()
function generateCaptcha() {
    $('#captcha_error').text('');
    // Get the canvas element with ID captcha and create an instance of its canvas rendering context
    var a = $("#captcha")[0],
        b = a.getContext("2d");
    // Clear the canvas
    b.clearRect(0, 0, a.width, a.height);
    // Define the string of characters that can be included in the captcha
    // var f = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",
    var f = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789",
        e = "",
        g = -45,
        h = 45,
        i = h - g,
        j = 20,
        k = 30,
        l = k - j;
    // Generate each character of the captcha
    for (var m = 0; m < 6; m++) {
        // Select random letter from the pool to be part of the captcha
        var n = f.charAt(Math.floor(Math.random() * f.length));
        e += n;

        // Set up the text formatting
        b.font = j + Math.random() * l + "px Arial";
        b.textAlign = "center";
        b.textBaseline = "middle";

        // Set the color of the text
        b.fillStyle = "rgb(" + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + "," + Math.floor(Math.random() * 256) + ")";

        // Add the character to the canvas
        var o = g + Math.random() * i;
        b.translate(20 + m * 30, a.height / 2);
        b.rotate(o * Math.PI / 180);
        b.fillText(n, 0, 0);
        b.rotate(-1 * o * Math.PI / 180);
        b.translate(-(20 + m * 30), -1 * a.height / 2);
    }
    // Set the captcha code in session storage
    sessionStorage.setItem("captchaCode", e);
}