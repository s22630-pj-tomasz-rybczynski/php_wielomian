<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Polynomial chart</title>
</head>

<body>
    <form name="form" method="post" action="">
        <div>
        <input type="number" name="a" value="<?php echo isset($_POST["a"])?$_POST["a"]:""; ?>"><b>x</b><sup>3</sup> +
        <input type="number" name="b" value="<?php echo isset($_POST["b"])?$_POST["b"]:""; ?>"><b>x</b><sup>2</sup> +
        <input type="number" name="c" value="<?php echo isset($_POST["c"])?$_POST["c"]:""; ?>"><b>x</b> +
        <input type="number" name="d" value="<?php echo isset($_POST["d"])?$_POST["d"]:""; ?>"> = 0
        </div>
        <div>
        <input type="number" name="xmin" value="<?php echo isset($_POST["xmin"])?$_POST["xmin"]:""; ?>"><b>x<sub>min</sub></b>
        <input type="number" name="xmax" value="<?php echo isset($_POST["xmax"])?$_POST["xmax"]:""; ?>"><b>x<sub>max</sub></b>
        </div>

        <input type="submit" name="sub" value="Oblicz">
    </form><br>
    <div class="chart-container" style="position: relative; height:30vh; width:60vw">
        <canvas id="myChart" ></canvas>
        <?php
          error_reporting(0);

          function countY($aa, $bb, $cc, $dd, $x) {
            return $aa*$x**3 + $bb*$x**2 + $cc*$x + $dd;
          }

          class XY {
            public $x;
            public $y;

            function __construct($x, $y)
            {
              $this->x = $x;
              $this->y = $y;
            }
          }

          if(isset($_POST['a'], $_POST['b'], $_POST['c'], $_POST['d'], $_POST['xmin'], $_POST['xmax'])){
            $dataset = array();
            $xarr = array();
            $a = $_POST['a'];
            $b = $_POST['b'];
            $c = $_POST['c'];
            $d = $_POST['d'];
            $xmin = $_POST['xmin'];
            $xmax = $_POST['xmax'];

            for($i = intval($xmin); $i <= intval($xmax); $i++){
              $dataset[] = $i;
              $xarr[] = $i;
            }

            foreach ($dataset as $x) {
              $index = array_search($x, $dataset);
              $dataset[$index] = new XY($dataset[$index], countY(intval($a), intval($b), intval($c), intval($d), $x));
            }
          }
        ?>
    </div>
    <script type="text/javascript">
      
      let dataArr = <?php echo json_encode($dataset); ?>;
      let labels = <?php echo json_encode($xarr); ?>;

      const data = {
        labels: labels,
        datasets: [{
          label: 'Polynomial chart',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: dataArr,
        }]
      };

      const config = {
        type: 'line',
        data: data,
        options: {
          scales: {
            x: {
              title: {
                display: true,
                text: 'X',
              }
            },
            y: {
              title: {
                display: true,
                text: 'Y'
              }
            }
          }
        }
      }

      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
    </script>
</body>
</html>
