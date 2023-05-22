<?php 
    include_once('header.php');
    // select category without deleting 
    $select_category = "SELECT * FROM categories
                        WHERE deleted_at = 0
                        ORDER BY id DESC";
    $select_category_query = mysqli_query($connect,$select_category);
    $count_category = mysqli_num_rows($select_category_query);
    // insert category
    if(isset($_POST['btnSubmit']))
    {
        $category_name = $_POST['category_name'];
        // check category already exists
        $check_category = "SELECT * FROM categories
                           WHERE category_name = '$category_name'
                          ";
        $check_category_query = mysqli_query($connect,$check_category);
        $count_category = mysqli_num_rows($check_category_query);
        if($count_category > 0)
        {
            echo "<script>
                    alert('Category already exists.')
                  </script>
                ";
        }
        else
        {
            $insert = "INSERT INTO categories(`category_name`)
                       VALUES ('$category_name')";
            $insert_query = mysqli_query($connect,$insert);
            if($insert_query)
            {
                echo "<script>
                        alert('Category added successfully')
                        window.location.assign('categories.php')
                      </script>
                    ";
            }
        }
     
    }
    // update user
    if(isset($_POST['btnUpdate']))
    {
        $ucategory_id = $_POST['ucategory_id'];
        $ucategory_name = $_POST['ucategory_name'];
        $update = "UPDATE categories SET
                   category_name = '$ucategory_name'
                   WHERE id = '$ucategory_id'
                  ";
        $update_query = mysqli_query($connect,$update);
        if($update_query)
        {
            echo "<script>
                    alert('Updated successfully')
                    window.location.assign('categories.php')
                  </script>
                 ";
        }
    }
    if(isset($_POST['btnDelete']))
    {
        $dcategory_id = $_POST['dcategory_id'];
        $delete = "UPDATE categories SET
                   deleted_at = 1
                   WHERE id = '$dcategory_id'
                  ";
        $delete_query = mysqli_query($connect,$delete);
        if($delete_query)
        {
            echo "<script>
                    alert('Deleted category successfully')
                    window.location.assign('categories.php')
                 </script>";
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
                <h4 class="card-title">Categories <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Categories</button></h4>
                
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="category-list">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_category > 0)
                            {
                                for ($i=1; $i <= $count_category; $i++) { 
                                    $row_category = mysqli_fetch_assoc($select_category_query);
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_category['category_name']; ?></td>
                                <td>
                                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModal" data-category='<?php echo json_encode($row_category); ?>'>Edit</button>
                                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row_category['id']; ?>">Delete</button>
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
        <form action="categories.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title float-left">Add Categories</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" value="<?php echo $_POST['category_name'] ?? ''; ?>" required>
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
        <form action="categories.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="uname">User Name</label>
                            <input type="text" class="form-control" id="ucategory_name" name="ucategory_name" placeholder="Category Name" required>
                        </div>
                    </div>
                    <input type="hidden" name="ucategory_id" id="ucategory_id">
                </div>
                
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnUpdate">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
  </div>
  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
        <form action="categories.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Delete Category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category ?</p>
                   <input type="hidden" name="dcategory_id" id="dcategory_id">
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
            $('#category-list').DataTable();

            // edit button click
            $(".editbtn").click(function(){
                var category_data = $(this).attr("data-category");
                var category_data_obj = $.parseJSON(category_data);
                $('#ucategory_name').val(category_data_obj.category_name);
                $('#ucategory_id').val(category_data_obj.id);
            });
            $(".deletebtn").click(function(){
                var category_id = $(this).attr("data-id");
                $("#dcategory_id").val(category_id);
            });
    });

</script>