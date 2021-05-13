<?php


namespace App\Domain\Payload\Actions;


use App\Domain\Payload\DTO\PayloadData;

/**
 * Class LoadPayloadAction
 * @package App\Domain\Payload\Actions
 */
class LoadPayloadAction
{

    private StorePayloadAction $storePayloadAction;

    /**
     * LoadPayloadAction constructor.
     * @param StorePayloadAction $storePayloadAction
     */
    public function __construct(StorePayloadAction $storePayloadAction)
    {
        $this->storePayloadAction = $storePayloadAction;
    }

    /**
     * @param PayloadData $payloadData
     * @return bool
     */
    public function __invoke(PayloadData  $payloadData): bool
    {
        //If save one location
        if(!$payloadData->isMassiveSave()){
            return $this->storePayloadAction->__invoke($payloadData->data);
        }

        //If save multiple locations
        $saveAll = true;
        $payloadData->getListData()->each(function($location, $key) use($saveAll) {
            if(!app(StorePayloadAction::class)->__invoke($location)){
                $saveAll = false;
            }
        });

        return $saveAll;
    }
}
