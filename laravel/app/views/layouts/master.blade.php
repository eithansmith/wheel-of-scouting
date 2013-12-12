<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
    <meta charset="UTF-8">
    <title>Wheel of Scouting - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
   	<meta name="author" content="" />
    @section('header-css')
    {{ HTML::style('assets/css/bootstrap.min.css') }}
	{{ HTML::style('assets/css/bootstrap-responsive.css') }}
	{{ HTML::style('assets/css/jquery/redmond/jquery-ui-1.8.21.custom.css') }}
	{{ HTML::style('assets/css/cus-icons.css') }}
	{{ HTML::style('assets/css/default.css') }}
    @show
    <style type="text/css">
		body 
		{

      	}
      	.sidebar-nav
      	{
        	padding: 9px 0;
      	}
    </style>
    @section('header-js')
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	{{ HTML::script('assets/js/jquery.js') }}
	{{ HTML::script('assets/js/jquery/jquery-ui-1.8.21.custom.min.js') }}
	{{ HTML::script('assets/js/jquery.js') }}
	{{ HTML::script('assets/js/noty/jquery.noty.js') }}
	{{ HTML::script('assets/js/noty/layouts/top.js') }}
	{{ HTML::script('assets/js/noty/layouts/bottom.js') }}
	{{ HTML::script('assets/js/noty/themes/default.js') }}
	@show
</head>
<body>
	<div id="wrapper">
		<input type="hidden" name="base_url" id="base_url" value="{{ URL::to('') }}">
    
    @section('header')
	<div class="center">
		<div id="wheel-logo-row" class="row-fluid">
	    	<div class="span12">
	    		<img id="wheel-logo" src="{{ URL::to('assets/img/wheel/wheel-logo.png') }}" alt="wheel">
	    	</div>
	  	</div>
	</div>		
	@show
    
    	@section('messages')
		    @if (Session::has('messageText'))
		        @include('messages/noty')
		    @endif
	    @show

	    <div class="container-fluid">
	    	<div class="row-fluid">
	    		<div class="span12">
	    			@yield('content')
	    		</div>
	    	</div>
	    </div>   
    
	@section('footer')
	@show
    
    @section('footer-js')
    {{ HTML::script('assets/js/bootstrap.min.js') }}
	{{ HTML::script('assets/js/jquery/jquery.ui.touch-punch.min.js') }}
	{{ HTML::script('assets/js/jquery.tinysort.js') }}
	{{ HTML::script('assets/js/default_v1.js') }}
	@show
</body>
</html>