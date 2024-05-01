<?php
$API_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiYTBlOGNkZGQtNGMyOC00NTY2LWJhYzEtOGE4Zjg0NGY2ZWVkIiwidHlwZSI6ImFwaV90b2tlbiJ9.KHNjz9jX-GO7TIWIbcYMBVbpni7EvGezjo07G0kDwX8";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['textInput'])) {
            // If text input is provided
            $text = $_POST['textInput'];
        } elseif (isset($_FILES['fileInput']['tmp_name']) && $_FILES['fileInput']['tmp_name'] != '') {
            // If a file is uploaded
            $text = file_get_contents($_FILES['fileInput']['tmp_name']);
        } else {
            // If neither text input nor file is provided
            echo json_encode(array('error' => 'No input provided.'));
            exit();
        }

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $API_KEY
        );
        $url = 'https://api.edenai.run/v2/text/ai_detection';
        $payload = array(
            'providers' => 'originalityai',
            'text' => $text,
            'fallback_providers' => ''
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);
        
        // Set content type to JSON
        header('Content-Type: application/json');

        if ($http_status == 200) {
            echo $response;
        } else {
            echo json_encode(array('error' => 'Error: Failed to get response from the API.'));
        }
    } catch (Exception $e) {
        echo json_encode(array('error' => 'An unexpected error occurred: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>