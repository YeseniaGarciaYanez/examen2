<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bienesraices";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vender'])) {
    $propiedad_id = $_POST['propiedad_id'];
    $comprador = $_POST['comprador'];

    echo "Datos recibidos:";

    $stmt = $conn->prepare("INSERT INTO propiedadesVendidas (propiedad_id, comprador) VALUES (?, ?)");
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("is", $propiedad_id, $comprador);

    if ($stmt->execute()) {
        echo "¡Propiedad vendida registrada exitosamente!";
    } else {
        echo "Error al registrar la venta: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM propiedades";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta de Propiedades</title>
    <style>
        body { 
            font-family:Verdana, Geneva, Tahoma, sans-serif;
            background-color: #333; 
            color:cadetblue;
            margin: 0;
        }
        .navbar {
            background-color: #222;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
        }
        .navbar-logo {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar-logo span {
            color: #fff;
        }
        .navbar-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
        }
        .navbar-links a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar-links a:hover {
            color: #ccc;
        }
        .navbar-icon {
            font-size: 20px;
            margin-left: auto;
        }
        .container { 
            width: 600px; 
            margin: 50px auto; 
            padding: 20px; 
            background-color: #444; 
            border-radius: 5px; 
            box-shadow: 0px 0px 10px rgba(0,0,0,0.5); 
        }
        h1 { 
            text-align: center; 
        }
        form { 
            display: flex; 
            flex-direction: column; 
        }
        label { 
            margin: 10px 0 5px; 
            font-weight: bold; 
            color: #ddd;
        }
        select, input[type="text"] { 
            padding: 8px; 
            border: 1px solid #555; 
            border-radius: 4px; 
            background-color: #666; 
            color: #fff;
        }
        button { 
            margin-top: 20px; 
            padding: 10px; 
            background-color:cadetblue;
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: #4cae4c; 
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-logo">BIENES<span>RAICES</span></div>
        <ul class="navbar-links">
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Anuncios</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
        <div class="navbar-icon">🌙</div>
    </div>

    <div class="container">
        <h1>Registrar Venta de Propiedad</h1>
        <form method="POST" action="index.php">
            <label for="propiedad_id">Selecciona la Propiedad Vendida:</label>
            <select name="propiedad_id" id="propiedad_id" required>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['titulo'] . " - $" . number_format($row['precio'], 2); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="comprador">Nombre del Comprador:</label>
            <input type="text" name="comprador" id="comprador" required>

            <button type="submit" name="vender">Registrar Venta</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
