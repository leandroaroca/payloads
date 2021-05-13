<?php

namespace App\Domain\Payload\Actions;

use App\Domain\Payload\Exceptions\StorePayloadException;
use ErrorException;
use ParseError;

/**
 * Class PayloadToArrayAction
 * @package App\Domain\Payload\Actions
 */
class PayloadToArrayAction
{
    /**
     * @param string $data
     * @return array
     */
    public function __invoke(string $data): array
    {
        $result = [];
        try{
            // Decode hexadecimally to string
            $str = hex2bin(str_replace(["\n", "\r"], '', $data));

            // Transform to array
            eval(("\$result = [".$str."];"));
        }catch (ErrorException $errorException){
            // If fail hex
            throw StorePayloadException::hexFailDecode($errorException->getMessage());
        } catch (ParseError $parseError){
            // If fail eval
            throw StorePayloadException::evalFailDecode($parseError->getMessage());
        }

        return $result;
    }
}
