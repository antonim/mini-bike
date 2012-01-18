<?php

include_once('db.php');
include_once('content/catalog.php');
$db = new dataBase();

if (isset($_GET['modelId'])) {
    $modelId = $_GET['modelId'];
    $modelData = $db->getModel($modelId);
    $photos = $db->getPhotoFromModel($modelId);
    $comments = $db->getComments($modelId);
} else {
    header('Location: index.php');
}

Content::getHeader($modelData['brand'] . ' ' . $modelData['model']);
Content::getPageProperty($modelData, $photos);
Content::getComments($comments, $modelData['id']);
Content::getFooter();