<?php
session_start();

plusCourtChemin(new noeud(1,1,1,NULL),new noeud(4,4,1,NULL),$_SESSION['map']['desc'],$_SESSION['map']['width']);

//$map doit comporter ['compo'],['passthru']
function plusCourtChemin($noeudDepart,$noeudArrive,$map,$mapWidth){
	
	$closedList=new chemin($noeudDepart,$noeudArrive,$map,$mapWidth);
	$tempOpenList=$closedList->getOpenList();
	$temp=$noeudDepart;
	while($temp!=$noeudArrive && !empty($tempOpenList) ){
		//$temp->toString()." <br />";
		$temp=$closedList->getBetterNodeAround($noeudArrive);
		$tempOpenList=$closedList->getOpenList();
		//print_r($closedList->getOpenList());
		//echo "<br />";

	}
	foreach($closedList->getAll() as $value)
		$value->toString();
	
	return serialize($closedList->toArray());
}


class chemin{
	
	var $noeuds;
	var $coutTotal;
	var $openList;
	var $map;
	var $mapWidth;
	var $choosenNode;


	
	function chemin($noeudDep,$noeudArr,$map,$mapWidth){
		$this->noeuds=array($noeudDep);
		$this->coutTotal+=$noeudDep->getCout();
		$this->openList=array();
		$this->map=$map;
		$this->mapWidth=$mapWidth;
		$this->choosenNode=$noeudDep;
		$this->updateOpenList($noeudDep);
		/*
		while( $noeudDep.getX()!=key($map['compo']%$mapWidth && $noeudDep.getY()!=bcdiv(key($map['compo']),$mapWidth) )
			each($map['compo']);
		foreach($map as $key => $value){
			if($noeudDep.getX()
			$this->openList.add(new noeud($key%$mapWidth,bcdiv($key,$mapWidth),(($map[$key]['passthru']+1)%2)+1));
		}*/
	}
	
	function updateOpenList($noeud){
		$temp=0;
		reset($this->map);
		while( $temp%$this->mapWidth!=$noeud->getX() || bcdiv($temp,$this->mapWidth)!=$noeud->getY() ){
			$temp=each($this->map);
			$temp=$temp['key'];
			//echo $temp." ".$temp%$this->mapWidth."!=".$noeud->getX()." ".bcdiv($temp,$this->mapWidth)."!=".$noeud->getY()."<br />";
		}
		//echo "blabla";
		for($i=0;$i<3;$i++){
			if($temp-21+$i>0){
				$cout=$this->map[$temp-21+$i]['passthru'];
				if($noeud!=NULL)
					$cout+=$noeud->getCout();
				$tempNode=new noeud(($temp-21+$i)%$this->mapWidth,bcdiv(($temp-21+$i),$this->mapWidth),$cout,$noeud);
				$alreadyIn=false;
				foreach($this->openList as $value){
					
					if($tempNode->compare($value))
						$alreadyIn=true;
				}
				if(!$alreadyIn){
					foreach($this->noeuds as $value2){
						if($value2->compare($tempNode))
							$alreadyIn=true;
					}
				}
				if(!$alreadyIn)
					$this->openList[]=$tempNode;	
			}
			
			if($temp+19+$i<400){
				$cout=$this->map[$temp+19+$i]['passthru'];
				if($noeud!=NULL)
					$cout+=$noeud->getCout();				
				$tempNode=new noeud(($temp+19+$i)%$this->mapWidth,bcdiv(($temp+19+$i),$this->mapWidth),$cout,$noeud);
				$alreadyIn=false;
				foreach($this->openList as $value){
					
					if($tempNode->compare($value))
						$alreadyIn=true;
				}
				if(!$alreadyIn){
					foreach($this->noeuds as $value2){
						if($value2->compare($tempNode))
							$alreadyIn=true;
					}
				}
				if(!$alreadyIn)
					$this->openList[]=$tempNode;
				}

		}
		if($temp-1>0){
			$cout=$this->map[$temp-1]['passthru'];
			if($noeud!=NULL)
				$cout+=$noeud->getCout();
			$tempNode=new noeud(($temp-1)%$this->mapWidth,bcdiv(($temp-1),$this->mapWidth),$cout,$noeud);
		}
		if($temp+1<400){
			$cout=$this->map[$temp+1]['passthru'];
			if($noeud!=NULL)
				$cout+=$noeud->getCout();
			$tempNode2=new noeud(($temp+1)%$this->mapWidth,bcdiv(($temp+1),$this->mapWidth),$cout,$noeud);
		}
		$alreadyIn=false;
		$alreadyIn2=false;
		
		foreach($this->openList as $value){
			if($tempNode->compare($value) && $temp-1>0)
				$alreadyIn=true;
			if($tempNode2->compare($value) && $temp+1<400)
				$alreadyIn2=true;
		}
		if(!$alreadyIn){
			foreach($this->noeuds as $value2){
				if($value2->compare($tempNode))
					$alreadyIn=true;
				if($value2->compare($tempNode2))
					$alreadyIn2=true;
			}
		}
		if(!$alreadyIn)
			$this->openList[]=$tempNode;
		if(!$alreadyIn2)
			$this->openList[]=$tempNode2;
	}
	
