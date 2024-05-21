<?php
use GuzzleHttp\Client;

require_once _PS_ROOT_DIR_ . '\modules\binshopsrest\controllers\AbstractRESTController.php';
class binshopsrestotpModuleFrontController extends AbstractRESTController
{
    public $ssl = true;

    protected function processGetRequest()
    {
        $tel  = Tools::getValue('phone');
        if (!empty($tel)) {
            $this->context->cookie->__set('tel', $tel);
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = '{
            "phoneNb": "' . $tel . '",
            "otpValidity": 1500,
            "otpToken": "6271608B-9C06-4EDC-9ED9-E245928A11B1",
            "message": "Code de confirmation Nety",
            "source": "Nety"
            }';
            $request = $client->createRequest('POST', 'https://smsingotp.chifco.com/api/Contact/SENDOTP', ['headers' => $headers, 'body' => $body]);
            $response = $client->send($request);

            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);
                $check = false;
                if (!array_key_exists('error', $successresponse)) { 
                    $this->context->cookie->__set('code', $successresponse['otpCode']);
                    $this->context->cookie->__set('expire', $successresponse['expiryDate']);
                    $this->context->cookie->write();
                    $check = true;
                }
                $psdata =[$successresponse['otpCode'], $successresponse['expiryDate']];
                $messageCode = 200;
                $success = true;
                
            } else {
                $psdata = $this->trans("An error occured", [], 'Modules.Binshopsrest.Auth');
                $messageCode = 308;
                $success = false;
            }
        } elseif (empty($phone)) {
            $psdata = $this->trans("Phone number should not be empty", [], 'Modules.Binshopsrest.Auth');
            $messageCode = 308;
            $success = false;
        } elseif (!preg_match('/^[0-9]{8}+$/', $phone)) {
            $psdata = $this->trans("Invalid phone number", [], 'Modules.Binshopsrest.Auth');
            $messageCode = 308;
            $success = false;
        }
        $this->ajaxRender(json_encode([
            'success' => $success,
            'code' => $messageCode,
            'psdata' => $psdata
        ]));
        die;
    }
}