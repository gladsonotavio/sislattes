<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
                         <CENTER>  <strong><h1>SISTEMA EM TESTE</h1><<>></strong>></CENTER>  

<hr>
<form method="post" action="lattes.php"  enctype="multipart/form-data">
<input type="file" name="arquivo" ><br><br>
<input type="submit" value="Enviar">
<input type="reset" value="Apagar">
</form>
<hr><br>

<?php

// Pasta onde o arquivo vai ser salvo
 $_UP['pasta'] = 'curriculos/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 8; // 8Mb

// Array com as extensões permitidas
$_UP['extensoes'] = array('zip');

// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = false;

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
exit; // Parar a execução do script
}

if($_FILES['arquivo']['name'] != "" ){

// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "<font color= 'red' >Arquivo com extensão inválida</font></br></br>";
echo "<font color= 'blue' >Por favor, envie arquivos  Somente com extensão .ZIP</font></br></br>";
break;
}

// Faz a verificação do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
echo "O arquivo enviado é muito grande, envie arquivos de até 8Mb.";
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
$nome_final = time().'.jpg';
} else {
// Mantém o nome original do arquivo
$nome_final = $_FILES['arquivo']['name'];
}

// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso
echo "Upload efetuado com sucesso!";
//echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
echo "Não foi possível enviar o arquivo, tente novamente";
}

}

//descompactar o arquivo
$zip = new ZipArchive();
$zip->open($_UP['pasta'].$nome_final);
$zip->extractTo( $_UP['pasta']);

//substituindo a string zip por xml
$arquivo_renomeado = substr_replace("$nome_final",'xml',-3);
copy($_UP['pasta']."curriculo.xml" , $_UP['pasta'].$arquivo_renomeado);
unlink($_UP['pasta']."/curriculo.xml");
unlink($_UP['pasta'].$nome_final);
$zip->close();

	 

/*$nome_temporario=$_FILES["Arquivo"]["tmp_name"];
$nome_real=$_FILES["Arquivo"]["name"]; 
copy($nome_temporario,"$nome_real"); 
*/

//if($nome_final != ""){
	
	
echo"	<h2><center>Produção Intelectual</center></h2><br>";



// Abre um diretorio conhecido, e faz a leitura de seu conteudo

   $dir =  $_UP['pasta'];    

    echo $arquivo;    
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
                           $artigo_cit1  =  utf8_decode($autores['NOME-PARA-CITACAO']);                    
                           break;
                   case '2':      
                           $artigo_cit2  =  utf8_decode($autores['NOME-PARA-CITACAO']);
                            break;
                   case '3':      
                           $artigo_cit3  =  utf8_decode($autores['NOME-PARA-CITACAO']);				 
                           break;
                }    

	      
           }
       
         $artigo_title    = utf8_decode($artigos->{'DADOS-BASICOS-DO-ARTIGO'}['TITULO-DO-ARTIGO']);
         $artigo_peri    = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['TITULO-DO-PERIODICO-OU-REVISTA']);
         $artigo_vol     = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['VOLUME']);  
         $artigo_pag_ini = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['PAGINA-INICIAL']);   
         $artigo_pag_fim = utf8_decode($artigos->{'DETALHAMENTO-DO-ARTIGO'}['PAGINA-FINAL']);   
         $artigo_ano     = utf8_decode($artigos->{'DADOS-BASICOS-DO-ARTIGO'}['ANO-DO-ARTIGO']);
               
                
      if(($artigo_ano <= $data) & ($artigo_ano > $data -2) ) {
             echo $artigo_cit1."; "." ".
                  $artigo_cit2 .";"." ".
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
        
    }       

#busca de livros publicados
  foreach($xml->{'PRODUCAO-BIBLIOGRAFICA'}->{'LIVROS-E-CAPITULOS'}->{'LIVROS-PUBLICADOS-OU-ORGANIZADOS'}->{'LIVRO-PUBLICADO-OU-ORGANIZADO'} as $livro_pub){
            
          
          $titulo      = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['TITULO-DO-LIVRO']);          
          $ano         = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['ANO']);
          $editora     = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NOME-DA-EDITORA']);
          $editora_cid = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['CIDADE-DA-EDITORA']);
          $volume      = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NUMERO-DE-VOLUMES']);
          $num_pag     = utf8_decode($livro_pub->{'DETALHAMENTO-DO-LIVRO'}['NUMERO-DE-PAGINAS']);
          $tipo = utf8_decode($livro_pub->{'DADOS-BASICOS-DO-LIVRO'}['TIPO']);

// verifica se autor publicou ou organizou livro          
          if($tipo == 'LIVRO_ORGANIZADO_OU_EDICAO'){
               $org = '(Org.)';          
          }
      
      
             $autor1 =" ";   
             $autor2  =" "; 
             $autor3  =" "; 
      
      foreach($livro_pub->{'AUTORES'} as $autores_livro){
          
          switch($autores_livro{'ORDEM-DE-AUTORIA'}) {
              case '1':
                       $autor1 = utf8_decode($autores_livro['NOME-PARA-CITACAO']);
                       break;
             case  '2':     
                       $autor2 = utf8_decode($autores_livro['NOME-PARA-CITACAO']);
                       break;
             case '3':          
                       $autor3 = utf8_decode($autores_livro['NOME-PARA-CITACAO']);
                       break;
          }
      
      }
 // ultimos 3 anos     
          if(($ano <= $data) & ($ano > $data -3) ) {
             if($autor2 != " " & $autor3 != " ") {
          	 
                  echo $autor1." ".$org . " 	" .
                       $autor2 . " " . $org . "." . " " .
                       $autor3 . " " . $org . "." . " " .
                       $titulo. "." .  " " .
                       $editora_cid . ":" . " " .
                       $editora . "," . " " .
                       $ano. "." . " " . "v." .
                       $volume. "," . " " .
                       $num_pag."p" . "<br/>"."<br />";
              }
                        if($autor2 != " " & $autor3 == " ") {
                             echo $autor1.$org . " " ." ".
                                  $autor2.$org 	 . " " .
                                  $titulo. "." .  " " .
                                  $editora_cid . ":" . " " .
                                  $editora . "," . " " .
                                  $ano. "." . " " . "v." .
                                  $volume. "," . " " .
                                  $num_pag."p" . "<br/>"."<br />";
              }  else {
                             echo $autor1." ".$org . " " .
                                  $titulo. "." .  " " .
                                  $editora_cid . ":" . " " .
                                  $editora . "," . " " .
                                  $ano. "." . " " . "v." .
                                  $volume. "," . " " .
                                  $num_pag."p" . "<br/>"."<br />";
                 }                    
                 
         }        
       
  
  }                
  
   
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
    
      

                   
               if(($livros_ano <= $data) & ($livros_ano > $data -2) ) {
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


     
}
        
    }
  
 		
 
?>
</body>
</html>






