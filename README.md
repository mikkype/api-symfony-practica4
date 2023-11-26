﻿# api-symfony-practica4
#Creación de contenedores
Una vez creado nuestros 3 contenedores PHP,NGINX,MYSQL,procedemos a crear un nuevo proyecto dentro del contenedor php que se ha generado:
#Creación de un nuevo proyecto
creamos el nuevo proyecto 

$ composer create-project symfony/skeleton .

#Creación de los componentes de la Api 
introducimos una serie de comandos para crear los componentes de nuestra Api

$ composer require annotations
$ composer require logger
$ composer require symfony/orm-pack –with-all-dependecies
$ composer require jms/serializer-bundle
$ composer require friendsofsymfony/rest-bundle –dev


#Conexión a la base de datos

Dentro de la carpeta symfony buscamos .env
rellenamos los parámetros verdes con los datos de nuestra base de datos:
DATABASE_URL="mysql://root:mike@mysql:3306/instituto?serverVersion=8.2"
#Permisos root para todos los archivos creados para trabajarlo en Visual Studio

Ver los archivos root : $ ls -la
Digitamos el comando : $ chmod -R 777 * (para todos)
Digitamos el comando : $ chmod -R 777 .env .gitignore

#Creación de las tablas y campos

Procedemos a la creación de los nombres de las tablas y ficheros.
$ bin/console make:entity estudiante
$ bin/console make:entity profesor

Una vez creado procedemos a generar las migraciones de las tablas y ficheros

$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate

#Generar el controlador

Ahora vamos a generar los controladores para nuestra API
$ php bin/console make:controller EstudianteController
$ php bin/console make:controller ProfesorController

#MÉTODOS HTTP 
 Ahora en cada controller generado vamos a crear los métodos http para usarlos en el Postman:

CRUD

CREATE  = ‘POST’
READ      = ‘GET’
UPDATE = ‘PUT’
DELETE = ‘DELETE’



#CREAR CONSTRUCTOR
Dentro de nuestro API creamos nuestro constructor como una representación de buenas practicas de codigo limpio:

#MÉTODO GET ALL
Utilizamos la función findAll() de la clase Estudiante y Profesor 
con un forEach recorremos el array para mostrarlo todo el contenido de las tablas en formato Json.

#MÉTODO GET ID

Utilizamos la función find($id) de la clase Estudiante y Profesor 
Estamos obteniendo un objeto como respuesta, necesitamos separarlo en variables.

#MÉTODO POST ID

Para insertar un nuevo estudiante y Profesor utilizamos la clase $registry del constructor ,Del $request obtendremos nuestros datos y la función json_decode los convierte en array para que podamos añadirlos a nuestras variables correspondientes.

#METODO PUT ID

Para actualizar los datos de estudiantes y profesores pasando un ID haremos una petición con los datos que queremos modificar. Antes de pasar las variables tenemos que comprobar si el ID se encuentra dentro de la base de datos.

#MÉTODO DELETE ID

Para borrar un registro de estudiante o profesor pasando un ID 


