<?php

namespace App\Repositories;

use App\Models\IpdDiagnosis;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class IpdDiagnosisRepository
 *
 * @version September 8, 2020, 11:46 am UTC
 */
class IpdDiagnosisRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ipd_patient_department_id',
        'report_type',
        'report_date',
        'description',
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
        return IpdDiagnosis::class;
    }

    public function store(array $input)
    {
        try {
            /** @var IpdDiagnosis $ipdDiagnosis */
            $ipdDiagnosis = $this->create($input);
            if (isset($input['file']) && ! empty($input['file'])) {
                $ipdDiagnosis->addMedia($input['file'])->toMediaCollection(IpdDiagnosis::IPD_DIAGNOSIS_PATH,
                    config('app.media_disc'));
            }
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateIpdDiagnosis(array $input, int $ipdDiagnosisId)
    {
        try {
            /** @var IpdDiagnosis $ipdDiagnosis */
            $ipdDiagnosis = $this->update($input, $ipdDiagnosisId);
            if (isset($input['file']) && ! empty($input['file'])) {
                $ipdDiagnosis->clearMediaCollection(IpdDiagnosis::IPD_DIAGNOSIS_PATH);
                $ipdDiagnosis->addMedia($input['file'])->toMediaCollection(IpdDiagnosis::IPD_DIAGNOSIS_PATH,
                    config('app.media_disc'));
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && ! empty($input['avatar_remove'])) {
                removeFile($ipdDiagnosis, IpdDiagnosis::IPD_DIAGNOSIS_PATH);
            }
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function deleteIpdDiagnosis(int $ipdDiagnosisId)
    {
        try {
            /** @var IpdDiagnosis $ipdDiagnosis */
            $ipdDiagnosis = $this->find($ipdDiagnosisId);
            $ipdDiagnosis->clearMediaCollection(IpdDiagnosis::IPD_DIAGNOSIS_PATH);
            $this->delete($ipdDiagnosisId);
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
