<?php 
  session_start();
  
  include 'php/db.php';
  $unique_id = $_SESSION['unique_id'];
  if(empty($unique_id))
  {
      header ("Location: login_page.html");
  } 
  $qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
  if(mysqli_num_rows($qry) > 0){
    $row = mysqli_fetch_assoc($qry);
    if($row){
      $_SESSION['verification_status'] = $row['verification_status'];
      if($row['verification_status'] == 'Verified')
      {
        header ("Location: index.php");
      } 
  }
  }
?>