<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * Class InvestigationReport
 *
 * @version February 21, 2020, 9:02 am UTC
 *
 * @property int $id
 * @property int $patient_id
 * @property Carbon $date
 * @property string $title
 * @property string|null $description
 * @property int $doctor_id
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Doctor $doctor
 * @property-read Patient $patient
 *
 * @method static Builder|InvestigationReport newModelQuery()
 * @method static Builder|InvestigationReport newQuery()
 * @method static Builder|InvestigationReport query()
 * @method static Builder|InvestigationReport whereAttachment($value)
 * @method static Builder|InvestigationReport whereCreatedAt($value)
 * @method static Builder|InvestigationReport whereDate($value)
 * @method static Builder|InvestigationReport whereDescription($value)
 * @method static Builder|InvestigationReport whereDoctorId($value)
 * @method static Builder|InvestigationReport whereId($value)
 * @method static Builder|InvestigationReport wherePatientId($value)
 * @method static Builder|InvestigationReport whereStatus($value)
 * @method static Builder|InvestigationReport whereTitle($value)
 * @method static Builder|InvestigationReport whereUpdatedAt($value)
 *
 * @mixin Model
 *
 * @property int $is_default
 * @property-read mixed $attachment_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 *
 * @method static Builder|InvestigationReport whereIsDefault($value)
 */
class InvestigationReport extends Model implements HasMedia
{
    use BelongsToTenant, PopulateTenantID, InteractsWithMedia;

    const STATUS = [self::NOT_SOLVED => 'Not Solved', self::SOLVED => 'Solved'];

    const STATUS_ALL = 2;

    const SOLVED = 1;

    const NOT_SOLVED = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::SOLVED => 'Solved',
        self::NOT_SOLVED => 'Not Solved',
    ];

    const COLLECTION_REPORTS = 'reports';

    public $table = 'investigation_reports';

    public $fillable = [
        'patient_id',
        'date',
        'title',
        'description',
        'doctor_id',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'date' => 'datetime',
        'title' => 'string',
        'description' => 'string',
        'doctor_id' => 'integer',
        'status' => 'integer',
    ];

    protected $appends = ['attachment_url'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'required|unique:investigation_reports,patient_id',
        'date' => 'required|date',
        'title' => 'required|string',
        'doctor_id' => 'required',
        'status' => 'required',
        'attachment' => 'mimes:jpeg,png,jpg,gif,pdf,doc,webp',
    ];

    /**
     * @var string[]
     */
    public static $messages = [
        'patient_id.unique' => 'The patient name has already been taken.',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function getAttachmentUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }
    }

    public function prepareData()
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->patientUser->full_name,
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
            'title' => $this->title,
            'attachment' => $this->attachment_url,
            'date' => isset($this->date) ? \Carbon\Carbon::parse($this->date)->translatedFormat('jS M, Y') : __('messages.common.n/a'),
            'time' => isset($this->date) ? \Carbon\Carbon::parse($this->date)->isoFormat('LT') : __('messages.common.n/a'),
        ];
    }
}
