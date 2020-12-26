<div class="row">
    <div class="col-sm-3">
        <?php 
            date_default_timezone_set("Asia/Kolkata");
            $month_array = array( '01' => 'January',
                   '02' => 'February',
                   '03' => 'March',
                   '04' => 'April',
                   '05' => 'May',
                   '06' => 'June',
                   '07' => 'July',
                   '08' => 'August',
                   '09' => 'September',
                   '10' => 'October',
                   '11' => 'November',
                   '12' => 'December'    
                );
            error_log( "calendar_start : " . $calendar_start );
            error_log( "calendar_end : " . $calendar_end );
            
            $start_date_array = explode( "-", $calendar_start );
            $start_date_year  = trim($start_date_array[0]);
            $start_date_month = trim($start_date_array[1]);
            if( strlen($start_date_month) > 1 )
                $start_date_month = $start_date_month[1];
            $start_date_day   = trim($start_date_array[2]);
            
            $end_date_array = explode( "-", $calendar_end );
            $end_date_year  = trim($end_date_array[0]);
            $end_date_month = trim($end_date_array[1]);
            if( strlen($end_date_month) > 1 )
                $end_date_month = $end_date_month[1];
            $end_date_day   = trim($end_date_array[2]);
            
            if( $start_date_year < $end_date_year ){
                for( $i = $start_date_month; $i <= 12; $i++ ){ 
                    $idx = "0$i";
                    if( $i >= 10 )
                        $idx = "$i";
                    
                    //echo "<p>" . $month_array[$idx] . "," . $start_date_year . "</p>"; 
                    echo "<input type='button' class='btn btn-link date-panel' value='$month_array[$idx], $start_date_year'"
                            . " onclick=\"showDates('$i, $start_date_year');\" ><br>";
                }
                for( $i = 1; $i <= $end_date_month; $i++ ){
                    $idx = "0$i";
                    if( $i >= 10 )
                        $idx = "$i";
                    
                    //echo "<p>" . $month_array[$idx] . "," . $end_date_year . "</p>"; 
                    echo "<input type='button' class='btn btn-link date-panel' value='$month_array[$idx], $end_date_year'"
                            . " onclick=\"showDates('$i, $end_date_year');\"><br>";
                }
            } else {
                for( $i = $start_date_month; $i <= $end_date_month; $i++ ){ 
                    $idx = "0$i";
                    if( $i >= 10 )
                        $idx = "$i";
                    
                    //echo "<p>" . $month_array[$idx] . "," . $start_date_year . "</p>";   
                    echo "<input type='button' class='btn btn-link date-panel' value='$month_array[$idx], $start_date_year'"
                            . " onclick=\"showDates('$i, $start_date_year');\"><br>";
                }
            }
            
            function escapeString( $input_str ){
                $input_str = str_replace("'", '&#39;', $input_str);
                $input_str = str_replace("'", '&quot;', $input_str);
                return $input_str;        
            }
        ?>
    </div>
    <div class="col-sm-9">
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-7" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date"> <!-- style="margin:0px;" month and year as input-->
                    <div class="panel-body">
                        <p id="selectedPeriod" style="text-align: center;font-weight: bold;margin:0;"></p>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_1_panel"> <!-- style="margin:0px;" month and year as input-->
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_1"></p>
                        <input type="hidden" id="day_1_1_desc" value="">
                        <input type="hidden" id="day_1_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_2"></p>
                        <input type="hidden" id="day_1_2_desc" value="">
                        <input type="hidden" id="day_1_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_3"></p>
                        <input type="hidden" id="day_1_3_desc" value="">
                        <input type="hidden" id="day_1_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_4"></p>
                        <input type="hidden" id="day_1_4_desc" value="">
                        <input type="hidden" id="day_1_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_5"></p>
                        <input type="hidden" id="day_1_5_desc" value="">
                        <input type="hidden" id="day_1_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_6"></p>
                        <input type="hidden" id="day_1_6_desc" value="">
                        <input type="hidden" id="day_1_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_1_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_1_7"></p>
                        <input type="hidden" id="day_1_7_desc" value="">
                        <input type="hidden" id="day_1_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_1_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_1"></p>
                        <input type="hidden" id="day_2_1_desc" value="">
                        <input type="hidden" id="day_2_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_2"></p>
                        <input type="hidden" id="day_2_2_desc" value="">
                        <input type="hidden" id="day_2_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_3"></p>
                        <input type="hidden" id="day_2_3_desc" value="">
                        <input type="hidden" id="day_2_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_4"></p>
                        <input type="hidden" id="day_2_4_desc" value="">
                        <input type="hidden" id="day_2_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_5"></p>
                        <input type="hidden" id="day_2_5_desc" value="">
                        <input type="hidden" id="day_2_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_6"></p>
                        <input type="hidden" id="day_2_6_desc" value="">
                        <input type="hidden" id="day_2_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_2_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_2_7"></p>
                        <input type="hidden" id="day_2_7_desc" value="">
                        <input type="hidden" id="day_2_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_1_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_1"></p>
                        <input type="hidden" id="day_3_1_desc" value="">
                        <input type="hidden" id="day_3_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_2"></p>
                        <input type="hidden" id="day_3_2_desc" value="">
                        <input type="hidden" id="day_3_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_3"></p>
                        <input type="hidden" id="day_3_3_desc" value="">
                        <input type="hidden" id="day_3_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_4"></p>
                        <input type="hidden" id="day_3_4_desc" value="">
                        <input type="hidden" id="day_3_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_5"></p>
                        <input type="hidden" id="day_3_5_desc" value="">
                        <input type="hidden" id="day_3_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_6"></p>
                        <input type="hidden" id="day_3_6_desc" value="">
                        <input type="hidden" id="day_3_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_3_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_3_7"></p>
                        <input type="hidden" id="day_3_7_desc" value="">
                        <input type="hidden" id="day_3_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_1_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_1"></p>
                        <input type="hidden" id="day_4_1_desc" value="">
                        <input type="hidden" id="day_4_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_2"></p>
                        <input type="hidden" id="day_4_2_desc" value="">
                        <input type="hidden" id="day_4_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_3"></p>
                        <input type="hidden" id="day_4_3_desc" value="">
                        <input type="hidden" id="day_4_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_4"></p>
                        <input type="hidden" id="day_4_4_desc" value="">
                        <input type="hidden" id="day_4_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_5"></p>
                        <input type="hidden" id="day_4_5_desc" value="">
                        <input type="hidden" id="day_4_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_6"></p>
                        <input type="hidden" id="day_4_6_desc" value="">
                        <input type="hidden" id="day_4_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_4_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_4_7"></p>
                        <input type="hidden" id="day_4_7_desc" value="">
                        <input type="hidden" id="day_4_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_1_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_1"></p>
                        <input type="hidden" id="day_5_1_desc" value="">
                        <input type="hidden" id="day_5_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_2"></p>
                        <input type="hidden" id="day_5_2_desc" value="">
                        <input type="hidden" id="day_5_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_3"></p>
                        <input type="hidden" id="day_5_3_desc" value="">
                        <input type="hidden" id="day_5_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_4"></p>
                        <input type="hidden" id="day_5_4_desc" value="">
                        <input type="hidden" id="day_5_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_5"></p>
                        <input type="hidden" id="day_5_5_desc" value="">
                        <input type="hidden" id="day_5_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_6"></p>
                        <input type="hidden" id="day_5_6_desc" value="">
                        <input type="hidden" id="day_5_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_5_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_5_7"></p>
                        <input type="hidden" id="day_5_7_desc" value="">
                        <input type="hidden" id="day_5_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin:0;">
            <div class="col-sm-1" style="margin:0;padding:2px;"></div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_1_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_1"></p>
                        <input type="hidden" id="day_6_1_desc" value="">
                        <input type="hidden" id="day_6_1_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_2_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_2"></p>
                        <input type="hidden" id="day_6_2_desc" value="">
                        <input type="hidden" id="day_6_2_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_3_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_3"></p>
                        <input type="hidden" id="day_6_3_desc" value="">
                        <input type="hidden" id="day_6_3_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_4_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_4"></p>
                        <input type="hidden" id="day_6_4_desc" value="">
                        <input type="hidden" id="day_6_4_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_5_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_5"></p>
                        <input type="hidden" id="day_6_5_desc" value="">
                        <input type="hidden" id="day_6_5_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_6_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_6"></p>
                        <input type="hidden" id="day_6_6_desc" value="">
                        <input type="hidden" id="day_6_6_event_type" value="">
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="margin:0;padding:2px;">
                <div class="panel panel-default panel-date" id="day_6_7_panel">
                    <div class="panel-body">
                        <p style="margin:0;text-align:center;" id="day_6_7"></p>
                        <input type="hidden" id="day_6_7_desc" value="">
                        <input type="hidden" id="day_6_7_event_type" value="">
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-sm-9">
                <div class="panel panel-default" style="margin-top:20px;">
                    <div class="panel-body">
                        <input type="hidden" id="calendar_events_content" value='<?php echo escapeString(json_encode($calendar_info));?>'>
                        <table class="table table-responsive" id="calendar_events" style="margin:0;">
                            <colgroup>
                                <col style="width:35%;">
                                <col style="width:65%;">
                            </colgroup>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>