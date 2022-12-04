<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aorbistest<?php echo empty($title) ? "":" - ".$title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Aorbistest</a>
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="#">Home</a></li>
      <li><a href="<?php echo base_url()."index.php/category/list"?>">Category</a></li>
      <li><a href="<?php echo base_url()."index.php/product/list"?>">Product</a></li>
    </ul>
  </div>
</nav>
  
