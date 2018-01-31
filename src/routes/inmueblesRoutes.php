<?php


$app->get('/inmuebles', function ($request, $response, $args) {

    $respuesta;

    try {

        $inmuebles = \Inmueble::all('id','tipo','grupo_id','direccion','latitud','longitud')->groupBy('grupo_id');

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

        $respuesta['estado'] = 'error';
        $respuesta['mensaje'] = $e;

    }

    return $response->withStatus(201)
                    ->withHeader("Content-Type", "application/json; charset=UTF-8")
                    ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  
});

$app->get('/inmuebles/{id}', function ($request, $response, $args) {

    $id = $args['id'];
    $respuesta;

    try {

        $inmueble = \Inmueble::find($id);

        $respuesta['estado'] = 'OK';
        $respuesta['inmueble'] = $inmueble;

    } catch (Exception $e) {

        $respuesta['estado'] = 'error';
        $respuesta['mensaje'] = $e;

    }

    return $response->withStatus(201)
                    ->withHeader("Content-Type", "application/json; charset=UTF-8")
                    ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
  
});

$app->get('/direccion/{direccion}', function ($request, $response, $args) {

    $direccion = $args['direccion'];
    $respuesta;

    try {

        $inmuebles = \Inmueble::where('direccion', $direccion)->get();

        if(isset($inmuebles[0])) { 
            
            $respuesta['estado'] = 'false';
            $respuesta['mensaje'] = 'Direccion en uso';
            $respuesta['inmuebles'] = $inmuebles;

        } else {

            $googleMaspURL = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($direccion) . '+Casilda+Santa+Fe,+Argentina&key=AIzaSyCi6ZChVN5gNH-2dv6KXGgoQ1KESMHRU88';
            $googleMaspJSON = file_get_contents($googleMaspURL);
            $googleMaspArray = json_decode($googleMaspJSON, true);

            if($googleMaspArray["results"][0]["types"][0] == "street_address") {

                $resultado['direccion'] = explode(",", $googleMaspArray["results"][0]["formatted_address"])[0];
                $resultado['latitud'] = $googleMaspArray["results"][0]["geometry"]["location"]["lat"];
                $resultado['longitud'] = $googleMaspArray["results"][0]["geometry"]["location"]["lng"];

                $respuesta['estado'] = 'OK';
                $respuesta['resultado'] = $resultado;

            } else {

                $respuesta['estado'] = 'false';
                $respuesta['mensaje'] = 'Direccion no valida';

            }

        }        

    } catch (Exception $e) {

        $respuesta['estado'] = 'error';
        $respuesta['mensaje'] = $e;

    }

    return $response->withStatus(201)
                    ->withHeader("Content-Type", "application/json; charset=UTF-8")
                    ->write(json_encode($respuesta, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

});