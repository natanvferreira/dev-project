<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController extends Controller
{
    public static function enviaEmail($nomeDestinatario, $destinatario, $mudaMensagem = false, $assunto = "", $mensagem = "")
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = "smtp.office365.com";
            $mail->SMTPAuth = true;
            $mail->Username = "devprojectnatan@outlook.com";
            $mail->Password = "pa108010";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;

            $mail->setFrom("devprojectnatan@outlook.com", "DevProject");
            $mail->addAddress($destinatario, $nomeDestinatario);

            $mail->isHTML(true);
            $mail->CharSet = "UTF-8";

            if (!$mudaMensagem) {
                $mail->Subject = "Novo post criado";
                $mail->msgHTML("Um novo post foi criado no sistema DevProject e aguarda liberação para publicação.", __DIR__);
            } else {
                $mail->Subject = $assunto;
                $mail->msgHTML($mensagem, __DIR__);
            }

            return $mail->send();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
