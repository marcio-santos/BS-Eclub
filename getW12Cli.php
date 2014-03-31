<?php
// Função que valida o CPF
function validaCPF($cpf)
{    // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
    
    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
    {
    return false;
    }
    else
    {   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

function validaCNPJ($cnpj) { 
    if (strlen($cnpj) <> 14) return false; 
    $soma1 = ($cnpj[0] * 5) + 

    ($cnpj[1] * 4) + 
    ($cnpj[3] * 3) + 
    ($cnpj[4] * 2) + 
    ($cnpj[5] * 9) + 
    ($cnpj[7] * 8) + 
    ($cnpj[8] * 7) + 
    ($cnpj[9] * 6) + 
    ($cnpj[11] * 5) + 
    ($cnpj[12] * 4) + 
    ($cnpj[13] * 3) + 
    ($cnpj[14] * 2); 
    $resto = $soma1 % 11; 
    $digito1 = $resto < 2 ? 0 : 11 - $resto; 
    $soma2 = ($cnpj[0] * 6) + 

    ($cnpj[1] * 5) + 
    ($cnpj[3] * 4) + 
    ($cnpj[4] * 3) + 
    ($cnpj[5] * 2) + 
    ($cnpj[7] * 9) + 
    ($cnpj[8] * 8) + 
    ($cnpj[9] * 7) + 
    ($cnpj[11] * 6) + 
    ($cnpj[12] * 5) + 
    ($cnpj[13] * 4) + 
    ($cnpj[14] * 3) + 
    ($cnpj[16] * 2); 
    $resto = $soma2 % 11; 
    $digito2 = $resto < 2 ? 0 : 11 - $resto; 
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2)); 
} 

 function getW12()
 
  {
    
    
  $user =& JFactory::getUser(); 
  $vUser = $user->id ;
    //echo "<h1>Este é o User->id:".$vUser."</h1>" ;
    
       $db =& JFactory::getDBO();
      
      $query1 = "SELECT value FROM jos_community_fields_values WHERE field_id=23  AND value<>'' AND user_id=".$vUser;
      $db->setQuery($query1);
      $Cpf = $db->loadResult();
      
      if (strlen($Cpf)!=0) {
              
          // Normaliza o CPF e envia de volta  para o Database
              
               $Cpf = str_replace(".","",$Cpf) ;
               $Cpf = str_replace("-","",$Cpf) ;
               $Cpf = str_replace("/","",$Cpf) ;
               $Cpf = str_replace(" ","",$Cpf) ;
              
              $query2 = "UPDATE jos_community_fields_values SET value='".$Cpf."' WHERE field_id=23  AND value<>'' AND user_id=".$vUser;
              $db->setQuery($query2);
              $db->query();
       }       
      
      
      
      
      //echo "<h1>Este é o CPF:".$Cpf."</h1>" ;
      
      if(strlen($Cpf)==0) { 
          //não tem CPF cadastrado no site
          $w12Id = 1 ;
          return $w12Id;
          exit();
      
      /*
      } else if (strlen($Cpf)==11) {
          
          if (validaCPF($Cpf)){
              
          }
          */
          
      } else {
          //verifica se existem pontos ou traços
          $normalize = array(".", "-","/", " ") ;
          $Cpf = str_replace($normalize,"",$Cpf) ;
      
      
      $query2 = "SELECT value FROM jos_community_fields_values WHERE field_id=21  AND value<>'' AND user_id=".$vUser;
      $db->setQuery($query2);
      $Type = $db->loadResult();
      //echo "<h1>Este é o Tipo:".$Type."</h1>" ;
      
      $client = new 
            SoapClient( 
                "http://177.154.134.90:8084/WCF/Clientes/wcfClientes.svc?wsdl" 
            ); 
        $params = array('IdClienteW12'=>229, 'IdFilial'=>1, 'CpfCnpj'=>$Cpf, 'TipoCliente'=>$Type); 
        $webService = $client->ListarClienteCPFCNPJ($params); 
        $wsResult = $webService->ListarClienteCPFCNPJResult; 


    // Recupera o IdCliente
     $w12Id = $wsResult->ID_CLIENTE;
     
     //echo $w12Id; 
     
                   
     return $w12Id;
 }   
 
      
      }

      
 function getEvo_Name()
 
  {
    
    
  $user =& JFactory::getUser(); 
  $vUser = $user->id ;
    //echo "<h1>Este é o User->id:".$vUser."</h1>" ;
    
       $db =& JFactory::getDBO();
      
      $query1 = "SELECT value FROM jos_community_fields_values WHERE field_id=23  AND value<>'' AND user_id=".$vUser;
      $db->setQuery($query1);
      $Cpf = $db->loadResult();
      
      if (strlen($Cpf)!=0) {
              
          // Normaliza o CPF e envia de volta  para o Database
              
               $Cpf = str_replace(".","",$Cpf) ;
               $Cpf = str_replace("-","",$Cpf) ;
               $Cpf = str_replace("/","",$Cpf) ;
               $Cpf = str_replace(" ","",$Cpf) ;
              
              $query2 = "UPDATE jos_community_fields_values SET value='".$Cpf."' WHERE field_id=23  AND value<>'' AND user_id=".$vUser;
              $db->setQuery($query2);
              $db->query();
       }       
      
      
      
      
      //echo "<h1>Este é o CPF:".$Cpf."</h1>" ;
      
      if(strlen($Cpf)==0) { 
          //não tem CPF cadastrado no site
          $w12Id = 1 ;
          return $w12Id;
          exit();
      
      /*
      } else if (strlen($Cpf)==11) {
          
          if (validaCPF($Cpf)){
              
          }
          */
          
      } else {
          //verifica se existem pontos ou traços
          $normalize = array(".", "-","/", " ") ;
          $Cpf = str_replace($normalize,"",$Cpf) ;
      
      
      $query2 = "SELECT value FROM jos_community_fields_values WHERE field_id=21  AND value<>'' AND user_id=".$vUser;
      $db->setQuery($query2);
      $Type = $db->loadResult();
      //echo "<h1>Este é o Tipo:".$Type."</h1>" ;
      
      $client = new 
            SoapClient( 
                "http://177.154.134.90:8084/WCF/Clientes/wcfClientes.svc?wsdl" 
            ); 
        $params = array('IdClienteW12'=>229, 'IdFilial'=>1, 'CpfCnpj'=>$Cpf, 'TipoCliente'=>$Type); 
        $webService = $client->ListarClienteCPFCNPJ($params); 
        $wsResult = $webService->ListarClienteCPFCNPJResult; 


    // Recupera o IdCliente
     $w12Id = $wsResult->NOME;
     
     //echo $w12Id; 
     
                   
     return $w12Id;
 }   
 
      
      }      
      
      
?>
