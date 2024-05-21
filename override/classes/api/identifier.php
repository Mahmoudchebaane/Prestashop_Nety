<?php

use GuzzleHttp\Client;

class demandeIdentifier extends ObjectModel
{
    public function __construct()
    {
        $this->table = 'identifier';
        $this->identifier = 'identifiant';
    }
    protected $webserviceParameters = array(
        'objectNodeName' => 'identifier',
    );
 

    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $identifiant = $_REQUEST['identifiant'];
        if (!$identifiant) {
            WebserviceRequest::getInstance()->setError(
                500,
                $this->trans(
                    'Identifier is missing',
                    [],
                    'Admin.Notifications.Error'
                ),
                140
            );
            return false;
        }
        $client = new Client();
        $optionsexist = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'cin' => $identifiant,
            ]
        ];

        try {
            $request = $client->createRequest('POST', LINK_CRM . '/api/verificationexistancecin', $optionsexist);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);              
                if( $successresponse['verif']== "true") {                                      
                    echo json_encode([
                        'success' => true,
                        'data' => $successresponse['msg'],
                    ]);
                    return true;
                } else {                   
                    echo json_encode([
                        'success' => false,
                        'data' => $this->trans(
                                    'Identifier is already used, please choose another one',
                                    [],
                                    'Admin.Notifications.Error'
                                ),
                    ]);
                   
                    return false;
                }
            } else {
                WebserviceRequest::getInstance()->setError(
                    500,
                    $this->trans(
                        'Error verifying code',
                        [],
                        'Admin.Notifications.Error'
                    ),
                    140
                );
                return false;
            }
        } catch (Exception $e) {
            WebserviceRequest::getInstance()->setError(
                500,
                $this->trans(
                    'Error verifying code',
                    [],
                    'Admin.Notifications.Error'
                ),
                140
            );
            return false;
        }
    }
}