<?php 
include_once('function.php');
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
$total_pages = $count_menus / $records_per_page;
$page = $_POST['page'];
$start = ($page-1) * $records_per_page;
$target_dir = "storage/menus/";

// return page 
$select_menus_pagination = "SELECT * FROM menus m, categories c
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
$select_menus_pagination .= " LIMIT $start, $records_per_page";
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
                                    <h6>$price</h6>
                                </div>
                            </div>
                            <div class='card-footer d-flex justify-content-between bg-light border'>
                                <p class='btn btn-sm text-dark p-0'><i class='fas fa-list-alt text-primary mr-1'></i>$category_name</p>
                                <a class='btn btn-sm text-dark p-0 cartbtn' data-toggle='modal' data-target='#cartModal' data-cart='";
    $search_data .= json_encode($row_menus);
    $search_data .= "'><i class='fas fa-shopping-cart text-primary mr-1'></i>Add To Cart</a>
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