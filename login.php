<?php
  
    function validaCPF($cpf)
    {    // Verifiva se o nÃºmero digitado contÃ©m todos os digitos
        $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequÃªncias abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
        {
            return false;
        }
        else
        {   // Calcula os nÃºmeros para verificar se o CPF Ã© verdadeiro
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
    
    
     function isCnpjValid($cnpj)
         {
            //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
            $j=0;
            for($i=0; $i<(strlen($cnpj)); $i++)
                {
                    if(is_numeric($cnpj[$i]))
                        {
                            $num[$j]=$cnpj[$i];
                            $j++;
                        }
                }
            //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
            if(count($num)!=14)
                {
                    $isCnpjValid=false;
                }
            //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
            if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
                {
                    $isCnpjValid=false;
                }
            //Etapa 4: Calcula e compara o primeiro dígito verificador.
            else
                {
                    $j=5;
                    for($i=0; $i<4; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);
                    $j=9;
                    for($i=4; $i<12; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);    
                    $resto = $soma%11;            
                    if($resto<2)
                        {
                            $dg=0;
                        }
                    else
                        {
                            $dg=11-$resto;
                        }
                    if($dg!=$num[12])
                        {
                            $isCnpjValid=false;
                        } 
                }
            //Etapa 5: Calcula e compara o segundo dígito verificador.
            if(!isset($isCnpjValid))
                {
                    $j=6;
                    for($i=0; $i<5; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);
                    $j=9;
                    for($i=5; $i<13; $i++)
                        {
                            $multiplica[$i]=$num[$i]*$j;
                            $j--;
                        }
                    $soma = array_sum($multiplica);    
                    $resto = $soma%11;            
                    if($resto<2)
                        {
                            $dg=0;
                        }
                    else
                        {
                            $dg=11-$resto;
                        }
                    if($dg!=$num[13])
                        {
                            $isCnpjValid=false;
                        }
                    else
                        {
                            $isCnpjValid=true;
                        }
                }
            //Trecho usado para depurar erros.
            /*
            if($isCnpjValid==true)
                {
                    echo "<p><font color=\"GREEN\">Cnpj é Válido</font></p>";
                }
            if($isCnpjValid==false)
                {
                    echo "<p><font color=\"RED\">Cnpj Inválido</font></p>";
                }
            */
            //Etapa 6: Retorna o Resultado em um valor booleano.
            return $isCnpjValid;            
        }


    function getw12($cpf) {


        //==========INTERAÃƒâ€¡Ãƒâ€¢ES COM O EVO====================================//
        $client = new
        SoapClient(
            "http://177.154.134.90:8084/WCF/Clientes/wcfClientes.svc?wsdl"
        );
        $params = array('IdClienteW12'=>229, 'IdFilial'=>1, 'CpfCnpj'=>$cpf, 'TipoCliente'=>1);
        $webService = $client->ListarClienteCPFCNPJ($params);
        $wsResult = $webService->ListarClienteCPFCNPJResult;


        // Recupera o IdCliente
        $w12id = $wsResult->ID_CLIENTE;
        return $w12id;
    }


    function login($cpf,$password){

        $db =& JFactory::getDBO();
        $query = 'SELECT wow_users.id,name,username,email,password FROM	wow_users WHERE	REPLACE(REPLACE(username,".",""),"-","") LIKE '.$db->Quote($cpf) ;
        $db->setQuery($query) ;
        $result =  $db->loadObjectList();

        $credentials = explode(':',$result[0]->password) ;
        $md5pass = $credentials[0] ;
        $saltpass = $credentials[1];

        $check_pass =  md5($password.$saltpass) ;


        $ret = ($check_pass==$md5pass) ? $result[0]->id : 0;
        return $ret;

    }
    
$template = <<<EOT
    <form id="login" action="eclub" method="POST">
    <p class="head">Para acessar o E-Club, por favor, identifique-se abaixo:</p>
    <div id="response" class="detalhe left_border" style="float:right"></div>
        <div id="info" class="info">
            <input type="text" id="cnpj" name="cnpj" placeholder="Digite o CNPJ" /><br/>
            <input type="password" id="password" name="password" placeholder="Digite sua senha" />
            <input type="submit" value="Verificar" id="lnk_login" name="lnk_login" /><br/>
            <a href="../recuperar-senha" id="recuperar-pass">Esqueci minha senha</a>
    </div>
    </form>
EOT;

if(isset($_POST['lnk_login']))  {
    
    //include('../../../exec_in_joomla.inc') ;

    //PARAMETROS DE ENTRADA
    $cpf = $_POST['cnpj'] ;
    $password = $_POST['password'] ;

    $cpf = str_replace('-','',str_replace('.','',$cpf));
  
    //LOCALIZA A SENHA DO CLIENTE
   if(strlen($cpf)>11){
       $log= isCnpjValid($cpf) ;  
   } else {
       $log = validaCPF($cpf);
   }
    
   
    
    if($log ==true)   {
        $ret = getw12($cpf);            
        file_put_contents('_ferramentas/e-club/login.log',$ret) ;
        $data = base64_encode($ret) ;
        $login_ok = login($cpf,$password) ;
        if($login_ok > 0 && $ret>0) {
            Header('Location: http://bodysystems.net/eclub-access?evoid='.$data);
        } else {
            echo "<center><p class='alert' >SENHA INVÁLIDA. POR FAVOR TENTE NOVAMENTE.</p></center>" ;
        }
        
    } else {
       //$ret= array('Documento inválido',0) ;
       echo "<center><p class='alert' >LOGIN INVÁLIDO. POR FAVOR CONSULTE NOSSO SUPORTE TÉCNICO.</p></center>" ;
    }

    
}
  
echo $template ;
  
?>
