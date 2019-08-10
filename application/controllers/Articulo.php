<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
      function cargartodos() {
      $result = $this->articulo_model->obtenerTodos('WECARE');
      $data = array();
      foreach ($result as $item) {
      if (empty($data[$item->ARTICULO])) {
      $data[] = array("codigo" => $item->ARTICULO, "name" => $item->DESCRIPCION, "precio" => $item->PRECIO, "nivel" => $item->NIVEL_PRECIO, "impuesto" => $item->IMPUESTO );
      }
      }
      $xml = '<?xml version="1.0" encoding="utf-8"?>
      <Products>';
      $i = 1;
      foreach ($data as $item) {
      $xml .= '<row no = "' . $i . '">
      <FL val = "Product Code">' . $item['codigo'] . '</FL>
      <FL val = "Product Name">' . $item['name'] . '</FL>
      <FL val = "Precio">' . $item['precio'] . '</FL>
      <FL val = "Nivel">' . $item['nivel'] . '</FL>
      <FL val = "Tax">' . $item['impuesto'] . '</FL>
      </row>';
      $i++;
      }

      $xml .= '</Products>';

      //$result = $this->zoho->saveArticulo(json_encode($json));
      $result = $this->zoho->crearArticulo($xml);
      echo $result;
      }
     */

    function actualizar() {
        $result = $this->articulo_model->actualizar();
        $xml = '<?xml version="1.0" encoding="utf-8"?>
                <Products>';
        if (count($result) > 0) {
            $i = 1;
            foreach ($result as $item) {
                $xml .= '<row no = "' . $i . '">
                <FL val = "Product Code">' . $item->ARTICULO . '</FL>
                <FL val = "Product Name">' . $item->DESCRIPCION . '</FL>
                <FL val = "Unit Price">' . number_format($item->PRECIO, 2) . '</FL>
                <FL val = "Nivel">' . $item->NIVEL_PRECIO . '</FL>
                <FL val = "Tax">' . $item->IMPUESTO1 . '</FL>
                </row>';
                $i++;
            }
            $xml .= '</Products>';
            $result = $this->zoho->actualizarArticulo($xml);
        }

  
    }

}
