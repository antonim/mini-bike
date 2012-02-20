<?php

include_once('../db.php');
include_once('../content/catalog.php');
include_once('../query.php');
$db = new dataBase();


if (isset($_REQUEST['filters'])) {
    $filters = $_REQUEST['filters'];
} else {
    $filters = '';
}

$where = Query::getWhereByFilters($filters);

$catalogList = $db->getCatalogList($where, $_REQUEST['page']);
$lastCount = $db->lastCount;

if ($lastCount['count'] > 0) {

    $content = Content::getCatalogListHtml($catalogList);

    $result = Array('content' => $content);

    $pageCount = ceil($lastCount['count'] / 10) + 1;

    $result['paginator'] = Content::getPaginator($pageCount, $_REQUEST['page']);
} else {

    $content = Content::getCatalogListHtml($catalogList);
    $result = Array('content' => $content);

    $result['paginator'] = Content::notResult();
}

echo json_encode($result);
//}

