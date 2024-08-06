<?php
$servername="127.0.0.1";
$username="root";
$password="";
$dbname="resturant";

$conn = mysqli_connect($servername , $username , $password , $dbname);

if(!$conn){
    die("connect failed".mysqli_connect_error());
}
$name=$_POST['name'];
$message=$_POST['message'];

$sql="INSERT INTO feeds(name,text) VALUES ('$name','$message')";
if(mysqli_query($conn,$sql)){
    echo "feed back successfully ";
}else{
    echo"error".$sql."<br>".mysqli_error($conn);
}

mysqli_close($conn);



?>