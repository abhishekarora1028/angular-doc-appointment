<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/navigation'); ?>
<div class="main">

    <div ng-app="main" ng-controller="DemoCtrl" >

        <div style="float:left; width:160px">
            <daypilot-navigator id="navigator" daypilot-config="navigatorConfig" daypilot-events="events"></daypilot-navigator>
        </div>
        <div style="margin-left: 160px">

            <div class="space">
                <select id="doctor" name="doctor" ng-model="doctor">
                    <?php
                    foreach ($doctors as $item) {
                        echo "<option value='" . $item["id"] . "'>" . $item["name"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <daypilot-calendar id="calendar" daypilot-config="calendarConfig" daypilot-events="events" ></daypilot-calendar>
        </div>

    </div>

    <script>
        var app = angular.module('main', ['daypilot']).controller('DemoCtrl', function ($scope, $timeout, $http) {

            $scope.doctor = '1';

            $scope.navigatorConfig = {
                selectMode: "week",
                showMonths: 3,
                skipMonths: 3,
                onTimeRangeSelected: function (args) {
                    loadEvents(args.start.firstDayOfWeek(), args.start.addDays(7));
                }
            };

            $scope.calendarConfig = {
                viewType: "Week",
                timeRangeSelectedHandling: "Disabled",
                onEventMoved: function (args) {
                    $http.post("<?php echo site_url('doctors/moveappointment'); ?>", args).success(function (data) {
                        $scope.calendar.message(data.message);
                    });
                },
                onEventResized: function (args) {
                    $http.post("<?php echo site_url('doctors/moveappointment'); ?>", args).success(function (data) {
                        $scope.calendar.message(data.message);
                    });
                },
                onBeforeEventRender: function (args) {
                    switch (args.data.tags.status) {
                        case "free":
                            args.data.barColor = "green";
                            break;
                        case "waiting":
                            args.data.barColor = "orange";
                            break;
                        case "confirmed":
                            args.data.barColor = "#f41616";  // red            
                            break;
                    }
                },
                onEventClick: function (args) {
                    var modal = new DayPilot.Modal({
                        onClosed: function (args) {
                            if (args.result) {  // args.result is empty when modal is closed without submitting
                                loadEvents();
                            }
                        }
                    });

                    modal.showUrl("<?php echo site_url("appointments/edit"); ?>?id=" + args.e.id());
                }
            };

            $scope.$watch("doctor", function () {
                loadEvents();
            });

            function loadEvents(day) {

                var params = {
                    doctor: $scope.doctor,
                    start: $scope.navigator.visibleStart(),
                    end: $scope.navigator.visibleEnd().toString()
                };

                $http.post("<?php echo site_url("doctors/getdoctorappointments"); ?>", params).success(function (data) {
                    if (day) {
                        $scope.calendarConfig.startDate = day;
                    }
                    $scope.events = data;
                });
            }
        });

    </script>

</div>
<div class="clear">
</div>
</div>
</body>    
</html>
