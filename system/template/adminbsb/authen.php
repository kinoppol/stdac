<?php
    $themeURL=site_url('system/template/'.$theme,true);
    $componentURL=$themeURL.'/src/';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php print $systemTitle; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php print $componentURL; ?>plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php print $componentURL; ?>plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php print $componentURL; ?>plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php print $componentURL; ?>css/style.css" rel="stylesheet">
</head>

<body class="login-page">
<?php print $content; ?>

    <!-- Jquery Core Js -->
    <script src="<?php print $componentURL; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php print $componentURL; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php print $componentURL; ?>plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php print $componentURL; ?>plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php print $componentURL; ?>js/admin.js"></script>
    <script src="<?php print $componentURL; ?>js/pages/examples/sign-in.js"></script>
</body>
<?php print $systemFoot; ?>
</html>