<?php

namespace App\Repositories;

use App\Models\Bed;
use App\Models\BedType;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class BedRepository
 *
 * @version February 17, 2020, 10:56 am UTC
 */
class BedRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bed_type',
        'bed_id',
        'description',
        'status',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Bed::class;
    }

    public function getBedTypes()
    {
        /** @var BedType $bedTypes */
        $bedTypes = BedType::all()->pluck('title', 'id')->sort();

        return $bedTypes;
    }

    public function getAssociateBedsList(): array
    {
        $result = BedType::orderBy('title', 'asc')->get()->pluck('title', 'id')->toArray();
        $bedTypes = [];
        foreach ($result as $key => $item) {
            $bedTypes[] = [
                'key' => $key,
                'value' => $item,
            ];
        }

        return $bedTypes;
    }

    /**
     * @return bool|UnprocessableEntityHttpException
     */
    public function store(array $input)
    {
        try {
            $input['bed_id'] = mb_strtoupper(Bed::generateUniqueBedId());
            $bed = Bed::create($input);

            return true;
        } catch (\Exception $e) {
            return new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return bool|UnprocessableEntityHttpException
     */
    public function storeBulkBeds(array $input)
    {
        try {
            for ($i = 0; $i < count($input['name']); $i++) {
                $data['name'] = $input['name'][$i];
                $data['bed_type'] = $input['bed_type'][$i];
                $data['charge'] = removeCommaFromNumbers($input['charge'][$i]);
                $data['description'] = $input['description'][$i];
                $data['bed_id'] = mb_strtoupper(Bed::generateUniqueBedId());
                Bed::create($data);
            }

            return true;
        } catch (\Exception $e) {
            return new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
