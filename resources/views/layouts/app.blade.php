<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Digitf</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap.css') }}" />
 <!--     Fonts and icons     -->
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" />
  <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
  <script type="text/javascript" src="{{ url('assets/js/jquery-3.4.1.min.js') }}"></script>
  
</head>
<body class="{{$subpage == true ? 'sub_page' : ''}}">
 
    @include('layouts.header')
    @yield('content')
    
    <script type="text/javascript" src="{{ url('assets/js/bootstrap.js') }}"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
   
   </script>
    <script type="text/javascript">
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [],
        autoplay: true,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1
          },
          420: {
            items: 2
          },
          1000: {
            items: 5
          }
        }
  
      });
    </script>
    <script>
      var nav = $("#navbarSupportedContent");
      var btn = $(".custom_menu-btn");
      
      btn.click(function (e) {
  
        e.preventDefault();
        nav.toggleClass("lg_nav-toggle");
        document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style")
      });
      btn.click();
    </script>
    <script>
      $('.carousel').on('slid.bs.carousel', function () {
        $(".indicator-2 li").removeClass("active");
        indicators = $(".carousel-indicators li.active").data("slide-to");
        a = $(".indicator-2").find("[data-slide-to='" + indicators + "']").addClass("active");
       
  
      })
    </script>
    <script src="{{url('assets/js/custom_sh.js')}}"></script>
    
</body>
</html>