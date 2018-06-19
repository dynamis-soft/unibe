<?php

class Contacto_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarContacto($nombre,$telefono,$fecha,$email,$identificacion) {
        $data = array(
            'NOMBRE' => $nombre,
            'TELEFONO1' => $telefono,
            'FECHA_INGRESO' => $fecha,
            'E_MAIL' => $email,
            'SUBTIPODOC' => $identificacion
        );

        $this->db->insert('unibe.CLIENTE', $data);
    }

}
