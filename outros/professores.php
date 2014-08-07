<?php



function validarCurriculo($cv){	 

include 'conexaofirebird.php';

		$sql = "select nomehp,emailhp,linklattes,homepage,titulhp from orient where exibirhp='S' order by nomehp" ;
		$resultado = ibase_query($conexao, $sql);  

	 	 while ($row = ibase_fetch_row($resultado)){

              $linklattes= explode("/", strrchr($row[2] ,'/')) ;
			      $linklattes = $linklattes[1] ;
			        
			     if($cv == $linklattes) {
			     	
			     	
              }
       }
}

$cv = '4883181787621572' ;

validarCurriculo($cv) ;

 ?>