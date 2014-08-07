<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="css/lattes.css" />
<title></title>
</head>
<body>

<?php
include 'layout/corpo.php';
include 'layout/topo.php';
include 'layout/box_center.php';?>

	<div id="conteudo">
<?php 	

//extraindo o número lattes do arquivo no upload
$lattes = explode('.',$_FILES['arquivo']['name'] );
$cv =  $lattes[0];

//verificando se curriculo pertence a professor do poslin
include 'conexaofirebird.php';

		$sql = "select nomehp,emailhp,linklattes,homepage,titulhp from orient where exibirhp='S' order by nomehp" ;
		$resultado = ibase_query($conexao, $sql);  

	 	 while ($row = ibase_fetch_row($resultado)){

         $linklattes= explode("/", strrchr($row[2] ,'/')) ;
              
			      $linklattes =    $linklattes[1] ;
			     
			        
			        if($cv == $linklattes) {   			    	  

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
// Faz a verificação da extensão do arquivo
		            $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
	             if (array_search($extensao, $_UP['extensoes']) === false) {
	                	echo "<font color= 'red' >Arquivo com extensão inválida</font></br></br>";
		                echo "<font color= 'blue' >Por favor, envie arquivos  Somente com extensão .ZIP</font></br></br>";
		
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

?>

  <?php	      
	             echo"<br /><br />";
              echo '<br /><a href="base.php  ">Novo Upload</a>';
              
	

              echo '<br /><a href="  producaoIntelectual.php  ">Visualizar o Resultado</a>';
              
       
           
           }
         
         
       }
       
   ?>
</div>




</body>
</html>




