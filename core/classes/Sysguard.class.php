<?php

/**
 * @file Class for handling logging of backend activity for users with access and 404, 403 and 500 errors that are not triggered by server failure.
 */
class Sysguard {
    public static function get($filter = array(), $first = false) {
        //Gets log entries
        if(count($filter)) {
            if($first == true) {
                $data = DB::getInstance()->get('sysguard', $filter)->first();
            }
            else {
                $data = DB::getInstance()->get('sysguard', $filter)->results();
            }
            return $data;
        }
        else {
            $data = DB::getInstance()->getAll('sysguard')->results();
            return $data;
        }
        return false;
    }
    public static function set($header, $details, $module, $ref, $uid = 0) {
        //Sets a new log entry
        $db = DB::getInstance();
        $fields = array(
            'header' => $header,
            'details' => $details,
            'module' => $module,
            'uid' => $uid,
            'ref' => $ref,
            'timestamp' => time()
        );
        if($db->insert('sysguard', $fields)) {
            return true;
        }
        return false;
    }
    public static function clear() {
        //Clears the log and sets a new entry after clearing the log to notify others about who cleared the log
        $db = DB::getInstance();
        if(!$db->query("TRUNCATE `sysguard`")->error()) {
            if(self::set('clear log', 'The sysguard log has been cleared', 'core', $_SERVER['HTTP_REFERER'], User::getInstance()->uid())) {
                return true;
            }
        }
        else {
            self::set('clear log', 'The sysguard log could not be cleared', 'core', $_SERVER['HTTP_REFERER'], User::getInstance()->uid());
        }
        return false;
    }
}
