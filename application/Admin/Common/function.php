<?php
function getChildren($id,$table,$field){
    $lanmus=M($table)->where("parent_id={$id}")->select();
    if($lanmus>0)
    {
		$lanmeArray=array();
        foreach($lanmus as $lanmu){
            $children = getChildren($table,$lanmu['id']);
			$array = array("id"=>$lanmu['id'],"text"=>$lanmu[$field],children=>$children);
			array_push($lanmeArray, $array);
        }
		return $lanmeArray;
    }
}
