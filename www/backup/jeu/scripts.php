<script language="javascript">
	function menu(iddiv){
		menuEraseAll();
		var d=document.getElementById(iddiv);
		if(d)	d.innerHTML="<label>"+iddiv+"</label><div id='"+iddiv+"_1'><label id='s_menu_text'>"+iddiv+"_1</label></div><div id='"+iddiv+"_2'><label id='s_menu_text'>"+iddiv+"_2</label></div><div id='"+iddiv+"_3'><label id='s_menu_text'>"+iddiv+"_3</label></div>";
	}
	function menuErase(iddiv){
		
		var d=document.getElementById(iddiv);
		if(d)	d.innerHTML="<label>"+iddiv+"</label>";
	}
	function menuEraseAll(){
		menuErase('menu_jeu1');
		menuErase('menu_jeu2');
		menuErase('menu_jeu3');
	}
	function insertTextById(id,content) {
		var balise=document.getElementById(id);
		balise.innerHTML=content;		
	}
	function insertBalisesById(id,content) {
		var balise=document.getElementById(id);
		balise.innerHTML=content;		
	}
</script>