<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkLeaveController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\LabOrderController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BirthReportController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\LabResultController;
use Illuminate\Support\Facades\Route;

// 🏥 Public Authentication Routes (Login, Register, Logout)

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🏥 Admin Panel Routes (Only accessible after login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // सही व्यू पथ सेट करें
    })->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}', [UserController::class, 'update']);

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Work Leaves Listing Page
    Route::get('/work-leaves', [WorkLeaveController::class, 'index'])->name('work-leaves.index');

    // Show Create Work Leave Form
    Route::get('/work-leaves/create', [WorkLeaveController::class, 'create'])->name('work-leaves.create');

    // Store New Work Leave
    Route::post('/work-leaves', [WorkLeaveController::class, 'store'])->name('work-leaves.store');

    // Show Single Work Leave Details
    Route::get('/work-leaves/{workLeave}', [WorkLeaveController::class, 'show'])->name('work-leaves.show');

    // Show Edit Work Leave Form
    Route::get('/work-leaves/{workLeave}/edit', [WorkLeaveController::class, 'edit'])->name('work-leaves.edit');

    // Update Work Leave
    Route::put('/work-leaves/{workLeave}', [WorkLeaveController::class, 'update'])->name('work-leaves.update');
    Route::patch('/work-leaves/{workLeave}', [WorkLeaveController::class, 'update'])->name('work-leaves.update');

    // Delete Work Leave
    Route::delete('/work-leaves/{workLeave}', [WorkLeaveController::class, 'destroy'])->name('work-leaves.destroy');


    // Patients Listing Page
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

    // Show Create Patient Form
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');

    // Store New Patient
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    // Show Single Patient Details
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    // Show Edit Patient Form
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');

    // Update Patient
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::patch('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');

    // Delete Patient
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

    

    // Departments Listing Page
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');

// Show Create Department Form
Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');

// Store New Department
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

// Show Single Department Details
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

// Show Edit Department Form
Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');

// Update Department
Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
Route::patch('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');

// Delete Department
Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');


// Doctor Routes
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');      // Show All Doctors
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create'); // Show Create Form
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');    // Store New Doctor
Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');  // Show Single Doctor
Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit'); // Show Edit Form
Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update'); // Update Doctor
Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy'); // Delete Doctor



Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
Route::post('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
// Route for deleting department
Route::delete('admin/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');



Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update'); // ✅ Corrected
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy'); // ✅ Corrected




Route::get('/beds', [BedController::class, 'index'])->name('beds.index'); 
Route::get('/beds/{id}/edit', [BedController::class, 'edit'])->name('beds.edit');

Route::post('/beds', [BedController::class, 'store'])->name('beds.store');
Route::put('/beds/{bed}', [BedController::class, 'update'])->name('beds.update'); 
Route::delete('/beds/{id}', [BedController::class, 'destroy'])->name('beds.destroy');



Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
Route::put('/visits/{visit}', [VisitController::class, 'update'])->name('visits.update');
Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');

// Admin Lab Orders Routes

Route::get('/lab_orders', [LabOrderController::class, 'index'])->name('lab_orders.index');
Route::post('/lab_orders', [LabOrderController::class, 'store'])->name('lab_orders.store');
Route::get('/lab_orders/{id}', [LabOrderController::class, 'show'])->name('lab_orders.show');
Route::put('/lab_orders/{id}', [LabOrderController::class, 'update'])->name('lab_orders.update');
Route::delete('/lab_orders/{id}', [LabOrderController::class, 'destroy'])->name('lab_orders.destroy');



    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index'); // लिस्ट दिखाएगा
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create'); // नया अपॉइंटमेंट बनाएगा
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store'); // अपॉइंटमेंट स्टोर करेगा
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show'); // डिटेल दिखाएगा
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit'); // एडिट करेगा
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update'); // अपडेट करेगा
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy'); // डिलीट करेगा

        Route::get('birth-reports', [BirthReportController::class, 'index'])->name('birth_reports.index');
        Route::post('birth-reports', [BirthReportController::class, 'store'])->name('birth_reports.store');
        Route::get('birth-reports/{id}/edit', [BirthReportController::class, 'edit'])->name('birth_reports.edit');
        Route::put('birth-reports/{id}', [BirthReportController::class, 'update'])->name('birth_reports.update');
        Route::delete('birth-reports/{id}', [BirthReportController::class, 'destroy'])->name('birth_reports.destroy');


        Route::get('lab_tests', [LabTestController::class, 'index'])->name('lab_tests.index');
        Route::post('lab_tests', [LabTestController::class, 'store'])->name('lab_tests.store');
        Route::get('lab_tests/{id}', [LabTestController::class, 'show'])->name('lab_tests.show');
        Route::get('lab_tests/{id}/edit', [LabTestController::class, 'edit'])->name('lab_tests.edit');
        Route::put('lab_tests/{id}', [LabTestController::class, 'update'])->name('lab_tests.update');
        Route::delete('lab_tests/{id}', [LabTestController::class, 'destroy'])->name('lab_tests.destroy');
    


        Route::get('/lab_results', [LabResultController::class, 'index'])->name('lab_results.index');
        Route::post('/lab_results', [LabResultController::class, 'store'])->name('lab_results.store');
        Route::get('/lab_results/{id}', [LabResultController::class, 'show'])->name('lab_results.show');
        Route::get('/lab_results/{id}/edit', [LabResultController::class, 'edit'])->name('lab_results.edit');
        Route::put('/lab_results/{id}', [LabResultController::class, 'update'])->name('lab_results.update');
        Route::delete('/lab_results/{id}', [LabResultController::class, 'destroy'])->name('lab_results.destroy');


});

    
