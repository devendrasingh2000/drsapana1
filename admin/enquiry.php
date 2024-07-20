
<?php
include('../config.php');
session_start();
if(!isset($_SESSION['username'])){
    header('location:../login.php');
  }
?>
<?php include('header.php'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Enquiry Manager</h1>
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
                <!-- <div class="col-6 text-right">
                <a href="page_add.php" class="btn btn-primary">Add Page</a>
                </div> -->
            </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>email Id</th>
                <th>Phone NO.</th>
                <th>Message</th>
                <th></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM enquiry";
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                $sr_no = 1; 
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $sr_no++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['meta_title']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td></td>
                        <td> 
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
