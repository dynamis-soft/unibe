<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zohov2 {

    private $estado;
    private $token;
    private $idOrganizacion;
    private $requestsHeader;

    function __construct() {
        ZCRMRestClient::initialize();
        $this->estado = $this->generarTokenAcceso();
        $this->token = $this->generarAccessTokenConRefreshToken();
        $this->setValoresCliente();
    }

    // @codeCoverageIgnoreStart
    function generarTokenAcceso() {
        try {
            $oAuthClient = ZohoOAuth::getClientInstance();
            $refreshToken = "1000.b79a3acf422fa48f98458d9300463417.ad30d74ed7dc5de622f4357848757b47";
            $userIdentifier = "rcampos@unibe.ac.cr";
            $oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken, $userIdentifier);
        } catch (ZCRMException $e) {
            return false;
        } catch (Exception $e) {
            return true;
        }
        return true;
    }

    function getEstado() {
        return $this->estado;
    }

    function obtenerContactos() {
        $zcrmModuleIns = ZCRMModule::getInstance("Contacts");
        $bulkAPIResponse = $zcrmModuleIns->getRecords();
        $recordsArray = $bulkAPIResponse->getData(); // $recordsArray - array of ZCRMRecord instances
        foreach ($recordsArray as $value) {
            echo var_dump($value);
        }
    }

    function obtenerContactosbyID($id) {
        $zcrmModuleIns = ZCRMModule::getInstance('Contacts')->getRecord($id);
        $record = $zcrmModuleIns->getData();
        $contactoZoho = $record->getData(); // $recordsArray - array of ZCRMRecord instances
        print_r($contactoZoho);
    }

    function obtenerOportunidades() {
        $zcrmModuleIns = ZCRMModule::getInstance("Deals");
        $bulkAPIResponse = $zcrmModuleIns->getRecords();
        $recordsArray = $bulkAPIResponse->getData(); // $recordsArray - array of ZCRMRecord instances
        foreach ($recordsArray as $value) {
            echo var_dump($value);
        }
    }

    function obtenerOportunidadesbyID($id) {
        $zcrmModuleIns = ZCRMModule::getInstance('Deals')->getRecord($id);
        $record = $zcrmModuleIns->getData();
        $oportunidadZoho = $record->getData(); // $recordsArray - array of ZCRMRecord instances
        return $oportunidadZoho;
    }

    function obtenerContactobyOportunidad($id) {
        try {
            $zcrmRecordIns = ZCRMRecord::getInstance("Deals", $id);
            $bulkAPIResponse = $zcrmRecordIns->getRelatedListRecords("Contacts");
            $relatedDeals = $bulkAPIResponse->getData();
            return $relatedDeals;
        } catch (ZCRMException $e) {
            return null;
        }
        return $relatedDeals;
    }

    function obtenerOportunidadbyContacto($id) {

        try {
            $zcrmRecordIns = ZCRMRecord::getInstance("Contacts", $id);
            $bulkAPIResponse = $zcrmRecordIns->getRelatedListRecords("Deals");
            $relatedDeals = $bulkAPIResponse->getData();
            return $relatedDeals;
        } catch (ZCRMException $e) {
            return null;
        }
        return $relatedDeals;
    }

    function obtenerFacturabyOportunidades($id) {
        try {
            $zcrmRecordIns = ZCRMRecord::getInstance("Deals", $id);
            $bulkAPIResponse = $zcrmRecordIns->getRelatedListRecords("Invoices");
            $relatedDeals = $bulkAPIResponse->getData();
            return $relatedDeals;
        } catch (ZCRMException $e) {
            print_r($e);
            return null;
        }
    }

    // @codeCoverageIgnoreEnd

    function upsertContacto($nuevoContacto) {
        $zcrmModuleIns = ZCRMModule::getInstance("Contacts");
        $response = "";
        $recordsArray = array($nuevoContacto);
        $bulkAPIResponse = $zcrmModuleIns->upsertRecords($recordsArray);
        $entityResponses = $bulkAPIResponse->getEntityResponses();
        foreach ($entityResponses as $entityResponse) {
            $response = [
                'status' => $entityResponse->getStatus(),
                'message' => $entityResponse->getMessage(),
                'code' => $entityResponse->getCode(),
                'ID' => $entityResponse->getStatus() === "success" ? $entityResponse->getData()->getEntityId() : ""
            ];
        }

        return $response;
    }

    function crearEvento($nuevoEvento) {
        $zcrmModuleIns = ZCRMModule::getInstance("Events");
        $response = "";
        $recordsArray = array($nuevoEvento);
        $bulkAPIResponse = $zcrmModuleIns->createRecords($recordsArray);
        $entityResponses = $bulkAPIResponse->getEntityResponses();
        foreach ($entityResponses as $entityResponse) {
            $response = [
                'status' => $entityResponse->getStatus(),
                'message' => $entityResponse->getMessage(),
                'code' => $entityResponse->getCode(),
                'details' => $entityResponse->getDetails(),
                'ID' => $entityResponse->getData()->getEntityId()
            ];
        }

        return $response;
    }

    function crearObjeto($modulo, $objeto) {
        $zcrmModuleIns = ZCRMModule::getInstance($modulo);
        $response = "";
        $recordsArray = array($objeto);
        $bulkAPIResponse = $zcrmModuleIns->createRecords($recordsArray);
        $entityResponses = $bulkAPIResponse->getEntityResponses();
        foreach ($entityResponses as $entityResponse) {
            $response = [
                'status' => $entityResponse->getStatus(),
                'message' => $entityResponse->getMessage(),
                'code' => $entityResponse->getCode(),
                'details' => $entityResponse->getDetails(),
                'ID' => $entityResponse->getData()->getEntityId()
            ];
        }

        return $response;
    }

    function actualizarObjeto($objeto) {
        $apiResponse = $objeto->update();
        $response = [
            'status' => $apiResponse->getStatus(),
            'message' => $apiResponse->getMessage(),
            'code' => $apiResponse->getCode(),
            'details' => $apiResponse->getDetails(),
            'ID' => $apiResponse->getData()->getEntityId()
        ];
        return $response;
    }

    function crearOportunidad($nuevaOportunidad) {
        $zcrmModuleIns = ZCRMModule::getInstance("Deals");
        $response = "";
        $recordsArray = array($nuevaOportunidad);
        $bulkAPIResponse = $zcrmModuleIns->createRecords($recordsArray);
        $entityResponses = $bulkAPIResponse->getEntityResponses();
        foreach ($entityResponses as $entityResponse) {
            $response = [
                'status' => $entityResponse->getStatus(),
                'message' => $entityResponse->getMessage(),
                'code' => $entityResponse->getCode(),
                'details' => $entityResponse->getDetails(),
                'ID' => $entityResponse->getData()->getEntityId()
            ];
        }

        return $response;
    }

    function buscarOportunidad($idContacto) {
        try {
            $zcrmRecordIns = ZCRMRecord::getInstance("Deals", $idContacto);
            $relatedDeals = $zcrmRecordIns->getData();
        } catch (ZCRMException $e) {
            return null;
        }

        $selectedDeal = null;

        foreach ($relatedDeals as $deal) {
            $currentDeal = $deal->getData();
            if ($currentDeal["Profesional"] == $profesional) {
                $fase = $currentDeal["Stage"];
                if ($fase == "Contacto Inicial" || $fase == "Atención de Consultas" || $fase == "Envío de Cotización") {

                    if ($selectedDeal === null) {
                        $selectedDeal = $deal;
                    } else {
                        $selectedDealDate = strtotime($selectedDeal->getCreatedTime());
                        $currentDealDate = strtotime($deal->getCreatedTime());
                        if ($selectedDealDate < $currentDealDate) { //Tiene más tiempo de existir
                            $selectedDeal = $deal;
                        }
                    }
                }
            }
            return $currentDeal;
        }
        return $currentDeal;
    }

    public function obtenerInformacion($id,$modle) {
        //Se debe probar cambiando modulo por books.
        $url = "https://www.zohoapis.com/crm/v2/$modle/".$id;
        $respuesta = $this->enviarRequest("GET", $url, $this->requestsHeader);
        return $respuesta;
    }
    
    private function enviarRequest($tipoSolicitud, $url, $header, $params = "") {
        //Making the options
        $tipos = array('GET', 'POST', 'PUT', 'PATCH');
        $tiposEnvío = array('POST', 'PUT', 'PATCH');

        if (!in_array($tipoSolicitud, $tipos)) {
            return array(
                "result_status" => FALSE,
                "result_data" => "El tipo de request no es válido."
            );
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $tipoSolicitud,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return array(
                "estado" => FALSE,
                "respuesta" => "CURL Error #:" . $err
            );
        } else {
            $responseT = json_decode($response);
            return array(
                "estado" => TRUE,
                "respuesta" => $responseT
            );
        }
    }

    public function setValoresCliente() {
        $this->requestsHeader = array(
            "Authorization: Zoho-oauthtoken " . $this->token,
            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
            "cache-control: no-cache"
        );
    }
    public function enviarInformacion( $modle,$data) {
        //Se debe probar cambiando modulo por books.
        $url = "https://www.zohoapis.com/crm/v2/$modle";
        $respuesta = $this->enviarRequest("POST", $url, $this->requestsHeader,$data);
        return $respuesta;
    }
/*
 * 
{
    "access_token": "1000.b79a3acf422fa48f98458d9300463417.ad30d74ed7dc5de622f4357848757b47",
    "refresh_token": "1000.328e01c2f1365041d8023fe34cd13c02.f9957ed62eee3a07e5435c3c3fbfc75d",
    "expires_in_sec": 3600,
    "api_domain": "https://www.zohoapis.com",
    "token_type": "Bearer",
    "expires_in": 3600000
}
 * 
 */
    
    public function generarAccessTokenConRefreshToken() {
        $client_id = "1000.PIJLWFPQ7X7Z4606986EZK4J7QW8EV";
        $client_secrect = "dcdc5fd834f26c8b8ae65ea363230065847aba9f1f";
        $uri = "http://localhost/UnibeSiku/api/persona/uri";
        $code = "1000.328e01c2f1365041d8023fe34cd13c02.f9957ed62eee3a07e5435c3c3fbfc75d";
        $url = "https://accounts.zoho.com/oauth/v2/token?refresh_token=".$code."&redirect_uri=".$uri."&client_id=".$client_id."&client_secret=".$client_secrect."&grant_type=refresh_token";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        return $result->access_token;
    }

}
