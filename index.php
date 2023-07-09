<?php

require __DIR__ . "/config.php";

use nexusRouter\Config;
// use Api\Models\User as UserModel;


class Route {    

    
    private static $outputMode = Config::OUTPUT_MODE;
    private static $urlRouterPath = Config::URL_ROUTER_PATH;


    public static function get(string $route, string|callable $payload, mixed $metadata = null) : void {
        if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
            self::router($route, $payload, $metadata); 
        }
    }
    public static function post(string $route, string|callable $payload, mixed $metadata = null) : void {
        if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
            self::router($route, $payload, $metadata); 
        }
    }
    public static function put(string $route, string|callable $payload, mixed $metadata = null) : void {
        if( $_SERVER['REQUEST_METHOD'] === 'PUT' ){
            self::router($route, $payload, $metadata); 
        }
    }
    public static function patch(string $route, string|callable $payload, mixed $metadata = null) : void {
        if( $_SERVER['REQUEST_METHOD'] === 'PATCH' ){
            self::router($route, $payload, $metadata); 
        }
    }
    public static function delete(string $route, string|callable $payload, mixed $metadata = null) : void {
        if( $_SERVER['REQUEST_METHOD'] === 'DELETE' ){
            self::router($route, $payload, $metadata); 
        }
    }


    private static function router(string $route, string|callable $payload, mixed $metadata = null) : void {
        
        
        // Separar la uri de la queryString
        $uri = parse_url($_SERVER["REQUEST_URI"])["path"];

        //+Start Debuggin: formating & cleaning
        $uri = str_replace(self::$urlRouterPath, "", $uri);
        $uri = filter_var($uri, FILTER_SANITIZE_URL);

        //validar ruta
        if ( $uri !== $route ){
            return;
        }
        
        //Eliminar separadores duplicados
        $route = preg_replace('/\/+/', '/', $route);
        $uri = preg_replace('/\/+/', '/', $uri);

        $route_sections = explode("/", $route);
        $uri_sections = explode("/", $uri);

        //+End Debuggin

        //validar si la cantidad de secciones de la uri coincide con las de la ruta
        // if ( count($uri_sections) !== count($route_sections) ){
        //     return;
        // }


        // section behavior controller
        $params = [];
        foreach ($route_sections as $mirror_key => $route_section) {
            //revisar si la sección es una variable
            if ( preg_match('/^\$+[^$]*$/', $route_section) ){
                $var_name = ltrim($route_section, "$");        
                $$var_name = $uri_sections[$mirror_key];
                array_push($params, $$var_name);
            } elseif ( $uri_sections[$mirror_key] !== $route_section ){
                return;
            }    
        }

        //Execute callback
        if( is_callable($payload) ){
            try {
                call_user_func_array($payload, $params);
            } catch(Throwable $th){
                if (empty(self::$outputMode) || self::$outputMode === 'WEB') {
                    echo "Error de ejecución Callback <br>";
                    echo "Mensaje: " . $th->getMessage() . "<br>";
                    echo "Archivo: " . $th->getFile() . "<br>";
                    echo "Línea: " . $th->getLine() . "<br>";
                } elseif (self::$outputMode === 'JSON') {
                    $errorData = [
                        'error' => [
                            'message' => $th->getMessage(),
                            'file' => $th->getFile(),
                            'line' => $th->getLine()
                        ]
                    ];
                    $jsonData = json_encode($errorData, JSON_PRETTY_PRINT);
                    header('Content-Type: application/json');
                    echo $jsonData;
                } elseif (self::$outputMode === 'XML') {
                    $errorData = [
                        'error' => [
                            'message' => $th->getMessage(),
                            'file' => $th->getFile(),
                            'line' => $th->getLine()
                        ]
                    ];
                    $xmlData = new SimpleXMLElement('<root/>');
                    array_walk_recursive($errorData, function($value, $key) use ($xmlData) {
                        $xmlData->addChild($key, $value);
                    });
                    header('Content-Type: application/xml');
                    echo $xmlData->asXML();
                }
            }
            self::endProcess();
        }
        
        if( !strpos($payload, '.php') ){ $payload .= '.php'; }
        require $payload;
        self::endProcess();

        

    }

    //Se utiliza para finalizar un proceso, devuelve not found 404 si es necesario.
    public static function endProcess($status = "ok", $httpCode = 404){
        if ( $status !== "ok") {
            http_response_code($httpCode);
        }  
        exit;
    }

    
}



Route::get('/users/list' , 'Controllers/User', "getUsers");

Route::get('/users/lisst' , 'Controllers/User', "getUsers");


// Route::get('/userdddd', function($tempi = "test"){
//     echo 'Callbackasdasd executed ' . $tempi;
// });

// Route::get('/users', function($tempi = "test"){
//     echo 'Callback executed ' . $tempi;
// });

// Route::router('/users', './usuarios/lista.php');

Route::endProcess(status:"notFound");

