<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function cargartodos() {
        $result = $this->articulo_model->obtenerTodos();
        /*
          foreach($result as $item){
          $data[] = array("Product_Code"=>$item->ARTICULO,"Product_Name"=>$item->DESCRIPCION);
          }
          $json = array("data"=>$data);
         * 
         */
        $xml = '<?xml version="1.0" encoding="utf-8"?>
                <Products>';
        $i = 1;
        foreach ($result as $item) {
            $xml .= '<row no = "' . $i . '">
                <FL val = "Product Code">' . $item->ARTICULO . '</FL>
                <FL val = "Product Name">' . $item->DESCRIPCION . '</FL>
                </row>';
            $i++;
        }

        $xml .= '</Products>';
        // $result = $this->zoho->saveArticulo(json_encode($json));
        $result = $this->zoho->crearArticulo($xml);
    }
    function actualizar() {
        $result = $this->articulo_model->obtenerTodos();
        /*
          foreach($result as $item){
          $data[] = array("Product_Code"=>$item->ARTICULO,"Product_Name"=>$item->DESCRIPCION);
          }
          $json = array("data"=>$data);
         * 
         */
        $xml = '<?xml version="1.0" encoding="utf-8"?>
                <Products>';
        $i = 1;
        foreach ($result as $item) {
            $xml .= '<row no = "' . $i . '">
                <FL val = "Product Code">' . $item->ARTICULO . '</FL>
                <FL val = "Product Name">' . $item->DESCRIPCION . '</FL>
                </row>';
            $i++;
        }

        $xml .= '</Products>';
        // $result = $this->zoho->saveArticulo(json_encode($json));
        $result = $this->zoho->crearArticulo($xml);
    }
}
