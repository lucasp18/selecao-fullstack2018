<?php
$form = new GForm();
$mysql = new GDbMysql();
$filter = new GFilter();
$filterUsuario = new GFilter();
$filterVacina = new GFilter();

//<editor-fold desc="Header">
$title = '<span class="acaoTitulo"></span>';
$tools = '<a id="f__btn_voltar"><i class="fa fa-arrow-left font-blue-steel"></i> <span class="hidden-phone font-blue-steel bold uppercase">Voltar</span></a>';
$htmlForm .= getWidgetHeader($title, $tools);
//</editor-fold>
//<editor-fold desc="Formulário">

try {

    $filter->setOrder(array('pro_var_nome' => 'ASC'));
    $mysql->execute("SELECT ani_int_codigo, ani_var_nome FROM vw_animal ", $filter->getParam() );

    
    $htmlForm .= $form->open('form', 'form-vertical form');
    $htmlForm .= $form->addInput('hidden', 'acao', false, array('value' => 'ins', 'class' => 'acao'), false, false, false);
    $htmlForm .= $form->addInput('hidden', 'anv_int_codigo', false, array('value' => ''), false, false, false);


    while ($mysql->fetch()) {
        $animais[$mysql->res['ani_int_codigo']] = $mysql->res['ani_var_nome'];
    }


    $htmlForm .= $form->addSelect('ani_int_codigo', $animais, '', 'Animal*', array('validate' => 'required'), false, false, true, '', 'Selecione...');
    
    $filterUsuario->setOrder(array('usu_var_nome' => 'ASC'));
    $mysql->execute("SELECT usu_int_codigo, usu_var_nome FROM vw_usuario ", $filterUsuario->getParam() );
    while ($mysql->fetch()) {
        $usuarios[$mysql->res['usu_int_codigo']] = $mysql->res['usu_var_nome'];
    }

    $htmlForm .= $form->addSelect('usu_int_codigo', $usuarios, '', 'Usuário*', array('validate' => 'required'), false, false, true, '', 'Selecione...');


    $filterVacina->setOrder(array('usu_var_nome' => 'ASC'));
    $mysql->execute("SELECT vac_int_codigo, vac_var_nome FROM vw_vacina ", $filterVacina->getParam() );
    while ($mysql->fetch()) {
        $vacinas[$mysql->res['vac_int_codigo']] = $mysql->res['vac_var_nome'];
    }

    $htmlForm .= $form->addSelect('vac_int_codigo', $vacinas, '', 'Vacina*', array('validate' => 'required'), false, false, true, '', 'Selecione...');

        
    $htmlForm .= '<div class="form-actions">';
    $htmlForm .= $form->addButton('p__btn_aplicar_vacina', '<i class="fa fa-plus"></i> <span class="hidden-phone">Aplicar Vacina</span>', array('class' => 'btn sepH_a sepV_a blue-steel pull-left'), 'submit');
    $htmlForm .= '</div>';
    $htmlForm .= $form->close();
    //</editor-fold>
    $htmlForm .= getWidgetFooter();

    echo $htmlForm;        
    

} catch (GDbException $exc) {
    echo $exc->getError();
}

?>
<script>
    $(function() {
        $('#ani_dec_peso').maskMoney({thousands:'.', decimal:',', precision:3,  affixesStay: false});        
        $('#form').submit(function() {            
            var ani_int_codigo = $('#ani_int_codigo').val();
            $('#p__selecionado').val();
            if ($('#form').gValidate()) {
                var method = ($('#acao').val() == 'ins') ? 'POST' : 'PUT';
                var endpoint = ($('#acao').val() == 'ins') ? URL_API + 'index.php/'+ 'aplicacoes' : URL_API + 'index.php/'+'aplicacoes/' + ani_int_codigo;
                $.gAjax.exec(method, endpoint, $('#form').serializeArray(), false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            }
            return false;
        });

        $('#f__btn_cancelar, #f__btn_voltar').click(function() {
            showList();
            return false;
        });

        $('#f__btn_excluir').click(function() {
            var ani_int_codigo = $('#ani_int_codigo').val();

            $.gDisplay.showYN("Quer realmente deletar o item selecionado?", function() {
                $.gAjax.exec('DELETE', URL_API + 'usuarios/' + ani_int_codigo, false, false, function(json) {
                    if (json.status) {
                        showList(true);
                    }
                });
            });
        });
    });
</script>