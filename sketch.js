var atractor;
var particles = [];


function setup(){
  var myCanvas = createCanvas(800,600);
  myCanvas.parent("canvasContainer");
  for(var i = 0; i < 30; i++){
    particle = new Particle(width/2,height/3);
    particles.push(particle);
  }
  atractor = createVector(width/2,height/2);

  background(51);
}

function draw(){

  stroke(255);
  strokeWeight(4);

  point(atractor);

  for(var i = 0; i < particles.length; i++){
    var particle = particles[i];
    particle.attracted(atractor);
    particle.update();
    particle.show();
  }



}
