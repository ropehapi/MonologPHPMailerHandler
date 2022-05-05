<?php

namespace App;

use Monolog\Handler\MailHandler;
use Monolog\Logger;

class PHPMailerHandler extends MailHandler
{
    /**
     * Os endereços de email pra onde a mensagem será enviada
     * @var string
     */
    protected $from;

    /**
     * Os endereços de email pra onde a mensagem será enviada
     * @var string[]
     */
    protected $to;

    /**
     * O assunto do email
     * @var string
     */
    protected $subject;

    /**
     * @param string          $from    O enviador do email
     * @param string|string[] $to      Os recebedores do email
     * @param string          $subject O assunto do email
     */
    public function __construct( string $from, $to, string $subject, $level = Logger::ERROR, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->from = $from;
        $this->to = (array) $to;
        $this->subject = $subject;
    }

    /**
     * {@inheritDoc}
     */
    protected function send(string $content, array $records): void
    {
        $message = [];
        $message['from'] = $this->from;
        foreach ($this->to as $recipient) {
            $message['to[]'] = $recipient;
        }
        $message['subject'] = $this->subject;
        $message['date'] = date('r');

        if ($this->isHtmlBody($content)) {
            $message['html'] = $content;
        } else {
            $message['text'] = $content;
        }
        //Defino uma variável com o HTML
        $msg = $message["html"];

        //Envio o Email de forma alternativa
        $email = new Email();
        $email->add("Subject",$msg,"Recipient name","mail_to@example.com")->send();
    }
}