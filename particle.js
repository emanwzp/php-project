function Particle(x, y) {
  this.pos = createVector(x, y);

  this.trail = [];
  this.vel = p5.Vector.random2D();
  this.acc = createVector();


  this.update = function() {
    this.vel.add(this.acc);
    this.pos.add(this.vel);
    this.acc.mult(0);

  }

  this.show = function() {
    strokeWeight(3);
    point(this.pos);

    var prev = createVector(this.pos.x, this.pos.y);
    this.trail.push(prev);

    beginShape();
    stroke(255,100);
    strokeWeight(1);
    noFill();
    for(var i = this.trail.length-1; i > 0; i--){
      vertex(this.trail[i].x,this.trail[i].y);
    }
    endShape();
    if(this.trail.length > trailLen){
      for(var i = this.trail.length-1; i > trailLen; i--){
        this.trail.shift();
      }
    }


  }

  this.attracted = function(target) {
    var force = p5.Vector.sub(target, this.pos);
    var dSqr = force.magSq();
    dSqr = constrain(dSqr, 5, 50);
    var magnitude = g / dSqr;
    force.setMag(magnitude);
    this.acc.add(force);

  }
}
