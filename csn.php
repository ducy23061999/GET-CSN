<?php
/*
>_ Code By Gre Y Sac
Link: https://www.facebook.com/Tranducy1999
*/
require "simple_html_dom.php";
$curren_url = "http://localhost/csn/csn.php" ;// url point to this source code. Config fist to use.

$skey = $_GET['s'];
$data = getinfo($skey);
$link = getlinkdownload($skey);
$html = file_get_html($link);
$html_download = $html->find("#downloadlink2 a");
$type = array();
$download = array();
$i = 0;
foreach ($html_download as $key) {
	$cut =  explode("[",$key->href);
	$cut = explode("]",$cut[1])[0];
	$type[$i] = $cut ;
	$download[$i] = str_replace(" ","",$key->href);
	$i++;
};
echo var_dump($download);
if (isset($_GET['s']) && !isset($_GET['type'])) {
	$skey = str_replace(" ","+",$_GET['s']);
	$js_arr = array (
	  'messages' => 
	  array (
	    0 => 
	    array (
	      'attachment' => 
	      array (
	        'type' => 'template',
	        'payload' => 
	        array (
	          'template_type' => 'button',
	          'text' => 'Bài Hát: '.$data['name'].'. Trình bày: '.$data['singer'],
	          'buttons' => 
	          array (
	            0 => 
	            array (
	              'type' => 'json_plugin_url',
	              'url' => $curren_url."?s=".$skey."&type=".$type[0],
	              'title' => $type[0],
	            ),
	            1 => 
	            array (
	              'type' => 'json_plugin_url',
	              'url' => $curren_url."?s=".$skey."&type=".$type[1],
	              'title' => $type[1],
	            ),
	            2 => 
	            array (
	              'type' => 'json_plugin_url',
	              'url' => $curren_url."?s=".$skey."&type=".$type[3],
	              'title' => $type[3],
	            ),
	          ),
	        ),
	      ),
	    ),
	  ),
	);

	$js_en = json_encode($js_arr);
	echo $js_en;

}

if (isset($_GET['type']) && isset($_GET['s'])) {
	$_type = $_GET['type'];
	switch ($_type) {
		case $type[0]:
			$mess_arr = array (
		  		'messages' => 
		  		array (
		   		 0 => 
		    		array (
		      		'text' =>$download[0],
		    		),
		  		),
			);
			break;
		case $type[1]:
			$mess_arr = array (
		  		'messages' => 
		  		array (
		   		 0 => 
		    		array (
		      		'text' =>$download[1],
		    		),
		  		),
			);
			break;
		case $type[3]:
			$mess_arr = array (
		  		'messages' => 
		  		array (
		   		 0 => 
		    		array (
		      		'text' =>$download[3],
		    		),
		  		),
			);
			break;
	};
	echo json_encode($mess_arr);
}
function getlinkdownload($string){
    $skey = str_replace(" ","+",$string);
    $url_search = "http://search.chiasenhac.vn/search.php?s=".$skey;
    $html = file_get_html($url_search);
    $e = $html->find(".tenbh p a");
    $url_link =  explode(".",$e[0]->attr['href']);
    $url_download =  $url_link[0].".".$url_link[1].".".$url_link[2]."_download.html";
    return $url_download;
}
function getinfo($string){
    $data = array();
    $skey = str_replace(" ","+",$string);
    $url_search = "http://search.chiasenhac.vn/search.php?s=".$skey;
    $html = file_get_html($url_search);
    $a = $html->find(".tenbh p a",0);
    $b = $html->find(".tenbh p",1);
    $data['name'] = $a->innertext;
    $data['singer'] = $b->innertext;
    return $data;
    
}
?>

