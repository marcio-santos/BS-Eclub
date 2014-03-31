function getTotal($id) {
  
  
        //var $vTotal=0 ;
        //var $ticket='' ;
        var $userid = document.user.userid.value ;
        var $local = document.user.local.value ;
        var $trailer = document.user.trailer.value ;
        $gastar_onde =  $local.toUpperCase() ;
  
        
        //var $block='' ;
        //$block="XFD1585" ;
        
        
        if ($id == 1) {
            $id = document.user.ticket.value ;
        }


		$ticket=$userid+$trailer;

        document.ticket.qtosTickets.value = $id ;				
        switch ($id) {
            case 5 : 
                $vTotal=2160 ;

                document.user.ticket.value = $id ;
                break ;
            case 10 : 
                $vTotal=4130 ;
                document.user.ticket.value = $id ;
                break ;
            case 15 : 
                $vTotal=5910 ;
                document.user.ticket.value = $id ;
                break ;
            
        }
        
        //var num = new Number($vTotal) ;
		$subTotal= ($vTotal/$id)-90 ;
        document.getElementById('total').innerHTML = 'R$ ' + $vTotal.toFixed(2);
        document.getElementById('subtotal').innerHTML = 'R$ ' + $subTotal.toFixed(2);
        document.pagseguro.item_valor.value = $vTotal*100 ;
        document.pagseguro.item_id.value = $ticket ;
        document.pagseguro.item_descr.value = "Compra Corporativa C" + $id + " - " + $gastar_onde ;
        
    }

    
function Onde() {
    var $gastar_onde = document.corporate.onde.options[document.corporate.onde.options.selectedIndex].value ;
    document.user.local.value = $gastar_onde ;
	document.ticket.destino.value = $gastar_onde ;				
    getTotal(1) ;
    
}

function getTickets() {
	
	var $vKeys = document.getElementById('keys').innerHTML ;
	document.getElementById('mt').value= $vKeys ;


}


function printSelection(node){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=10,height=10');

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();
 
  setTimeout(function(){pwin.close();},10000);

}


function toggle( $obj,$label,$msg ) {
	var ele = document.getElementById($obj);
	var rot = document.getElementById($label) ;
	if(ele.style.display == "block") {
    		ele.style.display = "none";
			rot.innerHTML = $msg ;

  	}
	else {
		ele.style.display = "block";
		rot.innerHTML = "Veja menos"		
	}
} 

function doSession($vTrailer) {
    document.vSession.the_trailer.value = $vTrailer ;
    document.vSession.submit() ;
}

//usada no eClub
function SubmitForm ($progid){
   
   switch($progid) 
   {
        case 'ACL' : $label = 'CAMPANHA 2013'; break;
        case 'BA' : $label = 'BODYATTACK'; break;
        case 'BB' : $label = 'BODYBALANCE'; break;
        case 'BC' : $label = 'BODYCOMBAT'; break;
        case 'BJ' : $label = 'BODYJAM'; break;
        case 'BP' : $label = 'BODYPUMP'; break;
        case 'BS' : $label = 'BODYSTEP'; break;
        case 'PJ' : $label = 'POWER JUMP'; break;
        case 'RPM' : $label = 'RPM'; break;
        case 'CX' : $label = 'CXWORX'; break;
        case 'SB' : $label = 'SHBAM'; break;
        case 'BV' : $label = 'BODYVIVE'; break;
    }
    
    
    document.getElementById('theprog').value = $progid ;
    document.getElementById('ftitulo').value = $label ;
    document.setprog.submit();
    
}