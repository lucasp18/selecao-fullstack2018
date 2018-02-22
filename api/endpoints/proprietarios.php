<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/proprietarioDao.php';

/*$app->get('/proprietarios/{ani_int_codigo}', function (Request $request, Response $response) {
    $ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::selectByIdForm($animal);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});*/

/*$app->get('/proprietarios', function (Request $request, Response $response) {
    return $response->withJson('teste2 ok', 200);
});*/


$app->post('/proprietarios', function (Request $request, Response $response) {
    //die('aqui');
    //return $response->withJson('teste2', 200);
    $body = $request->getParsedBody();

    $proprietario = new Proprietario();
    $proprietario->setPro_var_nome($body['pro_var_nome']);
 	$proprietario->setPro_var_email($body['pro_var_email']);
 	$proprietario->setPro_var_telefone($body['pro_var_telefone']); 	
    //return $response->withJson('teste', 200);
    $data = ProprietarioDao::insert($proprietario);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
});


/*$app->put('/proprietarios/{ani_int_codigo}', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();

    $animal->setAni_int_codigo($ani_int_codigo);
    $animal->setAni_var_nome($body['ani_var_nome']);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso($body['ani_dec_peso']);
 	$animal->setAni_var_raca($body['ani_var_raca']);

    $data = AnimalDao::update($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});


$app->delete('/proprietarios/{ani_int_codigo}', function (Request $request, Response $response) {
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::delete($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});*/