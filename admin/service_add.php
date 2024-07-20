<?php
include ('../config.php');
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
if(isset($_POST['submit'])){
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    //$status = mysqli_real_escape_string($conn, $_POST['status']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keyword = mysqli_real_escape_string($conn, $_POST['meta_keyword']);
    
    $image = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $upload_directory = "images/";
   
    if($_FILES['image']['error'] == UPLOAD_ERR_OK){
        $allowed_extensions = array("jpg","jpeg","png","gif","webp");
        $file_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if(in_array($file_extension, $allowed_extensions)){
            move_uploaded_file($file_tmp, $upload_directory . $image);
        }
        else{
            die("Error: Invalid file type. Allowed types: jpg, jpeg, png, gif, webp");
        }
    } 
        // Insert into database
        $sql = "INSERT INTO services (name,  meta_title, description, meta_description, meta_keyword,image) 
                VALUES ('$name',  '$meta_title', '$description', '$meta_description','$meta_keyword', '$image')";
        
        $query = mysqli_query($conn, $sql);
        if($query){
            header('Location: service.php');
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
  
}
?>
<?php include('header.php'); ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Your content goes here -->
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add <small>New Service</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data" id="quickForm">
        <div class="card-body">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Image</label>
                        <input type="file" name="image" class="form-control" id="pimage" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputdescription1">Description</label>
                        <textarea type="text" name="description" class="form-control" id="description" placeholder="Enter Description"></textarea>
                    </div>
                    <!-- <div class="form-group">
                    <label>Status</label><br>
                    <input type="radio" id="status_active" name="status" value="1">
                    <label for="status_active">Active</label>
                    <input type="radio" id="status_inactive" name="status" value="2">
                    <label for="status_inactive">Inactive</label>
                    </div> -->
                
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                
                <div class="form-group">
                        <label for="exampleInputdescription1">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" id="metatitle" placeholder="Enter Meta Title">
                </div>
                <div class="form-group">
                        <label for="exampleInputName1">Meta Keyword</label>
                        <input type="text" name="meta_keyword" class="form-control" id="metakeyword" placeholder="Enter Meta Keyword" >
                </div>
                <div class="form-group">
                        <label for="exampleInputdescription1">Meta Description</label>
                        <textarea type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Enter Meta Description"></textarea>
                </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button type="button" class="btn btn-outline-secondary text-red" onclick="window.location.href='page.php'">Cancel</button>

        </div>
    </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php    
include('sidebar.php');
include('footer.php');
?>
