<?php
use GuzzleHttp\Client;
class contratCRM extends ObjectModel
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = false;
        $this->table = 'contratCRM';
        $this->lang = false;
        $this->context = Context::getContext();
    }

    protected $webserviceParameters = [
        
        'objectMethods' => [
            'get' => 'getWebserviceObjectList',
        ]
    ];
    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $ref_abonnement = $_REQUEST['ref_abonnement'];
        
         $ref_contrat = $_REQUEST['ref_contrat'];
        if ($ref_abonnement) {
            $client = new Client();
            $list = array();
            try {    
                $request = $client->createRequest('POST', LINK_CRM . '/api/getInfoContratAbonnee', [
                    'body' => [
                        'ref_abonnement' => $ref_abonnement
                    ]
                ]);
    
                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $res = json_decode($response->getBody())->data;
                    foreach ($res as $value) {
                        if ($value->haveContrat) {
                            array_push($list, $value);
                        }
                    }
                    $result = ["code" => "SUCCESS", "data" => $list, "success" => true, "message" => null];
                    echo(json_encode($result));
                } else {
                    echo json_encode([
                            'success' => false,
                            'message' => 'une erreur se produite',
                            'data' => null
                        ]) ;
                }
            } catch (Exception $e) {
                echo json_encode([
                        'success' => false,
                        'message' => 'error: ' . $e->getMessage(),
                        'data' => null
                    ]);
            }
        }
        elseif($ref_contrat){
            $this->PdfContrat($ref_contrat);
        }
        else{
            WebserviceRequest::getInstance()->setError(
                500,
                $this->trans(
                    'Reference is missing',
                    [],
                    'Admin.Notifications.Error'
                ),
                140
            );
        }
    }

    public function PdfContrat($reference)
    {
        $client = new Client();
        try {
            $request = $client->createRequest('POST', LINK_CRM . '/api/getContratFile', [
                'body' => [
                    'reference' => $reference
                ]
            ]);
            $response = $client->send($request);
            if ($response->getStatusCode() == 200) {     
                echo $response->getBody();
            } else {
                echo json_encode([
                        'success' => false,
                        'message' => 'une erreur se produite',
                        'data' => null
                    ]) ;
            }
        } catch (Exception $e) {
           echo  json_encode([
                    'success' => false,
                    'message' => 'error: ' . $e->getMessage(),
                    'data' => null
                ]) ;
        }
    }
}