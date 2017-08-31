<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/navigation'); ?>
<div class="main">
    <div ng-app="main" ng-controller="DemoCtrl" >

        <div style="float:left; width:160px">
            <daypilot-navigator id="navigator" daypilot-config="navigatorConfig" daypilot-events="events"></daypilot-navigator>
        </div>
        <div style="margin-left: 160px">
            <div class="space">Available time slots:</div>
            <daypilot-calendar id="calendar" daypilot-config="calendarConfig" daypilot-events="events" ></daypilot-calendar>
        </div>

    </div>

    <script>
        var app = angular.module('main', ['daypilot']).controller('DemoCtrl', function ($scope, $timeout, $http) {

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
                eventMoveHandling: "Disabled",
                eventResizeHandling: "Disabled",
                onBeforeEventRender: function (args) {
                    switch (args.data.tags.status) {
                        case "free":
                            args.data.barColor = "green";
                            args.data.html = args.data.doctor_name + " (Available)";
                            args.data.toolTip = "Click to request this time slot";
                            break;
                        case "waiting":
                            args.data.barColor = "orange";
                            args.data.html = "Waiting for confirmation from " + args.data.doctor_name;
                            break;
                        case "confirmed":
                            args.data.barColor = "#f41616";  // red            
                            args.data.html = "Confirmed with " + args.data.doctor_name;
                            break;
                    }
                },
                onEventClick: function (args) {

                    if (args.e.tag("status") !== "free") {
                        $scope.calendar.message("You can only request a new appointment in a free slot.");
                        return;
                    }

                    var modal = new DayPilot.Modal({
                        onClosed: function (args) {
                            if (args.result) {  // args.result is empty when modal is closed without submitting
                                loadEvents();
                            }
                        }
                    });

                    modal.showUrl("<?php echo site_url('appointments/request'); ?>?id=" + args.e.id());
                }
            };

            $timeout(function () {
                loadEvents();
            });


            function loadEvents(day) {

                var start = $scope.navigator.visibleStart() > new DayPilot.Date() ? $scope.navigator.visibleStart() : new DayPilot.Date();

                var params = {
                    start: start.toString(),
                    end: $scope.navigator.visibleEnd().toString()
                };

                $http.post("<?php echo site_url('appointments/getfree'); ?>", params).success(function (data) {
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
