<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 text-right">&nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 text-left">
            <h3>Doctors Appointment Scheduler</h3>
        </div>
        <div class="col-lg-6 text-right">
            <a class = "btn btn-<?php echo (isset($publictab) ? 'primary' : 'default'); ?>" href="<?php echo site_url(''); ?>">Public</a> &nbsp;
            <a class = "btn btn-<?php echo (isset($doctorstab) ? 'primary' : 'default'); ?>" href="<?php echo site_url('doctors'); ?>">Doctors</a> &nbsp;
            <a class = "btn btn-<?php echo (isset($managerstab) ? 'primary' : 'default'); ?>" href="<?php echo site_url('managers'); ?>">Managers</a>
        </div>
    </div>
