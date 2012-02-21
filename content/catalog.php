<?php
class Content
{

    public $_accords = Array(
        'model'                     => 'Модель',
        'yearOfIssuance'            => 'Год начала выпуска',
        'length'                    => 'Длина',
        'height'                    => 'Высота',
        'base'                      => 'База',
        'engine	'                   => 'Объем двигателя',
        'diameterAndPistonStroke'   => 'Диаметр и ход поршня',
        'countCycleOfEngine'        => 'Тактность двигателя',
        'coolingType'               => 'Тип охлаждения',
        'maxPower'                  => 'Максимальная мощность',
        'torque	'                   => 'Крутящий момент',
        'fuelTankCapacity'          => 'Объем бензобака',
        'oilTankCapacity'           => 'Объем маслобака',
        'fuelConsumption'           => 'Расход топлива',
        'transmissionType'          => 'Тип трансмиссии',
        'brakeType'                 => 'Тип тормозов',
        'brakeTypeFront'            => 'Тип переднего тормоза',
        'brakeTypeRear'             => 'Тип заднего тормоза',
        'weight'                    => 'Масса',
        'frontWheelSize'            => 'Размер переднего колеса',
        'rearWheelSize'             => 'Размер заднего колеса',
        'maximumSpeed'              => 'Максимальная скорость',
        'thePresenceOfCatalyst'     => 'Наличие катализатора',
        'theVolumeOfOilInTheEngine' => 'Объем масла в двигателе',
    );

    static public $_filtersYear = Array('До 1990', '1990-1995', '1995-2000', '2000-2005', '2005-2009', '2010 и выше');
    static public $_filtersEngine = Array('До 50см<span class="sup">3</span>', '50-125 см<span class="sup">3</span>', '125 см<span class="sup">3</span> и выше');
    static public $_filtersModel = Array('Adly', 'Alfamoto', 'Aprilia', 'Benelli', 'Beta', 'Cpi', 'Daelim', 'Defiant', 'Derbi', 'G-max', 'Gilera', 'Honda', 'Italjet', 'Kymco', 'Malaguti', 'Peugeot', 'Piaggio', 'Skymoto', 'Suzuki', 'Vespa', 'Yamaha');



    static function getCatalogListHtml($catalogList) {

        ob_start();
        ?>
        <div class="cat_products_table">
            <table >
                <tbody>

                    <?php
                        $i = 0;
                        foreach($catalogList as $item) {
                            
                        if (file_exists('../img/prev/' . $item['photoId'] . '.jpg')) {
                            $itemImage = 'img/prev/' . $item['photoId'] . '.jpg';
                        } else {
                            $itemImage = 'img/noimage_small.jpg';
                        }
                        $i++;
                    ?>
                    <tr>

                        <td class="ill">
                            <img class = "a" onclick='window.location.href = "page.php?modelId=" + <?php echo $item['id']?>' alt="<?php echo $item['brand'] . ' ' . $item['model']?>" src="<?=$itemImage?>"/>
                        </td>
                        <td class="main"><h2><a href="page.php?modelId=<?php echo $item['id']?>"><?php
                            echo $item['brand'] . ' ' . $item['model']
                        ?></a></h2>
                        <p>
                        <?php
                            $str = '';
                            foreach($item as $key => $element) {
                                switch ($key) {
                                    case 'yearOfIssuance':
                                      if ($element)
                                      $str .= 'год выпуска: ' . $element . '; ';
                                      break;
                                    case 'engine':
                                      if ($element)
                                      $str .= 'oбъем двигателя: ' . $element . 'см<span class="sup">3</span>; ';
                                      break;
                                    case 'fuelConsumption':
                                      if ($element)
                                      $str .= 'расход: ' . $element . '; ';
                                      break;
                                    case 'maxPower':
                                      if ($element)
                                      $str .= 'мощность: ' . $element . '; ';
                                      break;
                                    case 'weight':
                                      if ($element)
                                      $str .= 'вес: ' . $element . '; ';
                                      break;
                                    case 'fuelTankCapacity':
                                      if ($element)
                                      $str .= 'объем бензобака: ' . $element . '; ';
                                      break;
                                }
                            }
                            $str = substr($str, 0, -2);
                            echo $str;
                        ?>
                        </p></td>

                    </tr>
                    <?php } ?>

                </tbody>
            </table>
            <div class="mask"></div>
        </div>

        <?php
        $output = ob_get_clean();
        return $output;
    }

