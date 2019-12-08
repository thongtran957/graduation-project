<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resume Parser</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('/templates/dist/css/adminx.css') }}" media="screen"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .multiselect {
            width: 200px;
        }

        .selectBox {
            position: relative;
        }

        .selectBox select {
            width: 100%;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        #checkboxes {
            display: none;
            border: 1px #dadada solid;
        }

        #checkboxes label {
            display: block;
        }

        #checkboxes label:hover {
            background-color: #1e90ff;
        }
    </style>
</head>
<body>
<div class="adminx-container">
    <nav class="navbar navbar-expand justify-content-between fixed-top">
        <a class="navbar-brand mb-0 h1 d-none d-md-block" href="{{ url('/') }}">
            <img src="{{asset('templates//demo/img/logo.png')}}"
                 class="navbar-brand-image d-inline-block align-top mr-2" alt="">
            Resume Parser
        </a>
        <div class="d-flex flex-1 d-block d-md-none">
            <a href="#" class="sidebar-toggle ml-3">
                <i data-feather="menu"></i>
            </a>
        </div>
        <ul class="navbar-nav d-flex justify-content-end mr-2">
            <li class="nav-item dropdown">
                <a class="nav-link avatar-with-name" id="navbarDropdownMenuLink" data-toggle="dropdown" href="#">
                    <img src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg"
                         class="d-inline-block align-top" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-danger" href="#">Sign out</a>
                </div>
            </li>
        </ul>
    </nav>
