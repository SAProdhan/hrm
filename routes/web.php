<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



// <?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Login*/
Route::get('/','App\Http\Controllers\UserController@login');
Route::post('user/get-login','App\Http\Controllers\UserController@getLogin');

/*Forgot Password*/
Route::get('forgot-password','App\Http\Controllers\UserController@forgotPassword');
Route::post('forgot-password-token','App\Http\Controllers\UserController@forgotPasswordToken');
Route::get('forgot-password-token-code/{token}','App\Http\Controllers\UserController@forgotPasswordTokenCode');


/*Logout*/
Route::get('user/logout','App\Http\Controllers\UserController@logout');

/*Dashboard*/
Route::get('dashboard','App\Http\Controllers\UserController@dashboard');

/*Profile Edit*/
Route::get('user/edit-profile','App\Http\Controllers\UserController@editProfile');
Route::post('user/post-user-personal-info','App\Http\Controllers\UserController@postUserPersonalInfo');
Route::post('user/update-user-avatar','App\Http\Controllers\UserController@updateUserAvatar');
Route::get('user/change-password','App\Http\Controllers\UserController@changePassword');
Route::post('user/update-user-password','App\Http\Controllers\UserController@updateUserPassword');

/*Designation Module*/
Route::get('designations','App\Http\Controllers\DesignationsController@designations');
Route::post('designations/add','App\Http\Controllers\DesignationsController@addDesignation');
Route::get('designations/delete/{id}','App\Http\Controllers\DesignationsController@deleteDesignation');
Route::post('designation/update','App\Http\Controllers\DesignationsController@updateDesignation');

/*Department Module*/
Route::get('departments','App\Http\Controllers\DepartmentController@departments');
Route::post('departments/add','App\Http\Controllers\DepartmentController@addDepartment');
Route::get('departments/delete/{id}','App\Http\Controllers\DepartmentController@deleteDepartment');
Route::post('departments/update','App\Http\Controllers\DepartmentController@updateDepartment');
Route::post('departments/get-employee','App\Http\Controllers\DepartmentController@getEmployee');

/*Employee Module*/
Route::get('employees/all','App\Http\Controllers\EmployeeController@allEmployees');
Route::get('employees/add','App\Http\Controllers\EmployeeController@addEmployee');
Route::post('employees/add-employee-post','App\Http\Controllers\EmployeeController@addEmployeePost');
Route::get('employees/view/{id}','App\Http\Controllers\EmployeeController@viewEmployee');
Route::post('employees/post-employee-personal-info','App\Http\Controllers\EmployeeController@postEmployeePersonalInfo');
Route::post('employees/update-employee-avatar','App\Http\Controllers\EmployeeController@updateEmployeeAvatar');
Route::post('employee/get-designation','App\Http\Controllers\EmployeeController@getDesignation');
Route::post('employee/get-uid','App\Http\Controllers\EmployeeController@getUid');
Route::post('employee/add-bank-account','App\Http\Controllers\EmployeeController@addBankInfo');
Route::get('employee/delete-bank-account/{id}','App\Http\Controllers\EmployeeController@deleteBankAccount');
Route::post('employee/add-document','App\Http\Controllers\EmployeeController@addDocument');
Route::get('employee/download-employee-document/{id}','App\Http\Controllers\EmployeeController@downloadEmployeeDocument');
Route::get('employee/delete-employee-doc/{id}','App\Http\Controllers\EmployeeController@deleteEmployeeDoc');
Route::get('employee/delete-employee/{id}','App\Http\Controllers\EmployeeController@deleteEmployee');
Route::get('employees/device','App\Http\Controllers\EmployeeController@employeetodevice');
Route::post('employees/device','App\Http\Controllers\EmployeeController@addEmployeeToDevice');
Route::post('employees/device-remove','App\Http\Controllers\EmployeeController@removeEmployeeFromDevice');

