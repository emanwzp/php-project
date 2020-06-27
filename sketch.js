var atractors = [];
var particles = [];

var trailLen = 50;
var trailSlider;

var g = 6.7;
var gSlider;




function setup(){
  var myCanvas = createCanvas(950,600);
  myCanvas.parent("canvasContainer");
  for(var i = 0; i < 100; i++){
    particle = new Particle(random(width),random(height));
    particles.push(particle);
  }
  for(var i = 0; i < 5; i++){
    var v = createVector(random(100,width-100),random(100,height-100));
    atractors.push(v);
  }
  textSize(20);

  trailSlider = createSlider(1,100,10,1);
  trailSlider.parent("trailSlider");

  gSlider = createSlider(1,50,6,1);
  gSlider.parent("gSlider");

}

function draw(){
  background(51);
  stroke(255);
  strokeWeight(6);
  for(var k = 0; k < atractors.length; k++){
    point(atractors[k]);
  }

  for(var i = 0; i < particles.length; i++){
    var particle = particles[i];
    for(var k = 0; k < atractors.length; k++){
      particle.attracted(atractors[k]);
    }
    particle.update();
    particle.show();
  }

  text(int(getFrameRate()),15, 25);

  trailLen = trailSlider.value();
  g = gSlider.value();


}
