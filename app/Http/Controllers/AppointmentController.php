<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Doctor;
use App\Models\DoctorUnavailability;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('doctor', 'patient')->paginate(10);
        $doctors = Doctor::all(); // Assuming you have a Doctor model
        $patients = Patient::all(); // Assuming you have a Patient model

        return view('admin.appointments', compact('appointments', 'doctors', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the request
            $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
            ]);

            // Convert time to proper format
            $time = date('H:i:s', strtotime($request->appointment_time));
            
            // For authenticated users
            if (Auth::check()) {
                $user = Auth::user();
                $patient = Patient::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $user->name,
                        'phone' => $user->phone ?? '',
                        'email' => $user->email
                    ]
                );

                // Check for existing appointment at the same time
                $existingAppointment = Appointment::where('patient_id', $patient->id)
                    ->where('appointment_date', $request->appointment_date)
                    ->where('appointment_time', $time)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->first();

                if ($existingAppointment) {
                    DB::rollBack();
                    $doctorName = $existingAppointment->doctor->name;
                    $warningMessage = $existingAppointment->doctor_id == $request->doctor_id 
                        ? "Warning! You already have an appointment with Dr. $doctorName at this time. Please choose another time slot."
                        : "Warning! You already have an appointment with Dr. $doctorName at this time. You cannot book two appointments at the same time.";
                    
                    return response()->json([
                        'warning' => $warningMessage
                    ]);
                }

                $patientId = $patient->id;
            } else {
                // For admin-created appointments
                $request->validate(['patient_id' => 'required|exists:patients,id']);
                $patientId = $request->patient_id;
            }

            // Create the appointment
            $appointment = Appointment::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $patientId,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $time,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'source' => Auth::check() ? 'website' : 'admin'
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully! We will contact you soon for confirmation.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while booking the appointment. Please try again.'
            ], 500);
        }
    }

    public function doctorStore(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'sometimes|in:pending,confirmed,canceled,completed'
        ]);

        try {
            DB::beginTransaction();

            // First, find or create the patient
            $patient = Patient::firstOrCreate(
                ['phone' => $request->patient_phone],
                ['name' => $request->patient_name]
            );

            // Check for existing appointment at the same time
            $existingAppointment = Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();

            if ($existingAppointment) {
                DB::rollBack();
                $doctorName = $existingAppointment->doctor->name;
                $warningMessage = $existingAppointment->doctor_id == $request->doctor_id 
                    ? "Warning! You already have an appointment with Dr. $doctorName at this time. Please choose another time slot."
                    : "Warning! You already have an appointment with Dr. $doctorName at this time. You cannot book two appointments at the same time.";
                
                return response()->json([
                    'success' => false,
                    'message' => $warningMessage
                ], 422);
            }

            // Create the appointment
            $appointment = Appointment::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $patient->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => $request->status ?? 'confirmed',
                'payment_status' => 'unpaid',
                'source' => 'doctor_portal'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'appointment' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while booking the appointment: ' . $e->getMessage()
            ], 500);
        }
    }

       public function rules()
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'nullable|exists:patients,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,confirmed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
        ];
    }

    public function update(Request $request, Appointment $appointmentId)
    {
        $previousStatus = $appointmentId->status;
        $newStatus = $request->status;

        // Update the appointment status
        $appointmentId->update(['status' => $newStatus]);

        if ($newStatus === 'confirmed' && $previousStatus !== 'confirmed') {
            // Add to unavailabilities only if it wasn't already confirmed
            DoctorUnavailability::create([
                'doctor_id' => $appointmentId->doctor_id,
                'date' => $appointmentId->appointment_date,
                'start_time' => $appointmentId->appointment_time,
            ]);
        }
        elseif ($newStatus === 'canceled' && $previousStatus === 'confirmed') {
            // Only remove from unavailabilities if it was previously confirmed
            DoctorUnavailability::where([
                'doctor_id' => $appointmentId->doctor_id,
                'date' => $appointmentId->appointment_date,
                'start_time' => $appointmentId->appointment_time,
            ])->delete();
        }

        $message = match($newStatus) {
            'confirmed' => 'Appointment confirmed successfully.',
            'canceled' => 'Appointment canceled successfully.',
            default => 'Appointment status updated successfully.'
        };

        return back()->with('success', $message);
    }

    
    /**
     * Show the form for creating a new appointment for public users
     */
    public function publicCreate()
    {
        $doctors = Doctor::where('status', 'active')->get();
        return view('public.appointments.create', compact('doctors'));
    }

    /**
     * Display user's appointments
     */
    public function myAppointments()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();
 // ليش بس اشيل ال بعطيني خطء      $user = Auth::user(); 
// وهاي بتجيب بس الي داخل الجلسه الحالي يعني .
        if ($patient) {
            $appointments = Appointment::where('patient_id', $patient->id)
                ->with('doctor')
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->get();
        } else {
            $appointments = collect(); // Empty collection if patient record not found
        }
        
        return view('public.appointments.my-appointments', compact('appointments'));
    }
    
    /**
     * Cancel an appointment
     */
    public function cancelAppointment(Appointment $appointment)
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        
        // Check if user is the owner of the appointment
        if (!$patient || $appointment->patient_id != $patient->id) {
            return redirect()->route('my.appointments')->with('error', 'غير مسموح لك بإلغاء هذا الموعد');
        }
        
        // Check if appointment is in 'pending' status
        if ($appointment->status != 'pending') {
            return redirect()->route('my.appointments')->with('error', 'لا يمكن إلغاء هذا الموعد في وضعه الحالي');
        }
        
        // Cancel the appointment
        $appointment->update(['status' => 'canceled']);
        
        return redirect()->route('my.appointments')->with('success', 'تم إلغاء الموعد بنجاح');
    }
    /**
 * Remove the specified appointment from storage.
 */
public function destroy(Appointment $appointment)
{
    try {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'تم حذف الموعد بنجاح.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'حدث خطأ أثناء محاولة الحذف.');
    }
}

}
