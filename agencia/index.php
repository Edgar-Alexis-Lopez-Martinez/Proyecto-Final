<?php
require_once('class/agencia.class.php');
$sliders = $Agencia->getAllSlider();
require_once('class/estados.class.php');
$estados = $Estados->read();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agencia Veronica</title>
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
                        <li><a class="dropdown-item" href="ciudad.php?id=<?php echo $estado["id_estado"]; ?>"><?php echo $estado["estado"]; ?></a></li>
                      <?php endforeach; ?>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      </ul>
                </ul>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="admin/login.php">Login</a>
                </li>
                </ul>
              </div>
            </div>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($sliders as $slider) : ?>
                <div class="carousel-item <?php if ($slider['prioridad'] == 1) : echo "active";
                                          endif; ?>">
                  <a href="<?php echo $slider['url']; ?>" target="_blank"><img src="<?php echo $slider['imagen']; ?>" class="d-block w-100" alt="..."></a>
                </div>
              <?php endforeach; ?>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div id="contenido" class="row">
      <div class="col">
        <aside>
          <div class="row mt-5 pt-4 border-top">
            <div class="col">
              <h3>Información</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-3 margileft">
              <div class="card" style="width: 18rem;">
                <img src="images/que_es.png" class="card-img-top" alt="agencia">
                <div class="card-body">
                  <h5 class="card-title">¿Qué es una agencia de viaje?</h5>
                  <p class="card-text">Son empresas que se dedican profesional y comercialmente en exclusiva al ejercicio de mediación y/u organización de servicios turísticos, pudiendo utilizar medios propios en la prestación de los mismos.</p>
                  <a href="https://www.ceupe.com/blog/que-es-una-agencia-de-viaje.html" class="btn btn-primary">Explorar</a>
                </div>
              </div>
            </div>
            <div class="col-3 margileft">
              <div class="card" style="width: 18rem;">
                <img src="images/estados.jpg" class="card-img-top" alt="estados">
                <div class="card-body">
                  <h5 class="card-title">Estados</h5>
                  <p class="card-text">Aqui podras ver un listado de todos los estados a los cuales tenemos viajes activos actualmente.</p>
                  <a href="estados.php" class="btn btn-primary">Explorar</a>
                </div>
              </div>
            </div>
            <div class="col-3 margileft">
              <div class="card" style="width: 18rem;">
                <img src="images/ciudadess.jpg" class="card-img-top" alt="ciudades">
                <div class="card-body">
                  <h5 class="card-title">Ciudades</h5>
                  <p class="card-text">Pasa a un listado de todas las cuidades activas a viajes</p>
                  <a href="ciudades.php" class="btn btn-primary">Explorar</a>
                </div>
              </div>
            </div>
            <div class="row mt-5 pt-4 border-top">
              <div class="card">
                <div class="card-header">
                  Oferta
                </div>
                <div class="card-body">
                  <h5 class="card-title">¿Te gustaria visitar Mazatlan?</h5>
                  <p class="card-text">Conoce nuestros viajes disponibles</p>
                  <a href="http://localhost/agencia/pase.php?id=2" class="btn btn-primary">Ir</a>
                </div>
              </div>
            </div>
            <div class="row mt-5 pt-4 border-top">
              <div class="card-group">
                <div class="card">
                  <img src="images/card1.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Playas</h5>
                    <p class="card-text">Te mandamos a las mejores playas del pais</p>
                    <p class="card-text"><small class="text-muted">A disfrutar el mar</small></p>
                  </div>
                </div>
                <br />
                <div class="card">
                  <img src="images/card2.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Hoteles</h5>
                    <p class="card-text">Disfruta de los mejores horeles</p>
                    <p class="card-text"><small class="text-muted">A un buen precio</small></p>
                  </div>
                </div>
                <br />
                <div class="card">
                  <img src="images/card3.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <h5 class="card-title">Rstaurantes</h5>
                    <p class="card-text">Disfruta de las mejores comidas</p>
                    <p class="card-text"><small class="text-muted">A un super precio</small></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>

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