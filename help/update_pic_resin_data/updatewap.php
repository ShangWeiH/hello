<?php
function help() {
	echo 'Usage: http://ido.sogou/update_pic_resin_data/updatewap.php?key=XXX';
}
if (!isset($_GET['key'])) {
	help();
	exit();
}
$module_conf = json_decode(file_get_contents('http://ido.sogou/ido_frontend/qianyi/newgetconf.php?product=pic&module=resin_picwap&type=host'), TRUE);
$resin_list = explode(',', $module_conf['online']);
$resin_list[] = $module_conf['pre'];
$error_list = array();
foreach ($resin_list as $resin) {
	$reload = file_get_contents('http://' . $resin . ':8081/pic/reload.jsp?key=' . $_GET['key']);
	if ($reload === FALSE) {
		$error_list[] = $resin;
		echo $resin . " reload failed!\n";
	} else {
		echo $resin . " reload ok.\n";
	}
}
if (count($error_list) > 0) {
	exit("some resin reload failed!\n");
}
?>
