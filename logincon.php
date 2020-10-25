<?php

 
/*$conn = new mysqli("localhost", "root", "", "logindb");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=record', "root", "");

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = $_POST['username'];
$password = $_POST['password'];
$out = [];

$sql = "select * from user where username=:username and password=:password";

$stmt = $db->prepare($sql);
$stmt->execute(['username' => $username,'password'=>$password ]);
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($user)) {
        foreach ($user as $row) {
          
            $_SESSION['user']=$row["id"];
            $out['message'] = "Giriş Başarılı";
        }

       

    }else{
        $out['error'] = true;
		$out['message'] = "Giriş Başarısız.";
    }

    header("Content-type: application/json");
    echo json_encode($out);
    die();

} 
catch ( PDOException $e ){
    print $e->getMessage();
}


/*$out = array('error' => false);
 

 
if($username==''){
	$out['error'] = true;
	$out['message'] = "Lütfen Kullanıcı Adı Giriniz";
}
else if($password==''){
	$out['error'] = true;
	$out['message'] = "Lütfen Şifre Giriniz";
}*/

/*	$sql = "select * from user where username='$username' and password='$password'";
	$query = $conn->query($sql);
 
	if($query->num_rows>0){
		$row=$query->fetch_array();
		$_SESSION['user']=$row['userid'];
		$out['message'] = "Giriş Başarılı";
	}
	else{
		$out['error'] = true;
		$out['message'] = "Giriş Başarısız.";
    }*/
    
   



 
 
 
/*$conn->close();
 
header("Content-type: application/json");
echo json_encode($out);
die();*/
 
 
?>