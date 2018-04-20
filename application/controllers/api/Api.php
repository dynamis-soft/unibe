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
        if (array_key_exists('data', $data)) {
            foreach ($data['data']['patient']['phones'] as $telefono) {
                $telefonos .= " Tipo: " . $telefono['type'] . " " . $telefono['number'];
            }
            $enfermedades = "";
            foreach ($data['data']['patient']['insurances'] as $enfermedad) {
                $telefonos .= $enfermedad['name'] . " ";
            }
            $description = "Usuario :" . 'user ' . $data['data']['user']['name'] . ". Doctor: " . $data['data']['doctor']['name'] .
                    ". Clinica: " . $data['data']['clinic']['name'] . ". Paciente: " . $data['data']['patient']['name'] . " - " . $data['data']['patient']['email']
                    . " - " . $telefonos . ". Motivo: " . $enfermedades;
            $xml = '<?xml version="1.0" encoding="utf-8"?>
                <Deals>
                <row no = "1">
                <FL val = "Description">' . $description . '</FL>
                <FL val = "Stage">Contacto Inicial</FL>
                <FL val = "Deal Name">Cita Huli ' . $data['data']['patient']['name'] . '</FL> 
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

}
