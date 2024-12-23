<!DOCTYPE html>
<html lang="en">

<head>

<?php
$settings = $this->db->get('settings')->row_array();
?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Absensi SMK Karya Nasional">
	<meta name="author" content="">

	<link defer rel="icon" type="image/x-icon" href="<?= base_url($settings['logo']) ?>">

	<title><?= $title; ?></title>


	<!-- Bootstrap CSS -->
	<!-- BOOTSTRAP 4-->
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">-->
	<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"></noscript>
	
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
	
	<!--<link rel="preload" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
	<!--<noscript><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></noscript>-->
	
	<!-- <link defer href="< ?= base_url('assets/vendor/fontawesome-free/css/fontawesome.min.css') ?>" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
	<!-- DATATABLES BS 4-->
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" /> -->
	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" /> -->
	<!-- DATATABLES BS 4 LOCAL-->
	<!--<link rel="stylesheet" href="< ?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>"/>-->
	<link rel="preload" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
	<noscript><link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"></noscript>
	
	<!--<link rel="stylesheet" href="< ?= base_url('assets/vendor/datatables/responsive.bootstrap4.min.css'); ?>"/>-->
	<link rel="preload" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
	<noscript><link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css"></noscript>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css"/>
	
	<!-- jQuery -->
	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> -->
	<!--<script type="text/javascript" src="< ?= base_url('assets/vendor/jquery/jquery.js') ?>" defer></script>-->
	<!--<script src="< ?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>-->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js" defer></script>-->
	<!--<script src="< ?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" async></script>-->
	
	
	<!--<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>-->
	

	<!-- Custom fonts for this template-->
	<!--<link rel="preload" href="< ?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
	<!--<noscript><link rel="stylesheet" href="< ?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css"></noscript>-->
	
	<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"></noscript>
	
	<!--<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" type="text/css" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
	<!--<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"></noscript>-->
	
	<link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" crossorigin as="style" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap"></noscript>
	
	<!--<link rel="preload" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/fonts/fontawesome-webfont.woff2?v=4.3.0" as="font" type="font/woff2" onload="this.onload=null;this.rel='stylesheet'" crossorigin>-->
	<!--<noscript><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/fonts/fontawesome-webfont.woff2?v=4.3.0"></noscript>-->
	
	<!-- <script src="< ?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> -->
	<!-- Custom styles for this template-->
	<link rel="preload" href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css"></noscript>
	
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/styles.css">

	<!-- FAB -->
	<link rel="preload" href="<?= base_url('assets/'); ?>css/kc.fab.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="<?= base_url('assets/'); ?>css/kc.fab.css"></noscript>
	
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.js"></script>-->
	
	<!-- Font Awesome -->
	<!--<link rel="preload" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">-->
	<!--<noscript><link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"></noscript>-->
	
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>-->
	<!--<script src="< ?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>" async></script>-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous" async></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script> -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">


		<style type="text/css">
			.table thead th {
				vertical-align: middle !important;
			}

			th {
				white-space: nowrap;
			}
		</style>