<div class="page-header container-fluid home_background" style="padding:0px;margin:0px;">   
        <div class="col-sm-2"></div>
        <div id="schoolLogoImage" name="schoolLogoImage" class="col-sm-1">
            <img src="<?php echo "public/images/" . _IMAGE_SCHOOL_LOGO_FILE_NAME; ?>" 
                    class="img-rounded" alt="VVSHS" style="max-height: 80px;max-width: 80px;" align="right" >
        </div>
        <div id="schoolLogo1" name="schoolLogo1" class="col-sm-5" style="margin-left:auto;margin-right:auto;">
            <h3 style="text-align:left;color:white;">Total Schooling<br><small>Complete Schooling Solution</small></h3>
        </div>
        <!-- Vidya Vardhaka Sangha High School :: Sa Vidya Ya Vimuktaye -->
        <div id="loginSection1" name="loginSection1" class="col-sm-4">
            <?php if( isset($headerData) && array_key_exists('logged_in', $headerData) 
                    && $headerData['logged_in'] == true ){ ?>
            <form id="logoutForm" name="logoutForm" method="post" action="/logout" >
                <table id="loggedInTable" name="loggedInTable" style="width:100%;">
                    <colgroup>
                        <col style="width:50%;">
                        <col style="width:50%;">
                    </colgroup>
                    <tr>
                        <td></td>
                        <td style="text-align: center;color:white;"><strong>Welcome <?php if( isset($headerData) && array_key_exists('username', $headerData) ) 
                                echo $headerData['username']; ?>!!! </strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">
                            <button id="logoutSubmitBtn" name="logoutSubmitBtn" type="submit" 
                                   class="btn btn-warning btn-sm" style="margin-left:5px;">
                                <span class="glyphicon glyphicon-log-out"></span><strong>&nbsp;&nbsp;Log Out</strong>
                            </button>
                            <a href="/showProfile">
                                <span id="profile" class="glyphicon glyphicon-user profile_icon"
                                    data-toggle="tooltip" data-placement="bottom" title="My Profile">
                                </span>
                            </a>
                            <!-- <input id="logoutSubmitBtn" name="logoutSubmitBtn" type="submit" style="margin:5px;"
                                   class="btn btn-warning btn-sm" value="Log Out"  ></td> -->
                    </tr>
                </table>
            </form>
            <?php } else { ?>
            <form id="loginForm" name="loginForm" method="post" action="/login" >
                <table id="loginTable" name="loginTable">
                    <tr>
                        <td style="color:white;"><strong>Username</strong></td>
                        <td style="color:white;"><strong>Password</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="text" id="username" name="username" class="input-sm" style="margin-right:5px;"
                                   value="<?php if( isset($headerData) && array_key_exists('username', $headerData) ) 
                                    echo trim($headerData['username']);  ?>"> </td>
                        <td><input type="password" id="password" name="password" class="input-sm"  value=""></td>
                        <td>
                            <button id="loginSubmitBtn" name="loginSubmitBtn" type="submit" 
                                   class="btn btn-success btn-sm" style="margin-left:5px;">
                                <span class="glyphicon glyphicon-log-in"></span><strong>&nbsp;&nbsp;Log In</strong>
                            </button>
                            <!--<input id="loginSubmitBtn" name="loginSubmitBtn" type="submit" 
                                   class="btn btn-success btn-sm" style="margin-left:5px;" value="Log In"  ></td><!-- glyphicon glyphicon-log-in -->
                    </tr>
                    <tr>
                        <td>
                            <input id="forgotUsername" name="forgotUsername" type="button" style="float:left;"
                                   class="btn btn-link btn-sm" style="margin-left:0px;" value="Forgot Username?" onclick="showForgotUsername();" >
                        </td>
                        <td>
                            <input id="forgotPassword" name="forgotPassword" type="button" style="float:left;"
                                   class="btn btn-link btn-sm" style="margin-left:0px;" value="Forgot Password?" onclick="showForgotPassword();" >                           
                        </td>
                    </tr>
                <?php if( isset($headerData) && 
                            (( array_key_exists('invalid_username', $headerData) && $headerData['invalid_username'] == true ) || 
                               ( array_key_exists('incorrect_password', $headerData) && $headerData['incorrect_password'] == true ))) { ?>
                    <tr>
                        <td colspan="2">
                            <p style="color:red;">
                               <?php 
                                    if( isset($headerData) && array_key_exists('invalid_username', $headerData) && 
                                            $headerData['invalid_username'] == true ) { 
                                        echo "* Invalid Username";
                                    } else {
                                        echo "* Incorrect Password";
                                    }
                                ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            </form>
            <?php } ?>
        </div>
</div>
