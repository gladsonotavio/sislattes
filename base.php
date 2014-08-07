<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/lattes.css" />
</head>
<body>
<?php include 'layout/corpo.php';?>
<?php include 'layout/topo.php';?>
<?php include 'layout/box_center.php';?>

<div id="conteudo">
<hr>
<form method="post" action="validar.php"  enctype="multipart/form-data">
<input type="file" name="arquivo" ><br><br>
<input type="submit" value="Enviar">
<input type="reset" value="Apagar">
</form>
<hr>

</div>


</body>
</html>
