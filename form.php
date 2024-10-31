<html>

<head>

<?
	$theme_url = "modularity-lite";
	$stylesheet_url = "../../themes/".$theme_url."/style.css"
?>
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet_url; ?>" />

<style>
	body{
		background: none;
	}
</style>

<script type="text/javascript">

function picFormReady(){
	var pic_cd = window.top.document;

	var pic_cf = pic_cd.getElementById("commentform");

	var string_function = "(this.pic_img)?this.comment.value=this.comment.value+this.pic_img.value:alert('Ha ocurrido un error y la imagen no será añadida. Si puedes editar tu comentario, pega este trozo de código: '+this.pic_img.value);"

	pic_cf.setAttribute("onsubmit", string_function);
	
}

function disabledTopForm(){
	var pic_cd = window.top.document;

	var pic_cs = pic_cd.getElementById("submit");
	
	pic_cs.setAttribute("disabled",true);

}

function onUpload(){
	disabledTopForm();
	document.upload.submit();
	document.upload.style.display = "none";
	document.loading.style.display = "block";
}

</script>


</head>

<body onload="picFormReady()">

<form id="upload" name="upload" enctype="multipart/form-data" action="api.php" method="POST">

	<p>
		<label for="userfile">Adjuntar imagen al comentario: <label>
		<input id="userfile" name="userfile" type="file" onchange="onUpload()" />
	</p>

</form>
<p id="loading" style="display: none">Cargando imagen...</p>

</body>