/*Job Application Module*/
Route::get('jobs','App\Http\Controllers\JobController@jobs');
Route::post('jobs/post-new-job','App\Http\Controllers\JobController@postNewJob');
Route::get('jobs/edit/{id}','App\Http\Controllers\JobController@editJob');
Route::post('jobs/job-edit-post','App\Http\Controllers\JobController@postEditJob');
Route::get('jobs/delete-job/{id}','App\Http\Controllers\JobController@deleteJob');
Route::get('jobs/view-applicant/{id}','App\Http\Controllers\JobController@viewApplicant');
Route::get('jobs/download-resume/{id}','App\Http\Controllers\JobController@downloadResume');
Route::get('jobs/delete-application/{id}','App\Http\Controllers\JobController@deleteApplication');
Route::post('jobs/set-applicant-status','App\Http\Controllers\JobController@setApplicantStatus');


/*Setting Module*/
Route::get('settings/general','App\Http\Controllers\SettingController@general');
Route::post('settings/post-general-setting','App\Http\Controllers\SettingController@postGeneralSetting');
Route::post('settings/post-office-time','App\Http\Controllers\SettingController@postOfficeTime');
Route::post('settings/post-expense-title','App\Http\Controllers\SettingController@postExpenseTitle');
Route::post('settings/post-leave-type','App\Http\Controllers\SettingController@postLeaveType');
Route::post('settings/post-award-name','App\Http\Controllers\SettingController@postAwardName');
Route::post('settings/post-job-file-extension','App\Http\Controllers\SettingController@postJobFileExtension');
Route::get('settings/localization','App\Http\Controllers\SettingController@localization');
Route::post('settings/localization-post','App\Http\Controllers\SettingController@localizationPost');
Route::get('settings/language-settings','App\Http\Controllers\SettingController@languageSettings');
Route::post('settings/language-settings/add','App\Http\Controllers\SettingController@addLanguage');
Route::get('settings/language-settings-translate/{lid}','App\Http\Controllers\SettingController@translateLanguage');
Route::post('settings/language-settings-translate-post','App\Http\Controllers\SettingController@translateLanguagePost');
Route::get('settings/language-settings-manage/{lid}','App\Http\Controllers\SettingController@languageSettingsManage');
Route::post('settings/language-settings-manage-post','App\Http\Controllers\SettingController@languageSettingManagePost');
Route::get('settings/language-settings/delete/{lid}','App\Http\Controllers\SettingController@deleteLanguage');

// Route::get('settings/shiftin-plan','App\Http\Controllers\ShiftingPlanController@index')->name('shift.plan');
Route::resource('settings/shiftin-plan','App\Http\Controllers\ShiftingPlanController');
Route::resource('settings/device','App\Http\Controllers\DevicesController');

/*Shift and Schedule module */
Route::resource('settings/schedule','App\Http\Controllers\ScheduleController');
Route::resource('settings/shift','App\Http\Controllers\ShiftController');

/*Language Change*/
Route::get('language/change/{id}','App\Http\Controllers\SettingController@languageChange');

/*Expense Settings*/
Route::get('settings/delete-expense/{id}','App\Http\Controllers\SettingController@deleteExpense');
Route::post('settings/update-expense-title','App\Http\Controllers\SettingController@updateExpenseTitle');

/*Leave Settings*/
Route::get('settings/delete-leave/{id}','App\Http\Controllers\SettingController@deleteLeave');
Route::post('settings/update-leave-type','App\Http\Controllers\SettingController@updateLeaveType');


/*Award Settings*/
Route::get('settings/delete-award/{id}','App\Http\Controllers\SettingController@deleteAward');
Route::post('settings/update-award-name','App\Http\Controllers\SettingController@updateAwardName');


/*Award Module*/
Route::get('award','App\Http\Controllers\AwardController@award');
Route::post('award/post-new-award','App\Http\Controllers\AwardController@postNewAward');
Route::get('award/delete-award/{id}','App\Http\Controllers\AwardController@deleteAward');
Route::get('award/edit/{id}','App\Http\Controllers\AwardController@editAward');
Route::post('award/award-edit-post','App\Http\Controllers\AwardController@postEditAward');


