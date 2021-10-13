<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add USER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<form method="POST">
<input type="text" class="form-control mt-3" name="text">
<button type="submit" class="btn btn-dark mt-3" name="btn">INSERT-إضافة</button> 
</div>
</form>
<?php
$username="root";
$password="";
$database=new PDO("mysql:host=localhost;dbname=users;charset=utf8",$username,$password);
session_start();
if(isset($_SESSION['role'])){
if($_SESSION['role']->ROLE==="user"){
$useridd=$_SESSION['role']->id;
 if(isset($_POST['btn'])){
   $user1=$database->prepare("INSERT INTO usertype (text,userid,states) VALUES(:text,:userid,'no')");
   $user1->bindParam("text",$_POST['text']);
   $user1->bindParam("userid",$useridd);
   $user1->execute();
 }
 
 $select=$database->prepare("SELECT * FROM usertype WHERE userid = :iduser");
 $select->bindParam("iduser",$useridd);
 $select->execute();
  echo "<div class='container mt-3'>
  <table class='table'>
  <tr class='shadow'>
   <th >المهمة</th>
   <th>الحالة</th>
   <th>جذف</th>
  </tr>
  </table></div>";
foreach($select AS $data){
  echo "<div class='container'>
  <table class='table'>
  <tr class='shadow '>
   <th>". $data['text']."</th>";
   if($data['states']==="no"){
    echo "<th><form  method='POST'>
    <button class='btn btn-warning' name='not' value='".$data['id']."'>لم ينجز بعد</button></form></th> ";
   }else if($data['states']==="yes"){
    echo "<th><form method='POST'><button class='btn btn-success' >إنجز</button></form></th>";
   }
   echo "<th><form method='POST'><button type='submit' class='btn btn-danger' name='delete' value='".$data['id']."'>Delete-حذف</button></form></th>";
   echo "</tr></div></table>";
 }
 if(isset($_POST['not'])){
    $update=$database->prepare("UPDATE usertype SET states= 'yes' WHERE id=:id ");
    $update->bindParam("id",$_POST['not']);
    $update->execute();
    header('location:user1.php',true);
 }
 if(isset($_POST['delete'])){
    $delete=$database->prepare("DELETE FROM usertype WHERE id=:id");
    $delete->bindParam("id",$_POST['delete']);
    $delete->execute();
    header('location:user1.php',true);
 }

}
}
 


?>

</body>
</html>
