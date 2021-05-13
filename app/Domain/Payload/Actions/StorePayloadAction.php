<?php

namespace App\Domain\Payload\Actions;

use App\Location;

/**
 * Class StorePayloadAction
 * @package App\Domain\Payload\Actions
 */
class StorePayloadAction
{

    private PayloadToArrayAction $payloadToArrayAction;

    /**
     * StorePayloadAction constructor.
     * @param PayloadToArrayAction $payloadToArrayAction
     */
    public function __construct(PayloadToArrayAction $payloadToArrayAction)
    {
        $this->payloadToArrayAction = $payloadToArrayAction;
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function __invoke(string  $data)
    {
        // Convert payload to array for save in json
        $location = $this->payloadToArrayAction->__invoke($data);

        // Save localization
        return Location::create($location);
    }
}
