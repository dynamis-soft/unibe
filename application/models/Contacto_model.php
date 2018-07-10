<?php

class Contacto_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarContacto($nombre, $telefono, $fecha, $email, $identificacion) {
        //if existe actualiza y si no inserta

        $query = $this->db
                ->get_where('unibe.CLIENTE', ['CLIENTE' => $identificacion]);
        $contacto = $query->last_row();
        if (!empty($contacto)) {
            $data = array(
                'NOMBRE' => $nombre,
                'TELEFONO1' => $telefono,
                'FECHA_INGRESO' => $fecha,
                'E_MAIL' => $email
            );
            $this->db->where('CLIENTE', $identificacion);
            return $this->db->update('unibe.CLIENTE', $data);
        } else {
            $data = array(
                'ZONA' => "ND",
                'CLASE_DOCUMENTO' => "",
                'AJUSTE_FECHA_COBRO' => "",
                'USAR_EXENCIMP_CORP' => "",
                'USAR_PRECIOS_CORP' => "",
                'ASOCOBLIGCONTFACT' => "",
                'DIAS_PROMED_ATRASO' => 0,
                'TIENE_CONVENIO' => "",
                'DOC_A_GENERAR' => "",
                'USAR_DESC_CORP' => "",
                'VERIF_LIMCRED_CORP' => "",
                'APLICAC_ABIERTAS' => "",
                'USAR_DIREMB_CORP' => "",
                'REGISTRARDOCSACORP' => "",
                'ES_CORPORACION' => "",
                'REQUIERE_OC' => "",
                'USA_TARJETA' => "",
                'DIAS_ABASTECIMIEN' => 0,
                'CATEGORIA_CLIENTE' => "ND",
                'COBRO_JUDICIAL' => "",
                'EXENCION_IMP2' => 0,
                'EXENCION_IMP1' => 0,
                'EXENTO_IMPUESTOS' => "",
                'ACTIVO' => "S",
                'ACEPTA_FRACCIONES' => "",
                'COBRADOR' => "ND",
                'RUTA' => "ND",
                'PAIS' => "CRI",
                'ACEPTA_BACKORDER' => "",
                'MONEDA_NIVEL' => "L",
                'DESCUENTO' => 0,
                'NIVEL_PRECIO' => "ND-LOCAL",
                'CONDICION_PAGO' => 0,
                'FECHA_ULT_MOV' => "",
                'FECHA_ULT_MORA' => "",
                'TASA_INTERES_MORA' => 0,
                'TASA_INTERES' => 0,
                'EXCEDER_LIMITE' => "N",
                'SALDO_CREDITO' => 0,
                'SALDO_DOLAR' => 0,
                'SALDO_LOCAL' => 0,
                'SALDO' => 0,
                'MONEDA' => "CRC",
                'MULTIMONEDA' => "S",
                'CONTRIBUYENTE' => "ND",
                'CARGO' => "",
                'CONTACTO' => "ND",
                'CLIENTE' => $identificacion,
                'NOMBRE' => $nombre,
                'TELEFONO1' => $telefono,
                'FECHA_INGRESO' => $fecha,
                'E_MAIL' => $email
            );

            $this->db->insert('unibe.CLIENTE', $data);
        }
    }

}
