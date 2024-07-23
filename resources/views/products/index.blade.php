@extends('layouts.dashboard.app',['activePage' => 'products'])
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-primary border-radius-lg pt-4 pb-3 row">
              <h6 class=" col-8 text-white text-capitalize ps-3">{{__('Products table')}}</h6>
              <button  class=" col-2 btn btn-icon btn-3 btn-info" type="button" data-bs-toggle="modal" data-bs-target="#AddModal">
                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                <span class="btn-inner--text">{{__('Add Product')}}</span>
              </button>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <!--data list for search -->
              <div class="row mb-4">
                <div class="col-md-8">
                  <div class="input-group input-group-outline ">
                    <input class="form-control mx-5" list="datalistOptions" id="DataList" placeholder="Type name of product ..">
                    <datalist id="datalistOptions">
                      @foreach($products as $product)
                        <option value="{{$product->name}}">
                      @endforeach
                    </datalist>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <button type="button" class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#filter" aria-controls="offcanvasRight">
                    <span class=""><i class="material-icons  text-white ">filter_list</i></span>
                  </button>
                
                  <button type="button" class="btn btn-danger d-none" id="cancel_filter">
                    <span class=""><i class="material-icons ">close</i></span> 
                  </button>
                  
                </div>
              </div>
              
              <!-- End Datalist -->
              <table class="table align-items-center mb-0">
                <thead>
                  <div class="text-center d-none" id="dbshow">
                    <button onclick="listDelete()" class=" btn btn-outline-danger">{{__('Delete All')}}</button>                    
                  </div>
                  <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><input type="checkbox" name="" id="check_me"></th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Image')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Product Name')}}</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Category')}}</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Price')}}</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Quantity')}}</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('Actions')}}</th>
                  </tr>
                </thead>
                <tbody id="table">
                @if(count($products)==0)
                  <tr>
                    <td colspan="7" class="text-center  bg-gradient-secondary">
                      <h4 class="text-light">{{__('No Products Found')}}</h3>
                    </td>
                  </tr>
                @else
                @foreach($products as $product)
                <tr>
                <td class="text-center">
                  <input type="checkbox"  name="checkboxGroup" value="{{$product->id}}">
                </td>
                <td>
                  <img class="img-fluid" src="{{url('uploads/'.$product->path)}}" alt="..." style="width: 100px;">
                </td>
                    <td class="text-xs font-weight-bold mb-0">
                      {{$product->name}}
                    </td>

                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$product->category->name}}</p>
                    </td>

                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-success">$ {{$product->price}} </span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">{{$product->quantity}}</span>
                    </td>
                    <td class="text-center align-middle">
                      
                      <button class="btn btn-icon p-0" onclick="showProducts('/admin/products/',{{$product->id}})" data-bs-target="#ShowModal" data-bs-toggle="modal" role="button">
                        <span class="btn-inner--icon">
                          <i class="material-icons">visibility</i>
                         </span>
                        </button>
                        
                      <button onclick="edit_product('/admin/products/',{{$product->id}})" class="btn  p-0 text-info font-weight-bold text-xs" data-bs-target="#EditModal" data-bs-toggle="modal" role="button" >
                        <i class="material-icons">edit</i>
                      </button>
                      <button onclick="delete_record('/admin/products/',{{$product->id}})" class="btn btn-icon p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="material-icons">delete</i>
                      </button>
                    </td>
                    
                  
                  </tr>
                @endforeach
                @endif
                </tbody>
              </table>
              <div class="mx-5 my-2 d-flex flex-row">
                
                <button class="btn p-2 bd-highlight" id="prev">
                  <span class="btn-inner--icon"><i class="material-icons">skip_previous</i></span>
                </button>
                <select name="" id="pagination-dropdown" class=" text-center form-select w-5 mb-3 bd-highlight">
                  @for($i=0; $i<count($products)/5; $i++)
                    <option  value="{{$i+1}}">{{$i+1}}</option>
                  @endfor
                  <input type="hidden" id="max-numpage" value="{{$i}}">
                </select>
                <button class="btn p-2 bd-highlight" id="next">
                  <span class="btn-inner--icon"><i class="material-icons">skip_next</i></span>
                </button>
                <p class="fw-bold text-secondary p-2 bd-highlight">
                  {{__('Total products available :')}} {{count($products)}}
                </p>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer py-4  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>

