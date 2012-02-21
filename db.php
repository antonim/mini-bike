<?php

class dataBase
{

    public $lastCount = 0;
    
    function __construct() 
    {       
        if ($connect = @mysql_connect('localhost', 'root', '123')) {
            mysql_select_db('p18516_mini_bike', $connect);
        } elseif ($connect = @mysql_connect('localhost', 'root', '')) {
            mysql_select_db('mini_bike', $connect);
        } else {
            $connect = mysql_connect('p18516.mysql.ihc.ru', 'p18516_mini_bike', 'vbyb,fqr');
            mysql_select_db('p18516_mini_bike', $connect);
        }
        mysql_query ('SET NAMES UTF8');            
    }
    
    function fetchAll($sql)
    {
        $result = mysql_query($sql);
        
        if($result) {
            $arr = array();
            while ($row = mysql_fetch_assoc($result)) {
                $arr[] = $row;
            }
            return $arr;
        }
        
        throw new Exception('Error sql:' . $sql);
    }

    function fetchRow($sql)
    {
        $result = mysql_query($sql);

        if($result) {
            $arr = array();
            if ($row = mysql_fetch_assoc($result)) {
                return $row;
            }
        }

        throw new Exception('Error sql:' . $sql);
    }

    function getModelsList()
    {
        $sql = '
            SELECT model, count(id) as `count`
            FROM parce_links
            GROUP BY model
            ORDER BY model';
        return $this->fetchAll($sql);
    }
    
    function getCatalogList($where = '', $offset = 1, $filters = false, $limit = 10)
    {

        if ($filters && is_array($filters) && empty($where)) {
            require_once('query.php');
            $filters = Array($filters);
            $where = Query::getWhereByFilters($filters);
            $limit = 1000;
        }

        $sql = '
            SELECT model_properies.*, model_properies.parceLinksId AS photoId, parce_links.model as brand
            FROM model_properies
                JOIN parce_links
                    ON model_properies.parceLinksId = parce_links.id
--                JOIN parsing_data
--                    ON parsing_data.parce_links_id = model_properies.id AND parsing_data.title = "photo"
                ' . $where . '
            GROUP BY model_properies.id
            ORDER BY model_properies.id DESC
            LIMIT ' . $limit . ' OFFSET ' . ((int)$offset - 1) * 10;

        $sqlCount = '
            SELECT count(t.id) as count
            FROM (
                SELECT model_properies.parceLinksId as id
                FROM model_properies
                JOIN parce_links
                    ON model_properies.parceLinksId = parce_links.id
--                JOIN parsing_data
--                    ON parsing_data.parce_links_id = model_properies.id -- AND parsing_data.title = "photo"
                 ' . $where . '
                GROUP BY model_properies.id
            ) AS t';

        $this->lastCount = $this->fetchRow($sqlCount);

        return $this->fetchAll($sql);
    }

    function getModel($modelId)
    {
        $sql = '
            SELECT model_properies.*, parce_links.model AS brand
            FROM model_properies
                JOIN parce_links
                    ON model_properies.parceLinksId = parce_links.id
            WHERE model_properies.id = ' . (int)$modelId ;

        return $this->fetchRow($sql);
    }

    function getPhotoFromModel($modelId)
    {
        $sql = '
            SELECT parsing_data.id AS photoId
            FROM model_properies
                JOIN parsing_data
                    ON parsing_data.parce_links_id = model_properies.id AND parsing_data.title = "photo"

            WHERE model_properies.id = ' . (int)$modelId ;

        return $this->fetchAll($sql);
    }

    function getComments($modelId)
    {
        $sql = '
            SELECT *
            FROM comments
            WHERE model_property_id = ' . (int)$modelId . '
            ORDER BY id DESC';

        return $this->fetchAll($sql);
    }

    function setComment($modelId, $commentName, $commentData)
    {
        $commentName = mysql_escape_string($commentName);
        $commentData = mysql_escape_string($commentData);
        
        $sql = '
            INSERT INTO comments(model_property_id, name, comment, createrIp)
            VALUES (' . (int)$modelId . ', "' . $commentName . '", "' . $commentData . '", "' . $_SERVER["REMOTE_ADDR"] . '")';

        $result = mysql_query($sql);
        return mysql_insert_id();
    }
}