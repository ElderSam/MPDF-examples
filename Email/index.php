<?php

/* See the Documentation: https://mpdf.github.io/real-life-examples/e-mail-a-pdf-file.html */
//This example shows how to create a PDF file and e-mail it:

use Mpdf\Mpdf;
// require composer autoload
require '../vendor/autoload.php';

require_once './Mailer.php';

$myPDF = new myPDF(); //cria um objeto myPDF
$myPDF->mountPDF();

if (isset($_GET['filename'])) { //se clicou para ver o PDF

    $myPDF->show();

} else if (isset($_GET['send'])) { //se clicou para enviar o PDF por e-mail

    /* ------------- Then, create a Message and send it. ---------- */
    $myPDF->sendMail();

} else {
    $filename = $myPDF->getFileName();
    echo "<br><a href='index.php?filename=$filename'>Visualizar PDF</a>";
    echo "<br><a href='index.php?send=true'>Enviar PDF por email</a>";
}

class myPDF
{
    private $filename;
    private $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf(); // Create new mPDF Document

        $this->filename = 'example.pdf';
        $this->mpdf->SetTitle('My title of PDF file');   
    }

    public function getFileName(){
        return $this->filename;
    }

    public function mountPDF()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dataTipo1 = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

        $hoje = date('d/m/Y');

        $content = "<h1>Hello World</h1>
            <p style='color: green;'> $hoje <br></p>
            <p style='color: red;'>$dataTipo1 <br></p>

            <p><br>OBS: Este é um exemplo de arquivo PDF gerado e enviado por e-mail.
            <br>Bibliotecas utilizadas:</p>
            <ol>
                <li><a href='https://mpdf.github.io/' target='_blank'>MPDF</a> para a geração de arquivos PDF a partir do HTML</li>
                <li><a href='https://phpmailer.github.io/PHPMailer/classes/PHPMailer.PHPMailer.PHPMailer.html' target='_blank'>PHPMailer</a> para o envio de e-mails</li>
            </ol>
            <br>

            <h4 style='background-color: black; color: white; text-align: center;'> Manipulando datas e horários com PHP:</h4>
            Alura <a href='https://www.alura.com.br/artigos/manipulando-datas-e-horarios-com-php'> manipulando-datas-e-horarios-com-php </a><br>
            HomeHost <a href='https://www.homehost.com.br/blog/tutoriais/php/php-date-format/'>PHP Date Format: Exibindo a modificando o padrão de Datas </a><br>
            Devmedia <a href='https://www.devmedia.com.br/manipulando-datas-com-php/32966'>Manipulando datas com PHP </a>
            <br><br>
            <h4>Envio de e-mails autenticados com PHPMailer</h4>
            <a href='https://www.devmedia.com.br/php-envio-de-e-mail-autenticado-utilizando-o-phpmailer/38380'>Envio de e-mail autenticado</a><br>
            <a href='https://www.youtube.com/watch?v=_Se2tUajrJI'>vídeo</a>
            ";

        // Here convert the encode for UTF-8, if you prefer 
        // the ISO-8859-1 just change for $mpdf->WriteHTML($html);
        $this->mpdf->WriteHTML($content);

        //second page
        $this->mpdf->AddPage(); 
        $content2 = "<h1>This is the 2nd page</h1>
            <a href='https://github.com/ElderSam/MPDF-examples'> link para o meu repositório de EXEMPLOS COM MPDF </a>";
        $this->mpdf->WriteHTML($content2);
    }

    public function show()
    {        
        //echo "display " . $this->filename;

        // Then, you can send PDF to the browser
        $this->mpdf->Output($this->filename, 'I'); //display file
    }

    public function sendMail()
    {
        /*OUTPUT Help:
        'D': download the PDF file
        'I': serves in-line to the browser
        'S': returns the PDF document as a string
        'F': save as file $file_out*/

        $this->mpdf->Output($this->filename, \Mpdf\Output\Destination::FILE); //cria um arquivo PDF

        $toAdress = '*******';
        $toName = 'Elder Sam';
        $subject = 'TESTE envio de PDF por e-mail';
        $html = 'Olá, estou enviando um arquivo PDF (teste) gerado a partir da biblioteca MPDF';
        $mail = new Mailer($toAdress, $toName, $subject, $html, $this->filename);

        if ($mail->send()) { //envia o email, e verifica se retornou sucesso

            $message = "<br>Email enviado com <strong style='color: green;'>sucesso ;)</strong>";
        } else {
            $error = $mail->getErrorInfo();
            $message = "<br>Ops, algo deu errado<br>
                    <strong style='color: red;'> $error :(</strong>";
        }

        echo $message;
        echo "<br><a href='index.php'><- Voltar</a>";

        unlink($this->filename); //apaga o arquivo do Servidor

    }
}
