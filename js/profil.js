// document.addEventListener('contextmenu', (e) => e.preventDefault());

// function ctrlShiftKey(e, keyCode) {
//     return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
// }

// document.onkeydown = (e) => {

//     // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
//     if (
//         event.keyCode === 123 ||
//         ctrlShiftKey(e, 'I') ||
//         ctrlShiftKey(e, 'J') ||
//         ctrlShiftKey(e, 'C') ||
//         (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
//     )
//         return false;
// };



  function changePass() {
    var profil = document.getElementById('changePass')
    profil.style.display = 'flex'
    var pass = document.getElementById('profilChange')
    pass.style.display = 'none'

    $('input[name="testPass"]').val("2");
    $('input[type="password"]').prop('required', true);

    var passBtn = document.getElementById('PassBtn')
    PassBtn.style.display = 'none'
    var passLink = document.getElementById('passLink')
    passLink.style.display = 'none'

    var idenLink = document.getElementById('idenLink')
    idenLink.style.display = 'block'
    var identityBtn = document.getElementById('identityBtn')
    identityBtn.style.display = 'block'
  }

  function backToidentity() {
    var profil = document.getElementById('profilChange')
    profil.style.display = 'flex'
    profil.style.flexDirection = 'column'
    var pass = document.getElementById('changePass')
    pass.style.display = 'none'

    $('input[type="password"]').prop('required', false);
    $('input[name="testPass"]').val("1");

    var identityBtn = document.getElementById('identityBtn')
    identityBtn.style.display = 'none'
    var idenLink = document.getElementById('idenLink')
    idenLink.style.display = 'none'

    var passBtn = document.getElementById('PassBtn')
    PassBtn.style.display = 'block'
    var passLink = document.getElementById('passLink')
    passLink.style.display = 'block'

  }
$(document).ready(function () {
    $(':input[type="password"]').each(function() {          
        $(this).parent().parent().parent().find('label').addClass('required');
      });
     
    var client
    $.ajax({
        type: 'POST',
        data: {
            ajax: true,
            action: 'GetUpdateCRM',
        },
        dataType: 'json'
    }).done(function (response) {
        if (response.success) {
            client = response.data.data
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
            $("input[name='ref_abonnement']").css("background-color", " #e9e9e9");

            $("input[name='firstname']").css("pointer-events", " none");
            $("input[name='lastname']").css("pointer-events", " none");
            $("input[name='ref_client']").css("pointer-events", " none");
            $("input[name='num_fixe']").css("pointer-events", " none");          
            $("input[name='ref_abonnement']").css("pointer-events", " none");
            // document.getElementById("customer-form").reset();
        }
        else {
           
        }
    }).fail(function (error) {
        console.log('erruuuor=', error)
    });
})


