<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_controller.php';

class Api extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    /* APIS GENERALES */

    public function huli_post() {
        $data = $this->post();

        $telefonos = "";
        $home = "";
        $mobile = "";
        if (array_key_exists('data', $data)) {
            foreach ($data['data']['patient']['phones'] as $telefono) {
                $telefonos .= " Tipo: " . $telefono['type'] . " " . $telefono['number'];
                if ($telefono['type'] == "home") {
                    $home = $telefono['number'];
                }
                if ($telefono['type'] == "mobile") {
                    $mobile = $telefono['number'];
                }
            }
            $enfermedades = "";
            foreach ($data['data']['patient']['insurances'] as $enfermedad) {
                $telefonos .= $enfermedad['name'] . " ";
            }
            $description = "Usuario :" . 'user ' . $data['data']['user']['name'] . ". Doctor: " . $data['data']['doctor']['name'] .
                    ". Clinica: " . $data['data']['clinic']['name'] . ". Paciente: " . $data['data']['patient']['name'] . " - " . $data['data']['patient']['email']
                    . " - " . $telefonos . ". Motivo: " . $enfermedades;
            if (array_key_exists("ids", $data['data']['patient'])) {
                foreach ($data['data']['patient']["ids"] as $item) {
                    if ($item["type"] == "identification") {
                        $result = $this->zoho->buscarContacto();
                        if (strpos($result, $item["number"]) === false) {
                            $xml = '<Contacts>
                            <row no="1">
                            <FL val="First Name"></FL>
                            <FL val="Last Name">' . $data['data']['patient']['name'] . '</FL>
                            <FL val="Email">' . $data['data']['patient']['email'] . '</FL>
                            <FL val="Número de ID">' . $item["number"] . '</FL>
                            <FL val="Phone">' . $home . '</FL>
                            <FL val="Mobile">' . $mobile . '</FL>
                            </row>
                            </Contacts>';
                            $result = $this->zoho->crearContacto($xml);
                            $current_timestamp = date('Y-m-d H:i:s');
                            $this->contacto_model->guardarContacto($data['data']['patient']['name'], $mobile, $current_timestamp, $data['data']['patient']['email'], $item["number"]);
                        }
                    }
                }
            }

            $xml = '<?xml version="1.0" encoding="utf-8"?>
                <Deals>
                <row no = "1">
                <FL val = "Description">' . $description . '</FL>
                <FL val = "Stage">Solicitud de Cita</FL>
                <FL val = "Deal Name">Cita Huli ' . $data['data']['patient']['name'] . '</FL> 
                <FL val = "Contact Name">' . $data['data']['patient']['name'] . '</FL> 
                <FL val = "Closing Date">' . date('d/m/Y') . '</FL> 
                </row>
                </Deals>';
            $result = $this->zoho->crearEvento($xml);




            $result = simplexml_load_string($result);
            $message = [
                'type' => "success",
                'message' => "Operacion exitosa",
                'data' => $result
            ];
        } else {
            $message = [
                'type' => "error",
                'message' => "Formato invalido"
            ];
        }



        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function facturacion_post() {
        $data = $this->post();
        //log_message('error', 'Entre');
        //log_message('error', json_encode($data));
        $user = $this->factura_model->getUser();
        $message = [
            'type' => "error",
            'message' => $user
        ];


        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function contacto_post() {
        $post = $this->post();
        $current_timestamp = date('Y-m-d H:i:s');
        $result = $this->zoho->buscarContactoJson();
        $result = json_decode($result);
        $i = 0;
        $contacto = "";
        foreach ($result->response->result->Contacts->row as $item) {
            foreach ($item as $data) {
                if (is_array($data)) {
                    foreach ($data as $key => $object) {
                        if ($object->val == 'CONTACTID' && $object->content == $post['id']) {
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

        foreach ($contacto as $item) {
            if ($item->val == 'First Name') {
                $nombre = $item->content;
            }
            if ($item->val == 'Last Name') {
                $nombre = " " . $item->content;
            }
            if ($item->val == 'Phone') {
                $mobile = " " . $item->content;
            }
            if ($item->val == 'Email') {
                $email = " " . $item->content;
            }
            if ($item->val == 'Número de ID') {
                $identificacion = " " . $item->content;
            }
        }
        $this->contacto_model->guardarContacto($nombre, $mobile, $current_timestamp, $email, $identificacion);
        $message = [
            'type' => "success"
        ];


        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }
/*
    public function producto_post() {
        $data = $this->post();
        //log_message('error', 'Entre');
        //log_message('error', json_encode($data));
        $user = $this->factura_model->getUser();
        $message = [
            'type' => "error",
            'message' => $user
        ];


        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }
*/
}
