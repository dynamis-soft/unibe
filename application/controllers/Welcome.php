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
        echo strpos('C% Cantones San José', "C-");
        if (strpos('C- Cantones San José', "C-") > 0) {
            $value = explode("-", trim($item->content));
            $data['barrio'] = $value[0];
        }

        die();
        $current_timestamp = date('Y-m-d H:i:s');
        $result = $this->zoho->buscarContactoJson();
        $result = json_decode($result);
        $i = 0;
        $contacto = "";
        foreach ($result->response->result->Contacts->row as $item) {
            foreach ($item as $data) {
                if (is_array($data)) {
                    foreach ($data as $key => $object) {
                        if ($object->val == 'CONTACTID' && $object->content == '3080805000001653150') {
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
        $tipoIdentificacion = "";
        foreach ($contacto as $item) {
            if ($item->val == 'Full Name') {
                $nombre = $item->content;
            }
            if ($item->val == 'Tipo de ID') {
                $tipoIdentificacion = $item->content;
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
        $this->contacto_model->guardarContacto($nombre, $mobile, $current_timestamp, $email, $identificacion, $docgenerar, $GLN, $confirma, $utiliza, $tipoIdentificacion);
        $this->load->view('welcome_message');
    }

}
