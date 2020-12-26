<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
        <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_PS_FAVICON_FILE_NAME; ?>">
    <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
</head>
<body>
    
    <div class="row" style="background:#FFE082;padding:10px;">
        <div class="col-sm-8 col-sm-offset-2" style="text-align: center;">
            <img src="/public/images/<?php echo _IMAGE_PS_DEFAULT_IMAGE; ?>" alt="Paathshaala" 
                 style="max-height: 200px;max-width: 500px;" align="middle" >
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12"> <!-- col-sm-8 col-sm-offset-2 -->
            <nav class="navbar navbar-inverse navbar-static-top" style="margin-bottom:0px;"> <!-- navbar-default-->
                <div class="container-fluid">
                    <div class="navbar-header">
                        <!--<p style="color:white;">Menu</p>-->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#psHomeMenu"> 
                          <span class = "sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span> 
                          <span class="icon-bar"></span> 
                        </button>
                    </div>
                    <div id="psHomeMenu" name="psHomeMenu" class="collapse navbar-collapse" >
                        <ul class="nav navbar-nav">
                            <li id="menuHomeOption" class="navbar-btn" style="margin:0px;">
                                <a href="/" id="menuHome" ><strong>Home</strong></a>
                            </li>
                            <li id="menuOtherOption" class="navbar-btn" style="margin:0px;">
                                <a href="/" id="menuOther" ><strong>Other</strong></a>
                            </li>
                            <li id="menuContactOption" class="navbar-btn" style="margin:0px;">
                                <a href="/" id="menuContact" ><strong>Contact</strong></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2" style="background:#DCEDC8;height:400px;">
        </div>
    </div>
    <!-- <div class="page-header container-fluid home_background" style="padding:0px;margin:0px;background:#FFE082;">
        <div id="schoolLogoImage" name="schoolLogoImage" class="col-sm-1">
            
        </div>
        <div id="schoolLogo1" name="schoolLogo1" class="col-sm-5" style="margin-left:auto;margin-right:auto;">
            <h3 style="text-align:left;color:white;">Vidya Vardhaka Sangha High School<br><small>Sa Vidya Ya Vimuktaye</small></h3>
        </div>
    </div> -->
</body>
</html>
