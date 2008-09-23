<html>
<?php 
session_start(); 
include('functions_nico.php');
?>
<head>
</head>

<body>


<form action="construction.php" method="post">

	batiment :<br>
		<?php $listbat=getListBat();  affListBat($listbat); ?>
	quantité:
		<input type ="text" name="nbbat">
		
<input type="submit" value="Construire" />
</form>

</body>
</html>