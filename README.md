arduinoWebCar
=============

An Arduino car that is remotely controlled from a webpage

Everything in public_html should be placed in the public_html folder on your web server, which should be capable of executing PHP and have file read/write permissions. The livestream_car.pde file is a script written in processing to be run on the computer connected to the Arduino.


You WILL need to edit the livestream_car.pde file to ensure that:

1. The script is looking at the correct COM port for the Arduino (line 24)
2. The script has the proper pins on the Arduino to use for motors (line 16-20)
3. The script is looking at the proper webserver (line 34)


The Arduino car is built using an H-Bridge and two motors, a right and a left, each of which requires two PWMs through the H-Bridge. The Arduino itself should have the StandardFirmata sketch written on it to allow the Processing script to communicate with it.

This was originally done with an Arduino Uno, but should have no problem when used with another Arduino (but may require additional configuration in livestream_car.pde)
<<<<<<< HEAD

A working install of the server-side app can be seen here:
http://shsbio.net/riley/arduino/livecar/v2/
=======
>>>>>>> 64c1a81c9b4eea38cfe31ad908ae506e70fcd2d5
