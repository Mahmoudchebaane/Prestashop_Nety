<?php
use GuzzleHttp\Client;
class Otp extends ObjectModel
{   
    public function __construct()
    {
        $this->bootstrap = true;
        $this->show_toolbar = false;
        $this->table = 'otp';
        $this->lang = false;
        $this->context = Context::getContext();
    }
    public function getWebserviceObjectList($sql_join, $sql_filter, $sql_sort, $sql_limit)
    {
        $tel = $_REQUEST['numtel'];
        
        if ($tel) {            
            $this->context->cookie->__set('tel', $tel);            
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = '{
            "phoneNb": "' . $tel . '",
            "otpValidity": 1500,
            "otpToken": "6271608B-9C06-4EDC-9ED9-E245928A11B1",
            "message": "Demande abonnement Nety: code de confirmation",
            "source": "Nety"
            }';
            $request = $client->createRequest('POST', 'https://smsingotp.chifco.com/api/Contact/SENDOTP', ['headers' => $headers, 'body' => $body]);
            $response = $client->send($request);
           
            if ($response->getStatusCode() == 200) {
                $successresponse = json_decode($response->getBody(), 1);                
                $check = false;
                if (!array_key_exists('error', $successresponse)) {
                    //  time();      // 1660338149  1676388556789  timestamp 
                    $this->context->cookie->__set('code', $successresponse['otpCode']);
                    $this->context->cookie->__set('expire', $successresponse['expiryDate']);
                    $this->context->cookie->write();
                    $check = true;
                }
                echo json_encode([
                    'success' => $check,
                    'data' => $response->getStatusCode(),
                ]);
            return true;
            } else {
                echo json_encode([
                    'success' => false,
                    'data' => $response->getStatusCode(),
                ]);
                return false;
            }
        }
        echo json_encode([
            'success' => false,
            'data' => "",
        ]);
    
    }
  
    // public function getCode()
    // {
       
    //     $tel = $_REQUEST['numtel'];
    //     if ($tel) {
    //         $this->context->cookie->__set('tel', $tel);
    //         $client = new Client();
    //         $headers = [
    //             'Content-Type' => 'application/json'
    //         ];
    //         $body = '{
    //         "phoneNb": "' . $tel . '",
    //         "otpValidity": 1500,
    //         "otpToken": "6271608B-9C06-4EDC-9ED9-E245928A11B1",
    //         "message": "Demande d\'abonnement Nety : code de confirmation",
    //         "source": "Nety"
    //         }';
    //         $request = $client->createRequest('POST', 'https://smsingotp.chifco.com/api/Contact/SENDOTP', ['headers' => $headers, 'body' => $body]);
    //         $response = $client->send($request);
    //         if ($response->getStatusCode() == 200) {
    //             $successresponse = json_decode($response->getBody(), 1);
    //             $check = false;
    //             if (!array_key_exists('error', $successresponse)) {
    //                 //  time();      // 1660338149  1676388556789  timestamp 
    //                 $this->context->cookie->__set('code', $successresponse['otpCode']);
    //                 $this->context->cookie->__set('expire', $successresponse['expiryDate']);
    //                 $this->context->cookie->write();
    //                 $check = true;
    //             }
    //             echo json_encode([
    //                 'success' => $check,
    //                 'data' => $response->getStatusCode(),
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'success' => false,
    //                 'data' => $response->getStatusCode(),
    //             ]);
    //         }
    //     }
    //     echo json_encode([
    //         'success' => false,
    //         'data' => "",
    //     ]);
    // }

}