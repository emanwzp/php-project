
var vehicles = [];
var counter = -50;
var explode;



function preload(){
  font = loadFont('text_steering/AvenirNextLTPro-Demi.otf');
}

function setup(){
  var myCanvas = createCanvas(950,600);
  myCanvas.parent("canvasContainer");

  explode = false;

  textW = 50;
  textH = height/2+70;

  var points = font.textToPoints('All',textW,textH,100);
  for(var i = 0; i < points.length; i++){
    var pt = points[i];
    var vehicle = new Vehicle(pt.x, pt.y, pt.x, pt.y);

    vehicles.push(vehicle);
  }


}

function draw(){
  background(51);

  if(explode){
    for(var i = 0; i < vehicles.length; i++){
      var v = vehicles[i];
      v.explode();
      v.behaviours();
      v.update();
      v.show();
    }
    explode = false;
  }else{
    for(var i = 0; i < vehicles.length; i++){
      var v = vehicles[i];
      v.behaviours();
      v.update();
      v.show();

    }
  }



  counter ++;

  var increment = 10;

  switch(counter){
    case increment:
      changeText("the other");
      explode = true;
      break;
    case increment * 5:
      changeText("kids");
      explode = true;
      break;
    case increment * 10:
      changeText("with the");
      explode = true;
      break;
    case increment * 17:
      changeText("pumped");
      explode = true;
      break;
    case increment * 19:
      changeText("up");
      explode = true;
      break;
    case increment * 22:
      changeText("kicks");
      explode = true;
      break;
    case increment * 25:
      changeText("You");
      explode = true;
      break;
    case increment * 27:
      changeText("Better");
      explode = true;
      break;
    case increment * 30:
      changeText("Run");
      explode = true;
      break;
    case increment * 35:
      changeText("better run");
      explode = true;
      break;
    case increment * 40:
      changeText("outrun");
      explode = true;
      break;
    case increment * 45:
    changeText("my gun");
    explode = true;
    break;
    // case increment * 4:
    // changeText("How");
    // break;
    // case increment * 4:
    // changeText("To");
    // break;
    // case 290:
    // changeText("Swim");
    // break;
  }

}

function changeText(string){

  var points = font.textToPoints(string, textW, textH,100);
  var diff = vehicles.length/points.length;

  //if diff bigger than 1, vehicles array is bigger, if v less than 1, vehicles array is smaller
  //if vehicles array is smaller,
  if(diff < 1){
    var k = 0;
    newVehicles =[]
    for(var i = 0; i < points.length; i++){
      var v = vehicles[floor(k)];
      var pt = points[i];
      var vehicle = new Vehicle(v.pos.x, v.pos.y, pt.x, pt.y);
      newVehicles.push(vehicle);
      k += diff;
    }
    vehicles = newVehicles;

  }else{
    var k = 0;
    newVehicles =[]
    //less points
    for(var i = 0; i < points.length; i++){
      var v = vehicles[floor(k)];
      var pt = points[i];
      var vehicle = new Vehicle(v.pos.x, v.pos.y, pt.x, pt.y);
      newVehicles.push(vehicle);
      k += diff;
    }
    vehicles = newVehicles;
  }

}
