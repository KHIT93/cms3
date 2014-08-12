<?php
class File {
    public function __construct($path, $type = 'a') {
        if(file_exists($path)) {
            $this->handle = fopen($path, $type);
            $this->path = $path;
        }
        else {
            addMessage('error', t('Not found').': '.$path.'<br/>'.t('The file does not exists'));
        }
    }
    public function write() {
        
    }
    public function read() {
        
    }
    public function delete() {
        
    }
    public static function parse_info_file($filepath = NULL) {
        $info = array();

        if (!isset($info[$filepath])) {
          if (!file_exists($filepath)) {
            $info[$filepath] = array();
          }
          else {
            $data = file_get_contents($filepath);
            $info[$filepath] = self::parse_info_format($data);
          }
        }
        return $info[$filepath];
    }
    private static function parse_info_format($data) {
        $info = array();
        $constants = get_defined_constants();

        if (preg_match_all('
          @^\s*                           # Start at the beginning of a line, ignoring leading whitespace
          ((?:
            [^=;\[\]]|                    # Key names cannot contain equal signs, semi-colons or square brackets,
            \[[^\[\]]*\]                  # unless they are balanced and not nested
          )+?)
          \s*=\s*                         # Key/value pairs are separated by equal signs (ignoring white-space)
          (?:
            ("(?:[^"]|(?<=\\\\)")*")|     # Double-quoted string, which may contain slash-escaped quotes/slashes
            (\'(?:[^\']|(?<=\\\\)\')*\')| # Single-quoted string, which may contain slash-escaped quotes/slashes
            ([^\r\n]*?)                   # Non-quoted string
          )\s*$                           # Stop at the next end of a line, ignoring trailing whitespace
          @msx', $data, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                // Fetch the key and value string.
                $i = 0;
                foreach (array('key', 'value1', 'value2', 'value3') as $var) {
                  $$var = isset($match[++$i]) ? $match[$i] : '';
                }
                $value = stripslashes(substr($value1, 1, -1)) . stripslashes(substr($value2, 1, -1)) . $value3;

                // Parse array syntax.
                $keys = preg_split('/\]?\[/', rtrim($key, ']'));
                $last = array_pop($keys);
                $parent = &$info;

                // Create nested arrays.
                foreach ($keys as $key) {
                  if ($key == '') {
                    $key = count($parent);
                  }
                  if (!isset($parent[$key]) || !is_array($parent[$key])) {
                    $parent[$key] = array();
                  }
                  $parent = &$parent[$key];
                }

                // Handle PHP constants.
                if (isset($constants[$value])) {
                  $value = $constants[$value];
                }

                // Insert actual value.
                if ($last == '') {
                  $last = count($parent);
                }
                $parent[$last] = $value;
            }
        }
        return $info;
    }
    public static function isInfoFile($filepath) {
        return (pathinfo($filepath, PATHINFO_EXTENSION) == 'info') ? true : false;
    }
}