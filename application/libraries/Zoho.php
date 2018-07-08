<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zoho {

    function token() {
        //GET URL from Post    
        $url = "https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoCreator/creatorapi&EMAIL_ID=" . USER . "&PASSWORD=" . PASSWORD;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: bf8dc171-5bb7-fa54-7416-56c5cda9bf5c"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "CURL Error #:" . $err;
        } else {
            $responseT = json_decode($response);
            return $responseT;
        }
    }

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

}
