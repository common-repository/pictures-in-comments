<?php

	if( $_FILES['userfile']['name']=="" ){
		header("Location:form.php");
	}else{
	
		include_once("config.php");
		
		include_once("functions.php");
		
?>
<html>

<head>


<?
	
	$stylesheet_url = "../../themes/".$theme_url."/style.css"
?>
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet_url; ?>" />

<style>
	body{
		/* Quitamos imágenes de fondo */
		background: none;
	}
</style>

</head>

<body>

<?	
	if( $upload_box == "imgur" )
		imgur_upload();
	else
		owner_upload();		
?>
		
</body>
</html>

<?
}
?>
