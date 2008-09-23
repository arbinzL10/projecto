<?php include('functions_nico.php'); ?>
<div id="caserne">
	<form action="recrutement.php" method="post">
	
		unite :<br>
			<?php $listbat=getListUnit();  affListUnit($listbat); ?>
		quantité:
			<input type ="text" name="nbunit">
			
	<input type="submit" value="Construire" />
	</form>
</div>
