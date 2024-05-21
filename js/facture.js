 
$(document).ready(function () {

    $('#table-facture').on('preXhr.dt', function (e, settings, data) {
        //console.log("API 1---------------------", data)
        data.start = data.start;
        data.length = data.length;
        data.order = data.order
    }); 
    var table = $('#table-facture').DataTable({
        processing: true,
        serverSide: true,
        order: [1, 'desc'],
        searching: true,
        bDestroy: true,
        ajax: {
            type: 'POST',
            url: my_ajax_url,
            data: {
                ajax: true,
                action: 'listFacture'
            },
            dataSrc: function (data) { 
                return data.data;
            }
        },
        columns: [
            {
                "data": "ref_facture",
                render: function (data) {
                  
                    return "<span class='colLabel'>" + reference + "</span>&nbsp;" + data
                }
            },
            {
                "data": "date_de_debut",
                render: function (data) {
                    if (data != null) {return "<span class='colLabel'>" + dateDebut + "</span>&nbsp;" + data}
                    else return '-'
                }
            },
            {
                "data": "date_de_fin",
                render: function (data) {
                    if (data != null) {return "<span class='colLabel'>" + dateFin + "</span>&nbsp;" + data}
                    else return '-'
                }

            },
            {
                "data": "montant_payer",
                render: function (data) {
                    return "<span class='colLabel'>" + amount + "</span>&nbsp;" + data
                }
            },
            {
                "data": "date_echeance",
                render: function (data) {
                    if (data != null){return "<span class='colLabel'>" + echeance + "</span>&nbsp;" + data}
                    else return '-'
                }
            },
            {
                "data": "etat_facture",
                "defaultContent": "",
                render: function (data) {
                    if (data) { return "<span class='colLabel'>" + etat + "</span>" + paid }
                    return "<span class='colLabel' > " + etat + " </span>" + unpaid
                }
            },
            {
                "data": "ref_facture",
                "defaultContent": "<button>" + consulter + "</button>",
                render: function (data) {
                    if (data.includes('AVR') ){return "<button style='background-color:grey' >" + consulter + "</button>"}
                    else {return "<button onclick='pdf(`" + data + "`)'>" + consulter + "</button>"}
                }

            }
        ],
        responsive: true,
        language: {
            lengthMenu: display + " _MENU_ ",//+ records
            processing: proccessing,
            paginate: {
                previous: prev,
                next: next,
                first: first,
                last: last
            },
            zeroRecords: zero,
            search: search,
            select: {
                show: "s",
                entities: 'e'
            },
            info: showing + " _START_ " + to + " _END_ " + sur + " _TOTAL_ " + total,
            infoFiltered: '- ' + filtred + ' MAX ' + total,
            infoEmpty: entries
        }
    },);

    $('#table-facture').on('xhr.dt', function (e, settings, data, json) {
        data.recordsTotal = data.recordsTotal;
        data.recordsFiltered = data.recordsFiltered;
    });


});
  
function pdf(ref_facture) {
    $.ajax({
        data: {
            ajax: true,
            action: 'PdfFacture',
            ref_facture: ref_facture
        },
        dataType: 'json'
    }).done(function (response) {
        if (response.success) {
             const linkSource = `data:application/pdf;base64,` + response.data;
            const downloadLink = document.createElement("a");
            const fileName = "Facture N" + ref_facture + ".pdf";
            downloadLink.type = "button"
            downloadLink.href = linkSource;
            downloadLink.download = fileName;
            downloadLink.click();
            return downloadLink
        }
        else {
            // console.log("error pdf")
            alert(alertPdf)
        }
    }).fail(function (error) {
        // console.log('error:', error)
        alert(alertPdf)
    })

}

