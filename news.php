<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="font-size: 0.9em; font-weight: 300;">


    <?php

    $fields = array(
        'owner' => 'ARCH',
        'category' => '',
        'tag' => '',
        'ordering' => 'act_date DESC',
        'limit' => '3',
    );
    $resp = GetAPI_Curl($fields, 'https://faed.mju.ac.th/dev/ActivityDBMS/_admin/api.php');

    // show json
    var_dump($resp);
    echo "<hr>";

    $data = json_decode($resp, true);
    // show array
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    echo "<hr>";

    // foreach ($data as $row) {
    //     echo $row["act_title"] . "<br>";
    // }



    function GetAPI_Curl($data_array, $url = '')
    {
        // Initialize a CURL session.
        $ch = curl_init($url);
        // verify SSL only
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        // * send POST JSON is no working
        // curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $result = curl_exec($ch);
        curl_close($ch);

        return ($result);
    }

    ?>


</body>

</html>