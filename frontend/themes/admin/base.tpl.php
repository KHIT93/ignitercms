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
  <body class="no-skin">
    <?php
        print $page_top;
        print $page;
        print $page_bottom;
        print $scripts;
    ?>
  </body>
</html>