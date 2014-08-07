
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css"   />
	<style type="text/css">
#conteudo1{width: 590px; height:; font-size: 12px	; text-align: justify; }	
</style>
	<title>Produção Intelectual</title>

	
</head>

<body >



<div id="conteudo1">
<div id="producaoIntelectual">
<?php

echo"	<h2><center>Produção Intelectual</center></h2><br>";

// Abre um diretorio conhecido, e faz a leitura de seu conteudo

   $dir =  $_UP['pasta'];    


    $arquivo = glob('curriculos/*.xml');     
      if ($arquivo !== false) {
          foreach ($arquivo as $arquivos){       	
	              
	
   //define o encoding do cabeçalho para utf-8
   @header('Content-Type: text/html; charset=utf-8');
      
   $xml = simplexml_load_file( $arquivos);
  
   $data = date("Y");
  
# busca de artigos completos
   foreach($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'ARTIGOS-PUBLICADOS'}->{'ARTIGO-PUBLICADO'} as $artigos){

         foreach($artigos->{'AUTORES'} as  $autores){  	      
            
      
                $ordem = $autores{'ORDEM-DE-AUTORIA'};
	         
               switch($ordem){

                   case '1':
                           $artigo_cit1  =  utf8_decode($autores['NOME-PARA-CITACAO'].";");                    
                           break;
                   case '2':      
                           $artigo_cit2  =  utf8_decode($autores['NOME-PARA-CITACAO'].";");
                            break;
                   case '3':      
                           $artigo_cit3  =  utf8_decode($autores['NOME-PARA-CITACAO'].";");				 
                           break;
                }    

	      
           }
       
         $artigo_title    = utf8_decode($artigos->{'DADOS-BASICOS-DO-ARTIGO'}['TITULO-DO-ARTIGO']);
         $artigo_peri    = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['TITULO-DO-PERIODICO-OU-REVISTA']);
         $artigo_vol     = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['VOLUME']);  
         $artigo_pag_ini = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['PAGINA-INICIAL']);   
         $artigo_pag_fim = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['PAGINA-FINAL']);   
         $artigo_ano     = utf8_decode($artigos->{'DADOS-BASICOS-DO-ARTIGO'}['ANO-DO-ARTIGO']); 
               
                
      if(($artigo_ano <= $data) & ($artigo_ano > $data -2) ) { ?>
            
<?php             echo $artigo_cit1." ".
                  $artigo_cit2 ." ".
                  $artigo_cit3 .". ". " " .
                  $artigo_title.". " ." ".
                  $artigo_peri."."." "."v.".
                  $artigo_vol.","." "."p.".
                  $artigo_pag_ini."-".
                  $artigo_pag_fim.",". " ".
                  $artigo_ano."."."<br/>"."<br/>" ;
                  
        }
         $artigo_cit1= "";
         $artigo_cit2= "";
         $artigo_cit3= "";
        
    }       ?>



         
<?php
//busca de livros publicados

 foreach(  $xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'LIVROS-E-CAPITULOS'}->children() as $elemento => $value){          	       
          	      //verifica se há livro publicado
          	 if($elemento == "LIVROS-PUBLICADOS-OU-ORGANIZADOS") { 
          	       
               foreach($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'LIVROS-E-CAPITULOS'}->{'LIVROS-PUBLICADOS-OU-ORGANIZADOS'}->{'LIVRO-PUBLICADO-OU-ORGANIZADO'} as $livro_pub){
             	    
          
                  $titulo      = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['TITULO-DO-LIVRO']);          
                  $ano         = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['ANO']);
                  $editora     = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NOME-DA-EDITORA']);
                  $editora_cid = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['CIDADE-DA-EDITORA']);
                  $volume      = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NUMERO-DE-VOLUMES']);
                  $num_pag     = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NUMERO-DE-PAGINAS']);
                  $tipo        = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['TIPO']);

