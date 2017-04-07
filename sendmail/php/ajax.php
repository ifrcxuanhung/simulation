<?php

if (is_file("../config.php")) {
    require_once("../config.php");
}
require_once("functions.php");
require_once("class.newsletter.php");
require_once("database.php");

$db = db_connect();
$news = new newsletter;
$all_members = $news->get_members_all($db, false, false, false);

$count = 1;
$page = $_REQUEST['page']; 
$limit = $_REQUEST['rows']; 
$sidx = $_REQUEST['sidx'];
if( $count > 0 && $limit > 0) { 
	  $total_pages = ceil($count/$limit); 
} else { 
	  $total_pages = 0; 
} 
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit;
$row = array();
//print_R($all_members);exit;
while ($member = mysql_fetch_assoc($all_members)) {
	$row[] = $member;	
}
//echo "<pre>";print_r($row);exit;
$data = array('records'=>$count,'page'=>$page,'total'=>$total_pages,'rows'=>$row);
echo json_encode($data);