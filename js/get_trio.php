<?php
/*	$url = 'http://iconosquare.com/feed/michaeltrio';
	$xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
	$output = array();
	foreach( $xml->channel->item as $item ){
		$string = $item->description;
		$output[] = substr( $string, strpos($string, 'src=') + 4, strpos($string, "'/>") -89 );
	}
	*/
	
$json = file_get_contents("https://api.instagram.com/v1/users/376272373/media/recent/?access_token=376272373.0a22db4.587b955095f443ed8a44fbb5317a48f7");
$data = json_decode($json);

// to get the array with all resolutions
$images = array();
foreach( $data->data as $user_data ) {
    $images[] = (array) $user_data->images;
}
// print_r( $images );

// to get the array with standard resolutions
$standard = array_map( function( $item ) {
    return $item['standard_resolution']->url;
}, $images );

foreach($standard as $item ){
		$output[] = $item;
	}
		
/*	$output[] = 'https://instagram.fdel1-1.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/13285306_1695501150715402_817260086_n.jpg?ig_cache_key=MTI2NDk4MzUyMzEyNTk1OTI4OA%3D%3D.2';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/13277603_626523924169023_793908659_n.jpg?ig_cache_key=MTI2NDM4NTEyNjEwMjgwMTE1MA%3D%3D.2';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/c135.0.810.810/13266940_1123282451025862_738295439_n.jpg?ig_cache_key=MTI2MzYzMDc2Mjk3OTQzMjgzMQ%3D%3D.2.c';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/c0.135.1080.1080/13277510_1776373905919379_1959279428_n.jpg?ig_cache_key=MTI2MjE1MTQ3NTgwNTg4Njg2NQ%3D%3D.2.c';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/e35/13257025_143902642680136_1635699205_n.jpg?ig_cache_key=MTI2MDgxMTM1ODY1MDU3MTA2Mw%3D%3D.2';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/13269389_836257629839764_1988995_n.jpg?ig_cache_key=MTI1OTI5OTY4MDk4OTU1MDYzNQ%3D%3D.2';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/c46.0.987.987/13260951_1147824421903517_1172420299_n.jpg?ig_cache_key=MTI1NzA1MjM2ODc3OTE1NjAwOA%3D%3D.2.c';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/s640x640/sh0.08/e35/c78.0.768.768/13256936_624211794393305_2042314620_n.jpg?ig_cache_key=MTI1NTU2NTA5NzAwOTc0ODgwNQ%3D%3D.2.c';
	$output[] = 'https://instagram.fdel1-2.fna.fbcdn.net/t51.2885-15/e35/13167454_1803600489861274_1231551951_n.jpg?ig_cache_key=MTI1NDI3NTEwODYzMjMzNjg4Mg%3D%3D.2';*/
	
	echo( json_encode($output)  );
?>