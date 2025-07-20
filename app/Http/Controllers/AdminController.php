<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use App\Models\Pharma;
use App\Models\Category;




class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Admin::withTrashed()
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->status == 'archived', function($query) {
                $query->onlyTrashed();
            })
            ->when($request->status == 'active', function($query) {
                $query->whereNull('deleted_at');
            })
            ->when($request->status == 'super_admin', function($query) {
                $query->where('role', 'super_admin')->whereNull('deleted_at');
            })
            ->when($request->status == 'admin', function($query) {
                $query->where('role','admin')->whereNull('deleted_at');
            })
            ->orderBy('deleted_at')
            ->orderBy('id', 'desc');

        $admins = $query->paginate(10);

        return view('admin.admins', compact('admins'));
    }


//Admin updated
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,'.$admin->id,
            'password' => 'nullable|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $admin->update($updateData);

        return back()->with('success', 'Admin updated successfully');
    }

//Admin deleted 
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->back()->with('success','Admin deleted successfully');
    }

    //Admin created
       public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    public function chart()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalSpecializations = Specialization::count();
        $totalAppointments = Appointment::count();
        $totalMedicines = Pharma::count();
        $totalCategories = Category::count();

        $specializationCounts = Specialization::withCount('doctors')
            ->get()
            ->map(function ($specialization) {
                return [
                    'name' => $specialization->name,
                    'count' => $specialization->doctors_count,
                ];
            });

        $topSpecializations = Specialization::withCount('doctors')
            ->orderByDesc('doctors_count')
            ->take(5)
            ->get()
            ->map(function ($specialization) {
                return [
                    'name' => $specialization->name,
                    'count' => $specialization->doctors_count,
                ];
            });

        $medicinesByCategory = Category::withCount('pharma')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->pharma_count,
                ];
            });

        $medicineSales = Pharma::select('name', 'price', 'quantity')
            ->orderBy('price', 'desc')
            ->take(10)
            ->get()
            ->map(function ($medicine) {
                return [
                    'name' => $medicine->name,
                    'total_sales' => $medicine->price * $medicine->quantity,
                    'quantity' => $medicine->quantity
                ];
            });

        // Pass all data to the view
        return view('admin.chart', compact(
            'totalUsers',
            'totalDoctors',
            'totalSpecializations',
            'totalAppointments',
            'totalMedicines',
            'totalCategories',
            'specializationCounts',
            'topSpecializations',
            'medicinesByCategory',
            'medicineSales'
        ));
    }
    //admin Appointment updated
    public function updateAppointment(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->payment_status = $request->payment_status;
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment updated successfully.');
    }


    // ADMIN retrieved 
    public function restore($id)
    {
        $admin = Admin::withTrashed()->findOrFail($id);
        $admin->restore();

        return redirect()->route('admins.index')->with('success', 'Administrator successfully retrieved');
    }
    // تعديل بيانات مريض
    // public function editPatient($id)
    // {
    //     $patient = User::findOrFail($id);
    //     return view('admin.patients', compact('patient'));
    // }

    // // حذف مريض
    // public function destroyPatient($id)
    // {
    //     $patient = User::findOrFail($id);
    //     $patient->delete();

    //     return redirect()->back()->with('success', 'تم حذف المريض بنجاح.');
    // }
 
    /**
     * Update the user's profile information.
     */
    

   

   

}
