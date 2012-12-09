<?php

function prepareBaseUrl()
{
    $filename = basename($_SERVER['SCRIPT_FILENAME']);

    if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
        $baseUrl = $_SERVER['SCRIPT_NAME'];
    } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
        $baseUrl = $_SERVER['PHP_SELF'];
    } elseif (basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
        $baseUrl = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
    } else {
        // Backtrack up the script_filename to find the portion matching
        // php_self
        $path    = $_SERVER['PHP_SELF'];
        $file    = $_SERVER['SCRIPT_FILENAME'];
        $segs    = explode('/', trim($file, '/'));
        $segs    = array_reverse($segs);
        $index   = 0;
        $last    = count($segs);
        $baseUrl = '';
        do {
            $seg     = $segs[$index];
            $baseUrl = '/'.$seg.$baseUrl;
            ++$index;
        } while (($last > $index) && (false !== ($pos = strpos($path, $baseUrl))) && (0 != $pos));
    }
    
    // Does the baseUrl have anything in common with the request_uri?
    $requestUri = prepareRequestUri();
    if ($baseUrl && false !== $prefix = getUrlencodedPrefix($requestUri, $baseUrl)) {
        // full $baseUrl matches
        return $prefix;
    }

    if ($baseUrl && false !== $prefix = getUrlencodedPrefix($requestUri, dirname($baseUrl))) {
        // directory portion of $baseUrl matches
        return rtrim($prefix, '/');
    }
    $truncatedRequestUri = $requestUri;
    if (($pos = strpos($requestUri, '?')) !== false) {
        $truncatedRequestUri = substr($requestUri, 0, $pos);
    }

    $basename = basename($baseUrl);
    if (empty($basename) || !strpos(rawurldecode($truncatedRequestUri), $basename)) {
        // no match whatsoever; set it blank
        return '';
    }

    // If using mod_rewrite or ISAPI_Rewrite strip the script filename
    // out of baseUrl. $pos !== 0 makes sure it is not matching a value
    // from PATH_INFO or QUERY_STRING
    if ((strlen($requestUri) >= strlen($baseUrl)) && ((false !== ($pos = strpos($requestUri, $baseUrl))) && ($pos !== 0))) {
        $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
    }
    
    return rtrim($baseUrl, '/');
 }
 
function prepareRequestUri()
{
   $requestUri = '';
   $url = currentURL();
   $url_parsed = parse_url($url);
   
  if ($_SERVER['REQUEST_URI']) {
       $requestUri = $_SERVER['REQUEST_URI'];
       
       $schemeAndHttpHost = $url_parsed['scheme'].'://'.$url_parsed['host'].':'.$url_parsed['port'];
       if (strpos($requestUri, $schemeAndHttpHost) === 0) {
           $requestUri = substr($requestUri, strlen($schemeAndHttpHost));
       }
   }
   return $requestUri;
}

function currentURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
 return $pageURL;
}

function getUrlencodedPrefix($string, $prefix)
{
    if (0 !== strpos(rawurldecode($string), $prefix)) {
        return false;
    }

    $len = strlen($prefix);

    if (preg_match("#^(%[[:xdigit:]]{2}|.){{$len}}#", $string, $match)) {
        return $match[0];
    }

    return false;
}
