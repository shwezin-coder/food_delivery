<?php 
    include_once('header.php');
?>
    <style>
        .page-item{
            cursor:pointer !important;
        }
    </style>
    <!-- Page Header Start -->
        <div class="container-fluid bg-secondary mb-5">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="assets/img/banner1.jpg" alt="Image">
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="assets/img/banner2.jpg" alt="Image">
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="assets/img/banner3.png" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
        </div>
    <!-- Page Header End -->
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by Category</h5>
                        <?php 
                            $select_category = "SELECT * FROM categories
                                                WHERE deleted_at = 0
                                               ";
                            $select_category_query = mysqli_query($connect,$select_category);
                            $select_category_count = mysqli_num_rows($select_category_query);
                            for ($i=0; $i < $select_category_count ; $i++) { 
                                $row_categories = mysqli_fetch_assoc($select_category_query);
                        ?>
                            <div class="form-group">
                                <input type="radio" name="category_id" id="category<?php echo $i; ?>" class="categories" value="<?php echo $row_categories['id']; ?>">
                                <label for="category<?php echo $i; ?>" class="search-label"><?php echo $row_categories['category_name'];?></label>
                            </div>
                        <?php 
                            }
                        ?>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name" id="search-name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-3" id="search-data">
                
                </div>
                <div class="col-12 pb-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-3" id="page-data">
                          
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
    <!-- Shop End -->
    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" role="dialog">
        <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title float-left">Add to cart</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label for="special_note">Special Note</label>
                                <textarea name="special_note" class="form-control" id="special_note" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="image" id="image">
                        <input type="hidden" name="menu_name" id="menu_name">
                        <input type="hidden" name="price" id="price">
                        <input type="hidden" name="category_name" id="category_name">
                        <input type="hidden" name="menu_id" id="menu_id">
                    </div>
                    <div class="modal-footer">
                        <button onclick="shoppingcart()" class="btn btn-primary" data-dismiss="modal" name="btnaddtocart">Add to Cart</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </div>
  <!-- Edit Modal -->
<?php
    include_once('footer.php');
?>
<script>
    $(document).ready(function ()
    {
        performSearch();
        $('#search-name').keyup(function() {
            menu_name = $(this).val();
            performSearch(page=1,menu_name);
        });
        $('.categories').click(function(){
            category_id = $(this).val();
            performSearch(page=1,menu_name=null,category_id=category_id);
        });
    });
    function addtocart(menu_data)
    {
        $('#quantity').val('');
        $('#menu_name').val(menu_data.menu_name);
        $('#price').val(menu_data.price);
        $('#category_name').val(menu_data.category_name);
        $('#image').val(menu_data.image);
        $('#menu_id').val(menu_data.menu_id);
    }
    function pagination(page){
        category_id = $('input[name="category_id"]:checked').val();
        menu_name = $('#search-name').val();
        performSearch(page,menu_name,category_id);
    }
    function shoppingcart()
    {
        var quantity = $('#quantity').val();
        var menu_name = $('#menu_name').val();
        var category_name = $('#category_name').val();
        var price = $('#price').val();
        var image = $('#image').val();
        var menu_id = $('#menu_id').val();
        var special_note = $('#special_note').val();
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: {quantity:quantity,menu_name:menu_name,category_name:category_name,price:price,image:image,menu_id:menu_id,special_note:special_note,function:'shoppingcart'},
            dataType: 'json',
            success: function(response) {
             // -1 => login first   
            // 1 => true
            // 2 => unavailable    
            if(response.status == 1)
            {
                // Update search results container
                $('#cart-data').html(response.cart_data);
                alert('Cart Added Successfully');
            }
            if(response.status == -1)
            {
                alert('You need to login first.');
                window.location.assign('signin.php');
            }
            if(response.status == 2)
            {
                alert('Sorry,this item is out of stock now');
                window.location.assign('menu_list.php');
            }
            
            }
        });
    }
    function performSearch(page = 1,menu_name = null, category_id = null) {
  $.ajax({
    url: 'ajax.php',
    type: 'POST',
    data: { menu_name:menu_name,category_id:category_id, page: page,function:'search'},
    dataType: 'json',
    success: function(response) {
      // Update search results container
      $('#search-data').html(response.search_data);
      $('#page-data').html(response.page_data);
    }
  });
}
</script>