<?php
    $tokencartao = $_POST['tokencartao'];
    $hashuser = $_POST['hashuser'];
    $brand = $_POST['brand'];
    $cpf = $_POST['cpf'];
    $nomecartao = $_POST['nomecartao'];
    $datanascimento = $_POST['datanascimento'];
    $emailcliente = $_POST['email'];
    $ruacliente = $_POST['rua'];
    $cidadecliente = $_POST['cidade'];
    $bairrocliente = $_POST['bairro'];
    $estadocliente = $_POST['estado'];
    $dddcliente = $_POST['ddd'];
    $telefonecliente = $_POST['telefone'];
    $numcliente = $_POST['numero'];
    $cepcliente = $_POST['cep'];
    $idsessao = $_POST['idsessao'];

    $url = "https://ws.pagseguro.uol.com.br/pre-approvals?email=email%40hotmail.com&token=CE77E947F35D454354354396A1AB704602";  //PRODUCAO

    $json = "{";
    $json = $json.'"plan":'.'"710FF1953F3F00D99497EFADD5BB8099",';
    $json = $json.'"reference":"'.$idsessao.'",';
    $json = $json.'"sender":{';
        $json = $json.'"name":"'.$nomecartao.'",';
        $json = $json.'"email":"'.$emailcliente.'",';
        $json = $json.'"ip":"'.'189.19.10.203'.'",';
        $json = $json.'"hash":"'.$hashuser.'",';
        $json = $json.'"phone":{';
            $json = $json.'"areaCode":"'.$dddcliente.'",';
            $json = $json.'"number":"'.$telefonecliente.'"';
            $json = $json."},";
        $json = $json.'"address":{';
            $json = $json.'"street":"'.$ruacliente.'",';
            $json = $json.'"number":"'.$numcliente.'",';
            $json = $json.'"complement":"'."centro".'",';
            $json = $json.'"district":"'.$bairrocliente.'",';
            $json = $json.'"city":"'.$cidadecliente.'",';
            $json = $json.'"state":"'.$estadocliente.'",';
            $json = $json.'"country":"'.'BRA'.'",';
            $json = $json.'"postalCode":"'.$cepcliente.'"';
            $json = $json."},";
            $json = $json.'"documents":[{';
                $json = $json.'"type":'.'"CPF"'.',';
                $json = $json.'"value":"'.$cpf.'"';
            $json = $json."}]";
        $json = $json."},";
    $json = $json.'"paymentMethod":{';
        $json = $json.'"type":'.'"CREDITCARD"'.",";
        $json = $json.'"creditCard":{';
            $json = $json.'"token":"'.$tokencartao.'",';
            $json = $json.'"holder":{';
                $json = $json.'"name":"'.$nomecartao.'",';
                $json = $json.'"birthDate":"'.$datanascimento.'",';
                $json = $json.'"documents":[{';
                    $json = $json.'"type":"'.'CPF'.'",';
                    $json = $json.'"value":"'.$cpf.'"';
                    $json = $json."}],";
                $json = $json.'"phone":{';
                    $json = $json.'"areaCode":"'.$dddcliente.'",';
                    $json = $json.'"number":"'.$telefonecliente.'"';
                    $json = $json."},";
                $json = $json.'"billingAddress":{';
                    $json = $json.'"street":"'.$ruacliente.'",';
                    $json = $json.'"number":"'.$numcliente.'",';
                    $json = $json.'"complement":"'."centro".'",';
                    $json = $json.'"district":"'.$bairrocliente.'",';
                    $json = $json.'"city":"'.$cidadecliente.'",';
                    $json = $json.'"state":"'.$estadocliente.'",';
                    $json = $json.'"country":"'.'BRA'.'",';
                    $json = $json.'"postalCode":"'.$cepcliente.'"}}}}}';


    $curl = curl_init();

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Accept:application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
        'Content-Type:application/json;charset=ISO-8859-1'));
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json );

    $res= curl_exec($curl);

    curl_close($curl);

    echo json_encode($res);
