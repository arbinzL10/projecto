<?php 
include('functions_nico.php');?>
<div id="batiment">
	<form action="construction.php" method="post">
	
		batiment :<br>
			<?php $listbat=getListBat();  affListBat($listbat); ?>
		quantité:
			<input type ="text" name="nbbat">
			
	<input type="submit" value="Construire" />
	</form>
</div>