<?php

define("DB_HOST", "localhost");
define("DB_NAME", "bd_teste");
define("DB_USER", "root");
define("DB_PASS", "");
//Conexao com Banco de Dados
return new PDO(sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_NAME), DB_USER, DB_PASS);