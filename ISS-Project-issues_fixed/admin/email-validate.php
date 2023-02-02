<?php

function validateEmail($email)
{
     $api_key = API_KEY;

     // initialize cURL
     $curl = curl_init();

     $params = http_build_query([
          'api_key' => $api_key,
          'email' => $email
     ]);

     curl_setopt_array($curl, [
          CURLOPT_URL => 'https://emailvalidation.abstractapi.com/v1/?' . $params,
          // return contents as variables
          CURLOPT_RETURNTRANSFER => true,
          // set follow redirects to true
          CURLOPT_FOLLOWLOCATION => true
     ]);

     // execute request and get response
     $res = curl_exec($curl);

     // close cURL handle
     curl_close($curl);

     // return response data as associative array
     $data = json_decode($res, true);

     $status = $data["deliverability"];

     if ($status == "UNDELIVERABLE") {
          return [
               'status' => false,
               'error' => "email doesn't exist"
          ];
     } else if ($status == "DELIVERABLE") {
          return [
               'status' => true,
               'error' => ""
          ];
     }
}
