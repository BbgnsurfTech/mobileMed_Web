<div>
    <div class="row">
        <div class="col-sm-12 col-lg-6 mb-5">
            {{ Form::label('Doctor',__('messages.doctor_opd_charge.doctor').':' ,['class' => 'form-label required']) }}
            {{ Form::select('doctor_id', $doctor, null,['class' => 'io-select2 form-select', 'id' => 'adminAppointmentDoctorId', 'data-control'=>"select2", 'required','placeholder' => __('messages.doctor_opd_charge.doctor')]) }}
        </div>
        <div class="mb-5 col-6">
            {{ Form::label('date',__('messages.sms.date').':' ,['class' => 'form-label required']) }}
            {{ Form::text('date', null,['class' => 'form-control'. (getLoggedInUser()->thememode ? ' bg-light' : ' bg-white'),'placeholder' => __('messages.sms.date') ,'id' =>'doctorHolidayDate']) }}
        </div>
        <div class="mb-5 col-6">
            {{ Form::label('name',__('messages.holiday.reason').':' ,['class' => 'form-label']) }}
            {{ Form::text('name', null,['class' => 'form-control','placeholder' => __('messages.holiday.reason')]) }}
        </div>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary" id="btnSubmit">{{ __('messages.common.save') }}</button>&nbsp;&nbsp;&nbsp;
        <a href="{{  route('holidays.index') }}"
           type="reset"
           class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>
