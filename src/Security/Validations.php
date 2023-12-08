<?php

namespace App\Security;

use Exception;

class Validations
{

    public static function checkToken():? bool
    {
        try {
            $bearearToken = apache_request_headers();
            if(!isset($bearearToken['Authorization'])) throw new Exception("Do not provide a token");
            
            $TokenArray = explode(" ", $bearearToken['Authorization']);

            if (!isset($TokenArray[1]) || count($TokenArray) < 2) throw new Exception("There are inconsistencies in the token provided");

            $authToken = $TokenArray[1];
            /**
             * Here should go the necessary logic to validate Token based on users in the database.
             * I will provide an example token for practical purposes.
             * Example:
             *
             *$user = $entityManager
             *    ->getRepository(Users::class)
             *    ->findOneBy(['email' => $userEmail_WithJWT, 'JWT_Token' => $authToken]);
             *return [
             *    'status' => $user == null ? false : true, 
             *    'user' => $user
             *];
             */
            $tokenExample = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
            
            if($authToken == $tokenExample) return false;

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1, $e);
        }
    }
}
