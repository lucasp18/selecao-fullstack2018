
<?php
require_once("aplicacaoVacina.php");

class AplicacaoVacinaDao {
    

    /** @param Animal $animal */
    public function insert($aplicacaoVacina) {

        $return = array();
        $param = array("sdss",
            $aplicacaoVacina->getAni_int_codigo(),
            $aplicacaoVacina->getVac_int_codigo(),
            $aplicacaoVacina->getUsu_int_codigo()            
            );
        try{
            $mysql = new GDbMysql();            
            $mysql->execute("CALL sp_animalvacina_aplica_ins($param[1],$param[2],$param[3],'S', @p_status, @p_msg, @p_insert_id);", $param, false);
            
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