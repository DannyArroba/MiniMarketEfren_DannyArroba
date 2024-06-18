<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="./css/tailwind.css">
    
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Registrar Producto</h1>
    <form id="formulario" action="" method="POST" class="w-full">
        <div class="mb-5">
            <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <span id="error-nombre" class="text-red-500 text-sm"></span>
        </div>
        <div class="mb-5">
            <label for="precio" class="block text-gray-700 font-semibold mb-2">Precio por Unidad:</label>
            <input type="number" id="precio" name="precio" step="0.01" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <span id="error-precio" class="text-red-500 text-sm"></span>
        </div>
        <div class="mb-5">
            <label for="cantidad" class="block text-gray-700 font-semibold mb-2">Cantidad en Inventario:</label>
            <input type="number" id="cantidad" name="cantidad" class="block w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
            <span id="error-cantidad" class="text-red-500 text-sm"></span>
        </div>
        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Registrar</button>
        </div>
    </form>
</div>

<?php
$productos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función para guardar los datos del formulario en un array asociativo
    function guardarProducto(&$productos, $nombre, $precio, $cantidad) {
        $productos[] = [
            "nombre" => $nombre,
            "precio" => $precio,
            "cantidad" => $cantidad
        ];
    }

    // Validación de datos
    $errores = [];
    if (empty($_POST["nombre"])) {
        $errores["nombre"] = "El nombre del producto es obligatorio.";
    }
    if (!is_numeric($_POST["precio"]) || $_POST["precio"] <= 0) {
        $errores["precio"] = "El precio debe ser un número positivo.";
    }
    if (!is_numeric($_POST["cantidad"]) || $_POST["cantidad"] < 0) {
        $errores["cantidad"] = "La cantidad debe ser un número no negativo.";
    }

    if (empty($errores)) {
        // Guardar producto si no hay errores
        guardarProducto($productos, $_POST["nombre"], $_POST["precio"], $_POST["cantidad"]);
    }
}

if (!empty($productos)) {
    // Función para calcular el valor total del producto
    function calcularValorTotal($precio, $cantidad) {
        return $precio * $cantidad;
    }

    // Función para determinar el estado del producto
    function determinarEstado($cantidad) {
        return $cantidad > 0 ? "En stock" : "Agotado";
    }

    // Función para mostrar la tabla de productos
    function mostrarTabla($productos) {
        echo "<table class='w-full bg-white border border-gray-200 mb-4'>";
        echo "<thead>";
        echo "<tr><th class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>Nombre del Producto</th><th class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>Precio por Unidad</th><th class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>Cantidad en Inventario</th><th class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>Valor Total</th><th class='py-2 px-2 bg-gray-200 text-gray-700 text-sm'>Estado</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($productos as $producto) {
            $valorTotal = calcularValorTotal($producto["precio"], $producto["cantidad"]);
            $estado = determinarEstado($producto["cantidad"]);
            echo "<tr>";
            echo "<td class='py-2 px-2 border-t text-sm'>{$producto['nombre']}</td>";
            echo "<td class='py-2 px-2 border-t text-sm'>\${$producto['precio']}</td>";
            echo "<td class='py-2 px-2 border-t text-sm'>{$producto['cantidad']}</td>";
            echo "<td class='py-2 px-2 border-t text-sm'>\${$valorTotal}</td>";
            echo "<td class='py-2 px-2 border-t text-sm'>{$estado}</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    // Mostrar los productos registrados
    echo "<div class='max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md mt-6'>";
    echo "<h2 class='text-2xl font-bold mb-4 text-center text-blue-600'>Productos Registrados</h2>";
    mostrarTabla($productos);
    echo "</div>";
}
?>

<script src="./js/validation.js"></script>

</body>
</html>
