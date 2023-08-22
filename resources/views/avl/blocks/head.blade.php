<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="IRsite - Панель управления">
  <meta name="author" content="IR.KZ">
  <meta name="keyword" content="">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>IRsite - Панель управления</title>

  <meta name="_token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link href="/avl/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="/avl/css/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

  <link href="/avl/js/tree/jquery.treeview.css" rel="stylesheet" type="text/css" />
  <!-- Main styles for this application -->
  <link href="/avl/css/style.css" rel="stylesheet">
  <!-- Styles required by this views -->

  @yield('css')

  <link href="/avl/cache/layout.css" rel="stylesheet">

  <script src="/avl/js/jquery.min.js"></script>

  <!-- Bootstrap and necessary plugins -->
    <script src="/avl/js/popper.min.js"></script>
    <script src="/avl/js/bootstrap.min.js"></script>
    <script src="/avl/js/pace.min.js"></script>
  <!-- CoreUI main scripts -->

  <script src="/avl/js/jquery.cookie.js"></script>
  <script src="/avl/js/tree/jquery.treeview.js"></script>
  <script src="/avl/js/app.js"></script>

    @yield('js')
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'			- Fixed Breadcrumb

// Footer options
1. '.footer-fixed'					- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden breadcrumb-fixed">

@include('avl.blocks.alerts')
