var atractor;
var particle;


function setup(){
  var myCanvas = createCanvas(800,600);
  myCanvas.parent("canvasContainer");

  atractor = createVector(width/2,height/2);
  particle = new Particle(width/2,height/3);
  background(51);
}

function draw(){

  stroke(255);
  strokeWeight(4);

  point(atractor);

  particle.attracted(atractor);
  particle.update();
  particle.show();


}
