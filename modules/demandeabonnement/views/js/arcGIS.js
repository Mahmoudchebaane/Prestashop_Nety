 
require([
    "esri/Map",
    "esri/views/MapView",
    "esri/widgets/Search",
    "esri/Graphic",
    "esri/widgets/Locate",
    "esri/widgets/BasemapToggle",
    "esri/widgets/Fullscreen","esri/intl"
], function (Map, MapView, Search, Graphic, Locate, BasemapToggle, Fullscreen,intl) {
    
    intl.setLocale(map_lang); 
    // Create a symbol for drawing the point 
    const markerSymbol = {
        type: "picture-marker",  
        url: my_module_path +"views/img/adresse_marker.png",         
        //url: "https://static.vecteezy.com/system/resources/previews/000/582/855/original/vector-location-pin-icon.jpg",
        width: "30px",
        height: "35px" 
    };
    var map = new Map({basemap: "hybrid"});

    var view = new MapView({
        container: "viewDiv",
        map: map,
        center: [
            10.473, 34.298
        ],
        zoom: 6
    });
   
    // let basemaps = ["streets", "satellite", "hybrid", "topo", "gray", "dark-gray", "osm", "dark-gray-vector", "gray-vector", "streets-vector", "topo-vector", "streets-night-vector", "streets-relief-vector", "streets-navigation-vector"]
    var toggle = new BasemapToggle({view: view, nextBasemap: "osm"});
    view.ui.add(toggle, "bottom-right");


    // view.when(function(){   // if  you want to set locate on load  map   });
    // Create an instance of the Locate widget
    let locateWidget = new Locate({view: view, scale: 5000, symbol: markerSymbol});
    view.ui.add(locateWidget, "top-left");
   // locateWidget.locate();
    locateWidget.on("locate", function (locateEvent) { 
        createGraphic(locateEvent.position.coords.latitude, locateEvent.position.coords.longitude);
    })


    // Add Search widget
    var search = new Search({view: view , symbol: markerSymbol });
    view.ui.add(search, "top-right" );

    search.on("search-complete", function(event){
        view.graphics.removeAll();
        
    });
     

 
      search.allSources.on("after-add", ({ item }) => {
        item.resultSymbol = markerSymbol
      });

    // Add full screen widget
    var fullscreen = new Fullscreen({view: view});
    view.ui.add(fullscreen, "top-right");

    // Find address
    view.on("click", function (event) {
        createGraphic(event.mapPoint.latitude, event.mapPoint.longitude);
       // search.clear();
       //  view.popup.clear();
        // if (search.activeSource) {
        //     var geocoder = search.activeSource.locator; // World geocode service
        //     var params = {
        //     location: event.mapPoint
        //     };
        //     geocoder.locationToAddress(params)
        //     .then(function(response) { // Show the address found
        //         var address = response.address;
        //         showPopup(address, event.mapPoint);
        //     }, function(err) { // Show no address found
        //         showPopup("No address found.", event.mapPoint);
        //     });
        // }

    });

    /*************************
       * Create a point graphic
       *************************/
    function createGraphic(lat, long) {
        view.graphics.removeAll();
        // First create a point geometry
        var point = {
            type: "point", // autocasts as new Point()
            longitude: long,
            latitude: lat
        };         
        // Create a graphic and add the geometry and symbol to it
        var pointGraphic = new Graphic({geometry: point, symbol: markerSymbol});

        // Add the graphics to the view's graphics layer
        view.graphics.add(pointGraphic);
        $("input[name='codeadresse']").val(point.longitude + ", " + point.latitude)
    }

    function showPopup(address, pt) {
        view.popup.open({
            title: + Math.round(pt.longitude * 100000) / 100000 + ", " + Math.round(pt.latitude * 100000) / 100000,
            content: address,
            location: pt
        });
    }

});
