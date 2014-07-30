<?php
class Sanitize {
    public static function checkPlain($string) {
        //Sanitize input from text-inputs
        $output = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        $output = nl2br($output);
        return $output;
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
}