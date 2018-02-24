<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '_class/animalDao.php';


$mwFormatarVirgulaPonto = function (Request $request, $response, $next ){
    
    $body = $request->getParsedBody();
    
    if($request->getParsedBodyParam('ani_dec_peso', false) !== false){
        $body['ani_dec_peso'] = str_replace(',', '.', $body['ani_dec_peso']);
    }
    
    $requestNovo = $request->withParsedBody($body);

    return $next($requestNovo, $response);
};

$app->get('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
    $ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::selectByIdForm($animal);
    $code = count($data) > 0 ? 200 : 404;

	return $response->withJson($data, $code);
});


$app->post('/animais', function (Request $request, Response $response) {
    $body = $request->getParsedBody();

    $animal = new Animal();
    $animal->setAni_var_nome($body['ani_var_nome']);
 	$animal->setAni_cha_vivo($body['ani_cha_vivo']);
 	$animal->setAni_dec_peso($body['ani_dec_peso']);
 	$animal->setAni_var_raca($body['ani_var_raca']);
    $animal->setPro_int_codigo($body['pro_int_codigo']);
    
    $data = AnimalDao::insert($animal);
    $code = ($data['status']) ? 201 : 500;

	return $response->withJson($data, $code);
})->add($mwFormatarVirgulaPonto);


$app->put('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
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


$app->delete('/animais/{ani_int_codigo}', function (Request $request, Response $response) {
	$ani_int_codigo = $request->getAttribute('ani_int_codigo');
    
    $animal = new Animal();
    $animal->setAni_int_codigo($ani_int_codigo);

    $data = AnimalDao::delete($animal);
    $code = ($data['status']) ? 200 : 500;

	return $response->withJson($data, $code);
});