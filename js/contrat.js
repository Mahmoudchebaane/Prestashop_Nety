
$('#contact-link').ready(function () {
    $('tableContrat').innerHTML = ``;
    $.ajax({
        data: {
            ajax: true,
            action: 'listContrat',
        },
        dataType: 'json'
    }).done(function (response) {
        if (response.success) {
            liste = response.data
            if (liste != []) {
                // $('tableContrat').innerHTML +=
                $('#table-contrat').DataTable({
                    // processing: true,
                    bDestroy: true,
                    data: liste,
                    ajax: function (liste, callback) {
                        setTimeout(function () {
                            callback({
                                draw: liste.draw,
                                data: liste,
                            });
                        }, 5);
                    },
                    lengthMenu: [10, 25, 50, 75, 100],
                    columns: [
                        {
                            "data": "ref_contrat",
                            render: function (data) {
                                return "<span class='colLabel'>" + reference + "</span>&nbsp;" + data
                            }
                        },
                        {
                            "data": "date_contrat",
                            "defaultContent": '',
                            render: function (data) {
                                return "<span class='colLabel'>" + dateDebut + "</span>&nbsp;" + data.split('T')[0]
                            }
                        },
                        {
                            "data": "etat",
                            "defaultContent": '',
                            render: function (data) {
                                return "<span class='colLabel'>" + etat + "</span>&nbsp;" + encours
                            }
                        },
                        {
                            "data": null,
                            "defaultContent": '',
                            render: function (data) {
                                if (data.etat == 'ACTIVE' || data.etat == 'VALID' || data.etat == 'UNPAID') {
                                    return "<button onclick=pdf(`" + data.ref_contrat + "`)>" + consulter + "</button>"
                                }
                                else { return "<button disabled onclick=pdf(`" + data.ref_contrat + "`)>" + consulter + "</button>" }
                            },
                        }
                    ],
                    responsive: true,
                    language: {
                         url: 'js/datatable_lang/'+"{$language.iso_code}"+'.json', 
                    }
                })
            }
            else {
                $('tableContrat').innerHTML += 'pas de contrat trouvé'
            }
        }
        else {
            $('tableContrat').innerHTML += 'pas de contrat trouvé'
        }
    }).fail(function (error) {
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
    if (byteString.includes('PDF')) { type = { type: 'application/pdf' } }
    else { type = { type: 'image/jpeg' } }
    
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
    }).done(function (response) {
        if (response.success) {
            const base64URL = response.data;
            const fileName = "Contrat réf " + ref_contrat;
            base64URLtoFile(base64URL, fileName);
        }
        else {
            console.log("error pdf")

        }
    }).fail(function (error) {
        console.log('error:', error)
    })

}
