var destinationId = 0;

// view model for an event
function eventViewModel() {
    var self = this;

    self.name = ko.observable();
    self.date = ko.observable();
    self.image = ko.observable();
    self.description = ko.observable();
    self.places = ko.observableArray();

    self.addPlace = function (latLng) {
        self.places.push(new destination(destinationId++, latLng));
    }
}

// view model for a destination
function destination(id, position){
    var self = this;

    self.id = id;
    self.position = position;
    self.name = ko.observable();
    self.time = ko.observable();
    self.description = ko.observable();
}

$(function(){
    initializeMap();
    bindEvents();
})

var map;
var coords = [];

// function to initialize a map
function initializeMap() {
    var mapOptions = {
        center: new google.maps.LatLng(-33.882031, 151.189535),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    var minZoomLevel = 17;

    // listen for the zoom event so we can restrict it.
    google.maps.event.addListener(map, 'zoom_changed', function(){
       if(map.getZoom() > minZoomLevel) map.setZoom(minZoomLevel);
    });

    // test google click event
    google.maps.event.addListener(map, 'click', function(event){
        dasModel.addPlace(event.latLng);
        coords.push(event.latLng);

        var testy = [];
        dasModel.places().forEach(function(ting){
            testy.push({location: ting.position, stopover: false});
        });

        var request = {
            origin: dasModel.places()[0].position,
            destination: event.latLng,
            waypoints: testy,
            optimizeWaypoints: false,
            travelMode: google.maps.TravelMode.WALKING
        };

        var dirDisplay = new google.maps.DirectionsRenderer();
        dirDisplay.setMap(map);

        var directionsService =  new google.maps.DirectionsService();

        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                dirDisplay.setDirections(response);
            }
        });
    });
}

function addMarker(latLng) {
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        title: "something"
    });
}

// globally accessible model
var dasModel;

// function to bind all used events on the page
function bindEvents(){

    dasModel = new eventViewModel();
    ko.applyBindings(dasModel);

    $('button').click(function (){
        createEvent();
    });
}

// function to create an event
function createEvent(){
    var cool= [];
    dasModel.places().forEach(function(thing){
        cool.push({id: thing.id, lat: thing.position.lat(), long: thing.position.lng(), name: thing.name(), time: thing.time(), description: thing.description()});
    });
    var data = {data: { name: dasModel.name(), date: dasModel.date(), image: dasModel.image(), description: dasModel.description(), places: cool}};

    $.post("create.php", data, function(html){
		$('#topbit').append(html);
	});
	
	window.scrollTo(0,0);
}