<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * from_mail 	- E-mail do remetente
     * from_name 	- Nome do remetente
     * to_mail 	    - E-mail do destinatário
     * to_name		- Nome do destinatário
     * title 		- Titulo do e-mail
     * template     - Arquivo da template
     * body      	- Conteúdo do e-mail
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $template = 'emails.template_body';

        if (!isset($this->data['from_mail'])) {
            $this->data['from_name']  = config('mail.from.name');
            $this->data['from_mail'] = config('mail.from.address');
        }

        if (!isset($this->data['to_name'])) {
            $this->data['to_name'] = '';
        }

        if (isset($this->data['template'])) {
            $template = $this->data['template'];
        }

        if (!isset($this->data['body'])) {
            $this->data['body'] = '';
        }

        if (env('MAIL_TO_ADDRESS')) {
            $this->data['to_mail'] = env('MAIL_TO_ADDRESS');
        }

        $mailer->send($template, $this->data, function ($m) {
            $m->from($this->data['from_mail'], $this->data['from_name']);
            $m->to($this->data['to_mail'], $this->data['to_name'])->subject($this->data['title']);
        });
    }
}
