// var coordinates = document.getElementById('mapid2');
// var latitude = coordinates.dataset.latitude;
// var longitude = coordinates.dataset.longitude;
//
let mosquitos = $('.thumbnail');

let coordinates = [];

let name = '';

for (mosquito of mosquitos) {
    let latitude = $(mosquito).data('latitude');
    let longitude  =  $(mosquito).data('longitude');
    let name =  $(mosquito).data('name');
    let coord = [name, latitude, longitude];
     coordinates.push(coord);
}


for (let i = 0; i < 1; i++) {
    name = coordinates[i][0];
    latitude = coordinates[i][1];
    longitude = coordinates[i][2];

}

// CREATE MAP
let mymap = L.map('mapid2').setView([latitude, longitude], 2);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?' +
    'access_token=pk.eyJ1Ijoibm9jbGFpbmIiLCJhIjoiY2phcGJyOXdpNTgyZDMzbDlyM3FrazF3eCJ9.FEtYuT1noyubSYlXZGsX7A', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
    '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © ' +
    '<a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

// CREATE MARKERS
for (coordinate of coordinates) {
      marker = new L.Marker([coordinate[1], coordinate[2]]).bindPopup(coordinate[0] + "<br/>" + coordinate[1] + " / " + coordinate[2]).addTo(mymap);
      marker.openPopup();
}

