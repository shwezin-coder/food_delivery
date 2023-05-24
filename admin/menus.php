<?php 
    include_once('header.php');
    // select menus without deleting 
    $select_menus = "SELECT *, m.id AS menu_id FROM menus m, categories c
                     WHERE m.deleted_at = 0 AND m.category_id = c.id
                     ORDER BY m.id DESC";
    $select_menus_query = mysqli_query($connect,$select_menus);
    $count_menus = mysqli_num_rows($select_menus_query);
    // target directory
    $target_dir = "../storage/menus/";
    // select category 
    $select_categories = "SELECT * FROM categories
                          WHERE deleted_at = 0
                          ORDER BY id DESC
                         ";
    $select_categories_query = mysqli_query($connect,$select_categories);
    $count_categories = mysqli_num_rows($select_categories_query);
    // insert menu
    if(isset($_POST['btnSubmit']))
    {
        $menu_name = $_POST['name'];
        $noofitems = $_POST['noofitems'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        // check menu already exists
        $check_menu = "SELECT * FROM menus
                       WHERE menu_name = '$menu_name'
                      ";
        $check_menu_query = mysqli_query($connect,$check_menu);
        $count_menu = mysqli_num_rows($check_menu_query);
        if($count_menu > 0)
        {
            echo "<script>
                    alert('Menu already exists.')
                  </script>
                ";
        }
        else
        {
                // file upload
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check === false) {
                    echo "<script>
                            alert('File is not an image.')
                        </script>";
                }
                
                // Check if file already exists
                elseif (file_exists($target_file)) {
                echo "<script>
                        alert('Sorry, file already exists.')
                    </script>";
                }

                // Check file size
                elseif ($_FILES["image"]["size"] > 500000) {
                echo "<script>
                        alert('Sorry, your file is too large.')
                    </script>";
                }

                // Allow certain file formats
                elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "<script>
                        alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')
                    </script>";
                }
            elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $_FILES["image"]["name"];
                    $insert = "INSERT INTO menus(`menu_name`, `noofitems`, `image`, `category_id`, `price`)
                               VALUES ('$menu_name','$noofitems','$image','$category_id','$price')";
                    $insert_query = mysqli_query($connect,$insert);
                    if($insert_query)
                    {
                        echo "<script>
                                alert('Menu added successfully')
                                window.location.assign('menus.php')
                              </script>
                            ";
                    }
                } else {
                    echo "<script>
                            alert('Sorry, there was an error uploading your file.')
                            window.location.assign('menus.php')
                        </script>
                        ";
                }
                
        }
    }
    // update user
    if(isset($_POST['btnUpdate']))
    {
        $umenu_name = $_POST['uname'];
        $unoofitems = $_POST['unoofitems'];
        $uprice = $_POST['uprice'];
        $ucategory_id = $_POST['ucategory_id'];
        $umenu_id = $_POST['umenu_id'];
        $update = "UPDATE menus SET
                   menu_name = '$umenu_name',
                   noofitems = '$unoofitems',
                   price = '$uprice',
                   category_id = '$ucategory_id'
                   WHERE id = '$umenu_id'
                  ";
        $update_query = mysqli_query($connect,$update);
        if($update_query)
        {
            echo "<script>
                    alert('Updated successfully')
                    window.location.assign('menus.php')
                  </script>
                 ";
        }
    }
    if(isset($_POST['btnDelete']))
    {
        $dmenu_id = $_POST['dmenu_id'];
        $delete = "UPDATE menus SET
                   deleted_at = 1
                   WHERE id = '$dmenu_id'
                  ";
        $delete_query = mysqli_query($connect,$delete);
        if($delete_query)
        {
            echo "<script>
                    alert('Deleted menu successfully')
                    window.location.assign('menus.php')
                 </script>";
        }
    }
    if(isset($_POST['btnUpdateImage']))
    {
            // file upload
            $target_file = $target_dir . basename($_FILES["uimage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["uimage"]["tmp_name"]);
            if($check === false) {
                echo "<script>
                        alert('File is not an image.')
                    </script>";
            }
            
            // Check if file already exists
            elseif (file_exists($target_file)) {
            echo "<script>
                    alert('Sorry, file already exists.')
                </script>";
            }

            // Check file size
            elseif ($_FILES["image"]["size"] > 500000) {
            echo "<script>
                    alert('Sorry, your file is too large.')
                </script>";
            }

            // Allow certain file formats
            elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "<script>
                    alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')
                </script>";
            }
        elseif (move_uploaded_file($_FILES["uimage"]["tmp_name"], $target_file)) {
                $image = $_FILES["uimage"]["name"];
                $menu_id = $_POST['umenu_id'];
                $old_image = $_POST['old_image'];
                $update = "UPDATE menus SET
                           image = '$image'
                           WHERE id = '$menu_id'
                          ";
                $update_query = mysqli_query($connect,$update);
                if($update_query)
                {
                    unlink($target_dir.$old_image);
                    echo "<script>
                            alert('Menu image updated successfully')
                            window.location.assign('menus.php')
                          </script>
                        ";
                }
            } else {
                echo "<script>
                        alert('Sorry, there was an error uploading your file.')
                        window.location.assign('menus.php')
                    </script>
                    ";
            }
            
    }
?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Menus <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Menus</button></h4>  
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="menu-list">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>No of Items</th>
                            <th width="30%">Action</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_menus > 0)
                            {
                                for ($i=1; $i <= $count_menus; $i++) { 
                                    $row_menu = mysqli_fetch_assoc($select_menus_query);
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_menu['menu_name']; ?></td>
                                <td><?php echo $row_menu['category_name']; ?></td>
                                <td><img src="<?php echo $target_dir .$row_menu['image']; ?>" alt="<?php echo $row_menu['image']; ?>" width="100px" height="100px"></td>
                                <td><?php echo $row_menu['price']; ?> MMK</td>
                                <td><?php echo $row_menu['noofitems']; ?></td>
                                <td>
                                    <div class="flex">
                                        <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModal" data-edit-menu='<?php echo json_encode($row_menu); ?>'>Edit</button>
                                        <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row_menu['menu_id']; ?>">Delete</button>
                                        <button class="btn btn-primary editimagebtn" data-toggle="modal" data-target="#editimageModal" data-editimg-menu="<?php echo json_encode($row_menu); ?>">Update Image</button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                                              
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php 
    include_once('footer.php');
?>
<!-- Add Modal -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
        <form action="menus.php" method="POST" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Add Menus</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="noofitems">No Of Items</label>
                            <input type="number" name="noofitems" id="noofitems" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="category_id">Category Name</label>
                            <select name="category_id" class="form-control">
                                <?php
                                    $select_categories1 = "SELECT * FROM categories
                                                          WHERE deleted_at = 0
                                                          ORDER BY id DESC
                                                         ";
                                    $select_categories_query1 = mysqli_query($connect,$select_categories1);
                                    $count_categories1 = mysqli_num_rows($select_categories_query1);
                                      for ($i=1; $i <= $count_categories1; $i++) {
                                        $row_category1 = mysqli_fetch_assoc($select_categories_query1);
                                ?>
                                    <option value="<?php echo $row_category1['id']; ?>"><?php echo $row_category1['category_name']; ?></option>
                                <?php
                                      }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnSubmit">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <form action="menus.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Edit Menu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-6">
                            <label for="uname">Name</label>
                            <input type="text" class="form-control" name="uname" id="uname" placeholder="Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="unoofitems">No Of Items</label>
                            <input type="number" name="unoofitems" id="unoofitems" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ucategory_id">Category Name</label>
                            <select name="ucategory_id" id="ucategory_id" class="form-control">
                                <?php
                                    for ($i=1; $i <= $count_categories; $i++) {
                                        $row_category = mysqli_fetch_assoc($select_categories_query);
                                ?>
                                    <option value="<?php echo $row_category['id']; ?>"><?php echo $row_category['category_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="uprice">Price</label>
                            <input type="number" name="uprice" id="uprice" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" name="umenu_id" id="umenu_id">
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
<div class="modal fade" id="editimageModal" role="dialog">
    <div class="modal-dialog">
        <form action="menus.php" method="POST" enctype="multipart/form-data">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Update Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-6">
                            <label for="uimage">Image</label>
                            <input type="file" class="form-control" name="uimage" id="uimage" placeholder="Upload Image" required>
                        </div>
                    </div>
                    <input type="hidden" name="old_image" id="old_image">
                    <input type="hidden" name="umenu_id" id="umenuimage_id">
                </div>
                
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnUpdateImage">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
  </div>
  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
        <form action="menus.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Delete Menu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this menu ?</p>
                   <input type="hidden" name="dmenu_id" id="dmenu_id">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnDelete">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
  </div>
<script>
        $(document).ready( function () {

            // datatable
            $('#menu-list').DataTable();     
    });
      // edit button click
      $(".editbtn").click(function(){
        var menu_data = $(this).attr("data-edit-menu");
        var menu_data_obj = $.parseJSON(menu_data);
        $('#uname').val(menu_data_obj.menu_name);
        $('#unoofitems').val(menu_data_obj.noofitems);
        $('#ucategory_id').val(menu_data_obj.category_id);
        $('#uprice').val(menu_data_obj.price);
        $('#umenu_id').val(menu_data_obj.menu_id);
    });
    $(".editimagebtn").click(function(){
        var menu_data = $(this).attr("data-editimg-menu");
        var menu_data_obj = $.parseJSON(menu_data);
        $('#old_image').val(menu_data_obj.image);
        $('#umenuimage_id').val(menu_data_obj.menu_id);
    });
    $(".deletebtn").click(function(){
        var menu_id = $(this).attr("data-id");
        $("#dmenu_id").val(menu_id);
    });

</script>