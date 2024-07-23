@extends('layouts.app',['subpage'=>true ,'activePage' => "shop"]) 
@section('content')
  <!-- brand section -->

  <section class="brand_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          {{__('Our Products')}}
        </h2>
      </div>
      <div class="row">
        <div class="col-xs-12 col-2 border bg-gradient bg-success mt-5 shadow text-white">
          <h2> 
            Filter
          </h2>
  
          <label for="minPrice" class="form-label">{{__('Min Price')}}</label>
          <input type="number" min="0" class="form-control" id="minPriceShop">

          <label for="maxPrice" class="form-label">{{__('Max Price')}}</label>
          <input type="number" min="0" class="form-control" id="maxPriceShop">  
           
          <div class="my-3">
            <label class="form-label">{{__('Categories')}}</label>
            @foreach($category as $cat)
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="{{$cat->id}}" name="category_cb" id="category_name">
              <label class="form-check-label t-name" for="flexCheckDefault">
                {{$cat->name}}
              </label>
            </div>
            @endforeach
          </div>
          <button type="submit" onclick="shop_filter()" class="btn btn-info bg-gradient-info" id="filterbtn" >Filter</button>
          <button type="button" class="btn btn-danger d-none" id="cancel_filter_shop">
            {{__('cancel')}}
          </button>
        </div>

        <div class="col-10 col-xs-8">
          <div class="brand_container layout_padding2"  id="card">
            @foreach ($products as $product)
            
            <div class="card card-shop m-2" name="card" style="width: 13rem;">
              <input type="hidden" id="cart_prod_id" value="{{$product->id}}">
              <img src="{{url('uploads/'.$product->path)}}" alt="" width="100%">
              <div class="card-body">
                <h5 class="card-title">{{$product->name}}</h5>
                <p class="card-text">{{$product->description}}</p>
                <p class="card-text"><span class="text-success">{{$product->price}}</span> <span style="font-size:11px">$</span></p>
                
              </div>
              
                <div class="card-footer bg-success ">
                  <button class="btn text-white ">
                    <i class="material-icons green600 md-18">add_shopping_cart</i>
                    <span style="position:relative;bottom:4px;">
                      {{__('Add to cart')}}
                    </span>
                  </button>  
   
                </div>
              
              
            </div>
            @endforeach 
          </div>
          <div class="mx-5 my-2 d-flex flex-row justify-content-center">
                
            <button class="btn p-2 bd-highlight" id="prev">
              <span class="btn-inner--icon"><i class="material-icons">skip_previous</i></span>
            </button>
            <select name="" id="pagination-dropdown" class="custom-select w-auto mb-3">
              @for($i=0; $i<count($products)/9; $i++)
                <option  value="{{$i+1}}">{{$i+1}}</option>
              @endfor
              <input type="hidden" id="max-numpage" value="{{$i}}">
            </select>
            <button class="btn p-2 bd-highlight" id="next">
              <span class="btn-inner--icon"><i class="material-icons">skip_next</i></span>
            </button>
            
          </div>
        </div>

       
      </div> 
       
        

      </div>
      <a href="" class="brand-btn">
        See More
      </a>
    </div>
  </section>

  <!-- end brand section -->
@endsection