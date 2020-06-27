var atractors = [];
var repulsors = [];
var particles = [];

var trailLen = 50;
var trailSlider;

var g = 6.7;
var gSlider;




function setup(){
  var myCanvas = createCanvas(950,600);
  myCanvas.parent("canvasContainer");

  textSize(20);
  //create particles
  for(var i = 0; i < 50; i++){
    particle = new Particle(random(width),random(height));
    particles.push(particle);
  }
  //create atractors
  for(var i = 0; i < 1; i++){
    var v = createVector(random(300,width-300),random(300,height-300));
    atractors.push(v);
  }

  //create sliders
  trailSlider = createSlider(0,100,10,1);
  trailSlider.parent("trailSlider");

  gSlider = createSlider(1,50,6,1);
  gSlider.parent("gSlider");

}

function mousePressed(){
  //check if mouse is within canvas boundaries
  if(mouseX > 0 && mouseX < width && mouseY > 0 && mouseY < height){
    var repulse = document.getElementById("repulsor");
    if (repulse.checked == true){
      var v = createVector(mouseX,mouseY);
      repulsors.push(v);
    }else{
      var v = createVector(mouseX,mouseY);
      atractors.push(v);
    }

  }
}

function draw(){
  background(90);

  //draw atractors
  for(var k = 0; k < atractors.length; k++){
    stroke(0);
    strokeWeight(6);
    point(atractors[k]);
  }
  //draw repulsors
  for(var k = 0; k < repulsors.length; k++){
    stroke(255);
    strokeWeight(6);
    point(repulsors[k]);
  }

  //draw and update particles
  for(var i = 0; i < particles.length; i++){
    var particle = particles[i];
    for(var k = 0; k < atractors.length; k++){
      particle.attracted(atractors[k],1);
    }
    for(var k = 0; k < repulsors.length; k++){
      particle.attracted(repulsors[k],-1);
    }

    particle.update();
    particle.show();
  }

  text(int(getFrameRate()),15, 25);

  trailLen = trailSlider.value();
  g = gSlider.value();


}
