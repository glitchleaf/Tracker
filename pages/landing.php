<?php
/**
 * Created by PhpStorm.
 * User: joann
 * Date: 10/21/2018
 * Time: 4:44 PM
 */

if (!defined('TRACKER')) die('No.');

// Load department list
$departments = getDepartments(0);
$cDept = isCheckedIn($badgeID)[0];
?>
<div class="container" style="top: 5em;position: relative;">
    <div class="card">
        <div class="card-header">
            <?php echo 'Check-' . ($cDept ? "Out" : "In") ?>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="card-body">
                        <div id="checkstatus" class="alert alert-<?php echo($cDept ? "success" : "danger") ?>"
                             style="padding: 0.4rem 1rem; margin: 0>" role="alert">
                            You are currently <?php echo($cDept ? "" : "not") ?> checked in.
                        </div>

                        <!--<p class="card-text">Select a department from the list on the right.</p>-->
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card-body">
                        <select <?php echo($cDept ? "disabled " : "") ?> id="dept" class="custom-select custom-select-lg mb-3"
                                style="margin-bottom: 0 !important;">

                            <?php if (!$cDept) { ?>
                                <option value="-1" disabled selected hidden>Select Department</option>
                            <?php } ?>
                            <?php foreach ($departments as $dept) echo "<option " . ($cDept['dept'] == $dept['id'] ? "selected" : "") . " value='" . $dept['id'] . "'>" . $dept['name'] . "</option>"; ?>

                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card-body">
                        <a href="#" id="checkinout" class="btn btn-block btn-primary"
                           data-value="<?php echo($cDept ? "out" : "in") ?>"><?php echo 'Check-' . ($cDept ? "Out" : "In") ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container" style="top: 5em;position: relative;">
    <div class="card">
        <div class="card-header">
            Your Stats
        </div>

        <div class="row">
            <div class="col-sm">
                <div class="card-body">
                    <div class="statistic">
                        <div class="value"><img src="/tracker/assets/img/clock-circular-outline.png"
                                                class="img-circle inline image"> 0
                        </div>
                        <div class="label">Hours Today</div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card-body">
                    <div class="statistic">
                        <div class="value"><img src="/tracker/assets/img/clock-circular-outline.png"
                                                class="img-circle inline image"> 0
                        </div>
                        <div class="label">Hours Earned</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="autologout">Auto logout in <span id="lsec">60</span> <span id="gram">seconds</span>...</div>
    </div>
</div>
<script src="js/landing.js"></script>