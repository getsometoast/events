
var points = new Array();

$(function(){
	getPoints();
	initialiseMap();
	bindEvents();
})

function getPoints() {
	
	$('.detail').each(function (index) {
		
		var element = $(this);
		
		var lat = element.find('input[name=lat]').val();
		var lng = element.find('input[name=lng]').val();
		
		var elementLatLng = new google.maps.LatLng(lat,lng);
		
		points.push(elementLatLng);
	});
}

function initialiseMap(){

	var mapOptions = {
        center: points[0],
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);

    var minZoomLevel = 17;

    // listen for the zoom event so we can restrict it.
    google.maps.event.addListener(map, 'zoom_changed', function(){
       if(map.getZoom() > minZoomLevel) map.setZoom(minZoomLevel);
    });
	 
	var marker;
	points.forEach(function(point){
		marker = new google.maps.Marker({
			position: point,
			map: map
		});
	});
}

function bindEvents(){
	$("#upvote button").click(function () {
		var mongoId = $("#mongo-id").val();
		$.post('upvote-event.php', { id: mongoId });
	});
}