
function Vehicle(posX, posY, targetX, targetY){
  this.pos = createVector(posX, posY);
  this.target = createVector(targetX, targetY);
  this.vel = createVector();
  this.acc = createVector();
  this.r = 8;
  this.maxSpeed = 30;
  this.maxForce = 3;

  Vehicle.prototype.update = function(){
    this.pos.add(this.vel);
    this.vel.add(this.acc);
    this.acc.mult(0);
  }

  Vehicle.prototype.show = function(){
    var desired = p5.Vector.sub(this.target, this.pos);
    var dist = desired.mag();
    var hu = map(dist, 0,150, 255, 0);
    stroke(hu);
    strokeWeight(7);
    point(this.pos.x, this.pos.y);
  }

  Vehicle.prototype.behaviours = function(){
    var steer = this.steer(this.target);

    var mouse = createVector(mouseX, mouseY);
    var repel = this.repel(mouse);


    repel.mult(3);

    this.applyForce(steer);
    this.applyForce(repel);


  }

  Vehicle.prototype.applyForce = function(f){
    this.acc.add(f);
  }

  Vehicle.prototype.steer = function(target){
    var desired = p5.Vector.sub(target, this.pos);
    var dist = desired.mag();
    var speed = this.maxSpeed;
    if(dist < 200){
      var speed = map(dist, 0, 200, 0, this.maxSpeed);
    }
    desired.setMag(speed);
    steer_force = p5.Vector.sub(desired, this.vel);
    steer_force.limit(this.maxForce);
    return steer_force;
  }

  Vehicle.prototype.repel = function(target){
    var desired = p5.Vector.sub(target, this.pos);
    var dist = desired.mag();
    if(dist < 50){
      desired.setMag(this.maxSpeed);
      desired.mult(-1);
      steer_force = p5.Vector.sub(desired, this.vel);
      steer_force.limit(this.maxForce);
      return steer_force;
    }else{
      return createVector();
    }

  }

    Vehicle.prototype.explode = function(){
      var force = p5.Vector.random2D();
      force.setMag(20);
      this.vel.add(force);
    }



}
