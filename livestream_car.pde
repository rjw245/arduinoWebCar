import processing.serial.*;
import cc.arduino.*;
Arduino arduino;

String[] motor_stream;
String[] motor_vals;
int rmotor;
int rmotor_cur;

int lmotor;
int lmotor_cur;

int dur;

//Configure these pins:
int motor1_1=5;  //Motor 1
int motor1_2=3;  //Motor 1

int motor2_1=6;  //Motor 2
int motor2_2=11; //Motor 2

void setup() {
  println(Arduino.list());
  arduino = new Arduino(this, Arduino.list()[1], 57600); //Replace the index [1] with the necessary index on your computer (which COM port should be checked?)
  
  for (int i = 0; i <= 13; i++) arduino.pinMode(i, Arduino.OUTPUT);
  int rmotor_cur=0;
  int lmotor_cur=0;
}

void draw() {
  //Edit the following URL to point to the tasks_to_arduino.php on your site
  //Leave the GET information appended (?arduino=1)
  motor_stream = loadStrings("http://YOURWEBSITE/tasks_to_arduino.php?arduino=1");
  motor_vals = split(motor_stream[0],':'); //Left:Right:Duration
  dur = int(motor_vals[2]);
  
  lmotor = int(motor_vals[0]);
  if(lmotor_cur != lmotor){
    if(lmotor<0){
      arduino.analogWrite(motor1_2,abs(lmotor));
      arduino.analogWrite(motor1_1,0);
      lmotor_cur=lmotor;
    }
    else{
      arduino.analogWrite(motor1_2,0);
      arduino.analogWrite(motor1_1,lmotor);
      lmotor_cur=lmotor;
    }
  }
  
  rmotor = int(motor_vals[1]);
  if(rmotor_cur != rmotor){
    if(rmotor<0){
      arduino.analogWrite(motor2_2,abs(rmotor));
      arduino.analogWrite(motor2_1,0);
      rmotor_cur=rmotor;
    }
    else{
      arduino.analogWrite(motor2_2,0);
      arduino.analogWrite(motor2_1,rmotor);
      rmotor_cur=rmotor;
    }
  }
  
  delay(dur); //Duration of each task
}
