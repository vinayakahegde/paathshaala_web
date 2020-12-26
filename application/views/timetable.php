<?php 
$dayArray = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
$periodArray = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" );
?> 
<div class="row" style="margin:20px;">
    <div class="col-sm-offset-10">
        <input type="button" id="editTimeTableBtn" name="editTimeTableBtn" 
               class="btn btn-warning" value="EDIT TIMETABLE">
        <br>
    </div>
</div>
<div class="row" style="margin:0;">
    <div class="col-sm-1" style="margin:0;padding:2px;"></div>
    <div class="col-sm-1" style="margin:0;padding:2px;"></div>
<?php for( $k=0; $k < _MAX_NUM_OF_PERIODS; $k++ ){ ?>
    <div class="col-sm-1" style="margin:0;padding:2px;">
        <div class="panel panel-default panel-date panel-period" id="tt_period_<?php echo $k; ?>_panel"> <!-- style="margin:0px;" month and year as input-->
            <div class="panel-body">
                <p style="margin:0;text-align:center;" id="tt_period_<?php echo $k; ?>"><strong><?php echo $periodArray[$k]; ?></strong></p>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php for( $j=0; $j < _MAX_NUM_DAYS; $j++ ){ ?>
<div class="row" style="margin:0;">
    <div class="col-sm-1" style="margin:0;padding:2px;"></div>
    <div class="col-sm-1" style="margin:0;padding:2px;">
        <div class="panel panel-default panel-date panel-day" id="tt_day_<?php echo $j; ?>_panel"> <!-- style="margin:0px;" month and year as input-->
            <div class="panel-body">
                <p style="margin:0;text-align:center;" id="tt_day_<?php echo $j; ?>"><strong><?php echo $dayArray[$j]; ?></strong></p>
            </div>
        </div>
    </div>
    <?php for( $i=0; $i < _MAX_NUM_OF_PERIODS; $i++ ){ ?>
        <div class="col-sm-1" style="margin:0;padding:2px;">
            <div class="panel panel-default panel-date" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_panel" 
                 data-toggle="modal" data-target="#editSubjectsTTModal"> <!-- style="margin:0px;" month and year as input-->
                <!-- onclick="showTTSubjectChg(<php echo $j; ?>, <php echo $i; ?>);" -->
                <div class="panel-body">
                    <p style="margin:0;text-align:center;" id="tt_<?php echo $j; ?>_<?php echo $i; ?>">&nbsp;</p>
                    <input type="hidden" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_subject_id" value="">
                    <input type="hidden" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_teacher_id" value="">
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php } ?>