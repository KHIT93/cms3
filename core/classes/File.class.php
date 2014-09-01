<?php
class File {
    private $_name, $_path, $_folder, $_size, $_permissions, $_created, $_updated, $_handle;
    public function __construct($path, $type = 'a') {
        if(file_exists($path)) {
            $this->_handle = fopen($path, $type);
            $this->_path = $path;
            $this->_name = basename($path);
            $this->_folder = dirname($path);
            $this->_size = filesize($this->_path);
            $this->_permissions = fileperms($this->_path);
            $this->_created = filectime($this->_path);
            $this->_updated = filemtime($this->_path);
        }
        else {
            Sysguard::set('File not found', 'The requested file '.$path.' does not exist', 'file', $_SERVER['HTTP_REFERER']);
            addMessage('error', t('Not found').': '.$path.'<br/>'.t('The file does not exists'));
        }
    }
    public function write() {
        
    }
    public function read() {
        return file($this->_path);
    }
    public function delete() {
        
    }
    public function name() {
        return $this->_name;
    }
    public function path() {
        return $this->_path;
    }
    public function folder() {
        return $this->_folder;
    }
    public function size($unit = 'KB') {
        switch ($unit) {
            case 'B':
                return $this->_size;
            break;
            case 'KB':
                return number_format($this->_size/1024, 2, ',', '.');
            break;
            case 'MB':
                return number_format(($this->_size/1024)/1024, 2, ',', '.');
            break;
            case 'GB':
                return number_format((($this->_size/1024)/1024)/1024, 2, ',', '.');
            break;
            case 'TB':
                return number_format(((($this->_size/1024)/1024)/1024)/1024, 2, ',', '.');
            break;
            default:
                return $this->_size;
            break;
        }
    }
    public function permissions() {
        return $this->_permissions;
    }
    public function created() {
        return $this->_created;
    }
    public function updated() {
        return $this->_updated;
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
    public static function isRegistryFile($filepath) {
        return (pathinfo($filepath, PATHINFO_EXTENSION) == 'info') ? true : false;
    }
    public static function getFilesInDir($directory, $recursive = false, $exclude = array()) {
        $dir = scandir($directory, SCANDIR_SORT_ASCENDING);
        $output = array();
        $x = 0;
        if(isset($dir[0])) {
            unset ($dir[0]);
            $x++;
        }
        if(isset($dir[1])) {
            unset ($dir[1]);
            $x++;
        }
        if(isset($dir[2]) && $dir[2] == '.DS_Store') {
            unset ($dir[2]);
            $x++;
        }
        if($recursive == true) {
            foreach($dir as $item) {
                $fileExt = explode('.', $item);
                $ext = $fileExt[count($fileExt)-1];
                if(!in_array($ext, $exclude)) {
                    $output[$x]['name'] = $item;
                    if(is_dir($directory.'/'.$item)) {
                        $output[$x]['children'] = self::getFilesInDir($directory.'/'.$item, true, $exclude);
                        if(!count($output[$x]['children'])) {
                            unset($output[$x]);
                            $x--;
                        }
                    }
                    clearstatcache();
                    $x++;
                }
            }
        }
        return $output;
    }
}