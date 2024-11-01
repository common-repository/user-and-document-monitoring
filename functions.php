<?php

class rep_database{

public function options($parameter){
global $wpdb;
$default_role = $wpdb->get_var($wpdb->prepare("SELECT $parameter FROM ".$wpdb->prefix."rep_options"));

return $default_role;


    }



}


class users{


      public function get_uID($id){
global $wpdb;
$uID = $wpdb->get_var($wpdb->prepare("SELECT uID FROM ".$wpdb->prefix."rep_user where pID = $id"));

return $uID;


    }
}
?>