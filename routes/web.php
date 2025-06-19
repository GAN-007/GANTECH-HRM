<?php


use App\Http\Controllers\AccountListController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\AnnouncementController;
// use App\Http\Controllers\EmployeeSocialProfileController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssignRoleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CalendarableController;
use App\Http\Controllers\ClientAutoUpdateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientInvoiceController;
use App\Http\Controllers\ClientProjectController;
use App\Http\Controllers\ClientTaskController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DeveloperSectionController;
use App\Http\Controllers\DynamicDependent;
use App\Http\Controllers\EmployeeAssignedController;
use App\Http\Controllers\EmployeeAwardController;
use App\Http\Controllers\EmployeeBankAccountController;
use App\Http\Controllers\EmployeeComplaintController;
use App\Http\Controllers\EmployeeContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\EmployeeImmigrationController;
use App\Http\Controllers\EmployeeLeaveController;
use App\Http\Controllers\EmployeePayslipController;
use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\EmployeePromotionController;
use App\Http\Controllers\EmployeeQualificationController;
use App\Http\Controllers\EmployeeTaskController;
use App\Http\Controllers\EmployeeTicketController;
use App\Http\Controllers\EmployeeTrainingController;
use App\Http\Controllers\EmployeeTransferController;
use App\Http\Controllers\EmployeeTravelController;
use App\Http\Controllers\EmployeeWarningController;
use App\Http\Controllers\EmployeeWorkExperienceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FinanceDepositController;
use App\Http\Controllers\FinanceExpenseController;
use App\Http\Controllers\FinancePayeeController;
use App\Http\Controllers\FinancePayerController;
use App\Http\Controllers\FinanceTransactionsController;
use App\Http\Controllers\FinanceTransferController;
use App\Http\Controllers\FrontEnd\AboutController;
use App\Http\Controllers\FrontEnd\ContactController;
use App\Http\Controllers\FrontEnd\HomeController;
use App\Http\Controllers\FrontEnd\JobController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\EmployeeLeaveTypeDetailController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IPSettingController;
use App\Http\Controllers\JobCandidateController;
use App\Http\Controllers\JobInterviewController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LanguageSettingController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\OfficeShiftController;
use App\Http\Controllers\OfficialDocumentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\Performance\AppraisalController;
use App\Http\Controllers\Performance\GoalTrackingController;
use App\Http\Controllers\Performance\GoalTypeController;
use App\Http\Controllers\Performance\IndicatorController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProjectBugController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDiscussionController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RouteClosureHandlerController;
use App\Http\Controllers\SalaryAllowanceController;
use App\Http\Controllers\SalaryBasicController;
use App\Http\Controllers\SalaryCommissionController;
use App\Http\Controllers\SalaryDeductionController;
use App\Http\Controllers\SalaryLoanController;
use App\Http\Controllers\SalaryOtherPaymentController;
use App\Http\Controllers\SalaryOvertimeController;
use App\Http\Controllers\SupportTicketCommentController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskDiscussionController;
use App\Http\Controllers\TaskFileController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingListController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\Variables\AssetCategoryController;
use App\Http\Controllers\Variables\AwardTypeController;
use App\Http\Controllers\Variables\DocumentTypeController;
use App\Http\Controllers\Variables\ExpenseTypeController;
use App\Http\Controllers\Variables\FileManagerSettingController;
use App\Http\Controllers\Variables\JobCategoryController;
use App\Http\Controllers\Variables\LeaveTypeController;
use App\Http\Controllers\Variables\PaymentMethodController;
use App\Http\Controllers\Variables\QualificationEducationLevelController;
use App\Http\Controllers\Variables\QualificationLanguageController;
use App\Http\Controllers\Variables\QualificationSkillController;
use App\Http\Controllers\Variables\StatusTypeController;
use App\Http\Controllers\Variables\TaxTypeController;
use App\Http\Controllers\Variables\TerminationTypeController;
use App\Http\Controllers\Variables\TrainingTypeController;
use App\Http\Controllers\Variables\TravelMethodController;
use App\Http\Controllers\Variables\VariableController;
use App\Http\Controllers\Variables\VariableMethodController;
use App\Http\Controllers\Variables\WarningTypeController;
use App\Http\Controllers\WarningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Addon\BiometricAddonController;
use App\Http\Controllers\Addon\SaasController;
use Laravel\Socialite\Facades\Socialite;

Auth::routes(['register' => false]);

Route::prefix('addons')->group(function () {

    Route::get('/', function () {
        return view('addons.index');
    })->name('addons');

    Route::controller(BiometricAddonController::class)->group(function () {
        Route::prefix('biometric')->group(function () {
            Route::get('install/step-1', 'biometricInstallStep1')->name('biometric-install-step-1');
            Route::get('install/step-2', 'biometricInstallStep2')->name('biometric-install-step-2');
            Route::get('install/step-3', 'biometricInstallStep3')->name('biometric-install-step-3');
            Route::post('install/process', 'biometricInstallProcess')->name('biometric-install-process');
            Route::get('install/step-4', 'biometricInstallStep4')->name('biometric-install-step-4');
        });
    });

    Route::controller(SaasController::class)->group(function () {
        Route::prefix('saas')->group(function () {
            Route::get('install/step-1', 'saasInstallStep1')->name('saas-install-step-1');
            Route::get('install/step-2', 'saasInstallStep2')->name('saas-install-step-2');
            Route::get('install/step-3', 'saasInstallStep3')->name('saas-install-step-3');
            Route::post('install/process', 'saasInstallProcess')->name('saas-install-process');
            Route::get('install/step-4', 'saasInstallStep4')->name('saas-install-step-4');
        });
    });
});


