document.addEventListener('DOMContentLoaded', (event) => {
    minFieldShop=document.getElementById("minPriceShop");
    maxFieldShop=document.getElementById("maxPriceShop");

    cancel_filterShop = document.getElementById("cancel_filter_shop");
    cancel_filterShop.addEventListener("click", (event) => {
           
        $('#cancel_filter_shop').addClass("d-none");
            window.location.reload();
        });

        maxFieldShop.addEventListener("change", (event) => {
            max = parseInt(maxFieldShop.value, 10);
            min = parseInt(minFieldShop.value, 10);
            if(max < min){
                minFieldShop.value = maxFieldShop.value;
            }
        });
        minFieldShop.addEventListener("change", (event) => {
            max = parseInt(maxFieldShop.value, 10);
            min = parseInt(minFieldShop.value, 10);
            if(min > max){
                minFieldShop.value =0;
            }
        });
        //Pagination
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
    });

    function shop_filter(){

        minPriceShop=document.getElementById("minPriceShop").value;
        maxPriceShop=document.getElementById("maxPriceShop").value;
    
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
                        minPrice:minPriceShop,
                        maxPrice:maxPriceShop
    
                    },
                    success:function(response){
                        console.log("piew");
                        if(response.success){
                            $('#cancel_filter_shop').removeClass("d-none");
                            console.log(response.data);
                            $('#card').empty();
                            response.data.forEach(function(product){
                                $('#card').append(
                                `<div class="card m-2" style="width: 13rem;">
                                    <img src="uploads/`+product.path+`" alt="" width="100%">
                                    <div class="card-body">
                                        <h5 class="card-title">`+product.name+`</h5>
                                        <p class="card-text">`+product.description+`</p>
                                        <p class="card-text"><span class="text-success">`+product.price+`</span> <span style="font-size:11px">$</span></p>
                                        
                                    </div>
                                    <a href="">
                                        <div class="card-footer bg-success text-white">
                                        <i class="material-icons green600 md-18">add_shopping_cart</i>
                                        <span style="position:relative;bottom:4px;">
                                            Add to cart
                                        </span>
                                        
                                            
                                        </div>
                                    </a>
                                    
                                </div>`
                                )
                            })
                        }
                      
                    }
                });
            
    }
    
    function showPage(pagenum){
        list_card = document.getElementById('card');
        cards = document.getElementById('card').getElementsByClassName("card");
        cards_per_page = 9;
        current_page = 1;
        const paginationDropdown = document.getElementById('pagination-dropdown');
        
        paginationDropdown.value=pagenum;
    
        for(var i=0; i<cards.length; i++){
            cards[i].style.display ="none";
        }
        start = (pagenum - 1) * cards_per_page;
        end = start + cards_per_page;
        for (var i=start; i<end; i++){
            cards[i].style.display ="";
        }
      
    }