<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once("configuracion.php");
require_once('C://xampp/htdocs/vendor/autoload.php');
session_start();
class Agencia
{
    var $db = null;
    public function conexion()
    {

        $dsn = SGRD . ':dbname=' . DB_NAME . ';host=' . DB_HOST;
        $this->db = new PDO($dsn, DB_USER, DB_PASSWORD);
    }

    public function alerta($mensaje, $tipo)
    {
        include('view/mensajes.php');
    }
    public function alertaError($mensaje)
    {
        include('view/header_error.php');
        $this->alerta($mensaje, 'danger');
        include_once('view/footer.php');
        die();
    }
    public function cargarImagen($carpeta)
    {
        if (isset($_FILES["foto"])) {
            $foto = $_FILES["foto"];
            if ($foto["error"] == 0) {
                if ($foto["size"] <= IMG_SIZE) {
                    if (in_array($foto["type"], IMG)) {
                        $origen = $foto["tmp_name"];
                        $num = random_int(1, 100);
                        $destino = PATH . "images/" . $carpeta . "/" . $num . "_" . $foto["name"];
                        if (move_uploaded_file($origen, $destino)) {
                            return "images/" . $carpeta . "/" . $num . "_" . $foto["name"];
                        }
                    }
                }
            }
        }
        return false;
    }
    public function login($correo, $contrasena)
    {
        $contrasena = md5($contrasena);
        if ($this->validateEmail($correo)) {
            $sql = "SELECT * FROM usuario WHERE correo=:correo AND contrasena=:contrasena;";
            $usuario = $this->db->prepare($sql);
            $usuario->bindParam(':correo', $correo, PDO::PARAM_STR);
            $usuario->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $usuario->execute();
            $usuario = $usuario->fetch(PDO::FETCH_ASSOC);
            if (isset($usuario['correo'])) {
                $_SESSION['validado'] = true;
                $_SESSION['correo'] = $correo;
                $_SESSION['roles'] = $this->roles($correo);
                $_SESSION['permisos'] = $this->permisos($correo);
                return true;
            }
        }
        $this->logOut();
        return false;
    }
    public function logOut()
    {
        if (isset($_SESSION['validado'])) unset($_SESSION['validado']);
        if (isset($_SESSION['correo'])) unset($_SESSION['correo']);
        if (isset($_SESSION['roles'])) unset($_SESSION['roles']);
        if (isset($_SESSION['permisos'])) unset($_SESSION['permisos']);
        session_destroy();
    }
    public function validateUser()
    {
        if (isset($_SESSION['validado'])) {
            if ($_SESSION['validado']) {
                return true;
            }
        }
        return false;
    }
    public function validateEmail($correo)
    {
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    public function roles($correo)
    {
        $roles = [];
        $sql = "SELECT rol FROM usuario join usuario_rol using(id_usuario) join rol using(id_rol) WHERE correo=:correo;";
        $rol = $this->db->prepare($sql);
        $rol->bindParam(':correo', $correo, PDO::PARAM_STR);
        $rol->execute();
        $rol = $rol->fetchAll(PDO::FETCH_ASSOC);
        if (isset($rol[0]["rol"])) {
            foreach ($rol as $r) {
                array_push($roles, $r["rol"]);
            }
        }
        return $roles;
    }
    public function permisos($correo)
    {
        $permisos = [];
        $sql = "SELECT permiso FROM usuario join usuario_rol using(id_usuario) join permiso_rol using(id_rol)
                join permiso using(id_permiso) WHERE correo=:correo;";
        $permiso = $this->db->prepare($sql);
        $permiso->bindParam(':correo', $correo, PDO::PARAM_STR);
        $permiso->execute();
        $permiso = $permiso->fetchAll(PDO::FETCH_ASSOC);
        if (isset($permiso[0]["permiso"])) {
            foreach ($permiso as $p) {
                array_push($permisos, $p["permiso"]);
            }
        }
        return $permisos;
    }
    public function validateRol($rol)
    {
        if ($this->validateUser()) {
            $roles = $_SESSION['roles'];
            if (!in_array($rol, $roles)) {
                $this->alertaError('Usted No Tiene El Rol Para Realizar Esta Accion');
            }
        } else {
            $this->alertaError('Usted No Es Un Usuario Valido');
        }
    }
    public function validatePermiso($permiso)
    {
        if ($this->validateUser()) {
            $permisos = $_SESSION['permisos'];
            if (!in_array($permiso, $permisos)) {
                $this->alertaError('Usted No TIene El Permiso Para Realizar Esta Accion');
            }
        } else {
            $this->alertaError('Usted No Es Un Usuario Valido');
        }
    }
    public function send_correo($destinatario, $asunto, $msj)
    {
        require '../../vendor/autoload.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = EMAIL_PASS;
        $mail->setFrom(EMAIL, 'Edgar Lopez');
        $mail->addAddress($destinatario, $destinatario);
        $mail->Subject = $asunto;
        $mail->msgHTML($msj);
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    public function recuperar($correo)
    {
        $sql = 'SELECT correo  from usuario WHERE correo=:correo';
        $recupera = $this->db->prepare($sql);
        $recupera->bindParam(':correo', $correo, PDO::PARAM_STR);
        $recupera->execute();
        $recupera = $recupera->fetchAll(PDO::FETCH_ASSOC);
        if ($recupera[0]['correo']) {
            $token = substr(md5(md5($correo . random_int(1, 100000) . 'golden' . md5(random_int(1, 500))) . soundex('uculele')), 0, 16);
            $sql = 'UPDATE usuario SET token=:token WHERE correo=:correo';
            $update = $this->db->prepare($sql);
            $update->bindParam(':correo', $correo, PDO::PARAM_STR);
            $update->bindParam(':token', $token, PDO::PARAM_STR);
            $update->execute();
            $mensaje = "
            <h2>Apreciable Usuario Precione El Siguiente Vinculo Para Reestrablecer Su Contraseña.<h2><br><br><br>
            <a href=\"http://localhost/agencia/admin/login.php?accion=restablecer&correo=$correo&token=$token\"
            target=\"_blank\">Recuper Contraseña</a>
            <br><br>
            Si Usted No Realizo Esta Accion Por Favor Ignore Este Correo Y Contacte Al Administrador.
            ";
            $this->send_correo($correo, "Recuperacion De Contraseña", $mensaje);
            return true;
        }
        return false;
    }
    public function validarToken($correo, $token)
    {
        if ($this->validateEmail($correo) && strlen($token) == 16) {
            $sql = "SELECT * FROM usuario WHERE correo=:correo AND token=:token;";
            $usuario = $this->db->prepare($sql);
            $usuario->bindParam(':correo', $correo, PDO::PARAM_STR);
            $usuario->bindParam(':token', $token, PDO::PARAM_STR);
            $usuario->execute();
            $usuario = $usuario->fetch(PDO::FETCH_ASSOC);
            if (isset($usuario['correo'])) {
                return true;
            }
        }
        return false;
    }
    public function nuevaContrasena($correo, $contrasena, $token)
    {
        $contrasena = md5($contrasena);
        $sql = "update usuario set contrasena=:contrasena, token= null where correo=:correo and token=:token";
        $cambio = $this->db->prepare($sql);
        $cambio->bindParam(':correo', $correo, PDO::PARAM_STR);
        $cambio->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $cambio->bindParam(':token', $token, PDO::PARAM_STR);
        $cuenta = $cambio->execute();
        return $cuenta;
    }
    public function pdf($orientacion, $tamano, $contenido, $nombre)
    {
        error_reporting(E_ALL ^ E_WARNING);
        ob_clean();
        $html2pdf = new HTML2PDF($orientacion, $tamano, 'es');
        //      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($contenido);
        $html2pdf->Output($nombre);
        die();
    }
    public function json($datos, $status, $mensaje)
    {
        ob_clean();
        header('Content-Type application/json; charset-utf-8');
        http_response_code($status);
        array_push($datos, $mensaje);
        $datos = json_encode($datos, JSON_PRETTY_PRINT);
        echo $datos;
        die();
    }
    public function getAllSlider()
    {
        $datos = $this->db->prepare("SELECT * FROM slider WHERE vigencia >= CURRENT_DATE() ORDER BY prioridad;");
        $datos->execute();
        $datos = $datos->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }
}
$Agencia = new Agencia;
$Agencia->conexion();
