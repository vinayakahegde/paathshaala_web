<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body>
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
        <div id="main" class="container" style="padding-bottom:0px;">
            <?php
                $displayData = array();
                if( isset($headerData) )
                    $displayData['headerData'] = $headerData;

                $this->load->view('common/header',$displayData); 

                $displayData = array();
                if( isset($user_type) )
                    $displayData['user_type'] = $user_type;
                if( isset($user_id) )
                    $displayData['user_id'] = $user_id;
                
                $this->load->view('common/menu', $displayData);

                function escapeString( $input_str ){

                    $input_str = str_replace("'", '&#39;', $input_str);
                    $input_str = str_replace("'", '&quot;', $input_str);
                    return $input_str;        
                }
            ?>
            <div class="container-fluid" style="margin:0px;padding:15px;"> <!--  -->
                <div class="panel panel-default" style="width:100%;height:100%;">
                    <div class="panel-body" style="width:100%;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="applicationSearchForm" name="applicationSearchForm" method="post" action="/applications/1/<?php echo $pageSize; ?>">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationPeriod">Application Date</label>
                                                <select class="light_background form-control" id="applicationPeriod" name="applicationPeriod">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_WEEK ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_ONE_WEEK) echo "selected"; ?>>Since One Week</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_WEEKS ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_TWO_WEEKS) echo "selected"; ?>>Since Two Weeks</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_MONTH ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_ONE_MONTH) echo "selected"; ?>>Since One Month</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_MONTHS ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_TWO_MONTHS) echo "selected"; ?>>Since Two Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_THREE_MONTHS ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_THREE_MONTHS) echo "selected"; ?>>Since Three Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_SIX_MONTHS ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_SIX_MONTHS) echo "selected"; ?>>Since Six Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_NINE_MONTHS ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_NINE_MONTHS) echo "selected"; ?>>Since Nine Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_YEAR ?>" 
                                                        <?php if(isset($applicationPeriod) && $applicationPeriod == _TIME_PERIOD_ONE_YEAR) echo "selected"; ?>>Since This Year</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationStatus">Application Status</label>
                                                <select class="light_background form-control" id="applicationStatus" name="applicationStatus">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_NEW ?>" 
                                                        <?php if(isset($applicationStatus) && $applicationStatus == _ADMISSION_APPLICATION_STATUS_NEW ) echo "selected"; ?>>New</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_WAITING_LIST ?>" 
                                                        <?php if(isset($applicationStatus) && $applicationStatus == _ADMISSION_APPLICATION_STATUS_WAITING_LIST) echo "selected"; ?>>Waiting List</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_ACCEPTED ?>" 
                                                        <?php if(isset($applicationStatus) && $applicationStatus == _ADMISSION_APPLICATION_STATUS_ACCEPTED) echo "selected"; ?>>Accepted</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_REJECTED ?>" 
                                                        <?php if(isset($applicationStatus) && $applicationStatus == _ADMISSION_APPLICATION_STATUS_REJECTED) echo "selected"; ?>>Rejected</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationMotherTongue">Mother Tongue</label>
                                                <select class="light_background form-control" id="applicationMotherTongue" name="applicationMotherTongue">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_LANG_HINDI ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_HINDI) echo "selected"; ?>>Hindi</option>
                                                    <option value="<?php echo _ADMISSION_LANG_ENGLISH ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_ENGLISH) echo "selected"; ?>>English</option>
                                                    <option value="<?php echo _ADMISSION_LANG_KANNADA ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_KANNADA) echo "selected"; ?>>Kannada</option>
                                                    <option value="<?php echo _ADMISSION_LANG_TELUGU ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_TELUGU) echo "selected"; ?>>Telugu</option>
                                                    <option value="<?php echo _ADMISSION_LANG_MALAYALAM ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_MALAYALAM) echo "selected"; ?>>Malayalam</option>
                                                    <option value="<?php echo _ADMISSION_LANG_TAMIL ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_TAMIL) echo "selected"; ?>>Tamil</option>
                                                    <option value="<?php echo _ADMISSION_LANG_MARATHI ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_MARATHI) echo "selected"; ?>>Marathi</option>
                                                    <option value="<?php echo _ADMISSION_LANG_GUJARATHI ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_GUJARATHI) echo "selected"; ?>>Gujarathi</option>
                                                    <option value="<?php echo _ADMISSION_LANG_BENGALI ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_BENGALI) echo "selected"; ?>>Bengali</option>
                                                    <option value="<?php echo _ADMISSION_LANG_ORIYA ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_ORIYA) echo "selected"; ?>>Oriya</option>
                                                    <option value="<?php echo _ADMISSION_LANG_URDU ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_URDU) echo "selected"; ?>>Urdu</option>
                                                    <option value="<?php echo _ADMISSION_LANG_PUNJABI ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_PUNJABI) echo "selected"; ?>>Punjabi</option>
                                                    <option value="<?php echo _ADMISSION_LANG_ASSAMESE ?>" 
                                                        <?php if(isset($applicationMotherTongue) && $applicationMotherTongue == _ADMISSION_LANG_ASSAMESE) echo "selected"; ?>>Assamese</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationIncomeLevel">Annual Income</label>
                                                <select class="light_background form-control" id="applicationIncomeLevel" name="applicationIncomeLevel">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_ANNUAL_INC_UPTO_5 ?>" 
                                                        <?php if(isset($applicationIncomeLevel) && $applicationIncomeLevel == _ADMISSION_ANNUAL_INC_UPTO_5) echo "selected"; ?>>Upto Rs. 5 Lakhs per annum</option>
                                                    <option value="<?php echo _ADMISSION_ANNUAL_INC_5_TO_10 ?>" 
                                                        <?php if(isset($applicationIncomeLevel) && $applicationIncomeLevel == _ADMISSION_ANNUAL_INC_5_TO_10) echo "selected"; ?>>Between Rs. 5 to 10 Lakhs per annum</option>
                                                    <option value="<?php echo _ADMISSION_ANNUAL_INC_10_TO_15 ?>" 
                                                        <?php if(isset($applicationIncomeLevel) && $applicationIncomeLevel == _ADMISSION_ANNUAL_INC_10_TO_15) echo "selected"; ?>>Between Rs.10 to 15 Lakhs per annum</option>
                                                    <option value="<?php echo _ADMISSION_ANNUAL_INC_15_TO_25 ?>" 
                                                        <?php if(isset($applicationIncomeLevel) && $applicationIncomeLevel == _ADMISSION_ANNUAL_INC_15_TO_25) echo "selected"; ?>>Between Rs. 15 to 25 Lakhs per annum</option>
                                                    <option value="<?php echo _ADMISSION_ANNUAL_INC_25_PLUS ?>" 
                                                        <?php if(isset($applicationIncomeLevel) && $applicationIncomeLevel == _ADMISSION_ANNUAL_INC_25_PLUS) echo "selected"; ?>>More than Rs. 25 Lakhs per annum</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationFatherQual">Father's Qualification</label>
                                                <select class="light_background form-control" id="applicationFatherQual" name="applicationFatherQual">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_UPTO_TENTH ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_UPTO_TENTH) echo "selected"; ?>>Upto Tenth Standard</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_12TH ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_COMPLETED_12TH) echo "selected"; ?>>Completed XII/ PUC </option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_DIPLOMA ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_COMPLETED_DIPLOMA) echo "selected"; ?>>Completed Diploma</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_BACHELORS ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_COMPLETED_BACHELORS) echo "selected"; ?>>Completed Bacherlors Degree</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_MASTERS ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_COMPLETED_MASTERS) echo "selected"; ?>>Completed Masters Degree</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_PHD ?>" 
                                                        <?php if(isset($applicationFatherQual) && $applicationFatherQual == _ADMISSION_QUAL_COMPLETED_PHD) echo "selected"; ?>>Completed PhD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationMotherQual">Mother's Qualification</label>
                                                <select class="light_background form-control" id="applicationMotherQual" name="applicationMotherQual">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_UPTO_TENTH ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_UPTO_TENTH) echo "selected"; ?>>Upto Tenth Standard</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_12TH ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_COMPLETED_12TH) echo "selected"; ?>>Completed XII/ PUC </option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_DIPLOMA ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_COMPLETED_DIPLOMA) echo "selected"; ?>>Completed Diploma</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_BACHELORS ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_COMPLETED_BACHELORS) echo "selected"; ?>>Completed Bacherlors Degree</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_MASTERS ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_COMPLETED_MASTERS) echo "selected"; ?>>Completed Masters Degree</option>
                                                    <option value="<?php echo _ADMISSION_QUAL_COMPLETED_PHD ?>" 
                                                        <?php if(isset($applicationMotherQual) && $applicationMotherQual == _ADMISSION_QUAL_COMPLETED_PHD) echo "selected"; ?>>Completed PhD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="applicationForClass">Applying for Class</label>
                                                <select class="light_background form-control" id="applicationForClass" name="applicationForClass">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_PLAY_HOME) echo "selected"; ?>>Play Home</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_PRE_KG ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_PRE_KG) echo "selected"; ?>>Pre - KG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_LKG ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_LKG) echo "selected"; ?>>LKG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_UKG ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_UKG) echo "selected"; ?>>UKG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_1) echo "selected"; ?>>Class I</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_2) echo "selected"; ?>>Class II</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_3) echo "selected"; ?>>Class III</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_4) echo "selected"; ?>>Class IV</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_5) echo "selected"; ?>>Class V</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_6) echo "selected"; ?>>Class VI</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_7) echo "selected"; ?>>Class VII</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_8) echo "selected"; ?>>Class VIII</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_9) echo "selected"; ?>>Class IX</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_10) echo "selected"; ?>>Class X</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_11) echo "selected"; ?>>Class XI</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>" 
                                                        <?php if(isset($applicationForClass) && $applicationForClass == _ADMISSION_APPLY_CLASS_12) echo "selected"; ?>>Class XII</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4">
                                            <br>
                                            <input type="submit" id="btnSearch" name="btnSearch" value="Search" 
                                                   class="btn btn-primary" style="width:100%;font-weight:bold;">
                                        </div>
                                    </div>               
                                </form>
                            </div>
                        </div>
                        <?php 
                            $limitStart = ( ($pageNo-1) * $pageSize ) + 1;
                            $limitEnd   = ( $applicationCount > ($pageNo * $pageSize) ) ? $pageNo * $pageSize : $applicationCount; 
                            $statusLabel = "applications";                
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <p style="text-align:center;color:#337ab7;"><?php echo "Showing ".$limitStart."-".$limitEnd." of ".$applicationCount." ".$statusLabel; ?></p>
                            </div> 
                            <div class="col-sm-4" style="text-align:center;">
                                <a href="#" title="First Page" onclick="goToFirstPage('applications','applicationSearchForm', 
                                            <?php echo $pageSize; ?>);" style="font-size:16px;">&lt;&lt;</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Previous Page" onclick="goToPrevPage('applications','applicationSearchForm',
                                            <?php echo $pageNo; ?>, <?php echo $pageSize; ?> );" style="font-size:16px;">&lt;</a>
                                &nbsp;&nbsp;&nbsp;<strong>Page No :</strong>&nbsp;
                                <input type="text" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" 
                                       style="width:25px;border-radius:3px;" onkeyup="handlePageNoKeyPress(event,'applicationSearchForm', 'applications',
                                                            '<?php echo $pageSize;?>', '<?php echo $applicationCount;?>');">&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Next Page" onclick="goToNextPage('applications','applicationSearchForm',
                                            <?php echo $pageNo; ?>, <?php echo $pageSize; ?>, <?php echo $applicationCount; ?>);" style="font-size:16px;">&gt;</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Last Page" onclick="goToLastPage('applications','applicationSearchForm',
                                            <?php echo $pageSize; ?>, <?php echo $applicationCount; ?>);" style="font-size:16px;">&gt;&gt;</a>
                            </div> 
                            <div class="col-sm-4" style="text-align:center;padding-bottom:10px;">
                                <button type="button" class="btn btn-default btn-sm" name="exportReport" id="exportReport"
                                        onclick="exportReportsData(1, <?= $applicationCount?>);" style="width:100px;">
                                    <span class="glyphicon glyphicon-download-alt"></span> <strong>Export</strong>
                                </button>
                            </div>
                        </div>
                      <div class="panel panel-default">
                          <div class="panel-body">
                              <div class="table-responsive">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-striped" >
                                      <colgroup>                
                                          <col style="width:2%;">
                                          <col style="width:3%;">
                                          <col style="width:20%;">
                                          <col style="width:10%;">
                                          <col style="width:15%;">
                                          <col style="width:15%;">
                                          <col style="width:15%;">
                                          <col style="width:5%;">
                                          <col style="width:5%;">
                                          <col style="width:8%;">
                                          <col style="width:2%;">
                                      </colgroup>
                                      <tr style="background:#337ab7;"> <!--  style="font-family: Consolas, monaco, monospace;" -->
                                          <th style="text-align: center;">Select</th>
                                          <th style="text-align:center;">Application ID</th>
                                          <th style="text-align:center;">Student Name</th>
                                          <th style="text-align:center;">Applying For</th>
                                          <th style="text-align:center;">Applied On</th>
                                          <th style="text-align:center;">Status</th>
                                          <th style="text-align:center;">Action</th>
                                          <th style="text-align:center;">Details</th>
                                      </tr>
                                      <?php 
                                          for( $i = 0; $i < count($applicationDetails); $i++ ){
                                      ?>
                                      <tr> 
                                          <td style="text-align: center;"><input type="checkbox" name="application_<?php echo $applicationDetails[$i]['application_id']; ?>" 
                                                     accept=""id="application_<?php echo $applicationDetails[$i]['application_id']; ?>" 
                                                     value="<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     onchange="updateApplicationSelectedCount();" ></td>
                                          <td style="text-align: center;">
                                              <?php echo $applicationDetails[$i]['application_id']; ?>
                                              <input type="hidden" id="student_name_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['student_name']; ?>" >
                                              <input type="hidden" id="father_name_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['father_name']; ?>" >
                                              <input type="hidden" id="mother_name_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['mother_name']; ?>" >
                                              <input type="hidden" id="class_desc_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['class_desc']; ?>" >
                                              <input type="hidden" id="father_qual_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['father_qual']; ?>" >
                                              <input type="hidden" id="mother_qual_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['mother_qual']; ?>" >
                                              <input type="hidden" id="income_desc_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['income_desc']; ?>" >
                                              <input type="hidden" id="language_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['language']; ?>" >
                                              <input type="hidden" id="phone_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['phone']; ?>" >
                                              <input type="hidden" id="email_id_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['email_id']; ?>" >
                                              <input type="hidden" id="applied_at_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['applied_at']; ?>" >
                                              <input type="hidden" id="status_<?php echo $applicationDetails[$i]['application_id']; ?>"
                                                     value="<?php echo $applicationDetails[$i]['status']; ?>" >
                                          </td>
                                          <td style="text-align: center;"><?php echo $applicationDetails[$i]['student_name']; ?></td>
                                          <td style="text-align: center;"><?php echo $applicationDetails[$i]['class_desc']; ?></td>
                                          <!-- <td><?php echo $applicationDetails[$i]['father_qual']; ?></td>
                                          <td><?php echo $applicationDetails[$i]['mother_qual']; ?></td>
                                          <td><?php echo $applicationDetails[$i]['income_desc']; ?></td>
                                          <td><?php echo $applicationDetails[$i]['language']; ?></td>
                                          <td><?php echo $applicationDetails[$i]['phone']; ?></td> -->
                                          <td style="text-align: center;"><?php echo $applicationDetails[$i]['applied_at']; ?></td>
                                          <td style="text-align: center;"><?php echo $applicationDetails[$i]['status']; ?></td>
                                          <td style="text-align: center;">
                                              <?php if( $applicationDetails[$i]['status_id'] == _ADMISSION_APPLICATION_STATUS_NEW ){ ?>
                                                  <input type='button' value='Accept' onclick='changeApplicationStatus(<?php echo $applicationDetails[$i]['application_id']; ?>, 
                                                          <?php echo _ADMISSION_APPLICATION_STATUS_ACCEPTED; ?>, <?php echo $pageNo; ?>, <?php echo $pageSize; ?> );' 
                                                          class="btn btn-default" style="color: darkgreen;">
                                                  <input type='button' value='Reject' onclick='changeApplicationStatus(<?php echo $applicationDetails[$i]['application_id']; ?> , 
                                                              <?php echo _ADMISSION_APPLICATION_STATUS_REJECTED; ?>, <?php echo $pageNo; ?>, <?php echo $pageSize; ?>);' 
                                                              class="btn btn-default" style="color: darkred;">
                                                  <input type='button' value='Put In Waiting List' onclick='changeApplicationStatus(<?php echo $applicationDetails[$i]['application_id']; ?>, 
                                                              <?php echo _ADMISSION_APPLICATION_STATUS_WAITING_LIST; ?>);' 
                                                              class="btn btn-default" style="margin-top:5px; color:darkorange;">
                                              <?php } else if( $applicationDetails[$i]['status_id'] == _ADMISSION_APPLICATION_STATUS_WAITING_LIST ){ ?>
                                                  <input type='button' value='Accept' onclick='changeApplicationStatus(<?php echo $applicationDetails[$i]['application_id']; ?>, 
                                                              <?php echo _ADMISSION_APPLICATION_STATUS_ACCEPTED; ?>, <?php echo $pageNo; ?>, <?php echo $pageSize; ?> );' 
                                                              class="btn btn-default" style="color: darkgreen;" >
                                                  <input type='button' value='Reject' onclick='changeApplicationStatus(<?php echo $applicationDetails[$i]['application_id']; ?> , 
                                                              <?php echo _ADMISSION_APPLICATION_STATUS_REJECTED; ?>, <?php echo $pageNo; ?>, <?php echo $pageSize; ?>);' 
                                                              class="btn btn-default" style="color: darkred;" >   
                                              <?php } ?>
                                          </td>
                                          <td style="text-align: center;">
                                              <input type='button' value='Details' class="btn btn-warning" data-toggle="modal" data-target="#applicationModal" 
                                                     id="details_<?php echo $applicationDetails[$i]['application_id']; ?>" >
                                          </td>
                                      </tr>
                                      <?php } ?>  
                                  </table>
                              </div>
                              <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <p id="selectedApplications"></p><br>
                                            <label for="applicationAction">Action</label>
                                            <select id="applicationAction" name="applicationAction" class="light_background form-control">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_ACCEPTED; ?>">Accept</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_REJECTED; ?>">Reject</option>
                                                    <option value="<?php echo _ADMISSION_APPLICATION_STATUS_WAITING_LIST; ?>">Put In Waiting List</option>
                                            </select>
                                            <br>
                                            <input id="applicationActionSubmit" name="applicationActionSubmit" class="btn btn-primary"
                                                        type="button" value="Done" onclick="changeApplicationStatusBulk();">
                                        </div>
                                    </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="applicationModal" class="modal fade" role="dialog" style="height:100%;">
               <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                           <h4 class="modal-title" id="applicationTitle"></h4> <!-- <strong></strong> -->
                       </div>
                       <div class="modal-body" id="applicationModalContent">
                            <table class="table table-responsive table-striped table-bordered">
                                <tr>
                                    <td><strong>Application ID</strong></td>
                                    <td><p id='applicationID'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Student Name</strong></td>
                                    <td><p id='studentName'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Father's Name</strong></td>
                                    <td><p id='fatherName'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Father's Qualification</strong></td>
                                    <td><p id='fatherQualification'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Mother's Name</strong></td>
                                    <td><p id='motherName'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Mother's Qualification</strong></td>
                                    <td><p id='motherQualification'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Applied For Class</strong></td>
                                    <td><p id='forClass'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Income Level</strong></td>
                                    <td><p id='incomeLevel'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Mother Tongue</strong></td>
                                    <td><p id='motherTongue'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Phone Number</strong></td>
                                    <td><p id='phoneNum'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Email ID</strong></td>
                                    <td><p id='emailID'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Applied On</strong></td>
                                    <td><p id='appliedOn'></p></td>
                                </tr>
                                <tr>
                                    <td><strong>Application Status</strong></td>
                                    <td><p id='applicationStatusPopup'></p></td>
                                </tr>
                            </table>
                           <!-- <img id="applicationContentImage" class="img-rounded img-responsive" style="padding-bottom:20px;" alt="">
                           <p id="applicationContentText" style="width:100%;word-wrap:break-word;"></p> -->
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
    <?php 
        $displayData = array();
        $this->load->view('common/footer', $displayData);
    ?>
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/school.js"></script>
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>