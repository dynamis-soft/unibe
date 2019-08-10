<?php

class Contacto_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarContacto($data) {
        try {
            $fecha = date('Y-m-d H:i:s');
            $sql = "SELECT * FROM hospital.CLIENTE where CONTRIBUYENTE = '" . $data['identificacion'] . "'";
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
                    'NIVEL_PRECIO' => $data['precio'],
                    'DIRECCION' => $data['direccion']
                );
                $this->db->where('CONTRIBUYENTE', $data['identificacion']);
                return $this->db->update('hospital.CLIENTE', $data3);
            } else {
                $sql = "SELECT ULTIMO_VALOR cantidad FROM [CAPACITA].[hospital].[CONSECUTIVO] where consecutivo='PACIENTE'";
                $query = $this->db->query($sql);
                $id = $query->result()[0]->cantidad;
                $id = str_replace("PAC", "", $id);
                $id = (int) $id + 1;
                $sql = "SELECT * FROM hospital.NIT where NIT = '" . $data['identificacion'] . "'";
                $query = $this->db->query($sql);


                if ($query->num_rows() < 1) {
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
                }
                $sql = "SELECT TOP (1) DETALLE_DIRECCION cantidad  FROM [CAPACITA].[hospital].[DETALLE_DIRECCION] ORDER BY DETALLE_DIRECCION DESC ";
                $query = $this->db->query($sql);
                $id2 = $query->result()[0]->cantidad;

                $arrayDireccion = array(
                    'DETALLE_DIRECCION' => (int) $id2 + 1,
                    'DIRECCION' => "ESTANDAR",
                    'CAMPO_1' => $data['direccion'],
                    'createdBy' => "FA/SA",
                    'updatedBy' => "FA/SA"
                );
                $this->db->insert('hospital.DETALLE_DIRECCION', $arrayDireccion);
                $data2 = array(
                    'ZONA' => "CLIE",
                    'CLASE_DOCUMENTO' => "N",
                    'DETALLE_DIRECCION' => $id2,
                    'CLASE_ABC' => "A",
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
                    'LOCAL' => 'L',
                    'MONEDA' => "CRC",
                    'VENDEDOR' => "ND",
                    'MULTIMONEDA' => "S",
                    'CONTRIBUYENTE' => $data['identificacion'],
                    'CARGO' => "",
                    'CONTACTO' => "ND",
                    'GLN' => $data['GLN'],
                    'CLIENTE' => "PAC00" . $id,
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
                    'NIVEL_PRECIO' => $data['precio'],
                    'DIRECCION' => $data['direccion'],
                    'CODIGO_IMPUESTO' => $data['codimpuesto'],
                    'DIR_EMB_DEFAULT' => "ND",
                    'AFECTACION_IVA' => $data['iva'],
                    'TIPIFICACION_CLIENTE' => $data['tipocliente'],
                    'TIPO_TARIFA' => $data['TIPO_TARIFA1'],
                    'TIPO_IMPUESTO' => $data['TIPO_IMPUESTO1'],
                    'PORC_TARIFA' => $data['IMPUESTO1'],
                    
                );
                $this->db->insert('hospital.CLIENTE', $data2);
                $arrayDireccion2 = array(
                    'CLIENTE' => "PAC00" . $id,
                    'DIRECCION' => "ND",
                    'NoteExistsFlag' => 0,
                    'createdBy' => "FA/SA",
                    'updatedBy' => "FA/SA"
                );
                $this->db->insert('hospital.DIRECC_EMBARQUE', $arrayDireccion2);
                $data3 = array(
                    'ULTIMO_VALOR' => "PAC00" . $id
                );
                $this->db->where('consecutivo', 'PACIENTE');
                $this->db->update('hospital.CONSECUTIVO', $data3);
                return "1";
            }
        } catch (Exception $ex) {
            return "0";
        }
    }

}
