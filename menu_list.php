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
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="font-weight-semi-bold text-uppercase mb-3">Menu</h1>
                <div class="d-inline-flex">
                    <p class="m-0"><a href="index.php">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Menu</p>
                </div>
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
                            <div class="custom-control d-flex align-items-center mb-3">
                                <input type="radio" name="category_id" id="category<?php echo $i; ?>" class="categories" value="<?php echo $row_categories['id']; ?>">
                                <label for="category<?php echo $i; ?>"><?php echo $row_categories['category_name']; ?></label>
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
            <form action="menus.php" method="POST">
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
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                        </div>
                        <input type="text" name="menu_name" id="menu_name">
                        <input type="text" name="price" id="price">
                        <input type="text" name="category_name" id="category_name">
                        <input type="hidden" name="menu_id" id="menu_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="btnUpdate">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
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
    $('.cartbtn').click(function(){
        var menu_data = $(this).attr("data-cart");
        var menu_data_obj = $.parseJSON(menu_data);
        $('#menu-name').val(menu_data_obj.menu_name);

    });
    function pagination(page){
        category_id = $('input[name="category_id"]:checked').val();
        menu_name = $('#search-name').val();
        performSearch(page,menu_name,category_id);
    }
    function performSearch(page = 1,menu_name = null, category_id = null) {
  $.ajax({
    url: 'search_ajax.php',
    type: 'POST',
    data: { menu_name:menu_name,category_id:category_id, page: page},
    dataType: 'json',
    success: function(response) {
      // Update search results container
      $('#search-data').html(response.search_data);
      $('#page-data').html(response.page_data);
    }
  });
}
</script>