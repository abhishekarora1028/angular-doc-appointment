<?php $this->load->view('includes/header'); ?>
<div ng-app="main" ng-controller="AppointmentEditCtrl" style="padding:10px">

    <h3>Edit Appointment Slot</h3>

    <div class="space">
        <button id="delete" ng-click="delete()">Delete</button>
    </div>
    <form name="editAppointment" ng-submit="save()" novalidate>
    <div>Start:</div>
    <div><input type="text" id="start" name="start" disabled ng-model="appointment.start" /></div>

    <div>End:</div>
    <div><input type="text" id="end" name="end" disabled  ng-model="appointment.end" /></div>

    <div class="space">
        <div>Doctor:</div>
        <div>
            <select id="resource" name="resource" disabled ng-model="appointment.doctor">
                <?php
                foreach ($doctors as $item) {
                    $selected = "";
                    if ($event["doctor_id"] == $item["doctor_id"]) {
                        $selected = " selected";
                    }
                    echo "<option value='" . $item["id"] . "'" . $selected . ">" . $item["name"] . "</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="space">
        <div>Status:</div>
        <div>
            <select id="status" name="status" ng-model="appointment.status">
                <option value="free">Free</option>
                <option value="waiting">Waiting</option>
                <option value="confirmed">Confirmed</option>
            </select>
        </div>
    </div>

    <div>Name: </div>
    <div><input type="text" id="name" name="name" ng-model="appointment.name" ng-disabled="appointment.status === 'free'" required/></div>
    <span ng-show="appointment.status !== 'free' && editAppointment.name.$invalid && !editAppointment.name.$pristine">The name is required.</span>
    
    <div class="space"><input type="submit" value="Save" ng-disabled="editAppointment.$invalid" /> <a href="" id="cancel" ng-click="cancel()">Cancel</a></div>
    </form>
</div>

<script type="text/javascript">

    var app = angular.module('main', ['daypilot']).controller('AppointmentEditCtrl', function ($scope, $timeout, $http) {
        $scope.appointment = {
            id: '<?php echo $event['appointment_id'] ?>',
            name: '<?php echo $event['appointment_patient_name'] ?>',
            doctor: '<?php echo $event['doctor_id'] ?>',
            status: '<?php echo $event['appointment_status'] ?>',
            start: '<?php print (new DateTime($event['appointment_start']))->format('d/M/y g:i A') ?>',
            end: '<?php print (new DateTime($event['appointment_end']))->format('d/M/y g:i A') ?>',
        };
        $scope.delete = function () {
            $http.post("<?php echo site_url('appointments/delete'); ?>", $scope.appointment).success(function (data) {
                DayPilot.Modal.close(data);
            });
        };
        $scope.save = function () {
            $http.post("<?php echo site_url('doctors/editappointment'); ?>", $scope.appointment).success(function (data) {
                DayPilot.Modal.close(data);
            });
        };
        $scope.cancel = function () {
            DayPilot.Modal.close();
        };

        $("#name").focus();
    });

</script>
</body>
</html>
