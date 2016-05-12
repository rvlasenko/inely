var mapLocation = new google.maps.LatLng(40.6700, -73.9400); //change coordinates here
var marker;
var map;

function initialize() {
    var mapOptions = {
        zoom: 11, //change zoom here
        center: mapLocation,
        scrollwheel: false,
        styles: [{
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#444444"
            }]
        }, {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [{
                "color": "#f2f2f2"
            }]
        }, {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "poi",
            "elementType": "labels.text",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "road",
            "elementType": "all",
            "stylers": [{
                "saturation": -100
            }, {
                "lightness": 45
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [{
                "visibility": "simplified"
            }]
        }, {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "water",
            "elementType": "all",
            "stylers": [{
                "color": "#dbdbdb"
            }, {
                "visibility": "on"
            }]
        }]

    };

    map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);


    //change address details here
    var contentString = '<div class="map-info-box">' + '<div class="map-head">' + '<h3>Archer</h3></div>' + '<p class="map-address"><i class="fa fa-map-marker"></i> 4751 Clarksburg Park Road <br><i class="fa fa-phone"></i> +1856-236-1853<br><span class="map-email"><i class="fa fa-envelope"></i> Contact@archer.com</span></p>' + '<a href="https://www.google.com/maps/place/851+6th+Ave,+New+York,+NY+10001,+USA/data=!4m2!3m1!1s0x89c259af44f80211:0xbd87d30d3c7da9d2?sa=X&amp;ei=KqAdVazxJMTkuQS9sIGIBQ&amp;aved=0CB0Q8gEwAA" target="_blank">Open on Google Maps</a></div>';


    var infowindow = new google.maps.InfoWindow({
        content: contentString,
    });


    var image = 'img/flag.svg';
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        title: 'Archer', //change title here
        icon: image,
        animation: google.maps.Animation.DROP,

        position: mapLocation
    });


    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);

    });

    google.maps.event.addListener(map, "click", function(event) {
        infowindow.close();
    });



    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    });
}



google.maps.event.addDomListener(window, 'load', initialize);


/* ==========================================================================
   Google map modal
   ========================================================================== */

$('#modal-google-map').on('shown.bs.modal', function() {
    initialize();
});


