<?php
// Load the database configuration file
include_once 'dbconfig.php';

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            // Parse data from CSV file line by line
			$prevQuery = "SELECT * FROM en";
			$prevResult = $db->query($prevQuery);
			if($prevResult->num_rows > 0){
                    // clear table
					echo "clear";
                    $db->query("truncate en");
                }
				
				while(($line = fgetcsv($csvFile)) !== FALSE){
					// Get row data
					//Plugin_ID	CVE	CVSS	Risk	Host	Protocol	Port	Name	Synopsis	Description	Solution	See_Also	
					//if($line[3]==="None"){continue;}
					$trans = $db->prepare("SELECT Name_CN,Description,Solution FROM trans WHERE Plugin_ID=(?)");
					$trans->bind_param('i', $line[0] );
					$trans->execute();
					$trans->bind_result($Name,$Description,$Solution);
					$trans->fetch();
					$trans->close();
					$trans='1';
					if(empty($Name)){
						$Name = htmlspecialchars($line[7]);
						$Description = htmlspecialchars($line[9]);
						$Solution = htmlspecialchars($line[10]);
						$trans='0';
					}
					$Plugin_ID = $line[0];
					$CVE  = $line[1];
					$CVSS  = $line[2];
					$Risk = $line[3];
					$Host = $line[4];
					$Protocol = $line[5];
					$Port = $line[6];
					$Synopsis = $line[8];
					$See_Also = $line[11];
					
					
					// Check whether member already exists in the database with the same email
					$prevQuery = "SELECT * FROM en";
					$prevResult = $db->query($prevQuery);
						
					// Insert member data in the database
					$stmt = $db->prepare("INSERT INTO en VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param('isssssissssss', htmlspecialchars($Plugin_ID), htmlspecialchars($CVE), htmlspecialchars($CVSS) , htmlspecialchars($Risk) , htmlspecialchars($Host) ,htmlspecialchars($Protocol),htmlspecialchars($Port),$Name,htmlspecialchars($Synopsis),$Description,$Solution,htmlspecialchars($See_Also),$trans );
					$stmt->execute();
					$stmt->close();
				}
				
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?actxs=succ';
        }else{
            $qstring = '?actxs=err';
        }
    }else{
        $qstring = '?actxs=invalid_file';
    }
}
 
// Redirect to the listing page
header("Location: index.php".$qstring);
?>