<?php


namespace App\Domain\Payload\Exceptions;

use DomainException;

class StorePayloadException extends DomainException
{

    public static function hexFailDecode(string $messsage): self
    {
        return new static($messsage);
    }

    public static function evalFailDecode(string $messsage): self
    {
        return new static($messsage);
    }

}
