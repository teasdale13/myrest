<?php

require 'vendor/autoload.php';
use Models\ModelFactory;
use Models\Validator;

$c = new \Slim\Container();

// instantiate the App object
$app = new \Slim\App($c);
$pdo = new PDO('mysql:host=127.0.0.1;dbname=blogpost', 'root', '');
// Add route callbacks


$app->get('/', function ($request, $response, $args){
    return $response->withStatus(200)->write('Ceci est un service Rest et ne devrait pas être accédé directement');
});

$app->get('/{model}', function ($request, $response, $args) use ($pdo) {
    if ( Validator::validate( $args['model'] ) ) {
        $my_class = ModelFactory::getModel( $args['model'], $pdo );
        $data = $my_class->getAll();
        return $data ? $response->withJson( $data ) : not_found( $response );

    } else {
        return denied($response);
    }
});

$app->get('/{model}/{id}', function ($request, $response, $args) use ($pdo) {
    if ( Validator::validate( $args['model'] ) ) {
        $my_class = ModelFactory::getModel( $args['model'], $pdo );
        $data = $my_class->getById($args['id']);
        return $data ? $response->withJson( $data ) : not_found( $response );
    } else {
        return denied($response);
    }
});

$app->post('/{model}', function ($request, $response, $args) use ($pdo) {
    if ( Validator::validate( $args['model'] ) ) {
        $my_class = ModelFactory::getModel( $args['model'], $pdo );
        if($request->getParsedBody()) {
            $new_obj = $my_class->insert( $request->getParams() );
            return $new_obj ? $new_obj : false;
        } else {
            return oops( $response , 'Impossible d\'insérer', 500);
        }
    } else {
        return denied( $response );
    }
});

$app->put('/{model}/{id}' , function ($request, $response, $args) use ($pdo) {
    if ( Validator::validate( $args['model'] ) ) {
        $my_class = ModelFactory::getModel( $args['model'], $pdo );
        if($request->getParsedBody()) {
            $update_obj = $my_class->update( $request->getParams(), $args['id'] );
            return $update_obj ? $update_obj : false;
        } else {
            return oops( $response , 'Impossible de mettre à jour', 406);
        }
    } else {
        return denied( $response );
    }
});

$app->delete('/{model}/{id}', function ( $request, $response, $args ) use ($pdo) {
    if ( Validator::validate( $args['model'] ) ) {
        $my_class = ModelFactory::getModel( $args['model'], $pdo );
        if ( $my_class->getById( $args['id'] ) ) {
            return $response->withJson( $my_class->delete( $args['id'] ) );
        }
    } else {
        return denied( $response );
    }
});

function oops( $response, $msg, $status ) {
    return $response->withStatus($status)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write( $msg );
}

function not_found( $response ) {
    return $response->withStatus(404)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write('Enregistrement introuvable');
}

function denied($response) {
    return $response->withStatus(400)
        ->withHeader('Content-Type', 'application/json;charset=utf-8')
        ->write('Access Denied');
}


$app->run();