// verifica se autor publicou ou organizou livro          
                
                
      
      foreach($livro_pub->{'AUTORES'} as $autores_livro){
      	
          
          switch($autores_livro{'ORDEM-DE-AUTORIA'}) {
              case '1':
                       $autor1 = utf8_decode($autores_livro['NOME-PARA-CITACAO'].";");
                       break;
             case  '2':     
                       $autor2 = utf8_decode($autores_livro['NOME-PARA-CITACAO'].";");
                       break;
             case '3':          
                       $autor3 = utf8_decode($autores_livro['NOME-PARA-CITACAO'].";");
                       break;
                       
             case '4': $autor4 = utf8_decode($autores_livro['NOME-PARA-CITACAO'].";");  
                       break;       
          }
        
      
      }
    
    
 // ultimos 3 anos     
          if(($ano <= $data) & ($ano > $data -3) ) {

           
           	 
                  echo $autor1." ".$org . " 	" .
                       $autor2 . " " . $org . "." . " " .
                       $autor3 . " " . $org . "." . " " .
                       $autor4 . " " . $org . " " . " " .
                       $titulo. "." .  " " .
                       $editora_cid . ":" . " " .
                       $editora . "," . " " .
                       $ano. "." . " " . "v." .
                       $volume. "," . " " .
                       $num_pag."p" . "<br/>"."<br />";
                       
                             
             $org = " ";         
             $autor1 =" ";   
             $autor2  =" "; 
             $autor3  =" "; 
             $autor4  =" ";
  
                       
             
             }
                         
               
            
               }
          }
                  
             
  
  }  ?> 
  
            
  
<?php   
#busca de capitulos de livros publicados
  foreach($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'LIVROS-E-CAPITULOS'}->{'CAPITULOS-DE-LIVROS-PUBLICADOS'}->{'CAPITULO-DE-LIVRO-PUBLICADO'} as $cap_livros){
  	 
     foreach($cap_livros->{'AUTORES'} as $cap_aut){ 	  	
  	  	  	  	
  	  	  
             $autoria = $cap_aut{'ORDEM-DE-AUTORIA'}; 
      
               switch($autoria){
     	
                  case '1':
                          $livros_cit1  =  utf8_decode($cap_aut['NOME-PARA-CITACAO'].";");
                          break; 
                  case '2':      
                          $livros_cit2  =  utf8_decode($cap_aut['NOME-PARA-CITACAO'].";");
                          break;
                  case '3':      
                         $livros_cit3  =  utf8_decode($cap_aut['NOME-PARA-CITACAO']); 
                          break;
                  
                }
            
     }
              
 
      $livros_cap_title =  utf8_decode($cap_livros->{'DADOS-BASICOS-DO-CAPITULO'}['TITULO-DO-CAPITULO-DO-LIVRO']);
      $livros_title     =  utf8_decode($cap_livros->{'DETALHAMENTO-DO-CAPITULO'}['TITULO-DO-LIVRO']); 
      $livros_vol       =  utf8_decode($cap_livros->{'DETALHAMENTO-DO-CAPITULO'}['NUMERO-DE-VOLUMES']);
      $livros_pag_ini  =   utf8_decode($cap_livros->{'DETALHAMENTO-DO-CAPITULO'}['PAGINA-INICIAL']); 
      $livros_pag_fim  =   utf8_decode($cap_livros->{'DETALHAMENTO-DO-CAPITULO'}['PAGINA-FINAL']);
      $livros_ano       =  utf8_decode($cap_livros->{'DADOS-BASICOS-DO-CAPITULO'}['ANO']);          	      	
    
      

                   
               if(($livros_ano <= $data) & ($livros_ano > $data -2) ) { ?>
     
<?php              
             echo $livros_cit1." ".
                  $livros_cit2 ." ".
                  $livros_cit3  . "" . " " .
                  $livros_cap_title."."." ".
                  $livros_title ." "."v.".                  
                  $livros_vol.","." "."p.".
                  $livros_pag_ini."-".
                  $livros_pag_fim.",". " ".
                  $livros_ano."." . "<br/>"."<br/>";
         }        
     
             $livros_cit1  =" ";   
             $livros_cit2  =" "; 
             $livros_cit3  =" ";   
       
   }
}


     
} ?>


 

</div>

</div>
    
  

 

</body>
</html>






