<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Sep 2019 10:03:06 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="<?php echo htmlspecialchars($baseHref ?? '', ENT_QUOTES, 'UTF-8'); ?>">

    <title>Ecommerce</title>
  
    <link href="assets/css/mainCSS/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/mainCSS/font-awesome.css" rel="stylesheet">
    <link href="assets/css/mainCSS/custom.css" rel="stylesheet">
    <link href="assets/css/mainCSS/animate.css" rel="stylesheet">
    <link href="assets/css/mainCSS/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="assets/css/mainCSS/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <?php if(($dataTable ?? false) == true): ?>
        <link rel="stylesheet" href="assets/css/dataTable/datatables.min.css">
        <?php endif; ?>

        <?php if(($fileUpload ?? false) == true): ?>
        <link rel="stylesheet" href="assets/css/fileUpload/codemirror.css">
        <link rel="stylesheet" href="assets/css/fileUpload/basic.css">
        <link rel="stylesheet" href="assets/css/fileUpload/dropzone.css">
        <link rel="stylesheet" href="assets/css/fileUpload/jasny-bootstrap.min.css">
        <?php endif; ?>

   

</head>

<body>

    <div id="wrapper">