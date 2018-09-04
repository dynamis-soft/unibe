<?php

class Contacto_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarContacto($nombre, $telefono, $fecha, $email, $identificacion,$docgenerar, $GLN, $acepta, $utiliza,$tipoIdentificacion) {
        $tipo = explode(" ",$tipoIdentificacion);
        //if existe actualiza y si no inserta
        $sql = "SELECT * FROM hospital.CLIENTE where cliente = '" . trim($identificacion) . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = array(
                'GLN' => trim($GLN),
                'NOMBRE' => trim($nombre),
                'ALIAS' => trim($nombre),
                'TELEFONO1' => trim($telefono),
                'E_MAIL' => trim($email),
                'EMAIL_DOC_ELECTRONICO' => trim($email),
                'ACEPTA_DOC_ELECTRONICO' => trim($acepta),
                'CONFIRMA_DOC_ELECTRONICO' => trim($utiliza),
                'TIPO_CONTRIBUYENTE' => trim($tipo[0]),
            );
            $query = $this->db->update('hospital.CLIENTE', $data, array('CLIENTE' => trim($identificacion)));
            print_r($query);
            return $query;
        } else {
            $data = array(
                'ZONA' => "CLIE",
                'CLASE_DOCUMENTO' => "",
                'AJUSTE_FECHA_COBRO' => "",
                'USAR_EXENCIMP_CORP' => "",
                'USAR_PRECIOS_CORP' => "",
                'ASOCOBLIGCONTFACT' => "",
                'DIAS_PROMED_ATRASO' => 0,
                'TIENE_CONVENIO' => "",
                'DOC_A_GENERAR' => /* trim($docgenerar) */"",
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
                'RUTA' => "CLIE",
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
                'GLN' => trim($GLN),
                'CLIENTE' => trim($identificacion),
                'NOMBRE' => trim($nombre),
                'ALIAS' => trim($nombre),
                'TELEFONO1' => trim($telefono),
                'FECHA_INGRESO' => trim($fecha),
                'E_MAIL' => trim($email),
                'EMAIL_DOC_ELECTRONICO' => trim($email),
                'ACEPTA_DOC_ELECTRONICO' => trim($acepta),
                'CONFIRMA_DOC_ELECTRONICO' => trim($utiliza),
                'TIPO_CONTRIBUYENTE' => trim($tipo[0]),
            );

            $this->db->insert('hospital.CLIENTE', $data);
        }
    }

}
