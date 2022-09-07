<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    



<?php

class myclass{
  
    function connect(){
$db_host='localhost';
$db_username='root';
$db_password='';
$db_name='temp';
$conn =  mysqli_connect($db_host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else{
    return $conn;
}
}

function insert(){
$db=$this->connect();
 if($db){
    $fname=htmlspecialchars($_POST['name']);
    $pno=filter_var($_POST['pno'],FILTER_SANITIZE_NUMBER_INT);
    $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $id=filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    $file = $_FILES['upload']['name'];
    if (file_exists($target_file)) {
     $rawBaseName = pathinfo($file, PATHINFO_FILENAME );
    $extension = pathinfo($file, PATHINFO_EXTENSION );
    $counter =  0;
while(file_exists("images/".$file)) {
    $file = $rawBaseName . $counter . '.' . $extension;
    $counter++;
}
$hi=move_uploaded_file($_FILES["upload"]['tmp_name'],"images/".$file);  
$files=$target_dir .basename($file);
$sql="insert into data(name,pno,email,images,ID)Values('$fname','$pno','$email','$files ','$id')";
var_dump($hi);
      
    } else {
        (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file));
        echo "The file " . htmlspecialchars(basename($_FILES["upload"]["name"])) . " has been uploaded" . "<br>";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $sql="insert into data(name,pno,email,images,ID)Values('$fname','$pno','$email','$target_file ','$id')";
    }

   // $sql="insert into data(name,pno,email,images,ID)Values('$fname','$pno','$email','$target_file ','$id')";
    if (mysqli_query($db, $sql)){
        echo "record inserted"; 
    }
    else{
    echo "record not inserted";
    }
 }
}
function update(){
    $db=$this->connect();
    $fname=htmlspecialchars($_POST['name']);
    $pno=filter_var($_POST['pno'],FILTER_SANITIZE_NUMBER_INT);
    $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $id=filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["upload"]["name"]);
    $file = $_FILES['upload']['name'];
    if (file_exists($target_file)) {
     $rawBaseName = pathinfo($file, PATHINFO_FILENAME );
    $extension = pathinfo($file, PATHINFO_EXTENSION );
    $counter =  0;
while(file_exists("images/".$file)) {
    $file = $rawBaseName . $counter . '.' . $extension;
    $counter++;
}
move_uploaded_file($_FILES["upload"]['tmp_name'],"images/".$file);  
$files=$target_dir .basename($file);
$sql="update data set name='$fname', pno='$pno',email='$email',images=' $files' where id='$id'";

      
    } else {
        (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file));
        echo "The file " . htmlspecialchars(basename($_FILES["upload"]["name"])) . " has been uploaded" . "<br>";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $sql="update data set name='$fname', pno='$pno',email='$email',images=' $target_file' where id='$id'";
    }

 if (mysqli_query($db, $sql)){
        echo "record updated"; 
    }
}
function delete(){
    $db=$this->connect();
    $id=filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $sql="delete from data where id='$id'";

 if (mysqli_query($db, $sql)){
        echo "record deleted"; 
    }
}
function display(){
    $db=$this->connect();
    $id=filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $sql="select *from data ";
    $result = $db->query($sql);
   
    if ($result->num_rows > 0){
                    
        while($rec=$result->fetch_assoc())
        {
          
            echo "Name : ". $rec['name']."<br>";
            echo "Phone NO : ".$rec['pno']."<br>";
            echo "Email : ".$rec['email']."<br>";
            echo "ID : ".$rec['ID']."<br>";
            $c= $rec['images'];
            echo "<img src='$c' width='90%' height= '90%'>"."<br>";
         }
        }
}
}
$obj=new myclass();
$obj->connect();

if (isset($_POST['insert'])) {
    $obj->insert();
}

if (isset($_POST['update'])) {
    $obj->update();
}
if (isset($_POST['delete'])) {
    $obj->delete();
}
if (isset($_POST['disp'])) {
    $obj->display();
}

?>
</body>
</html>