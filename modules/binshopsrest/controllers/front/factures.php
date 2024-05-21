<?php
use GuzzleHttp\Client;
use PrestaShop\CircuitBreaker\Client\GuzzleClient;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestfacturesModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $emplacement = Tools::getValue('emplacement');

        if ($emplacement == 1) {
            $identifiant = Tools::getValue('identifiant');
            $type_identif = Tools::getValue('type_identif');
            $client = new GuzzleClient();
            try {
                $response = $client->request(LINK_CRM . '/api/listeFactureNonPayee?identifiant=' . $identifiant . '&type_identif=' . $type_identif, []);
                $psdata = $response;
            } catch (Exception $e) {
                $psdata = [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => null
                ];
            }
        } else {
            $client = new Client();
            $ref_abonnement = Tools::getValue('ref_abonnement');

            $page = Tools::getValue("page"); //Tools::getValue('from');
            $size = Tools::getValue("length"); //  Tools::getValue('take');
            $order = Tools::getValue("column");
            $dir = Tools::getValue('dir');
            $search = Tools::getValue('search');
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
                    $psdata = $output;
                } else {
                    $psdata = [
                        'success' => false,
                        'message' => 'une erreur se produite',
                        'data' => null
                    ];
                }
            } catch (Exception $e) {
                $psdata = [
                    'success' => false,
                    'message' => 'error: ' . $e->getMessage(),
                    'data' => null
                ];
            }
        }
        $this->ajaxRender(json_encode(
            $psdata
        ));
        die;

    }
}