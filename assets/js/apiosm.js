var test = document.getElementById('mapid');
var latitude = test.dataset.latitude;
var longitude = test.dataset.longitude;
var coordinate = test.dataset.true;
var mymap = L.map('mapid').setView([latitude, longitude], 11.5);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?' +
    'access_token=pk.eyJ1Ijoibm9jbGFpbmIiLCJhIjoiY2phcGJyOXdpNTgyZDMzbDlyM3FrazF3eCJ9.FEtYuT1noyubSYlXZGsX7A', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
    '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © ' +
    '<a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);
if (coordinate) {
    var marker = L.marker([latitude, longitude]).addTo(mymap);
}
else {
    var circle = L.circle([latitude, longitude], {
        color: 'red',
        fillColor: '#ff0033',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(mymap);
}