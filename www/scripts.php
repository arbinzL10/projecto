<SCRIPT language="JavaScript">
	var haloChateau=null;
	var haloChateauOld=null;
	var offsetMenuChateau=0;
	var haloHero=null;
	var haloHeroOld=null;
	var selItem=null;
	var selEffItem=null;
	var selItemOld=null;
	var oldRect=null;
	
	function menu(iddiv){
		menuEraseAll();
		var d=document.getElementById(iddiv);
		if(d)	{
			if(iddiv=='social'){
				d.innerHTML="<label>social</a><div id='accueil' onClick=\"loadPage('accueil.php','b_menu')\"><label id='s_menu_text'>accueil</label></div><div id='forum' onClick=\"loadPage('forum.php','b_menu')\"><label id='s_menu_text'>forum</label></div><div id='déconnexion' onClick=\"HTTPReq('deconexion',null,'déconnexion.php','<java>')\"><label id='s_menu_text'>déconnexion</label></div>";
			}
			if(iddiv=='cité'){
				d.innerHTML="<label>cité</label><div id='construire' onClick=\"loadPage('batiment.php','b_menu')\"><label id='s_menu_text'>construire</label></div><div id='recruté' onClick=\"loadPage('caserne.php','b_menu')\"><label id='s_menu_text'>recruté</label></div>";//<div id='déconnexion'><label id='s_menu_text'>déconnexion</label></div>";
			
			}
			/*if(iddiv=='map'){
				d.innerHTML="<a href='index.php?map'>map</a><div id='afficher' onClick='header('Location: index.php?map')><a id='s_menu_text'>afficher</a></div>";//<div id='recruté'><label id='s_menu_text'>recruté</label></div><div id='déconnexion'><label id='s_menu_text'>déconnexion</label></div>";
			
			}*/
		}
	}
	function menuErase(iddiv){
		var d=document.getElementById(iddiv);
		if(d)	d.innerHTML="<label onMouseOver=\"menu('"+iddiv+"')\">"+iddiv+"</label>";
	}
	function menuEraseAll(){
		menuErase('social');
		menuErase('cité');
		menuErase('map');
	}
	
	function insertBalisesById(id,content) {
		var balise=document.getElementById(id);
		balise.innerHTML=content;		
	}
	function setHaloChateau() {
		if(haloChateauOld!=null){
			document.getElementById(haloChateauOld).innerHTML='';
		}
		if(haloChateau!=null){
			var balise=document.getElementById(haloChateau);
			balise.innerHTML='<img style=\"margin-left:-5px;margin-top:-7px;\" src=\"images/encadrement.png\" />';
		}
		haloChateauOld=haloChateau;

	}
	function setHaloItem() {
		if(selItemOld!=null){
			document.getElementById(selItemOld).innerHTML='';
		}
		if(selItem!=null){
			var balise=document.getElementById(selItem);
			balise.innerHTML='<img src=\"images/encadrement-mini.png\" />';
		}
		selItemOld=selItem;
		selEffItem=selItem;

	}
	function setHaloHero(id) {
		if(document.getElementById(haloHeroOld))
			document.getElementById(haloHeroOld).innerHTML='';
		var balise=document.getElementById(haloHero);
		balise.innerHTML='<img style=\"margin-right:-5px;\" src=\"images/encadrement.png\" />';
	}
	
	function addBalisesById(where,content) {
		var balise=document.getElementById(where);
		balise.innerHTML+=content;
	}
	function insertPage(where,content){
		var balise=document.getElementById(where);
		var len=9999;
		var toInsert=content;
		if(document.getElementById('menuHero'))
			len=balise.innerHTML.indexOf('menuHero',0)-29;
		if(document.getElementById('menuChateau')){
			if(len>balise.innerHTML.indexOf('menuChateau',0)-29)
				len=balise.innerHTML.indexOf('menuChateau',0)-29;
		}
		var toInsert=new String();
		if(len==9999)
			toInsert=content;
		else
			toInsert=content+balise.innerHTML.substring(len);
		insertBalisesById(where,toInsert);
	}
	function removeBalisesById(where,content,id) {
		var balise=document.getElementById(where);
		var l1=balise.innerHTML.length;
		var l2=content.length;
		var toInsert1=new String();
		var toInsert2=new String();
		if(document.getElementById('menuChateau') && document.getElementById('menuHero')){
				toInsert1=balise.innerHTML.substring(0,balise.innerHTML.indexOf(id,0)-29);
				toInsert2=balise.innerHTML.substring(toInsert1.length-1+l2);
		}
		else
			var toInsert1=balise.innerHTML.substring(0,(l1-l2)+1);
		balise.innerHTML=toInsert1+toInsert2;
	}
	function mouseOnMap(x,y,id){
		if(oldRect!=null)
			document.getElementById(oldRect).style.border="none";
		oldRect=id;
		document.getElementById(id).style.border="2px solid blue";
	}
	function removeHTMLFrom(html,expression){
		var l1=html.length;
		var l2=content.length;
		var toInsert1=html.substring(0,(l1-l2)+1);
		var toInsert2=html.substring(l1+l2);
		return res=toInsert1+toInsert2;
	}
	function PHPinsertInBalisesById(id,content) {
		var balise=document.getElementById(id);
		balise.innerHTML="<?php "+content+"; ?>";		
	}
	function redirect(url){
	document.location=url;
	}
	function loadPage(url,where) {
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(url), true); 
		
		
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				insertPage(where,xhr_object.responseText);		
			}
		} 
		
		//xhr_object.setRequestHeader("Content-type", header); 
		xhr_object.send(null);
		//sendData('current_content='+iddiv, 'bataille.php', 'POST');
	}
	function execute(urlDuScript) {
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(urlDuScript), true); 
		
		
		xhr_object.onreadystatechange = function() { 
			
		} 
		
		//xhr_object.setRequestHeader("Content-type", header); 
		xhr_object.send(null);
		//sendData('current_content='+iddiv, 'bataille.php', 'POST');
	}
	function writePage(url) {
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(url), true); 
		
		
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				document.write(eval(xhr_object.responseText));		
			}
		} 
		
		//xhr_object.setRequestHeader("Content-type", header); 
		xhr_object.send(null);
		//sendData('current_content='+iddiv, 'bataille.php', 'POST');
	}
	function reloadSideMenu(url){
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(url), true); 
		
		
		
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				if(url='menuG.php'){
					insertBalisesById('menuChateau',xhr_object.responseText);	
				}
				if(url='menuD.php'){
					insertBalisesById('menuHero',xhr_object.responseText);				
				}
			}
		} 
		
		//xhr_object.setRequestHeader("Content-type", header); 
		xhr_object.send("offset="+offsetMenuChateau++);
	}
	function addSideMenu(url,where,idToInsert) {
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(url), true); 
		
		
		
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				if(document.getElementById(idToInsert)){
					removeBalisesById(where,xhr_object.responseText,idToInsert);	
				}
				else{
					addBalisesById(where,xhr_object.responseText);				
				}
			}
		} 
		
		//xhr_object.setRequestHeader("Content-type", header); 
		xhr_object.send(null);
		//sendData('current_content='+iddiv, 'bataille.php', 'POST');
	}
	
	function isArray(obj) {
		   if (obj.constructor.toString().indexOf("Array") == -1)
			  return false;
		   else
			  return true;
	}
	function HTTPReq(varToSend,id,url,where){
	/** 
	Utilisation:
		varToSend(nom de variable unique ou tableau de nom de variable que l'on aura dans $_POST[] exemple 'login' sera accessible dans $_POST['login'] sur la page executé sur le server. Pour envoyer plusieurs variable à la fois faire : new Array('login[0]','login[1'],...) accesible dans $_POST['login'][0]...)
		id( valeur que prendra la variables varToSend ( les variable si varToSend est un array, et dans ce cas la premiere valeur de id sera mises dans la premiere valeur du tableau varToSend etc...), peut prendre 3 formes: 
													   -null => la variable varToSend sera créer mais vide,
													   -n'importe que valeur ou tableau de valeur => ces valeurs seront attribuer dans l'ordre aux variable de 											varToSend,
													   -n'importe quelle id ou tabeau d'id existant => récupére la valeur d'un élément HTML et l'attribue à la variable correspondante de varToSend, à noter qu'il faut utiliser la syntaxe suivante 'id=monid' où monid correspond à l'idée de la balise HTML
		url( url de la page à executer sur le server)
		where( id de la balise dans laquelle insérer le résultat de la page )
		
		astuce : dans la page executer sur le server, tout les sorties ecran ( c'est à dire echo ) sera afficher telle qu'elle dans la page à l'endroit définie dans la variable where. 
	**/
		var var_to_send;
		for(i=0;i<varToSend.length;i++){
			if(i==0){
				if(id!=null){
					
					if(id[i].substr(0,3)=='id=')
						var_to_send=varToSend[i]+'='+document.getElementById(id[i].substring(3)).value;
					else
						var_to_send=varToSend[i]+'='+id[i];
					
				}
				else
					var_to_send=varToSend+'=null';
			}else{
				if(id!=null){
					
					if(id[i].substr(0,3)=='id=')
						var_to_send+='&'+varToSend[i]+'='+document.getElementById(id[i].substring(3)).value;
					else
						var_to_send+='&'+varToSend[i]+'='+id[i];
					
				}
				else
					var_to_send=varToSend+'=null';
			}
		}
		sendData(var_to_send,url,where);
	}/*function HTTPReq(varToSend,id,url,where){
	var var_to_send;
		for(i=0;i<varToSend.length;i++){
			if(i==0){
				if(id!=null)			
					var_to_send=varToSend[i]+'='+document.getElementById(id[i]).value;
				else
					var_to_send=varToSend+'=null';
			}else{
				if(id!=null)			
					var_to_send+='&'+varToSend[i]+'='+document.getElementById(id[i]).value;
				else
					var_to_send=varToSend+'=null';
				}
		}
		sendData(var_to_send,url,where);
	}*/
	function sendData(varToSend,url,where) {
		
		var xhr_object = null; 
	
			if(window.XMLHttpRequest) // Firefox 
			   xhr_object = new XMLHttpRequest(); 
			else	
				if(window.ActiveXObject) // Internet Explorer 
					xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
				else { // XMLHttpRequest non supporté par le navigateur 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				return; 
			} 
		xhr_object.open("POST", escape(url), true); 
		
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				if(where=='<java>')
					eval(xhr_object.responseText);
				if(where=='<cache>')
					document.write(xhr_object.responseText);
				else
					insertPage(where,xhr_object.responseText);
			}
		} 
		
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		
		xhr_object.send(varToSend);		
		
		//sendData('current_content='+iddiv, 'bataille.php', 'POST');
	}
	
	function verifData(input_id,label_input,var_to_send) {
	   if (document.getElementById(input_id).value.length > 0) {
			sendFormData(var_to_send+'='+ document.getElementById(input_id).value,label_input);
	   }
	   else {
			document.getElementById(label_input).innerHTML = '';
	   }
	}

	
	function sendFormData(var_to_send,where){
		if(window.XMLHttpRequest) // Firefox 
		   xhr_object = new XMLHttpRequest(); 
		else	
			if(window.ActiveXObject) // Internet Explorer 
				xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
			else { // XMLHttpRequest non supporté par le navigateur 
			   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		xhr_object.open("POST", "verif_data.php", true); 
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4){
				insertBalisesById(where,xhr_object.responseText);
			}
		}
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		xhr_object.send(var_to_send);
		
	}
	
	function clickOnMap(x,y){
		if(selItem==null)
			HTTPReq(new Array('coord[0]','coord[1]'),new Array('map_joueur',x,y),'building_inside.php','main');
			
		else{
			alert('batiment '+selItem+' construit aux coordonnées '+x+','+y);
			
			HTTPReq(new Array('option[0]','option[1]','type_map','item[0]','item[1]','item[2]'),new Array('building','force-reloading','map_joueur',selEffItem,x,y),'aff_map.php','tiles');
		}
		
	}

