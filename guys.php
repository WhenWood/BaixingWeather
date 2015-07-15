<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/14
 * Time: 15:59
 */
require_once "guys_action.php";
function add_guy($email,$name){
    $a_g = new guys_action();
    echo json_encode( $a_g ->addguy($email,$name) );
}
function del_guy($email){
    $d_g = new guys_action();
    echo json_encode($d_g->delguy($email));
}

function list_guy(){
    $l_g = new guys_action();
    echo json_encode( $l_g->listguys());

}
?>