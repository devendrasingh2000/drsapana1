<?php
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
include ('../config.php');

if(isset($_POST['submit'])){
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $external_link = mysqli_real_escape_string($conn, $_POST['external_link']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $page_id = mysqli_real_escape_string($conn, $_POST['page_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
        // Insert into database
        $sql = "INSERT INTO menu (name, type, external_link, position, page_id, status) VALUES ('$name', '$type', '$external_link', '$position', '$page_id', '$status')";
        $query = mysqli_query($conn, $sql);
        if($query){
            header('Location: menu.php');
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
  
}
?>

<?php include('header.php'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Menu</h1>
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
            <!-- Your content goes here -->
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add <small>New Menu</small></h3>
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
                        <label for="exampleInputName1">External Link</label>
                        <input type="text" name="external_link" class="form-control" id="exlink" placeholder="Enter External link" >
                    </div>
                    <div class="form-group">
                    <label>Status</label><br>
                    <input type="radio" id="status_active" name="status" value="1">
                    <label for="status_active">Active</label>
                    <input type="radio" id="status_inactive" name="status" value="2">
                    <label for="status_inactive">Inactive</label>
                    </div>
                
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                
                <div class="form-group">
                        <label for="exampleInputdescription1">Type</label>
                        <input type="text" name="type" class="form-control" id="type" placeholder="Enter Type">
                </div>
                <div class="form-group">
                        <label for="exampleInputName1">Position</label>
                        <input type="text" name="position" class="form-control" id="position" placeholder="Enter Position" >
                </div>
                <?php
                $pages = [];
                $sql = "SELECT id, name FROM pages";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $pages[] = $row;
                    }
                }
                ?>
                <div class="form-group">
                    <label for="page_id">Page ID</label>
                    <select name="page_id" id="page_id" class="form-control">
                        <?php foreach ($pages as $page): ?>
                            <option>Select Page Id</option>
                            <option value="<?php echo $page['id']; ?>"><?php echo $page['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
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
