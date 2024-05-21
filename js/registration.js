document.addEventListener('contextmenu', (e) => e.preventDefault());

function ctrlShiftKey(e, keyCode) {
    return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
}

document.onkeydown = (e) => {

    // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
    if (
        event.keyCode === 123 ||
        event.keyCode === 46 ||
        ctrlShiftKey(e, 'I') ||
        ctrlShiftKey(e, 'J') ||
        ctrlShiftKey(e, 'C') ||
        (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
    )
        return false;
};


function secondStep() {
    // authOptions.innerHTML += `<div id='notification'></div>`
    var notif = document.getElementById('notification')
    notif.innerHTML = ``
    var registerOption = $('input[name="registerOptions"]')
    if (document.getElementById('email').checked) {
        registerOption.val('1')       
        var form = document.getElementById('SubscriptionForm')
        form.style.display = 'flex'
        var authOptions = document.getElementById('authOptions')
        authOptions.style.display = 'none'
    } else if (document.getElementById('contrat').checked) {
        registerOption.val('2')
        var form = document.getElementById('recuperation')
        form.style.display = 'flex'
        var authOptions = document.getElementById('authOptions')
        authOptions.style.display = 'none'
    } else {
        var authOptions = document.getElementById('authOptions')
        notif.innerHTML += chooseOption
        // authOptions.innerHTML += `<div id='notification'>` + chooseOption + `</div>`
    }
}

function thirdstep() {
    var form = document.getElementById('SMS')
    form.style.display = 'flex'
    $('div.codeverifciation').show()
    var authOptions = document.getElementById('recuperation')
    authOptions.style.display = 'none'
}

function fourthStep() {
    var form = document.getElementById('SubscriptionForm')
    form.style.display = 'flex'
    var authOptions = document.getElementById('SMS')
    authOptions.style.display = 'none'
}

function prevStep() {
    var recuperation = document.getElementById('recuperation')
    recuperation.style.display = 'none'
    var authOptions = document.getElementById('authOptions')
    authOptions.style.display = 'flex'
}

$('#renvoyersms').on("click", function () {
    $('#sms_error').text('');
    $.ajax({
        data: {
            ajax: true,
            action: 'GetCode',
            numtel: $("input[name='num_mobile']").val(),
            codesms: false
        },
        dataType: 'json',
        success: function (response) { // console.log('send sms respopnse' ,response);
            if (response.success) {
                $('#sms_error').text('');
                $("input[name='ref_client']")
                $("input[name='num_fixe']")
            } else {
                $('#sms_error').text(Echec + ': ' + response.message);
            }
        }
    });
});


function getAbonnCRM() {

    var client
    $('#errorIdent').text('');
    $('#errorFixe').text('');
    $('#errorRegister').text('');
    
    $.ajax({
        type: 'POST',
        data: {
            ajax: true,
            action: 'GetParameters',
            identifiant: $.trim($("input[name='identifiant']").val()),
            num_fixe: $.trim($("input[name='num_fixe']").val()),
        },
        dataType: 'json'
    }).done(function (response) {
        var identifiant = $("input[name='identifiant']").val()
        var num_fixe = $("input[name='num_fixe']").val()
        if (response.success) {
            client = response.client.data
            $("input[name='num_mobile']").val(client.num_mobile)
            //thirdstep()
            var form = document.getElementById('SMS')
            form.style.display = 'flex'
            $('div.codeverifciation').show()
            var authOptions = document.getElementById('recuperation')
            authOptions.style.display = 'none'
            $('#submitCode').on("click", function () {
                $('#sms_error').text('');
                if ($("input[name='codemobile']").val() == "") {
                    $('#sms_error').text(required);

                } else {
                    document.getElementById('submitCode').setAttribute('disabled', '');
                    $('#submitCode').addClass('disabled');
                    $('#sms_error').text('');
                    $.ajax({

                        data: {
                            ajax: true,
                            action: 'CheckCode',
                            numtel: $("input[name='num_mobile']").val(),
                            codesms: $("input[name='codemobile']").val(),
                            submitCreate2: $("input[name='submitCreate2']").val()
                        },
                        dataType: 'json'

                    }).done(function (response) {
                        if (response.success) {
                            $('#sms_error').text('');
                            $("#submit").click();
                            var form = document.getElementById('SubscriptionForm')
                            form.style.display = 'flex'
                            var authOptions = document.getElementById('SMS')
                            authOptions.style.display = 'none'
                            document.getElementById("customer-form").reset();

                            $("input[name='firstname']").val(client.prenom);
                            $("input[name='lastname']").val(client.nom);
                            $("input[name='ref_client']").val(client.identifiant);
                            $("input[name='num_fixe']").val(client.num_fixe);
                            $("input[name='phone']").val(client.num_mobile);
                            $("input[name='ref_abonnement']").val(client.ref_aonnement);
                            $("input[name='email']").val(client.email);

                            $("input[name='firstname']").css("background-color", " #e9e9e9");
                            $("input[name='lastname']").css("background-color", " #e9e9e9");
                            $("input[name='ref_client']").css("background-color", " #e9e9e9");
                            $("input[name='num_fixe']").css("background-color", " #e9e9e9");
                            $("input[name='phone']").css("background-color", " #e9e9e9");
                            $("input[name='ref_abonnement']").css("background-color", " #e9e9e9");

                            $("input[name='firstname']").css("pointer-events", " none");
                            $("input[name='lastname']").css("pointer-events", " none");
                            $("input[name='ref_client']").css("pointer-events", " none");
                            $("input[name='num_fixe']").css("pointer-events", " none");
                            $("input[name='phone']").css("pointer-events", " none");
                            $("input[name='ref_abonnement']").css("pointer-events", " none");

                            // return false;

                        } else {
                            document.getElementById('submitCode').removeAttribute('disabled');
                            $('#submitCode').removeClass('disabled');
                            // $('#sms_error').text(echec + ' : ' + response.message);
                            switch (response.message) {
                                case 1: $('#sms_error').text(echec + ' : ' + MsgError); break;
                                case 2: $('#sms_error').text(echec + ' : ' + MsgValid); break;
                                case 3: $('#sms_error').text(echec + ' : ' + MsgExpire); break;
                                case 4: $('#sms_error').text(echec + ' : ' + MsgInvalid); break;
                                default: null;
                            }
                        }
                    })

                        .fail(function (error) {
                            document.getElementById('submitCode').removeAttribute('disabled');
                            $('#submitCode').removeClass('disabled');
                        });
                }
            });
            // document.getElementById("customer-form").reset();
        }
        else {

            switch (response.code) {
                case 'PARAMS_MISSING':
                    if (identifiant == '') { $('#errorIdent').text(IdentManq); }
                    else if (num_fixe == '') { $('#errorFixe').text(telManq); }
                    else { $('#errorRegister').text(paraManq); }
                    break;
                case 'NUM_FIXE_NOT_VALID':
                    if (num_fixe == '') { $('#errorFixe').text(telManq); }
                    else { $('#errorFixe').text(echec + ' : ' + testFix); }
                    break;
                case 'CLIENT_NOT_FOUND': $('#errorRegister').text(echec + ' : ' + paraInvalid); break;
                case 'IDENT_EXISTE': $('#errorIdent').text(echec + ' : ' + IdentifiantExist); break;
                case 'IDENT_MANQ': $('#errorIdent').text(echec + ' : ' + IdentManq); break;
                default: $('#errorRegister').text(echec + ' : ' + paraError); break;
            }
        }
    }).fail(function (error) {
        console.log('error=', error)
    });
}

$("#btn-confirm_password").on("click", function () {
    var a = $('input[name="confirm_password"]');
    if ("password" === a.attr("type")) {
        $('input[name="confirm_password"]').attr("type", "text");
    } else {
        $('input[name="confirm_password"]').attr("type", "password");
    }
})

