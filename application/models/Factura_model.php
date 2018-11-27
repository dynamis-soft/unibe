<?php

class Factura_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function guardarFactura($nombre, $identificacion, $profesional, $productos) {
        //if existe actualiza y si no inserta
        $sql = "SELECT VALOR_CONSECUTIVO cantidad FROM [CAPACITA].[hospital].[Consecutivo_FA] where codigo_consecutivo='PEDIDO'";
        $query = $this->db->query($sql);
        $id = $query->result()[0]->cantidad;
        $sql = "SELECT CLIENTE cliente FROM [CAPACITA].[hospital].[CLIENTE] where CONTRIBUYENTE = '$identificacion'";
        $query = $this->db->query($sql);
        $cliente = $query->result()[0]->cliente;
        $id = str_replace("PED", "", $id);
        $id = (int) $id + 1;
        $data = array(
            'PEDIDO' => "PED00" . $id,
            'ESTADO' => "N",
            'FECHA_PEDIDO' => date('Y-m-d H:i:s'),
            'FECHA_PROMETIDA' => date('Y-m-d H:i:s'),
            'FECHA_PROX_EMBARQU' => date('Y-m-d H:i:s'),
            'FECHA_ULT_EMBARQUE' => "1980-01-01 00:00:00.000",
            'FECHA_ULT_CANCELAC' => "1980-01-01 00:00:00.000",
            'ORDEN_COMPRA' => NULL,
            'FECHA_ORDEN' => date('Y-m-d H:i:s'),
            'TARJETA_CREDITO' => '',
            'EMBARCAR_A' => $nombre,
            'DIREC_EMBARQUE' => 'ND',
            'DIRECCION_FACTURA' => 'ND',
            'RUBRO1' => NULL,
            'RUBRO2' => NULL,
            'RUBRO3' => NULL,
            'RUBRO4' => NULL,
            'RUBRO5' => $profesional,
            'OBSERVACIONES' => "",
            'COMENTARIO_CXC' => NULL,
            'TOTAL_MERCADERIA' => 0.00000000,
            'MONTO_ANTICIPO' => 0.00000000,
            'MONTO_FLETE' => 0.00000000,
            'MONTO_SEGURO' => 0.00000000,
            'MONTO_DOCUMENTACIO' => 0.00000000,
            'TIPO_DESCUENTO1' => 'P',
            'TIPO_DESCUENTO2' => 'P',
            'MONTO_DESCUENTO1' => 0.00000000,
            'MONTO_DESCUENTO2' => 0.00000000,
            'PORC_DESCUENTO1' => 0.00000000,
            'PORC_DESCUENTO2' => 0.00000000,
            'TOTAL_IMPUESTO1' => 0.00000000,
            'TOTAL_IMPUESTO2' => 0.00000000,
            'TOTAL_A_FACTURAR' => 0.00000000,
            'PORC_COMI_VENDEDOR' => 0.00000000,
            'PORC_COMI_COBRADOR' => 0.00000000,
            'TOTAL_CANCELADO' => 0.00000000,
            'TOTAL_UNIDADES' => 0.00000000,
            'IMPRESO' => 'N',
            'FECHA_HORA' => date('Y-m-d H:i:s'),
            'DESCUENTO_VOLUMEN' => 0.00000000,
            'TIPO_PEDIDO' => 'N',
            'MONEDA_PEDIDO' => 'L',
            'VERSION_NP' => 1,
            'AUTORIZADO' => 'N',
            'DOC_A_GENERAR' => 'F',
            'CLASE_PEDIDO' => 'N',
            'MONEDA' => 'L',
            'NIVEL_PRECIO' => 'CLINICA',
            'COBRADOR' => 'ND',
            'RUTA' => 'EMPL',
            'USUARIO' => 'SA',
            'CONDICION_PAGO' => 60,
            'BODEGA' => '006',
            'ZONA' => 'EMPL',
            'VENDEDOR' => 'ND',
            'CLIENTE' => $cliente,
            'CLIENTE_DIRECCION' => $cliente,
            'CLIENTE_CORPORAC' => $cliente,
            'CLIENTE_ORIGEN' => $cliente,
            'PAIS' => 'CRI',
            'SUBTIPO_DOC_CXC' => 0,
            'TIPO_DOC_CXC' => 'FAC',
            'BACKORDER' => 'N',
            'CONTRATO' => NULL,
            'PORC_INTCTE' => 0.00000000,
            'DESCUENTO_CASCADA' => 'N',
            'TIPO_CAMBIO' => NULL,
            'FIJAR_TIPO_CAMBIO' => 'N',
            'ORIGEN_PEDIDO' => 'F',
            'DESC_DIREC_EMBARQUE' => NULL,
            'DIVISION_GEOGRAFICA1' => NULL,
            'DIVISION_GEOGRAFICA2' => NULL,
            'BASE_IMPUESTO1' => NULL,
            'BASE_IMPUESTO2' => NULL,
            'NOMBRE_CLIENTE' => $nombre,
            'FECHA_PROYECTADA' => date('Y-m-d H:i:s'),
            'NoteExistsFlag' => 0,
            'RecordDate' => date('Y-m-d H:i:s'),
            'CreatedBy' => 'FA/SA',
            'UpdatedBy' => 'FA/SA',
            'CreateDate' => date('Y-m-d H:i:s'),
            'FECHA_APROBACION' => NULL,
            'TIPO_DOCUMENTO' => 'P',
            'VERSION_COTIZACION' => NULL,
            'RAZON_CANCELA_COTI' => NULL,
            'DES_CANCELA_COTI' => NULL,
            'CAMBIOS_COTI' => NULL,
            'COTIZACION_PADRE' => NULL,
            'TASA_IMPOSITIVA' => NULL,
            'TASA_IMPOSITIVA_PORC' => 0.00000000,
            'TASA_CREE1' => NULL,
            'TASA_CREE1_PORC' => 0.00000000,
            'TASA_CREE2' => NULL,
            'TASA_CREE2_PORC' => 0.00000000,
            'TASA_GAN_OCASIONAL_PORC' => 0.00000000,
            'CONTRATO_AC' => NULL,
            'TIPO_CONTRATO_AC' => NULL,
            'PERIODICIDAD_CONTRATO_AC' => NULL,
            'FECHA_CONTRATO_AC' => NULL,
            'FECHA_INICIO_CONTRATO_AC' => NULL,
            'FECHA_PROXFAC_CONTRATO_AC' => NULL,
            'FECHA_FINFAC_CONTRATO_AC' => NULL,
            'FECHA_ULTAUMENTO_CONTRATO_AC' => NULL,
            'FECHA_PROXFACSIST_CONTRATO_AC' => NULL,
            'DIFERIDO_CONTRATO_AC' => NULL,
            'TOTAL_CONTRATO_AC' => NULL,
            'CONTRATO_REVENTA' => 'N',
            'USR_NO_APRUEBA' => NULL,
            'FECHA_NO_APRUEBA' => NULL,
            'RAZON_DESAPRUEBA' => NULL,
            'MODULO' => NULL,
            'CORREOS_ENVIO' => NULL,
            'USO_CFDI' => NULL,
            'CONTRATO_VIGENCIA_DESDE' => NULL,
            'CONTRATO_VIGENCIA_HASTA' => NULL,
            'FORMA_PAGO' => NULL,
            'CLAVE_REFERENCIA_DE' => NULL,
            'FECHA_REFERENCIA_DE' => NULL
        );

