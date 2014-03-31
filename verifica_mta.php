<?php
  defined( '_JEXEC' ) or die( 'Acesso restrito' );  

require_once('getW12Cli.php');


function check_mta($evoid) {
    
//Recupera a Carreira do Cliente
                $client = new 
                SoapClient( 
                    "http://177.154.134.90:8084/WCF/_BS/wcfBS.svc?wsdl" 
                ); 
            
                $params = array('IdClienteW12'=>229, 'IdCliente'=>$evoid); 
                $webService = $client->RetornarCertificacoesProfessor($params); 
                $wsResult = $webService->RetornarCertificacoesProfessorResult; 
                
                /*
                echo "<pre>" ;
                print_r($wsResult) ;
                echo "</pre>" ;
                die() ;
                */
                
                $count= count($wsResult);
                if(is_array($wsResult->VOBS)) {
                    $wsResult = $wsResult->VOBS ;
                } 
                
                if ($count>0) {
                    $UProg = '' ;
                    foreach ($wsResult as $v1) {
                            
                            if($v1->ID_NIVEL_PROGRAMA >=1 && strlen($v1->DS_PROGRAMA_ABREV)>0){
                                
                                if ($UProg!='') {
                                    $prog_ok = " ".$v1->DS_PROGRAMA_ABREV ;
                                    } else {
                                     $prog_ok = $v1->DS_PROGRAMA_ABREV ;
                                    }
                                $UProg .= $prog_ok ;
                                
                                }
                
                }
                } else {
                    $UProg="" ;
                    
                }
                return $UProg ;
                
}  
  
?>
