<?php

print_r($_GET);

$clientId = "AXlAuQZdeYFxfSn4n5bDvvu6EGbeYAMQnT6XSd7v4C8CNzDa6PWIJOx56MiwatzyBjK5RVHekA-2WfaF";
$secret = "EBJyjKAO3VUKUo1zVZ23d-iATTOErOUA2XLjtEf0dIKKFa0iLiPHPAafUasJBnBexCvwM4r65Yh6gQet";

$login = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login, CURLOPT_RETURNTRANSFER, true);

curl_setopt($login, CURLOPT_USERPWD, $clientId . ":". $secret);

curl_setopt($login, CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$reply = curl_exec($login);

$responseObject = json_decode($reply);

$accessToken = $responseObject->access_token;

print_r($accessToken);