	function getOpenList(){
		return $this->openList;
	}
	
	function add($newNoeud){
		if(in_array($newNoeud,$this->noeuds)){
			$key=array_search($newNoeud,$this->noeuds);
			reset($this->noeuds);
			$cur=each($this->noeuds);
			while($cur['key']!=$key){ 
				$cur=each($this->noeuds);
			}
			$value=each($this->noeuds);
			while($value!=NULL){
				
				$this->noeuds[$key]->setCout($this->noeuds[$key]->getCout()+$value['value']->getCout());
				$temp=key($this->noeuds);
				unset($temp);
				$value=each($this->noeuds);
			}
		}
		else
		{
			$this->noeuds[]=$newNoeud;
			$this->coutTotal+=$newNoeud->getCout();
		}
	}
	
	function pop($noeud){
		$key=array_search($noeud,$this->openList);
		unset($this->openList[$key]);
	}
	
	function getLast(){
		if(empty($this->noeuds))
			return NULL;
		$value=end($this->noeuds);
		return $value;
	}
	
	function getAll(){
		return $this->noeuds;
	}
	
	function getBetterNodeAround($noeudArrive){
		/*if(!in_array($noeudDepart,$this->noeuds))
			return NULL;*/
		$temp=$this->choosenNode;
		$temp2=array();
		$temp3=300;
		unset($temp2);
		foreach($this->openList as $value){
			if($value->getCout() <= $temp3){
				$temp2[]=$value;
				$temp3=$value->getCout();
			}
			if($value->getCout() < $temp3){
				unset($temp2);
				$temp2[]=$value;
				$temp3=$value->getCout();
			}
			
			
		}
		//print_r($temp2)."<br />";
			$temp=$temp2[key($temp2)];
		foreach($temp2 as $value){
			$value->toString();
			if($value->getDistance($noeudArrive) <= $temp->getDistance($noeudArrive) ){
				$temp=$value;
				
			}
		}
		echo "<br /><br />";
		$this->choosenNode=$temp;
		$this->pop($this->choosenNode);
		$this->add($this->choosenNode);
		
			
		$this->updateOpenList($this->choosenNode);
		return $this->choosenNode;		
	}
	
	function toArray(){
		foreach($this->noeuds as $key => $value){
			if($value!='')
				$temp[]=$value->toArray();
		}
		return $temp;
	}
					
}




class noeud{

	var $x;
	var $y;
	var $cout;
	var $parent;
	
	function noeud($newx,$newy,$newcout,$parent){
		$this->x=$newx;
		$this->y=$newy;
		$this->cout=$newcout;
		$this->parent=$parent;
	}
	function getX(){
		return $this->x;
	}
	function getY(){
		return $this->y;
	}
	function getCout(){
		return $this->cout;
	}
	function getParent(){
		return $this->parent;
	}
	function setCout($newCout){
		$this->cout=$newCout;
	}
	
	function getDistance($noeud2){
		return sqrt( pow($noeud2->getX()-$this->x,2)+pow($noeud2->getY()-$this->y,2));
	}
	
	function compare($noeud2){
		if($noeud2->getX()==$this->x && $noeud2->getY()==$this->getY())
			return true;
		return false;
	}
	
	function toArray(){
		return array("x" => $this->x, "y" => $this->y, "cout" => $this->cout, "parent" => $this->parent);
	}
	
	function toString(){
		echo "[noeud] x=".$this->x." y=".$this->y." cout=".$this->cout."<br />";
	}
}

?>