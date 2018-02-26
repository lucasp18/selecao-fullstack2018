<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/aplicacaoVacinaDao.php';



$app->post('/aplicacoes', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $aplicacaoVacina = new AplicacaoVacina();
    $aplicacaoVacina->setAni_int_codigo($body['ani_int_codigo']);
 	$aplicacaoVacina->setVac_int_codigo($body['vac_int_codigo']);
 	$aplicacaoVacina->setUsu_int_codigo($body['usu_int_codigo']);
   //var_dump($aplicacaoVacina);
    //die('teste');
    $data = AplicacaoVacinaDao::insert($aplicacaoVacina);
    //$data = "";
    //$code = '10';
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});

