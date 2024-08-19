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
use proyecto\Controller\ChefsController;
use proyecto\Controller\MeserosController;
use proyecto\Models\User;
use proyecto\MOdels\EstadoReserva;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Usuarios;
use proyecto\Models\Roles;
use proyecto\Models\RolUsuario;
use proyecto\Models\Personas;
use proyecto\Models\Horarios;
use proyecto\Models\Comentarios;
use proyecto\Models\Clientes;
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
use proyecto\Controller\PlatillosController;
use proyecto\Controller\ComidaController;
use proyecto\Controller\BebidasController;
use proyecto\Controller\PostresController;
use proyecto\Controller\IngredientesController;
use proyecto\Controller\EstadoComidaController;
use proyecto\Controller\EstadoIngredientesController;
use proyecto\Controller\EstadoReservaController;
use proyecto\Controller\ReservaController;

// index.php o archivo de rutas
Router::post('/login', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario = $data['usuario'];
    $contrasena = $data['contrasena'];

    $response = User::auth($usuario, $contrasena);

    echo json_encode($response);
});

// Ruta para obtener las reservas
Router::get('/reservas', function() {
    $controller = new ReservaController();
    $reservas = $controller->obtenerReservas();
    echo json_encode($reservas);
});

// Ruta para cambiar el estado de la reserva
Router::post('/estadoreservas/cambiarEstado', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $reservaId = $data['reservaId'];

    $controller = new EstadoReservaController();
    $response = $controller->cambiarEstadoReserva($reservaId);

    echo json_encode($response);
});

// Ruta para obtener el estado de las reservas
Router::get('/estadoreservas', function() {
    $controller = new EstadoReservaController();
    $reservas = $controller->obtenerEstadoReservas();

    echo json_encode($reservas);
});

// Ruta para obtener ingredientes por platillo

// Ruta para obtener los ingredientes
Router::get('/ingredientes', function() {
    $controller = new EstadoIngredientesController();
    $ingredientes = $controller->obtenerIngredientes();
    echo json_encode($ingredientes);
});

// Ruta para cambiar el estado de un ingrediente
Router::post('/ingredientes/cambiarEstado', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $ingredienteId = $data['ingredienteId'];

    $controller = new EstadoIngredientesController();
    $response = $controller->cambiarEstadoIngrediente($ingredienteId);

    echo json_encode($response);
});

Router::post('/comidas/cambiarEstado', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $comidaId = $data['comidaId'];
    
    $controller = new EstadoComidaController();
    $response = $controller->cambiarEstadoComida($comidaId);
    
    echo json_encode($response);
});

Router::get('/comidas', function() {
    $controller = new EstadoComidaController();
    $comida = $controller->obtenerComida();
    
    echo json_encode($comida);
});

Router::get('/ingrediente', function() {
    $controller = new IngredientesController();
    $ingredientes = $controller->obtenerIngredientes();

    echo json_encode($ingredientes);
});

Router::get('/comida', function() {
    $controller = new ComidaController();
    $comida = $controller->getComida();
    echo json_encode($comida);
});

// Ruta para obtener las bebidas
Router::get('/bebidas', function() {
    $controller = new BebidasController();
    $bebidas = $controller->getBebidas();
    echo json_encode($bebidas);
});

// Ruta para obtener los postres
Router::get('/postres', function() {
    $controller = new PostresController();
    $postres = $controller->getPostres();
    echo json_encode($postres);
});


// Ruta para obtener los platillos
Router::get('/getPlatillos', function() {
    $controller = new PlatillosController();
    $platillos = $controller->getPlatillos();
    echo json_encode($platillos);
});

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

// Ruta para obtener la información de los chefs
Router::get('/chefs', function() {
    $controller = new ChefsController();
    $chefs = $controller->getChefsInfo();
    echo json_encode($chefs);
});

// Ruta para obtener la información de los meseros
Router::get('/meseros', function() {
    $controller = new MeserosController();
    $meseros = $controller->getMeserosInfo();
    echo json_encode($meseros);
});

// Ruta para eliminar un chef
Router::post('/deletechef', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new ChefsController();
    $message = $controller->deleteChef($data['usuarioID']); // Asegúrate de que usuarioID se está pasando correctamente
    echo json_encode(["message" => $message]);
});

// Ruta para eliminar un mesero
Router::post('/deletemesero', function() {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller = new MeserosController();
    $message = $controller->deleteMesero($data['usuarioID']); // Asegúrate de que usuarioID se está pasando correctamente
    echo json_encode(["message" => $message]);
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

Router::get('/404', '../views/404.php');


route::get ("/p", function(){
    echo "Hola";
});