/*Holiday Module*/
Route::get('holiday','App\Http\Controllers\HolidayController@holiday');
Route::get('holiday/ajax-event-calendar','App\Http\Controllers\HolidayController@eventCalendar');
Route::get('holiday/add','App\Http\Controllers\HolidayController@addHoliday');
Route::post('holiday/post-add-holiday','App\Http\Controllers\HolidayController@postAddHoliday');
Route::get('holiday/view-holiday/{id}','App\Http\Controllers\HolidayController@viewHoliday');
Route::get('holiday/delete-holiday/{id}','App\Http\Controllers\HolidayController@deleteHoliday');
Route::post('holiday/post-edit-holiday','App\Http\Controllers\HolidayController@postEditHoliday');


/*Leave Module*/
Route::get('leave','App\Http\Controllers\LeaveController@leave');
Route::get('leave/edit/{id}','App\Http\Controllers\LeaveController@viewLeave');
Route::post('leave/post-job-status','App\Http\Controllers\LeaveController@postJobStatus');
Route::post('leave/post-new-leave','App\Http\Controllers\LeaveController@postNewLeave');
Route::get('leave/delete-leave-application/{id}','App\Http\Controllers\LeaveController@deleteLeaveApplication');

/*Notice Module*/
Route::get('notice-board','App\Http\Controllers\NoticeController@noticeBoard');
Route::post('notice-board/post-new-notice','App\Http\Controllers\NoticeController@postNewNotice');
Route::get('notice-board/delete-notice/{id}','App\Http\Controllers\NoticeController@deleteNotice');
Route::get('notice-board/edit/{id}','App\Http\Controllers\NoticeController@editNotice');
Route::post('notice-board/edit-notice-post','App\Http\Controllers\NoticeController@postEditNotice');

/*Expense Module*/
Route::get('expense','App\Http\Controllers\ExpenseController@expense');
Route::post('expense/post-new-expense','App\Http\Controllers\ExpenseController@postExpense');
Route::get('expense/download-bill-copy/{id}','App\Http\Controllers\ExpenseController@downloadBillCopy');
Route::get('expense/delete-expense/{id}','App\Http\Controllers\ExpenseController@deleteExpense');
Route::get('expense/edit/{id}','App\Http\Controllers\ExpenseController@editExpense');
Route::post('expense/expense-edit-post','App\Http\Controllers\ExpenseController@postEditExpense');


/*Task Module*/
Route::get('task','App\Http\Controllers\TaskController@task');
Route::post('task/post-new-task','App\Http\Controllers\TaskController@postNewTask');
Route::get('task/edit/{id}','App\Http\Controllers\TaskController@editTask');
Route::post('task/task-edit-post','App\Http\Controllers\TaskController@postEditTask');
Route::get('task/view/{id}','App\Http\Controllers\TaskController@viewTask');
Route::post('task/task-basic-info-post','App\Http\Controllers\TaskController@postBasicTaskInfo');
Route::post('task/post-task-comments','App\Http\Controllers\TaskController@postTaskComments');
Route::post('task/post-task-files','App\Http\Controllers\TaskController@postTaskFiles');
Route::get('task/download-file/{id}','App\Http\Controllers\TaskController@downloadTaskFIle');
Route::get('task/delete-task-file/{id}','App\Http\Controllers\TaskController@deleteTaskFIle');
Route::get('task/delete-task/{id}','App\Http\Controllers\TaskController@deleteTask');

