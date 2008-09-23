<script language="javascript">
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
				insertBalisesById(where,xhr_object.responseText);
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
						var_to_send=varToSend[i]+'='+id[i];
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
				if(where=='<java>'){
					eval(xhr_object.responseText);
				}
				else{
					insertBalisesById(where,xhr_object.responseText);
				}
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



</script>