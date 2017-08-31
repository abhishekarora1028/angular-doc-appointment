<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Doctor Appointment Scheduling</title>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/layout.css'); ?>" />    

        <style type="text/css">
            #calendar .calendar_default_event_bar, #calendar .calendar_default_event_bar_inner {
                width: 10px;
            }

            #calendar .calendar_default_event_inner {
                padding-left: 12px;
            }                        
        </style>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/angular.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/daypilot/daypilot-all.min.js'); ?>"></script>
    </head>
    <body>