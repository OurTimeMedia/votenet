<html>
<link href="sdk.css" rel="stylesheet" type="text/css"/>
  <table class="api" width=400>
	        	<?php 
				if (count($resArray)>0) {
    		foreach($resArray as $key => $value) {
    			
    			echo "<tr><td> $key:</td><td>$value</td>";
    			}	
				}
       			?>
  </table>
</html>