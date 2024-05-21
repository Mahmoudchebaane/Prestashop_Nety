var map;
var markers = [];
var markerCluster;

console.log('cluster marker', markerCluster)
function FilterStores() {
    $.ajax({
        url: testGov,
        data: {
            ajax: true,
            action: 'GetGov',
            gov: $("input[name='selectedGov']").val().toUpperCase(),
            search: $("input[name='Search']").val().toUpperCase(),
        },
        dataType: 'json',
    }).done(function (response) {
        if (response.success) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
                markerCluster.removeMarker(markers[i]);
            }
            markers = [];
            document.getElementById('listestore').innerHTML = ``;
            const stores = response.Filtredlist;
            const iconBase = "/img/ggggg.png";
            stores.forEach(store => {
                if (store.email != 0) {
                    var email =
                        `  <tr class="d-flex">
                                    <td class="storeLabel">Email:</td>
                                    <td class="storeInfo">`+ store.email + `</td>
                                </tr>`
                }
                else var email = ''
                if (store.address1 != 0) {
                    var address = `

                                        <div class="">
                                            <p class="storeLabel">Adresse:<p class="storeInfo" >`+ store.address1 + `</p></p>  
                                             </div>                                                                                      
                                       `
                }
                else var address = ''
                if (store.phone != 0) {
                    var tel = `
                                        <tr class="d-flex align-items-end" >
                                            <th class="storeLabel">Télephone:</th>
                                            <td class="storeInfo">`+ store.phone + `</td>
                                        </tr >`
                }
                else var tel = ''
                var marker;
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(store.latitude, store.longitude),
                    icon: iconBase,
                    // draggable: true,
                    title: store.name
                });
                document.getElementById('listestore').innerHTML += `
                    <div id="store-`+ store.id + `" class="store-item card storeItem" onclick="markerPosition(` + store.latitude + `,` + store.longitude + `)">
                        <div class=" clearfix h-100">
                          <div class="store-description storeDescription">
                                <h3 class="h3 card-title">`+ store.name + `</h3>                                
                                                   ` + address + `        
                            </div>
                        </div>                    
                    </div>
                    `
                // < table > ` + address + `</table > 
                const contentString = `                   
                        <div class="clearfix h-100 ">
                          <div class="store-description markerPopup ">
                                <h3 class="h3 card-title">`+ store.name + `</h3>                                
                                   <table>` + address + `</table>                            
                            </div>
                        </div>                 
                    `
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    ariaLabel: "store",
                });
                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                    });
                });
                map.setCenter(marker.getPosition());
                marker.setMap(map);
                markers.push(marker);
                console.log('eeede=', markers)
            }
            )
            console.log('marker=', markers)
            markerCluster = new MarkerClusterer(map, markers, { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' });
            markerCluster.setMap(map)
            console.log('markers1=', markerCluster)
        }
        else {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
                markerCluster.removeMarker(markers[i]);
            }
            document.getElementById('listestore').innerHTML = ``;
            document.getElementById('listestore').innerHTML += `
            
                <p>Aucun boutiques trouvé.</p>`
            // Pas des magasions disponibles avec cette recherche
            // < i class="material-icons " > DoNotDisturbOn</i >
        }

    }).fail(function (error) {
        console.log('error=', error)
    });
}
function markerPosition(lat, lng) {
    map.panTo(new google.maps.LatLng(lat, lng));
    map.setZoom(13);
    return false;
}
function getLocation() {
    navigator.geolocation.getCurrentPosition(
        function (position) {
            var marker;
            map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
            map.setZoom(16);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                map: map,
            });
            map.setCenter(marker.getPosition());
            console.log('test1')
        },
        function errorCallback(error) {
            console.log(error, 'test3')
        }
    );
}

$(document).ready(function () {
    // Initialise gov list
    var govs = [
        { id: 'Tous', text: 'Tout' },
        { id: 'Ariana', text: 'Ariana' },
        { id: 'Beja', text: 'Béja' },
        { id: 'Ben Arous', text: 'Ben Arous' },
        { id: 'Bizerte', text: 'Bizerte' },
        { id: 'Gabès', text: 'Gabès' },
        { id: 'Gafsa', text: 'Gafsa' },
        { id: 'Jendouba', text: 'Jendouba' },
        { id: 'Kairouan', text: 'Kairouan' },
        { id: 'Kasserine', text: 'Kasserine' },
        { id: 'Kébili', text: 'Kébili' },
        { id: 'Kef', text: 'Kef' },
        { id: 'Mahdia', text: 'Mahdia' },
        { id: 'Manouba', text: 'Manouba' },
        { id: 'Médenine', text: 'Médenine' },
        { id: 'Monastir', text: 'Monastir' },
        { id: 'Nabeul', text: 'Nabeul' },
        { id: 'Sfax', text: 'Sfax' },
        { id: 'Sidi Bouzid', text: 'Sidi Bouzid' },
        { id: 'Siliana', text: 'Siliana' },
        { id: 'Sousse', text: 'Sousse' },
        { id: 'Tataouine', text: 'Tataouine' },
        { id: 'Tozeur', text: 'Tozeur' },
        { id: 'Tunis', text: 'Tunis' },
        { id: 'Zaghouan', text: 'Zaghouan' }
    ]
    $('#gouvernoratid').select2({ width: '200px', height: '50px', data: govs, value: govs[0].id }).on("change", function (e) {
        FilterStores()
        console.log('markersafter', markers)
    });
    $('#gouvernoratid').val(govs[0].id).trigger('change');


    map = new google.maps.Map(document.getElementById('map-canvas'), {
        zoom: 10, mapTypeId: google.maps.MapTypeId.ROADMAP
    });
});


