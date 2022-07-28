<?php
session_start();
error_reporting(0);
include('confs/config.php');
if(strlen($_SESSION['detsuid']==0)):
    header('location: logout.php');
else:
  $id=$_GET['id'];
  if(isset($_POST['sub']))
  {
    $exdate = $_POST['expense_date'];
    $item = $_POST['expense_item'];
    $itemcost = $_POST['cost'];
    $paid_by = $_POST['paid_by'];
    $itempaid = $_POST['is_paid'];
    if(is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {

      $filename = $_FILES['uploadfile']['name'];
      $tempname = $_FILES['uploadfile']['tmp_name'];
      $folder="images/".$filename;
      move_uploaded_file($tempname,$folder);
        $sql = "UPDATE tblexpenses SET expense_date='".$exdate."', expense_item='".$item."', cost='".$itemcost."',paid_by='".$paid_by."',is_paid='".$itempaid."',image='".$folder."'	 where id=".$id;
    }

    else {
        $sql = "UPDATE tblexpenses SET expense_date='".$exdate."', expense_item='".$item."', cost='".$itemcost."',paid_by='".$paid_by."',is_paid='".$itempaid."'	 where id=".$id;
    }



  if(mysqli_query($conn,$sql))
  {
    echo "data updated";
    header("location: manage-expense.php");
  }
  else
  {
        echo "Error updating record: " . mysqli_error($con);
    }
  }
 if(isset($_GET['sub'])) {
  // $rowid = intval($_GET['delid']);
  "UPDATE unit SET uni='".$uni."' where id=".$id;
  $query = mysqli_query($conn, "UPDATE FROM tblexpenses WHERE id = '$id'");
  if($query) {
      // echo "<script>alert('Record successfully deleted.');</script>";
      // echo "<script>window.location.href='manage-expense.php'</script>";
      // header('location:manage-expense.php');
        echo "data updated";
  }else {
      echo "Error updating record: " . mysqli_error($conn);
      // echo "<script>alert('Something went wrong. Please try again!');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Expense Tracker || Manage Expense</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	  <link href="css/font-awesome.min.css" rel="stylesheet">
	  <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
    <?php include('confs/header.php'); ?>
    <?php include('confs/sidebar.php'); ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Edit Expense</li>
			</ol>
		</div>




		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Expense</div>
					<div class="panel-body">
            <?php if($msg): ?>
              <div class="alert alert-info"><?php echo $msg; ?></div>
            <?php endif; ?>

						<div class="col-md-12">
              <?php
              $selectquery = "select * from tblexpenses where id=".$id;
              $query = mysqli_query($conn,$selectquery);
              $row = mysqli_fetch_array($query);
              ?>



                   <form action="update-expense.php?id=<?php echo $row['id'];?> " method="post" enctype="multipart/form-data">
                     <fieldset>
                       <div class="col-md-4">
                          <label>Date of Expense</label>
                         <div class="form-group"><input type="date" class="form-control" name="expense_date" value="<?php echo $row['expense_date'];?>" ></div>
                       </div>
                       <div class="col-md-4">
                        <label>Item</label>
                         <div class="form-group"><input type="text" class="form-control" name="expense_item" value="<?php echo $row['expense_item'];?>" ></div>
                       </div>
                       <div class="col-md-4">
                          <label>Cost of Item</label>
                         <div class="form-group"><input type="text" class="form-control" name="cost" value="<?php echo $row['cost'];?>"></div>
                       </div>
                       <div class="col-md-4">
                        <label>Paid by</label>
                         <div class="form-group"><input type="text" class="form-control" name="paid_by" value="<?php echo $row['paid_by'];?>"></div>
                        </div>
                        <div class="col-md-4">
                          <div><label>Item Image</label></div>
                            <?php if ($row['image'] != "images/"): ?>
                              <div class="inline">
                                <img src="<?php echo $row['image'];?>" height="50" width="100">
                              </div>
                            <?php endif; ?>

                               <input type="file" class="inline w-40" name="uploadfile">

                        </div>
                        <div class="col-md-4">
                          <label>Paid</label>
                          <div class="form-group">
                              <select class="form-select form-select-lg mb-3 form-control required"  name="is_paid" value="<?php echo $row['is_paid'];?>">
                            <!-- <option selected>Open this select menu</option> -->
                          <option value="no">No</option>
                          <option value="yes">Yes</option>
                        </select>
                        </div>
                        </div>

                        <div class="w-50">
                          <div class="form-group">
                            <input type="submit" value="update" class="btn btn-primary btn-add" name="sub" id="sub">
                              <!-- <button type="submit" class="btn btn-primary btn-add" name="submit">Add</button> -->
                          </div>
                        </div>

                    </fieldset>
                    </form>












						</div>
					</div>
				</div>
			</div>
			<?php include('confs/footer.php'); ?>
		</div>
	</div>

  <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
</body>
</html>

<?php endif; ?>
