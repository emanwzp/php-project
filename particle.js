function Particle(x,y){
  this.pos = createVector(x,y);
  this.vel = p5.Vector.random2D();
  this.acc = createVector();


  this.update = function(){
    this.pos.add(this.vel);
    this.vel.add(this.acc);


  }

  this.show = function(){
    stroke(255);
    strokeWeight(4);
    point(this.pos);
  }

  this.attracted = function(target){
    var force = p5.Vector.sub(target,this.pos);
    var dSqr = force.magSq();
    dSqr = constrain(dSqr,25,500);
    var g = 50;
    var magnitude = g / dSqr;
    force.setMag(magnitude);
    this.acc = force;

  }
}
