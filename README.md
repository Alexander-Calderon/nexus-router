<div align="center">
  <img src="https://i.ibb.co/yR8F4FC/nexusrouter3-short.png" alt="NexusRouter Icon"/>
</div>


# NexusRouter

NexusRouter es un enrutador de PHP diseñado para simplificar la creación y gestión de rutas en tu proyecto. Con NexusRouter, puedes definir fácilmente las rutas y controladores que deseas utilizar en tu aplicación web.

## Resumen

NexusRouter es una herramienta poderosa que ofrece numerosas ventajas para la implementación de rutas en tus proyectos en entornos de producción y pruebas. Algunas de las ventajas clave de NexusRouter incluyen:

- **Fácil implementación**: NexusRouter se integra de manera sencilla en tus proyectos existentes. Solo necesitas agregar la carpeta `nexusRouter` en tu proyecto y realizar una simple importación del archivo `NexusLoader.php` en el archivo `index.php` de la raíz del proyecto.

- **Flexibilidad en el manejo de rutas**: Puedes utilizar rutas a controladores o callbacks, lo que te brinda la libertad de elegir cómo manejar las solicitudes entrantes. Puedes definir rutas que se redirijan a controladores específicos o utilizar callbacks personalizados para ejecutar código en respuesta a una ruta determinada.

- **Precisión en las rutas**: NexusRouter te permite definir rutas exactas, validando cada segmento de ruta y segmentos que se comportarán como valores. Esto te da un mayor control sobre cómo se manejan las solicitudes y cómo se accede a los parámetros de la ruta en el controlador o archivo importado, evitando comportamientos indeseados.

- **Metadata para rutas**: NexusRouter te permite pasar una variable `$metadata` con cada ruta, que puede ser de cualquier tipo (mixed). Esta variable de metadata proporciona información adicional sobre la ruta y puede ser accedida desde el controlador o archivo importado asociado.

## Instalación

### Instalación Básica

Para comenzar a usar NexusRouter en tu proyecto de forma básica, sigue los siguientes pasos:

1. Descarga la carpeta `nexusRouter` y colócala en cualquier ubicación dentro de tu proyecto.

2. Asegúrate de que el archivo `NexusLoader.php` esté importado en el archivo `index.php` de la raíz de tu proyecto. Esto permitirá que NexusRouter se cargue correctamente cuando se acceda a tu aplicación.

3. Incluye el archivo `.htaccess` en la raíz de tu proyecto. Este archivo es necesario para que NexusRouter funcione correctamente con el servidor Apache.

4. Dentro de la carpeta `nexusRouter`, encontrarás un archivo llamado `routes.php`. En este archivo, puedes definir todas las rutas que deseas controlar utilizando NexusRouter.

### Instalación usando Composer

Si prefieres utilizar Composer para administrar las dependencias de tu proyecto, puedes instalar NexusRouter de la siguiente manera:

1. En la terminal, navega hasta el directorio raíz de tu proyecto.

2. Si aún no tienes un archivo `composer.json` en tu proyecto, ejecuta el siguiente comando para crearlo:

   ```bash
   composer init
   ```

   Este comando te guiará a través de la creación del archivo `composer.json` con información básica sobre tu proyecto.

   > **Nota**: Si ya tienes un archivo `composer.json`, puedes omitir este paso.

3. Una vez que tengas el archivo `composer.json`, ejecuta el siguiente comando para agregar NexusRouter como una dependencia en tu proyecto:

   ```bash
   composer require foca/nexus-router
   ```

   Esto descargará e instalará NexusRouter y sus dependencias en la carpeta `vendor` de tu proyecto, y actualizará automáticamente el archivo `composer.json` con la nueva dependencia.

4. Incluye el archivo `autoload.php` generado por Composer en tu archivo `index.php` de la siguiente manera:

   ```php
   require 'vendor/autoload.php';
   ```
   Este cargará automáticamente el `NexusRouter` por lo que ya no es necesario importar el archivo `NexusLoader.php`.

5. Asegúrate de que el archivo `.htaccess` esté presente en la raíz de tu proyecto.

6. Dentro de la carpeta `vendor/foca/nexus-router`, encontrarás un archivo llamado `routes.php`. En este archivo, puedes definir todas las rutas que deseas controlar utilizando NexusRouter.

> **Nota**: Los archivos de ejemplo `index.php` y `.htaccess` se pueden encontrar en la carpeta del paquete instalado, en este caso `vendor/foca/nexus-router`.

## Configuración Flexible de Rutas

Antes de utilizar NexusRouter en tu proyecto, puedes configurar si deseas cargar o no las rutas desde el archivo `routes.php`. Esta configuración se realiza en el archivo `config.php` ubicado en la carpeta `nexusRouter`.

Para controlar la carga de rutas desde el archivo `routes.php`, sigue estos pasos:

1. Abre el archivo `config.php` ubicado en la carpeta `nexusRouter`.

2. Busca la constante llamada `ENABLE_ROUTES_FILE` y configúrala según tus necesidades:

   ```php
   public const ENABLE_ROUTES_FILE = true; // Cargar rutas desde routes.php
   // public const ENABLE_ROUTES_FILE = false; // No cargar rutas desde routes.php
   ```

   - Si estableces `ENABLE_ROUTES_FILE` como `true`, NexusRouter

 cargará las rutas definidas en el archivo `routes.php`.
   - Si estableces `ENABLE_ROUTES_FILE` como `false`, NexusRouter no cargará las rutas desde el archivo `routes.php`.

Recuerda que también puedes definir rutas directamente en el archivo `index.php` antes de la instanciación de `NexusLoader` si `ENABLE_ROUTES_FILE` está configurado como `false`. Esto te brinda flexibilidad para agregar rutas adicionales o condiciones personalizadas en tu archivo `index.php`.


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

Sintaxis alternativa `Fluent Design`
```php
Router::get('/users' , 'Controllers/User')
      ->get('/users/$list', 'Controllers/User')
      ->get('/users/$list', 'Controllers/User', "getUsers");
```


Puedes agregar tantas rutas como necesites, especificando el método HTTP correspondiente (por ejemplo, `get`, `post`, `put`, `delete`) y el controlador al que se debe redirigir la ruta.

## Ejemplos de Callbacks

Además de utilizar controladores, NexusRouter también te permite utilizar callbacks para manejar las rutas. Aquí tienes algunos ejemplos de cómo utilizar callbacks en NexusRouter:

```php
// Callback simple: http://localhost/welcome
Router::get('/welcome', function(){
    echo 'I love Nexus Router!';
});

// Ejemplo con un parámetro: http://localhost/welcome/alexander
Router::get('/welcome/$name', function($param1){
    echo $param1 . ' loves Nexus Router!';
});

// Ejemplo con múltiples parámetros: http://localhost/welcome/alexander/calderon
Router::get('/welcome/$name/$lastname', function($param1,$param2){
    echo $param1 . ' ' . $param2 . ' loves Nexus Router!';
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
