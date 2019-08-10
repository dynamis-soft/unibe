<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_controller.php';

class Api extends REST_Controller {

    function __construct() {
        parent::__construct();
        if (!($this->zohov2->getEstado())) {
            $this->errorDeRequest("Hubo un error al iniciar el API de Zoho. Intente de nuevo en un rato.");
        }
    }

    public function facturacion_post() {
        try {
            $post = $this->post();
            $deals = $this->zohov2->obtenerInformacion($post['id'], "Deals");
            $contact = $deals["respuesta"]->data[0]->Contact_Name;
            $id_contacto = $contact->id;
            $facturas = $deals["respuesta"]->data[0]->Facturas;
            $id_facturas = $facturas->id;
            $profesional = $deals["respuesta"]->data[0]->Profesional;

            $contact = $this->zohov2->obtenerInformacion($id_contacto, "Contacts");
            $nombre = $contact["respuesta"]->data[0]->Full_Name;
            $identificacion = $contact["respuesta"]->data[0]->identificacion;
            $nivelprecio = $contact["respuesta"]->data[0]->Nivel_Precio;
            $invoices = $this->zohov2->obtenerInformacion($id_facturas, "Invoices");
            $total = number_format($invoices["respuesta"]->data[0]->Grand_Total, 5, ".", "");
            $descuento = number_format($invoices["respuesta"]->data[0]->Discount, 5, ".", "");
            $medico = $invoices["respuesta"]->data[0]->Descuento_M_dico;
     
            $productos = array();
            foreach ($invoices["respuesta"]->data[0]->Product_Details as $product) {
                $product_search = $this->zohov2->obtenerInformacion($product->product->id, "Products");
                $productos[] = array("code" => $product->product->Product_Code, "price" => number_format($product->unit_price, 5, ".", ""),
                    "discount" => number_format($product->Discount, 5, ".", ""), "quantity" => number_format($product->quantity, 5, ".", ""),
                    "bodega" => $product_search["respuesta"]->data[0]->Bodega);
            }
            $result = $this->factura_model->guardarFactura($nombre, trim($identificacion), trim($profesional), $productos, $descuento, $total, $nivelprecio,$medico);
            if ($result == "1") {
                $message = [
                    'type' => "success",
                    'message' => ""
                ];
            } else {
                $message = [
                    'type' => "error",
                    'message' => ""
                ];
            }
        } catch (Exception $ex) {
            $message = [
                'type' => "error",
                'message' => ""
            ];
        }

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function pedido_post() {
        $post = $this->post();
        $result = $this->factura_model->existeFactura($post['id']);
        $message = [
            'type' => "success",
            'cantidad' => $result
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

    public function contacto_post() {
        $post = $this->post();
        $contacts = $this->zohov2->obtenerInformacion($post['id'], "Contacts");
        $data = array();
        $data['nombre'] = $contacts["respuesta"]->data[0]->Full_Name;
        $value = explode("-", trim($contacts["respuesta"]->data[0]->Tipo_de_ID));
        $data['tipoIdentificacion'] = $value[0];
        $data['mobile'] = str_replace("(506)", "", $contacts["respuesta"]->data[0]->Mobile);
        $data['email'] = $contacts["respuesta"]->data[0]->Email;

        $data['identificacion'] = $contacts["respuesta"]->data[0]->identificacion;
        //$data['docgenerar'] = $contacts["respuesta"]->data[0]->Confirmacion_Electronica;
        if ($contacts["respuesta"]->data[0]->Confirmacion_Electronica == "SI") {
            $data['confirma'] = "S";
        } else
            $data['confirma'] = "N";
        if ($contacts["respuesta"]->data[0]->Documentos_Electronicos == "SI") {
            $data['utiliza'] = "S";
        } else
            $data['utiliza'] = "N";

        $data['precio'] = $contacts["respuesta"]->data[0]->Nivel_Precio;
        $value = explode("-", trim($contacts["respuesta"]->data[0]->PROVINCIA1));
        $data['provincia'] = $value[0];
        $data['canton'] = "";
        $data['distrito'] = "";
        $data['barrio'] = "";
        if ($contacts["respuesta"]->data[0]->Impuesto != '') {
            $value = explode("-", trim($contacts["respuesta"]->data[0]->Impuesto));
            $data['impuesto'] = $value[0];
            $impuestos = $this->articulo_model->impuesto($data['impuesto']);
            $data['codimpuesto'] = $impuestos->IMPUESTO;
            $data['TIPO_TARIFA1'] = $impuestos->TIPO_TARIFA1;
            $data['TIPO_IMPUESTO1'] = $impuestos->TIPO_IMPUESTO1;
            $data['IMPUESTO1'] = $impuestos->IMPUESTO1;
        } else {
            $data['codimpuesto'] = NULL;
            $data['TIPO_TARIFA1'] = NULL;
            $data['TIPO_IMPUESTO1'] = NULL;
            $data['IMPUESTO1'] = NULL;
        }

        $value = explode("-", trim($contacts["respuesta"]->data[0]->Tipo_de_Cliente));
        $data['tipocliente'] = $value[0];
        $value = explode("-", trim($contacts["respuesta"]->data[0]->Afectaci_n_del_IVA));
        $data['iva'] = $value[0];
        foreach ($contacts["respuesta"]->data[0] as $key => $item) {

            if (strpos($key, "Cantones_") !== false && $item != "") {
                $value = explode("-", trim($item));
                if ((int) $value[0] < 10) {
                    $data['canton'] = "0" . $value[0];
                } else {
                    $data['canton'] = $value[0];
                }
            }
            if (strpos($key, "Distrito_Canton_") !== false && $item != "") {
                $value = explode("-", trim($item));
                if ((int) $value[0] < 10) {
                    $data['distrito'] = "0" . $value[0];
                } else {
                    $data['distrito'] = $value[0];
                }
                $data['direccion'] = $value[1];
            }
            if (strpos($key, "Barrio_Distrito") !== false && $item != "") {
                $value = explode("-", trim($item));
                if ((int) $value[0] < 10) {
                    $data['barrio'] = "0" . $value[0];
                } else {
                    $data['barrio'] = $value[0];
                }
            }
        }

        $data['GLN'] = "0000000000000";
        $this->contacto_model->guardarContacto($data);
        $message = [
            'type' => "success"
        ];


        $this->set_response($message, REST_Controller::HTTP_CREATED);
        $response = [
            'status' => "Success",
            'message' => "Paciente creado correctamente",
            'code' => "SUCCESS",
        ];
        $this->set_response($response, REST_Controller::HTTP_CREATED);
    }

}
