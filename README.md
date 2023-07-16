<p align="center">
  <img src="https://i.ibb.co/CB4r50G/nexusrouter1-short.png" alt="NexusRouter Icon">
</p>


# NexusRouter

NexusRouter es un enrutador de PHP diseñado para simplificar la creación y gestión de rutas en tu proyecto. Con NexusRouter, puedes definir fácilmente las rutas y controladores que deseas utilizar en tu aplicación web.

## Resumen

NexusRouter es una herramienta poderosa que ofrece numerosas ventajas para la implementación de rutas en tus proyectos en entornos de producción y pruebas. Algunas de las ventajas clave de NexusRouter incluyen:

- **Fácil implementación**: NexusRouter se integra de manera sencilla en tus proyectos existentes. Solo necesitas agregar la carpeta `nexusRouter` en tu proyecto y realizar una simple importación del archivo `NexusLoader.php` en el archivo `index.php` de la raíz del proyecto.

- **Flexibilidad en el manejo de rutas**: Puedes utilizar rutas a controladores o callbacks, lo que te brinda la libertad de elegir cómo manejar las solicitudes entrantes. Puedes definir rutas que se redirijan a controladores específicos o utilizar callbacks personalizados para ejecutar código en respuesta a una ruta determinada.

- **Precisión en las rutas**: NexusRouter te permite definir rutas exactas, validando cada segmento de ruta y segmentos que se comportarán como valores. Esto te da un mayor control sobre cómo se manejan las solicitudes y cómo se accede a los parámetros de la ruta en el controlador o archivo importado, evitando comportamientos indeseados.

- **Metadata para rutas**: NexusRouter te permite pasar una variable `$metadata` con cada ruta, que puede ser de cualquier tipo (mixed). Esta variable de metadata proporciona información adicional sobre la ruta y puede ser accedida desde el controlador o archivo importado asociado.

## Instalación

Para comenzar a usar NexusRouter en tu proyecto, sigue los siguientes pasos:

1. Descarga la carpeta `nexusRouter` y colócala en cualquier ubicación dentro de tu proyecto.

2. Asegúrate de que el archivo `NexusLoader.php` esté importado en el archivo `index.php` de la raíz de tu proyecto. Esto permitirá que NexusRouter se cargue correctamente cuando se acceda a tu aplicación.

3. Incluye el archivo `.htaccess` en la raíz de tu proyecto. Este archivo es necesario para que NexusRouter funcione correctamente con el servidor Apache.

4. Dentro de la carpeta `nexusRouter`, encontrarás un archivo llamado `routes.php`. En este archivo, puedes definir todas las rutas que deseas controlar utilizando NexusRouter.

## Ejemplos de Rutas

Aquí hay algunos ejemplos de cómo definir rutas utilizando NexusRouter en el archivo `routes.php`:

```php
// Ruta simple
Router::get('/users' , 'Controllers/User');

// Ruta con parámetro
Router::get('/users/$list', 'Controllers/User');

// Ruta con parámetro y valor inyectado
Router::get('/users/$list', 'Controllers/User', "getUsers");
```

Puedes agregar tantas rutas como necesites, especificando el método HTTP correspondiente (por ejemplo, `get`, `post`, `put`, `delete`) y el controlador al que se debe redirigir la ruta.

## Ejemplos de Callbacks

Además de utilizar controladores, NexusRouter también te permite utilizar callbacks para manejar las rutas. Aquí tienes algunos ejemplos de cómo utilizar callbacks en NexusRouter:

```php
// Callback simple: http://localhost/welcome
Router::get('/welcome', function(){
    echo '¡Amo NexusRouter!';
});

// Ejemplo con un parámetro: http://localhost/welcome/alexander
Router::get('/welcome/$name', function($param1){
    echo $param1 . ' ama NexusRouter!';
});

// Ejemplo con múltiples parámetros: http://localhost/welcome/alexander/calderon
Router::get('/welcome/$name/$lastname', function($param1,$param2){
    echo $param1 . ' ' . $param2 . ' ama NexusRouter!';
});
```

Puedes definir callbacks directamente en las rutas, lo que te permite ejecutar código personalizado para manejar la respuesta de la ruta.

## Configuración

Si deseas personalizar la configuración de NexusRouter, puedes hacerlo modificando el archivo `config.php` ubicado en la carpeta `nexusRouter`. En este archivo, puedes realizar los siguientes ajustes:

- `OUTPUT_MODE`: Define el formato de salida deseado para las respuestas. Puedes elegir entre "WEB", "JSON" o "XML".

- `SKIP_URL_PATH`: Si estás realizando pruebas y deseas omitir una parte específica de la URL, puedes configurar esta opción para eliminarla. Por ejemplo, si deseas omitir `/pruebas` de la URL `localhost/pruebas/users/1`, establece `/pruebas` en `'SKIP_URL_PATH'` , esto es útil para que al lanzar a producción, en tus rutas no tengas subcarpetas adicionales como el ejemplo `'/pruebas'`.

## Atribución

Por favor, asegúrate de mantener la atribución al autor original, Alexander Calderón, al utilizar NexusRouter en tu proyecto. Incluye una referencia al autor original y proporciona un enlace o crédito adecuado en tu documentación, página de créditos o cualquier otro lugar apropiado.

## Licencia

NexusRouter se distribuye bajo la Licencia MIT. Consulta el archivo `LICENSE` para obtener más información sobre los términos de la licencia.

---

¡Disfruta utilizando NexusRouter para simplificar el enrutamiento en tu proyecto! Si tienes alguna pregunta o problema, no dudes en comunicarte con el autor original o buscar ayuda en la documentación y recursos disponibles.