        $this->db->insert('hospital.PEDIDO', $data);

        $data3 = array(
            'VALOR_CONSECUTIVO' => $id
        );
        $this->db->where('codigo_consecutivo', 'PEDIDO');
        $this->db->update('hospital.Consecutivo_FA', $data3);
        $i = 1;

        foreach ($productos as $product) {
            $data4 = array(
                'PEDIDO' => "PED00" . $id,
                'PEDIDO_LINEA' => $i,
                'BODEGA' => 'ND',
                'LOTE' => NULL,
                'LOCALIZACION' => NULL,
                'ARTICULO' => $product,
                'ESTADO' => "F",
                'FECHA_ENTREGA' => date('Y-m-d H:i:s'),
                'LINEA_USUARIO' => $i - 1,
                'PRECIO_UNITARIO' => 0.00000000,
                'CANTIDAD_PEDIDA' => 1.00000000,
                'CANTIDAD_A_FACTURA' => 0.00000000,
                'CANTIDAD_FACTURADA' => 1.00000000,
                'CANTIDAD_RESERVADA' => 0.00000000,
                'CANTIDAD_BONIFICAD' => 0.00000000,
                'CANTIDAD_CANCELADA' => 0.00000000,
                'TIPO_DESCUENTO' => 'P',
                'MONTO_DESCUENTO' => 0.00000000,
                'PORC_DESCUENTO' => 0.00000000,
                'DESCRIPCION' => '',
                'COMENTARIO' => '',
                'PEDIDO_LINEA_BONIF' => NULL,
                'UNIDAD_DISTRIBUCIO' => NULL,
                'FECHA_PROMETIDA' => date('Y-m-d H:i:s'),
                'LINEA_ORDEN_COMPRA' => NULL,
                'PROYECTO' => NULL,
                'FASE' => NULL,
                'NoteExistsFlag' => 0,
                'RecordDate' => date('Y-m-d H:i:s'),
                'CreatedBy' => '',
                'UpdatedBy' => '',
                'CreateDate' => NULL,
                'CENTRO_COSTO' => NULL,
                'CUENTA_CONTABLE' => NULL,
                'RAZON_PERDIDA' => NULL,
                'TIPO_DESC' => 0
            );
            $this->db->insert('hospital.PEDIDO_LINEA', $data4);
            $i++;
        }
    }

    function existeFactura($id) {
        $sql = "  SELECT count(*) cantidad
        FROM [CAPACITA].[hospital].[PEDIDO] where PEDIDO= '$id';";
        $query = $this->db->query($sql);
        $id = $query->result()[0]->cantidad;
        return $id;
    }

}
