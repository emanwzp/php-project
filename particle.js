function Particle(x, y) {
  this.pos = createVector(x, y);

  this.trail = [];
  //this.vel = p5.Vector.random2D();
  this.vel = createVector();
  this.acc = createVector();


  this.update = function() {
    this.vel.add(this.acc);
    //prevents velocity from going out of control
    //this.vel.limit(20);
    this.pos.add(this.vel);
    this.acc.mult(0);

  }

  this.show = function() {
    stroke(255);
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

  this.attracted = function(target,type) {
    var force = p5.Vector.sub(target, this.pos);
    var dSqr = force.magSq();
    dSqr = constrain(dSqr,2,170);
    var magnitude = g / dSqr;
    force.setMag(magnitude);
    //multiplying by 1 or -1,-1 reverts the force, repelling instead of attracting
    force.mult(type);
    this.acc.add(force);

  }
}
