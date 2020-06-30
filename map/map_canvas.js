
//Setting up map
var myMap = L.map('mapid').setView([51.505, -0.09], 3);


L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    maxZoom: 10,
    id: 'mapbox/streets-v11',
    tileSize: 256,
}).addTo(myMap);

//Setting boundaries for map
var southWest = L.latLng(-89.98155760646617, -180),
northEast = L.latLng(89.99346179538875, 180);
var bounds = L.latLngBounds(southWest, northEast);

myMap.setMaxBounds(bounds);
myMap.maxBoundsViscosity = 1;


var countries = ["Switzerland","Portugal","France"];
//Stores country clicked if it exists in the array, otherwise it removes it from
//the array
function countryClicked(e){
  var feature = e.target.feature;
  var name = feature.properties.NAME;
  var i = countryStored(name);

  if(i){
    countries.splice(i-1,1);
  }else{
    countries.push(name);
  }

}

//Returns country index if it was stored in the array, otherwise returns false
function countryStored(country_name){
  for(var i = 0; i < countries.length; i++){
    if (countries[i] === country_name){
      //have to add 1 to the index, so index 0 does not evaluate to false
      return i+1;
    }
  }
  return false;
}



//Styles country border and fill colours based on whether they are stored or not
function style(feature) {
  if(countryStored(feature.properties.NAME)){
    return{
      fillColor: "blue",
      weight: 1,
      opacity: 1,
      color: 'white',
      dashArray: '',
      fillOpacity: 0.5
    }
  }else{
    return {
      fillColor: "white",
      weight: 1,
      opacity: 1,
      color: 'grey',
      dashArray: '',
      fillOpacity: 0.5
    };
  }
}



function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        fillColor: "grey",
        weight: 3,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
}


var borders;

function resetHighlight(e) {
    borders.resetStyle(e.target);
}



function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: countryClicked
    });
}





borders = L.geoJson(borderData, {
    style: style,
    onEachFeature: onEachFeature
}).addTo(myMap);
