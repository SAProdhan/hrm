@extends('employee')

@section('content')

<section class="wrapper-bottom-sec">
			<div class="p-30">
				<div class="row">
					<div class="col-sm-8">
						<h2 class="page-title p-b-15">{{language_data('Payment Salary Details')}}</h2>
					</div>
					<div class="col-sm-4 text-right">
                        <a href="{{url('employee/payslip/print-payslip/'.$payslip->id)}}" target="_blank" class="btn btn-primary btn-animated from-left fa fa-print">
                            <span>{{language_data('Print Payslip')}}</span>
                        </a>
					</div>
				</div>
			</div>
			<div class="p-30 p-t-none p-b-none">

				<div class="panel">
					<div class="panel-heading p-b-none">
						<h3>{{language_data('Payslip')}}<br><small>{{language_data('Salary Month')}}: {{$payslip->payment_month}}</small></h3>
					</div>
					<div class="panel-body p-none m-b-10">
						<table class="table table-no-border table-condensed">
							<tbody>
								<tr>
									<td><strong class="help-split">{{language_data('Employee ID')}}:</strong>#{{$payslip->employee_info->employee_code}}</td>
									<td><strong class="help-split">{{language_data('Employee Name')}}:</strong>{{$payslip->employee_info->fname}} {{$payslip->employee_info->lname}}</td>
									<td><strong class="help-split">{{language_data('Payslip NO')}}:</strong>#{{$payslip->id}}</td>
								</tr>
								<tr>
									<td><strong class="help-split">{{language_data('Phone')}}:</strong>{{$payslip->employee_info->phone}}</td>
									<td><strong class="help-split">{{language_data('Joining Date')}}:</strong>{{get_date_format($payslip->employee_info->doj)}}</td>
									<td><strong class="help-split">{{language_data('Payment By')}}:</strong>{{$payslip->payment_type}}</td>
								</tr>
								<tr>
									<td><strong class="help-split">{{language_data('Department')}}:</strong>{{$payslip->department_name->department}}</td>
									<td><strong class="help-split">{{language_data('Designation')}}:</strong>{{$payslip->designation_name->designation}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>


			<div class="row">
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading p-b-none">
							<h4 class="m-b-10"><strong>{{language_data('Payment Details')}}</strong></h4>
						</div>
						<div class="panel-body p-none">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td><strong>{{language_data('Working Hourly Rate')}}:</strong> <span class="pull-right">{{app_config('Currency')}} {{$payslip->employee_info->working_hourly_rate}}</span></td>
									</tr>
									<tr>
										<td><strong>{{language_data('Overtime Hourly Rate')}}:</strong> <span class="pull-right">{{app_config('Currency')}} {{$payslip->employee_info->overtime_hourly_rate}}</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel">
						<div class="panel-heading p-b-none">
							<h4 class="m-b-10"><strong>{{language_data('Earning')}}</strong></h4>
						</div>
						<div class="panel-body p-none">
							<table class="table table-condensed">
								<tbody>
									<tr>
										<td><strong>{{language_data('Net Salary')}}:</strong> <span class="pull-right">{{app_config('Currency')}} {{$payslip->net_salary}}</span></td>
									</tr>
									<tr>
										<td><strong>{{language_data('Overtime Amount')}}:</strong> <span class="pull-right">{{app_config('Currency')}} {{$payslip->overtime_salary}}</span></td>
									</tr>
									<tr>
										<td><strong>{{language_data('Attendance Panelty')}}:</strong> <span class="pull-right">{{app_config('Currency')}} {{$payslip->attendance_panelty}}</span></td>
									</tr>
									<tr>
										<td class="td-highlighted"><strong>{{language_data('Grand Total')}}:</strong> <span class="pull-right"><strong>{{app_config('Currency')}} {{$payslip->total_salary}}</strong></span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

                </div>
		</section>


@endsection
