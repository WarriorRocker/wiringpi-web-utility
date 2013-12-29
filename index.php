<?php

require 'config.php';

$pins = Array(0, 1, 2, 3, 4, 5, 6, 7, 17, 18, 19, 20);

if ($_GET['c'] == 'pm') {
	wiringpi::pinMode($_GET['p'], $_GET['v']);
}

if ($_GET['c'] == 'dw') {
	wiringpi::digitalWrite($_GET['p'], $_GET['v']);
}

?>
<!doctype html>
<html>
<head>
	<title>WiringPi Web GPIO Utility</title>
	
	<meta name="HandheldFriendly" content="true" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<style type="text/css">
		html, body { background-color: #EEE; }
		
		h1 { font-size: 24px; }
		a { color: #000; }
		
		table {
			border-collapse: collapse;
			border-spacing: 0;
			font-size: 16px;
		}
		
		table thead tr {
			background: #a8a8a8; /* Old browsers */
			background: -moz-linear-gradient(top,  #dddddd 0%, #a8a8a8 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#dddddd), color-stop(100%,#a8a8a8)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #dddddd 0%,#a8a8a8 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #dddddd 0%,#a8a8a8 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #dddddd 0%,#a8a8a8 100%); /* IE10+ */
			background: linear-gradient(to bottom,  #dddddd 0%,#a8a8a8 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dddddd', endColorstr='#a8a8a8',GradientType=0 ); /* IE6-9 */
		}
	
		table tr.odd { background-color: #D5D5D5; }
		table tr td { padding: 7px; }
		
		table tr td.green { background-color: #51FF51; }
		table tr.odd td.green { background-color: #3FE93F; }
		table tr td.red { background-color: #FD7878; }
		table tr.odd td.red { background-color: #FF5A5A; }
		table tr td.blue { background-color: #A5A5FF; }
		table tr.odd td.blue { background-color: #8686FF; }
		table tr td.orange { background-color: #FDCF70; }
		table tr.odd td.orange { background-color: #FFC144; }
	</style>
</head>
<body>
	<h1>WiringPi GPIO Web Utility</h1>
	<table>
		<thead>
			<tr>
				<td>Pin</td>
				<td>GPIO</td>
				<td>Phys</td>
				<td>Name</td>
				<td>Mode</td>
				<td>Value</td>
			</tr>
		</thead>
		<tbody>
<?php

$even = false;
exec('gpio readall', $readall);
for ($i = 3; $i < (count($readall) - 1); $i++) {
	$row = explode('|', $readall[$i]);
	$pin = intval(trim($row[1]));
	if (in_array($pin, $pins)) {
		$mode = trim($row[5]);
		$value = trim($row[6]);
	
		echo '<tr class="'.(($even) ? 'even' : 'odd').'">';
		echo '<td>'.$pin.'</td>';
		echo '<td>'.trim($row[2]).'</td>';
		echo '<td>'.trim($row[3]).'</td>';
		echo '<td>'.trim($row[4]).'</td>';
		echo '<td class="'.(($mode == 'IN') ? 'orange' : 'blue').'"><a href="?c=pm&p='.$pin.'&v='.(($mode == 'IN') ? '1' : '0').'">'.$mode.'</a></td>';
		echo '<td class="'.(($value == 'High') ? 'green' : 'red').'"><a href="?c=dw&p='.$pin.'&v='.(($value == 'High') ? '0' : '1').'">'.$value.'</a></td>';
		echo '</tr>';
	
		$even = !$even;
	}
}

?>
		</tbody>
	</table>
	<p>Created by Travis Brown</p>
</body>
</html>
