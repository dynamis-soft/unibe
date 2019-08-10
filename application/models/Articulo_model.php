<?php

class Articulo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function obtenerTodos($categoria) {
        $sql = "select 
            a.ARTICULO,a.DESCRIPCION,c.PRECIO,b.NIVEL_PRECIO,i.IMPUESTO1
        from
         [CAPACITA].[hospital].[ARTICULO] A
         inner join 
        (select NIVEL_PRECIO,ARTICULO, max(VERSION) as VERSION from [CAPACITA].[hospital].[ARTICULO_PRECIO] GROUP BY NIVEL_PRECIO,ARTICULO) as b on
         a.ARTICULO = b.ARTICULO
          inner join [CAPACITA].[hospital].[ARTICULO_PRECIO] c 
          on b.ARTICULO=c.ARTICULO and b.NIVEL_PRECIO=c.NIVEL_PRECIO and b.VERSION= c.VERSION 
		  INNER JOIN [CAPACITA].[hospital].[IMPUESTO] i 
		  ON a.IMPUESTO = i.IMPUESTO
          where a.ACTIVO = 'S' 
        ";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records;
    }

    function actualizar() {
        $sql = "select 
            a.ARTICULO,a.DESCRIPCION,c.PRECIO,b.NIVEL_PRECIO,i.IMPUESTO1
        from
         [CAPACITA].[hospital].[ARTICULO] A
         inner join 
        (select NIVEL_PRECIO,ARTICULO, max(VERSION) as VERSION from [CAPACITA].[hospital].[ARTICULO_PRECIO] GROUP BY NIVEL_PRECIO,ARTICULO) as b on
         a.ARTICULO = b.ARTICULO
          inner join [CAPACITA].[hospital].[ARTICULO_PRECIO] c 
          on b.ARTICULO=c.ARTICULO and b.NIVEL_PRECIO=c.NIVEL_PRECIO and b.VERSION= c.VERSION 
		  INNER JOIN [CAPACITA].[hospital].[IMPUESTO] i 
		  ON a.IMPUESTO = i.IMPUESTO
          where a.ACTIVO = 'S' AND a.FCH_HORA_ULT_MODIF >  DATEADD(MINUTE , -5,  GetDate())";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records;
    }

    function bodega() {
        $sql = "select 
          BODEGA
        from
         [CAPACITA].[hospital].BODEGA";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records;
    }
    function impuesto($codigo) {
        $sql = "select 
          TIPO_TARIFA1, TIPO_IMPUESTO1,IMPUESTO1,IMPUESTO,TIPO_TARIFA2,TIPO_IMPUESTO2,IMPUESTO2
        from
         [CAPACITA].[hospital].IMPUESTO where IMPUESTO like '%$codigo%'";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records[0];
    }
    
        function impuestobyarticulo($codigo) {
        $sql = "select IMPUESTO
            from hospital.ARTICULO where articulo like '%$codigo%'";
        $query = $this->db->query($sql);
        $records = $query->result();
        return $records[0]->IMPUESTO;
    }
}
