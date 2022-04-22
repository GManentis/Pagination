<?php 

if( !empty($_POST["page"]) && !empty($_POST["items"]) )
{
	    (int)$choice = $_POST["page"];
		
		$hostname_DB = "127.0.0.1";
		$database_DB = "projectword";
		$username_DB = "root";
		$password_DB = "";

		try 
		{
			$CONNPDO = new PDO("mysql:host=".$hostname_DB.";dbname=".$database_DB.";charset=UTF8", $username_DB, $password_DB, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3));
		} 
		catch (PDOException $e) 
		{
			$CONNPDO = null;
		}
		if ($CONNPDO != null) 
		{    
	        $response = "<center><table  border=\"2\"><tr><th>Id</th><th>Word</th></tr>";
		    
			(int)$pValues = $_POST["items"]; 
			
			if($choice == 1){
				
			(int)$from = 0;	
				
			}
			else
			{
				
			(int)$from = (($choice*$pValues - $pValues)) ;
				
			}
			
			(int)$to = $pValues ; 
		  
			/*Rules that apply on pagiantion in general
			- If we want results to be sorted by a column/field, we must ensure that the value of the field is unique else duplicated 
			entries may occur in our pagination.
			- If we want to paginate entries sorted by column without unique values, we must include also a column/field with unique value.
			For example: if we want results to be ordered by a field named priority in Ascended order and that field contains not unique values 
			in each column, then a second unique column is mandatory for the duplicate bug not to occur.The query in our example should be like
			this:
			
			"SELECT id,word FROM vocabulary ORDER BY priority, id LIMIT :from, :to"
			
			- (Cuurent example case)In case we want pagination unordered, we do not have to use ORDER BY although using we still can sort by a unique column.
			In short in line 51, since we do not care about the sorting, the ORDER BY can be considered optional
			*/							
			$getdata_PRST = $CONNPDO->prepare("SELECT id,word FROM vocabulary ORDER BY id LIMIT :from , :to ");
			$getdata_PRST->bindValue(":from", $from, PDO::PARAM_INT);
			$getdata_PRST->bindValue(":to",$to ,PDO::PARAM_INT);
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
			{
				$sId = $getdata_RSLT["id"];
				$sWord = $getdata_RSLT["word"];
				$response .= "<tr><td>$sId</td><td>$sWord</td></tr>";
				
			}
			$response .= "</table>" ; 
			
			$getdata_PRST = $CONNPDO->prepare("SELECT COUNT(id) AS Number FROM vocabulary  ");
			$getdata_PRST->execute() or die($CONNPDO->errorInfo());
			while($getdata_RSLT = $getdata_PRST->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
			{
				$sNumber = $getdata_RSLT["Number"];
			}
			
			$sNumber2 = ($sNumber /$pValues );
			$sNumber3 = ceil($sNumber2);
			$response .="<br><br><br>";
			
			
			for($x = 1 ; $x <= $sNumber3 ; $x++)
			{
				if($x != $choice)
				{
				  $response .= "<span style=\"cursor:pointer;\"  onclick= \"Paz($x,$pValues);\" >$x</span>&nbsp;";
				
				}else
				{
				  $response .= "<span style=\"background-color:red;color:pink;cursor:pointer;\"  onclick= \"Paz($x,$pValues);\" >$x</span>&nbsp;";
				}
				
			}

		$response .= "</center>";
			
		
		 echo $response;
		
		}
		else
		{
			echo "No PDO connection";
		
		}
}
else
{
	echo "A fatal error occured";
	
			
}	      
	

?>
