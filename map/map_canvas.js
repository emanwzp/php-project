
//Setting up map
var myMap = L.map('mapid').setView([51.505, -0.09], 1.5);


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



//var countries = ["Switzerland","Portugal","France"];

//Stores country clicked if it exists in the array, otherwise it removes it from
//the array
function countryClicked(e){
  var feature = e.target.feature;
  var name = feature.properties.NAME;
  var country_index = countryStored(name);
  var wishlist_country_index = wishCountryStored(name);

  if(country_index){
    countries.splice(country_index-1,1);
    //remove input with name of country (DB purposes)
    document.getElementById(name).remove();

  }else if(wishlist_country_index){
    wishlist_countries.splice(wishlist_country_index-1,1);
    //remove input with name of country (DB purposes)
    document.getElementById(name).remove();

  }else{
    //if wishlist checkbox is checked, then store country in the wishlist country
    var wishlist = document.getElementById("wishlist");
    if (wishlist.checked == true){
      wishlist_countries.push(name);
      //add form input with name of country that was added (DB purposes)
      var input = document.createElement("input");
      input.type = "hidden";
      input.name = "wishlist_countries[]";
      input.id = name;
      input.value = name;
      document.getElementById("form").appendChild(input);

    }else{
      countries.push(name);
      //add form input with name of country that was added (DB purposes)
      var input = document.createElement("input");
      input.type = "hidden";
      input.name = "visited_countries[]";
      input.id = name;
      input.value = name;
      document.getElementById("form").appendChild(input);
    }

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

function wishCountryStored(country_name){
  for(var i = 0; i < wishlist_countries.length; i++){
    if (wishlist_countries[i] === country_name){
      //have to add 1 to the index, so index 0 does not evaluate to false
      return i+1;
    }
  }
  return false;
}

//Manual input to add country to array
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
//Manual input to remove country from array
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
      color: 'black',
      dashArray: '',
      fillOpacity: 0.5
    }
  }else if(wishCountryStored(feature.properties.NAME)){
    return{
      fillColor: "orange",
      weight: 1,
      color: 'black',
      dashArray: '',
      fillOpacity: 0.5
    }
  }
  else{
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
    //updates legend
    info.update(layer.feature.properties);
}


var borders;

function resetHighlight(e) {
    borders.resetStyle(e.target);

    //updates
    info.update();
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


//Legend for map
var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
  // var message = "<i> Click to add country as visited </i>";
  // var wishlist = document.getElementById("wishlist");
  // if(wishlist){
  //   if (wishlist.checked == true){
  //     message = "Click to add country you wish to visit";
  //   }
  // }
    this._div.innerHTML = (props ?
        '<h4>' + props.NAME + '</h4>' 
        : 'Hover over a Country');
};

info.addTo(myMap);


//Bottom legend for map
var legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
    var div = L.DomUtil.create('div', 'info legend');
    div.innerHTML +=
        '<i style="background:' + 'blue' + '"  ></i> ' + 'Visited Countries' + '<br>' ;
    div.innerHTML +=
        '<i style="background:' + 'orange' + '"  ></i> ' + 'Wishlist' + '<br>' ;



    return div;
};

legend.addTo(myMap);
