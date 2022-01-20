<?php 
include 'mysqli.php';

if ($_POST['location'] == "register_user") 
{
  $query="SELECT * FROM `tb_user` where username ='".$_POST['username']."'";

  $stm=$connect->prepare($query);
  $stm->execute();
  if ($stm->RowCount() > 0)
  {
  	$alert="<p style='color:red;'>This name is used by another account</p>";
  }else{

  	if (!empty($_POST['username'])) 
  	{

  	  if ($_POST['password'] == $_POST['cpassword']) 
  	  {
  	  	 if (isset($_FILES['img'])) 
  	  	 {
  	  	  	$d_file='Upload/';
  	  	  	$f_name=$d_file.$_FILES['img']['name'];
  	  	  	$f_type=strtolower(pathinfo($f_name,PATHINFO_EXTENSION));
  	  	 	  $ch_file_up="png jpg jpeg";

  	  	  	if (strpos($ch_file_up,$f_type) !== false) 
  	  	  	{
  	  	 	    $img_base64=base64_encode(file_get_contents($_FILES['img']['tmp_name']));

  	  	 	    $image='data:image/'.$f_type.';base64,'.$img_base64;
  	  	    
  	  	  	}
  	     }else{
           $image='';
         }
         $query='INSERT INTO `tb_user`(`username`, `password`, `img_user`)
                               VALUES ("'.$_POST['username'].'","'.$_POST['password'].'","'.$image.'")';
         $stm=$connect->prepare($query);
         if ($stm->execute()) 
         {
           $alert="<p style='color:blue;'>successfully registered</p>";
         }

     }else{

       $alert="<p style='color:red;'>Passwords do not match</p>";
     } 
     }else{

  		 $alert="<p style='color:red;'>Please add a username</p>";
  	}
  }

  echo $alert;
 }

?>