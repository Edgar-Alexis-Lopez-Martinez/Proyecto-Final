<?php
require_once('class/ciudades.class.php');
$ciudades = $Ciudades->read();
require_once('class/estados.class.php');
$estados = $Estados->read();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciudades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <div id="wrapper" class="container-fluid">
        <header>
            <div class="row" id="idtoprowheader">
                <div class="col" id="idnavcontent">
                    <nav class="navbar navbar-expand-lg navbar-dark" id="navheader">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#">Agencia De Viajes Veronica </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="mapa.php">Mapa</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="estados.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Estados
                                        </a>
                                        <?php
                                        foreach ($estados as $estado) :
                                        ?>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="ciudad.php?id=<?php echo $estado["id_estado"]; ?>" value="<?php echo $estado["id_estado"]; ?>"><?php echo $estado["estado"]; ?></a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="admin/login.php">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <?php
        $renglon = 1;
        $columnas = 1;
        foreach ($ciudades as $ciudades) :
        ?>
            <?php if ($renglon % 3 == 0 or $renglon == 1) :
                $columnas = 1; ?>
                <div class="row text-center">
                <?php endif; ?>
                <div class="col">
                    <?php $columnas++; ?>
                    <img class="rounded-circle" src="<?php echo $ciudades["foto"]; ?>">
                    <h2><?php echo $ciudades["ciudad"]; ?></h2>
                    <p><a class="btn btn-secondary" href="#">Ver Mas &raquo;</a></p>
                </div>
                <?php if ($columnas == 3) : ?>
                </div><!-- /.row -->
            <?php endif; ?>
        <?php $renglon++;
        endforeach; ?>
        <div class="row">
            <footer class="footer-03">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <nav id="menu_inferior">
                                        <h3>Enlaces</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="index.php">Acerca De La Agencia</a></li>
                                            <li><a href="estados.php">Estados</a></li>
                                            <li><a href="ciudades.php">Ciudades</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="col">
                                    <h3 class="footer-heading">Dirección</h3>
                                    <ul class="list-unstyled">
                                        <li>Cuitláhuac #208, Rancho Grande, 38620 Acámbaro, Gto.</li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <h3 class="footer-heading">Teléfono</h3>
                                    <ul class="list-unstyled">
                                        <li>417 104 8683</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col">
                                <h3 class="footer-heading">Redes Sociales</h3>
                                <ul id="navlist">
                                    <li id="iconofb"><a href="https://m.facebook.com/login/?locale=es_ES"></a></li>
                                    <li id="iconoyt"><a href="https://youtube.com.mx"></a></li>
                                    <li id="iconotw"><a href="https://twitter.com/?lang=es"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-md-6 col-lg-8">
                            <p class="copyright">
                                Copyright All rights reserved | This template is made with <i class="ion-ios-heart" aria-hidden="true"></i> by AgenciaVeronica.com
                            </p>
                        </div>
                        <div class="col-md-6 col-lg-4 text-md-right">
                            <p class="mb-0 list-unstyled">
                                Condiciones
                                Privacidad
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>