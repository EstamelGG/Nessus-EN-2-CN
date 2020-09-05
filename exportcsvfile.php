<?php 
// Load the database configuration file 
include_once 'dbconfig.php'; 
 
$filename = "nessus_CN_" . date('Y-m-d-H-i-s') . ".csv"; 
$delimiter = ","; 
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// Set column headers 
fwrite($f, chr(0xEF).chr(0xBB).chr(0xBF));//加入BOM头
$fields = array('Plugin ID', 'CVE', 'CVSS' , 'Risk' , 'Host' ,'Protocol','Port','Name','Synopsis','Description','Solution','See Also','Plugin Output'); 
fputcsv($f, $fields, $delimiter); 
 
// Get records from the database 
$result = $db->query("SELECT * FROM en ORDER BY risk asc"); 
if($result->num_rows > 0){ 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $result->fetch_assoc()){ 
        $lineData = array(
		$row['Plugin_ID'],
		$row['CVE'],
		$row['CVSS'],
		$row['Risk'],
		$row['Host'],
		$row['Protocol'],
		$row['Port'],
		$row['Name'],
		#iconv('utf-8', 'gbk',$row['Name']),
		$row['Synopsis'],
		$row['Description'],
		$row['Solution'],
		#iconv('utf-8', 'gbk',$row['Description']),
		#iconv('utf-8', 'gbk',$row['Solution']),
		$row['See_Also'],
		$row['Plugin_Output']); 
		
		fputcsv($f, $lineData, $delimiter); 
    } 
} 
 
// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Encoding: UTF-8');
header("Content-Type: text/csv; charset=UTF-8");
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
// Output all remaining data on a file pointer 
fpassthru($f); 
 
// Exit from file 
exit();
?>