/*Attendance Module */
Route::get('attendance/report','App\Http\Controllers\AttendanceController@report');
Route::get('attendance/update','App\Http\Controllers\AttendanceController@update');
Route::post('attendance/post-update-attendance','App\Http\Controllers\AttendanceController@postUpdateAttendance');
Route::post('attendance/post-update-attendance-device','App\Http\Controllers\AttendanceController@postUpdateAttendanceDevice');
Route::post('attendance/get-designation','App\Http\Controllers\AttendanceController@getDesignation');
Route::post('attendance/post-custom-search','App\Http\Controllers\AttendanceController@postCustomSearch');
Route::get('attendance/edit/{id}','App\Http\Controllers\AttendanceController@editAttendance');
Route::post('attendance/post-edit-attendance','App\Http\Controllers\AttendanceController@postEditAttendance');
Route::get('attendance/delete-attendance/{id}','App\Http\Controllers\AttendanceController@deleteAttendance');
Route::post('attendance/set-overtime','App\Http\Controllers\AttendanceController@postSetOvertime');


/*Support Ticket Module*/
Route::get('support-tickets/all','App\Http\Controllers\SupportTicketController@all');
Route::get('support-tickets/create-new','App\Http\Controllers\SupportTicketController@createNew');
Route::get('support-tickets/view-ticket/{id}','App\Http\Controllers\SupportTicketController@viewTicket');
Route::get('support-tickets/department','App\Http\Controllers\SupportTicketController@department');
Route::get('support-tickets/view-department/{id}','App\Http\Controllers\SupportTicketController@viewDepartment');
Route::get('support-tickets/ticket-department/{id}','App\Http\Controllers\SupportTicketController@ticketDepartment');
Route::get('support-tickets/ticket-status/{id}','App\Http\Controllers\SupportTicketController@ticketStatus');
Route::post('support-tickets/post-department','App\Http\Controllers\SupportTicketController@postDepartment');
Route::post('support-tickets/update-department','App\Http\Controllers\SupportTicketController@updateDepartment');
Route::post('support-tickets/post-ticket','App\Http\Controllers\SupportTicketController@postTicket');
Route::post('support-tickets/ticket-update-department','App\Http\Controllers\SupportTicketController@updateTicketDepartment');
Route::post('support-tickets/ticket-update-status','App\Http\Controllers\SupportTicketController@updateTicketStatus');
Route::post('support-tickets/replay-ticket','App\Http\Controllers\SupportTicketController@replayTicket');
Route::get('support-tickets/delete-ticket/{id}','App\Http\Controllers\SupportTicketController@deleteTicket');
Route::get('support-tickets/delete-department/{id}','App\Http\Controllers\SupportTicketController@deleteDepartment');
Route::post('support-ticket/basic-info-post','App\Http\Controllers\SupportTicketController@postBasicInfo');
Route::post('support-ticket/post-ticket-files','App\Http\Controllers\SupportTicketController@postTicketFiles');
Route::get('support-ticket/download-file/{id}','App\Http\Controllers\SupportTicketController@downloadTicketFile');
Route::get('support-ticket/delete-ticket-file/{id}','App\Http\Controllers\SupportTicketController@deleteTicketFile');


/*Payroll Module*/
Route::get('payroll/employee-salary-list','App\Http\Controllers\PayrollController@employeeSalaryList');
Route::get('payroll/employee-salary-edit/{id}','App\Http\Controllers\PayrollController@editEmployeeSalary');
Route::post('payroll/edit-employee-salary-post','App\Http\Controllers\PayrollController@postEditEmployeeSalary');
Route::get('payroll/make-payment','App\Http\Controllers\PayrollController@makePayment');
Route::post('payroll/make-payment/post-custom-search','App\Http\Controllers\PayrollController@postCustomSearch');
Route::post('payroll/get-designation','App\Http\Controllers\PayrollController@getDesignation');
Route::get('payroll/generate','App\Http\Controllers\PayrollController@generatePayslip');
Route::get('payroll/pay-payment/{emp_id}/{date}','App\Http\Controllers\PayrollController@payPayment');
Route::post('payroll/pay-payment-post','App\Http\Controllers\PayrollController@payPaymentPost');
Route::post('payroll/payslip/post-custom-search','App\Http\Controllers\PayrollController@postPayslipCustomSearch');
Route::get('payroll/view-details/{id}','App\Http\Controllers\PayrollController@viewDetails');
Route::get('payroll/print-payslip/{id}','App\Http\Controllers\PayrollController@printPayslip');
Route::get('payroll/employee-salary-increment','App\Http\Controllers\PayrollController@employeeSalaryIncrement');
Route::get('payroll/employee-salary-increment-edit/{id}','App\Http\Controllers\PayrollController@editEmployeeSalaryIncrement');
Route::post('payroll/edit-employee-salary-increment-post','App\Http\Controllers\PayrollController@postEditEmployeeSalaryIncrement');


