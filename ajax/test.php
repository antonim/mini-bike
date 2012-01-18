<?php

include_once('../db.php');

if (isset($_REQUEST['filters'])) {
	
	$filters = $_REQUEST['filters'];



	foreach($filters as $key => $value) {
		switch($key) {
			case 'brand':
                $where.= 'AND parce_links.model = "' . $value . '"';
                break;
            case 'engine':
                /*
                switch ($value) {
                    
                }*/
                break;

		}
	}


    /*
    $sql = 'SELECT model_properies.*, parsing_data.id AS photoId, parce_links.model as brand
            FROM model_properies
                JOIN parce_links
                    ON model_properies.parceLinksId = parce_links.id
                JOIN parsing_data
                    ON parsing_data.parce_links_id = model_properies.id AND parsing_data.title = "photo"
		 	WHERE
            GROUP BY model_properies.id
		 	ORDER BY model_properies.id DESC
			LIMIT 10';
	*/
}