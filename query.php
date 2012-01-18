<?php
class Query
{
    static function getWhereByFilters($filters) {
        
        $where = '';
        
        if (isset($filters) && is_array($filters)) {

            if (isset($filters[0]) && isset($filters[0]['query'])) {

                $q = trim(mysql_escape_string(strtolower($filters[0]['query'])));

                $query = explode(' ', $q);

                foreach ($query as $value) {
                    if ($where) {
                        $where = '
                            WHERE (LOWER(model_properies.model) like ("%'. $value .'%")
                            || LOWER(parce_links.model) like ("%'. $value .'%")
                            || LOWER(model_properies.yearOfIssuance) like ("%'. $value .'%")
                            || LOWER(model_properies.engine) like ("%'. $value .'%")
                            || LOWER(model_properies.diameterAndPistonStroke) like ("%'. $value .'%")
                            || LOWER(model_properies.coolingType) like ("%'. $value .'%")
                            || LOWER(model_properies.maxPower) like ("%'. $value .'%"))
                            ';
                    } else {
                        $where .= '
                            AND( LOWER(model_properies.model) like ("%'. $value .'%")
                            || LOWER(parce_links.model) like ("%'. $value .'%")
                            || LOWER(model_properies.yearOfIssuance) like ("%'. $value .'%")
                            || LOWER(model_properies.engine) like ("%'. $value .'%")
                            || LOWER(model_properies.diameterAndPistonStroke) like ("%'. $value .'%")
                            || LOWER(model_properies.coolingType) like ("%'. $value .'%")
                            || LOWER(model_properies.maxPower) like ("%'. $value .'%"))
                            ';
                    }
                }

            } else {

                foreach($filters as $filter) {

                    foreach ($filter as $key => $value) {

                        switch($key) {
                            case 'brand':
                                if (!isset($brand)) {
                                    $brand = '"' . Content::$_filtersModel[$value] . '"';
                                } else {
                                    $brand .= ',"' . Content::$_filtersModel[$value] . '"';
                                }
                                break;

                            case 'engine':
                                switch (trim($value)) {
                                    case '0':
                                        if (!isset($engine)) {
                                            $engine = 'engine < 50';
                                        } else {
                                            $engine .= ' OR engine < 50';
                                        }
                                        break;
                                    case '1':

                                        if (!isset($engine)) {
                                            $engine = 'engine >= 50 AND engine <= 125';
                                        } else {
                                            $engine .= ' OR ( engine >= 50 AND engine <= 125 )';
                                        }
                                        break;
                                    case '2':

                                        if (!isset($engine)) {
                                            $engine = 'engine > 125';
                                        } else {
                                            $engine .= ' OR engine > 125';
                                        }
                                        break;
                                }
                                break;

                            case 'year':
                                switch (trim($value)) {
                                    case '0':
                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance < 1990';
                                        } else {
                                            $year .= ' OR yearOfIssuance < 1990';
                                        }
                                        break;
                                    case '1':

                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance >= 1990 AND yearOfIssuance  <= 1995';
                                        } else {
                                            $year .= ' OR ( yearOfIssuance >= 1990 AND yearOfIssuance  <= 1995 )';
                                        }
                                        break;
                                    case '2':

                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance >= 1995 AND yearOfIssuance  <= 2000';
                                        } else {
                                            $year .= ' OR ( yearOfIssuance >= 1995 AND yearOfIssuance  <= 2000 )';
                                        }
                                        break;
                                    case '3':

                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance >= 2000 AND yearOfIssuance  <= 2005';
                                        } else {
                                            $year .= ' OR ( yearOfIssuance >= 2000 AND yearOfIssuance  <= 2005 )';
                                        }
                                        break;
                                    case '4':

                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance >= 2005 AND yearOfIssuance  <= 2009';
                                        } else {
                                            $year .= ' OR ( yearOfIssuance >= 2005 AND yearOfIssuance  <= 2009 )';
                                        }
                                        break;
                                    case '5':

                                        if (!isset($year)) {
                                            $year = 'yearOfIssuance >= 2010';
                                        } else {
                                            $year .= ' OR yearOfIssuance >= 2010';
                                        }
                                        break;
                                }
                                break;
                        }
                    }
                }



                if (!empty($brand)) {
                    $where .= 'parce_links.model IN (' . $brand . ')';
                }

                if (!empty($engine)) {
                    if ($where) {
                        $where .= ' AND (' . $engine . ')';
                    } else {
                        $where = '(' . $engine . ')';
                    }
                }

                if (!empty($year)) {
                    if ($where) {
                        $where .= ' AND (' . $year . ')';
                    } else {
                        $where = '(' . $year . ')';
                    }
                }

                if (!empty($where)) {
                    $where = 'WHERE ' . $where;
                }
            }
        }
        
        return $where;
    }
}