<?php 
class Rest {

    public static function getStatusCodeMessage($status)
    {
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    
    public static function initProcess()
    {
        $requestMethod      = strtolower($_SERVER['REQUEST_METHOD']);
        $obj                = new RestRequest();
        $data               = array();
        $_PUT_VARS          = null;
            
        switch ($requestMethod) {
                case 'get':
                        $data = $_GET;
                        break;
                case 'post':
                        $data = $_POST;
                        break;
                case 'put':
                        parse_str(file_get_contents('php://input'), $_PUT_VARS);
                        $data = $_PUT_VARS;
                        break;
        }
            
        $obj->setMethod($requestMethod);
        $obj->setRequestVars($data);
        
        //print_logex($data);
        if(isset($data['data'])) {
                $obj->setData(json_decode($data['data']));
        }
        return $obj;
}

    public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' .Rest::getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);

        if($body != '') {
            print $body;
            exit;
        } else {

            $message = '';

                switch($status) {
                        case 401:
                                $message = 'Vous devez être autorisé à afficher cette page.';
                                break;
                        case 404:
                                $message = 'L\'url demandé :  ' . $_SERVER['REQUEST_URI'] . ' n\'a pas était trouvé.';
                                break;
                        case 500:
                                $message = 'Le serveur a rencontré une erreur lors du traitement de votre demande.';
                                break;
                        case 501:
                                $message = 'La méthode demandée n\'est pas implémentée.';
                                break;
                }

                $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Serveur à ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

                $body  = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
                $body .= '<html>';
                $body .= '  <head>';
                $body .= '      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
                $body .= '      <title>' . $status . ' ' . Rest::getStatusCodeMessage($status) . '</title>';
                $body .= '  </head>';
                $body .= '  <body>';
                $body .= '      <h1>' . Rest::getStatusCodeMessage($status) . '</h1>';
                $body .= '      <p>' . $message . '</p>';
                $body .= '      <hr />';
                $body .= '      <address>' . $signature . '</address>';
                $body .= '  </body>';
                $body .= '</html>';

                print $body;
                exit;
        }
    }

}