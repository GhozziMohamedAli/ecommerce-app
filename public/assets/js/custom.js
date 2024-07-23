document.addEventListener('DOMContentLoaded', (event) => {
    // Initialize your app here
       
        minField=document.getElementById("minPrice");
        maxField=document.getElementById("maxPrice");

        cancel_filter = document.getElementById("cancel_filter");
        cancel_filter.addEventListener("click", (event) => {
           
            $('#cancel_filter').addClass("d-none");
            window.location.reload();
        });
        maxField.addEventListener("change", (event) => {
            max = parseInt(maxField.value, 10);
            min = parseInt(minField.value, 10);
            if(max < min){
               
                minField.value = maxField.value;
            }
        });
        minField.addEventListener("change", (event) => {
            max = parseInt(maxField.value, 10);
            min = parseInt(minField.value, 10);
            if(min > max){
                minField.value =0;
            }
        });
        filtersumbit=document.getElementById("filterbtn");
        filtersumbit.addEventListener("click",function(){
            minPrice=document.getElementById("minPrice").value;
            maxPrice=document.getElementById("maxPrice").value;
            const category_cb = document.getElementsByName("category_cb");
            const values = [];
            for(i=0;i<category_cb.length;i++){
                if(category_cb[i].checked){
                    values.push(category_cb[i].value);
                }
            }
            
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'/products/filter',
                type:'POST',
                data:{
                    values:values,
                    minPrice:minPrice,
                    maxPrice:maxPrice

                },
                success:function(response){
                    if(response.success){
                        $('#cancel_filter').removeClass("d-none");
                        console.log(response.data);
                        $('#table').empty();
                        response.data.forEach(function(product){
                            $('#table').append(
                            `<tr>
                                <td class="text-center">
                                <input type="checkbox"  name="checkboxGroup" value="`+product.id+`">
                                </td>
                                <td>
                                <img class="img-fluid" src="uploads/`+product.path+`" alt="..." style="width: 100px;">
                                </td>
                                <td class="text-xs font-weight-bold mb-0">
                                `+product.name+`
                                </td>
            
                                <td>
                                <p class="text-xs font-weight-bold mb-0">`+product.category_name+`</p>
                                </td>
            
                                <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-success">`+product.price+` </span>
                                </td>
                                <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">`+product.quantity+`</span>
                                </td>
                                <td class="text-center align-middle">
                                
                                <button class="btn btn-icon p-0" onclick="showProducts('/admin/products/',`+product.id+`)" data-bs-target="#ShowModal" data-bs-toggle="modal" role="button">
                                    <span class="btn-inner--icon">
                                    <i class="material-icons">visibility</i>
                                    </span>
                                    </button>
                                    
                                <button onclick="edit_product('/admin/products/',`+product.id+`)" class="btn  p-0 text-info font-weight-bold text-xs" data-bs-target="#EditModal" data-bs-toggle="modal" role="button" >
                                    <i class="material-icons">edit</i>
                                </button>
                                <button onclick="delete_record('/admin/products/',`+product.id+`)" class="btn  p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                    <i class="material-icons">delete</i>
                                </button>
                                </td>
                                
                            
                            </tr>`
                            )
                        })
                    }
                  
                }
            })
        });
        const datalist = document.getElementById("DataList");
        rows = document.getElementById('table').getElementsByTagName('tr');
        
        datalist.addEventListener("change", function(){
            
            if(datalist.textLength === 0 ){
                showPage(1);
                
            }else{
                for(var i=0; i<rows.length; i++){
                    
                    if(rows[i].getElementsByTagName('td')[2].innerText.trim().includes(datalist.value)){
                        rows[i].style.display = "";
                    }else{
                        
                        rows[i].style.display = 'none';
                    }
                }
            }
           
            
        });
        if(document.getElementById("add_prod_err")){
            $('#AddModal').modal('show');
        }
        check = document.getElementById("check_me");
        const checkboxes = document.getElementsByName("checkboxGroup");
        let count = 0;
        check.addEventListener("change",function(){
            if(this.checked){
                checkboxes.forEach((cb) => cb.checked = true);
                $('#dbshow').removeClass('d-none');
            }else{
                $('#dbshow').addClass('d-none');
                checkboxes.forEach((cb) => cb.checked = false);
            }
        });

        checkboxes.forEach((checkbox) => {
            if(this.checked){
                count++;
            }
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    count++;                    
                } else{
                    if(count !=0){
                        count--;
                    }
                }
                if(count>=2){
                    $('#dbshow').removeClass('d-none');
                }else{
                    $('#dbshow').addClass('d-none');
                }
            });
        });

        showPage(1);
        const paginationDropdown = document.getElementById('pagination-dropdown');
        const next = document.getElementById('next');
        const prev = document.getElementById('prev');
        
        paginationDropdown.addEventListener('change', function() {
            const selectedPage = parseInt(paginationDropdown.value, 10);
            showPage(selectedPage);
        });
        max_numpage=document.getElementById('max-numpage').value;
        next.addEventListener('click', function() {
            current=parseInt(paginationDropdown.value, 10);
            if(current+1 <= max_numpage) {
                showPage(current+1);
            } 

        });
        prev.addEventListener('click', function() {
            current=parseInt(paginationDropdown.value, 10);
            if(current != 1) {

                showPage(current-1);
            }
        });
    
        prod_img = document.getElementById('edit_image');
        img_input = document.getElementById('img_input');
        prod_img.addEventListener('change', function() {
        const file = this.files;
        if(file){
            img_input.src =  URL.createObjectURL(file[0]);
        }
    });
        
});
function showPage(pagenum){
    list_table = document.getElementById('table');
    rows = document.getElementById('table').getElementsByTagName('tr');
    rows_per_page = 5;
    current_page = 1;
    const paginationDropdown = document.getElementById('pagination-dropdown');
    
    paginationDropdown.value=pagenum;

    for(var i=0; i<rows.length; i++){
        rows[i].style.display ="none";
    }
    start = (pagenum - 1) * rows_per_page;
    end = start + rows_per_page;
    for (var i=start; i<end; i++){
        rows[i].style.display ="";
    }
  
}



