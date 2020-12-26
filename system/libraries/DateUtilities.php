<?php

/**
 * Description of DateUtilities
 *
 * @author vinayakahegde
 */

class DateUtilities {
    public function __construct() {
        date_default_timezone_set('Asia/Calcutta');
    }
    
    /**
     * Inputs: 
     * $period - period as defined in the constants file
     * $fromSearch - passed by reference. Will be set a value depending on period and option
     * $toSearch - passed by reference. Will be set a value depending on period and option
     * $option - past or future time.
     *         - TRUE : future
     *         - FALSE : past
     * 
    **/    
    public function setDateRange( $period, &$fromSearch, &$toSearch, $option ){
        date_default_timezone_set("Asia/Kolkata");
        $cur_time = date("Y-m-d H:i:s");
        if( $option )
            $fromSearch = $cur_time;
        else
            $toSearch = $cur_time;
        
        $cur_time_date = date_create($cur_time);
        switch( $period ){
            case _TIME_PERIOD_ONE_WEEK : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("1 week"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("1 week"));                   
                break;
            
            case _TIME_PERIOD_TWO_WEEKS : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("2 weeks"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("2 weeks"));
                break;
            
            case _TIME_PERIOD_ONE_MONTH :
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("1 month"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("1 month"));
                break;
            
            case _TIME_PERIOD_TWO_MONTHS : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("2 months"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("2 months"));
                break;
            
            case _TIME_PERIOD_THREE_MONTHS : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("3 months"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("3 months"));
                break;
            
            case _TIME_PERIOD_SIX_MONTHS : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("6 months"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("6 months"));
                break;
            
            case _TIME_PERIOD_NINE_MONTHS : 
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("9 months"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("9 months"));
                break;
            
            case _TIME_PERIOD_ONE_YEAR :
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("1 year"));
                else 
                    date_sub($cur_time_date, date_interval_create_from_date_string("1 year"));
                break;
            
            default :
                if( $option )
                    date_add($cur_time_date, date_interval_create_from_date_string("1 month"));
                else
                    date_sub($cur_time_date, date_interval_create_from_date_string("1 month"));
                break;
        }
        
        if( $option )
            $toSearch = date_format($cur_time_date, "Y-m-d H:i:s");
        else
            $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
        
    }
}
