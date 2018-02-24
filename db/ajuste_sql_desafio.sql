DROP TABLE IF EXISTS proprietario;
create table proprietario(pro_int_codigo int(11) not null auto_increment, pro_var_nome varchar(50) not null, pro_var_email varchar(50) not null, pro_var_telefone varchar(12) not null, primary key(pro_int_codigo) );

alter table animal add pro_int_codigo int(11) not null;

alter table animal add constraint fk_animal_proprietario foreign key (pro_int_codigo) references proprietario(pro_int_codigo) on delete restrict on update restrict;



--
-- Definition for view vw_proprietario
--
DROP VIEW IF EXISTS vw_proprietario CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_proprietario
AS
  select `proprietario`.`pro_int_codigo` AS `pro_int_codigo`,`proprietario`.`pro_var_nome` AS `pro_var_nome`,`proprietario`.`pro_var_email` AS `pro_var_email`,`proprietario`.`pro_var_telefone` AS `pro_var_telefone` from `proprietario`;




DELIMITER $$

--
-- Definition for procedure sp_proprietario_ins
--
DROP PROCEDURE IF EXISTS sp_proprietario_ins$$
CREATE PROCEDURE sp_proprietario_ins(IN p_pro_var_nome VARCHAR(50), IN p_pro_var_email VARCHAR(50), IN p_pro_var_telefone VARCHAR(12), INOUT p_status BOOLEAN, INOUT p_msg TEXT, INOUT p_insert_id INT(11))
  SQL SECURITY INVOKER
  COMMENT 'Procedure de Insert'
BEGIN

  DECLARE v_existe boolean;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    SET p_status = FALSE;
    SET p_msg = 'Erro ao executar o procedimento.';
  END;

  SET p_msg = '';
  SET p_status = FALSE;

  -- VALIDAÇÕES
  IF p_pro_var_nome IS NULL THEN
    SET p_msg = concat(p_msg, 'Nome não informado.<br />');
  END IF;
  IF p_pro_var_email IS NULL THEN
    SET p_msg = concat(p_msg, 'E-mail não informado.<br />');
  ELSE
    IF p_pro_var_telefone IS NULL THEN
      SET p_msg = concat(p_msg, 'Telefone não informado.<br />');
    END IF;
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    INSERT INTO proprietario (pro_var_nome, pro_var_email, pro_var_telefone) VALUES (p_pro_var_nome, p_pro_var_email, p_pro_var_telefone);

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'Um novo registro foi inserido com sucesso.';
    SET p_insert_id = LAST_INSERT_ID();

  END IF;

END
$$

--
-- Definition for procedure sp_animal_ins
--
DROP PROCEDURE IF EXISTS sp_animal_ins$$
CREATE PROCEDURE sp_animal_ins(IN p_ani_var_nome VARCHAR(50), IN p_ani_dec_peso DECIMAL(8,3), IN p_ani_var_raca VARCHAR(50), IN p_ani_cha_vivo CHAR(1), IN p_pro_int_codigo INT(11), INOUT p_status BOOLEAN, INOUT p_msg TEXT, INOUT p_insert_id INT(11))
  SQL SECURITY INVOKER
  COMMENT 'Procedure de Insert'
BEGIN

  DECLARE v_existe boolean;

  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_status = FALSE;
    SET p_msg = 'Erro ao executar o procedimento.';
  END;

  SET p_msg = '';
  SET p_status = FALSE;

  -- VALIDAÇÕES
  IF p_ani_var_nome IS NULL THEN
    SET p_msg = concat(p_msg, 'Nome não informado.<br />');
  END IF;
  IF p_ani_cha_vivo IS NULL THEN
    SET p_msg = concat(p_msg, 'Status não informado.<br />');
  ELSE
    IF p_ani_cha_vivo NOT IN ('S','N') THEN
      SET p_msg = concat(p_msg, 'Status inválido.<br />');
    END IF;
  END IF;
  IF p_pro_int_codigo IS NULL THEN
  	SET p_msg = concat(p_msg, 'Proprietário não informado.<br />');
  ELSE
  	
    SELECT IF( count(pro_int_codigo) = 0, FALSE, TRUE ) into v_existe FROM vw_proprietario WHERE pro_int_codigo = p_pro_int_codigo;

    IF NOT v_existe THEN
      SET p_msg = concat(p_msg, 'Proprietário inválido.<br />');              
    END IF;
    
  END IF;

  IF p_msg = '' THEN

    START TRANSACTION;

    INSERT INTO animal (ani_var_nome, ani_dec_peso, ani_var_raca, ani_cha_vivo, pro_int_codigo)
    VALUES (p_ani_var_nome, p_ani_dec_peso, p_ani_var_raca, p_ani_cha_vivo, p_pro_int_codigo);

    COMMIT;

    SET p_status = TRUE;
    SET p_msg = 'Um novo registro foi inserido com sucesso.';
    SET p_insert_id = LAST_INSERT_ID();

  END IF;

END
$$

DELIMITER ;




--
-- Definition for view vw_animal
--
DROP VIEW IF EXISTS vw_animal CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_animal
AS
  select `animal`.`ani_int_codigo` AS `ani_int_codigo`,`animal`.`ani_var_nome` AS `ani_var_nome`,`animal`.`ani_dec_peso` AS `ani_dec_peso`,`animal`.`ani_var_raca` AS `ani_var_raca`,`animal`.`ani_cha_vivo` AS `ani_cha_vivo`,(case `animal`.`ani_cha_vivo` when 'S' then 'Sim' when 'N' then 'Não' end) AS `ani_var_vivo`,`animal`.`ani_dti_inclusao` AS `ani_dti_inclusao`,date_format(`animal`.`ani_dti_inclusao`,'%d/%m/%Y %H:%i:%s') AS `ani_dtf_inclusao` , proprietario.pro_var_nome AS pro_var_nome from `animal` inner join proprietario ON animal.pro_int_codigo = proprietario.pro_int_codigo;
