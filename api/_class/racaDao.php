<?php

require_once("raca.php");

class RacaDao{


	public static function selectAll() {

        try{
            $mysql = new GDbMysql();
            
            $mysql->execute("SELECT rac_int_codigo,rac_var_nome FROM vw_raca ",null, false);
            $racas[] = "";
            while($mysql->fetch()){
              $racas[$mysql->res[0]] =  $mysql->res[1];  
            };
            
        } catch (GDbException $e) {
            throw new Exception("Erro na consulta de raça", 1);              
        }
        return $racas;
    }
    

}
