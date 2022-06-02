<?php

/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

// get the HTML
ob_start();
include(dirname(__FILE__) . '/res/exemple00.php');
$content = ob_get_clean();

// convert in PDF
//require_once(dirname(__FILE__).'/../vendor/autoload.php');
require_once('C://xampp/htdocs/vendor/autoload.php');
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'es');
    //      $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $contenido = "<h1>Reporte</h1>
    <br><p>Hola Mundo</p>";
    $html2pdf->writeHTML($contenido);
    $html2pdf->Output('exemple00.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