/*Provident Fund*/
Route::get('provident-fund/all','App\Http\Controllers\PayrollController@providentFund');
Route::post('provident-fund/post-new-provident-fund','App\Http\Controllers\PayrollController@postProvidentFund');
Route::get('provident-fund/view-details/{id}','App\Http\Controllers\PayrollController@viewProvidentFund');
Route::post('provident-fund/edit-post','App\Http\Controllers\PayrollController@postEditProvidentFund');
Route::get('provident-fund/delete/{id}','App\Http\Controllers\PayrollController@deleteProvidentFund');
Route::post('provident-fund/make-payment','App\Http\Controllers\PayrollController@makePaymentProvidentFund');
Route::get('provident-fund/view-payslip/{id}','App\Http\Controllers\PayrollController@payslipProvidentFund');
Route::get('provident-fund/print-payslip/{id}','App\Http\Controllers\PayrollController@printPayslipProvidentFund');

/*Loan Module*/
Route::get('loan/all','App\Http\Controllers\PayrollController@loan');
Route::post('loan/post-new-loan','App\Http\Controllers\PayrollController@postNewLoan');
Route::get('loan/view-details/{id}','App\Http\Controllers\PayrollController@viewDetailsLoan');
Route::post('loan/edit-post','App\Http\Controllers\PayrollController@postEditLoan');
Route::get('loan/delete/{id}','App\Http\Controllers\PayrollController@deleteLoan');



/*Email Template Module*/
Route::get('settings/email-templates','App\Http\Controllers\SettingController@emailTemplates');
Route::get('settings/email-template-manage/{id}','App\Http\Controllers\SettingController@manageTemplate');
Route::post('settings/email-templates-update','App\Http\Controllers\SettingController@updateTemplate');

/*Tax Rules*/
Route::get('settings/tax-rules','App\Http\Controllers\SettingController@taxRules');
Route::post('tax-rules/post-new-tax','App\Http\Controllers\SettingController@postNewTax');
Route::get('tax-rules/set-rules/{tid}','App\Http\Controllers\SettingController@setRules');
Route::post('tax-rules/post-set-rules','App\Http\Controllers\SettingController@postSetRules');
Route::get('tax-rules/delete-tax-rule/{tid}','App\Http\Controllers\SettingController@deleteTaxRule');
Route::post('tax-rules/post-update-tax-rules','App\Http\Controllers\SettingController@postUpdateTaxRules');

/*SMS Gateways*/
Route::get('settings/sms-gateways','App\Http\Controllers\SettingController@smsGateways');
Route::get('settings/sms-gateways-manage/{id}','App\Http\Controllers\SettingController@smsGatewayManage');
Route::post('settings/sms-gateway-update','App\Http\Controllers\SettingController@smsGatewayUpdate');



/*Reports Module*/