Route::group(['middleware' => ['XSS']], function () {

    Route::get('/pdf', function () {
        return view('pdf');
    });

    Route::get('/', [RouteClosureHandlerController::class, 'redirectToLogin'])->name('redirectToLogin');

    Route::get('/home', [HomeController::class, 'index'])->name('home.front');
    Route::get('/about', [AboutController::class, 'index'])->name('about.front');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.front');

    Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
    Route::get('/jobs/details/{job_post}', [JobController::class, 'details'])->name('jobs.details');
    Route::get('/jobs/search/category/{url}', [JobController::class, 'searchByCategory'])->name('jobs.searchByCategory');
    Route::get('/jobs/search/job_type/{job_type}', [JobController::class, 'searchByJobType'])->name('jobs.searchByJobType');
    Route::post('/jobs/apply/{job}', [JobController::class, 'applyForJob'])->name('jobs.apply');

    Route::get('markAsRead', [RouteClosureHandlerController::class, 'markAsReadNotification'])->name('markAsRead');
    Route::get('/all/notifications', [RouteClosureHandlerController::class, 'allNotifications'])->name('seeAllNoti');
    Route::get('clearAll', [RouteClosureHandlerController::class, 'clearAll'])->name('clearAll');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [DashboardController::class, 'profile_update'])->name('profile_update');
    Route::post('/profile/employee/{id}', [DashboardController::class, 'employeeProfileUpdate'])->name('employee_profile_update');
    Route::post('/profile/change_password/{id}', [DashboardController::class, 'change_password'])->name('change_password');

    // Languages Section
    Route::prefix('languages')->group(function () {
        Route::get('/{language}/translations', [LanguageSettingController::class, 'index'])->name('languages.translations.index');
        // Route::get('/{language}', [LanguageSettingController::class, 'index'])->name('languages.translations.index');
        Route::post('/update', [LanguageSettingController::class, 'update'])->name('language.translations.update');
        Route::get('/create', [LanguageSettingController::class, 'create'])->name('languages.create');
        Route::post('/store', [LanguageSettingController::class, 'store'])->name('languages.store');
        Route::get('/switch/{lang}', [LanguageSettingController::class, 'languageSwitch'])->name('language.switch');
        Route::get('/delete', [LanguageSettingController::class, 'languageDelete'])->name('language.delete');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::group(['prefix' => 'employee', 'as' => 'employee.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('EmployeeDashboard');
    });

    Route::group(['prefix' => 'client', 'as' => 'client.', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'clientDashboard'])->name('ClientDashboard');
    });

    Route::get('/users-list', [AllUserController::class, 'index'])->name('users-list');
    Route::post('/user-add', [AllUserController::class, 'add_user_process'])->name('add-user');
    Route::get('/user-login-info', [AllUserController::class, 'login_info'])->name('login-info');
    Route::get('/user_roles', [AllUserController::class, 'user_roles'])->name('user-roles');
    Route::get('/user/edit/{id}', [AllUserController::class, 'edit'])->name('edit_user');
    Route::post('/update-user', [AllUserController::class, 'process_update'])->name('update-user');
    Route::get('/user/delete/{id}', [AllUserController::class, 'delete_user'])->name('delete_user');
    Route::post('/user-mass-delete', [AllUserController::class, 'delete_by_selection'])->name('delete_by_selection');
    Route::post('/assign_role/{user}', [AssignRoleController::class, 'update'])->name('assign_role');
    Route::post('/mass_assign', [AssignRoleController::class, 'mass_update'])->name('mass_assign_role');

    Route::prefix('staff')->group(function () {

        Route::prefix('employees')->group(function () {
            Route::resource('/', EmployeeController::class)->names([
                'index' => 'employees.index',
                'store' => 'employees.store',
            ]);
            Route::get('{employee}', [EmployeeController::class, 'show'])->name('employees.show');
            Route::post('update', [EmployeeController::class, 'update'])->name('employees.update');
            Route::get('{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');
            Route::post('delete/selected', [EmployeeController::class, 'delete_by_selection'])->name('mass_delete_employees');
            Route::get('page/import', [EmployeeController::class, 'import'])->name('employees.import');
            Route::post('page/import', [EmployeeController::class, 'importPost'])->name('employees.importPost');
            Route::get('filter', [EmployeeController::class, 'employeesFilter'])->name('employees.filter');
            Route::get('pdf/{id}', [EmployeeController::class, 'employeePDF'])->name('employees.pdf');
            Route::post('{employee}/pension_update', [EmployeeController::class, 'employeesPensionUpdate'])->name('employees.pension_update');
            Route::post('{employee}/infoUpdate', [EmployeeController::class, 'infoUpdate'])->name('employees_basicInfo.update');
        });

        Route::prefix('immigrations')->group(function () {
            Route::get('/', [EmployeeImmigrationController::class, 'index'])->name('immigrations.index');
            Route::get('{id}/edit', [EmployeeImmigrationController::class, 'edit'])->name('immigrations.edit');
            Route::get('{employee}', [EmployeeImmigrationController::class, 'show'])->name('immigrations.show');
            Route::post('update', [EmployeeImmigrationController::class, 'update'])->name('immigrations.update');
            Route::post('{employee}/store', [EmployeeImmigrationController::class, 'store'])->name('immigrations.store');
            Route::get('{id}/delete', [EmployeeImmigrationController::class, 'destroy'])->name('immigrations.destroy');
            Route::get('document/download/{id}', [EmployeeImmigrationController::class, 'download'])->name('immigrations_document.download');
        });
        // End

        Route::get('contacts', [EmployeeContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{id}/edit', [EmployeeContactController::class, 'edit'])->name('contacts.edit');
        Route::get('contacts/{employee}', [EmployeeContactController::class, 'show'])->name('contacts.show');
        Route::post('contacts/update', [EmployeeContactController::class, 'update'])->name('contacts.update');
        Route::post('contacts/{employee}/store', [EmployeeContactController::class, 'store'])->name('contacts.store');
        Route::get('contacts/{id}/delete', [EmployeeContactController::class, 'destroy'])->name('contacts.destroy');

        // check - EmployeeSocialProfileController
        Route::get('social_profile/{employee}', [EmployeeSocialProfileController::class, 'show'])->name('social_profile.show');
        Route::post('social_profile/{employee}/store', [EmployeeController::class, 'storeSocialInfo'])->name('social_profile.store');

        Route::post('profile_picture/{employee}/store', [EmployeeController::class, 'storeProfilePicture'])->name('profile_picture.store');

        Route::get('documents', [EmployeeDocumentController::class, 'index'])->name('documents.index');
        Route::get('documents/{id}/edit', [EmployeeDocumentController::class, 'edit'])->name('documents.edit');
        Route::get('documents/{employee}', [EmployeeDocumentController::class, 'show'])->name('documents.show');
        Route::post('documents/update', [EmployeeDocumentController::class, 'update'])->name('documents.update');
        Route::post('documents/{employee}/store', [EmployeeDocumentController::class, 'store'])->name('documents.store');
        Route::get('documents/{id}/delete', [EmployeeDocumentController::class, 'destroy'])->name('documents.destroy');
        Route::get('documents/document/download/{id}', [EmployeeDocumentController::class, 'download'])->name('documents_document.download');

        Route::get('qualifications', [EmployeeQualificationController::class, 'index'])->name('qualifications.index');
        Route::get('qualifications/{id}/edit', [EmployeeQualificationController::class, 'edit'])->name('qualifications.edit');
        Route::get('qualifications/{employee}', [EmployeeQualificationController::class, 'show'])->name('qualifications.show');
        Route::post('qualifications/update', [EmployeeQualificationController::class, 'update'])->name('qualifications.update');
        Route::post('qualifications/{employee}/store', [EmployeeQualificationController::class, 'store'])->name('qualifications.store');
        Route::get('qualifications/{id}/delete', [EmployeeQualificationController::class, 'destroy'])->name('qualifications.destroy');

        Route::get('work_experience', [EmployeeWorkExperienceController::class, 'index'])->name('work_experience.index');
        Route::get('work_experience/{id}/edit', [EmployeeWorkExperienceController::class, 'edit'])->name('work_experience.edit');
        Route::get('work_experience/{employee}', [EmployeeWorkExperienceController::class, 'show'])->name('work_experience.show');
        Route::post('work_experience/update', [EmployeeWorkExperienceController::class, 'update'])->name('work_experience.update');
        Route::post('work_experience/{employee}/store', [EmployeeWorkExperienceController::class, 'store'])->name('work_experience.store');
        Route::get('work_experience/{id}/delete', [EmployeeWorkExperienceController::class, 'destroy'])->name('work_experience.destroy');

        Route::get('bank_account', [EmployeeBankAccountController::class, 'index'])->name('bank_account.index');
        Route::get('bank_account/{id}/edit', [EmployeeBankAccountController::class, 'edit'])->name('bank_account.edit');
        Route::get('bank_account/{employee}', [EmployeeBankAccountController::class, 'show'])->name('bank_account.show');
        Route::post('bank_account/update', [EmployeeBankAccountController::class, 'update'])->name('bank_account.update');
        Route::post('bank_account/{employee}/store', [EmployeeBankAccountController::class, 'store'])->name('bank_account.store');
        Route::get('bank_account/{id}/delete', [EmployeeBankAccountController::class, 'destroy'])->name('bank_account.destroy');

        Route::post('employees/{employee}/storeSalary', [EmployeeController::class, 'storeSalary'])->name('employees_basicSalary.store');

        Route::get('salary_basic', [SalaryBasicController::class, 'index'])->name('salary_basic.index');
        Route::get('salary_basic/{employee}', [SalaryBasicController::class, 'show'])->name('salary_basic.show');
        Route::post('salary_basic/{employee}/store', [SalaryBasicController::class, 'store'])->name('salary_basic.store');
        Route::get('salary_basic/{id}/edit', [SalaryBasicController::class, 'edit'])->name('salary_basic.edit');
        Route::post('salary_basic/update', [SalaryBasicController::class, 'update'])->name('salary_basic.update');
        Route::get('salary_basic/{id}/delete', [SalaryBasicController::class, 'destroy'])->name('salary_basic.destroy');

        Route::get('salary_allowance', [SalaryAllowanceController::class, 'index'])->name('salary_allowance.index');
        Route::get('salary_allowance/{id}/edit', [SalaryAllowanceController::class, 'edit'])->name('salary_allowance.edit');
        Route::get('salary_allowance/{employee}', [SalaryAllowanceController::class, 'show'])->name('salary_allowance.show');
        Route::post('salary_allowance/update', [SalaryAllowanceController::class, 'update'])->name('salary_allowance.update');
        Route::post('salary_allowance/{employee}/store', [SalaryAllowanceController::class, 'store'])->name('salary_allowance.store');
        Route::get('salary_allowance/{id}/delete', [SalaryAllowanceController::class, 'destroy'])->name('salary_allowance.destroy');

        Route::get('salary_commission', [SalaryCommissionController::class, 'index'])->name('salary_commission.index');
        Route::get('salary_commission/{id}/edit', [SalaryCommissionController::class, 'edit'])->name('salary_commission.edit');
        Route::get('salary_commission/{employee}', [SalaryCommissionController::class, 'show'])->name('salary_commission.show');
        Route::post('salary_commission/update', [SalaryCommissionController::class, 'update'])->name('salary_commission.update');
        Route::post('salary_commission/{employee}/store', [SalaryCommissionController::class, 'store'])->name('salary_commission.store');
        Route::get('salary_commission/{id}/delete', [SalaryCommissionController::class, 'destroy'])->name('salary_commission.destroy');

        Route::get('salary_loan', [SalaryLoanController::class, 'index'])->name('salary_loan.index');
        Route::get('salary_loan/{id}/edit', [SalaryLoanController::class, 'edit'])->name('salary_loan.edit');
        Route::get('salary_loan/{employee}', [SalaryLoanController::class, 'show'])->name('salary_loan.show');
        Route::post('salary_loan/update', [SalaryLoanController::class, 'update'])->name('salary_loan.update');
        Route::post('salary_loan/{employee}/store', [SalaryLoanController::class, 'store'])->name('salary_loan.store');
        Route::get('salary_loan/{id}/delete', [SalaryLoanController::class, 'destroy'])->name('salary_loan.destroy');

        Route::get('salary_deduction', [SalaryDeductionController::class, 'index'])->name('salary_deduction.index');
        Route::get('salary_deduction/{id}/edit', [SalaryDeductionController::class, 'edit'])->name('salary_deduction.edit');
        Route::get('salary_deduction/{employee}', [SalaryDeductionController::class, 'show'])->name('salary_deduction.show');
        Route::post('salary_deduction/update', [SalaryDeductionController::class, 'update'])->name('salary_deduction.update');
        Route::post('salary_deduction/{employee}/store', [SalaryDeductionController::class, 'store'])->name('salary_deduction.store');
        Route::get('salary_deduction/{id}/delete', [SalaryDeductionController::class, 'destroy'])->name('salary_deduction.destroy');

        Route::get('other_payment', [SalaryOtherPaymentController::class, 'index'])->name('other_payment.index');
        Route::get('other_payment/{id}/edit', [SalaryOtherPaymentController::class, 'edit'])->name('other_payment.edit');
        Route::get('other_payment/{employee}', [SalaryOtherPaymentController::class, 'show'])->name('other_payment.show');
        Route::post('other_payment/update', [SalaryOtherPaymentController::class, 'update'])->name('other_payment.update');
        Route::post('other_payment/{employee}/store', [SalaryOtherPaymentController::class, 'store'])->name('other_payment.store');
        Route::get('other_payment/{id}/delete', [SalaryOtherPaymentController::class, 'destroy'])->name('other_payment.destroy');

        Route::get('salary_overtime', [SalaryOvertimeController::class, 'index'])->name('salary_overtime.index');
        Route::get('salary_overtime/{id}/edit', [SalaryOvertimeController::class, 'edit'])->name('salary_overtime.edit');
        Route::get('salary_overtime/{employee}', [SalaryOvertimeController::class, 'show'])->name('salary_overtime.show');
        Route::post('salary_overtime/update', [SalaryOvertimeController::class, 'update'])->name('salary_overtime.update');
        Route::post('salary_overtime/{employee}/store', [SalaryOvertimeController::class, 'store'])->name('salary_overtime.store');
        Route::get('salary_overtime/{id}/delete', [SalaryOvertimeController::class, 'destroy'])->name('salary_overtime.destroy');

        Route::get('employee_leave/{employee}', [EmployeeLeaveController::class, 'index'])->name('employee_leave.index');
        Route::get('employee_leave/details', [EmployeeLeaveController::class, 'details'])->name('employee_leave.details');
        Route::get('employee_leave/details/{id}', [EmployeeLeaveController::class, 'show'])->name('employee_leave.show');

        Route::get('employee_award/{employee}', [EmployeeAwardController::class, 'index'])->name('employee_award.index');
        Route::get('employee_award/details', [EmployeeAwardController::class, 'details'])->name('employee_award.details');
        Route::get('employee_award/details/{id}', [EmployeeAwardController::class, 'show'])->name('employee_award.show');

        Route::get('employee_travel/{employee}', [EmployeeTravelController::class, 'index'])->name('employee_travel.index');
        Route::get('employee_travel/details', [EmployeeTravelController::class, 'details'])->name('employee_travel.details');
        Route::get('employee_travel/details/{id}', [EmployeeTravelController::class, 'show'])->name('employee_travel.show');

        Route::get('employee_training/{employee}', [EmployeeTrainingController::class, 'index'])->name('employee_training.index');
        Route::get('employee_training/details', [EmployeeTrainingController::class, 'details'])->name('employee_training.details');
        Route::get('employee_training/details/{id}', [EmployeeTrainingController::class, 'show'])->name('employee_training.show');

        Route::get('employee_ticket/{employee}', [EmployeeTicketController::class, 'index'])->name('employee_ticket.index');
        Route::get('employee_ticket/details', [EmployeeTicketController::class, 'details'])->name('employee_ticket.details');
        Route::get('employee_ticket/details/{id}', [EmployeeTicketController::class, 'show'])->name('employee_ticket.show');

        Route::get('employee_transfer/{employee}', [EmployeeTransferController::class, 'index'])->name('employee_transfer.index');
        Route::get('employee_transfer/details', [EmployeeTransferController::class, 'details'])->name('employee_transfer.details');
        Route::get('employee_transfer/details/{id}', [EmployeeTransferController::class, 'show'])->name('employee_transfer.show');

        Route::get('employee_promotion/{employee}', [EmployeePromotionController::class, 'index'])->name('employee_promotion.index');
        Route::get('employee_promotion/details', [EmployeePromotionController::class, 'details'])->name('employee_promotion.details');
        Route::get('employee_promotion/details/{id}', [EmployeePromotionController::class, 'show'])->name('employee_promotion.show');

        Route::get('employee_complaint/{employee}', [EmployeeComplaintController::class, 'index'])->name('employee_complaint.index');
        Route::get('employee_complaint/details', [EmployeeComplaintController::class, 'details'])->name('employee_complaint.details');
        Route::get('employee_complaint/details/{id}', [EmployeeComplaintController::class, 'show'])->name('employee_complaint.show');

        Route::get('employee_warning/{employee}', [EmployeeWarningController::class, 'index'])->name('employee_warning.index');
        Route::get('employee_warning/details', [EmployeeWarningController::class, 'details'])->name('employee_warning.details');
        Route::get('employee_warning/details/{id}', [EmployeeWarningController::class, 'show'])->name('employee_warning.show');

        Route::get('employee_project/{employee}', [EmployeeProjectController::class, 'index'])->name('employee_project.index');
        Route::get('employee_project/details', [EmployeeProjectController::class, 'details'])->name('employee_project.details');
        Route::get('employee_project/details/{id}', [EmployeeProjectController::class, 'show'])->name('employee_project.show');

        Route::get('employee_task/{employee}', [EmployeeTaskController::class, 'index'])->name('employee_task.index');
        Route::get('employee_task/details', [EmployeeTaskController::class, 'details'])->name('employee_task.details');
        Route::get('employee_task/details/{id}', [EmployeeTaskController::class, 'show'])->name('employee_task.show');

        Route::get('employee_payslip/{employee}', [EmployeePayslipController::class, 'index'])->name('employee_payslip.index');
        Route::get('employee_payslip/details', [EmployeePayslipController::class, 'details'])->name('employee_payslip.details');
        Route::get('employee_payslip/details/{id}', [EmployeePayslipController::class, 'show'])->name('employee_payslip.show');

        Route::get('employee_leave_type_detail/{employee}', [EmployeeLeaveTypeDetailController::class,'index'])->name('employee_leave_type_detail.index');

    });

    Route::get('calendar/hr', [CalendarableController::class, 'index'])->name('calendar.index');
    Route::get('calendar/hr/load', [CalendarableController::class, 'load'])->name('calendar.load');

    Route::prefix('core_hr')->group(function () {

        Route::post('awards/update', [AwardController::class, 'update'])->name('awards.update');
        Route::resource('awards', AwardController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('awards/{id}/delete', [AwardController::class, 'destroy'])->name('awards.destroy');
        Route::post('awards/delete/selected', [AwardController::class, 'delete_by_selection'])->name('mass_delete_awards');

        Route::post('promotions/update', [PromotionController::class, 'update'])->name('promotions.update');
        Route::resource('promotions', PromotionController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('promotions/{id}/delete', [PromotionController::class, 'destroy'])->name('promotions.destroy');
        Route::post('promotions/delete/selected', [PromotionController::class, 'delete_by_selection'])->name('mass_delete_promotions');

        Route::post('travels/update', [TravelController::class, 'update'])->name('travels.update');
        Route::resource('travels', TravelController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('travels/{id}/delete', [TravelController::class, 'destroy'])->name('travels.destroy');
        Route::post('travels/delete/selected', [TravelController::class, 'delete_by_selection'])->name('mass_delete_travels');
        Route::get('travels/{id}/calendarable', [TravelController::class, 'calendarableDetails'])->name('travels.calendarable');

        Route::post('transfers/update', [TransferController::class, 'update'])->name('transfers.update');
        Route::resource('transfers', TransferController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('transfers/{id}/delete', [TransferController::class, 'destroy'])->name('transfers.destroy');
        Route::post('transfers/delete/selected', [TransferController::class, 'delete_by_selection'])->name('mass_delete_transfers');

        // Route::controller(ResignationController::class)->group(function () {
        //     Route::post('resignations/update', 'update')->name('resignations.update');
        //     Route::resource('resignations')->except([
        //         'destroy', 'create', 'update',
        //     ]);
        //     Route::get('resignations/{id}/delete', 'destroy')->name('resignations.destroy');
        //     Route::post('resignations/delete/selected', 'delete_by_selection')->name('mass_delete_resignations');
        //     Route::get('resignations/{resignation}/restore', 'restore')->name('resignations.restore');
        // });

        Route::post('resignations/update', [ResignationController::class, 'update'])->name('resignations.update');
        Route::resource('resignations', ResignationController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('resignations/{id}/delete', [ResignationController::class, 'destroy'])->name('resignations.destroy');
        Route::post('resignations/delete/selected', [ResignationController::class, 'delete_by_selection'])->name('mass_delete_resignations');
        Route::get('resignations/{resignation}/restore', [ResignationController::class, 'restore'])->name('resignations.restore');


        Route::post('complaints/update', [ComplaintController::class, 'update'])->name('complaints.update');
        Route::resource('complaints', ComplaintController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('complaints/{id}/delete', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
        Route::post('complaints/delete/selected', [ComplaintController::class, 'delete_by_selection'])->name('mass_delete_complaints');

        Route::post('warnings/update', [WarningController::class, 'update'])->name('warnings.update');
        Route::resource('warnings', WarningController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('warnings/{id}/delete', [WarningController::class, 'destroy'])->name('warnings.destroy');
        Route::post('warnings/delete/selected', [WarningController::class, 'delete_by_selection'])->name('mass_delete_warnings');

        Route::post('terminations/update', [TerminationController::class, 'update'])->name('terminations.update');
        Route::resource('terminations', TerminationController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('terminations/{id}/delete', [TerminationController::class, 'destroy'])->name('terminations.destroy');
        Route::post('terminations/delete/selected', [TerminationController::class, 'delete_by_selection'])->name('mass_delete_terminations');
        Route::get('terminations/{termination}/restore', [TerminationController::class, 'restore'])->name('terminations.restore');

    });

    Route::prefix('report')->group(function () {
        //New Added
        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('date_wise_attendances', [AttendanceController::class, 'dateWiseAttendance'])->name('date_wise_attendances.index');
        Route::get('monthly_attendances', [AttendanceController::class, 'monthlyAttendance'])->name('monthly_attendances.index');
        //New Added

        Route::get('payslip', [ReportController::class, 'payslip'])->name('report.payslip');
        Route::get('attendance', [ReportController::class, 'attendance'])->name('report.attendance');
        Route::get('training', [ReportController::class, 'training'])->name('report.training');
        Route::get('project', [ReportController::class, 'project'])->name('report.project');
        Route::get('task', [ReportController::class, 'task'])->name('report.task');
        Route::get('employees', [ReportController::class, 'employees'])->name('report.employees');
        Route::get('account', [ReportController::class, 'account'])->name('report.account');
        Route::get('expense', [ReportController::class, 'expense'])->name('report.expense');
        Route::get('deposit', [ReportController::class, 'deposit'])->name('report.deposit');
        Route::get('transaction', [ReportController::class, 'transaction'])->name('report.transaction');
        Route::get('pension', [ReportController::class, 'pension'])->name('report.pension');
    });

    Route::prefix('organization')->group(function () {

        Route::resource('locations', LocationController::class)->except([
            'create', 'show',
        ]);
        Route::get('locations/edit/{id}', [LocationController::class, 'edit'])->name('locations.edit');
        Route::post('locations/update', [LocationController::class, 'update'])->name('locations.update');
        Route::get('locations/delete/{id}', [LocationController::class, 'delete']);
        Route::post('locations/delete/selected', [LocationController::class, 'delete_by_selection'])->name('mass_delete_location');

        Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');
        Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('companies/edit/{id}', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::post('companies/update', [CompanyController::class, 'update'])->name('companies.update');
        Route::get('companies/delete/{id}', [CompanyController::class, 'destroy']);
        Route::post('companies/delete/selected', [CompanyController::class, 'delete_by_selection'])->name('mass_delete_companies');

        Route::post('departments/update', [DepartmentController::class, 'update'])->name('departments.update');
        Route::resource('departments', DepartmentController::class)->except([
            'destroy', 'show', 'create', 'update',
        ]);
        Route::get('departments/{id}/delete', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::post('departments/delete/selected', [DepartmentController::class, 'delete_by_selection'])->name('mass_delete_departments');

        Route::post('designations/update', [DesignationController::class, 'update'])->name('designations.update');
        Route::resource('designations', DesignationController::class)->except([
            'destroy', 'show', 'create', 'update',
        ]);
        Route::get('designations/{id}/delete', [DesignationController::class, 'destroy'])->name('designations.destroy');
        Route::post('designations/delete/selected', [DesignationController::class, 'delete_by_selection'])->name('mass_delete_designations');

        Route::post('announcements/update', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::resource('announcements', AnnouncementController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('announcements/{id}/delete', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::post('announcements/delete/selected', [AnnouncementController::class, 'delete_by_selection'])->name('mass_delete_announcements');

        Route::post('policy/update', [PolicyController::class, 'update'])->name('policy.update');
        Route::resource('policy', PolicyController::class)->except([
            'destroy', 'create', 'update',
        ]);
        Route::get('policy/{id}/delete', [PolicyController::class, 'destroy'])->name('policy.destroy');
        Route::post('policy/delete/selected', [PolicyController::class, 'delete_by_selection'])->name('mass_delete_policy');
    });

    Route::prefix('timesheet')->group(function () {
        // Route::get('attendances', 'AttendanceController@index')->name('attendances.index');
        // Route::get('date_wise_attendances', 'AttendanceController@dateWiseAttendance')->name('date_wise_attendances.index');
        // Route::get('monthly_attendances', 'AttendanceController@monthlyAttendance')->name('monthly_attendances.index');

        Route::get('update_attendances', [AttendanceController::class, 'updateAttendance'])->name('update_attendances.index');
        Route::get('update_attendances/{id}/get', [AttendanceController::class, 'updateAttendanceGet'])->name('update_attendances.get');
        Route::post('update_attendances/store', [AttendanceController::class, 'updateAttendanceStore'])->name('update_attendances.store');
        Route::post('update_attendances/update', [AttendanceController::class, 'updateAttendanceUpdate'])->name('update_attendances.update');
        Route::get('update_attendances/{id}/delete', [AttendanceController::class, 'updateAttendanceDelete'])->name('update_attendances.delete');

        Route::get('attendances/page/import', [AttendanceController::class, 'import'])->name('attendances.import');
        Route::post('attendances/page/import_device', [AttendanceController::class, 'importDeviceCsv'])->name('attendances.importDeviceCsv');
        Route::post('attendances/page/import', [AttendanceController::class, 'importPost'])->name('attendances.importPost');
        Route::post('attendance/employee/{id}', [AttendanceController::class, 'employeeAttendance'])->name('employee_attendance.post');

        Route::post('office_shift/update', [OfficeShiftController::class, 'update'])->name('office_shift.update');
        Route::resource('office_shift', OfficeShiftController::class)->except(['destroy', 'update', 'show']);
        Route::get('office_shift/{id}/delete', [OfficeShiftController::class, 'destroy'])->name('office_shift.destroy');
        Route::post('office_shift/delete/selected', [OfficeShiftController::class, 'delete_by_selection'])->name('mass_delete_office_shifts');

        Route::post('holidays/update', [HolidayController::class, 'update'])->name('holidays.update');
        Route::resource('holidays', HolidayController::class)->except(['destroy', 'create', 'update']);
        Route::get('holidays/{id}/delete', [HolidayController::class, 'destroy'])->name('holidays.destroy');
        Route::post('holidays/delete/selected', [HolidayController::class, 'delete_by_selection'])->name('mass_delete_holidays');
        Route::get('holidays/{id}/calendarable', [HolidayController::class, 'calendarableDetails'])->name('holidays.calendarable');

        Route::post('leaves/update', [LeaveController::class, 'update'])->name('leaves.update');
        Route::resource('leaves', LeaveController::class)->except(['destroy', 'create', 'update']);
        Route::get('leaves/{id}/delete', [LeaveController::class, 'destroy'])->name('leaves.destroy');
        Route::post('leaves/delete/selected', [LeaveController::class, 'delete_by_selection'])->name('mass_delete_leaves');
        Route::get('leaves/{id}/calendarable', [LeaveController::class, 'calendarableDetails'])->name('leaves.calendarable');

    });

    Route::prefix('payroll')->group(function () {
        Route::get('list', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('payslip', [PayrollController::class, 'dummy'])->name('paySlip.index');
        Route::get('payslip_show', [PayrollController::class, 'paySlip'])->name('paySlip.show');
        Route::post('payslip/pay/{id}', [PayrollController::class, 'payEmployee'])->name('paySlip.pay');
        Route::post('payslip/payment/bulk', [PayrollController::class, 'payBulk'])->name('paySlip.bulk_pay');
        Route::get('payslip/generate', [PayrollController::class, 'payslipGenerateInfoShow'])->name('paySlip.generate');

        Route::get('payment_history', [PayslipController::class, 'index'])->name('payment_history.index');
        Route::get('payslip/delete/{payslip}', [PayslipController::class, 'delete'])->name('payslip.destroy');
        Route::get('payslip/id/{payslip}', [PayslipController::class, 'show'])->name('payslip_details.show');
        Route::get('payslip/pdf/id/{payslip}', [PayslipController::class, 'printPdf'])->name('payslip.pdf');

    });

    Route::prefix('recruitment')->group(function () {
        Route::post('job_posts/update', [JobPostController::class, 'update'])->name('job_posts.update');
        Route::resource('job_posts', JobPostController::class)->except(['destroy', 'create', 'update']);
        Route::get('job_posts/{id}/delete', [JobPostController::class, 'destroy'])->name('job_posts.destroy');
        Route::post('job_posts/delete/selected', [JobPostController::class, 'delete_by_selection'])->name('mass_delete_job_posts');

        Route::resource('job_candidates', JobCandidateController::class)->except(['destroy', 'create', 'update', 'store']);
        Route::get('job_candidates/{id}/delete', [JobCandidateController::class, 'destroy'])->name('job_candidates.destroy');

        Route::post('job_interviews/update', [JobInterviewController::class, 'update'])->name('job_interviews.update');
        Route::resource('job_interviews', JobInterviewController::class)->except(['destroy', 'create', 'update']);
        Route::get('job_interviews/{id}/delete', [JobInterviewController::class, 'destroy'])->name('job_interviews.destroy');

        Route::get('cms', [CmsController::class, 'index'])->name('cms.index');
        Route::post('cms', [CmsController::class, 'store'])->name('cms.store');
    });

    Route::prefix('training')->group(function () {
        Route::post('training_lists/update', [TrainingListController::class, 'update'])->name('training_lists.update');
        Route::resource('training_lists', TrainingListController::class)->except(['destroy', 'create', 'update']);
        Route::get('training_lists/{id}/delete', [TrainingListController::class, 'destroy'])->name('training_lists.destroy');
        Route::post('training_lists/delete/selected', [TrainingListController::class, 'delete_by_selection'])->name('mass_delete_training_lists');
        Route::get('training_lists/{id}/calendarable', [TrainingListController::class, 'calendarableDetails'])->name('training_lists.calendarable');

        Route::post('trainers/update', [TrainerController::class, 'update'])->name('trainers.update');
        Route::resource('trainers', TrainerController::class)->except(['destroy', 'create', 'update']);
        Route::get('trainers/{id}/delete', [TrainerController::class, 'destroy'])->name('trainers.destroy');
        Route::post('trainers/delete/selected', [TrainerController::class, 'delete_by_selection'])->name('mass_delete_trainers');
    });

    Route::prefix('accounting')->group(function () {

        Route::post('accounting_list/update', [AccountListController::class, 'update'])->name('accounting_list.update');
        Route::resource('accounting_list', AccountListController::class)->except(['destroy', 'create', 'update', 'show']);
        Route::get('accounting_list/{id}/delete', [AccountListController::class, 'destroy'])->name('accounting_list.destroy');
        Route::post('accounting_list/delete/selected', [AccountListController::class, 'delete_by_selection'])->name('mass_delete_accounting_list');
        Route::get('account_balances', [AccountListController::class, 'accountBalance'])->name('account_balances');

        Route::post('payees/update', [FinancePayeeController::class, 'update'])->name('payees.update');
        Route::get('payees/{id}/delete', [FinancePayeeController::class, 'destroy'])->name('payees.destroy');
        Route::resource('payees', FinancePayeeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('payers/update', [FinancePayerController::class, 'update'])->name('payers.update');
        Route::get('payers/{id}/delete', [FinancePayerController::class, 'destroy'])->name('payers.destroy');
        Route::resource('payers', FinancePayerController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('deposit/update', [FinanceDepositController::class, 'update'])->name('deposit.update');
        Route::resource('deposit', FinanceDepositController::class)->except(['destroy', 'create', 'update']);
        Route::get('deposit/{id}/delete', [FinanceDepositController::class, 'destroy'])->name('deposit.destroy');
        Route::get('deposit/download', [FinanceDepositController::class, 'download'])->name('deposit.download');
        Route::get('deposit/download/{id}', [FinanceDepositController::class, 'download'])->name('deposit.downloadFile');

        Route::post('expense/update', [FinanceExpenseController::class, 'update'])->name('expense.update');
        Route::resource('expense', FinanceExpenseController::class)->except(['destroy', 'create', 'update']);
        Route::get('expense/{id}/delete', [FinanceExpenseController::class, 'destroy'])->name('expense.destroy');
        Route::get('expense/download', [FinanceExpenseController::class, 'download'])->name('expense.download');
        Route::get('expense/download/{id}', [FinanceExpenseController::class, 'download'])->name('expense.downloadFile');

        Route::resource('finance_transfer', FinanceTransferController::class)->except(['destroy', 'create', 'update', 'show', 'edit']);

        Route::get('transactions', [FinanceTransactionsController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{id}/show', [FinanceTransactionsController::class, 'show'])->name('transactions.show');
    });

    Route::post('assets/update', [AssetController::class, 'update'])->name('assets.update');
    Route::resource('assets', AssetController::class)->except(['destroy', 'create', 'update']);
    Route::get('assets/{id}/delete', [AssetController::class, 'destroy'])->name('assets.destroy');
    Route::get('assets/download', [AssetController::class, 'download'])->name('assets.download');
    Route::get('assets/download/{id}', [AssetController::class, 'download'])->name('assets.downloadFile');
    Route::post('assets/delete/selected', [AssetController::class, 'delete_by_selection'])->name('mass_delete_assets');

    Route::post('events/update', [EventController::class, 'update'])->name('events.update');
    Route::resource('events', EventController::class)->except(['destroy', 'create', 'update']);
    Route::get('events/{id}/delete', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('events/delete/selected', [EventController::class, 'delete_by_selection'])->name('mass_delete_events');
    Route::get('events/{id}/calendarable', [EventController::class, 'calendarableDetails'])->name('events.calendarable');

    Route::post('meetings/update', [MeetingController::class, 'update'])->name('meetings.update');
    Route::resource('meetings', MeetingController::class)->except(['destroy', 'create', 'update']);
    Route::get('meetings/{id}/delete', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    Route::post('meetings/delete/selected', [MeetingController::class, 'delete_by_selection'])->name('mass_delete_meetings');
    Route::get('meetings/{id}/calendarable', [MeetingController::class, 'calendarableDetails'])->name('meetings.calendarable');

    Route::post('tickets/update', [SupportTicketController::class, 'update'])->name('tickets.update');
    Route::resource('tickets', SupportTicketController::class)->except(['destroy', 'create', 'update']);
    Route::post('tickets/{ticket}/assigned', [EmployeeAssignedController::class, 'employeeTicketAssigned'])->name('tickets.assigned');
    Route::get('tickets/{id}/delete', [SupportTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('tickets/download/{id}', [SupportTicketController::class, 'download'])->name('tickets.downloadTicket');
    Route::post('tickets/delete/selected', [SupportTicketController::class, 'delete_by_selection'])->name('mass_delete_tickets');
    Route::post('tickets/{ticket}/comments', [SupportTicketCommentController::class, 'index'])->name('ticket_comments.index');
    Route::post('tickets/store_comments/{ticket}', [SupportTicketCommentController::class, 'store'])->name('ticket_comments.store');
    Route::get('tickets/{id}/delete_comments', [SupportTicketCommentController::class, 'destroy'])->name('ticket_comments.destroy');
    Route::post('tickets/{ticket}/details', [SupportTicketController::class, 'detailsStore'])->name('ticket_details.store');
    Route::post('tickets/{ticket}/notes', [SupportTicketController::class, 'notesStore'])->name('ticket_notes.store');

    Route::prefix('project-management')->group(function () {
        Route::post('projects/{project}/assigned', [EmployeeAssignedController::class, 'employeeProjectAssigned'])->name('projects.assigned');

        Route::post('projects/update', [ProjectController::class, 'update'])->name('projects.update');
        Route::resource('projects', ProjectController::class)->except(['destroy', 'create', 'update']);
        Route::get('projects/{id}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('projects/{id}/calendarable', [ProjectController::class, 'calendarableDetails'])->name('projects.calendarable');
        Route::post('projects/{project}/progress', [ProjectController::class, 'progressStore'])->name('project_progress.store');

        Route::post('projects/{project}/discussions', [ProjectDiscussionController::class, 'index'])->name('project_discussions.index');
        Route::post('projects/store_discussions/{project}', [ProjectDiscussionController::class, 'store'])->name('project_discussions.store');
        Route::get('projects/{id}/delete_discussions', [ProjectDiscussionController::class, 'destroy'])->name('project_discussions.destroy');

        Route::post('projects/{project}/bugs', [ProjectBugController::class, 'index'])->name('project_bugs.index');
        Route::post('projects/store_bugs/{project}', [ProjectBugController::class, 'store'])->name('project_bugs.store');

        Route::post('projects/{project}/files', [ProjectFileController::class, 'index'])->name('project_files.index');
        Route::post('projects/store_files/{project}', [ProjectFileController::class, 'store'])->name('project_files.store');
        Route::get('projects/{id}/delete_files', [ProjectFileController::class, 'destroy'])->name('project_files.destroy');

        Route::post('projects/{project}/tasks', [ProjectTaskController::class, 'index'])->name('project_tasks.index');
        Route::post('projects/store_tasks/{project}', [ProjectTaskController::class, 'store'])->name('project_tasks.store');
        Route::get('projects/{id}/delete_tasks', [ProjectTaskController::class, 'destroy'])->name('project_tasks.destroy');

        Route::get('projects/bug_status', [ProjectBugController::class, 'default'])->name('bug_status.default');
        Route::get('projects/bug_status/{id}', [ProjectBugController::class, 'editStatus'])->name('bug_status.edit');
        Route::post('projects/bug_status/update', [ProjectBugController::class, 'updateStatus'])->name('bug_status.update');
        Route::get('projects/{id}/delete_bugs', [ProjectBugController::class, 'destroy'])->name('project_bugs.destroy');
        Route::get('projects/discussion_download/{id}', [ProjectDiscussionController::class, 'download'])->name('projects.downloadAttachment');
        Route::get('projects/bug_download/{id}', [ProjectBugController::class, 'download'])->name('projects.downloadBug');

        Route::get('projects/file_download/{id}', [ProjectFileController::class, 'download'])->name('projects.downloadFile');
        Route::post('projects/{project}/notes', [ProjectController::class, 'notesStore'])->name('project_notes.store');
        Route::post('tasks/{task}/assigned', [EmployeeAssignedController::class, 'employeeTaskAssigned'])->name('tasks.assigned');

        Route::post('tasks/update', [TaskController::class, 'update'])->name('tasks.update');
        Route::resource('tasks', TaskController::class)->except(['destroy', 'create', 'update']);
        Route::get('tasks/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::get('tasks/{id}/calendarable', [TaskController::class, 'calendarableDetails'])->name('tasks.calendarable');
        Route::post('tasks/{task}/progress', [TaskController::class, 'progressStore'])->name('task_progress.store');

        Route::post('tasks/{task}/discussions', [TaskDiscussionController::class, 'index'])->name('task_discussions.index');
        Route::post('tasks/store_discussions/{task}', [TaskDiscussionController::class, 'store'])->name('task_discussions.store');
        Route::get('tasks/{id}/delete_discussions', [TaskDiscussionController::class, 'destroy'])->name('task_discussions.destroy');

        Route::post('tasks/{task}/files', [TaskFileController::class, 'index'])->name('task_files.index');
        Route::post('tasks/store_files/{task}', [TaskFileController::class, 'store'])->name('task_files.store');
        Route::get('tasks/{id}/delete_files', [TaskFileController::class, 'destroy'])->name('task_files.destroy');
        Route::get('tasks/file_download/{id}', [TaskFileController::class, 'download'])->name('tasks.downloadFile');

        Route::post('tasks/{task}/notes', [TaskController::class, 'notesStore'])->name('task_notes.store');

        Route::post('invoices/{id}/update', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::resource('invoices', InvoiceController::class)->except(['destroy', 'update']);
        Route::get('invoices/status/{status_id}/{invoice_id}', [InvoiceController::class, 'status'])->name('invoices.status');
        Route::get('invoices/{id}/delete', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::get('invoices/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('invoices/download/{id}', [InvoiceController::class, 'download'])->name('invoices.downloadFile');
        Route::post('invoices/delete/selected', [InvoiceController::class, 'delete_by_selection'])->name('mass_delete_invoices');

        Route::post('clients/update', [ClientController::class, 'update'])->name('clients.update');
        Route::resource('clients', ClientController::class)->except(['destroy', 'create', 'update', 'show']);
        Route::get('clients/{id}/delete', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::post('clients/delete/selected', [ClientController::class, 'delete_by_selection'])->name('mass_delete_clients');
    });

    Route::post('dynamic_dependent/fetch_department', [DynamicDependent::class, 'fetchDepartment'])->name('dynamic_department');
    Route::post('dynamic_dependent/fetch_employee', [DynamicDependent::class, 'fetchEmployee'])->name('dynamic_employee');
    Route::post('dynamic_dependent/fetch_employee_department', [DynamicDependent::class, 'fetchEmployeeDepartment'])->name('dynamic_employee_department');
    Route::post('dynamic_dependent/fetch_designation_department', [DynamicDependent::class, 'fetchDesignationDepartment'])->name('dynamic_designation_department');
    Route::post('dynamic_dependent/fetch_office_shifts', [DynamicDependent::class, 'fetchOfficeShifts'])->name('dynamic_office_shifts');
    Route::post('dynamic_dependent/fetch_balance', [DynamicDependent::class, 'fetchBalance'])->name('dynamic_balance');
    Route::post('dynamic_dependent/company_employee/{ticket}', [DynamicDependent::class, 'companyEmployee'])->name('company_employee');
    Route::post('dynamic_dependent/get_tax_rate', [DynamicDependent::class, 'getTaxRate'])->name('dynamic_tax_rate');
    Route::post('dynamic_dependent/fetch_candidate', [DynamicDependent::class, 'fetchCandidate'])->name('dynamic_candidate');

    Route::prefix('settings')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::get('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('roles/role-permission/{id}', [PermissionController::class, 'rolePermission'])->name('rolePermission');
        Route::get('roles/permission_details/{id}', [PermissionController::class, 'permissionDetails'])->name('permissionDetails');
        Route::post('roles/permission', [PermissionController::class, 'set_permission'])->name('set_permission');
        Route::post('general_settings/update/{id}', [GeneralSettingController::class, 'update'])->name('general_settings.update');
        Route::resource('general_settings', GeneralSettingController::class)->except(['create', 'edit', 'show', 'update']);
        Route::get('mail_setting', [GeneralSettingController::class, 'mailSetting'])->name('setting.mail');
        Route::post('setting/mail_setting_store', [GeneralSettingController::class, 'mailSettingStore'])->name('setting.mailStore');
        Route::get('general_settings/change-theme/{theme}', [GeneralSettingController::class, 'change_theme'])->name('change_theme');
        Route::resource('variables', VariableController::class);
        Route::resource('variables_method', VariableMethodController::class);
        Route::get('/empty_database', [GeneralSettingController::class, 'emptyDatabase'])->name('empty_database');
        Route::get('/export_database', [GeneralSettingController::class, 'exportDatabase'])->name('export_database');

        // IP Settings
        Route::prefix('ip_settings')->group(function () {
            Route::get('/', [IPSettingController::class, 'index'])->name('ip_setting.index');
            Route::post('/store', [IPSettingController::class, 'store'])->name('ip_setting.store');
            Route::get('/edit', [IPSettingController::class, 'edit'])->name('ip_setting.edit');
            Route::post('/update', [IPSettingController::class, 'update'])->name('ip_setting.update');
            Route::get('/delete', [IPSettingController::class, 'delete'])->name('ip_setting.delete');
            Route::get('/bulk_delete', [IPSettingController::class, 'bulkDelete'])->name('ip_setting.bulk_delete');
        });
    });

    Route::prefix('dynamic_variable')->group(function () {
        Route::post('leave_type/update', [LeaveTypeController::class, 'update'])->name('leave_type.update');
        Route::get('leave_type/{id}/delete', [LeaveTypeController::class, 'destroy'])->name('leave_type.destroy');
        Route::resource('leave_type', LeaveTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('award_type/update', [AwardTypeController::class, 'update'])->name('award_type.update');
        Route::get('award_type/{id}/delete', [AwardTypeController::class, 'destroy'])->name('award_type.destroy');
        Route::resource('award_type', AwardTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('warning_type/update', [WarningTypeController::class, 'update'])->name('warning_type.update');
        Route::get('warning_type/{id}/delete', [WarningTypeController::class, 'destroy'])->name('warning_type.destroy');
        Route::resource('warning_type', WarningTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('termination_type/update', [TerminationTypeController::class, 'update'])->name('termination_type.update');
        Route::get('termination_type/{id}/delete', [TerminationTypeController::class, 'destroy'])->name('termination_type.destroy');
        Route::resource('termination_type', TerminationTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('status_type/update', [StatusTypeController::class, 'update'])->name('status_type.update');
        Route::get('status_type/{id}/delete', [StatusTypeController::class, 'destroy'])->name('status_type.destroy');
        Route::resource('status_type', StatusTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('training_type/update', [TrainingTypeController::class, 'update'])->name('training_type.update');
        Route::get('training_type/{id}/delete', [TrainingTypeController::class, 'destroy'])->name('training_type.destroy');
        Route::resource('training_type', TrainingTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('tax_type/update', [TaxTypeController::class, 'update'])->name('tax_type.update');
        Route::get('tax_type/{id}/delete', [TaxTypeController::class, 'destroy'])->name('tax_type.destroy');
        Route::resource('tax_type', TaxTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('expense_type/update', [ExpenseTypeController::class, 'update'])->name('expense_type.update');
        Route::get('expense_type/{id}/delete', [ExpenseTypeController::class, 'destroy'])->name('expense_type.destroy');
        Route::resource('expense_type', ExpenseTypeController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('assets_category/update', [AssetCategoryController::class, 'update'])->name('assets_category.update');
        Route::get('assets_category/{id}/delete', [AssetCategoryController::class, 'destroy'])->name('assets_category.destroy');
        Route::resource('assets_category', AssetCategoryController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('document_type/update', [DocumentTypeController::class, 'update'])->name('document_type.update');
        Route::get('document_type/{id}/delete', [DocumentTypeController::class, 'destroy'])->name('document_type.destroy');
        Route::resource('document_type', DocumentTypeController::class)->except(['create', 'update', 'destroy', 'show']);
    });

    Route::prefix('dynamic_variable_method')->group(function () {
        Route::post('travel_method/update', [TravelMethodController::class, 'update'])->name('travel_method.update');
        Route::get('travel_method/{id}/delete', [TravelMethodController::class, 'destroy'])->name('travel_method.destroy');
        Route::resource('travel_method', TravelMethodController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('payment_method/update', [PaymentMethodController::class, 'update'])->name('payment_method.update');
        Route::get('payment_method/{id}/delete', [PaymentMethodController::class, 'destroy'])->name('payment_method.destroy');
        Route::resource('payment_method', PaymentMethodController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::get('employee_qualification', [QualificationEducationLevelController::class, 'index'])->name('employee_qualification.index');
        Route::post('education_level/update', [QualificationEducationLevelController::class, 'update'])->name('education_level.update');
        Route::get('education_level/{id}/delete', [QualificationEducationLevelController::class, 'destroy'])->name('education_level.destroy');
        Route::resource('education_level', QualificationEducationLevelController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('language_skill/update', [QualificationLanguageController::class, 'update'])->name('language_skill.update');
        Route::get('language_skill/{id}/delete', [QualificationLanguageController::class, 'destroy'])->name('language_skill.destroy');
        Route::resource('language_skill', QualificationLanguageController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('general_skill/update', [QualificationSkillController::class, 'update'])->name('general_skill.update');
        Route::get('general_skill/{id}/delete', [QualificationSkillController::class, 'destroy'])->name('general_skill.destroy');
        Route::resource('general_skill', QualificationSkillController::class)->except(['create', 'update', 'destroy', 'show']);

        Route::post('job_categories/update', [JobCategoryController::class, 'update'])->name('job_categories.update');
        Route::get('job_categories/{id}/delete', [JobCategoryController::class, 'destroy'])->name('job_categories.destroy');
        Route::resource('job_categories', JobCategoryController::class)->except(['create', 'update', 'destroy', 'show']);
    });

    Route::prefix('file_manager')->group(function () {
        Route::post('files/update', [FileManagerController::class, 'update'])->name('files.update');
        Route::resource('files', FileManagerController::class)->except(['destroy', 'create', 'update', 'show']);
        Route::get('files/{id}/delete', [FileManagerController::class, 'destroy'])->name('files.destroy');
        Route::get('files/new/download/{id}', [FileManagerController::class, 'download'])->name('files.downloadFile');
        Route::post('files/delete/selected', [FileManagerController::class, 'delete_by_selection'])->name('mass_delete_files');

        Route::post('official_documents/update', [OfficialDocumentController::class, 'update'])->name('official_documents.update');
        Route::resource('official_documents', OfficialDocumentController::class)->except(['destroy', 'create', 'update', 'show']);
        Route::get('official_documents/{id}/delete', [OfficialDocumentController::class, 'destroy'])->name('official_documents.destroy');
        Route::get('official_documents/new/download/{id}', [OfficialDocumentController::class, 'download'])->name('official_documents.downloadFile');
        Route::post('official_documents/delete/selected', [OfficialDocumentController::class, 'delete_by_selection'])->name('mass_delete_official_documents');

        Route::get('file_config', [FileManagerSettingController::class, 'index'])->name('file_config.index');
        Route::post('file_config', [FileManagerSettingController::class, 'store'])->name('file_config.store');
    });

    Route::prefix('client')->group(function() {
        Route::get('/profile', [DashboardController::class, 'clientProfile'])->name('clientProfile');
        Route::get('/invoices', [ClientInvoiceController::class, 'invoices'])->name('clientInvoice');
        Route::get('/invoices/payment', [ClientInvoiceController::class, 'paidInvoices'])->name('clientInvoicePaid');
        Route::get('/projects', [ClientProjectController::class, 'index'])->name('clientProject');
        Route::post('/projects/store', [ClientProjectController::class, 'store'])->name('clientProject.store');
        Route::get('/projects/status', [ClientProjectController::class, 'status'])->name('clientProjectStatus');
        Route::get('/tasks', [ClientTaskController::class, 'index'])->name('clientTask');
        Route::post('/tasks', [ClientTaskController::class, 'store'])->name('clientTask.store');
        Route::get('/tasks/{id}/edit', [ClientTaskController::class, 'edit'])->name('clientTask.edit');
        Route::post('/tasks/update', [ClientTaskController::class, 'update'])->name('clientTask.update');
    });

    //Performance Feature By - Md Irfan Chowdhury

    Route::group(['prefix' => 'performance', 'namespace' => 'Performance'], function () {
        Route::group(['prefix' => 'goal-type'], function () {
            Route::get('/index', [GoalTypeController::class, 'index'])->name('performance.goal-type.index');
            Route::post('/store', [GoalTypeController::class, 'store'])->name('performance.goal-type.store');
            Route::get('/edit', [GoalTypeController::class, 'edit'])->name('performance.goal-type.edit');
            Route::post('/update', [GoalTypeController::class, 'update'])->name('performance.goal-type.update');
            Route::get('/delete', [GoalTypeController::class, 'delete'])->name('performance.goal-type.delete');
            Route::get('/delete-checkbox', [GoalTypeController::class, 'deleteCheckbox'])->name('performance.goal-type.delete.checkbox');
        });

        Route::group(['prefix' => 'goal-tracking'], function () {
            Route::get('/index', [GoalTrackingController::class, 'index'])->name('performance.goal-tracking.index');
            Route::post('/store', [GoalTrackingController::class, 'store'])->name('performance.goal-tracking.store');
            Route::get('/edit', [GoalTrackingController::class, 'edit'])->name('performance.goal-tracking.edit');
            Route::post('/update', [GoalTrackingController::class, 'update'])->name('performance.goal-tracking.update');
            Route::get('/delete', [GoalTrackingController::class, 'delete'])->name('performance.goal-tracking.delete');
            Route::get('/delete-checkbox', [GoalTrackingController::class, 'deleteCheckbox'])->name('performance.goal-tracking.delete.checkbox');
        });

        Route::group(['prefix' => 'indicator'], function () {
            Route::get('/index', [IndicatorController::class, 'index'])->name('performance.indicator.index');
            Route::get('/get-designation', [IndicatorController::class, 'getDesignationByComapny'])->name('performance.indicator.get-designation-by-company');
            Route::post('/store', [IndicatorController::class, 'store'])->name('performance.indicator.store');
            Route::get('/edit', [IndicatorController::class, 'edit'])->name('performance.indicator.edit');
            Route::post('/update', [IndicatorController::class, 'update'])->name('performance.indicator.update');
            Route::get('/delete', [IndicatorController::class, 'delete'])->name('performance.indicator.delete');
            Route::get('/delete-checkbox', [IndicatorController::class, 'deleteCheckbox'])->name('performance.indicator.delete.checkbox');
        });

        Route::group(['prefix' => 'appraisal'], function () {
            Route::get('/index', [AppraisalController::class, 'index'])->name('performance.appraisal.index');
            Route::get('/get-employee', [AppraisalController::class, 'getEmployee'])->name('performance.appraisal.get-employee');
            Route::post('/store', [AppraisalController::class, 'store'])->name('performance.appraisal.store');
            Route::get('/edit', [AppraisalController::class, 'edit'])->name('performance.appraisal.edit');
            Route::post('/update', [AppraisalController::class, 'update'])->name('performance.appraisal.update');
            Route::get('/delete', [AppraisalController::class, 'delete'])->name('performance.appraisal.delete');
            Route::get('/delete-checkbox', [AppraisalController::class, 'deleteCheckbox'])->name('performance.appraisal.delete.checkbox');
        });
    });

    // Auto Update
    Route::group(['prefix' => 'developer-section'], function () {
        Route::get('/', [DeveloperSectionController::class, 'index'])->name('admin.developer-section.index');
        Route::post('/', [DeveloperSectionController::class, 'submit'])->name('admin.developer-section.submit');
        Route::post('/bug-update-setting', [DeveloperSectionController::class, 'bugUpdateSetting'])->name('admin.bug-update-setting.submit');
        Route::post('/version-upgrade-setting', [DeveloperSectionController::class, 'versionUpgradeSetting'])->name('admin.version-upgrade-setting.submit');
    });

    Route::get('/new-release', [ClientAutoUpdateController::class, 'newVersionReleasePage'])->name('new-release');
    Route::get('/bugs', [ClientAutoUpdateController::class, 'bugUpdatePage'])->name('bug-update-page');
    // Action on Client server
    Route::post('version-upgrade', [ClientAutoUpdateController::class, 'versionUpgrade'])->name('version-upgrade');
    Route::post('bug-update', [ClientAutoUpdateController::class, 'bugUpdate'])->name('bug-update');


    // ==================== Laravel Socialite ===============



    // Route::get('/auth/redirect', function () {
    //     return Socialite::driver('google')->redirect();
    // });

    // Route::get('/auth/callback', function () {
    //     $user = Socialite::driver('google')->user();
    //     // $user->token
    // });

    // Route::get('/auth/google/callback', function () {
    //     dd('redirect Google');
    //     // $user = Socialite::driver('google')->user();
    //     // $user->token
    // });
});


Route::group(['prefix' => 'auth'], function () {

    Route::group(['prefix' => 'google'], function () {
        Route::controller(GoogleAuthController::class)->group(function () {
            Route::get('/redirect', 'redirect')->name('auth.redirect.google');
            Route::get('/callback', 'callback');
        });
    });

});






//
//Route::group(['prefix' => 'api', 'middleware' => 'auth'], function ()
//{
//	Route::get('find', function (Illuminate\Http\Request $request)
//	{
//		$keyword = $request->input('keyword');
//		Log::info($keyword);
//		$names = DB::table('employees')->where('first_name', 'like', '%' . $keyword . '%')
//			->orWhere('last_name', 'like', '%' . $keyword . '%')
//			->select('employees.id', DB::raw("CONCAT(employees.first_name,' ',employees.last_name) as full_name"))
//			->get();
//
//		return json_encode($names);
//	})->name('api.names');
//});

//Employeer
//Set Null
