<?php

require 'CloudMailRu.php';

function PublishFile($cloud,$local_file,$remote_file) {
	$url = $cloud->loadFileAhdPublish($local_file, $remote_file);
	return ($url !== "error")?"ссылка для скачивания: $url":"загрузка в облако не удалась";
}

function DownloadFile ($cloud,$remote_file,$local_file) {
	$result = $cloud->getFile($remote_file);
	if ($result) {
		file_put_contents($local_file,$result);
		return "Сохранено в $local_file";
	} else {
		return "Скачивание не удалось";
	}
}

$cloud = new CloudMailRu('user','password');
if ($cloud->login()) {
	echo PublishFile ($cloud,dirname(__FILE__).'/test_file.txt','/dir/test_file.txt');
	echo DownloadFile ($cloud,'/dir/test_file.txt',dirname(__FILE__).'/test_file_from_cloud.txt');
} else {
	echo 'не прошли авторизацию';
}

unset($cloud);
