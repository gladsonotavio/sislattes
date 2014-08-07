
<html>
<head>
<style type="text/css">
.table{  border-collapse: collapse; width:590px;  font-size:12; text-align: center}
.table tr td {border:1px solid #000;}
.table th{border:2px solid #000; background-color:#5458B3; height:30; font-size:small; color:white}
</style>
	<link rel="stylesheet" type="text/css" href="css/lattes.css"  />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Produção Intelectual</title>
</head>

<body>

<?php include 'layout/topo.php' ;?>
<?php include 'layout/box_center.php' ;?>

<div id="conteudo">


<center>
<h2> Informações do Currículo Lattes.</h2>
<table class="table">
	<tr  >
		<th >Nome</th>
		<th>Data de atualizacão</th>		
		
	</tr>
	</center>
	
<?php $arquivo = glob('curriculos/*.xml');     
      if ($arquivo !== false) {
      	   $nomes = array();
          foreach ($arquivo as $arquivos){                         
      
                $xml = simplexml_load_file( $arquivos);

                          $data_curriculo = $xml{'DATA-ATUALIZACAO'};
                          $nome = utf8_decode($xml->{'DADOS-GERAIS'}{'NOME-COMPLETO'});          
                                
                       
                        $lista[] = array(nome=>$nome, atualizacao=>$data_curriculo);
                         



           }
          sort($lista);    

       }
?>                        
             
                 
<?php     for($rows = 0;$rows< count($lista);$rows++) {?>
           
           			<tr>
                 <?php echo"<td>".  $lista[$rows]['nome']."</td><td>" .$lista[$rows]['atualizacao']."</td>" ;?>     
              </tr>
              
<?php     }?>
           	                             	
	                 

                                                      
  
                  
               
 <table summary="teste" >

</table>                    
      
</div>


</body>
</html>
