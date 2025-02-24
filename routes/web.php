<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkLeaveController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\UserRoleController;

// 🏥 Public Authentication Routes (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🏥 Admin Panel Routes (Only accessible after login)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
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

//Roles Route
Route::controller(UserRoleController::class)->group(function(){
    Route::get('/role','index')->name('users.role');
    Route::post('/role','store')->name('role.store');
    Route::delete('/role/{id}','destroy')->name('roles.destroy');
});

});

