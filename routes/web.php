<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkLeaveController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
// use App\Http\Controllers\RoleController;

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


    Route::controller(UserController::class)->group(function(){
        Route::get('/users','index')->name('users.index');
        Route::post('/users','store')->name('users.store');
        Route::put('/users/{id}','update')->name('users.update');
        Route::delete('/users/{id}','destroy')->name('users.destroy');
    });

     
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

    Route::get('/role', [RoleController::class, 'index'])->name('users.role');
    Route::post('/role',[RoleController::class, 'store'])->name('role.store');
    Route::put('/role/{id}',[RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}',[RoleController::class, 'destroy'])->name('roles.destroy');

// Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
// Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
// Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
// Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
// Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

//Route::delete('/role/{id}', [UserRoleController::class, 'destroy'])->name('role.destroy');
});

