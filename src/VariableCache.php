<?php

namespace CodeBlog\RateLimit;

/**
 * Class CodeBlog VariableCache
 *
 * @author Whallysson Avelino <https://github.com/whallysson>
 * @package CodeBlog\RateLimit
 */
class VariableCache {

    /**
     * Directory where the data will be saved
     * @access private
     * @var string
     */
    private $cacheFolder;

    /**
     * Extent that will save the file
     * @access private
     * @var type string
     */
    private $ext = "cache";

    /**
     * Variable Array
     * @access private
     * @var type array
     */
    private $variables = [];

    /**
     * VariableCache constructor.
     * @param string|null $cacheFolder
     * @throws \Exception
     */
    function __construct(string $cacheFolder = null) {
        $folder = (substr($cacheFolder, "-1") == "/" ? $cacheFolder : "{$cacheFolder}/");
        $this->cacheFolder = $cacheFolder ? $folder : $_SERVER['DOCUMENT_ROOT'] . '/cache-variable/';

        if (!file_exists($this->cacheFolder) && !is_dir($this->cacheFolder)):
            if (!mkdir($this->cacheFolder, 0755)) {
                throw new \Exception("Could not create cache folder");
            }
        endif;
    }

    /**
     * Saves a variable in the cache
     * 
     * @param string $key
     * @param array $value
     * @param string $expire
     */
    public function store(string $key, array $value, $expire = 0) {
        $this->variables = array_merge($this->variables, ['expire' => time() + $expire]);
        $this->variables = array_merge($this->variables, ['data' => $value]);
        file_put_contents($this->cacheFolder . "{$key}.{$this->ext}", json_encode($this->variables));
    }

    /**
     * Returns the saved cache variables
     * 
     * @param string $key
     * @return boolean
     */
    public function fetch(string $key) {
        $archive = $this->cacheFolder . "{$key}.{$this->ext}";
        if (file_exists($archive)) {
            $content = json_decode(file_get_contents($archive), true);

            if ($content['expire'] > time()):
                return $content['data'];
            endif;
            unlink($archive);
        }

        return false;
    }

    /**
     * Delete the last cache on $key
     * 
     * @param type $key
     * @return boolean
     */
    public function delete(string $key) {
        $archive = $this->cacheFolder . "{$key}.{$this->ext}";
        if (file_exists($archive)) {
            unlink($archive);
        }
        return true;
    }

    /**
     * Returns all saved cache variables
     * 
     * @param string $key
     * @return boolean
     */
    public function cacheInfo(string $key) {
        $archive = $this->cacheFolder . "{$key}.{$this->ext}";
        if (file_exists($archive)) {
            $content = json_decode(file_get_contents($archive), true);
            return $content;
        }

        return false;
    }

}
