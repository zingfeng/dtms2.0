<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sitemap
{
    function set($url){
        $CI = &get_instance();
        $url = trim(trim($url),'/');
        if ($this->_check_link($url) === FALSE){
            return false;
        }
        $CI->db->where('link',$url);
        $query = $CI->db->get('urllists',1);
        $row = $query->row_array();
        // neu chua ton tai link nay
        if (!empty($row)){
            return false;
        }
        $somecontent = "<url><loc>$url</loc><lastmod>".date('c',time())."</lastmod></url>";
		$this->_write(FCPATH.'sitemap.xml',$somecontent,'xml');
		$this->_write(FCPATH.'urllist.txt',"\n$url");
        $CI->db->insert('urllists',array('link' => $url));
        $status = $this->_pingGoogleSitemaps(site_url('sitemap.xml'));
        $CI->load->setArray('script','<script>alert("'.$status.': Đã set trang này vào sitemap");</script>');
    }
	function _write($filename,$somecontent,$type='url'){
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename)) {
		    if ($type === 'xml'){
                $xml = file($filename);
                $xml = array_filter($xml);
                array_pop($xml);
                $somecontent = implode("",$xml).$somecontent."\n</urlset>";
                if (!$handle = fopen($filename, 'w')) {
    		         show_error ("Cannot open file ($filename)");
    		         exit("show_error");
                }
            }
            else{
                if (!$handle = fopen($filename, 'a')) {
    		         show_error ("Cannot open file ($filename)");
    		         exit("show_error");
    		    }
            }
		    // Write $somecontent to our opened file.
		    if (fwrite($handle, $somecontent) === FALSE) {
		        show_error ("Cannot write to file ($filename)");
		        exit;
		    }
            return $somecontent;
		    fclose($handle);
		} else {
		    show_error("The file $filename is not writable");
            exit();
		}
		///////////////////////////
	}
    function _pingGoogleSitemaps( $url_xml )
    {
       $status = 0;
       $google = 'www.google.com';
       if( $fp=@fsockopen($google, 80) )
       {
          $req =  'GET /webmasters/sitemaps/ping?sitemap=' .
                  urlencode( $url_xml ) . " HTTP/1.1\r\n" .
                  "Host: $google\r\n" .
                  "User-Agent: Mozilla/5.0 (compatible; " .
                  PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
                  "Connection: Close\r\n\r\n";
          fwrite( $fp, $req );
          while( !feof($fp) )
          {
             if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
             {
                $status = intval( $m[1] );
                break;
             }
          }
          fclose( $fp );
       }
       return( $status );
    }
    function _check_link($url){
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        }
        else {
            $url = array($url, "/");
        }
        $url_port = explode(':', $url[0]);
        if ($url_port[1]) {
        $port = $url_port[1];
        $url[0] = str_replace(':'.$port, '', $url[0]);
        }
        else
        $port = 80;
        $fh = fsockopen($url[0], $port);
        if ($fh) {
            fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
            else { return TRUE;    }

        }
        else { return FALSE;}
    }
}