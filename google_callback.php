<?php
// Configuración de Google OAuth
$client_id = "20144009687-c0seotmt6dbtb3sjn0au9rulgh368avj.apps.googleusercontent.com";
$client_secret = "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";
$redirect_uri = "http://localhost/chat-bot/google_callback.php";

// Verificar si Google devolvió un código
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Intercambiar el código por un token de acceso
    $token_url = "https://oauth2.googleapis.com/token";
    $post_fields = [
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => $redirect_uri,
        "grant_type" => "authorization_code"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if (isset($response_data['access_token'])) {
        $access_token = $response_data['access_token'];

        // Obtener información del usuario
        $user_info_url = "https://www.googleapis.com/oauth2/v3/userinfo";
        $headers = [
            "Authorization: Bearer " . $access_token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $user_info_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $user_info_response = curl_exec($ch);
        curl_close($ch);

        $user_info = json_decode($user_info_response, true);

        // Aquí puedes guardar los datos del usuario en la base de datos si es necesario
        // ...

        // Redirigir al usuario a la página deseada
        header("Location: http://localhost/chat-bot/pagina2.html");
        exit();
    } else {
        echo "Error al obtener el token de acceso.";
    }
} else {
    echo "Error: Código de autorización no proporcionado.";
}
?>
