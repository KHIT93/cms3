<?php
/**
 * @file
 * Acts as an abstraction layer for the SplFileObject class and implements easy to use functionality that has been customized for use with core classes and functions as well as third party modules
 */
class File {
    private $_name, $_path, $_folder, $_size, $_permissions, $_created, $_updated, $_handle;
    public function __construct($path, $type = 'a') {
        if(file_exists($path)) {
            $this->_handle = new SplFileObject($path);
            $this->_path = $path;
            $this->_name = $this->_handle->getBasename();
            $this->_folder = $this->_handle->getPath();
            $this->_size = $this->_handle->getSize();
            $this->_permissions = $this->_handle->getPerms();
            $this->_created = $this->_handle->getCTime();
            $this->_updated = $this->_handle->getMTime();
        }
        else {
            Sysguard::set('File not found', 'The requested file '.$path.' does not exist', 'file', $_SERVER['HTTP_REFERER']);
            addMessage('error', t('Not found').': '.$path.'<br/>'.t('The file does not exists'));
        }
    }
    public function write($string = NULL) {
        $this->_handle->rewind();
        if($string) {
            try {
                $this->_handle->fwrite($string);
                return true;
            }
            catch(Exception $e) {
                System::addMessage('error', t('There was an error writing to the file @filepath: @error', array('@filepath' => $this->_path, '@error' => $e->getMessage())), $e);
                return false;
            }
        }
        return false;
    }
    public function read() {
        $this->_handle->rewind();
        return $this->_handle->fpassthru();
    }
    public function delete() {
        
    }
    public function rewind() {
        $this->_handle->rewind();
    }
    public function spl($function = NULL) {
        //Development function. Will only be available during core development to determine which functions from SplFileObject should be abstracted to core File class
        if($function) {
            return $this->_handle->$function();
        }
        return false;
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