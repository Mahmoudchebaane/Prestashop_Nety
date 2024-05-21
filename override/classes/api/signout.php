<?php

class Signout extends Customer {
    protected $webserviceParameters = [
        'objectMethods' => [
            'add' => 'signout',
        ]
    ];

    // Your custom customer login function
    public function signout($autodate = true, $null_values = false)
    {
        $id = $_REQUEST['id'];      
        $customer = Customer::getCustomerById($id); dump($customer);die;      
        Hook::exec('actionCustomerLogoutBefore', ['customer' => $customer]);

        if (isset(Context::getContext()->cookie)) {
            Context::getContext()->cookie->mylogout();
        }

        $customer->logged = 0;

        Hook::exec('actionCustomerLogoutAfter', ['customer' => $customer]);
        // if (!$customer->logged) {

        //     // Logout successful
          
        //     $customer->id_access = 0; // Set the customer group ID as needed
        //     $customer->update();
          
        //     $result = ['success' => true, 'message' =>'Successfully logged out'];

        //     // Return customer information or token as needed
        // } else {
        //     // Login failed
        //     $result = ['success' => false, 'error' => 'Invalid credentials'];
        //     //return $result;
        // }
        // echo json_encode($result);
    }
}