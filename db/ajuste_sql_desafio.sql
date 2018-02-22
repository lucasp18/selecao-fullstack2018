DROP TABLE IF EXISTS proprietario;
create table proprietario(pro_int_codigo int(11) not null auto_increment, pro_var_nome varchar(50) not null, pro_var_email varchar(50) not null, pro_var_telefone varchar(12) not null, primary key(pro_int_codigo) );


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

DELIMITER ;

--
-- Definition for view vw_proprietario
--
DROP VIEW IF EXISTS vw_proprietario CASCADE;
CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW vw_proprietario
AS
  select `proprietario`.`pro_int_codigo` AS `pro_int_codigo`,`proprietario`.`pro_var_nome` AS `pro_var_nome`,`proprietario`.`pro_var_email` AS `pro_var_email`,`proprietario`.`pro_var_telefone` AS `pro_var_telefone` from `proprietario`;

