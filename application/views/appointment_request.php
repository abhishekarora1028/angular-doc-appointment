<?php $this->load->view('includes/header'); ?>
<div ng-app="main" ng-controller="AppointmentRequestCtrl" style="padding:10px">
<form id="f" name = "requestAppointment" style="padding:20px;" ng-submit="save()" novalidate="">
    <input type="hidden" name="id" id="id" value="<?php print $event['appointment_id'] ?>" />
    <h3>Request an Appointment</h3>

    <div>Start:</div>
    <div><input type="text" id="start" name="start" value="<?php print (new DateTime($event['appointment_start']))->format('d/M/y g:i A') ?>" disabled /></div>

    <div>End:</div>
    <div><input type="text" id="end" name="end" value="<?php print (new DateTime($event['appointment_end']))->format('d/M/y g:i A') ?>" disabled /></div>
    
    <div>Your Name: </div>
    <div><input type="text" id="name" ng-model="appointment.name" name="name" value="" required/>
        <span ng-show="requestAppointment.name.$invalid && !requestAppointment.name.$pristine">The name is required.</span>
    </div>
    <div>Reason: </div>
    <div><select id="reason" ng-model="appointment.reason" name="reason" required>
            <option value = "">Select Reason</option>
            <option value = "Sickness">Sickness</option>
            <option value = "Injury">Injury</option>
            <option value = "General Body Checkup">General Body Checkup</option>
            <option value = "Eyes Checkup">Eyes Checkup</option>
            <option value = "Dental Checkup">Dental Checkup</option>
        </select>
        <span ng-show="!requestAppointment.reason.$pristine && requestAppointment.reason.$invalid">The reason is required.</span>
    </div>

    <div class="space"><input type="submit" ng-disabled="requestAppointment.$invalid" value="Save" /> <a href="#" id="cancel">Cancel</a></div>
</form>
</div>
<script type="text/javascript">

    var app = angular.module('main', ['daypilot']).controller('AppointmentRequestCtrl', function ($scope, $timeout, $http) {
        $scope.save = function () {
            var postData = {};
            $("#f").serializeArray().map(function(x){postData[x.name] = x.value;});
            $http.post("<?php echo site_url('appointments/save'); ?>", postData).success(function (data) {
                DayPilot.Modal.close(data);
            });
        };
        $("#name").focus();
    });

</script>
</body>
</html>
