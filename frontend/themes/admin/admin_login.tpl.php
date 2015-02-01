<!DOCTYPE html>
<html lang="en">
  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
    <?php print $styles; ?>
    <!--[if lte IE 9]>
            <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <![endif]-->

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->
  </head>
  <body class="login-layout">
      <div class="main-container">
          <div class="main-content">
              <div class="row">
                  <div class="col-sm-10 col-sm-offset-1">
                      <div class="login-container">
                          <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">Igniter</span>
                                    <span class="white" id="id-text2">CMS</span>
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; Company Name</h4>
                          </div>
                          
                          <div class="space-6"></div>
                          
                          <div class="position-relative">
                              <div id="login-box" class="login-box visible widget-box no-border">
                                  <div class="widget-body">
                                      <div class="widget-main">
                                          <h4 class="header blue lighter bigger">
                                              <i class="ace-icon fa fa-lock green"></i>
                                              Please Enter Your Information
                                          </h4>
                                          <div class="space-6"></div>
                                          <?php print $login_form; ?>
                                      </div>
                                      <div class="toolbar clearfix">
                                          <div>
                                              <?php print $go_home; ?>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <?php
        print $scripts;
    ?>
  </body>
</html>