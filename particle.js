function Particle(x, y) {
  this.pos = createVector(x, y);
  this.vel = p5.Vector.random2D();

  this.acc = createVector();


  this.update = function() {
    this.vel.add(this.acc);
    this.pos.add(this.vel);
    this.acc.mult(0);

  }

  this.show = function() {
    stroke(255, 15);
    strokeWeight(4);
    point(this.pos);
  }

  this.attracted = function(target) {
    var force = p5.Vector.sub(target, this.pos);
    var dSqr = force.magSq();
    dSqr = constrain(dSqr, 10, 500);
    var g = 6.7;
    var magnitude = g / dSqr;
    force.setMag(magnitude);
    this.acc = force;

  }
}
