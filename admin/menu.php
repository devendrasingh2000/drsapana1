<?php
include('../config.php'); 
session_start(); 
if(!isset($_SESSION['username'])){
  header('location:../login.php');
}
// Delete Pages
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $delete_sql = "DELETE FROM menu WHERE id = $id";
    $delete_query = mysqli_query($conn, $delete_sql);
    if($delete_query){
        header('Location: menu.php');
        exit;
    } else {
        echo "Error deleting record from database: " . mysqli_error($conn);
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
                    <h1 class="m-0">Menu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
                <a href="menu_add.php" class="btn btn-primary">Add Menu</a>
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
                <th>Type</th>
                <th>Externale LInk</th>
                <th>Position</th>
                <th>Page Id</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM menu";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                $sr_no = 1; 
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $sr_no++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['external_link']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['page_id']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td> <a href="menu_edit.php?editid=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
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