function listDelete(){
    swal.fire({
        title:"Do you want to delete this Products?",
        icon:'question',
        iconColor:"#F44335",
        background:"#FFFFFF",
        color: "#F44335",
        confirmButtonColor:"#FFFFFF",
        cancelButtonColor:"#FFFFFF",
        showCancelButton:true,
        confirmButtonText:'Delete',
        showLoaderOnConfirm:true,}).then((proceed =>{
            if(proceed.isConfirmed){
                const checkboxes = document.getElementsByName("checkboxGroup");
                const values = [];
                for(i=0;i<checkboxes.length;i++){
                    if(checkboxes[i].checked){
                        values.push(checkboxes[i].value);
                    }
                }
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:'/products/listDelete',
                    type:'POST',
                    data:{values:values},
                    success:function(response){
                        if(response.success){
                            
                            swal.fire({
                                icon:"success",
                                title: "Success!",
                                text:  response.msg,
                                type: "success",
                                timer: 1000,
                                showConfirmButton: false
                            });
                            window.setTimeout(function(){location.reload(); } ,1000);
                        }
                    }

                });
            }
        }));
    
}
function category_has_products(id){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/category/category_has_products/'+id,
        type:'GET',
        success:function(response){
            if(response.success){
                swal.fire({
                    icon:"question",
                    title: "Do you want to proceed ?",
                    text:response.msg,
                    iconColor:"#FFFFFF",
                    background:"#F44335",
                    color: "#FFFFFF",
                    confirmButtonColor:"#FFFFFF",
                    cancelButtonColor:"#FFFFFF",
                    showCancelButton:true,
                    confirmButtonText:'Delete',
                    showLoaderOnConfirm:true,
                }).then((result) => {
                    if(result.isConfirmed){
                        console.log("hello");
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url:'/admin/category/'+id,
                            type:'DELETE',
                            success:function(response){
                                if(response.success){
                                    
                                
                                        swal.fire({
                                            icon:"success",
                                            title: "Success!",
                                            
                                            text:  response.msg,
                                            type: "success",
                                            timer: 1000,
                                            showConfirmButton: false
                                        });
                                        window.setTimeout(function(){location.reload(); } ,1000);
                                
                                
                                }
                            },
                        });
                    }
                });
            }else{
                delete_record('/admin/category/',id);
            }
        }
    });
}
function edit_category(url,id){
    $('#update_cat_err').html("");
    $('#update_cat_err').hide();
    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:url+id,
        type:'GET',
        success:function(result){
            
            $('#cat_id').attr("value", result.data.id) ;
            $('#edit_name').val(result.data.name) ;
            
            if(result.data.status == 1)
                $('#edit_status').attr('checked', true);
            else
                $('#edit_status').attr('checked', false);
        }, error: function(error) {
            console.log('error in show');
        }
    });
}

