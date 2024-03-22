//map.js

//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 
        
//Function called to initialize / create the map.
//This is called when the page has loaded.
var latitudeValues = [];
var distanceValues = [];

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            // Extract latitude and distance values into separate arrays

            data.forEach(function (item) {
                latitudeValues.push(parseFloat(item.latitude));
                distanceValues.push(parseFloat(item.distance));
            });

            // Use latitudeValues and distanceValues as needed
            
        } else {
            console.error('Failed to fetch data');
        }
    }
};

xhr.open('GET', 'get_data.php', true);
xhr.send();

function initMap() {

    //The center location of our map.
    var centerOfMap = new google.maps.LatLng(16.665903, 74.475852);

    //Map options.
    var options = {
      center: centerOfMap, //Set center.
      zoom: 15 //The zoom value.
    };

    var redCircle = new google.maps.Circle({
        strokeColor: '#FF0000', // Red color
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000', // Red color
        fillOpacity: 0.35,
        map: map,
        center: centerOfMap, // You can adjust the circle center as needed
        radius: 1000 // Example radius in meters
    });

    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);
    
    for(var i = 0; i < latitudeValues.length; i++)
    {
        var redCircle = new google.maps.Circle({
            strokeColor: '#FF0000', // Red color
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000', // Red color
            fillOpacity: 0.35,
            map: map,
            center: new google.maps.LatLng(latitudeValues[i], longitude[i]), // You can adjust the circle center as needed
            radius: distanceValues[i] // Example radius in meters
        });
    }
    //Listen for any clicks on the map.
    redCircle.addListener('click', function(event) {
        var clickedLocation = event.latLng;
        if (marker === false) {
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true // make it draggable
            });
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else {
            marker.setPosition(clickedLocation);
        }
        markerLocation();
    });
    google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true //make it draggable
            });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });
}

function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    current_lat = currentLocation.lat(); //latitude
    current_lng = currentLocation.lng(); //longitude

    dangerStatus();
    function dangerStatus()
    {
        var status;
        for(var i = 0; i < latitudeValues.length; i++)
        {
            if(current_lat > latitudeValues[i])
            {
                if((current_lat-latitudeValues[i])<=(distanceValues[i]*0.000007976) && (current_lat-latitudeValues[i])>=0.0000000)
                {
                    status = false;
                }
                else
                {
                    status = true;
                }
            }
            else if(current_lat < latitudeValues[i])
            {
                if((latitudeValues[i]-current_lat)<=(distanceValues[i]*0.000006584) && (latitudeValues[i]-current_lat)>=0.0000000)
                {
                    status = false;
                }
                else
                {
                    status = true;
                }
            }
        }
        if(status == true)
        {
            alert("You are in safe zone Dont worry about it.!!!");
        }
        if(status == false)
        {
            alert("You are in Danger Zone. Please go away from that area.!!!")
        }
    }
}
        
        
//Load the map when the page has finished loading.
google.maps.event.addDomListener(window, 'load', function()
{
    initMap();
    addDangerZoneCircle();
});