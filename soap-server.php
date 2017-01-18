<?


include "funcoes.php";


 teste   dsfs sfs
require_once("nusoap.php");

$ns="http://www.maniezo.com.br/";
teste
$server = new soap_server();

$server->configureWSDL('traz_cep',$ns);
$server->configureWSDL('traz_cep_partes',$ns);
$server->configureWSDL('calcula_frete',$ns);

$server->register('traz_cep',array('cep' => 'xsd:string'),array('return'=>'xsd:string'),$ns);
$server->register('traz_cep_partes',array('cep' => 'xsd:string'),array('return'=>'xsd:string'),$ns);
$server->register('calcula_frete',array('frete' => 'xsd:string'),array('return'=>'xsd:string'),$ns);

function traz_cep($cep){
  
  $var = traz_cepserver($cep);
  
  return new soapval('return','string',$var);
}

function traz_cep_partes($cep){
  
  $var = traz_cepserver_partes($cep);
  
  return new soapval('return','string',$var);
}

function calcula_frete($frete){
  
  $frete_str  = explode("#",$frete);
  $login      = $frete_str[0];
  $senha      = $frete_str[1];
  $cepOrigem  = $frete_str[2];
  $cepDestino = $frete_str[3];
  $peso       = $frete_str[4];
  
  $cepOrigem = str_replace("-","", $cepOrigem);
  $cepDestino = str_replace("-","", $cepDestino);
  
  $var = calculaFreteServer($cepOrigem, $cepDestino, $peso, $login, $senha);

  return new soapval('return','string',$var);

}

$server->service($HTTP_RAW_POST_DATA);
?>
