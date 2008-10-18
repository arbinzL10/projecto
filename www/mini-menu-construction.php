<?php @session_start();
	
if(isset($_POST['reload'])){
	include 'basic_functions.php';
}


if(isset($_POST['type_menu'])){
	echo " <script language='javascript'>
				document.getElementById('onglet_".$_POST['type_menu']."').style.backgroundColor='#0000CC';
			</script>";
}

if( isset($_POST['change_onglet']) or !isset($_POST['item_start']) && isset($_POST['type_menu']) ){
	if(substr($_POST['type_menu'],0,12)=='unit_control'){
		$sql="SELECT id_action,nom_action from ".substr($_POST['type_menu'],0,12)." WHERE ".substr($_POST['type_menu'],0,12).".id_unit=(SELECT id from unit WHERE unit.nom='".substr($_POST['type_menu'],13)."')";
		$_SESSION['map']['unitselected']['x']=$_POST['unit_x'];
		$_SESSION['map']['unitselected']['y']=$_POST['unit_y'];
	}
	else{
		$sql="SELECT id_".$_POST['type_menu'].",nom from dispo_".$_POST['type_menu'].",".$_POST['type_menu']." where dispo_".$_POST['type_menu'].".id_joueur=".$_SESSION['identify']['id']." and ".$_POST['type_menu'].".id=dispo_".$_POST['type_menu'].".id_".$_POST['type_menu'];
	}
	$data=exec_req($sql,0) or die($sql.' '.mysql_error());
	$req=mysql_query($sql);
	$item_count=mysql_num_rows($req);	
	
	foreach($data as $key => $value){
		if($value!=''){
			if($key==0){
				$var="sql_data[$key]'";
				$content=$value[key($value)]."'";
			}
			else{
				if($key==$item_count-1){
					$var=$var.",'sql_data[$key]";
					$content=$content.",'".$value[key($value)];
				}
				else{
					$var=$var.",'sql_data[$key]'";
					$content=$content.",'".$value[key($value)]."'";
				}
			}
		}
	}
	$_SESSION['item_start']=0;

}
if(isset($_POST['item_start']))
	$_SESSION['item_start']+=$_POST['item_start'];
if(isset($_POST['sql_data']))
	$data=$_POST['sql_data'];
if(isset($_POST['item_count']))
	$item_count=$_POST['item_count'];



if(isset($_POST['init']) && !isset($_POST['type_menu'])){
echo "	
		<div id='menu_construct_global'>";
}
if(isset($_POST['type_menu'])){
	if(isset($_POST['init']) ){
	
	echo "	<div id='div_onglet'>
				<div class='onglet' id='onglet_".$_POST['type_menu']."' onclick=\"HTTPReq(new Array('type_menu','reload','change_onglet'),new Array('".$_POST['type_menu']."','true','true'),'mini-menu-construction.php','construct')\" >
					<label>".$_POST['type_menu']."</label>
				</div>
				"./*<div class='onglet' id='onglet_unit' onclick=\"HTTPReq(new Array('type_menu','reload','change_onglet'),new Array('unit','true','true'),'mini-menu-construction.php','construct')\">
					<label>unités</label>
				</div>*/"
			</div>
			<div id='mini_menu_construct'>
			
			<div id='construct'>";
	}
	else
	{
		if($_SESSION['item_start']<0)
			$_SESSION['item_start']=0;
		if($_SESSION['item_start']>8 )
			$_SESSION['item_start']=8;
		//$item_count+=$_POST['item_start'];
		if($_SESSION['item_start']>=$item_count)
			$_SESSION['item_start']=$item_count-1;
	}
	
	//echo "item_start=".$_SESSION['item_start']."<br />item_count=$item_count";
	
	if(isset($_POST['sql_data'])){
		foreach($_POST['sql_data'] as $key => $value){
			if($value!=''){
				if($key==0){
					$var="sql_data[$key]'";
					$content=$value."'";
				}
				else{
					if($key==$item_count-1){
						$var=$var.",'sql_data[$key]";
						$content=$content.",'".$value;
					}
					else{
						$var=$var.",'sql_data[$key]'";
						$content=$content.",'".$value."'";
					}
				}
			}
		}
	}
	
	echo "
			<div id='miniflecheG' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheG-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheG-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."','type_menu'),new Array('-1','".$item_count."','".$content."','".$_POST['type_menu']."'),'mini-menu-construction.php','construct')\"> 
			</div>";
	for($i=$_SESSION['item_start'];($i<$item_count)and($i<9);$i++){
		if($_POST['type_menu']=='batiments')
			echo "	<div id='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."' class='construct_button' onclick=\"setHaloItem();\" onmouseover=\"selItem='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."';\" ></div>";
		if($_POST['type_menu']=='unit'){
			echo "	<div id='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."' class='construct_button' onclick=\"addUnit('".$data[$i]['id_'.$_POST['type_menu']]."',5000);\" ></div><div id='label_div_".$data[$i]['id_'.$_POST['type_menu']]."' class='label_div'></div>";
		}
		if(substr($_POST['type_menu'],0,12)=='unit_control'){
			echo "	<div id='unit_control_".$data[$i]['nom_action']."' class='construct_button' onclick=\"actionUnit('".$data[$i]['id_action']."');setHaloItem();\" onmouseover=\"selItem='unit_control_".$data[$i]['nom_action']."';\" ><label>".$data[$i]['nom_action']."</label></div>";
		}
	}
	
	echo "
			<div id='miniflecheD' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheD-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheD-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."','type_menu'),new Array('1','".$item_count."','".$content."','".$_POST['type_menu']."'),'mini-menu-construction.php','construct')\"> 
			</div>";
	
	if(isset($_POST['init'])){
	echo "	</div>
			</div>
		";
	}
}
if(isset($_POST['init']))
	echo "
</div>";
?>