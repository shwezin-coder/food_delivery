<?php 
include_once('function.php');
if($_POST['function'] == 'search')
{
    $select_menus = "SELECT * FROM menus m,categories c
                    WHERE m.deleted_at = 0 AND c.deleted_at = 0 AND m.category_id = c.id
                ";
    if($_POST['category_id'] != null)
    {
        $category_id = $_POST['category_id'];
        $select_menus .= " AND m.category_id = '$category_id'";
    }
    if($_POST['menu_name'] != null)
    {
        $menu_name = $_POST['menu_name'];
        $select_menus .= " AND menu_name LIKE '%$menu_name%'";
    }

    $select_menus_query = mysqli_query($connect,$select_menus);
    $count_menus = mysqli_num_rows($select_menus_query);
    $records_per_page = 9;
    $total_pages = ceil($count_menus / $records_per_page);
    $page = $_POST['page'];
    $start = ($page-1) * $records_per_page;
    $target_dir = "storage/menus/";

    // return page 
    $select_menus_pagination = "SELECT *, m.id AS menu_id FROM menus m, categories c
                                WHERE m.category_id = c.id AND m.deleted_at = 0
                            ";
    if($_POST['category_id'] != null)
    {
        $category_id = $_POST['category_id'];
        $select_menus_pagination .= " AND m.category_id = '$category_id'";
    }
    if($_POST['menu_name'] != null)
    {
        $menu_name = $_POST['menu_name'];
        $select_menus_pagination .= " AND menu_name LIKE '%$menu_name%'";
    }
    $select_menus_pagination .= " ORDER BY m.id DESC LIMIT $start, $records_per_page";
    $select_menus_pagination_query = mysqli_query($connect,$select_menus_pagination);
    $count_menu_pagination = mysqli_num_rows($select_menus_pagination_query);
    $search_data = '';
    $page_data = '';
    for ($i=0; $i < $count_menu_pagination ; $i++) { 
        $row_menus = mysqli_fetch_assoc($select_menus_pagination_query);
        $menu_name = $row_menus['menu_name'];
        $price = $row_menus['price'];
        $image = $target_dir .$row_menus['image'];
        $category_name = $row_menus['category_name'];
        $search_data .= "<div class='col-lg-4 col-md-6 col-sm-12 pb-1'>
                            <div class='card product-item border-0 mb-4'>
                                <div class='card-header product-img position-relative overflow-hidden bg-transparent border p-0'>
                                    <img src='$image' alt='$image' width='100%' height='200px'>
                                </div>
                                <div class='card-body border-left border-right text-center p-0 pt-4 pb-3'>
                                    <h6 class='text-truncate mb-3'>$menu_name</h6>
                                    <div class='justify-content-center'>
                                        <h6>$price MMK</h6>
                                    </div>
                                </div>
                                <div class='card-footer d-flex justify-content-between bg-light border'>
                                    <p class='btn btn-sm text-dark p-0'><i class='fas fa-list-alt text-primary mr-1'></i>$category_name</p>
                                    <a class='btn btn-sm text-dark p-0' data-toggle='modal' data-target='#cartModal' onclick='addtocart(";
        $search_data .= json_encode($row_menus);
        $search_data .= ")'><i class='fas fa-shopping-cart text-primary mr-1'></i>Add To Cart</a>
                                </div>
                            </div>
                        </div>";
    }
    $previous_pageno = $_POST['page'] - 1;
    $next_pageno = $_POST['page'] + 1;
    if($previous_pageno != 0)
    {
        $page_data  .=  "<li class='page-item' onclick='pagination($previous_pageno)'>
                            <p class='page-link' aria-label='Previous'>
                            <span aria-hidden='true'>&laquo;</span>
                            <span class='sr-only'>Previous</span>
                            </p>
                        </li>";
    }

    for($j = 1; $j <= $total_pages; $j++)
    {
        $page_data .=   "<li class='page-item";
        if($_POST['page'] == $j)
        {
            $page_data .= " active ";
        }
        $page_data .="' onclick='pagination($j)'><p class='page-link'>$j</p></li>";
    }
    if($next_pageno <= $total_pages)
    {
        $page_data .=   "<li class='page-item' onclick='pagination($next_pageno)'>
                            <p class='page-link' aria-label='Next'>
                            <span aria-hidden='true'>&raquo;</span>
                            <span class='sr-only'>Next</span>
                            </p>
                        </li>
                        ";
    }

    $response = [
        'search_data' => $search_data,
        'page_data' => $page_data
    ];
    echo json_encode($response);
}
if($_POST['function'] == 'shoppingcart')
{
    if(!isset($_SESSION['user']))
    {
        $response = [
            'status' => false
        ];
        echo json_encode($response);
    }
    else
    {
        $user_id = $_SESSION['user']['id'];
        $quantity = $_POST['quantity'];
        $menu_name = $_POST['menu_name'];
        $category_name = $_POST['category_name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $menu_id = $_POST['menu_id'];
                // count shopping cart 
        $select_cart = "SELECT * FROM shopping_carts
                        WHERE status = 0 AND user_id = '$user_id' AND menu_id = '$menu_id'
                       ";
        $select_cart_query = mysqli_query($connect,$select_cart);
        $cart_data = mysqli_fetch_assoc($select_cart_query);
        $count_cart = mysqli_num_rows($select_cart_query);
        if($count_cart == 0)
        {
            
            $insert = "INSERT INTO shopping_carts(`user_id`,`menu_id`, `menu_name`, `price`, `image`, `quantity`, `category_name`)
                       VALUES('$user_id','$menu_id','$menu_name','$price','$image','$quantity','$category_name')
                      ";
            $insert_query = mysqli_query($connect,$insert);
            $quantity = $_SESSION['totalitems'] + $quantity;
        }
        else
        {
            $quantity = $cart_data['quantity'] + $quantity;
            $cart_id = $cart_data['id'];
            $update = "UPDATE shopping_carts SET
                       quantity = '$quantity'
                       WHERE id = '$cart_id'
                      ";
            $update_query = mysqli_query($connect,$update);       
        }
        $_SESSION['totalitems'] = $quantity;
        $response = [
            'status' => true,
            'cart_data' => $_SESSION['totalitems']
        ];
        echo json_encode($response);
    }

}
if($_POST['function'] == 'removefromcart')
{
    $cart_id = $_POST['cart_id'];
    $delete = "DELETE FROM shopping_carts
               WHERE id = '$cart_id'
              ";
    $delete_query = mysqli_query($connect,$delete);
    if($delete_query){
        echo true;
    }
}
if($_POST['function'] == 'updatecart')
{
    $quantity = $_POST['quantity'];
    $cart_id = $_POST['cart_id'];
    $update = "UPDATE shopping_carts SET
               quantity = '$quantity'
               WHERE id = '$cart_id'
              ";
    $update_query = mysqli_query($connect,$update);
    if($update_query)
    {
        echo true;
    }
    
}