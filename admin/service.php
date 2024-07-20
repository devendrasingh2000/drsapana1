<?php
include('../config.php'); 
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
// Delete Pages
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT image FROM services WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    if($query && mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $image_filename = $row['image'];
        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/drsapana/admin/images/' . $image_filename; 
        if(file_exists($image_path)){
            if(unlink($image_path)){
                $delete_sql = "DELETE FROM services WHERE id = $id";
                $delete_query = mysqli_query($conn, $delete_sql);
                if($delete_query){
                    header('Location: service.php');
                    exit;
                } else {
                    echo "Error deleting record from database: " . mysqli_error($conn);
                }
            } 
        } 
    } else {
        echo "No image found in the database for id: $id";
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
                    <h1 class="m-0">Service Manager</h1>
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
            <div class="col-12">
            <div class="card">
            <div class="card-header">
              <div class="row">
               <div class="col-6">
                
                </div>
                <div class="col-6 text-right">
                <a href="service_add.php" class="btn btn-primary">Add Service</a>
                </div>
            </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Meta Title</th>
                <th>Meta Keyword</th>
                <th>Meta Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM services";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                $sr_no = 1; 
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $sr_no++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['meta_title']; ?></td>
                        <td><?php echo $row['meta_keyword']; ?></td>
                        <td><?php echo $row['meta_description']; ?></td>
                        <td><img src="images/<?php echo $row['image']; ?>" height="50" alt="Image"></td>
                        <td> <a href="service_edit.php?editid=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick =" javascript:return confirm(' Are You Sure to Delete this ');" >Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No rows found
                ?>
                <tr>
                    <td colspan="6">No data found</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>
        </div>
              <!-- /.card-body -->
            </div>
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
