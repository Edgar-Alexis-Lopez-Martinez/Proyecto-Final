<?php
require_once('../class/agencia.class.php');
$Agencia->validatePermiso('Portada');
include('view/header.php');
$estados = 3;
$ciudades = 3;
$pases = 2;
?>
<h1>Bienvenido Al Sistema</h1>
<!--Load the AJAX API-->
<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        'packages': ['corechart']
    });

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            ['Estdos', <?php echo $estados; ?>],
            ['Ciudades', <?php echo $ciudades; ?>],
            ['Pases', <?php echo $pases; ?>]
        ]);

        // Set chart options
        var options = {
            'title': 'Contenido',
            'width': 400,
            'height': 300
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
<?php
include('view/footer.php');
?>