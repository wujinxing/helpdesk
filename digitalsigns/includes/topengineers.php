<h3> Top Engineers</h3>
<table>
<tr>
	<th>Engineer Name</th>
	<th>30 Days</th>
	<th>7 Days</th>
	<th>24 Hours</th>
</tr>
<?php

	include_once('../includes/functions.php');

	if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
	};



	$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers ".$whereenginners." GROUP BY engineerName ORDER BY Last30 DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>

<tr>
	<td><?=$loop['engineerName'];?></td>
	<td><?=$loop['Last30'];?></td>
	<td><?=$loop['Last7'];?></td>
	<td><?=$loop['Last1'];?></td>
</tr>
<?	} ?>
</table>