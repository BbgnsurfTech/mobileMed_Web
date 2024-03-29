<?php

namespace App\Repositories;

use App\Models\ItemCategory;

/**
 * Class ItemCategoryRepository
 *
 * @version August 26, 2020, 8:12 am UTC
 */
class ItemCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return ItemCategory::class;
    }
}
