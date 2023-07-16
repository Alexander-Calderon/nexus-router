<?php
namespace NexusRouter\Core;

use NexusRouter\Config;

class Router {

    
    private static $outputMode = Config::OUTPUT_MODE;
    private static $urlRouterPath = Config::SKIP_URL_PATH;

    private static $routes = [];


    public static function get(string $route, string|callable $payload, mixed $metadata = null) : Router {
            self::addRoute("GET", $route, $payload, $metadata);
            return new self;            
    }
    public static function post(string $route, string|callable $payload, mixed $metadata = null) : Router {
            self::addRoute("POST", $route, $payload, $metadata);
            return new self;
    }
    public static function put(string $route, string|callable $payload, mixed $metadata = null) : Router {
            self::addRoute("PUT", $route, $payload, $metadata);
            return new self;
    }
    public static function patch(string $route, string|callable $payload, mixed $metadata = null) : Router {
            self::addRoute("PATCH", $route, $payload, $metadata);
            return new self;
    }
    public static function delete(string $route, string|callable $payload, mixed $metadata = null) : Router {
            self::addRoute("DELETE", $route, $payload, $metadata);
            return new self;
    }

    public static function addRoute( string $httpMethod, string $route, string|callable $payload, mixed $metadata = null ){
        array_push( 
            self::$routes, 
            [
                'http_method' => $httpMethod,
                'route'     => $route,
                'payload'   => $payload,
                'metadata'  => $metadata
            ]
        );
    }

    public static function init(){

        foreach( self::$routes as $route ){
            if( $_SERVER["REQUEST_METHOD"] == $route['http_method'] ){
                Router::core( $route['route'], $route['payload'], $route['metadata'] );
            }
        }
        Router::endProcess(status:"notFound");

    }


    private static function core(string $route, string|callable $payload, mixed $metadata = null) : void {
                
        // Separar la uri de la queryString
        $uri = parse_url($_SERVER["REQUEST_URI"])["path"];

        //+Start Debuggin: formating & cleaning
        $uri = str_replace(self::$urlRouterPath, "", $uri);
        $uri = filter_var($uri, FILTER_SANITIZE_URL);

        // echo "block 404 temporary for testing purposes <br>";
        // var_dump( $route, $uri );

        // Eliminar separadores duplicados
        // $route = preg_replace('/\/+/', '/', $route);
        // $uri = preg_replace('/\/+/', '/', $uri);
        
        // Validar si la cantidad de secciones de la uri coincide con las de la ruta
        if ( substr_count($uri, '/') !== substr_count($route, '/') ){
            return;
        }        
        $route_sections = explode("/", substr_replace($route, '', 0, 1));
        $uri_sections = explode("/", substr_replace($uri, '', 0, 1));

        //+End Debuggin

        // var_dump( $route_sections );
        // echo "<br>";
        // var_dump( $uri_sections );        
        
        // section behavior controller
        $params = [];
        foreach ($route_sections as $mirror_key => $route_section) {
            
            // fixed empty uri section checker in route section
            // because double slash aren´t converted to only 1 anymore in this version
            // for uri precision purposes.
            if ( empty( trim( $uri_sections[$mirror_key] ) ) && 
                !empty( trim( $route_section )) )
            {
                return;
            }
            
            //revisar si la sección es una variable
            if ( preg_match('/^\$+[^$]*$/', $route_section) ){

                // if( )
                $var_name = ltrim($route_section, "$");        
                $$var_name = $uri_sections[$mirror_key];
                array_push($params, $$var_name);
                continue;
            }

            if ( $uri_sections[$mirror_key] !== $route_section ){
                return;
            }

        }

        //Execute callback
        if( is_callable($payload) ){
            try {
                call_user_func_array($payload, $params);
            } catch(\Throwable $th){
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
                    $xmlData = new \SimpleXMLElement('<root/>');
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
        require getBasePath() . '/' . $payload;
        self::endProcess();

        

    }

    //Se utiliza para finalizar un proceso, devuelve not found 404 si es necesario.
    public static function endProcess($status = "ok", $httpCode = 404) : never {
        if ( $status !== "ok") {
            http_response_code($httpCode);
        }  
        exit;
    }

    
}

