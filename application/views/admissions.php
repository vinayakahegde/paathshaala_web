<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body>
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
            <div id="main" class="container" style="padding-bottom:0px;"> <!-- style="padding:0px;margin:0px;width:100%;" -->
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
                
                $this->load->view('common/menu', $displayData); ?>
                <div class="container-fluid" style="margin:0px;">
                    <?php if( $header_message != "" ){ ?>
                        <div class="row">
                            <div id="alert" class="col-sm-6 col-sm-offset-3" style="position:fixed;z-index:10;height:25px;" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                                <p style="color:black;text-align:center;background-color:#FDFD88;padding-left:5px;padding-right:5px;"><?php echo $header_message; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div id="admissionsContentDiv" name="admissionsContentDiv" class="col-lg-9" style="padding:10px;padding-right:0px;">
                            <div id="admissionsContentPanel" name="admissionsContentPanel" class="panel panel-default">
                                <div id="admissionsContentText" name="admissionsContentText" class="panel-body">
                                    <p>Welcome to the admissions section!</p><br>
                                    <?php if( $admissions_open ){ ?>
                                        <p>The admissions for standards <strong>LKG</strong> to <strong>10th</strong> are now open.
                                            Please apply here and we will get back to you.</p><br>
                                        <p>Once your application has been accepted, you will get a mail notifying you about the same.
                                            Please come to the school with the following documents to complete the admission -
                                        </p>
                                        <p>1. Marks card from the previous school.</p>
                                        <p>2. Birth certificate.</p>
                                        <br>
                                        <p style="font-weight: bold;">Fee Details</p>
                                        <p>Admission Fee : Rs.50,000/- </p>
                                        <p>Yearly Fees : Rs. 40,000/- </p>
                                        <p>School Van( If Opted ) : Rs. 15,000/- </p>
                                        <br>
                                        <p style="font-weight: bold;">Important Dates </p>
                                        <p>Admission start date : 1 Jan, 2016 </p>
                                        <p>Last day to apply : 1 May, 2016 </p>
                                    <?php } else { ?>
                                        <p>The admissions have not yet started for academic year 2016-17.</p>
                                        <p>The admissions start on 1 Jan, 2016. Please apply on this site after this date.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div id="applicationPanelDiv" name="applicationPanelDiv" class="col-lg-3" style="padding:10px;height:100%;" >
                            <div id="applicationPanel" name="applicationPanel" class="panel panel-default">
                                <div id="applicationPanelContent" name="applicationPanelContent" class="panel-body">
                                    <br><br>
                                    <p>Download Prospectus</p>
                                    <br><br>
                                    <input type="button" id="apply" name="apply" class="btn btn-success btn-block btn-lg" data-toggle="modal" 
                                           data-target="#applicationDetailsModal" value="Apply For Admission"><!--onclick="showAdmissionPopup();"-->
                                    <br><br>
                                    <input type="button" id="viewStatus" name="viewStatus" class="btn btn-primary btn-block btn-lg"
                                           data-toggle="modal" data-target="#applicationStatusModal" value="View Application Status">
                                    <!-- onclick="showStatusPopup();" -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="applicationDetailsModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title"><strong>APPLICATION FORM</strong></h4>
                            </div>
                            <form id="applicationDetailsForm" name="applicationDetailsForm" action="/submitApplication" 
                                  method="post" onsubmit="return validateApplication();" role="form" class="form-horizontal">
                                <div class="modal-body">
                                    <div class="form-group" id="studentNameDiv">
                                        <label class="col-lg-2 control-label" for="test">Student Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="studentName" 
                                                   name="studentName" onblur="checkStudentName();" > 
                                        </div>
                                        <div class="col-lg-6">
                                            <!--<span class="help-inline">Please correct the error</span>-->
                                            <p id="studentNameMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="fatherNameDiv">
                                        <label class="col-lg-2 control-label" for="test">Father's Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="fatherName" 
                                                   name="fatherName" onblur="checkFatherName();"> <!--form-control  -->
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="fatherNameMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="motherNameDiv">
                                        <label class="col-lg-2 control-label" for="test">Mother's Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="motherName" 
                                                   name="motherName" onblur="checkMotherName();"> <!--form-control  -->
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="motherNameMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="homeAddressDiv">
                                        <label class="col-lg-2 control-label" for="test">Home Address</label>
                                        <div class="col-lg-4">
                                            <textarea class="form-control" rows="5" id="address" placeholder="Enter Address"
                                                      value="" name="address" id="address" onblur="checkAddress();"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="addressMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="pincodeDiv">
                                        <label class="col-lg-2 control-label" for="test">PIN code</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="pincode" 
                                                   name="pincode" onblur="checkPinCode();">
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="pincodeMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="contactNumberDiv">
                                        <label class="col-lg-2 control-label" for="test">Contact Number</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="phoneNum" 
                                                   name="phoneNum" onblur="checkPhoneNum();" >
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="phoneNumMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="contactEmailDiv">
                                        <label class="col-lg-2 control-label" for="test">Contact EmailID</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="emailID" 
                                                   name="emailID" onblur="checkContactEmail();" >
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="emailIDMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="fatherQualDiv">
                                        <label class="col-lg-2 control-label" for="test">Father's Qualification</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="fatherQualification" name="fatherQualification">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_QUAL_UPTO_TENTH; ?>">Upto 10th Standard</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_12TH; ?>">Completed 12th/PUC</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_DIPLOMA; ?>">Completed Diploma</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_BACHELORS; ?>">Bachelors Degree</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_MASTERS; ?>">Masters Degree</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_PHD; ?>">PhD</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="fatherQualificationMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="motherQualDiv">
                                        <label class="col-lg-2 control-label" for="test">Mother's Qualification</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="motherQualification" name="motherQualification">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_QUAL_UPTO_TENTH; ?>">Upto 10th Standard</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_12TH; ?>">Completed 12th/PUC</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_DIPLOMA; ?>">Completed Diploma</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_BACHELORS; ?>">Bachelors Degree</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_MASTERS; ?>">Masters Degree</option>
                                                <option value="<?php echo _ADMISSION_QUAL_COMPLETED_PHD; ?>">PhD</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="motherQualificationMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="motherTongueDiv">
                                        <label class="col-lg-2 control-label" for="test">Mother Tongue</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="motherTongue" name="motherTongue">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_LANG_HINDI; ?>">Hindi</option>
                                                <option value="<?php echo _ADMISSION_LANG_ENGLISH; ?>">English</option>
                                                <option value="<?php echo _ADMISSION_LANG_KANNADA; ?>">Kannada</option>
                                                <option value="<?php echo _ADMISSION_LANG_TELUGU; ?>">Telugu</option>
                                                <option value="<?php echo _ADMISSION_LANG_MALAYALAM; ?>">Malayalam</option>
                                                <option value="<?php echo _ADMISSION_LANG_TAMIL; ?>">Tamil</option>
                                                <option value="<?php echo _ADMISSION_LANG_MARATHI; ?>">Marathi</option>
                                                <option value="<?php echo _ADMISSION_LANG_GUJARATHI; ?>">Gujarathi</option>
                                                <option value="<?php echo _ADMISSION_LANG_BENGALI; ?>">Bengali</option>
                                                <option value="<?php echo _ADMISSION_LANG_ORIYA; ?>">Oriya</option>
                                                <option value="<?php echo _ADMISSION_LANG_URDU; ?>">Urdu</option>
                                                <option value="<?php echo _ADMISSION_LANG_PUNJABI; ?>">Punjabi</option>
                                                <option value="<?php echo _ADMISSION_LANG_ASSAMESE; ?>">Assamese</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="motherTongueMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="annualIncomeDiv">
                                        <label class="col-lg-2 control-label" for="test">Annual Income</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="annualIncome" name="annualIncome">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_ANNUAL_INC_UPTO_5; ?>">Upto Rs. 5 Lakhs per annum</option>
                                                <option value="<?php echo _ADMISSION_ANNUAL_INC_5_TO_10; ?>">Rs. 5 Lakhs to 10 Lakhs per annum</option>
                                                <option value="<?php echo _ADMISSION_ANNUAL_INC_10_TO_15; ?>">Rs. 10 Lakhs to 15 Lakhs per annum</option>
                                                <option value="<?php echo _ADMISSION_ANNUAL_INC_15_TO_25; ?>">Rs. 15 Lakhs to 25 Lakhs per annum</option>
                                                <option value="<?php echo _ADMISSION_ANNUAL_INC_25_PLUS; ?>">More than Rs. 25 Lakhs per annum</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="annualIncomeMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="forClassDiv">
                                        <label class="col-lg-2 control-label" for="test">Applying for Class</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" id="forClass" name="forClass">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME; ?>">Play Home</option>
                                                <option value="<?php echo _ADMISSION_APPLY_PRE_KG; ?>">Pre KG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_LKG; ?>">LKG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_UKG; ?>">UKG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_1; ?>">Class I</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_2; ?>">Class II</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_3; ?>">Class III</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_4; ?>">Class IV</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_5; ?>">Class V</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_6; ?>">Class VI</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_7; ?>">Class VII</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_8; ?>">Class VIII</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_9; ?>">Class IX</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_10; ?>">Class X</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_11; ?>">Class XI</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_12; ?>">Class XII</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="forClassMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="lastScoreDiv">
                                        <label class="col-lg-2 control-label" for="test">Last Received Marks</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="lastScore" name="lastScore" >
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="lastScoreMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group" id="previousSchoolDiv">
                                        <label class="col-lg-2 control-label" for="test">Previous School Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="previousSchool" name="previousSchool" >
                                        </div>
                                        <div class="col-lg-6">
                                            <p id="previousSchoolMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <br>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                             <input type="submit" class="btn btn-primary btn-block" 
                                                    id="submitApplication" name="submitApplication" value="SUBMIT" > 
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
                <div id="applicationStatusModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title"><strong>VIEW APPLICATION STATUS</strong></h4>
                            </div>
                            <form id="applicationViewForm" name="applicationViewForm" action="" 
                                  method="post" role="form" class="form-horizontal"> <!--onsubmit="return showApplicationStatus();"-->
                                <div class="modal-body">
                                    <div class="form-group" id="applicationStatusPhoneDiv">
                                        <label class="col-sm-4 control-label" for="test">Enter Phone Number</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="applicationStatusPhone" 
                                                   name="applicationStatusPhone" onblur="checkApplicationStatusPhone();">
                                            <p id="applicationStatusPhoneMessage" class="inputAlert">* This is a warning message</p>
                                        </div>
                                        <!--<div class="col-sm-4">
                                            <p id="applicationStatusPhoneMessage" class="inputAlert">* This is a warning message</p>
                                        </div>-->
                                    </div>
                                    <div class="form-group" id="applicationStatusBtnDiv">
                                        <br>
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-6">
                                             <input type="button" class="btn btn-primary btn-block" id="applicationStatusBtn"
                                                     name="applicationStatusBtn" value="VIEW STATUS" onclick="showApplicationStatus();"> 
                                        </div>
                                    </div>
                                    <div id="applicationStatusDetailsDiv" style="display:none;">
                                        <p id="enteredPhoneNum"></p>
                                        <table id="applicationStatusTable" name="applicationStatusTable" 
                                               class="table table-bordered table-striped">
                                        </table>
                                    </div>
                                </div>
                            </form>
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
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>