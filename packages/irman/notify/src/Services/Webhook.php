<?php

namespace Irman\Notify\Services;

class Webhook
{
    protected string|array $content;

    public function __construct(string|array $content)
    {
        $this->content = $content;
    }

    public function getUrl(): string
    {
        return config('notify.webhook.url');
    }

    public function send(): bool
    {
        $url = $this->getUrl();
        $headers = [];
        $stringData = $this->content;
        if (is_array($this->content)) {
            $stringData = json_encode($this->content);
            $headers[] = 'Content-Type: application/json';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $stringData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $this->setCurlDefaultOptions($curl);
        curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_code >= 200 && $http_code < 300) {
            return true;
        }

        return false;
    }

    protected function setCurlDefaultOptions(&$curl): void
    {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    }
}
