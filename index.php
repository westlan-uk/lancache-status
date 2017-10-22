<?php

require_once 'lanCacheStatusFunctions.php';

echo '<h1>Lan Cache Status</h1>';
echo '<link rel = "stylesheet" href = "style.css" />';

echo '<table>';
foreach (getStatus() as $stat) {
	if (empty($stat['description'])) {
		$stat['description'] = null;
	}

	echo '<tr>';
	echo '<td valign = "top">' . $stat['name'] . '</td><td>' . $stat['value'] . '</td><td>' . $stat['description']. '</td>';
	echo '</tr>';
}
echo '</table>';

?>
