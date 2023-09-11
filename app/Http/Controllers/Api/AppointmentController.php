<?php

namespace App\Http\Controllers\Api;

use App\Helpers\InvoiceNumber;
use App\Http\Controllers\Controller;
use App\Models\Appointment\Appointment;
use App\Models\Doctor\Doctor;
use App\Models\Employee\Department;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use App\Models\Employee\Designation;
use App\Models\PaymentSystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function department()
    {
        return response()->json([
            'status' => 'success',
            'data' => Department::select('id', 'name')->get()
        ]);
    }

    public function doctor()
    {
        return response()->json([
            'status' => 'success',
            'data' => Doctor::select('id', 'first_name', 'last_name', 'department_id', 'designation_id', 'image')->get()->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->first_name . ' ' . $doctor->last_name,
                    'image' => $doctor->image,
                    'department' => Department::select('name')->where('id', $doctor->department_id)->first(),
                    'designation' => Designation::select('name')->where('id', $doctor->designation_id)->first(),

                ];
            })
        ]);
    }
    public function doctorInfo(Request $request)
    {

        return response()->json([
            'status' => 'success',
            'data' => Doctor::whereId($request->doctor_id)->select('id', 'first_name', 'last_name', 'department_id', 'designation_id', 'image')
                ->with('consultations:id,doctor_id,consultation_day,consultation_fee')
                ->get()->map(function ($doctor) use ($request) {
                    return [
                        'id' => $doctor->id,
                        'name' => $doctor->first_name . ' ' . $doctor->last_name,
                        'image' => $doctor->image,
                        'department' => Department::select('name')->where('id', $doctor->department_id)->first(),
                        'designation' => Designation::select('name')->where('id', $doctor->designation_id)->first(),
                        'consultation_fee' => $request->checkreport === 'true' ? $doctor->consultations()->orderBy('id', 'DESC')->first()->consultation_fee : $doctor->consultations->first()->consultation_fee,
                    ];
                })
        ]);
    }

    public function departmentWiseDoctor(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => Doctor::where('department_id', $request->department_id)->select('id', 'first_name', 'last_name', 'department_id', 'designation_id', 'image')->get()->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->first_name . ' ' . $doctor->last_name,
                    'image' => $doctor->image,
                    'department' => Department::select('name')->where('id', $doctor->department_id)->first(),
                    'designation' => Designation::select('name')->where('id', $doctor->designation_id)->first(),

                ];
            })
        ]);
    }

    public function slot(Request $request)
    {
        $request->validate([
            'date'         => 'required',
            'doctor_id'   => 'required',

        ]);
        $timeSlot = [];
        $data = Doctor::whereId($request->doctor_id)->select('id', 'consultation_duration')->with('doctorAppointmentSchedules')->first();

        $day = date('l', strtotime($request->date));  // date wise day show
        $timeSlot = $data->doctorAppointmentSchedules()->where('day',  $day)->get();

        if (empty($timeSlot[0])) {
            return response()->json(['status' => false, 'msg' => 'No time Slot Found!']);
        }
        $list = [];
        foreach ($timeSlot as $slot) {
            $list[] = [
                'start_time' => date("h.i A", strtotime($slot->start_time)),
                'end_time' => date("h.i A", strtotime($slot->end_time)),
                'id'    => $slot->id,
            ];
        }
        return response()->json(['status' => true, 'data' => $list]);
    }

    public function getSerialNumber($request)
    {
        $lastSerialNumber = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date ?? $request->appointment_date)
            ->where('doctor_appointment_schedule_id', $request->slot ?? $request->appointment_schedule_id)
            ->max('serial_number');
        return $lastSerialNumber ? $lastSerialNumber + 1 : 1;
    }

    public function storeAppointment(Request $request)
    {
        try {
            DB::beginTransaction();
            $data['invoice_number']                 = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
            $data['doctor_appointment_schedule_id'] = $request->appointment_schedule_id;
            $data['patient_id']             = $this->patient($request);
            $data['visitType']              = $request->checkReport == 'on' ? 'report' : 'regular';
            $data['doctor_id']              = $request->doctor_id;
            $data['doctor_fee']             = $request->doctor_fee; // o
            $data['appointment_date']       = $request->appointment_date;
            $data['appointment_priority']   = 'Normal';
            $data['payment_mode']           = "Due"; //payment method name
            $data['appointment_status']     = 'online';
            $data['payment_status']         = 'due';
            $data['date']                   =  now();
            $data['serial_number']          = $this->getSerialNumber($request);
            $data['discount_type']          = null;
            $data['discount']               = 0;
            $data['paid_amount']            = 0;
            $data['subtotal_amount']        = Str::replace(',', '', $request->doctor_fee);
            $data['total_amount']           = Str::replace(',', '', $request->doctor_fee);
            $data['due_amount']             =  $request->doctor_fee;
            $appointment = Appointment::create($data);

            DB::commit();
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'msg' => $ex->getMessage()]);
        }
        return response()->json(['status' => true, 'msg' => 'Data Created Successfully', 'data' => $appointment]);
    }
    public function getInvoiceNumber()
    {
        if (!Appointment::latest()->first()) {
            return 1;
        } else {
            return Appointment::latest()->first()->invoice_number + 1;
        }
    }

    public function serial_number($request)
    {
        $lastSerialNumber = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('doctor_appointment_schedule_id', $request->appointment_schedule)
            ->max('serial_number');
        return $lastSerialNumber ? $lastSerialNumber + 1 : 1;
    }

    function patient($request)
    {
        $data['patientId']          = (new InvoiceNumber)->invoice_num($this->getInvoiceNumber());
        $data['name']               = $request->p_name;
        $data['email']              = $request->p_email;
        $data['mobile']             = $request->p_mobile;
        // $data['emergency_contact']  = $request->p_emergency_contact;
        // $data['guardian_name']      = $request->p_guardian_name;
        // $data['gender']             = $request->p_gender;
        $data['dob']                = $request->p_dob;
        $data['age']                = $request->p_age;
        // $data['blood_group']        = $request->blood_group;
        // $data['marital_status']     = $request->marital_status;
        // $data['address']            = $request->address;
        $patient = Patient::create($data);
        return $patient->id;
    }
}
