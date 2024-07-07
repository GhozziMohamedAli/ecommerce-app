<div class="hero_area">
  <!-- header section strats -->
  <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="/home">
          <img src="{{url('assets/images/logo.png')}}" alt="" /> 
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item {{$activePage == 'home' ? 'active' : ''}} ">
              <a class="nav-link" href="/home">Home </a>
            </li>
           
            <li class="nav-item {{$activePage == 'shop' ? 'active' : ''}}">
              <a class="nav-link" href="/shop">Shop </a>
            </li>
            
          </ul>
          <div class="user_option">
            
              <button type="button" onclick="checkout()"  id="add_to_cart" class="btn  d-none position-relative  mt-3 mr-3 mb-1">
                <span class=""><i class="material-icons" style="color:white;">shopping_cart</i></span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light d-none" id="cart_num">
                 0
                </span>
              </button>
              
            
            @if(!Auth::user())
            <a href="{{url('login')}}">
              <img src="{{url('assets/images/user.png')}}" alt="">
              <span>
                Login
              </span>
            </a>
            @endif
            <a href="/admin/dashboard">
              <span class=""><i class="material-icons">dashboard</i></span>
              <span>
                {{__('Dashboard')}}
              </span>
            </a>
            <a href="">
              <span class=""><i class="material-icons">account_circle</i></span>
              <span>
                {{__('Profile')}}
              </span>
            </a>
            
            <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
              <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
            </form>
          </div>
        </div>
        <div>
          <div class="custom_menu-btn ">
            <button>
              <span class=" s-1">

              </span>
              <span class="s-2">

              </span>
              <span class="s-3">

              </span>
            </button>
          </div>
        </div>

      </nav>
    </div>
  </header>
  <!-- end header section -->
  @if($subpage ==false)
      <!-- slider section -->
      <section class="slider_section ">
        <div class="play_btn">
          <a href="">
            <img src=" {{url('/assets/images/play.png')}}" alt="">
          </a>
        </div>
        <div class="number_box">
          <div>
            <ol class="carousel-indicators indicator-2">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">01</li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1">02</li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2">03</li>
              <li data-target="#carouselExampleIndicators" data-slide-to="3">04</li>
            </ol>
          </div>
        </div>
        <div class="container">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        The Latest
                        <span>
                          Furniture
                        </span>
                      </h1>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                        do eiusmod tempor incididunt ut labore
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn-1">
                          Read More
                        </a>
                        <a href="" class="btn-2">
                          Contact us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 img-container">
                    <div class="img-box">
                      <img src="{{url('/assets/images/slider-img.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item ">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        The Latest
                        <span>
                          Furniture
                        </span>
                      </h1>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                        do eiusmod tempor incididunt ut labore
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn-1">
                          Read More
                        </a>
                        <a href="" class="btn-2">
                          Contact us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 img-container">
                    <div class="img-box">
                      <img src="{{url('assets/images/slider-img.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item ">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        The Latest
                        <span>
                          Furniture
                        </span>
                      </h1>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                        do eiusmod tempor incididunt ut labore
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn-1">
                          Read More
                        </a>
                        <a href="" class="btn-2">
                          Contact us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 img-container">
                    <div class="img-box">
                      <img src="{{url('assets/images/slider-img.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item ">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-box">
                      <h1>
                        The Latest
                        <span>
                          Furniture
                        </span>
                      </h1>
                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                        do eiusmod tempor incididunt ut labore
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn-1">
                          Read More
                        </a>
                        <a href="" class="btn-2">
                          Contact us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 img-container">
                    <div class="img-box">
                      <img src="{{url('assets/images/slider-img.png')}}" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- end slider section -->
  @endif
</div>
