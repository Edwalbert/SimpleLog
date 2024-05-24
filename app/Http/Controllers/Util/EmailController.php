<?php

namespace App\Http\Controllers\Util;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class EmailController extends Mailable
{

    public function enviarEmail($subject, $messageContent, $to, $cc, array $anexos = [], $email_from)
    {

        $emailId = null;
        try {
            Mail::send([], [], function ($message) use ($subject, $messageContent, $to, $cc, $anexos, $email_from) {
                $message->from($email_from);
                $message->to($to);
                $message->subject(strtoupper($subject));
                $message->html($messageContent);

                foreach ($anexos as $anexo) {

                    if ($anexo instanceof UploadedFile) {
                        $temporaryPath = $anexo->store('temp');
                        $message->attach(Storage::path($temporaryPath), ['as' => $anexo->getClientOriginalName()]);
                    }
                }

                if (!empty($cc)) {
                    $message->cc($cc);
                }
            });

            $emailId = DB::getPdo()->lastInsertId();
            return $emailId;
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function autorizarAdiantamento($subject, $messageContent, $to, $cc, $file)
    {
        Mail::send([], [], function ($message) use ($subject, $messageContent, $to, $cc, $file) {
            $email_from = 'cte.itajai@cotramol.com.br';
            $message->from($email_from);
            $message->to($to);
            $message->subject(strtoupper($subject));
            $message->html($messageContent);
            if ($file instanceof UploadedFile) {
                $temporaryPath = 'temp/'  . 'Anexo.' . $file->getClientOriginalExtension();
                Storage::put($temporaryPath, file_get_contents($file));
                $originalName = $file->getClientOriginalName();

                $message->attach(Storage::path($temporaryPath), [
                    'as' => $originalName,
                ]);
            }

            if (!empty($cc)) {
                $message->cc($cc);
            }
        });
    }

    public function cancelarAdiantamento($id_email)
    {
        try {
            $emailOriginal = Mailable::find($id_email);
            if (!$emailOriginal) {
                return 'Email original não encontrado';
            }

            return redirect('consulta-adiantamentos')->with('success', 'Adiantamento enviado com sucesso!');
        } catch (QueryException $e) {
            return redirect('consulta-adiantamentos')->with('error', 'Erro ao enviar adiantamento!: ');
        }
    }
}
