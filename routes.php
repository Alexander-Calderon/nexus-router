<?php
namespace NexusRouter;

use NexusRouter\Router;

# PATH EXAMPLES #
// Simple route
Router::get('/users' , 'Controllers/User');

// Route with value
Router::get('/users/$list', 'Controllers/User');

// Route with value and injected metadata value
Router::get('/users/$list', 'Controllers/User', "getUsers");

# Alternative syntax
Router::get('/users' , 'Controllers/User')
      ->get('/users/$list', 'Controllers/User')
      ->get('/users/$list', 'Controllers/User', "getUsers");


# CALLBACK EXAMPLES #

// Simple callback: : http://localhost/welcome
Router::get('/welcome', function(){
    echo 'I love Nexus Router!';
});

// Singleparam Example: http://localhost/welcome/alexander
Router::get('/welcome/$name', function($param1){
    echo $param1 . ' loves Nexus Router!';
});


// Multiparams Example: http://localhost/welcome/alexander/calderon
Router::get('/welcome/$name/$lastname', function($param1,$param2){
    echo $param1 . ' ' . $param2 . ' loves Nexus Router!';
});





// Router::get('/users', 'Controllers/User')
//       ->get('/users/$list' , 'Controllers/User', "getUsers")
// ;



/*
Test:
+ ya no valida //users/s ni /users/s/ ó //users
lo cuál solicita precisión a la solicitud y evitar bypass.

+ se valida que si es / no entra ya que debe exigir un valor.
por lo que /$var será diferente de solo /

blocked unauthorized bypass:
//list/section
/users/list/
/users/list/section/

// fixed empty uri section checker in route section
// because double slash aren´t converted to only 1 anymore in this version
// for uri precision purposes.
*/

