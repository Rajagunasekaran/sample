<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
set_include_path(APPPATH . 'third_party/' . PATH_SEPARATOR . get_include_path());
require_once APPPATH . 'third_party/Google/autoload.php';
require_once APPPATH . 'third_party/Google/Client.php';
require_once APPPATH . 'third_party/Google/Service/Drive.php';
include APPPATH . 'third_party/Google/Service/Calendar.php';

class Google extends Google_Client {
    function __construct($params = array()) {
        parent::__construct();
    }
}

