<?php


namespace App\Repositories;


use App\Http\Requests\CheckRequest;
use App\Models\Check;
use App\Models\CheckData;

class CheckRepository
{
    /**
     * @param CheckRequest $checkRequest
     * @return mixed
     */
    public function create(CheckRequest $checkRequest)
    {
        $check = Check::create($checkRequest->except('meta'));

        if ($checkRequest->exists('meta') && $checkRequest->filled('meta')) {
            $this->saveMeta($check, $checkRequest->only('meta'));
        }

        return $check;
    }

    /**
     * @param CheckRequest $checkRequest
     * @param Check $check
     * @return Check
     */
    public function update(Check $check, CheckRequest $checkRequest)
    {
        $check->update($checkRequest->except('meta'));

        if ($check->meta->isNotEmpty()) {
            $check->meta()->delete();
        }

        if ($checkRequest->exists('meta') && $checkRequest->filled('meta')) {
            $this->saveMeta($check, $checkRequest->only('meta'));
        }

        return $check;
    }
    /**
     * @param Check $check
     * @param array $metas
     */
    public function saveMeta(Check $check, array $metas) : void
    {
        $data = [];

        foreach ($metas as $meta) {
            foreach ($meta as $key => $value) {
                $data[] = new CheckData(['name' => $key, 'value' => $value]);
            }
        }

        $check->meta()->saveMany($data);
    }
}
