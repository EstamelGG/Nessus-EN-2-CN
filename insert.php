<?php
// Load the database configuration file
include_once 'dbconfig.php';
// Get status message
if (!empty($_GET['actxs'])) {
    switch ($_GET['actxs']) {
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = '导入成功.';
            break;

        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = '导入失败，指定插件ID记录已存在.';
            break;

        case 'wpid':
            $statusType = 'alert-danger';
            $statusMsg = '错误的插件ID.';
            break;

        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = '错误的文件类型.';
            break;

        case 'wps':
            $statusType = 'alert-danger';
            $statusMsg = '错误的密码.';
            break;

        case 'mis':
            $statusType = 'alert-danger';
            $statusMsg = '缺少必须项.';
            break;

        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>
<!DOCTYPE html>
<html class="no-js" lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="./css/theme.css" type="text/css">
  <title>Nessus翻译</title>
<script>
<!--拖动滚动条或滚动鼠标轮-->
window.onscroll=function(){
if(document.body.scrollTop||document.documentElement.scrollTop>0){
document.getElementById('rTop').style.display="block"
}else{
document.getElementById('rTop').style.display="none"
}
}
</script>
</head>
<body>
	<div id="totop"></div>
<!-- Display status message -->
<?php
if (!empty($statusMsg)) { ?>
<div class="col-xs-12">
    <div class="alert <?php
    echo $statusType; ?>">
    <?php echo $statusMsg; ?>
    </div>
</div>
<?php
} ?>
 
<body>
   <div id = "rTop" style="position:fixed; right:100px; bottom:10px;z-index: 99999;" class="py-5">
    <div class="container">
      <div class="row" style="opacity: 0.8;">
        <div class="col-md-12"><a type="submit" class="btn btn-success ml-1" href="#totop" style="submit">TOP</a><a type="submit" href="#foot" class="btn btn-success ml-1" style="submit">Buttom</a></div>
      </div>
    </div>
  </div>
  <div class="py-5" style="">
    <div class="container">
      <div class="row">
        <div class="col-md-12 border-left border-right border-top border-bottom">
          <form id="c_form-h" class="" action="updatetrans.php" method="post" enctype="multipart/form-data" style="opacity: 0.8;">
            <div class="form-group row"> <label for="inputmailh" class="col-2 col-form-label text-right text-dark mt-2" style="">Plugin ID：</label>
              <div class="col-10 col-md-5" style="">
                <input type="number" class="form-control mt-2" id="plgid" name="plgid" placeholder="123456" required="required" style="  box-shadow: 0px 0px 4px  black;"> </div>
            </div>
            <div class="form-group row"> <label for="inputpasswordh" class="col-2 col-form-label text-right text-dark" style="">Name&nbsp;英文名称：<br></label>
              <div class="col-10 col-md-5" style="">
                <input type="text" class="form-control" id="nameen" name="nameen" required="required" style=" box-shadow: 0px 0px 4px  black;"> </div>
            </div>
            <div class="form-group row"><label class="col-2 col-form-label text-right text-dark" style="">Name 中文名称：</label>
              <div class="col-10 col-md-5" style=""><input type="text" class="form-control" id="namecn" name="namecn" required="required" style=" box-shadow: 0px 0px 4px  black;"></div>
            </div>
            <div class="form-group row"><label class="col-2 col-form-label text-right text-dark" style="">Description 描述：</label>
              <div class="col-10" style=""><textarea class="form-control" id="desc" name="desc" rows="3" style="    margin-top: 0px;    margin-bottom: 0px; height: 175px;  box-shadow: 0px 0px 4px  black;"></textarea></div>
            </div>
            <div class="form-group row"><label class="col-2 col-form-label text-right text-dark">Solution 解决方案：</label>
              <div class="col-10"><textarea class="form-control" id="sol" name="sol" rows="3" style=" margin-top: 0px;    margin-bottom: 0px; height: 179px;  box-shadow: 0px 0px 4px  black;"></textarea></div>
            </div>
            <div class="form-group row"><label class="col-2 col-form-label text-right text-dark" style="">密码：</label>
              <div class="col-10 col-md-5" style=""><input type="password" class="form-control" id="psw" name="psw" placeholder="password" style=" box-shadow: 0px 0px 4px  black;"></div>
              <button type="submit" class="btn ml-5 btn-success" style="">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 text-left py-1">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 w-100" style="transition: all 0.25s;">
          <div class="table-responsive" style="">
            <table class="table table-bordered ">
              <thead class="thead-dark">
                <tr>
                  <th class="">#</th>
                  <th>Plugin_ID</th>
                  <th>Name</th>
                  <th>Name_CN</th>
                  <th>Description</th>
                  <th>Solution</th>
                </tr>
              </thead>
              <tbody>
        <?php
// Get member rows
$result = $db->query("SELECT * FROM `trans`;");
if ($result->num_rows > 0) {
    $line_num = 1 + $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        $line_num-= 1;
?>
            <tr>
                <td><?php
        echo $line_num; ?></td>
                <td><?php
        echo $row['Plugin_ID']; ?></td>
                <td><?php
        echo $row['Name']; ?></td>
                <td><?php
        echo $row['Name_CN']; ?></td>
                <td><?php
        echo $row['Description']; ?></td>
                <td><?php
        echo $row['Solution']; ?></td>
            </tr>
            <?php
    }
} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </br></br></br></br></br></br>
 <div id="foot"></div>
  <script src="./js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="./js/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="./js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 
<!-- Show/hide CSV upload form -->
<script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>
</body>
</html>
