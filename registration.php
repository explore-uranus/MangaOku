<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

<title>MangaOku Sign Up</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<link rel="stylesheet" href="styles.css">
<style type="text/css">
  
 body {
  color: #fff;
  background: #cc6699;
  font-family: 'Roboto', sans-serif;
 }
 .form-control, .form-control:focus, .input-group-addon {
  border-radius: 5px;
  border-color: #e1e1e1;
 }
    .form-control, .btn {        
        border-radius: 3px;
    }
 .signup-form {
  width: 390px;
  margin: 0 auto;
  padding: 30px 0;
 }
    .signup-form form {
  color: #999;
  border-radius: 3px;
     margin-bottom: 15px;
        background: #fff;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
 .signup-form h2 {
  color: #333;
  font-weight: bold;
        margin-top: 0;
    }
    .signup-form hr {
        margin: 0 -30px 20px;
    }
 .signup-form .form-group {
  margin-bottom: 20px;
 }

 
 
  
    .signup-form .btn{        
        font-size: 16px;
        font-weight: bold;
  background: #cc6699;
  border: none;
  min-width: 140px;
    }
 .signup-form .btn:hover, .signup-form .btn:focus {
  background: #19aa8d;
        outline: none;
 }
 
 
</style>
<?php 
    if(isset($_POST['submit'])){
       
        $connect = oci_connect("hr","MangaOku12", "localhost/MangaOku");
        $s = "SELECT MAX(USER_ID) AS ID FROM MANGAOKU_USER";
        $sres = oci_parse($connect,$s);
        oci_execute($sres);
        ocifetchinto($sres,$ss);
        $id = intval(join(" ",$ss))+1;



        $sql = "INSERT INTO MANGAOKU_USER 
                (USER_ID, FNAME, LNAME, NNAME, EMAIL,USER_PASSWORD)
                VALUES(:USER_ID, :FNAME, :LNAME, :NNAME, :EMAIL,:USER_PASSWORD)
        ";
        $res = oci_parse ($connect, $sql);

        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $nname = $_POST['nickname'];
        $email = $_POST['email'];
        $pass = $_POST['password'];




        oci_bind_by_name($res, ":USER_ID",$id);
        oci_bind_by_name($res, ":FNAME",$fname );
        oci_bind_by_name($res, ":LNAME",$lname );
        oci_bind_by_name($res, ":NNAME",$nname );
        oci_bind_by_name($res, ":EMAIL",$email );
        oci_bind_by_name($res, ":USER_PASSWORD", $pass);
         oci_execute($res, OCI_DEFAULT) or die ("Unable to execute query");
        oci_commit($connect);
        oci_free_statement($res);
    }
?>
</head>
<body>
<div class="signup-form">
    <form  method="post" action="main_page.php">
  <h2>Sign Up</h2>
  <p>Please fill in this form to create an account!</p>
  <hr>
        <div class="form-group">

   <div class="input-group">
    
    <input type="text" style="width: 300px; border-radius: 3px;" class="form-control" name="nickname" placeholder="NickName" required="required">
   </div>
        </div>
        <div class="form-group">
   <div class="input-group">
   
    <input type="text"  style="width: 300px; border-radius: 3px;" class="form-control" name="firstname" placeholder="First Name" required="required">
   </div>
        </div>
        <div class="form-group">
   <div class="input-group">
   
    <input type="text"  style="width: 300px; border-radius: 3px;" class="form-control" name="lastname" placeholder="Last Name" required="required">
   </div>
        </div>
        <div class="form-group">
   <div class="input-group">
   
    <input type="email"  style="width: 300px; border-radius: 3px;" class="form-control" name="email" placeholder="Email Address" required="required">
   </div>
        </div>
  <div class="form-group">
   <div class="input-group">
    
    <input type="password" style="width: 300px; border-radius: 3px;" class="form-control" name="password" placeholder="Password" required="required">
   </div>
        </div>
 
       
  <div class="form-group">
            <input type="submit" name="signup"class="btn btn-primary btn-lg" value ="Sign up">
        </div>
    </form>

</body>
</html>             


