document.addEventListener('DOMContentLoaded', (event) => {
    checkout_prods = document.querySelectorAll('.row_check');
   
    checkout_prods.forEach((product)=>{
        product.querySelector('input[type=number]').addEventListener('change',(event)=>{
            init_price = parseInt(product.querySelector('.init_price').value);
            prod_name = product.childNodes[3].querySelector('.mb-0').innerHTML;
            document.querySelectorAll('.pay-quantity').forEach((quant_pay)=>{
                quant_name = quant_pay.nextElementSibling.value;
                if(quant_name == prod_name){
                    quant_pay.value = parseInt(product.querySelector('input[type=number').value);
                }
            });
            quantity =parseInt(product.querySelector('input[type=number').value);
            
            prod_price = init_price * quantity;
            product.querySelector('span').innerHTML = prod_price;
            cal_total_price();
        });
    });

    products = document.querySelectorAll('.card-shop');
    add_to_cart = document.getElementById('add_to_cart');
    cart_num = document.getElementById('cart_num');
    const cart_prods = [];
    if(parseInt(cart_num.innerText) != 0){
        cart_num.classList.remove("d-none");
    }
    products.forEach((product)=>{
        product.lastElementChild.firstElementChild.addEventListener('click',(event)=>{
            cart_prods.push(product.firstElementChild.value);
            console.log(cart_prods);
            localStorage.setItem('products_ids',cart_prods);
            cart_num.classList.remove("d-none");
            add_to_cart.classList.remove("d-none");
            cart_num.innerText = parseInt(cart_num.innerText) + 1;
            product.lastElementChild.firstElementChild.disabled = true;
        });
    })
   
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
        products = document.querySelectorAll('.card');
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
                      
                        if(response.success){
                            $('#cancel_filter_shop').removeClass("d-none");
                           
                            $('#card').empty();
                            response.data.forEach(function(product){
                                
                                $('#card').append(
                                `
                                <div class="card m-2" style="width: 13rem;">
                                    <input type="hidden" id="cart_prod_id" value="`+product.id+`"></input>
                                    <img src="uploads/`+product.path+`" alt="" width="100%">
                                    <div class="card-body">
                                        <h5 class="card-title">`+product.name+`</h5>
                                        <p class="card-text">`+product.description+`</p>
                                        <p class="card-text"><span class="text-success">`+product.price+`</span> <span style="font-size:11px">$</span></p>
                                        
                                    </div>
                                    <div class="card-footer bg-success ">
                                        <button class="btn text-white" id="add_to_cart">
                                            <i class="material-icons green600 md-18">add_shopping_cart</i>
                                            <span style="position:relative;bottom:4px;">
                                            Add to cart
                                            </span>
                                        </button>  
                    
                                    </div>
                                    
                                </div>`
                                )
                                
                            })
                            const cart_prods = [];
                                products = document.querySelectorAll('.card-shop');
                                cart_num = document.getElementById('cart_num');
                                products.forEach((product)=>{
                                    product.lastElementChild.firstElementChild.addEventListener('click',(event)=>{
                                        cart_prods.push(product.firstElementChild.value);
                                        console.log(cart_prods);
                                        cart_num.classList.remove("d-none");
                                        cart_num.innerText = parseInt(cart_num.innerText) + 1;
                                        product.lastElementChild.firstElementChild.disabled = true;
                                    });
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

    function checkout(){
        prods_ids = localStorage.getItem('products_ids');
        if(prods_ids.length > 0){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'/shop/cart',
                type:'POST',
                data:{
                    products_ids:prods_ids
                },
                success:function(response){
                    if(response.success){
                        localStorage.removeItem('products_ids');
                        window.location.href = '/shop/checkout';
                    }
                }
            })
        }
    }

    function cal_total_price(){
        
        checkout_prods = document.querySelectorAll('.row_check');
        total_price = 0;
        checkout_prods.forEach((product)=>{
           total_price+= parseInt(product.querySelector('span').innerHTML);
        });
        let total_taxed = total_price * 15 / 100;
        
        document.querySelector('.total_price1').querySelector('span').innerHTML = total_price;
        document.querySelector('.total_price2').querySelector('span').innerHTML = total_price + total_taxed;
    }