Route::get('reports/payroll','App\Http\Controllers\ReportsController@payrollSummery');
Route::post('reports/get-salary-statement','App\Http\Controllers\ReportsController@getSalaryStatement');
Route::get('reports/print-salary-statement/{id}/{date_from}/{date_to}','App\Http\Controllers\ReportsController@printSalaryStatement');
Route::get('reports/employee-summery/{id}','App\Http\Controllers\ReportsController@employeeSummery');
Route::get('reports/job-applicants','App\Http\Controllers\ReportsController@jobApplicants');
Route::post('reports/send-email-to-applicants','App\Http\Controllers\ReportsController@sendEmailApplicant');
Route::post('reports/send-sms-to-applicants','App\Http\Controllers\ReportsController@sendSMSApplicant');
Route::post('reports/send-sms-salary-statement','App\Http\Controllers\ReportsController@sendSMSSalaryStatement');
Route::post('reports/send-email-salary-statement','App\Http\Controllers\ReportsController@sendEmailSalaryStatement');

/*Attendance Report */
Route::get('reports/attendance-daily-present','App\Http\Controllers\ReportsController@get_att_daily_present_report');
Route::post('reports/attendance-daily-present','App\Http\Controllers\ReportsController@att_daily_present_report');
Route::post('reports/attendance-month-wise-pdf','App\Http\Controllers\ReportsController@att_daily_present_report_pdf');
Route::get('reports/attendance-date-wise','App\Http\Controllers\ReportsController@get_att_date_wise_report');
Route::post('reports/attendance-date-wise','App\Http\Controllers\ReportsController@att_date_wise_report');
Route::get('reports/attendance-date-wise-pdf/{date}/{emp_id?}','App\Http\Controllers\ReportsController@att_date_wise_report_pdf');
Route::get('reports/attendance-month-wise','App\Http\Controllers\ReportsController@get_att_month_wise_report');
Route::post('reports/attendance-month-wise','App\Http\Controllers\ReportsController@att_month_wise_report');
Route::get('reports/attendance-month-wise-pdf/{month}/{emp_id?}','App\Http\Controllers\ReportsController@att_month_wise_report_pdf');
Route::post('reports/attendance-monthly','App\Http\Controllers\ReportsController@att_monthly_report');
Route::get('reports/attendance-monthly','App\Http\Controllers\ReportsController@get_att_monthly_report');
Route::get('reports/attendance-monthly/{month}/{emp_id?}','App\Http\Controllers\ReportsController@att_monthly_report_pdf');


/*Employee Portal*/

/*Employee Dashboard*/
Route::get('employee/dashboard','App\Http\Controllers\UserController@employeeDashboard');

/*Logout*/
Route::get('employee/logout','App\Http\Controllers\UserController@logout');

/*Profile Edit*/
Route::get('employee/edit-profile','App\Http\Controllers\UserController@editEditProfile');
Route::post('employee/post-employee-personal-info','App\Http\Controllers\UserController@postEmployeePersonalInfo');
Route::post('employee/update-employee-avatar','App\Http\Controllers\UserController@updateEmployeeAvatar');
Route::get('employee/change-password','App\Http\Controllers\UserController@changeEmployeePassword');
Route::post('employee/update-employee-password','App\Http\Controllers\UserController@updateEmployeePassword');

/*Employee Holiday*/
Route::get('employee/holiday','App\Http\Controllers\EmployeePortalController@holiday');
Route::get('employee/holiday/ajax-event-calendar','App\Http\Controllers\EmployeePortalController@eventCalendar');

/*Employee Award*/
Route::get('employee/award','App\Http\Controllers\EmployeePortalController@award');

/*Employee Leave*/
Route::get('employee/leave','App\Http\Controllers\EmployeePortalController@leave');
Route::post('employee/leave/post-new-leave','App\Http\Controllers\EmployeePortalController@postNewLeave');

/*Employee Notice Board*/
Route::get('employee/notice-board','App\Http\Controllers\EmployeePortalController@noticeBoard');

/*Employee Expense*/
Route::get('employee/expense','App\Http\Controllers\EmployeePortalController@expense');
Route::post('employee/expense/post-new-expense','App\Http\Controllers\EmployeePortalController@postExpense');

