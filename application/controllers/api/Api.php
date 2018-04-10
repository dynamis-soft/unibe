<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_controller.php';

class Api extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    /* APIS GENERALES */

    public function huli_post() {
        /*
         * 
         * 
          {
          "id": "evt_589c2fbbc62596f2e11ea6e77ed4cf03",
          "type": "appointment.booked",
          "data": {
          "id": "apt_acbe8095f5353c89c62cba19c2596844",
          "dateFrom": "2017-10-06T15:00:00",
          "dateTo": "2017-10-06T16:00:00",
          "status": "booked",
          "user": {
          "name": "Asistente Metropolitano"
          },
          "doctor": {
          "name": "Julio Health",
          "specialties": [
          {
          "name": "Cardiology"
          },
          {
          "name": "Cardiothoracic Surgery"
          }
          ]
          },
          "clinic": {
          "name": "Huli Clinic"
          },
          "patient": {
          "email": "julio@huli.io",
          "name": "Julio Health",
          "phones": [
          {
          "iso2": "CR",
          "number": "88888888",
          "extension": "123",
          "type": "home"
          },
          {
          "iso2": "CR",
          "number": "88888888",
          "type": "mobile"
          }
          ],
          "ids": [
          {
          "type": "identification",
          "number": "1-2345-6789"
          },
          {
          "type": "other",
          "number": "CLI0001"
          }
          ],
          "insurances": [
          {
          "name": "Medismart",
          "number": "MED123"
          }
          ]
          }
          }
          }
         */

        $message = [
            'type' => "success",
            'message' => "Operacion exitosa",
        ];


        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

}
