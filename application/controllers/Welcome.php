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
        $post = array("id"=>"3080805000003050038");
        $result = $this->zoho->getOportunidad();
        $result = json_decode($result);
        $i = 0;
        $oportunidad = "";
        foreach ($result->response->result->Deals->row as $item) {
            foreach ($item as $data) {
                if (is_array($data)) {
                    foreach ($data as $key => $object) {
                        if ($object->val == 'DEALID' && $object->content == $post['id']) {
                            $oportunidad = $data;
                        }
                    }
                }
            }
        }
        print_r($oportunidad);die();
        $id_contacto = "";
        $profesional = "";
        foreach ($oportunidad as $item) {
            if ($item->val == 'CONTACTID') {
                $id_contacto = $item->content;
            }
            if ($item->val == 'Profesional') {
                $profesional = $item->content;
            }
        }
        $result = $this->zoho->buscarContactoJson();
        $result = json_decode($result);
        $i = 0;
        $contacto = "";
        foreach ($result->response->result->Contacts->row as $item) {
            foreach ($item as $data) {
                if (is_array($data)) {
                    foreach ($data as $key => $object) {
                        if ($object->val == 'CONTACTID' && $object->content == $id_contacto) {
                            $contacto = $data;
                        }
                    }
                }
            }
        }
        $nombre = "";
        $mobile = "";
        $email = "";
        $identificacion = "";
        $docgenerar = "";
        $GLN = "";
        $confirma = "";
        $utiliza = "";

        foreach ($contacto as $item) {
            if ($item->val == 'Full Name') {
                $nombre = $item->content;
            }
            if ($item->val == 'Phone') {
                $mobile = " " . $item->content;
            }
            if ($item->val == 'Email') {
                $email = $item->content;
            }
            if ($item->val == 'Número de ID') {
                $identificacion = $item->content;
            }
            if ($item->val == 'Número de ID') {
                $identificacion = " " . $item->content;
            }
            if ($item->val == 'Documento a Generar') {
                $docgenerar = $item->content;
            }
            if ($item->val == 'GLN') {
                $GLN = $item->content;
            }
            if ($item->val == 'Confirmación Electrónica') {
                if ($item->content == "SI") {
                    $confirma = "S";
                } else
                    $confirma = "N";
            }
            if ($item->val == 'Utiliza documentos electrónicos') {
                if ($item->content == "SI") {
                    $utiliza = "S";
                } else
                    $utiliza = "N";
            }
        }
        $this->factura_model->guardarFactura($nombre, $identificacion,$profesional);
        //$this->contacto_model->guardarContacto($data);
        $this->load->view('welcome_message');
    }

}
