<?php


$app->get('/getAll', function ($request, $response, $args) {

    $respuesta;

    try {

        $inmuebles = \Inmueble::all()->groupBy('grupo_id');

        $respuesta['estado'] = 'OK';
        $respuesta['inmuebles'] = [];

        foreach($inmuebles as $grps) {

            if($grps[0]['grupo_id'] != null) {
                
                $grupo = \Grupo::find($grps[0]['grupo_id']);

                $grupo['extructura'] = 'grupo';

                $grupo['inmuebles'] = $grps;

                array_push($respuesta['inmuebles'], $grupo);

            } else {

                foreach($grps as $inmueble) {

                    $inmueble['extructura'] = 'inmueble';

                    array_push($respuesta['inmuebles'], $inmueble);

                }

            }

        }

    } catch (Exception $e) {

    }

    return $response->withStatus(201)
                    ->withHeader("Content-Type", "application/json; charset=UTF-8")
                    ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  
});