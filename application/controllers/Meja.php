<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Meja extends REST_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index_get() {
        $this->response('gembus');
    }
}