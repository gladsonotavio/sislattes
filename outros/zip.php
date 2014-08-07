<?php

$zip = zip_open("8545870038468318.zip"); //DEFINE O ARQUIVO A SER ABERTO

if (is_resource($zip)) {

while ($zip_entry = zip_read($zip)) {

$fp = fopen("8545870038468318/". zip_entry_name($zip_entry), "w");

if (zip_entry_open($zip, $zip_entry, "r")) {

$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)); fwrite($fp,"$buf");

zip_entry_close($zip_entry);

print(zip_entry_name($zip_entry)); //IMPRIME O ARQUIVO ABERTO

fclose($fp); } }

zip_close($zip); }


?>