// essai infobulle

var IB=new Object;
var posX=0;posY=0;
var xOffset=10;yOffset=10;
function AffBulle(texte) {
  contenu="<TABLE border=0 cellspacing=0 cellpadding="+IB.NbPixel+"><TR bgcolor='"+IB.ColContour+"'><TD><TABLE border=0 cellpadding=2 cellspacing=0 bgcolor='"+IB.ColFond+"'><TR><TD><FONT size='-1' face='arial' color='"+IB.ColTexte+"'>"+texte+"</FONT></TD></TR></TABLE></TD></TR></TABLE>&nbsp;";
  var finalPosX=posX-xOffset;
  if (finalPosX<0) finalPosX=0;
  if (document.layers) {
    document.layers["bulle"].document.write(contenu);
    document.layers["bulle"].document.close();
    document.layers["bulle"].top=posY+yOffset;
    document.layers["bulle"].left=finalPosX;
    document.layers["bulle"].visibility="show";}
  if (document.all) {
    //var f=window.event;
    //doc=document.body.scrollTop;
    bulle.innerHTML=contenu;
    document.all["bulle"].style.top=posY+yOffset;
    document.all["bulle"].style.left=finalPosX;//f.x-xOffset;
    document.all["bulle"].style.visibility="visible";
  }
  //modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
  else if (document.getElementById) {
    document.getElementById("bulle").innerHTML=contenu;
    document.getElementById("bulle").style.top=posY+yOffset;
    document.getElementById("bulle").style.left=finalPosX;
    document.getElementById("bulle").style.visibility="visible";
  }
}
function getMousePos(e) {
  if (document.all) {
  posX=event.x+document.body.scrollLeft; //modifs CL 09/2001 - IE : regrouper l'évènement
  posY=event.y+document.body.scrollTop;
  }
  else {
  posX=e.pageX; //modifs CL 09/2001 - NS6 : celui-ci ne supporte pas e.x et e.y
  posY=e.pageY; 
  }
}
function HideBulle() {
	if (document.layers) {document.layers["bulle"].visibility="hide";}
	if (document.all) {document.all["bulle"].style.visibility="hidden";}
	else if (document.getElementById){document.getElementById("bulle").style.visibility="hidden";}
}

function InitBulle(ColTexte,ColFond,ColContour,NbPixel) {
	IB.ColTexte=ColTexte;IB.ColFond=ColFond;IB.ColContour=ColContour;IB.NbPixel=NbPixel;
	if (document.layers) {
		window.captureEvents(Event.MOUSEMOVE);window.onMouseMove=getMousePos;
		document.write("<LAYER name='bulle' top=0 left=0 visibility='hide'></LAYER>");
	}
	if (document.all) {
		document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
		document.onmousemove=getMousePos;
	}
	//modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
	else if (document.getElementById) {
	        document.onmousemove=getMousePos;
	        document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
	}

}

</script>