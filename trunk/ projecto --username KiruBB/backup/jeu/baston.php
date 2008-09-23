<?php session_start();
include('functions_nico.php');

//================================================= VERIF Nb Unités envoyées / Nb Unités max ======================================================
$nbg = $_POST['guerrier'];
$nba = $_POST['archer'];
$nbg = VerifNbUnit($_SESSION['id'],2, $nbg);//test nb Guerriers
$nba = VerifNbUnit($_SESSION['id'],3, $nba);//test nb Archers
$nbg2 = getNbUnit($_POST['cible'],2);
$nba2 = getNbUnit($_POST['cible'],3);



//########################################    COMBAT    ##########################################

$stats1=getstats(2);
$stats2=getstats(3);

echo $stats1['nom']."s ==> Att : ".(int)$stats1['attaque']." portee : ".(int)$stats1['portee']." pv : ".(int)$stats1['pv']."<br>";
echo $stats2['nom']."s ===> Att : ".(int)$stats2['attaque']." portee : ".(int)$stats2['portee']." pv : ".(int)$stats2['pv']."<br><br>";	

$powerG1 = getpuissoffensive($nbg, 2);
$HPG1 = getHP($nbg, 2);
$powerA1 = getpuissoffensive($nba, 3);
$HPA1 = getHP($nba, 3);

$powerG2 = getpuissoffensive($nbg2, 2);
$HPG2 = getHP($nbg2, 2);
$powerA2 = getpuissoffensive($nba2, 3);
$HPA2 = getHP($nba2, 3);;


echo "defenseur : ".$nbg2." guerriers et ".$nba2." archers<br>";
echo "defenseur : guerriers : ".$powerG2." PO et ".$HPG2." HP<br>";
echo "----------- : archersss : ".$powerA2." PO et ".$HPA2." HP<br><br>";

echo "attaquants : ".$nbg." guerriers et ".$nba." archers<br>";;
echo "attaquant : guerriers : ".$powerG1." PO et ".$HPG1." HP<br>";
echo "----------- : archersss : ".$powerA1." PO et ".$HPA1." HP<br><br>";
?>