<?php
function help() {
	echo 'Usage: http://ido.sogou/update_pic_resin_data/updateris.php?fname=XXX';
}
if (!isset($_GET['fname'])) {
	help();
	exit();
}
$module_conf = json_decode(file_get_contents('http://ido.sogou/ido_frontend/qianyi/newgetconf.php?product=riscbir&module=resin_ris&type=host'), TRUE);
$resin_list = explode(',', $module_conf['online']);
#$resin_list[] = $module_conf['pre'];
$error_list = array();
foreach ($resin_list as $resin) {
	$reload = file_get_contents('http://' . $resin . ':8080/ris/load.jsp?fname=' . $_GET['fname']);
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
