<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="author" content="Aniruddha Sinha">
    <title>@yield('pageTitle')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('public/admin_v2/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="{{asset('public/admin_v2/css/metisMenu.min.css')}}" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="{{asset('public/admin_v2/css/timeline.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('public/admin_v2/css/startmin.css')}}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{asset('public/admin_v2/css/morris.css')}}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{asset('public/admin_v2/css/font-awesome.min.cs')}}s" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="{{asset('public/admin_v2/css/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="{{asset('public/admin_v2/css/dataTables/dataTables.responsive.css')}}" rel="stylesheet">
    <!-- toastr notification CSS -->
    <link href="{{asset('public/admin_v2/css/toastr.min.css')}}" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="{{asset('public/admin_v2/css/select2.min.css')}}" rel="stylesheet"> 
    <!-- Ajax java script -->
    <script src="{{asset('public/admin_v2/js/jquery_ajax.js')}}"></script> 

    <style type="text/css">
        .pro-list {
        margin: 0 0 15px;
    }
    .pro-list input[type="text"], .pro-list select {
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 20px;
        width: 77%;
        margin: 0 10px 10px 0;
    }
    .pro-list input[type="submit"] {
        background: #00a65a;
        border: none;
        color: #fff;
        padding: 11px;
        width: 220px;
        font-size: 20px;
        text-transform: uppercase;
    }
    </style>
    
    </head>
<body>
<div id="wrapper">