function update_category(url){
    id = document.getElementById('cat_id').value;
    console.log(id);
    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:url+id,
        type:'PUT',
        data:{
            name:$('#edit_name').val(),
            status:$('#edit_status').is(':checked')? 1 : 0
        },
        success:function(result){
            
            if(result.success){
                    swal.fire({
                        icon:"success",
                        title: "Success!",
                        
                        text:  result.msg,
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    window.setTimeout(function(){location.reload(); } ,1000);
            }else{
                $('#update_cat_err').append(`<span class="alert-icon align-middle">
                    <span class="material-icons text-md">
                    report
                    </span>
                  </span>
                  <span class="alert-text" id="err_txt">`+result.error+`</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>`);
                $('#update_cat_err').show();
            }
        }, error: function(error) {
            console.log('error in update category: '+error.message);
        }
    });
}
function delete_record(url,id){
    swal.fire({
        title:"Do you want to delete this record?",
        icon:'question',
        iconColor:"#FFFFFF",
        background:"#F44335",
        color: "#FFFFFF",
        confirmButtonColor:"#FFFFFF",
        cancelButtonColor:"#FFFFFF",
        showCancelButton:true,
        confirmButtonText:'Delete',
        showLoaderOnConfirm:true,
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: url+id,
                type:'delete',
                success:function(response){
                    if(response.success){
                        
                    
                            swal.fire({
                                icon:"success",
                                title: "Success!",
                                
                                text:  response.msg,
                                type: "success",
                                timer: 1000,
                                showConfirmButton: false
                            });
                            window.setTimeout(function(){location.reload(); } ,1000);
                    
                    
                    }
                },
                error: function(error) {
                    swal("Error!", "An error occurred while deleting the record.", "error");
                }
            });
        }
    });
}

function load_categories(){
    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/loadCategories',
        type:'GET',
        success:function(result){
            
           $.each(result.data,function(index,category){
            optionText = category.name;
            optionValue = category.name;
            let optionHTML = `
            <option value="${optionValue}"> 
                ${optionText} 
            </option>`;
            $('#category_select').append(optionHTML);
                
           });
        }, error: function(error) {
            console.log('error in load categories');
        }
    });
}
//Products Functions
haslooped = false;
function showProducts(url,id){
    $('#show_prod_name').html('');
    $('#show_prod_descr').html('');
    $('#show_prod_category').html('');
    $('#show_prod_quantity').html('');
    $('#show_prod_price').html('');
    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:url+id,
        type:'GET',
        success:function(result){
            console.log(result.data);
            $('#show_prod_name').append(result.data.name);
            $('#show_prod_descr').append(result.data.description);
            $('#show_prod_category').append(result.data.category_name);
            $('#show_prod_quantity').append(result.data.quantity);
            $('#show_prod_price').append(result.data.price);
        },error:function(error){
            console.log(error.message);
        }
    });
}
function edit_product(url,id){
    $('#update_prod_err').html("");
    $('#update_prod_err').hide();
    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:url+id+'/edit',
        type:'GET',
        success:function(result){
            console.log(window.location.host);
            $('#img_input').attr("src","/uploads/"+result.data.path);
            $('#prod_id').attr("value", result.data.id) ;
            $('#edit_name').val(result.data.name) ;
            $('#edit_descr').val(result.data.description) ;
            $('#edit_price').val(result.data.price) ;
            $('#edit_quantity').val(result.data.quantity) ;
            $('#edit_category').val(result.data.category_name) ;
            $('#edit_category').html(result.data.category_name) ;
            if(!haslooped)
            $.each(result.data.categories,function(index,category){
                haslooped = true;
                optionText = category.name;
                optionValue = category.name;
                let optionHTML = `
                <option value="${optionValue}"> 
                    ${optionText} 
                </option>`;
                $('#edit_category_select').append(optionHTML);       
          });      
        }, error: function(error) {
            console.log('error in show');
        }
    });
}


function update_product(url){
    var formData = new FormData();
    id = document.getElementById('prod_id').value;
    edit_name=$('#edit_name').val();
    edit_description=$('#edit_descr').val();
    edit_cat=$('#edit_category_select').val();
    edit_price=$('#edit_price').val();
    edit_quantity=$('#edit_quantity').val();
    img=document.getElementById('edit_image').files[0];
    
    formData.append('edit_name',edit_name);
    formData.append('edit_description',edit_description);
    formData.append('edit_category',edit_cat);
    formData.append('edit_price',edit_price);
    formData.append('edit_quantity',edit_quantity);
    if(img){
        formData.append('edit_image',img);
    }
        

    formData.append('_method', 'PUT');
   

    $.ajax({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:url+id,
        data:formData,
        contentType: false,
        processData:false,
        type:'POST',
       
        success:function(result){
           
            if(result.success){
                swal.fire({
                    icon:"success",
                    title: "Success!",
                    
                    text:  result.msg,
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                window.setTimeout(function(){location.reload(); } ,1000);
            }else{
                
                $('#update_prod_err').append(`<span class="alert-icon align-middle">
              <span class="material-icons text-md">
              report
              </span>
            </span>
            <span class="alert-text" id="err_txt">`+result.error+`</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>`);
                $('#update_prod_err').show();
            }
        }, error: function(error) {
            console.log('error in update product: '+error);
        }
    });
}