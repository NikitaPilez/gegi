<?php

declare(strict_types=1);


abstract class BaseWebhookRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        $ips = $this->getIps();
        if (count($ips) > 0 && ! in_array($this->ip(), $ips)) {
            return false;
        }

        return $this->checkSign();
    }

    abstract public function getDto();

    abstract protected function checkSign(): bool;

    /**
     * @return string[]
     */
    abstract protected function getIps(): array;
}
