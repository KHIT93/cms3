<?php
class Sanitize {
    public static function checkPlain($string) {
        //Sanitize input from text-inputs
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    public static function stringPlaceholder($string) {
        return '<em class="placeholder">'.self::checkPlain($string).'</em>';
    }
    public static function stripDangerousProtocols($uri) {
        $allowed_protocols;
        //Checking if array of allowed protocols exist. Otherwise create it
        if (!isset($allowed_protocols)) {
            $allowed_protocols = array_flip(variable_get('filter_allowed_protocols', array('ftp', 'http', 'https', 'irc', 'mailto', 'news', 'nntp', 'rtsp', 'sftp', 'ssh', 'tel', 'telnet', 'webcal')));
        }
        do {
            $before = $uri;
            $colonpos = strpos($uri, ':');
            if($colonpos > 0) {
                $protocol = substr($uri, 0, $colonpos);
                if(preg_match('![/?#]!', $protocol)) {
                    break;
                }
                if (!isset($allowed_protocols[strtolower($protocol)])) {
                    $uri = substr($uri, $colonpos + 1);
                }
            }
        }
        while($before != $uri);
    }
    public static function checkURL($input) {
        //Sanitize input from URL-inputs
        return $output = check_plain(strip_dangerous_protocols($input));
    }
    public static function escapeAddr($addr) {
        $check = preg_match('/(.*)<(.*)>/', $addr, $a);
        if ($check) $addr = '=?UTF-8?B?'.base64_encode($a[1]).'?= <'.$a[2].'>';
        return $addr;
    }
    public static function checkPath($path) {
        //Sanitizes the passed variable as if it was a path to a file or directory to prevent Path Traversal
        return strtr($path, array('./' => '', '../' => ''));
    }
}