/*Employee Support Ticket*/
Route::get('employee/support-tickets/all','App\Http\Controllers\EmployeePortalController@allSupportTickets');
Route::get('employee/support-tickets/create-new','App\Http\Controllers\EmployeePortalController@createNewTicket');
Route::post('employee/support-tickets/post-ticket','App\Http\Controllers\EmployeePortalController@postTicket');
Route::get('employee/support-tickets/view-ticket/{id}','App\Http\Controllers\EmployeePortalController@viewTicket');
Route::post('employee/support-tickets/replay-ticket','App\Http\Controllers\EmployeePortalController@replayTicket');
Route::post('employee/support-ticket/post-ticket-files','App\Http\Controllers\EmployeePortalController@postTicketFiles');
Route::get('employee/support-ticket/download-file/{id}','App\Http\Controllers\EmployeePortalController@downloadTicketFile');

/*Employee Payroll*/
Route::get('employee/payslip','App\Http\Controllers\EmployeePortalController@paySlip');
Route::get('employee/payslip/view/{id}','App\Http\Controllers\EmployeePortalController@viewPaySlip');
Route::get('employee/payslip/print-payslip/{id}','App\Http\Controllers\EmployeePortalController@printPaySlip');

/*Employee Task*/
Route::get('employee/task','App\Http\Controllers\EmployeePortalController@task');
Route::get('employee/task/view/{id}','App\Http\Controllers\EmployeePortalController@viewTask');
Route::post('employee/task/post-task-comments','App\Http\Controllers\EmployeePortalController@postTaskComments');
Route::post('employee/task/post-task-files','App\Http\Controllers\EmployeePortalController@postTaskFiles');
Route::get('employee/task/download-file/{id}','App\Http\Controllers\EmployeePortalController@downloadTaskFIle');


/*Apply Job*/
Route::get('apply-job','App\Http\Controllers\UserController@applyJob');
Route::get('apply-job/details/{id}','App\Http\Controllers\UserController@applyJobDetails');
Route::post('apply-job/post-applicant-resume','App\Http\Controllers\UserController@postApplicantResume');

/*Clock In, Out*/
Route::post('employee/attendance/set_clocking','App\Http\Controllers\EmployeePortalController@setClocking');

/*Loan*/
Route::get('employee/loan/all','App\Http\Controllers\EmployeePortalController@allLoan');
Route::post('employee/loan/post-new-loan','App\Http\Controllers\EmployeePortalController@postNewLoan');
Route::get('employee/loan/view-details/{id}','App\Http\Controllers\EmployeePortalController@viewLoanDetails');
Route::post('employee/loan/edit-post','App\Http\Controllers\EmployeePortalController@postEditLoan');




/*For Admin Portal*/

Route::get('payroll/download-pdf/{id}','App\Http\Controllers\PayrollController@downloadPdf');
Route::get('reports/pdf-salary-statement/{id}/{date_from}/{date_to}','App\Http\Controllers\ReportsController@pdfSalaryStatement');

/*Training*/

