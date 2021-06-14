<?php
namespace App\Service\API\Common;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class CurlMode
{
    const POST_JSON = 0;
    const POST_FORM_URLENCODED = 10;
    const POST_FORM_DATA = 20;
}

class GenericApi {
    private $em;
    private $logger;

    var $userId = '';
    var $token = '';

    public function __construct(EntityManagerInterface $em, LoggerInterface $apiLogger) {
        $this->em = $em;
        $this->logger = $apiLogger;

        $apiLogger->info("Apilogger");
    }

    private function curl_send($ch, $data, $token = false, $mode = CurlMode::POST_JSON) {
        $headers = array();
        if ($token) array_push($headers, 'Authorization: Token ' . $token);
        if ($mode == CurlMode::POST_JSON) {
            array_push($headers, 'Content-Type: application/json');
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
            ));
        } elseif ($mode == CurlMode::POST_FORM_URLENCODED) {
            array_push($headers, 'Content-Type: application/x-www-form-urlencoded');
            $postData = http_build_query($data);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postData,
                CURLOPT_HTTPHEADER => $headers,
            ));
        } elseif ($mode == CurlMode::POST_FORM_DATA) {
            array_push($headers, 'Content-Type: application/json');
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $headers,
            ));
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die(curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }

    function getToken($username, $password) {
        // The data to send to the API
        $postData = array(
            'username' => $username,
            'password' => $password
        );

        // Setup cURL
        $ch = curl_init($_ENV['API_LOGIN']);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));

        // Send the request
        $response = curl_exec($ch);

        // Check for errors
        if($response === FALSE){
            die(curl_error($ch));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);

        $this->userId = $responseData['user'];
        $this->token = $responseData['token'];
    }



    function curl_read($ch,$postData) {

        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postData)
        ));

        $response = curl_exec($ch);

        if ($response === FALSE) {
            die(curl_error($ch));
        }

        return json_decode($response, TRUE);
    }


}
