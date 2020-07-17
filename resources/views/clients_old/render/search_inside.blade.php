<?php 
// echo "<pre>";
// print_r($arr_result);
// die();

foreach ($arr_result as $key => $value) {
	 //echo "<pre>";	
	 //print_r($value);
	$fileurl = url('clients/file/render/'.$value['fileid'].'/'.$value['pageno']);
	$fileimg = url('public/images/file-pdf-icon_32.png');
	// if($key == 0){
	echo '<a href="'.$fileurl.'" style="color:#5f5c61;font-size:x-large;"><img src="'.$fileimg.'"><strong style="margin-left:20px;">'.ucfirst($value['filename']).'</strong></a>';

		// echo "<h4>Filename : ".$value['filename']."</h4>";
	// }
	for ($i=0; $i < count($value['text']); $i++) {
		echo "<p>".$value['text'][$i]."</p>";
		echo "<hr>";
	}
}
?>
	
