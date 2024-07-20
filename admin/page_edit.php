<?php
include ('../config.php');
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
if(isset($_GET['editid'])) {
    $id = mysqli_real_escape_string($conn, $_GET['editid']);
    
    // Fetch existing data from database for the given id
    $selectsql = "SELECT * FROM pages WHERE id = '$id'";
    $selectquery = mysqli_query($conn, $selectsql);
    
    if($selectquery) {
        $row = mysqli_fetch_assoc($selectquery);
        $name = $row['name'];
        $status = $row['status'];
        $meta_title = $row['meta_title'];
        $description = $row['description'];
        $meta_description = $row['meta_description'];
        $meta_keyword = $row['meta_keyword'];
        $oldimage = $row['picture_image']; // Existing image path in database
        
        // Handle form submission
        if(isset($_POST['submit'])){
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
            $meta_keyword = mysqli_real_escape_string($conn, $_POST['meta_keyword']);
            
            // Check if a new image file is uploaded
            if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])){
                $newimage = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $upload_directory = "images/"; 
                
                // Move uploaded file to the upload directory
                if(move_uploaded_file($file_tmp, $upload_directory . $newimage)){
                    $picture_image = $upload_directory . $newimage; // New image path for database
                    
                    // Delete old image file if it exists and is different from new image
                    if(!empty($oldimage) && $oldimage != $newimage && file_exists($upload_directory . $oldimage)){
                        unlink($upload_directory . $oldimage);
                    }
                } else {
                    echo "Error uploading file.";
                    $picture_image = $oldimage; // Keep the old image path if upload fails
                }
            } else {
                $newimage = $oldimage; // Keep the existing image path if no new image is uploaded
            }
            
            // Update record in database
            $sql = "UPDATE pages SET name = '$name', status = '$status', meta_title ='$meta_title', description ='$description', meta_description='$meta_description', meta_keyword='$meta_keyword', picture_image='$newimage' WHERE id = '$id'";
            $query = mysqli_query($conn, $sql);
            
            if($query){
                header('Location: page.php');
                exit;
            } else {
                die("Error updating record: " . mysqli_error($conn));
            }
        }
    } else {
        die("Error fetching data: " . mysqli_error($conn));
    }
}
?>
<?php include('header.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Page</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit <small>Page</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="post" enctype="multipart/form-data" id="quickForm">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="<?php echo $name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pimage">Picture Image</label>
                                            <input type="file" name="image" class="form-control" id="pimage">
                                            <?php if (!empty($oldimage)) { ?>
                                                <img src="<?php echo $oldimage; ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;">
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description" placeholder="Enter Description"><?php echo $description; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label><br>
                                            <input type="radio" id="status_active" name="status" value="1" <?php if ($status == 1) echo 'checked'; ?>>
                                            <label for="status_active">Active</label>
                                            <input type="radio" id="status_inactive" name="status" value="2" <?php if ($status == 2) echo 'checked'; ?>>
                                            <label for="status_inactive">Inactive</label>
                                        </div>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="metatitle">Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control" id="metatitle" placeholder="Enter Meta Title" value="<?php echo $meta_title; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="metakeyword">Meta Keyword</label>
                                            <input type="text" name="meta_keyword" class="form-control" id="metakeyword" placeholder="Enter Meta Keyword" value="<?php echo $meta_keyword; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Enter Meta Description"><?php echo $meta_description; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                <a href="page.php" class="btn btn-outline-secondary text-red">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <!-- Additional content here if needed -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php    
include('sidebar.php');
include('footer.php');
?>
