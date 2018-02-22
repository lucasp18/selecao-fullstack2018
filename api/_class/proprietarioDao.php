<?php

require_once("proprietario.php");

class ProprietarioDao{


	public static function insert($proprietario) {

        $return = array();
        $param = array("sdss",
            $proprietario->getPro_var_nome(),
            $proprietario->getPro_var_email(),
            $proprietario->getPro_var_telefone()
            );
        	
        try{
            $mysql = new GDbMysql();
            
            $mysql->execute("CALL sp_proprietario_ins('$param[1]','$param[2]','$param[3]', @p_status, @p_msg, @p_insert_id);", $param, false);
            $mysql->execute("SELECT @p_status, @p_msg, @p_insert_id");
            $mysql->fetch();
            $return["status"] = ($mysql->res[0]) ? true : false;
            $return["msg"] = $mysql->res[1];
            $return["insertId"] = $mysql->res[2];
            $mysql->close();
        } catch (GDbException $e) {
            $return["status"] = false;
            $return["msg"] = $e->getError();
        }
        return $return;
    }

}
