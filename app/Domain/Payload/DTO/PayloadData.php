<?php

namespace App\Domain\Payload\DTO;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class PayloadData extends  DataTransferObject
{
    public ?string $data;

    public ?array $dataList;

    public static function fromRequest(Request $request): self
    {
        $data = self::getData($request);

        if(is_array($data)){
            return new static(['dataList' => $data]);
        }

        return new static(['data' => $data]);
    }

    private static function getData(Request $request)
    {
        $paramName = config('payload.param_name');

        if(is_null($paramName))
        {
            return file_get_contents('php://input');
        }

        return $request->$paramName;
    }

    public function isMassiveSave()
    {
        $separator = config('payload.separator');

        if(is_null($separator)){
            return false;
        }

        if(!is_null($this->dataList)){
            return true;
        }

        $listData = explode($separator, $this->data);

        return count($listData) > 1;
    }

    public function getListData()
    {
        $separator = config('payload.separator');

        if(is_null($separator)){
            return false;
        }

        if(!is_null($this->dataList)){
            return Collection::make($this->dataList);
        }

        return Collection::make(explode($separator, $this->data));
    }
}
