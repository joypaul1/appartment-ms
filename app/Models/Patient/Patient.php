<?php

namespace App\Models\Patient;

use App\Models\Appiontment\Appointment as AppiontmentAppointment;
use App\Models\Appointment\Appointment;
use App\Models\Appointment\DialysisAppointment;
use App\Models\SiteConfig\BloodBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use App\Traits\GlobalScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use AuthScopes,AutoTimeStamp,GlobalScope,SoftDeletes;

    protected $guarded =['id'];

    /**
     * Get all of the appoint for the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doctorAppointment(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id')->latest();
    }

    /**
     * Get all of the dialysisAppointment for the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dialysisAppointment(): HasMany
    {
        return $this->hasMany(DialysisAppointment::class, 'patient_id', 'id');
    }


   /**
    * Get the blood that owns the Patient
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function blood(): BelongsTo
   {
       return $this->belongsTo(BloodBank::class, 'blood_group', 'id');
   }

}
