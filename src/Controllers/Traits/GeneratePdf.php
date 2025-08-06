<?php

namespace App\Controllers\Traits;

//importar lib DOMPDF
use Dompdf\Dompdf;
use Dompdf\Options;

trait GeneratePdf {

    public function generateOs($clientes, $os, $servicos, $code = null, $qr_code = null) : bool{
        $path = __DIR__ . '/../../Resources/pdf/os.php';

        $nome_cliente = $clientes->nome;
        $doc_cliente = $clientes->documento;
        
        ob_start();
            extract((array)$nome_cliente);
            extract((array)$doc_cliente);
            extract((array)$os);
            extract((array)$servicos);
            extract((array)$code);
            extract((array)$qr_code);
            
            include $path;
        $pdf = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdf);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('O.S.pdf', ['Attachment' => false]);

        return true;
    }

    public function generateSale($clientes, $venda, $produtos, $code = null, $qr_code = null) : bool{
        $path = __DIR__ . '/../../Resources/pdf/venda.php';

        $nome_cliente = $clientes->nome;
        $doc_cliente = $clientes->documento;

        ob_start();
            extract((array)$nome_cliente);
            extract((array)$doc_cliente);
            extract((array)$venda);
            extract((array)$produtos);
            extract((array)$code);
            extract((array)$qr_code);
            
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

}