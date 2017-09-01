# angular-doc-appointment
Doctors Appointment Scheduler - With AngularJs and Codeigniter

Daypilot AngularJs module (free version) | Backend is done with Codeigniter 3.1.5 | Database is sqlite

This application uses three different views:

Manager | Doctor | Patient

It allows the patients to request an appointment with reason to meet the doctor in one of the time slots defined by the manager or doctor. 
The appointment slots are defined in advance. 
The manager can create the appointment slots using drag and drop - it will automatically generate the slots with the defined size (1 hour) in the selected range (shift).

Frontend validations are done with AngularJs

Unit Tests are written in /Unittest Controller

# How to setup this:

1.) Download zip folder and copy it in your server directory 
    
    MAMP (Applications/MAMP/htdocs/)
    WAMP (C:/wamp/www/)
    XAMPP (C:/xampp/htdocs/)
    
2.) Go to application/config/config.php
3.) update base_url path to your http://localhost/angular-doc-appointment
4.) Run in your browser http://localhost/angular-doc-appointment
