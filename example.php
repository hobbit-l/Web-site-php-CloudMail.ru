<?php

require 'CloudMailRu.php';

/**
 * @param CloudMailRu $cloud
 * @param string $local_file
 * @param string $remote_file
 * @return string
 */
function PublishFile($cloud, $local_file, $remote_file) {
	$url = $cloud->loadFileAhdPublish($local_file, $remote_file);
	return ($url !== "error")?"ссылка для скачивания: $url":"загрузка в облако не удалась";
}

/**
 * @param CloudMailRu $cloud
 * @param string $remote_file
 * @param $local_file
 * @return string string
 */
function DownloadFile ($cloud, $remote_file, $local_file) {
	$result = $cloud->getFile($remote_file);
	if ($result) {
		file_put_contents($local_file,$result);
		return "Сохранено в $local_file";
	} else {
		return "Скачивание не удалось";
	}
}

$cloud = new CloudMailRu('user','password'/*,'domain = 'mail.ru''*/);
if ($cloud->login()) {
	echo PublishFile ($cloud,dirname(__FILE__).'/test_file.txt','test_file.txt');
	echo DownloadFile ($cloud,'/test_file.txt',dirname(__FILE__).'/test_file_from_cloud.txt');
} else {
	echo 'не прошли авторизацию';
}

unset($cloud);
