<?php
/**
 * @file
 * Functions for page preparation and rendering
 */
function get_breadcrumb() {
    $get_url = splitURL();
    $items = $get_url;
    $count = count($items);
    $i = 0;
    if($count > 0) {
        $link = array();
        $link[] = '';
        $breadcrumb = '<ol class="breadcrumb">';
        while($count > 0) {
            $link[] = $items[$i];
            if($count > 1) {
                $breadcrumb .= '<li><a href="'.implode('/', $link).'">'.ucfirst($items[$i]).'</a></li>';
            }
            else {
                $breadcrumb .= '<li class="active">'.ucfirst($items[$i]).'</li>';
            }
            $i++;
            $count--;
            
        }
        $breadcrumb .= '</ol>';
        //$breadcrumb = '<ol class="breadcrumb"><li><a href="#">'.implode('</a></li><li><a href="#">', $items).'</a></li></ol>';
    }
    else {
        $breadcrumb = '<ol class="breadcrumb"><li class="active">'.$items[0].'</li></ol>';
    }
    return $breadcrumb;
}
function pagination($limit, $table, $fields = '*', $parameter = NULL, $parameter_value = NULL) {
    $db = DB::getInstance();
    $get_url = splitURL();
    $lang = Config::get('site/site_language');
    $sql = '';
    if($parameter != NULL || $parameter != '') {
        $sql = "SELECT COUNT({$fields}) FROM {$table} WHERE {$parameter}= ?";
        $params = array($parameter_value);
    }
    else {
        $sql = "SELECT COUNT({$fields}) FROM {$table}";
    }
    $query = ($parameter) ? $db->query($sql, $params, PDO::FETCH_ASSOC) : $db->query($sql, NULL, PDO::FETCH_ASSOC);
    $count = $query->first()['COUNT('.$fields.')'];
    $pages = ceil($count / $limit);
    if($pages < 1) {
        $pages = 1;
    }
    $pagenum = 1;
    if(isset($get_url[4])) {
        $pagenum = (is_numeric($get_url[4])) ? $get_url[4] : 1;
    }
    else if($pagenum > $pages) {
        $pagenum = $pages;
    }
    $page = ($pagenum -1) * $limit;
    if($parameter != NULL || $parameter != '') {
        $sql = "SELECT {$fields} FROM `{$table}` WHERE `{$parameter}`= ? LIMIT {$page}, {$limit}";
        $params = array($parameter_value);
    }
    else {
        $sql = "SELECT {$fields} FROM `{$table}` LIMIT {$page}, {$limit}";
    }
    $query = ($parameter) ? $db->query($sql, $params, PDO::FETCH_ASSOC) : $db->query($sql, NULL, PDO::FETCH_ASSOC);
    $data = $query->results();
    $controls = '<ul class="pagination">';
    $url = $get_url[0].'/'.$get_url[1].'/'.$get_url[2].'/'.$get_url[3];
    $previous = $pagenum - 1;
    $controls .= ($previous < 1) ? '<li class="disabled"><a href="#">&laquo; '.t('Previous').'</a></li>' : '<li><a href="/'.$url.'/'.$previous.'">&laquo; '.t('Previous').'</a></li>';
    for($i = 1; $i <= $pages; $i++) {
        if($i == $pagenum) {
            $controls .= '<li class="active"><a href="/'.$url.'/'.$i.'">'.$i.'</a></li>';
        }
        else {
            $controls .= '<li><a href="/'.$url.'/'.$i.'">'.$i.'</a></li>';
        }
    }
    $next = $pagenum + 1;
    $controls .= ($next > $pages) ? '<li class="disabled"><a href="#">'.t('Next').' &raquo;</a></li>' : '<li><a href="/'.$url.'/'.$next.'">'.t('Next').' &raquo;</a></li>';
    $controls .= '</ul>';

    $paginated = array(
        'data' => $data,
        'controls' => $controls
    );
    return $paginated;
}
function currentPageIsFront() {
    return (!isset($_GET['q']) || $_GET['q'] == page_front()) ? true : false;
}
function getPageId($alias) {
    $convert = explode('/', $alias);
    //krumo(debug_backtrace());
    //$alias_convert = (strpos($alias, 'pages/') == false) ? DB::getInstance()->getField('url_alias', 'source', 'alias', $alias) : $alias;
    $alias_convert = ($convert[0] == 'pages') ? $alias : DB::getInstance()->getField('url_alias', 'source', 'alias', $alias);
    if(!is_null($alias_convert)) {
        $page_id = explode('/', $alias_convert)[1];
        return $page_id;
    }
    else {
        return false;
    }
    //$page_id = DB::getInstance()->getField('pages', 'pid', 'page_url', $alias_convert);
    return false;
}
function urlIsAlias($url) {
    if($url[0] == 'pages' && is_numeric($url[1])) {
        return false;
    }
    else {
        return true;
    }
}
function page_front() {
    return Config::get('site/site_home');
}
function getPage() {
    return Page::getInstance();
}