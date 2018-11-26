<?php

class Articulo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function obtenerTodos() {
        $sql = "SELECT TOP (2) ARTICULO, DESCRIPCION  FROM [CAPACITA].[hospital].[ARTICULO]";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records;
    }

    function actualizar() {
        $sql = "SELECT TOP (2) ARTICULO, DESCRIPCION   FROM [CAPACITA].[hospital].[ARTICULO] WHERE FCH_HORA_ULT_MODIF >  DATEADD(MINUTE , -5,  GetDate())";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records;
    }

}
