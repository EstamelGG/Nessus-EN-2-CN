<?php
// Load the database configuration file
include_once 'dbconfig.php';
$qstring="";
if(isset($_POST['psw'])||isset($_POST['plgid'])||isset($_POST['nameen'])||isset($_POST['namecn'])||isset($_POST['desc'])||isset($_POST['sol'])){
	$trans = $db->prepare("SELECT Name_CN,Description,Solution FROM trans WHERE Plugin_ID=(?)");
	$trans->bind_param('i', $_POST['plgid'] );
	$trans->execute();
	$trans->bind_result($Name,$Description,$Solution);
	$trans->fetch();
	$trans->close();
	if(MD5($_POST['psw']) === "*************"){ //密码 php -r "echo md5('yourpassword');"
		if(!empty($Name)){
			$qstring = '?actxs=err'; //判断记录是否已经存在
		}else{
		// Validate whether selected file is a CSV file
		if(!empty($_POST['plgid'])&&!empty($_POST['nameen'])&&!empty($_POST['namecn'])&&!empty($_POST['desc'])&&!empty($_POST['sol'])){
			if(is_numeric($_POST['plgid'])){
				$stmt = $db->prepare("INSERT INTO trans VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param('issss', htmlspecialchars($_POST['plgid']), htmlspecialchars($_POST['nameen']), htmlspecialchars($_POST['namecn']) , htmlspecialchars($_POST['desc']),htmlspecialchars($_POST['sol']));
				$stmt->execute();
				$stmt->close();
				
				$trans = $db->prepare("SELECT Name_CN,Description,Solution FROM trans WHERE Plugin_ID=(?)");
				$trans->bind_param('i', $_POST['plgid'] );
				$trans->execute();
				$trans->bind_result($Name,$Description,$Solution);
				$trans->fetch();
				$trans->close();
					if(!empty($Name)){
						$qstring = '?actxs=succ';
						header("Location: insert.php".$qstring);
					}
				}else{$qstring = '?actxs=wpid';}
			}
		}
	}else{
		$qstring = '?actxs=wps';
	}
}else{
	$qstring = '?actxs=mis';
}
// Redirect to the listing page
header("Location: insert.php".$qstring);
?>
