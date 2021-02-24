<?php

namespace App\Http\Controllers;

use App\AwardList;
use App\Attendance;
use App\Classes\permission;
use App\Employee;
use App\JobApplicants;
use App\Leave;
use App\Loan;
use App\Payroll;
use App\ProvidentFund;
use App\SMSGateway;
use App\Department;
use App\Designation;
use Dompdf\Adapter\CPDF;
use Illuminate\Http\Request;
use PDF;

use App\Http\Requests;
use Illuminate\Support\Facades\Request as Input;
use League\Flysystem\Exception;
use Twilio\Rest\Client;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* payrollSummery  Function Start Here */
    public function payrollSummery()
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $employees = Employee::where('user_name','!=','admin')->where('status', 'active')->get();
        return view('admin.payroll-summery', compact('employees'));
    }

    /* getSalaryStatement  Function Start Here */
    public function getSalaryStatement(Request $request)
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v = \Validator::make($request->all(), [
            'date_from' => 'required', 'date_to' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('reports/payroll')->withErrors($v->errors());
        }

        $cmd = Input::get('cmd');
        $date_from = Input::get('date_from');
        $date_to = Input::get('date_to');

        $date_from = date('Y-m-01', strtotime($date_from));
        $date_to = date('Y-m-t', strtotime($date_to));

        $payslip = Payroll::where('emp_id', $cmd)->first();

        if ($payslip==''){
            return redirect('reports/payroll')->with([
                'message'=> language_data('User pay transaction data not found'),
                'message_important'=>true
            ]);
        }

        $payroll = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->get();

        $net_salary = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('net_salary');
        $over_time = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('overtime_salary');
        $tax = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('tax');
        $provident_fund = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('provident_fund');
        $loan = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('loan');
        $total_salary = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('total_salary');
        $attendance_panelty = Payroll::where('emp_id', $cmd)->whereBetween('payment_date', [$date_from, $date_to])->sum('attendance_panelty');


        return view('admin.employee-salary-statement', compact('payroll', 'payslip', 'cmd', 'date_from', 'date_to', 'net_salary', 'over_time', 'tax', 'provident_fund', 'loan', 'total_salary', 'attendance_panelty'));


    }

    /* printSalaryStatement  Function Start Here */
    public function printSalaryStatement($id, $date_from, $date_to)
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=date('Y-m-d',strtotime($date_to));

        $payslip = Payroll::where('emp_id', $id)->first();
        $payroll = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->get();

        $net_salary = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('net_salary');
        $over_time = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('overtime_salary');
        $tax = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('tax');
        $provident_fund = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('provident_fund');
        $loan = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('loan');
        $total_salary = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('total_salary');


        return view('admin.print-salary-statement', compact('payroll', 'payslip', 'id', 'date_from', 'date_to', 'net_salary', 'over_time', 'tax', 'provident_fund', 'loan', 'total_salary'));
    }

    /* employeeSummery  Function Start Here */
    public function employeeSummery($id)
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $employee = Employee::find($id);
        $loan = Loan::where('emp_id', $id)->get();
        $provident_fund = ProvidentFund::where('emp_id', $id)->get();
        $award = AwardList::where('emp_id', $id)->get();
        $leave = Leave::where('employee_id', $id)->get();

        return view('admin.employee-summery', compact('employee', 'provident_fund', 'loan', 'award', 'leave'));
    }


    /* jobApplicants  Function Start Here */
    public function jobApplicants()
    {
        $self='job-applicants';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $job_applicants = JobApplicants::where('status', '!=', 'Unread')->where('status', '!=', 'Rejected')->get();

        return view('admin.job-applicants-summery', compact('job_applicants'));
    }

    /* sendEmailApplicant  Function Start Here */
    public function sendEmailApplicant(Request $request)
    {
        $self='job-applicants';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'email' => 'required', 'subject' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('reports/job-applicants')->withErrors($v->errors());
        }

        $applicant = JobApplicants::find($request->cmd)->name;
        $email = Input::get('email');
        $subject = Input::get('subject');
        $message = Input::get('message');

        $sysEmail = app_config('Email');
        $sysCompany = app_config('AppName');
        $default_gt = app_config('Gateway');

        if ($default_gt == 'default') {

            $mail = new \PHPMailer();

            $mail->setFrom($sysEmail, $sysCompany);
            $mail->addAddress($email, $applicant);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('Please check your email setting'),
                    'message_important' => true
                ]);
            } else {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('Email send successfully')
                ]);
            }

        } else {
            $host = app_config('SMTPHostName');
            $smtp_username = app_config('SMTPUserName');
            $stmp_password = app_config('SMTPPassword');
            $port = app_config('SMTPPort');
            $secure = app_config('SMTPSecure');


            $mail = new \PHPMailer();

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $smtp_username;                 // SMTP username
            $mail->Password = $stmp_password;                           // SMTP password
            $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;

            $mail->setFrom($sysEmail, $sysCompany);
            $mail->addAddress($email, $applicant);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body = $message;


            if (!$mail->send()) {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('Please check your email setting'),
                    'message_important' => true
                ]);
            } else {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('Email send successfully')
                ]);
            }
        }

    }

    /* sendSMSApplicant  Function Start Here */
    public function sendSMSApplicant(Request $request)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('reports/job-applicants')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='job-applicants';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'phone' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('reports/job-applicants')->withErrors($v->errors());
        }

        $phone = Input::get('phone');
        $message = Input::get('message');
        $sender_id=app_config('AppName');

        $sms_gateway = SMSGateway::where('status', 'Active')->first();
        $gateway_name = $sms_gateway->name;

        if ($gateway_name == 'Twilio') {
            $sid = $sms_gateway->user_name;
            $token = $sms_gateway->password;

            try {

                $client = new Client($sid, $token);
                $response = $client->account->messages->create(
                    "$phone",
                    array(
                        'from' => '+15005550006',
                        'body' => $message
                    )
                );

                if ($response->sid!='') {
                    return redirect('reports/job-applicants')->with([
                        'message' => language_data('SMS sent successfully')
                    ]);
                } else {
                    return redirect('reports/job-applicants')->with([
                        'message' => language_data('Please check your Twilio Credentials'),
                        'message_important'=>true
                    ]);
                }
            } catch (Exception $e) {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('Please check your Twilio Credentials'),
                    'message_important'=>true
                ]);
            }


        } elseif ($gateway_name == 'Route SMS') {

            $sms_url=$sms_gateway->api_link;
            $user=$sms_gateway->user_name;
            $password=$sms_gateway->password;

            $sms_sent_to_user = "$sms_url" . "?type=0" . "&username=$user" . "&password=$password" ."&destination=$phone" . "&source=$sender_id" . "&message=$message" . "&dlr=1";
            $get_sms_status=file_get_contents($sms_sent_to_user);
            $get_sms_status = str_replace("1701", language_data('Success'), $get_sms_status);
            $get_sms_status = str_replace("1709", language_data('User Validation Failed'), $get_sms_status);
            $get_sms_status = str_replace("1025", language_data('Insufficient Credit'), $get_sms_status);
            $get_sms_status = str_replace("1710", language_data('Internal Error'), $get_sms_status);
            $get_sms_status = str_replace("1706", language_data('Invalid receiver'), $get_sms_status);
            $get_sms_status = str_replace("1705", language_data('Invalid SMS'), $get_sms_status);
            $get_sms_status = str_replace("1707", language_data('Invalid sender'), $get_sms_status);
            $get_sms_status = str_replace(",", " ", $get_sms_status);
            $pos = strpos($get_sms_status, language_data('Success'));

            if ($pos === false) {
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('SMS sent successfully')
                ]);
            } else {
                return redirect('reports/job-applicants')->with([
                    'message' => $get_sms_status,
                    'message_important'=>true
                ]);
            }



        } elseif ($gateway_name == 'Bulk SMS') {

            $sms_url=$sms_gateway->api_link;
            $user=$sms_gateway->user_name;
            $password=$sms_gateway->password;


            $url = "$sms_url" . "/eapi/submission/send_sms/2/2.0?username=$user" . "&password=$password" ."&msisdn=$phone" ."&message=".urlencode($message);


            $ret = file_get_contents($url);

            $send = explode("|",$ret);

            if ($send[0]=='0') {
                $get_sms_status= language_data('In progress');
            }elseif($send[0]=='1'){
                $get_sms_status= language_data('Scheduled');
            }elseif($send[0]=='22'){
                $get_sms_status= language_data('Internal Error');
            }elseif($send[0]=='23'){
                $get_sms_status= language_data('Authentication failure');
            }elseif($send[0]=='24'){
                $get_sms_status= language_data('Data validation failed');
            }elseif($send[0]=='25'){
                $get_sms_status= language_data('Insufficient Credit');
            }elseif($send[0]=='26'){
                $get_sms_status= language_data('Upstream credits not available');
            }elseif($send[0]=='27'){
                $get_sms_status= language_data('You have exceeded your daily quota');
            }elseif($send[0]=='28'){
                $get_sms_status= language_data('Upstream quota exceeded');
            }elseif($send[0]=='40'){
                $get_sms_status= language_data('Temporarily unavailable');
            }elseif($send[0]=='201'){
                $get_sms_status= language_data('Maximum batch size exceeded');
            }elseif($send[0]=='200'){
                $get_sms_status= language_data('Success');
            }
            else{
                $get_sms_status= language_data('Failed');
            }

            if($get_sms_status=='Success'){
                return redirect('reports/job-applicants')->with([
                    'message' => language_data('SMS sent successfully')
                ]);
            }else{
                return redirect('reports/job-applicants')->with([
                    'message' => $get_sms_status,
                    'message_important'=>true
                ]);
            }

        } else {
            return redirect('reports/job-applicants')->with([
                'message' => language_data('Gateway information not found'),
                'message_important' => true
            ]);
        }

    }


    /* sendSMSSalaryStatement  Function Start Here */
    public function sendSMSSalaryStatement(Request $request)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('reports/payroll')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'phone' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('reports/payroll')->withErrors($v->errors());
        }

        $phone = Input::get('phone');
        $message = Input::get('message');

        $sms_gateway = SMSGateway::where('status', 'Active')->first();
        $gateway_name = $sms_gateway->name;

        if ($gateway_name == 'Twilio') {
            $sid = $sms_gateway->user_name;
            $token = $sms_gateway->password;

            try {

                $client = new Client($sid, $token);
                $response = $client->account->messages->create(
                    "$phone",
                    array(
                        'from' => '+15005550006',
                        'body' => $message
                    )
                );

                if ($response->sid!='') {
                    return redirect('reports/payroll')->with([
                        'message' => language_data('SMS sent successfully')
                    ]);
                } else {
                    return redirect('reports/payroll')->with([
                        'message' => language_data('Please check your Twilio Credentials'),
                        'message_important'=>true
                    ]);
                }
            } catch (Exception $e) {
                return redirect('reports/payroll')->with([
                    'message' => language_data('Please check your Twilio Credentials'),
                    'message_important'=>true
                ]);
            }


        } elseif ($gateway_name == 'Route SMS') {

            $sms_url=$sms_gateway->api_link;
            $user=$sms_gateway->user_name;
            $password=$sms_gateway->password;
            $sender_id=app_config('AppName');


            $sms_sent_to_user = "$sms_url" . "?type=0" . "&username=$user" . "&password=$password" ."&destination=$phone" . "&source=$sender_id" . "&message=$message" . "&dlr=1";
            $get_sms_status=file_get_contents($sms_sent_to_user);
            $get_sms_status = str_replace("1701", language_data('Success'), $get_sms_status);
            $get_sms_status = str_replace("1709", language_data('User Validation Failed'), $get_sms_status);
            $get_sms_status = str_replace("1025", language_data('Insufficient Credit'), $get_sms_status);
            $get_sms_status = str_replace("1710", language_data('Internal Error'), $get_sms_status);
            $get_sms_status = str_replace("1706", language_data('Invalid receiver'), $get_sms_status);
            $get_sms_status = str_replace("1705", language_data('Invalid SMS'), $get_sms_status);
            $get_sms_status = str_replace("1707", language_data('Invalid sender'), $get_sms_status);
            $get_sms_status = str_replace(",", " ", $get_sms_status);
            $pos = strpos($get_sms_status, language_data('Success'));

            if ($pos === false) {
                return redirect('reports/payroll')->with([
                    'message' => language_data('SMS sent successfully')
                ]);
            } else {
                return redirect('reports/payroll')->with([
                    'message' => $get_sms_status,
                    'message_important'=>true
                ]);
            }



        } elseif ($gateway_name == 'Bulk SMS') {

            $sms_url=$sms_gateway->api_link;
            $user=$sms_gateway->user_name;
            $password=$sms_gateway->password;

            $url = "$sms_url" . "/eapi/submission/send_sms/2/2.0?username=$user" . "&password=$password" ."&msisdn=$phone" ."&message=".urlencode($message);
            $ret = file_get_contents($url);

            $send = explode("|",$ret);


            if ($send[0]=='0') {
                $get_sms_status= language_data('In progress');
            }elseif($send[0]=='1'){
                $get_sms_status= language_data('Scheduled');
            }elseif($send[0]=='22'){
                $get_sms_status= language_data('Internal Error');
            }elseif($send[0]=='23'){
                $get_sms_status= language_data('Authentication failure');
            }elseif($send[0]=='24'){
                $get_sms_status= language_data('Data validation failed');
            }elseif($send[0]=='25'){
                $get_sms_status= language_data('Insufficient Credit');
            }elseif($send[0]=='26'){
                $get_sms_status= language_data('Upstream credits not available');
            }elseif($send[0]=='27'){
                $get_sms_status= language_data('You have exceeded your daily quota');
            }elseif($send[0]=='28'){
                $get_sms_status= language_data('Upstream quota exceeded');
            }elseif($send[0]=='40'){
                $get_sms_status= language_data('Temporarily unavailable');
            }elseif($send[0]=='201'){
                $get_sms_status= language_data('Maximum batch size exceeded');
            }elseif($send[0]=='200'){
                $get_sms_status= language_data('Success');
            }
            else{
                $get_sms_status= language_data('Failed');
            }

            if($get_sms_status=='Success'){
                return redirect('reports/payroll')->with([
                    'message' => language_data('SMS sent successfully')
                ]);
            }else{
                return redirect('reports/payroll')->with([
                    'message' => $get_sms_status,
                    'message_important'=>true
                ]);
            }

        } else {
            return redirect('reports/payroll')->with([
                'message' => language_data('Gateway information not found'),
                'message_important' => true
            ]);
        }

    }


    /* sendEmailSalaryStatement  Function Start Here */
    public function sendEmailSalaryStatement(Request $request)
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'email' => 'required', 'subject' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('reports/payroll')->withErrors($v->errors());
        }

        $employee = Employee::find($request->cmd)->fname.' '.Employee::find($request->cmd)->lname;
        $email = Input::get('email');
        $subject = Input::get('subject');
        $message = Input::get('message');

        $sysEmail = app_config('Email');
        $sysCompany = app_config('AppName');
        $default_gt = app_config('Gateway');

        if ($default_gt == 'default') {

            $mail = new \PHPMailer();

            $mail->setFrom($sysEmail, $sysCompany);
            $mail->addAddress($email, $employee);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body = $message;

            if (!$mail->send()) {
                return redirect('reports/payroll')->with([
                    'message' => language_data('Please check your email setting'),
                    'message_important' => true
                ]);
            } else {
                return redirect('reports/payroll')->with([
                    'message' => language_data('Email send successfully')
                ]);
            }

        } else {
            $host = app_config('SMTPHostName');
            $smtp_username = app_config('SMTPUserName');
            $stmp_password = app_config('SMTPPassword');
            $port = app_config('SMTPPort');
            $secure = app_config('SMTPSecure');


            $mail = new \PHPMailer();

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $smtp_username;                 // SMTP username
            $mail->Password = $stmp_password;                           // SMTP password
            $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $port;

            $mail->setFrom($sysEmail, $sysCompany);
            $mail->addAddress($email, $employee);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $subject;
            $mail->Body = $message;


            if (!$mail->send()) {
                return redirect('reports/payroll')->with([
                    'message' => language_data('Please check your email setting'),
                    'message_important' => true
                ]);
            } else {
                return redirect('reports/payroll')->with([
                    'message' => language_data('Email send successfully')
                ]);
            }
        }

    }

    /*Version 1.5*/

    /* pdfSalaryStatement  Function Start Here */
    public function pdfSalaryStatement($id, $date_from, $date_to)
    {
        $self='employee-payroll-summery';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=date('Y-m-d',strtotime($date_to));


        $payslip = Payroll::where('emp_id', $id)->first();
        $payroll = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->get();

        $net_salary = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('net_salary');
        $over_time = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('overtime_salary');
        $tax = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('tax');
        $provident_fund = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('provident_fund');
        $loan = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('loan');
        $total_salary = Payroll::where('emp_id', $id)->whereBetween('payment_date', [$date_from, $date_to])->sum('total_salary');


        // $pdf =\WkPdf::loadView('admin.pdf-salary-statement', compact('payroll', 'payslip', 'id', 'date_from', 'date_to', 'net_salary', 'over_time', 'tax', 'provident_fund', 'loan', 'total_salary'));
        $pdf =PDF::loadView('admin.pdf-salary-statement', compact('payroll', 'payslip', 'id', 'date_from', 'date_to', 'net_salary', 'over_time', 'tax', 'provident_fund', 'loan', 'total_salary'));
        return $pdf->download('salary_statement.pdf');
    }


    public function get_att_date_wise_report()
    {
        $date_from = '';
        $date_to = '';
        $emp_id = '';
        $dep_id = '';
        $des_id = '';

        $attendance = Attendance::all();
        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.report.attendance.employee_wise_view', compact('attendance', 'employees', 'department', 'date_from','date_to', 'emp_id', 'dep_id', 'des_id'));
    }

    public function att_date_wise_report(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'employee' => 'required','date_from' => 'required','date_to' => 'required'
        ]);
        
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $date_from = date('Y-m-d',strtotime($request->date_from));
        $date_to = date('Y-m-d',strtotime($request->date_to));
        $emp_id = $request->employee;
        $dep_id = '';
        $des_id = '';
        $employee = Employee::find($emp_id);
        $attendance = Attendance::whereBetween('date', [$date_from, $date_to])->where('emp_id', $emp_id)->orderBy('date', 'asc')->get();
        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.report.attendance.employee_wise_view', compact('attendance', 'employees', 'employee', 'department', 'date_from','date_to', 'emp_id', 'dep_id', 'des_id'));
    }

    public function att_date_wise_report_pdf($date,$emp_id=0)
    {

        $date=explode('_',$date);

        if (is_array($date) && $emp_id!= 0){
            $date_from=$date['0'];
            $date_to=$date['1'];
        }else{
            return redirect()->back()->with([
                'message' => 'Failed!',
                'message_important' => true
            ]);
        }

        $date_from=date('Y-m-d',strtotime($date_from));
        $date_to=date('Y-m-d',strtotime($date_to));
        $attendance_query = Attendance::whereBetween('date', [$date_from,$date_to]);
        $employee = 0;
        if ($emp_id) {
            $attendance_query->Where('emp_id', $emp_id);
            $employee = Employee::find($emp_id);
        }

        $attendance = $attendance_query->orderBy('date', 'asc')->get();

        // $pdf=PDF::loadView('admin.all-pdf-attendance-report', compact('attendance'));

        // return $pdf->download('attendance.pdf');

        $pdf=PDF::loadView('admin.report.attendance.employee_wise_pdf', compact('attendance', 'employee', 'date_from','date_to'));
        return $pdf->download($employee->user_name.'_'.$date_from.'_'.$date_to.'.pdf');
    }
    public function get_att_daily_present_report()
    {
        $date = '';
        $emp_id = '';
        $dep_id = '';
        $attendance = '';
        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.report.attendance.daily_present_view', compact('attendance','employees', 'department', 'date', 'emp_id', 'dep_id'));
    }

    public function att_daily_present_report(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'date' => 'required'
        ]);
        
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $date = date('Y-m-d',strtotime($request->date));
 
        $emp_id = $request->employee;
        $dep_id = $request->department;
        $attendance_query = Attendance::where('date', 'like', $date.'%');
        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        
        if ($dep_id != '') {
            $attendance_query->where('department',$dep_id);
        }

        if ($emp_id  != '') {
            $attendance_query->whereIn('emp_id', $emp_id);
        }
        $attendance = $attendance_query->get();
        $department = Department::all();
        // echo('<pre>');
        // echo($date);
        // print_r($attendance);
        return view('admin.report.attendance.daily_present_view', compact('attendance', 'employees', 'department', 'date', 'emp_id', 'dep_id'));
    }

    public function att_daily_present_report_pdf(Request $request)
    {
        $date = date('Y-m-d',strtotime($request->date));
 
        $emp_id = $request->employee;
        $dep_id = $request->department;
        $attendance_query = Attendance::where('date', 'like', $date.'%')->where('status','Present');
               
        if ($dep_id) {
            $attendance_query->where('department',$dep_id);
        }

        if ($emp_id) {
            $attendance_query->whereIn('emp_id', $emp_id);
        }

        $attendance = $attendance_query->orderBy('date', 'asc')->get();

        echo('<pre>');
        print_r($emp_id);
        print_r($emp_id);
        print_r($attendance);
        // $pdf=PDF::loadView('admin.report.attendance.daily_present_pdf', compact('attendance', 'date'));
        // return $pdf->download($date.'-daily-present.pdf');
    }

    public function get_att_month_wise_report()
    {
      
        $month = '';
        $emp_id = '';
        $dep_id = '';

        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.report.attendance.month_wise_view', compact('employees', 'department', 'month', 'emp_id', 'dep_id'));
    }

    public function att_month_wise_report(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'employee' => 'required','month' => 'required'
        ]);

        $month = date('Y-m',strtotime($request->month));
        $dep_id = '';
        $emp_id = $request->employee;
        $employee = Employee::find($emp_id);
        $attendance = Attendance::where('date', 'like', $month.'%')->where('emp_id', $emp_id)->orderBy('date', 'asc')->get();
        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();

        // echo('<pre>');
        // print_r($request->employee);
        // echo('<br>');
        // print_r($month);
        // echo('<br>');
        // print_r($attendance);
        return view('admin.report.attendance.month_wise_view', compact('attendance', 'employees', 'employee', 'department',  'dep_id', 'month', 'emp_id'));
    }

    public function att_month_wise_report_pdf($month,$emp_id=0)
    {
        if ($month== '' && $emp_id== 0){
            return redirect()->back()->with([
                'message' => 'Failed!',
                'message_important' => true
            ]);
        }

        $employee = 0;
        if ($emp_id) {
            $employee = Employee::find($emp_id);
        }

        // $month = date('Y-m',strtotime($request->month));
        $attendance = Attendance::where('date', 'like', $month.'%')->where('emp_id', $emp_id)->orderBy('date', 'asc')->get();
        // $pdf=PDF::loadView('admin.report.attendance.month_wise_pdf', compact('attendance', 'employee', 'month'))->setPaper('a4', 'landscape');
        $pdf=PDF::loadView('admin.report.attendance.month_wise_pdf', compact('attendance', 'employee', 'month'));
        return $pdf->download($employee->user_name.'-'.date('F-Y',strtotime($month)).'.pdf');
    }

    public function get_att_monthly_report()
    {
        $month = '';
        $emp_id = '';
        $dep_id = '';

        $employees = Employee::where('status', 'active')->where('user_name','!=','admin')->get();
        $department = Department::all();
        return view('admin.report.attendance.monthly_view', compact('employees', 'department', 'month', 'emp_id', 'dep_id'));
    }

    public function att_monthly_report(Request $request)
    {
        $v = \Validator::make($request->all(), [
           'month' => 'required'
        ]);
            
        $month = date('Y-m-d',strtotime($request->month));
        $month_1 = date('Y-m-d',strtotime('+1 months',strtotime($request->month)));

        $emp_ids = $request->employee;
        $dep_id = $request->department;
        // $attendance_query = Attendance::where('date', 'like', $month.'%');
        $employee_query = Employee::where('status', 'active');
        
        if ($dep_id) {
            $employee_query->where('department',$dep_id);
        }

        if ($emp_ids) {
            $employee_query->whereIn('id', $emp_ids);
        }
        $ids = $employee_query->get('id')->toArray();
        $department = Department::all();

        $monthly_att = Array();
        $days = (strtotime($month_1)-strtotime($month))/86400;
        foreach($ids as $id){
            $emp_info = Employee::where('id',$id)->first();
            if($emp_info){
                $p=0;
                $l=0;
                $a=0;
                $h=0;
                $lp=0;
                $temp=Array();
                for($i=strtotime($month);$i<strtotime($month_1);$i+=86400){
                    
                    $attendance = Attendance::where('emp_id', $id)->where('date', date('Y-m-d',$i))->first();
                    $s = 'A';

                    if($attendance){
                        // echo($attendance->employee_info->fname.' '.$attendance->status.' ');
                        // echo(date('Y-m-d', $i).'<br>');
                        if($attendance->late > 0){
                            $lp++;
                            $s = 'LP';
                        }
                        else if($attendance->status == 'Present')
                        {
                            $p++;
                            $s = 'P';
                        }
                        else if($attendance->status == 'Absent')
                        {
                            $a++;
                            $s = 'A';
                        }
                        else if($attendance->status == 'Holiday')
                        {
                            $h++;
                            $s = 'H';
                        }
                        else if($attendance->status == 'Leave')
                        {
                            $l++;
                            $s = 'L';
                        }
                    }
                    else{
                        $a++;
                    }
                    $temp[date('j',$i)] = $s;
                }
                array_push($monthly_att, Array(
                    'code'=> $emp_info->employee_code,
                    'name'=> $emp_info->fname,
                    'designation'=> $emp_info->designation_name->designation,
                    'att' => $temp,
                    'p' => $p,
                    'a' => $a,
                    'lp' => $lp,
                    'l' => $l,
                    'h' => $h,
                ));

            }
            

        }
        // print_r($monthly_att);
        
        // return view('admin.report.attendance.monthly_view_pdf', compact('attendance', 'employees', 'employee', 'department',  'dep_id', 'month', 'emp_id'));
        // return view('admin.report.attendance.monthly_pdf', compact('monthly_att','month','days'));
        $pdf=PDF::loadView('admin.report.attendance.monthly_pdf', compact('monthly_att','month','days'))->setPaper('a4', 'landscape');
        // $pdf=PDF::loadView('admin.report.attendance.monthly_pdf', compact('monthly_att','month'))->setPaper('a4', 'landscape');
        return $pdf->download('att.pdf');
    }

    public function att_monthly_report_pdf($month,$emp_id=0)
    {
        if ($month== '' && $emp_id== 0){
            return redirect()->back()->with([
                'message' => 'Failed!',
                'message_important' => true
            ]);
        }
        
        $employee = 0;
        if ($emp_id) {
            $employee = Employee::find($emp_id);
        }

        // $month = date('Y-m',strtotime($request->month));
        $attendance = Attendance::where('date', 'like', $month.'%')->where('emp_id', $emp_id)->orderBy('date', 'asc')->get();
        // $pdf=PDF::loadView('admin.report.attendance.monthly_pdf', compact('attendance', 'employee', 'month'))->setPaper('a4', 'landscape');
        $pdf=PDF::loadView('admin.report.attendance.monthly_pdf', compact('attendance', 'employee', 'month'));
        return $pdf->download($employee->user_name.'-'.date('F-Y',strtotime($month)).'.pdf');
    }

}
