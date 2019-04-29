<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Description of MY_Output
 *
 * @author Soumitra
 */
class MY_Output extends CI_Output {
 
    function nocache() {
		$this->clear_all_cache();
		$this->set_header('HTTP/1.0 200 OK');
		$this->set_header('HTTP/1.1 200 OK');
        $this->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->set_header('Pragma: no-cache');
    }
	
	/**
     * Clears the cache for the specified path
     * @param string $uri The URI path
     * @return boolean TRUE if successful, FALSE if not
     */
    public function clear_path_cache($uri)
    {
        $CI =& get_instance();
		$path = $CI->config->item('cache_path');
        
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        
        $uri =	$CI->config->item('base_url').
		$CI->config->item('index_page').
		$uri;

		$cache_path .= md5($uri);
        
        return @unlink($cache_path);
    }
    
    /**
     * Clears all cache from the cache directory
     */
    public function clear_all_cache()
    {
        $CI =& get_instance();
		$path = $CI->config->item('cache_path');
        
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        
        $handle = opendir($cache_path);

        while (($file = readdir($handle))!== FALSE) 
        {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html')
            {
               @unlink($cache_path.'/'.$file);
            }
        }

        closedir($handle);
    }
    
    /**
     * Checks to see if a cache file exists for the specified path
     * @param string $uri The URI path to check
     * @return boolean TRUE if it is, FALSE if not
     */
    public function path_cached($uri)
    {
        $CI =& get_instance();
		$path = $CI->config->item('cache_path');
        
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        
        $uri =	$CI->config->item('base_url').
		$CI->config->item('index_page').
		$uri;

		$cache_path .= md5($uri);
        
        return file_exists($cache_path);
    }
    
    /**
     * Returns the cache expiration timestamp for the specified path
     * @param string $uri The URI patch to check
     * @return int|boolean The expiration Unix timestamp or FALSE if there is no cache
     */
    public function get_path_cache_expiration($uri)
    {
        $CI =& get_instance();
		$path = $CI->config->item('cache_path');
        
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        
        $uri =	$CI->config->item('base_url').
		$CI->config->item('index_page').
		$uri;

		$cache_path .= md5($uri);
        
        if (!$fp = @fopen($cache_path, FOPEN_READ))
        {
            return FALSE;
        }
        
        flock($fp, LOCK_SH);

        $cache = '';
        if (filesize($cache_path) > 0)
        {
            $cache = fread($fp, filesize($cache_path));
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        //Strip out the embedded timestamp
        if (!preg_match("/(\d+TS--->)/", $cache, $match))
        {
            return FALSE;
        }
        
        //Return the timestamp
        return (int)trim(str_replace('TS--->', '', $match['1']));
    }
 
}
 
/* End of file MY_Output.php */
/* Location: ./application/core/MY_Output.php */