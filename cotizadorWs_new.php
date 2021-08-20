<?php



// 2015-05-19 | Javier Puentes



$doAction = (isset($_REQUEST['doAction'])) ? $_REQUEST['doAction'] : '';

$idMarca = (isset($_REQUEST['idMarca'])) ? $_REQUEST['idMarca'] : '';

$anio = (isset($_REQUEST['anio'])) ? $_REQUEST['anio'] : '';

$idGrupoModelo = (isset($_REQUEST['idGrupoModelo'])) ? $_REQUEST['idGrupoModelo'] : '';

$idModeloVehiculo = (isset($_REQUEST['idModeloVehiculo'])) ? $_REQUEST['idModeloVehiculo'] : '';

$idGuarda = (isset($_REQUEST['idGuarda'])) ? $_REQUEST['idGuarda'] : '';

$LocalidadGuarda = (isset($_REQUEST['LocalidadGuarda'])) ? $_REQUEST['LocalidadGuarda'] : '';

$antiguedad = (isset($_REQUEST['antiguedad'])) ? $_REQUEST['antiguedad'] : '';

$Gnc = (isset($_REQUEST['Gnc'])) ? $_REQUEST['Gnc'] : '';

$ValorGnc = (isset($_REQUEST['ValorGnc'])) ? $_REQUEST['ValorGnc'] : '';

$ValorAccesorios = (isset($_REQUEST['ValorAccesorios'])) ? $_REQUEST['ValorAccesorios'] : '';

$CoberturaRC = (isset($_REQUEST['CoberturaRC'])) ? $_REQUEST['CoberturaRC'] : '';

$CoberturaCasco = (isset($_REQUEST['CoberturaCasco'])) ? $_REQUEST['CoberturaCasco'] : '';

$ValorVehiculo = (isset($_REQUEST['ValorVehiculo'])) ? $_REQUEST['ValorVehiculo'] : '';


$q = (isset($_REQUEST['query'])) ? $_REQUEST['query'] : '';



$cotID = (!empty($_REQUEST['cotID'])) ? $_REQUEST['cotID'] : "0";



$cliNombre = (!empty($_POST['cliNombre'])) ? $_POST['cliNombre'] : "";

$cliApellido = (!empty($_POST['cliApellido'])) ? $_POST['cliApellido'] : "";

$cliEmail = (!empty($_POST['cliEmail'])) ? $_POST['cliEmail'] : "";

$cliTel = (!empty($_POST['cliTel'])) ? $_POST['cliTel'] : "";

$cliDominio = (!empty($_POST['cliDominio'])) ? $_POST['cliDominio'] : "";

$cotAnio = (!empty($_POST['cotAnio'])) ? $_POST['cotAnio'] : 0;

$cotMarca = (!empty($_POST['cotMarca'])) ? $_POST['cotMarca'] : 0;

$cotModelo = (!empty($_POST['cotModelo'])) ? $_POST['cotModelo'] : 0;

$cotVersion = (!empty($_POST['cotVersion'])) ? $_POST['cotVersion'] : 0;

$cotGnc = (!empty($_POST['cotGnc'])) ? $_POST['cotGnc'] : "";

$cotGncCost = (!empty($_POST['cotGncCost'])) ? $_POST['cotGncCost'] : "0";

$cotAcc = (!empty($_POST['cotAcc'])) ? $_POST['cotAcc'] : "";

$cotAccCost = (!empty($_POST['cotAccCost'])) ? $_POST['cotAccCost'] : "0";

$cotAccDesc = (!empty($_POST['cotAccDesc'])) ? $_POST['cotAccDesc'] : "";

$cotRC = (!empty($_POST['cotRC'])) ? $_POST['cotRC'] : "";

$cotCasco = (!empty($_POST['cotCasco'])) ? $_POST['cotCasco'] : "";

$cotPrima = (!empty($_POST['cotPrima'])) ? $_POST['cotPrima'] : "0";

$cotPremio = (!empty($_POST['cotPremio'])) ? $_POST['cotPremio'] : "0";

$cotIva = (!empty($_POST['cotIva'])) ? $_POST['cotIva'] : "0";

$cotSuma = (!empty($_POST['cotSuma'])) ? $_POST['cotSuma'] : "0";

$cotCuota = (!empty($_POST['cotCuota'])) ? $_POST['cotCuota'] : "0";



$alianza = (!empty($_POST['alianza'])) ? $_POST['alianza'] : "";