Route::get('training/trainers','App\Http\Controllers\TrainingController@trainers');
Route::post('training/post-new-trainer','App\Http\Controllers\TrainingController@postNewTrainer');
Route::get('training/delete-trainer/{id}','App\Http\Controllers\TrainingController@deleteTrainer');
Route::get('training/view-trainers-info/{id}','App\Http\Controllers\TrainingController@viewTrainersInfo');
Route::post('training/post-trainer-update-info','App\Http\Controllers\TrainingController@postTrainerUpdateInfo');
Route::get('training/employee-training','App\Http\Controllers\TrainingController@employeeTraining');
Route::post('training/post-new-training','App\Http\Controllers\TrainingController@postNewTraining');
Route::get('training/delete-employee-training/{id}','App\Http\Controllers\TrainingController@deleteEmployeeTraining');
Route::get('training/view-employee-training/{id}','App\Http\Controllers\TrainingController@viewEmployeeTraining');
Route::post('training/post-employee-training-info','App\Http\Controllers\TrainingController@postEmployeeTrainingInfo');
Route::get('training/training-needs-assessment','App\Http\Controllers\TrainingController@trainingNeedsAssessment');
Route::post('training/post-new-training-needs-assessment','App\Http\Controllers\TrainingController@postNewTrainingNeedsAssessment');
Route::get('training/delete-training-needs-assessment/{id}','App\Http\Controllers\TrainingController@deleteTrainingNeedsAssessment');
Route::get('training/view-training-needs-assessment/{id}','App\Http\Controllers\TrainingController@viewTrainingNeedsAssessment');
Route::get('training/view-training-needs-assessment/{id}','App\Http\Controllers\TrainingController@viewTrainingNeedsAssessment');
Route::post('training/post-training-needs-assessment-update','App\Http\Controllers\TrainingController@postTrainingNeedsAssessmentUpdate');
Route::get('training/training-events','App\Http\Controllers\TrainingController@trainingEvents');
Route::post('training/post-new-training-event','App\Http\Controllers\TrainingController@postNewTrainingEvent');
Route::get('training/delete-training-event/{id}','App\Http\Controllers\TrainingController@deleteTrainingEvent');
Route::get('training/view-training-events/{id}','App\Http\Controllers\TrainingController@viewTrainingEvent');
Route::post('training/post-training-events-update','App\Http\Controllers\TrainingController@postTrainingEventUpdate');
Route::get('training/evaluations','App\Http\Controllers\TrainingController@TrainingEvaluations');
Route::post('training/post-training-evaluations','App\Http\Controllers\TrainingController@postTrainingEvaluations');
Route::post('training/update-training-evaluations','App\Http\Controllers\TrainingController@updateTrainingEvaluations');
Route::get('training/delete-training-evaluations/{id}','App\Http\Controllers\TrainingController@deleteTrainingEvaluations');

/*For Employee Role management*/

Route::get('employees/roles','App\Http\Controllers\EmployeeController@employeeRoles');
Route::post('employees/add-roles','App\Http\Controllers\EmployeeController@addEmployeeRoles');
Route::post('employees/update-role','App\Http\Controllers\EmployeeController@updateEmployeeRoles');
Route::get('employees/set-roles/{id}','App\Http\Controllers\EmployeeController@setEmployeeRoles');
Route::post('employees/update-employee-set-roles','App\Http\Controllers\EmployeeController@updateEmployeeSetRoles');
Route::get('employees/delete-roles/{id}','App\Http\Controllers\EmployeeController@deleteEmployeeRoles');

/*Permission Check*/
Route::get('permission-error','App\Http\Controllers\UserController@permissionError');


Route::get('attendance/get-all-pdf-report','App\Http\Controllers\AttendanceController@getAllPdfReport');
Route::get('attendance/get-pdf-report/{date}/{emp_id?}/{dep_id?}/{des_id?}','App\Http\Controllers\AttendanceController@getPdfReport');


/*
|--------------------------------------------------------------------------
| Disable Menu For specific Employee
|--------------------------------------------------------------------------
|
| You can show hide Admin Menu/Employee Menu for specific Employee
|
*/
Route::get('settings/disable-menus','App\Http\Controllers\SettingController@disableMenus');
Route::get('settings/disable-menus-manage/{id}','App\Http\Controllers\SettingController@disableMenusManage');
Route::post('settings/disable-menus-post','App\Http\Controllers\SettingController@disableMenusManagePost');

/*Employee Portal*/
Route::get('employee/attendance','App\Http\Controllers\EmployeePortalController@attendance');
Route::get('employee/training','App\Http\Controllers\EmployeePortalController@training');
Route::get('employee/training/view/{id}','App\Http\Controllers\EmployeePortalController@viewTraining');

/*Update Application*/
Route::get('update','App\Http\Controllers\UserController@updateApplication');