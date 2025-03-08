<?php

namespace App\Controllers\Traits;

//importar lib DOMPDF
use Dompdf\Dompdf;
use Dompdf\Options;

trait GeneratePdf {

    public function generateOs($clientes, $os, $servicos) : bool{
        $path = __DIR__ . '/../../Resources/pdf/os.php';

        $nome_cliente = $clientes->nome;
        $doc_cliente = $clientes->documento;

        ob_start();
            extract((array)$nome_cliente);
            extract((array)$doc_cliente);
            extract((array)$os);
            extract((array)$servicos);
            
            include $path;
        $pdf = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
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