if ($doAction == 98) {



    

    function trace_lead($clientCode, $name, $email, $phone, $origen, $alianza) {



        $hash_input = "";

        $fields = '';



        if ($clientCode != '') {$fieldName = $fields != '' ? "&CLIENT_CODE=" : "CLIENT_CODE=";$fields .= $fieldName . rawurlencode($clientCode);$hash_input .= $clientCode;}

        if ($name != '') {$fieldName = $fields != '' ? "&NAME=" : "NAME=";$fields .= $fieldName . rawurlencode($name);$hash_input .= $name;}

        if ($email != '') {$fieldName = $fields != '' ? "&EMAIL=" : "EMAIL=";$fields .= $fieldName . rawurlencode($email);$hash_input .= $email;}

        if ($phone != '') {$fieldName = $fields != '' ? "&PHONE=" : "PHONE=";$fields .= $fieldName . rawurlencode($phone);$hash_input .= $phone;}

        if($origen != '') {$fieldName = $fields != '' ? "&COMMENTS=" : "COMMENTS=";$fields .= $fieldName.rawurlencode($origen);$hash_input .= $origen;}

        if ($origen != '') {$fieldName = $fields != '' ? "&ORIGEN=" : "ORIGEN=";$fields .= $fieldName . rawurlencode($alianza);$hash_input .= $alianza;}

        if ($alianza != '') {$fieldName = $fields != '' ? "&ALLIANCE=" : "ALLIANCE=";$fields .= $fieldName . rawurlencode($alianza);$hash_input .= $alianza;}

        

        $key = md5($hash_input);

        $fields .= ($fields != '' ? "&" : "") . "Key=" . $key;



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://leadmanager.itechla.com/Leadservices.asp");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        $leadCodeReturn = "0";

        try {$doc = new DOMDocument;$doc->LoadXml($result);$leadCodeReturn = $doc->getElementsByTagName('LeadCode')->item(0)->nodeValue;

        } catch (Exception $e) {$xml = simplexml_load_string($result);$leadCodeReturn = $xml->LeadCode[0];}



        echo $leadCodeReturn;

    }

    

    

    

    $_SESSION['leadmanager_id'] = trace_lead('43', $cliNombre ." ". $cliApellido, $cliEmail, $cliTel, 'Cotizaciones Online', $alianza);



    die();

}





if ($doAction == 99) {



    $url = 'https://api.icommarketing.com/Contacts/SaveContact.Json/';



    $data = array(

        'ProfileKey' => 'NzQ0MTI1',

        'Contact' => array(

            'Email' => $cliEmail,

            'CustomFields' => array(

                array('Key' => 'nombre', 'Value' => $cliNombre),

                array('Key' => 'apellido', 'Value' => $cliApellido)

            )

        )

    );



    $dataToSend = json_encode($data);



    $headers = array(

        'POST /Contacts/List.Json/ HTTP/1.1',

        'User-Agent: curl/7.27.0',

        'Host: api.icommarketing.com',

        'Accept: */*',

        'Content-Type: application/json',

        'Content-Length: ' . strlen($dataToSend),

        'Authorization: MzUxLTUxNi1zdG9wY2Fy0:0',

    );

//echo json_encode($data);

//die();

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_HEADER, false);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curl, CURLOPT_POST, true);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $dataToSend);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);



    $json_response = curl_exec($curl);



    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);





    curl_close($curl);



    $response = json_decode($json_response, true);



    echo $json_response;



    die();

}



$url = 'http://intranet.stopcar.com.ar/Alaweb3/WebServiceRus/cotizacionWs.php?doAction=' . $doAction;

$url.= '&idMarca=' . $idMarca;

$url.= '&anio=' . $anio;

$url.= '&Ramo=4';

$url.= '&idGrupoModelo=' . $idGrupoModelo;

$url.= '&idModeloVehiculo=' . $idModeloVehiculo;

$url.= '&uso=PARTICULAR';

$url.= '&idGuarda=' . $idGuarda;

$url.= '&LocalidadGuarda=' . $LocalidadGuarda;

$url.= '&antiguedad=' . $antiguedad;

$url.= '&Gnc=' . $Gnc;

$url.= '&ValorGnc=' . $ValorGnc;

$url.= '&ValorAccesorios=' . $ValorAccesorios;

$url.= '&CoberturaRC=' . $CoberturaRC;

$url.= '&CoberturaCasco=' . $CoberturaCasco;

$url.= '&query=' . urlencode($q);

$url.= '&cotID=' . urlencode($cotID);

$url.= '&cliNombre=' . urlencode($cliNombre);

$url.= '&cliApellido=' . urlencode($cliApellido);

$url.= '&cliEmail=' . urlencode($cliEmail);

$url.= '&cliTel=' . urlencode($cliTel);

$url.= '&cliDominio=' . urlencode($cliDominio);

$url.= '&cotAnio=' . urlencode($cotAnio);

$url.= '&cotMarca=' . urlencode($cotMarca);

$url.= '&cotModelo=' . urlencode($cotModelo);

$url.= '&cotVersion=' . urlencode($cotVersion);

$url.= '&cotGnc=' . urlencode($cotGnc);

$url.= '&cotGncCost=' . urlencode($cotGncCost);

$url.= '&cotAcc=' . urlencode($cotAcc);

$url.= '&cotAccCost=' . urlencode($cotAccCost);

$url.= '&cotAccDesc=' . urlencode($cotAccDesc);

$url.= '&cotRC=' . urlencode($cotRC);

$url.= '&cotCasco=' . urlencode($cotCasco);

$url.= '&cotPrima=' . urlencode($cotPrima);

$url.= '&cotPremio=' . urlencode($cotPremio);

$url.= '&cotIva=' . urlencode($cotIva);

$url.= '&cotSuma=' . urlencode($cotSuma);

$url.= '&cotCuota=' . urlencode($cotCuota);

//echo "valor vehic ". (int)$ValorVehiculo;


if((int)$ValorVehiculo < 575001){
$url.= '&idProductor=' . urlencode(3098);
} else {
$url.= '&idProductor=' . urlencode(3035);

}


//die;
//echo $url;
//die;
$htm = file_get_contents($url);

echo $htm;
?>