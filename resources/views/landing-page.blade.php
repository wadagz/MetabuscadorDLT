<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> MetaBuscador </title>
    <link rel="stylesheet" href="css/stylesLandingPage.css">
    <script src="js/scriptsLandingPage.js"> </script>
</head>
<body>
    <header>
        <x-navBar/>
    </header>

    <div class="buscador">
        <div class="especificaciones">
            <img src="images\lupa.png" class="imagen-especificaciones">
            <input class="caja-busqueda" id="buscarDestino" type="text" value="Destino o lugar turístico" onclick="borrarTexto();">
        </div>
        <div class="especificaciones">
            <img src="images\calendario.png" class="imagen-especificaciones">
            <p class="fechas"> Fecha de Partida </p>
        </div>
        <div class="especificaciones">
            <img src="images\calendario.png" class="imagen-especificaciones">
            <p class="fechas"> Fecha de Llegada </p>
        </div>
        <button class="btn-buscar" onclick="buscarDestino()"> Buscar </button>
    </div>
</body>
</html>