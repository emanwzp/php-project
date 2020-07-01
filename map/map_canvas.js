
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
  var country_index = countryStored(name);

  if(country_index){
    countries.splice(country_index-1,1);
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


function addCountry(){
  var input = document.getElementById("countryInput").value;
  var form_input = format(input);

  var feedback = "";
  if(countryStored(form_input)){
    feedback = "Country Already Selected";
  }else{
    var index = countryExists(form_input)
    if(index){
      countries.push(form_input);
      borders.resetStyle();
      feedback = "Country added";
    }else{
      feedback = "The country you typed does not exist or could not be selected";
    }
  }
  document.getElementById("feedback").innerHTML = feedback;
}

function removeCountry(){
  var input = document.getElementById("countryInput").value;
  var form_input = format(input);
  var feedback = "";
  var country_index = countryStored(form_input)
  if(country_index){
    countries.splice(country_index-1,1);
    borders.resetStyle();
    feedback = "Country Removed";
  }else{
    feedback = "No country could be removed";
  }
  document.getElementById("feedback").innerHTML = feedback;
}

function format(string){
  //remove whitespaces
  var formatted = string.trim();
  formatted = formatted.toLowerCase();
  //make first letter uppercase
  formatted = formatted.charAt(0).toUpperCase() + formatted.slice(1);
  return formatted;
}

//Checks whether the string as parameter exists in the borders.js as a countryName
//returns false if it does not, or returns the index+1 if it does
function countryExists(string){
  var features = borderData.features;
  for(var i = 0; i < features.length; i++){
    var countryName = features[i].properties.NAME
    if(string === countryName){
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

      color: 'white',
      dashArray: '',
      fillOpacity: 0.5
    }
  }else{
    return {
      fillColor: "white",
      weight: 1,

      color: 'grey',
      dashArray: '',
      fillOpacity: 0.5,
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
        fillOpacity: 0.7,
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
