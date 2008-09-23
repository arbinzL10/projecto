<?php @session_start();


if(!isset($_POST['item_start'])){
	$sql="SELECT id_batiment from dispo_bat where id_joueur=".$_SESSION['identify']['id'];
	$data=@exec_req($sql,0);
	$req=mysql_query($sql);
	$item_count=mysql_num_rows($req);	
	foreach($data as $key => $value){
		if($value!=''){
			if($key==0){
				$var="sql_data[$key]'";
				$content=$data[$key]['id_batiment']."'";
			}
			else{
				if($key==$item_count-1){
					$var=$var.",'sql_data[$key]";
					$content=$content.",'".$data[$key]['id_batiment'];
				}
				else{
					$var=$var.",'sql_data[$key]'";
					$content=$content.",'".$data[$key]['id_batiment']."'";
				}
			}
		}
	}
	
	$_SESSION['item_start']=0;
	echo " <div id='mini_menu_construct'>";
echo "	<div id='miniflecheG' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheG-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheG-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."'),new Array('-1','".$item_count."','".$content."'),'mini-menu-construction.php','construct')\"> 
		</div>
		<div id='construct'>";
}
else
{
	$data=$_POST['sql_data'];
	$item_count=$_POST['item_count'];
	$_SESSION['item_start']+=$_POST['item_start'];
	
	if($_SESSION['item_start']<0)
		$_SESSION['item_start']=0;
	if($_SESSION['item_start']>8 )
		$_SESSION['item_start']=8;
	if($_SESSION['item_start']>$item_count-1)
		$_SESSION['item_start']=$item_count-1;
}
for($i=$_SESSION['item_start'];($i<$item_count)and($i<9);$i++){
	echo "		
				<div id='bat_".$data[$i]['id_batiment']."' class='construct_button' onclick=\"setHaloItem();\" onmouseover=\"selItem='bat_".$data[$i]['id_batiment']."';\" > 
				</div>";
}

if(!isset($_POST['item_start'])){
echo "	</div>
		<div id='miniflecheD' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheD-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheD-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."'),new Array('1','".$item_count."','".$content."'),'mini-menu-construction.php','construct')\"> 
		</div>";
echo " </div>";
}
?>