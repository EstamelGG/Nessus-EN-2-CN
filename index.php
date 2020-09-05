<?php
// Load the database configuration file
include_once 'dbconfig.php';
if(!isset($_GET['actxs'])){$db->query("truncate en");}
// Get status message
if(!empty($_GET['actxs'])){
    switch($_GET['actxs']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = '导入成功.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = '导入失败.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = '错误的文件类型.';
            break;
        case 'x':
            $statusType = 'alert-success';
            $statusMsg = ' ';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
			
    }
}
$risk_num = $db->query("SELECT * FROM `en` WHERE Risk='Critical';");
$Critical_num=$risk_num->num_rows;
$risk_num = $db->query("SELECT * FROM `en` WHERE Risk='High';");
$High_num=$risk_num->num_rows;
$risk_num = $db->query("SELECT * FROM `en` WHERE Risk='Medium';");
$Medium_num=$risk_num->num_rows;
$risk_num = $db->query("SELECT * FROM `en` WHERE Risk='Low';");
$Low_num=$risk_num->num_rows;
$risk_num = $db->query("SELECT * FROM `en` WHERE Risk='None';");
$None_num=$risk_num->num_rows;
$result = $db->query("SELECT * FROM `en` ORDER BY FIELD (`Risk`,'Critical','High','Medium','Low','None')");
$total = $result->num_rows
?>
<!DOCTYPE html>
<html class="no-js" lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="./css/theme.css" type="text/css">
<script src="./js/jquery.min.js"></script>
<title>Nessus翻译</title>
</head>
<body>
<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg.'&nbsp;&nbsp;&nbsp;&nbsp;<font color="#a80000">危急:'.$Critical_num.'</font>'.'&nbsp;&nbsp;&nbsp;&nbsp;<font color="#a86600">高危:'.$High_num.'</font>'.'&nbsp;&nbsp;&nbsp;&nbsp;<font color="#a5a800">中危:'.$Medium_num.'</font>'.'&nbsp;&nbsp;&nbsp;&nbsp;<font>低危:'.$Low_num.'</font>'.'&nbsp;&nbsp;&nbsp;&nbsp;<font color="#00568e">信息项:'.$None_num.'</font>'.'&nbsp;&nbsp;&nbsp;&nbsp;总计:'.$total; ?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php 
	if($_GET['lan']==="CN"){
		echo "<a href='index.php?actxs=x&lan=EN' style='color: #1b89bf;'>没有翻译的</a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?actxs=x' style='color: #1b89bf;'>全部</a>";
	}elseif($_GET['lan']==="EN"){
		echo "<a href='index.php?actxs=x&lan=CN' style='color: #1b89bf;'>翻译过的</a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?actxs=x' style='color: #1b89bf;'>全部</a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='insert.php' target='_blank' style='color: #1b89bf;'>手动输入翻译数据</a>";
	}elseif(!isset($_GET['lan'])){
		$lang="";
		echo "<a href='index.php?actxs=x&lan=EN' style='color: #1b89bf;'>没有翻译的</a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?actxs=x' style='color: #1b89bf;'>全部</a>";
	}
	if(isset($_GET['lan'])){
		switch($_GET['lan']){
			case 'EN':
				$lang="where Trans = 0";
				break;
			case 'CN':
				$lang="where Trans = 1";
				break;
			default:
				$lang="";
				
		}
	}?>
	</div>
</div>
<?php } ?>
  <div class="py-5 px-5">
    <div class="container-fluid">
      <div class="row" >
        <div class="col-md-11 offset-md-1" style="">
          <div class="upload-wrap anticon btn btn-outline-primary ml-2 mr-2">
          	<form action="importcsvfile.php" method="post" enctype="multipart/form-data">
	            <input class="file-ele" type="file" name="file" style="width: 56px;height: 36px;" onchange="javascript:this.form.submit();" />
	            <input name="importSubmit" value="导入" hidden="">
	            <div class="file-open"><em class="icon icon-upload"></em>上传</div>
            </form>
          </div>
          <a class="btn btn-outline-primary my-2 mr-2" href="exportcsvfile.php">导出</a><a class="btn btn-outline-primary my-2 ml-2 mr-2" href="insert.php" target="_blank">手动添加译文</a>
        </div>
      </div>
    </div>
  </div>

  
 <div>	
    <!-- Data list table --> 
    <table class="table table-hover table-bordered table-condensed" align="center">
        <thead class="thead-dark">
            <tr>
				<th>#</th>
                <th>Plugin_ID</th>
                <th>CVE</th>
                <th>CVSS</th>
                <th>Risk</th>
                <th>Host</th>
				<th>Protocol</th>
				<th>Port</th>
				<th>Name</th>
				<th>Description</th>
				<th>Solution</th>
				<th>Trans</th>
            </tr>
        </thead>
        <tbody>
        <?php
		$line_num=0;
        // Get member rows
        $result = $db->query("SELECT * FROM `en` ".$lang." ORDER BY FIELD (`Risk`,'Critical','High','Medium','Low','None')");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){$line_num+=1;
        ?>
            <tr <?php 
					$risk_level=$row['Risk'];
					switch($risk_level){
						case 'Critical':
						echo 'style="background-color: #ffdede;"';
						break;
						case 'High':
						echo 'style="background-color: #ffebde;"';
						break;
						case 'Medium':
						echo 'style="background-color: #fffcde;"';
						break;
						case 'Low':
						echo 'style="background-color: #f0ffde;"';
						break;
						case 'None':
						echo 'style="background-color: #def3ff;"';
						break;
					} ?>>
				<td><?php echo $line_num; ?></td>
                <td><?php echo $row['Plugin_ID']; ?></td>
                <td><?php echo $row['CVE']; ?></td>
                <td><?php echo $row['CVSS']; ?></td>
                <td><?php echo $row['Risk']; ?></td>
                <td><?php echo $row['Host']; ?></td>
				<td><?php echo $row['Protocol']; ?></td>
				<td><?php echo $row['Port']; ?></td>
				<td><?php echo $row['Name']; ?></td>
				<td><?php echo $row['Description']; ?></td>
				<td><?php echo $row['Solution']; ?></td>
				<td>
				<?php if($row['Trans']==="1"){
					echo "CN";
					} else{
						echo "EN";
						} ?></td>
            </tr>
        <?php } }else{ ?>
            <tr><td colspan="13">No Record found...</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div
<!-- Show/hide CSV upload form -->
  <script src="./js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="./js/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</body>
</html>