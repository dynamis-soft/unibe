<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zoho {

    function crearEvento($xml) {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/xml/Deals/insertRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&newFormat=1&xmlData=" . $xml;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function buscarContacto() {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/xml/Contacts/getRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&newFormat=1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function buscarContactoJson() {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/json/Contacts/getRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function crearContacto($xml) {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/xml/Contacts/insertRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&xmlData=" . $xml;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

//https://crm.zoho.com/crm/private/json/Leads/getRecords?authtoken=Auth Token&scope=crmapi
    function getOpciones() {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/json/Leads/getRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&selectColumns=Deals(Stage)";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function getOportunidad() {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/json/Deals/getRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function crearArticulo($xml) {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/xml/Products/insertRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&newFormat=1&xmlData=" . $xml;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

        function actualizarArticulo($xml) {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/xml/Products/updateRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&newFormat=1&xmlData=" . $xml;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    function getArticulo($id) {
        $token = "AUTHTOKEN";
        $url = "https://crm.zoho.com/crm/private/json/Products/getRelatedRecords";
        $param = "authtoken=" . TOKEN . "&scope=crmapi&parentModule=Deals&id=" . $id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function saveArticulo($param) {
        $token = "AUTHTOKEN";
        $url = "https://www.zohoapis.com/crm/v2/Products";
        $header = array(
            'Authorization: Zoho-oauthtoken ' . TOKEN,
            '@newproduct.json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*
      function token() {
      //GET URL from Post
      $url = "https://accounts.zoho.com/oauth/v2/auth?code=authorization_code&redirect_uri=http://ec2-52-86-138-151.compute-1.amazonaws.com/api/api/oauth2callback&client_id=1000.PIJLWFPQ7X7Z4606986EZK4J7QW8EV&client_secret=dcdc5fd834f26c8b8ae65ea363230065847aba9f1f&grant_type=authorization_code";
      //Making the options
      $options = array(
      'http' => array(
      'header' => "Content-type: application/x-www-form-urlencoded\r\n",
      'method' => 'POST'
      )
      );
      $context = stream_context_create($options);
      $result = @file_get_contents($url, false, $context);
      if ($result === FALSE) {
      return "99";
      } else {
      $result = file_get_contents($url, true, $context);
      $ar = json_decode($result);
      return $ar;
      }
      }
     * 
     */
}
