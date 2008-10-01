<?php @session_start();

if(isset($_POST['reload'])){
	include 'basic_functions.php';
}

if(isset($_POST['type_menu'])){
	echo " <script language='javascript'>
				document.getElementById('onglet_".$_POST['type_menu']."').style.backgroundColor='#0000CC';
			</script>";
}


if(!isset($_POST['item_start'])){
	$sql="SELECT id_".$_POST['type_menu']." from dispo_".$_POST['type_menu']." where id_joueur=".$_SESSION['identify']['id'];
	$data=exec_req($sql,0) or die($sql.' '.mysql_error());
	$req=mysql_query($sql);
	$item_count=mysql_num_rows($req);	
	foreach($data as $key => $value){
		if($value!=''){
			if($key==0){
				$var="sql_data[$key]'";
				$content=$data[$key]['id_'.$_POST['type_menu']]."'";
			}
			else{
				if($key==$item_count-1){
					$var=$var.",'sql_data[$key]";
					$content=$content.",'".$data[$key]['id_'.$_POST['type_menu']];
				}
				else{
					$var=$var.",'sql_data[$key]'";
					$content=$content.",'".$data[$key]['id_'.$_POST['type_menu']]."'";
				}
			}
		}
	}
	
	$_SESSION['item_start']=0;
	
	if(isset($_POST['init'])){
echo "	
		<div id='menu_construct_global'>";
echo "	<div id='div_onglet'>
			<div class='onglet' id='onglet_batiments' onclick=\"HTTPReq(new Array('type_menu','reload'),new Array('batiments','null'),'mini-menu-construction.php','construct')\" >
				<label>batiments</label>
			</div>
			<div class='onglet' id='onglet_unit' onclick=\"HTTPReq(new Array('type_menu','reload'),new Array('unit','null'),'mini-menu-construction.php','construct')\">
				<label>unités</label>
			</div>
		</div>
		<div id='mini_menu_construct'>
		<div id='miniflecheG' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheG-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheG-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."'),new Array('-1','".$item_count."','".$content."'),'mini-menu-construction.php','construct')\"> 
		</div>
		<div id='construct'>";
	}
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
	if($_POST['type_menu']=='batiments')
		echo "	<div id='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."' class='construct_button' onclick=\"setHaloItem();\" onmouseover=\"selItem='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."';\" ></div>";
	if($_POST['type_menu']=='unit'){
		echo "	<div id='".$_POST['type_menu']."_".$data[$i]['id_'.$_POST['type_menu']]."' class='construct_button' onclick=\"addUnit('".$data[$i]['id_'.$_POST['type_menu']]."',5000);\" ></div><div id='label_div_".$data[$i]['id_'.$_POST['type_menu']]."' class='label_div'></div>";
	}
}

if(isset($_POST['init'])){
echo "	</div>
		<div id='miniflecheD' class='construct_button' onMouseOut=\"this.style.backgroundImage='url(images/flecheD-mini.png)'\" onmouseover=\"this.style.backgroundImage='url(images/flecheD-mini2.png)';\" onclick=\"HTTPReq(new Array('item_start','item_count','".$var."'),new Array('1','".$item_count."','".$content."'),'mini-menu-construction.php','construct')\"> 
		</div>";
echo " </div>
		</div>";
}
?>