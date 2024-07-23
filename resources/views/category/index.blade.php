@extends('layouts.dashboard.app',['activePage' => 'category'])
@section('content')

<div class="container-fluid py-4">

    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-primary border-radius-lg pt-4 pb-3 row">
              <h6 class=" col-8 text-white text-capitalize ps-3">{{__('Category table')}}</h6>
              <a class=" col-2 btn btn-icon btn-3 btn-info" type="button" data-bs-toggle="modal" href="#AddModal">
                <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                <span class="btn-inner--text">{{__('Add Category')}}</span>
              </a>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 "></th>
                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Category Name')}}</th>
                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('Status')}}</th>
                    <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{(__('Actions'))}}</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                  <tr>
                    <td></td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{$category->name}}</p>
                    
                    </td>
                    <td class="text-sm">
                      <span class="badge badge-sm bg-gradient-success">
                      @if($category->status == 1)  {{__('Working')}} @else {{__('not up')}} @endif
                      </span>
                    </td>
                    <td class="align-middle">
                      <button onclick="edit_category('/admin/category/',{{$category->id}})" class="btn  p-0 text-info font-weight-bold text-xs" data-bs-target="#EditModal" data-bs-toggle="modal" role="button" >
                        <i class="material-icons">edit</i>
                      </button>
                      <button onclick="category_has_products({{$category->id}})" class="btn  p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="material-icons">delete</i>
                      </button>
                  
                    </td>
                    
                  
                  </tr>
                @endforeach
                </tbody>
              </table>
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

<!-- Add Modal -->
<div class="modal fade" id="AddModal"  aria-labelledby="AddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">{{__('Add Category')}}</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('/admin/category')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="form-label">{{__('Name')}}</label>
                <input type="text" name="name" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault" value="1" checked="">
                <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
              </div>
            </div>
        
          </div>
      </div>

        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn bg-gradient-info">{{__('Save')}}</button>
        </form>
        </div>
      
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModal"   aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="exampleModalLabel2" >{{__('Edit Category')}}</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div  id="update_cat_err" class="alert alert-danger alert-dismissible text-white fade show" style="display:none;" role="alert">
            
          </div>
          <input type="hidden" name="id" id="cat_id">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="input-group input-group-static my-3">
                <label class="">{{__('Name')}}</label>
                <input type="text" id="edit_name" name="name" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="edit_status" name="status" id="flexSwitchCheckDefault" value="1" checked="">
                <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
              </div>
            </div>
        
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
          <button onclick="update_category('/admin/category/')" type="button" class="btn bg-gradient-info">{{__('Save')}}</button>
      </div>
   
    </div>
  </div>
</div>



@endsection
