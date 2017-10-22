<?php

function bytesToHuman($bytes) {
	$si_prefix = array('B', 'KB', 'MB', 'GB', 'TB');
	$base = 1024;

	$class = min((int)log($bytes, $base), count($si_prefix) -1);

	return number_format($bytes / pow($base, $class), 2) . $si_prefix[$class];
}

function isProcessRunning($prog) {
	exec("pgrep $prog", $pids);

	if (empty($pids)) {
		return 'false';
	} else {
		return 'true';
	}
}

function getStatus() {
	return array(
		array( 
			'name' => 'disk_total_space',
			'value' => bytesToHuman(disk_total_space("/srv/lancache")),
		),
		array( 
			'name' => 'disk_free_space',
			'value' => bytesToHuman(disk_free_space("/srv/lancache")),
		),
		array( 
			'name' => 'disk_available_percent',
			'value' => number_format(100 - ((disk_free_space("/srv/lancache") / disk_total_space("/srv/lancache")) * 100), 2),
		),
		array( 
			'name' => 'requests_HIT',
			'value' => number_format(trim(`grep HIT /srv/lancache/logs/Keys/steam.log | wc -l `)),
			'description' =>  'Number of requests that we served from the cache',
		),
		array(
			'name' => 'requests_MISS',
			'value' => number_format(trim(`grep MISS /srv/lancache/logs/Keys/steam.log | wc -l `)),
			'description' =>  'Number of requests that we went to the internet for'
		),
		array(
			'name' => 'sniproxy_running',
			'value' => isProcessRunning('sniproxy'),
		),
		array( 
			'name' => 'nginx_running',
			'value' => isProcessRunning('nginx'),
		),
		array( 
			'name' => 'disk_used_space',
			'value' => nl2br(`tac disk_used `),
		),

	);
}

?>
