<?php

class Login extends Customer {
    protected $webserviceParameters = [
        'objectMethods' => [
            'add' => 'login',
        ]
    ];
     function checkPassword1($idCustomer, $passwordHash) {
        if (!Validate::isUnsignedId($idCustomer)) {
            die(Tools::displayError());
        }

        // Check that customers password hasn't changed since last login
        $context = Context::getContext();
        if ($passwordHash != $context->customer->passwd) {
            return false;
        }

        $cacheId = 'Customer::checkPassword' . (int) $idCustomer . '-' . $passwordHash;
        if (!Cache::isStored($cacheId)) {
            $sql = new DbQuery();
            $sql->select('c.`id_customer`');
            $sql->from('customer', 'c');
            $sql->where('c.`id_customer` = ' . (int) $idCustomer);
            $sql->where('c.`passwd` = \'' . pSQL($passwordHash) . '\'');

            $result = (bool) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

            Cache::store($cacheId, $result);

            return $result;
        }

        return Cache::retrieve($cacheId);
    }
    // Your custom customer login function


    public function login($autodate = true, $null_values = false)
    {
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $customer = new Customer();
        // Check customer credentials

        if ($customer->getByEmail($email, $password)) {

            // Login successful
            $customer->logged = 1;
            $customer->id_access = 1; // Set the customer group ID as needed
            $customer->update();
            $user = [
                "id" => $customer->id,
                "lastname" => $customer->lastname,
                "firstname" => $customer->firstname,
                "birthday" => $customer->birthday,
                "email" => $customer->email,
                "ref_abonnement" => $customer->ref_abonnement == null ? '' : $customer->ref_abonnement,
                "ref_client" => $customer->ref_client == null ? '' : $customer->ref_client,
                "num_fixe" => $customer->num_fixe == null ? '' : $customer->num_fixe,
                "phone" => $customer->phone,
                // "passwd" => $customer->passwd

            ];
            $result = ['success' => true, 'customer' => $user];

            // Return customer information or token as needed
        } else {
            // Login failed
            $result = ['success' => false, 'error' => 'Invalid credentials'];
            //return $result;
        }
        echo json_encode($result);
    }
}