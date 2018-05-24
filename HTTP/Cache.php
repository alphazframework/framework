<?php
namespace Softhub99\Zest_Framework\HTTP;

class Cache {

    public static $fileName;

    public static $path;

    public static $lastModified;

    public static $etag;

    public static function make($fileName) {

      static::$fileName     = $fileName;
      static::$path         = $fileName;
      static::$lastModified = static::getLastModified();
      static::httpHeaders();

    }

    public static function getLastModified() {

      return filemtime(static::$path);

    }
    public static function generateEtag() {

      static::$etag = md5(MHASH_TIGER160,static::$lastModified);
      return static::$etag;

    }
    public static function httpHeaders() {

      header("Cache-Control: must-revalidate");
      /* https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html 14.29 */
      header("Last-Modified:" .gmdate('D, d M Y H:i:s T',static::$lastModified));
      /* https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html 14.19 */
      header("Etag:" .bin2hex(static::generateEtag()));
      static::validate();

    }
    public static function validate() {

      if( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) AND strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) === static::$lastModified) {
        http_response_code("304");
      }
      if( isset($_SERVER['HTTP_IF_NONE_MATCH']) AND bin2hex($_SERVER['HTTP_IF_NONE_MATCH']) === bin2hex(static::$etag)) {
        http_response_code("304");
      }

    }
    
}