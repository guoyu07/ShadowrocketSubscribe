<?php
require_once("lib/FileSystemCache.php");

// 二维码解码url
$qring = 'http://qring.org/decode?url=';

// FreeSS 的二维码节点
$freess_url = array(
    'jp01' => 'https://freess.cx/images/servers/jp01.png',
    'jp02' => 'https://freess.cx/images/servers/jp02.png',
    'jp03' => 'https://freess.cx/images/servers/jp03.png',
    'us01' => 'https://freess.cx/images/servers/us01.png',
    'us02' => 'https://freess.cx/images/servers/us02.png',
    'us03' => 'https://freess.cx/images/servers/us03.png',
);

// 设置缓存KEY
$cache_key = FileSystemCache::generateCacheKey('subscribe');

// 获取缓存
$subscribe = FileSystemCache::retrieve($cache_key);

if($subscribe === false){// 缓存不存在则重新获取节点
	foreach($freess_url as $key=>$url){
		$jsontext = get_url_content($qring . $url, "http://qring.org/d");     // 拼装url并用 qring.org 解码二维码
		$json = json_decode($jsontext, true);
		if($json && $json['errCode'] == 0){
			$freess[$key] = $json['data']['text'];
			$subscribe .= $freess[$key] . '#FreeSS - ' . $key . chr(10); // 拼接成订阅的原始数据格式 文档： https://github.com/ssrbackup/shadowsocks-rss/wiki/Subscribe-%E6%9C%8D%E5%8A%A1%E5%99%A8%E8%AE%A2%E9%98%85%E6%8E%A5%E5%8F%A3%E6%96%87%E6%A1%A3
		}
	}
    $subscribe = substr($subscribe, 0, -1); // 最后一条删除换行符
	FileSystemCache::store($cache_key, $subscribe, 1800);   // 缓存数据(有效期半小时)
}


if(!empty($subscribe)){
	echo base64_encode($subscribe);     // 输出订阅的数据
}

/*
* 抓取页面内容
*/
function get_url_content($url, $referer="") {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ch = curl_init();
    $timeout = 5;
    $urlarr     = parse_url($url);
    if($urlarr["scheme"] == "https") {	//判断URL是否为https类型
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    }
    curl_setopt ($ch, CURLOPT_URL, $url);
    if($referer!="") curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    $file_contents = curl_exec($ch);
    curl_close($ch);
	return $file_contents;
}