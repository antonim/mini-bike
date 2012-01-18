<?php

include_once('db.php');
include_once('content/catalog.php');

$db = new dataBase();
$modelsList = $db->getModelsList();

$page = 1;
if (isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
}

$title = '';
if(isset($_REQUEST['filter']) && isset($_REQUEST['filterType'])) {
    $filters[$_REQUEST['filterType']] = $_REQUEST['filter'];

    switch ($_REQUEST['filterType']) {
        case 'brand':
            $title = Content::$_filtersModel[$_REQUEST['filter']];
            break;
        case 'engine':
            $title = 'Cписок мототехники с объемом двигателя ' . strip_tags(Content::$_filtersEngine[$_REQUEST['filter']]);
            break;
        case 'year':
            $title = 'Список мототехники с годом выпуска ' . Content::$_filtersYear[$_REQUEST['filter']];
            break;
    }
    $limit = 100;
}

$thisPage = $_SERVER['REQUEST_URI'];
$catalogList = $db->getCatalogList('', $page);
$count = $db->lastCount;
$pageCount = ceil($count['count'] / 10) + 1;

Content::getHeader($title);
//if (!empty($limit)) {
    $paginator = Content::getPaginator($pageCount, $page);
//}
//echo $paginator;
Content::getFilterPanel($modelsList);

Content::searchBlock();
            ?>
            <div class="catalog">
                <?php
echo Content::getCatalogListHtml($catalogList);
                ?>
            </div>
            

            <?php
echo $paginator;
Content::getFooter();