<!--showModal -->
<div class="modal fade" id="ShowModal"   aria-labelledby="ShowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel2" >{{__('Product Details')}}</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <table class="table table-info table-bordered">
            <thead>
              <th>{{__('Name')}}</th>
              <th>{{__('Description')}}</th>
              <th>{{__('Category')}}</th>
            </thead>
            <tbody>
              <tr>

                <td id="show_prod_name"></td>
                <td id="show_prod_descr"></td>
                <td id="show_prod_category"></td>
              </tr>
              <tr>
                <th scope="row">{{__('Quantity')}}</th>
                <td id="show_prod_quantity"></td>
                <th scope="row">{{__('Price')}}</th>
                <td id="show_prod_price"></td>
              </tr>
            </tbody>
          </table>
        </div>
    

    
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- AddModal -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">{{__('Add Product')}}</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        @if($errors->all())
       
            @foreach($errors->all() as $err)
              <div class="alert alert-danger alert-dismissible text-white fade show" id="add_prod_err" role="alert">
                {{$err}}
              </div>
            @endforeach
      
        @endif
        <form action="{{url('/admin/products')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="form-label">{{__('Name')}}</label>
                <input type="text" name="name" class="form-control" required>
              </div>
            </div>


            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="form-label">{{__('Description')}}</label>
                <input type="text" name="description" class="form-control">
              </div>
            </div>

            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Select Image')}}</label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>

            <div class="col-md-12">
              <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1" class="ms-0">{{__('Select Category')}}</label>
                <select class="form-control" id="category_select" name="category">
                  @foreach($category as $cat)
                    <option value="{{$cat->name}}">{{$cat->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Price')}}</label>
                <input type="number" value="0" step="0.01" min="0" name="price" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Quantity')}}</label>
                <input type="number" value="0" min="0" name="quantity" class="form-control">
              </div>
            </div>
          </div>
        
      </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn bg-gradient-info">{{__('Save')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModal"   aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel2" >{{__('Edit Product')}}</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        
          <div class="alert alert-danger alert-dismissible text-white fade show" style="" id="update_prod_err" role="alert">
            
          </div>
          
      
          <input type="hidden" name="id" id="prod_id">

        <div class="row">

            <div class="col-md-12 text-center">
              <img src="" id="img_input" alt="" width="100px">
            </div>

            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Image')}}</label>
                
                <input type="file" id="edit_image" name="edit_image" class="form-control" required>
              </div>
            </div>
          
            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Name')}}</label>
                <input type="text" id="edit_name" name="edit_name" class="form-control" required>
              </div>
            </div>


            <div class="col-md-12">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Description')}}</label>
                <input type="text" id="edit_descr" name="edit_description" class="form-control">
              </div>
            </div>
          
            <div class="col-md-12">
              <div class="input-group input-group-static mb-4">
                <label for="exampleFormControlSelect1" class="ms-0">{{__('Select Category')}}</label>
                <select class="form-control"  id="edit_category_select" name="edit_category">
                  <option id="edit_category" value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Price')}}</label>
                <input type="number"  id="edit_price" step="0.01" min="0" name="edit_price" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Quantity')}}</label>
                <input type="number" id="edit_quantity"  min="0" name="edit_quantity" class="form-control">
              </div>
            </div>

        </div>

      <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            <button onclick="update_product('/admin/products/')"  type="submit" class="btn bg-gradient-info">{{__('Save')}}</button>
      </div>
    </div>
    </div>
  </div>
</div>

<!--Filter Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="filter" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">{{__('Products Filter')}}</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <div class="row ">
        <div class="col-6  ">
          <div class="input-group input-group-static my-3">
            <label for="minPrice" class="">{{__('Min Price')}}</label>
            <input type="number" min="0" class="form-control" id="minPrice">
          </div>
        </div>
        <div class="col-6 ">
          <div class="input-group input-group-static my-3">
            <label for="maxPrice" class="">{{__('Max Price')}}</label>
            <input type="number" min="0" class="form-control" id="maxPrice">
          </div>  
        </div>
      </div>
      <div class="col-md-12">
        <div class="input-group my-3">
          <label for="">{{__('Categories')}}</label>
          @foreach($category as $cat)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{$cat->id}}" name="category_cb" id="category_name">
            <label class="form-check-label" for="flexCheckDefault">
              {{$cat->name}}
            </label>
          </div>
          @endforeach
        </div>
      </div>
      
      
    
    <button type="submit" class="btn bg-gradient-info" id="filterbtn" >Filter</button>
  
    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
  </div>
</div>
<!--End Filter Modal-->
@endsection