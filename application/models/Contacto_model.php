<?php

class Contacto_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarContacto($data) {
        $fecha = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM hospital.CLIENTE where cliente = '" . $data['identificacion'] . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data3 = array(
                'GLN' => trim($data['GLN']),
                'NOMBRE' => trim($data['nombre']),
                'ALIAS' => trim($data['nombre']),
                'TELEFONO1' => trim($data['mobile']),
                'FECHA_INGRESO' => $fecha,
                'E_MAIL' => trim($data['email']),
                'EMAIL_DOC_ELECTRONICO' => trim($data['email']),
                'ACEPTA_DOC_ELECTRONICO' => $data['confirma'],
                'CONFIRMA_DOC_ELECTRONICO' => $data['utiliza'],
                'DIVISION_GEOGRAFICA1' => $data['provincia'],
                'DIVISION_GEOGRAFICA2' => $data['canton'],
                'DIVISION_GEOGRAFICA3' => $data['distrito'],
                'DIVISION_GEOGRAFICA4' => $data['barrio'],
                'NIVEL_PRECIO' => $data['precio']
            );
            $this->db->where('CLIENTE', $data['identificacion']);
            return $this->db->update('hospital.CLIENTE', $data3);
        } else {
            $arrayNit = array(
                'NIT' => $data['identificacion'],
                'RAZON_SOCIAL' => trim($data['nombre']),
                'ALIAS' => trim($data['nombre']),
                'NOTAS' => "",
                'TIPO' => trim($data['tipoIdentificacion']),
                'NoteExistsFlag' => 0,
                'RecordDate' => $fecha,
                'CreateDate' => $fecha,
                'USA_REPORTE_D151' => "N",
                'ORIGEN' => "O",
                'NUMERO_DOC_NIT' => $data['identificacion'],
                'EXTERIOR' => '0',
                'NATURALEZA' => 'N',
                'ACTIVO' => 'S'
            );
            $this->db->insert('hospital.NIT', $arrayNit);
            $sql = "SELECT ULTIMO_VALOR cantidad FROM [CAPACITA].[hospital].[CONSECUTIVO] where consecutivo='CLIENTE'";
            $query = $this->db->query($sql);
            $id = $query->result()[0]->cantidad;
            $id = str_replace("C", "", $id);
            $id = (int) $id + 1;
            $data2 = array(
                'ZONA' => "CLIE",
                'CLASE_DOCUMENTO' => "",
                'AJUSTE_FECHA_COBRO' => "",
                'USAR_EXENCIMP_CORP' => "",
                'USAR_PRECIOS_CORP' => "",
                'ASOCOBLIGCONTFACT' => "",
                'DIAS_PROMED_ATRASO' => 0,
                'TIENE_CONVENIO' => "",
                'DOC_A_GENERAR' => "F",
                'USAR_DESC_CORP' => "",
                'VERIF_LIMCRED_CORP' => "",
                'APLICAC_ABIERTAS' => "",
                'USAR_DIREMB_CORP' => "",
                'REGISTRARDOCSACORP' => "",
                'ES_CORPORACION' => "",
                'REQUIERE_OC' => "",
                'USA_TARJETA' => "",
                'DIAS_ABASTECIMIEN' => 0,
                'CATEGORIA_CLIENTE' => "002",
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
                'CONTRIBUYENTE' => $data['identificacion'],
                'CARGO' => "",
                'CONTACTO' => "ND",
                'GLN' => $data['GLN'],
                'CLIENTE' => "C00" . $id,
                'NOMBRE' => $data['nombre'],
                'ALIAS' => $data['nombre'],
                'TELEFONO1' => $data['mobile'],
                'FECHA_INGRESO' => $fecha,
                'E_MAIL' => $data['email'],
                'EMAIL_DOC_ELECTRONICO' => $data['email'],
                'ACEPTA_DOC_ELECTRONICO' => $data['confirma'],
                'CONFIRMA_DOC_ELECTRONICO' => $data['utiliza'],
                'DIVISION_GEOGRAFICA1' => $data['provincia'],
                'DIVISION_GEOGRAFICA2' => $data['canton'],
                'DIVISION_GEOGRAFICA3' => $data['distrito'],
                'DIVISION_GEOGRAFICA4' => $data['barrio'],
                'NIVEL_PRECIO' => $data['precio']
            );
            $this->db->insert('hospital.CLIENTE', $data2);
            $data3 = array(
                'ULTIMO_VALOR' => "C00" . $id
            );
            $this->db->where('consecutivo', 'CLIENTE');
            return $this->db->update('hospital.CONSECUTIVO', $data3);
        }
    }

}