    static function getHeader($title = 'Каталог мототехники мопедов мотоциклов максискутеров скутеров', $keywords = '')
    {
        ?><!DOCTYPE html>
    <html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="description" content="<?php if($title != 'Каталог мототехники мопедов мотоциклов максискутеров скутеров') echo 'Технические характеристики '; echo $title?>" />
                <meta name="keywords" content="<?php if(!$keywords) $keywords = $title; echo $keywords?>" />

                <script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
                <script type="text/javascript" src="/js/jquery.form.js"></script>
                <script type="text/javascript" src="/js/jquery.validate.js"></script>
                
                <script type="text/javascript" src="/js/script.js"></script>
                <title><?php echo $title?></title>
                <link type="text/css" rel="stylesheet" href="/css/index.css" />
                
                
                <script type="text/javascript">

                  var _gaq = _gaq || [];
                  _gaq.push(['_setAccount', 'UA-21067552-1']);
                  _gaq.push(['_trackPageview']);

                  (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                  })();

                </script>
        </head>
        
        <div></div>
        <div class = "page">
            <div class = "mainHeader" onclick = 'window.location.href = "/"'>
                <h1>КАТАЛОГ МОТОТЕХНИКИ</h1>
                <h3>На этом портале вы сможете найти модельные ряды самых популярных производителей мототехники</h3>
            </div>
        <?php
    }

    

    static function getFooter()
    {
        ?>
        </div>
        <div id = "footer">
            <p>&copy; Mini Bike, 2006-2011</p>
        </div>
        
    </html>
        <?php
    }
    
    
    static function getFilterPanel($modelsList)
    {
        ?>

    <div style="float: left; width: 250px; margin-bottom: 20px;">

        <div class="filters changed" style="display:none">
            <div class="nameCategoryFilter">
                    <h3>Выбранные фильтры</h3>
            </div>

            <div style="display: none">
                <h4 class="brand" >Марка</h4>
                <?php foreach (Content::$_filtersModel as $key => $value) {
                    ?><p style="display: none"><a href="javascript: void(0);" rel="<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>
                <p style="margin-top: 12px;"></p>
            </div>

            <div style="display: none">
                <h4 class="engine" >Объем двигателя</h4>
                <?php foreach (Content::$_filtersEngine as $key => $value) {
                    ?><p style="display: none"><a href="javascript: void(0);" rel="<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>
                <p style="margin-top: 12px;"></p>
            </div>

            <div style="display: none">
                <h4 class="year" >Год начала выпуска</h4>

                <?php foreach (Content::$_filtersYear as $key => $value) {
                    ?><p style="display: none"><a href="javascript: void(0);" rel="<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>

                <p style="margin-top: 12px;"></p>
            </div>


        </div>
        <div class="filters forChange">
            <div class="nameCategoryFilter">
                <h3>Фильтры для выбора</h3>
            </div>

            <div>
                <h4 class="brand">Марка</h4>
               <?php foreach (Content::$_filtersModel as $key => $value) {
                    ?><p><a href="?filterType=brand&amp;filter=<?php echo $key ?>" rel="<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>
                <p style="margin-top: 12px;"></p>
            </div>

            <div>
                <h4 class="engine">Объем двигателя</h4>
                <?php foreach (Content::$_filtersEngine as $key => $value) {
                    ?><p><a href="?filterType=engine&amp;filter=<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>
                <p style="margin-top: 12px;"></p>
            </div>

            <div>
                <h4 class="year">Год начала выпуска</h4>
                <?php foreach (Content::$_filtersYear as $key => $value) {
                    ?><p><a href="?filterType=year&amp;filter=<?php echo $key ?>"><?php echo $value; ?></a></p><?php
                } ?>
                <p style="margin-top: 12px;"></p>
            </div>

        </div>
    </div>

        <?php
    }

    static function getPaginator($count = 100, $selected = 1)
    {

        ob_start();
        ?>

        <div class = "paginator">
            
            <div class="ltem last cont">
            
            <?php if ($selected > 1) { ?>
                <a class="prev" href="?page=<?php echo $selected-1; ?>" value="<?php echo $selected-1; ?>">&larr; Назад</a>
            <?php } 

                $start = 1;
                if ($count >= 9 && $selected > 5) {
                    $start = $selected - 4;
                }
                
                for ($i = $start; $i <= $start + 8; $i++) {

                    if ($count > $i) {
                        if ((int)$i == (int)$selected) {
                        ?> <span><?php echo $i; ?></span><?php
                        } else {
                        ?> <a href="?page=<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></a><?php
                        }
                    }
                }
                
                if ($count-2 >= $selected) {
                    ?> <a class="next" href="?page=<?php echo $selected+1; ?>" value="<?php echo $selected+1; ?>">Вперед &rarr;</a> <?php
                }
                
            ?> 
        </div></div>
        <?php
        $output = ob_get_clean();
        return $output;
    }

    static function notResult()
    {
        ob_start();
        ?>
            <div class = "paginator">
                <h3>по вашему запросу ничего не найдено</h3>
            </div>
        <?php
        $output = ob_get_clean();
        return $output;
    }

    static function getPageProperty($modelData, $photos)
    {
        $content = new Content();

        $filtersModel = Content::$_filtersModel;
        foreach ($filtersModel as $key => $value) {
            if ($value == $modelData['brand']) {
                $parceLinksId = $key;
            }
        }
                
        if (file_exists('img/photo/' . $modelData['id'] . '.jpg')) {
            $itemImage = 'img/photo/' . $modelData['id'] . '.jpg';
        } else {
            $itemImage = 'img/noimage.jpg';
        }
        
        if (!empty($modelData['brakeTypeRear'])) {
            foreach ($modelData as $key => $value) {
                if ($key == 'brakeType') {
                    $tmp['brakeTypeFront'] = $value;
                } else {
                    $tmp[$key] = $value;
                }    
            }
            $modelData = $tmp;
        }
        
        
        ?>
        <div class = "contentPage">
            <div class="driver"><a href="index.php#brand_<?php echo $parceLinksId ?>/"><?php echo $modelData['brand']?></a> -> <?php echo $modelData['model']?></div>
            
            <div class="photo" ><img src="<?=$itemImage?>" /></div>
            <table class="tx_full">
                <tbody>
                    <tr>
                        <th colspan="2"><h3>Технические характеристики</h3></th>
                    </tr>
                    <?php foreach($modelData as $key => $property) {
                        if ($property && !empty($content->_accords[$key])) {?>
                    <tr>
                        <td class="op"><?php echo $content->_accords[$key]?></td>
                        <td><?php if($key == 'model') echo $modelData['brand'] . ' '; echo $property?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>

       
        <?php
    }

    static function getComments($comments, $modelId)
    {
        ?>
            <div id = "comments">

                <a class ="addComment" href="javascript: void(0);">Добавить свой комментарий</a>
                <div class = "addCommentForm">
                    <form id ="commentForm" action="ajax/addComment.php?modelId=<?php echo $modelId?>" method="post">
                        <p>Ваше имя:</p>
                        <input name="name" class="required" minlength="2"/>
                        <label for="userName"></label>
                        <p>Комментарий: </p>
                        <textarea name= "comment" class="required" minlength="5"></textarea><br/>
                        <input type = "submit" value = "Отправить"/>
                    </form>
                </div>

                <div class="comment">
                    <?php echo Content::getBlockComments($comments)?>
                </div>
            </div>

            <div class = "line"></div>
        <?php
    }

    static function getBlockComments($comments)
    {
        ob_start();
        foreach($comments as $comment) {?>

            <div class="headerComment">
                <div class="name">
                    <!--<span class="small">комментирует: </span>-->
                    <span class="userName"><?php echo $comment['name']?></span> <span class="small">(<?php echo $comment['create']?>)</span>
                </div>
                
                <!--<div class="date small">
                    <?php
                    //setlocale(LC_ALL, 'RUS').': ';
                    //echo iconv('windows-1251', 'UTF-8', strftime('%A %d %B %Y', $comment['create']));
                    echo $comment['create']?>
                </div>--><br/>
            </div>
            <p class="userComment"><?php echo $comment['comment']?></p>
        <div class = "thickLine"></div>
        <?php }
        $output = ob_get_clean();
        return $output;
    }

    static function searchBlock()
    {
        ?>
            <div class = "search">
                <label class="searchLabel">Поиск:</label>
                <input class="searchString"/>
                <input class="searchButton" type="button" value="искать"/>
            </div>
        <?php
    }

}