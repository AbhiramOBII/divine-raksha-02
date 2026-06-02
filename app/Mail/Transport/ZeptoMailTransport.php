<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;

class ZeptoMailTransport extends AbstractTransport
{
    protected string $token;
    protected string $host;

    public function __construct(string $token, string $host = 'api.zeptomail.in')
    {
        parent::__construct();
        $this->token = $token;
        $this->host = $host;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $from = $email->getFrom()[0];
        $payload = [
            'from' => [
                'address' => $from->getAddress(),
                'name' => $from->getName() ?: config('mail.from.name', 'Divine Raksha'),
            ],
            'subject' => $email->getSubject(),
        ];

        // To recipients
        $toAddresses = [];
        foreach ($email->getTo() as $to) {
            $toAddresses[] = [
                'email_address' => [
                    'address' => $to->getAddress(),
                    'name' => $to->getName() ?: $to->getAddress(),
                ],
            ];
        }
        $payload['to'] = $toAddresses;

        // CC
        if ($email->getCc()) {
            $ccAddresses = [];
            foreach ($email->getCc() as $cc) {
                $ccAddresses[] = [
                    'email_address' => [
                        'address' => $cc->getAddress(),
                        'name' => $cc->getName() ?: $cc->getAddress(),
                    ],
                ];
            }
            $payload['cc'] = $ccAddresses;
        }

        // BCC
        if ($email->getBcc()) {
            $bccAddresses = [];
            foreach ($email->getBcc() as $bcc) {
                $bccAddresses[] = [
                    'email_address' => [
                        'address' => $bcc->getAddress(),
                        'name' => $bcc->getName() ?: $bcc->getAddress(),
                    ],
                ];
            }
            $payload['bcc'] = $bccAddresses;
        }

        // HTML body
        if ($email->getHtmlBody()) {
            $payload['htmlbody'] = $email->getHtmlBody();
        } elseif ($email->getTextBody()) {
            $payload['textbody'] = $email->getTextBody();
        }

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->token,
        ])->post("https://{$this->host}/v1.1/email", $payload);

        if ($response->failed()) {
            throw new \RuntimeException(
                'ZeptoMail API error: ' . $response->body()
            );
        }
    }

    public function __toString(): string
    {
        return 'zeptomail';
    }
}
