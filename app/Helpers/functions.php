<?php
function array_ids($arr,$id_field='id'){
    $ids=[];
    foreach ($arr as $v){
        $ids[]=$v[$id_field];
    }
    return $ids;
}

function array_options($arr,$value_field='name',$key_field='id'){
    $options=[];
    foreach ($arr as $v){
        $ids[$key_field]=$v[$value_field];
    }
    return $options;
}