<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DoctorsPageController;
use App\Http\Controllers\HomeController;
use App\Models\Subscription;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PharmaController;
use App\Http\Controllers\Admin\PharmaController_Admin;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\OrderController;

// Public Routes
Route::get('/welcome', function () {
    return view('public.welcome');
})->name('welcome');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

// Route::get('/doctor', function () {
//     return view('public.doctor');
// })->name('doctor');

Route::get('/doctors', [DoctorsPageController::class, 'index'])->name('doctors');

Route::get('/doctors/{id}', [DoctorsPageController::class, 'show'])->name('doctor');

// Add GET route for appointments page
Route::get('/appointments', [AppointmentController::class, 'publicCreate'])->name('appointments.create');
Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->middleware('auth')->name('my.appointments');
Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancelAppointment'])->middleware('auth')->name('appointments.cancel');


/**
 * Admin Routes
 */
// Guest (unauthenticated) admin routes
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    // Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

});

// Authenticated admin routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'chart'])->name('admin.dashboard');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

 Route::get('/patients/{id}/edit', [AdminController::class, 'editPatient'])->name('admin.patients.edit');
    Route::delete('/patients/{id}', [AdminController::class, 'destroyPatient'])->name('admin.patients.destroy');

Route::put('/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('appointments.update');


    // Resource controllers
    Route::resource('admins', AdminController::class);
    Route::post('admins/{id}/restore', [AdminController::class, 'restore'])->name('admins.restore');

    Route::resource('specializations', SpecializationController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy'
    ]);


    // Doctor routes with additional custom routes
    Route::resource('doctors', DoctorController::class);
    Route::patch('/doctors/{doctor}/status', [DoctorController::class, 'updateStatus'])
        ->name('doctors.update-status');

    Route::get('/chart', [AdminController::class, 'chart'])->name('admin.chart');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('subscriptions', SubscriptionController::class)->names([
        'index' => 'admin.subscriptions.index',
        'create' => 'admin.subscriptions.create',
        'store' => 'admin.subscriptions.store',
        'show' => 'admin.subscriptions.show',
        'edit' => 'admin.subscriptions.edit',
        'update' => 'admin.subscriptions.update',
        'destroy' => 'admin.subscriptions.destroy'
    ]);

    // Pharma Admin Routes
Route::prefix('pharmacies')->name('pharmacies.')->group(function () {
    Route::get('/', [PharmaController_Admin::class, 'index'])->name('index');
    Route::get('/create', [PharmaController_Admin::class, 'create'])->name('create');
    Route::post('/', [PharmaController_Admin::class, 'store'])->name('store');
    Route::get('/{pharmacy}', [PharmaController_Admin::class, 'show'])->name('show');
    Route::get('/{pharmacy}/edit', [PharmaController_Admin::class, 'edit'])->name('edit');
    Route::put('/{pharmacy}', [PharmaController_Admin::class, 'update'])->name('update');
    Route::delete('/{pharmacy}', [PharmaController_Admin::class, 'destroy'])->name('destroy');
    Route::patch('/{pharmacy}/status', [PharmaController_Admin::class, 'updateStatus'])->name('update-status');
});

    // Medicine routes
    Route::prefix('medicines')->name('medicines.')->group(function () {
        Route::get('/', [PharmaController_Admin::class, 'index'])->name('index');
        Route::get('/create', [PharmaController_Admin::class, 'create'])->name('create');
        Route::post('/', [PharmaController_Admin::class, 'store'])->name('store');
        Route::get('/{medicine}/edit', [PharmaController_Admin::class, 'edit'])->name('edit');
        Route::put('/{medicine}', [PharmaController_Admin::class, 'update'])->name('update');
        Route::delete('/{medicine}', [PharmaController_Admin::class, 'destroy'])->name('destroy');
    });
});
/**
 * Doctor Routes
 */

// Authenticated doctor routes
Route::prefix('doctor')->middleware('doctor')->group(function () {
    Route::get('/dashboard', [DoctorAuthController::class, 'show'])->name('doctor.dashboard');
    Route::get('/index', [DoctorAuthController::class, 'show'])->name('doctor.index');
    Route::put('/appointments/{appointmentId}/update', [AppointmentController::class , 'update'])->name('doctor.appointments.update');
    Route::post('/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');
    Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/{doctor}', [DoctorController::class, 'update'])->name('doctors.updateDoctor');
    Route::put('/{doctor}/password', [DoctorController::class, 'updatePassword'])->name('doctors.updatePassword');
    Route::post('/appointments', [AppointmentController::class, 'doctorStore'])
    ->name('doctor.appointments.store');
});
Route::post('/subscription/process', [SubscriptionController::class, 'processSubscription'])->name('doctor.subscription.process');



// Guest (unauthenticated) doctor routes
Route::middleware('guest:doctor')->group(function () {
    // Route::get('/doctor/register', [DoctorAuthController::class, 'create'])->name('register.doctor');
    // Route::post('/doctor/register', [DoctorAuthController::class, 'store'])->name('register.doctor.store');
    Route::get('/doctor/login', [DoctorAuthController::class, 'showLogin'])->name('doctor.login');
    Route::post('/doctor/appointments/{id}/cancel', [DoctorAuthController::class, 'cancelAppointment'])->name('doctor.appointments.cancel');

    Route::post('/doctor/login', [DoctorAuthController::class, 'login'])->name('doctor.login.submit');
});

/**
 * User Routes
 */
Route::middleware('auth')->group(function () {
    // Route::view('/profile', 'public.profile')->name('profile');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

// Authentication routes
require __DIR__.'/auth.php';



//mootaz///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/order-items', [PharmaController::class, 'allOrderItems'])->name('order.items');
Route::get('/pharma', [PharmaController::class, 'index'])->name('pharma.index');
Route::get('/pharma/{id}/add-to-cart', [PharmaController::class, 'addToCart'])->name('pharma.addToCart');
Route::get('/cart', [PharmaController::class, 'cart'])->name('cart.index');
Route::get('/cart/remove/{id}', [PharmaController::class, 'removeFromCart'])->name('pharma.removeFromCart');
Route::post('/order', [PharmaController::class, 'createOrder'])->name('order.create');
Route::get('/pharma/search', [PharmaController::class, 'search'])->name('pharma.search');
Route::post('/cart/increase/{id}', [PharmaController::class, 'increaseQuantity'])->name('pharma.increaseQuantity');
Route::post('/cart/decrease/{id}', [PharmaController::class, 'decreaseQuantity'])->name('pharma.decreaseQuantity');
Route::post('/place-order', [PharmaController::class, 'placeOrder'])->name('pharma.placeOrder');
Route::get('/cart/count', [PharmaController::class, 'getCartCount'])->name('cart.count');

// Agregar la ruta que falta para categorías de farmacia
Route::get('/pharma/categories', [PharmaController::class, 'categories'])->name('pharma.categories');

Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis');
Route::post('/predict', [DiagnosisController::class, 'predict'])->name('predict');

Route::get('/order/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');

// Route::get('/admin/logout', function () {
//     Auth::guard('admin')->logout();
//     session()->invalidate();
//     session()->regenerateToken();
//     return redirect('/admin/login');
// })->name('admin.logout');
//     <a href="{{ route('admin.logout') }}">تسجيل الخروج</a>