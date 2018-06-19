<?php

class Factura_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getUser() {
        $query = $this->db
                ->get_where('user');
        return $query->result();
    }

}
