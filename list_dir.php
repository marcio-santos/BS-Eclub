<?php 
//error_reporting(E_ALL ^ NOTICE ^ E_STRICT);

$document =& JFactory::getDocument();

$document->addScript('_ferramentas/fancybox/lib/jquery-1.10.1.min.js');
$document->addScript('_ferramentas/fancybox/source/jquery.fancybox.pack.js?v=2.1.5');
$document->addStyleSheet('_ferramentas/fancybox/source/jquery.fancybox.css?v=2.1.5') ;
$document->addScript( "_ferramentas/e-club/main.js" );
$document->addScript( "_ferramentas/e-club/thumb.js" );


//include_once ('_ferramentas/e-club/dash_toolbar.php') ;
//include_once('_ferramentas/e-club/getW12Cli.php');


//SOMENTE PARA ACADEMIAS CREDENCIADAS
/*
$evo_id = getW12() ;          
$user =& JFactory::getUser(); 
 
 
        $dbx =& JFactory::getDBO();    
        $query="SELECT profiletype FROM jos_xipt_users WHERE userid=".$user->id ;
        $dbx->setQuery($query);
        $Acad = $dbx->loadResult();
        
        if ($Acad!=1 || $evo_id==0 || $evo_id ==64421) {
            header("Location: http://bodysystems.net/index.php?option=com_jumi&fileid=14&Itemid=257") ;
            die() ;
        }
  */      
//==================================================


function extenso($prog) {
     
    Switch($prog) {
        Case 'BA' : $label = 'BODYATTACK'; break;
        Case 'BB' : $label = 'BODYBALANCE'; break;
        Case 'BC' : $label = 'BODYCOMBAT'; break;
        Case 'BJ' : $label = 'BODYJAM'; break;
        Case 'BP' : $label = 'BODYPUMP'; break;
        Case 'BS' : $label = 'BODYSTEP'; break;
        Case 'PJ' : $label = 'POWER JUMP'; break;
        Case 'RPM' : $label = 'RPM'; break;
        Case 'CX' : $label = 'CX30'; break;
        Case 'SB' : $label = 'SHBAM'; break;
        Case 'BV' : $label = 'BODYVIVE'; break;
    } 
    return $label ;
     
 }

function ListFiles($dir) {
    
    if($dh = opendir($dir)) {

        $files = Array();
        $inner_files = Array();
        while($file = readdir($dh)) {
            if($file != "." && $file != ".." && $file[0] != '.') {
                if(is_dir($dir . "/" . $file)) {
                    echo "<br style='clear:both' /><div><h1>".$file."</h1><hr/></div>";
                    $inner_files = ListFiles($dir . "/" . $file);
                    if(is_array($inner_files)) $files = array_merge($files, $inner_files); 
                } else {
                    //array_push($files, $dir . "/" . $file);
                    //echo $file."<br/>";
                    $original = $dir."/". substr_replace($file, '', 0, 3) ;
                    if(substr($file,0,3)=="tn_") {
                        
                        $ext = strtoupper( substr($file,3,3));
                        if ($ext == 'PDF' || $ext== 'CDR' || $ext== 'AII' || $ext== 'EPS' || $ext== 'ZIP' || $ext== 'PSD') {
                            if($ext=='AII') {$ext = 'AI';}
                            $down_file =  $dir."/".substr($file,7,strlen($file)-11).".".strtolower($ext);
                            $filesize = filesize($down_file)/1024;
                            $tipo = $ext ;
                        } else {
                            
                            $down_file = $original ;
                            $file_tam = filesize($original);
                            $tipo = 'JPG' ;
                            $filesize = $file_tam/1024 ;
                        }
                            
                        $filesize = number_format($filesize,2,".","") ;
                        $med_thumb = substr_replace($file, 'tn2', 0, 2); //xabcd
                        echo "<div align='center' style='height:160px; width:140px;float:left; position:relative;padding:10px; border:solid 1px #CCC; margin:5px;'><div style='height:120px; width:120px; overflow:hidden;'><a rel='rokbox[385 200]' href='".$dir . "/" .$med_thumb."'><img src='".$dir . "/" . $file."' /></a></div><center><span style='font-size:11px;'>Arquivo ".$tipo." - ".$filesize." Kb</span><br/><span style='font-size:11px;'><a href='download.php?arquivo=$down_file'>Download</a></span></center></div>";
                    }
                 
                }
            }
        }

        closedir($dh);
        return $files;
    }
}

require_once('_ferramentas/e-club/verifica_mta.php');
//require_once('_ferramentas/e-club/getW12Cli.php') ;

$mdata = $_GET['evoid'] ;
$evo_id = base64_decode($mdata) ; //11; //getW12() ;

$prog_str = check_mta($evo_id);


$programas = explode(" ", $prog_str) ;
sort($programas) ;


$template_form = <<<EOT

<form id="setprog" name="setprog" method="post" >
<input type="hidden" id="ftitulo" name="ftitulo" value="" />
<input type="hidden" id="theprog" name="theprog" value="" />
</form>

EOT;

echo $template_form ;

foreach($programas as $key){ 
    
 $label = extenso($key) ;
    
    echo "<div align='center' style='height:48px; width:48px;float:left; position:relative;padding:10px; border:solid 1px #CCC; margin:5px;font-size:11px;'><img src='http://bodysystems.net/images/gestor/$key.jpg' alt='$label' title='$label' onClick='SubmitForm(&quot;$key&quot;)' style='cursor:pointer' /></div>" ;
    
}


$ViewFolder='_ferramentas/e-club/'.$programas[0];

$Tit = extenso($programas[0]) ;

if(isset($_POST['theprog'])) {
    $Prog = $_POST['theprog'] ;
    $Tit = $_POST['ftitulo'] ;
    $ViewFolder = "_ferramentas/e-club/".$Prog;
}


echo "<br style='clear:both' /><div class='info' ><span style='font-size:18px;'>Conteúdo do Programa $Tit</span><br/><small>Clique nos &iacute;cones acima para selecionar o conte&uacute;do do respectivo Programa.</small></div>" ; 


foreach (ListFiles($ViewFolder) as $key=>$file){
    //echo $file ."<br />";
}  

?>