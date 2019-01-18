<head>
    <title>
        @hasSection('title')
            @yield('title') - Islamic Wall
        @else
           Islamic Wall
        @endif
    </title>
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{  asset('assets/img/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{  asset('assets/img/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{  asset('assets/img/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{  asset('assets/img/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{  asset('assets/img/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{  asset('assets/img/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{  asset('assets/img/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{  asset('assets/img/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{  asset('assets/img/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{  asset('assets/img/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{  asset('assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{  asset('assets/img/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{  asset('assets/img/favicons/favicon-16x16.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <script src="{{ asset('assets/js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets/js/respond.min.js') }}"></script>
    <![endif]-->
    <style>
    .navbar {
  overflow: hidden;
  margin-top: 9px;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.subnav {
  float: left;
  overflow: hidden;
}

.subnav .subnavbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  text-transform: uppercase;
}

.navbar a:hover, .subnav:hover .subnavbtn {
 
}

.subnav-content {
  display: none;
  position: absolute;
  left: 0;
  background-color: white;
  width: 100%;
  z-index: 9999;
}

.subnav-content a {
  float: left;
  color: black;
  text-decoration: none;
}

.subnav-content a:hover {
  background-color: #eee;
  color: black;
}

.subnav:hover .subnav-content {
  display: block;
  position:fixed;
  top: 17%;
  
}
.subnav-  a{
padding:5px 16px;
}
.subnav:hover .subnav- {
    top: 98%;
    position: absolute;
    background: white;
    width: 100%;
}
        header.ls .page_header.header-01,header.ls .page_header.header-01 input#modal-search-input{
            background: #f6f6f6;
        }
        header.ls .page_header.header-01 .searchform.search-form #modal-search-input,header.ls .page_header.header-01 .searchform.search-form button.search-form__button{
            border: 1px solid #cccccc;
        }
        header.ls .page_header.header-01 .searchform.search-form #modal-search-input{
            border-right: none;
        }
        header.ls .page_header.header-01 .searchform.search-form button.search-form__button{
            border-left: none;
            padding-right: 30px;
        }
    </style>
</head>