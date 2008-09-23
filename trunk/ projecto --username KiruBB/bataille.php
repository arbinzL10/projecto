<?php	session_start(); 
include 'functions_nico.php'; ?>

<div id="bataille">
	<form action='baston.php' method='post'>
		cible :<br>
		<?php $listcible=getListCible(); affListCibles($listcible);?> <!-- affichage des cibles -->
		
	
		guerriers :<br>
		<INPUT type='text' name='guerrier'/>
		<?php $nbg=getNbUnit($_SESSION['id'], 2);   echo 'max '.$nbg;?> <!-- affichage du nombre max de guerriers -->
		<br>
			
		archers :<br>
		<INPUT type='text' name='archer'/>	
		<?php $nbg=getNbUnit($_SESSION['id'],3);   echo 'max '.$nbg;?>  <!-- affichage du nombre max de archers -->
		<br><br>
			
		<INPUT type='submit' value='attaquer' />
	</form>
</div>