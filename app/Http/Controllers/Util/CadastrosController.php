<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\pessoas\Motorista;
use App\Models\veiculos\Carreta;
use App\Models\veiculos\Cavalo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CadastrosController extends Controller
{
    public function cadastroPortonave($tipo, $identificacao = null)
    {
        $tipo = strtoupper($tipo);
        $user = Auth::user();
        $email_usuario = $user->email;
        try {
            $assinatura_email = public_path('storage' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'assinatura_edwalbert.png');
            $tipo_conteudo = mime_content_type($assinatura_email);
            $imagem_base64 = base64_encode(file_get_contents($assinatura_email));
            $tag_imagem = '<img src="data:' . $tipo_conteudo . ';base64,' . $imagem_base64 . '" alt="Assinatura Edwalbert">';

            if ($tipo == 'MOTORISTA') {
                $cpf = $identificacao;
                $motorista = Motorista::where('cpf', $cpf)->first();
                if ($motorista == null) {
                    return redirect('consulta')->with('error', 'Motorista não encontrado!');
                }
                $nome = strtoupper($motorista->nome);
                $assunto = 'ATUALIZAR CNH ' . $nome;
                $corpo = 'Olá! <br><br>' . 'Por gentileza, atualizar CNH do Motorista ' . $nome . '. <br><br> CPF: ' . $cpf . ' <br><br>' . $tag_imagem;
                $vencimento_cnh = Carbon::createFromFormat('d/m/Y', $motorista->vencimento_cnh);
                $anexos[] = 'storage' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR . 'motoristas' . DIRECTORY_SEPARATOR . 'cnh' . DIRECTORY_SEPARATOR . $cpf . '-CNH.pdf';

                if ($vencimento_cnh->isPast()) {
                    return redirect('consulta')->with('error', 'CNH Vencida!');
                }
            } else {
                $placa = strtoupper($identificacao);
                $assunto = 'ATUALIZAR CRLV | ' . $placa;
                $corpo = 'Olá! <br><br>' . 'Por gentileza, atualizar CRLV do Veículo ' . $placa . ' <br><br>' . $tag_imagem;;
                $anexos[] = 'storage' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR . 'veiculos' . DIRECTORY_SEPARATOR . 'crlv' . DIRECTORY_SEPARATOR . $placa . '-CRLV.pdf';

                if ($tipo == 'CAVALO') {

                    $cavalos = Cavalo::with('crlv')
                        ->where('placa', '=', "$placa")
                        ->get();

                    $vencimento_crlv = Carbon::createFromFormat('d/m/Y',  $cavalos[0]->crlv->vencimento_crlv);
                    if ($vencimento_crlv->isPast()) {
                        return redirect('consulta')->with('error', 'CRLV Vencido!');
                    }
                }
            }

            $email_from = 'monitoramento@cotramol.com.br';
            $emails_to[] = 'monitoramento@cotramol.com.br';
            $emails_cc[] = 'cadastro@cotramol.com.br';
            $emails_cc[] = "$email_usuario";

            $this->enviarEmail($assunto, $corpo, $emails_to, $emails_cc, $anexos, $email_from);

            return redirect('consulta')->with('success', 'Atualização cadastral solicitada!');
        } catch (Exception $e) {
            return redirect('consulta')->with('error', $e);
        }
    }

    public function enviarEmail($subject, $messageContent, $to, $cc, array $anexos = [], $email_from)
    {

        $emailId = null;
        try {
            Mail::mailer('custom')->send([], [], function ($message) use ($subject, $messageContent, $to, $cc, $anexos, $email_from) {
                $message->from($email_from);
                $message->to($to);
                $message->subject(strtoupper($subject));
                $message->html($messageContent);

                foreach ($anexos as $anexo) {
                    $filePath = public_path($anexo);
                    $message->attach($filePath, ['as' => 'Doc.pdf']);
                }

                if (!empty($cc)) {
                    $message->cc($cc);
                }
            });

            $emailId = DB::getPdo()->lastInsertId();
            return $emailId;
        } catch (Exception $e) {
            return redirect('consulta')->with('error', $e);
        }
    }
}
