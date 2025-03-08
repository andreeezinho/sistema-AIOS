<?php

namespace App\Controllers\Traits;

//importar lib DOMPDF
use Dompdf\Dompdf;

trait GeneratePdf {

    public function generateOs($clientes, $os, $servicos) : bool{
        $path = __DIR__ . '/../../Resources/pdf/os.php';
        $cliente_data = json_encode($clientes);
        
        ob_start();
            extract((array)$cliente_data);
            extract((array)$os);
            extract((array)$servicos);
            
            include $path;
        $pdf = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Venda.pdf', ['Attachment' => false]);

        return true;
    }

    public function generateSale($cliente, $venda, $produtos){
        $path = __DIR__ . '/../../Resources/pdf/venda.php';

        ob_start();
            extract(json_decode($cliente, true));
            extract(json_decode($venda, true));
            extract(json_decode($produtos, true));
            
            include $path;
        $pdf = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('O.S.pdf', ['Attachment' => false]);
        
        return true;
    }

}