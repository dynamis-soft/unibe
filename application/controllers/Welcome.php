<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
       //$user = $this->factura_model->getUser();
        //print_r($user); die();
        $current_timestamp = date('Y-m-d H:i:s');
        $this->contacto_model->guardarContacto("Juan Rojas","88888888",$current_timestamp,"usuario@email.com","1-1111-1111");
        $this->load->view('welcome_message');
    }

}
