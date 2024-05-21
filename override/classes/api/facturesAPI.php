<?php
use PrestaShop\CircuitBreaker\Client\GuzzleClient;
use GuzzleHttp\Client;
class facturesAPI extends PaiementFactureClass
{
    protected $webserviceParameters = [
        
        'objectMethods' => [
            'get' => 'getWebserviceObjectList',
            'add' => 'addWsPaiement'
        ]

    ];

    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $emplacement = $_REQUEST['emplacement'];
       
        if ($emplacement == 1) {
            $client = new GuzzleClient();
            try {
                $response = $client->request(LINK_CRM . '/api/listeFactureNonPayee?identifiant=' . $_REQUEST['identifiant'] . '&type_identif=' . $_REQUEST['type_identif'], []);
                echo $response;
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => null
                ]);
            }
        } else {
            $client = new Client();
            $ref_abonnement = $_REQUEST['ref_abonnement'];
            
            $page = $_REQUEST['start']; //Tools::getValue('from');
            $size = $_REQUEST['length']; //  Tools::getValue('take');
            $order = $_REQUEST["column"];
            $dir = $_REQUEST['dir'];
            $search = $_REQUEST['search'];
            try {
                $request = $client->createRequest('POST', LINK_CRM . '/api/getAllFacture', [
                    'body' => [
                        'ref_abonnement' => $ref_abonnement,
                        'page' => $page,
                        'size' => $size,
                        'sortBy' => $order,
                        'sortOrder' => $dir,
                        'search' => $search
                    ]
                ]);

                $response = $client->send($request);
                if ($response->getStatusCode() == 200) {
                    $res = json_decode($response->getBody())->data;
                    //dump(json_decode($response->getBody()));die;
                    $show = json_decode($response->getBody())->showFacture;
                    $output = array(
                        'showFacture' => $show,
                        'draw' => intval($_POST['draw']),
                        'recordsTotal' => $res->totalElements,
                        'recordsFiltered' => $res->totalElements,
                        'data' => $res->content,
                    );
                    echo json_encode($output);
                } else {
                    echo json_encode([
                            'success' => false,
                            'message' => 'une erreur se produite',
                            'data' => null
                        ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                        'success' => false,
                        'message' => 'error: ' . $e->getMessage(),
                        'data' => null
                    ]) ;
            }
        }
    }

    public function addWsPaiement()
    {
        dump('ttttt');
        die;
    }
}