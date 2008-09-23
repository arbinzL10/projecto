<html>
<?php 
session_start(); 
include('functions_nico.php');
?>
<head>
</head>

<body>


<form action="recrutement.php" method="post">

	unite :<br>
		<?php $listbat=getListUnit();  affListUnit($listbat); ?>
	quantité:
		<input type ="text" name="nbunit">
		
<input type="submit" value="Construire" />
</form>

</body>
</html>