<?php


require_once "dompdf_config.inc.php";

$dompdf = new DOMPDF();
require_once 'dompdf/autoload.inc.php';
$dompdf = new Dompdf();

$html = <<<'ENDHTML'
<html>
 <body>
  <h1>Hello Dompdf</h1>
 </body>
</html>
ENDHTML;

$dompdf->load_html($html);
$dompdf->render();

$dompdf->stream("hello.pdf");