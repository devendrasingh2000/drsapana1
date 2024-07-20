<?php
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
include ('../config.php');

if(isset($_GET['editid'])){
    $id = mysqli_real_escape_string($conn, $_GET['editid']);
    $selectsql = "SELECT * FROM menu WHERE id = '$id'";
    $selectquery = mysqli_query($conn, $selectsql);
    if($selectquery){
        $row = mysqli_fetch_assoc($selectquery);
        $name = $row['name'];
        $type = $row['type'];
        $external_link = $row['external_link'];
        $position = $row['position'];
        $page_id = $row['page_id'];
        $status = $row['status'];

    
        if(isset($_POST['submit'])){
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $external_link = mysqli_real_escape_string($conn, $_POST['external_link']);
            $position = mysqli_real_escape_string($conn, $_POST['position']);
            $page_id = mysqli_real_escape_string($conn, $_POST['page_id']);
            $status = mysqli_real_escape_string($conn, $_POST['status']);
                // edit data
                $sql = "UPDATE menu SET name = '$name',type='$type',external_link='$external_link',position='$position',page_id='$page_id',status='$status'";
                $query = mysqli_query($conn, $sql);
                if($query){
                    header('Location: menu.php');
                    exit;
                } else {
                    die("Error: " . mysqli_error($conn));
                }
          
        }
    } else {
        die("Error fetching data: " . mysqli_error($conn));
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
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="<?php echo $name ; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">External Link</label>
                        <input type="text" name="external_link" class="form-control" id="exlink" placeholder="Enter External link" value="<?php echo $external_link ; ?>">
                    </div>
                    <div class="form-group">
                       <label>Status</label><br>
                       <input type="radio" id="status_active" name="status" value="1" <?php echo ($status == 1) ? 'checked' : ''; ?>>
                       <label for="status_active">Active</label>
                       <input type="radio" id="status_inactive" name="status" value="2" <?php echo ($status == 2) ? 'checked' : ''; ?>>
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
                        <input type="text" name="position" class="form-control" id="position" placeholder="Enter Position" value="<?php echo $position; ?>">
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
                    <option>Select Page ID</option>
                    <?php foreach ($pages as $page): ?>
                    <?php if ($page['id'] == $page_id): ?>
                    <option value="<?php echo $page['id']; ?>" selected><?php echo $page['name']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $page['id']; ?>"><?php echo $page['name']; ?></option>
                    <?php endif; ?>
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
