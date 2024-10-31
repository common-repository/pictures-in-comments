<?php


function imgur_upload(){
	$api_key = "2138fd83af378494c359e1ba0a1e78ac";
	//$file = getcwd() . '/' . basename( $_FILES['userfile']['name']);
	$file = sys_get_temp_dir() . '/' . basename( $_FILES['userfile']['name']);
	move_uploaded_file($_FILES['userfile']['tmp_name'], $file);
	list($width, $height, $file_type) = getimagesize($file);
	
	if ($file_type == 3) {
		$image = imagecreatefrompng($file);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		ob_start();
		imagepng($image);
		$data =  ob_get_contents();
		ob_end_clean();
	}
	
	if ($file_type == 2) {
		$image = imagecreatefromjpeg($file);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		ob_start();
		imagejpeg($image);
		$data =  ob_get_contents();
		ob_end_clean();
	}
	
	if ($file_type == 1) {
		$image = imagecreatefromgif($file);
		imagealphablending($image, false);
		imagesavealpha($image, true);
		ob_start();
		imagegif($image);
		$data =  ob_get_contents();
		ob_end_clean();
	}
	
    $pvars   = array('image' => base64_encode($data), 'key' => $api_key);
    $timeout = 30;
    $curl    = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'http://imgur.com/api/upload.xml');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

    $xml_raw = curl_exec($curl);
    curl_close ($curl);
    unlink($file);
	
    $xml = new SimpleXMLElement($xml_raw);
	
	if ($xml->error_code != '') {
		$imgur_error_code = $xml->error_code;
		$imgur_error_msg = $xml->error_msg;
		
		settype($imgur_error_code, "string");
		settype($imgur_error_msg, "string");
		
		echo "<a href='javascript:history.back(1)'>Atrás</a><p>Error #" . $imgur_error_code . ", " . $imgur_error_msg . "</p>";
	}else {
		imagedestroy($image);
		$imgur_original = $xml->original_image;
		$imgur_large_tbn = $xml->large_thumbnail;
		$imgur_small_tbn = $xml->small_thumbnail;
		$imgur_image_hash = $xml->image_hash;
		$imgur_delete_hash = $xml->delete_hash;
		$imgur_page = $xml->imgur_page;
		$img_delete_page = $xml->delete_page;
		
		settype($imgur_original, "string");
		settype($imgur_large_tbn, "string");
		settype($imgur_small_tbn, "string");
		
	?>
	<img src="<?php echo $imgur_small_tbn; ?>" />
	<p><a href="<?php echo $img_delete_page; ?>" target="_blank" onclick="location.replace('form.php')">Borrar</a><p>
	
	
	<script type="text/javascript">
		
		var pic_cd = window.top.document;

		var pic_cf = pic_cd.getElementById("commentform");
		
		var pic_input = pic_cd.createElement('input');
		
		pic_input.setAttribute("id", "pic_img" );
		pic_input.setAttribute("name", "pic_img" );
		pic_input.setAttribute("type", "hidden" );
		pic_input.setAttribute("value", "<br /><img src='<?php echo $imgur_original; ?>' width='100%' /><input type='hidden' value='<?php echo $img_delete_page; ?>' />" );
		
		pic_cf.appendChild(pic_input);
		
		
		var pic_cs = pic_cd.getElementById("submit");
	
		pic_cs.removeAttribute("disabled");

		
	</script>
	
	<?php
}


function owner_upload(){

}

?>
