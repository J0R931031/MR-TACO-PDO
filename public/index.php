<?php

namespace proyecto;
require("../vendor/autoload.php");

// Configurar CORS al inicio del archivo de rutas
header("Access-Control-Allow-Origin: *"); // Permitir todos los orígenes
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Permitir métodos específicos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permitir ciertos encabezados

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // Terminar script para solicitudes pre-flight
}

use proyecto\Controller\crearPersonaController;
use proyecto\Controller\ClientesController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Usuarios;
use proyecto\Models\Roles;
use proyecto\Models\RolUsuario;
use proyecto\Models\Personas;
use proyecto\Models\Horarios;
use proyecto\Models\EstadoDeReservas;
use proyecto\Models\Comentarios;
use proyecto\Models\Chefs;
use proyecto\Models\Clientes;
use proyecto\Models\Meseros;
use proyecto\Models\Categorias;
use proyecto\Models\Comida;
use proyecto\Models\Ingredientes;
use proyecto\Models\DetalleComida;
use proyecto\Models\Mesas;
use proyecto\Models\DetalleReservaMesa;
use proyecto\Models\Ordenes;
use proyecto\Models\DetalleOrden;
use proyecto\Models\Pedidos;
use proyecto\Models\DetallePedido;
use proyecto\Controller\EmpleadosController;

// Otras rutas y configuraciones...

// Ruta para registrar un empleado
Router::post('/register', function() {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Crear instancia del controlador
    $controller = new EmpleadosController();

    // Llamar al método register con los datos
    $response = $controller->register($data);

    // Devolver la respuesta
    echo json_encode($response);
});

Router::post('/crearcliente', function() {
    // Obtener los datos del cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Crear instancia del controlador
    $controller = new ClientesController();

    // Llamar al método register con los datos
    $message = $controller->register($data);

    // Devolver la respuesta
    echo json_encode(["message" => $message]);
});

Router::get('/chefs', function() {
    $controller = new ChefsController();
    $chefs = $controller->getChefsInfo();
    echo json_encode($chefs);
});

Router::get('/meseros', function() {
    $controller = new MeserosController();
    $meseros = $controller->getMeserosInfo();
    echo json_encode($meseros);
});

Router::get('/verificarcorreo', function() {
    $correo = $_GET['correo'];
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM USUARIOS WHERE Correo = ?");
    $stmt->execute([$correo]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
});


Router::get('/prueba',[crearPersonaController::class,"prueba"]);
Router::get('/usuarios',[Usuarios::class,"mostrarUsuarios"]);
Router::get('/roles',[Roles::class,"mostrarRoles"]);
Router::get('/rolusuario',[RolUsuario::class,"mostrarRolUsuario"]);
Router::get('/personas',[Personas::class,"mostrarPersonas"]);
Router::get('/horarios',[Horarios::class,"mostrarHorarios"]);
Router::get('/estadodereservas',[EstadoDeReservas::class,"mostrarEstadoDeReservas"]);
Router::get('/comentarios',[Comentarios::class,"mostrarComentarios"]);
Router::get('/chefs',[Chefs::class,"mostrarChefs"]);
Router::get('/clientes',[Clientes::class,"mostrarClientes"]);
Router::get('/categorias',[Categorias::class,"mostrarCategorias"]);
Router::get('/comida',[Comida::class,"mostrarComida"]);
Router::get('/ingredientes',[Ingredientes::class,"mostrarIngredientes"]);
Router::get('/detallecomida',[DetalleComida::class,"mostrarDetalleComida"]);
Router::get('/mesas',[Mesas::class,"mostrarMesas"]);
Router::get('/detallereservamesa',[DetalleReservaMesa::class,"mostrarDetalleReservaMesa"]);
Router::get('/ordenes',[Ordenes::class,"mostrarOrdenes"]);
Router::get('/detalleorden',[DetalleOrden::class,"mostrarDetalleOrden"]);
Router::get('/pedidos',[Pedidos::class,"mostrarPedidos"]);
Router::get('/detallepedido',[DetallePedido::class,"mostrarDetallePedido"]);

Router::get('/usuario/buscar/$id', function ($id) {
    $user = User::find($id);
    if(!$user) {
        $r = new Failure(404, "no se encontro el usuario");
        return $r->Send();
    }
    $r = new Success($user);
    return $r->Send();
});

Router::any('/404', '../views/404.php');

route::get ("/p", function(){
    echo "Hola";
});
