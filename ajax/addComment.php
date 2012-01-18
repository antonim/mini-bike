<?php

include_once('../db.php');
include_once('../content/catalog.php');
$db = new dataBase();

if (isset($_REQUEST['comment']) && isset($_REQUEST['modelId'])) {

    if ($db->setComment($_REQUEST['modelId'], strip_tags($_REQUEST['name']), strip_tags($_REQUEST['comment']))){
        $comments = $db->getComments($_REQUEST['modelId']);
        echo Content::getBlockComments($comments);
    } else {
        echo 'error';
    }
}

