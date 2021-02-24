<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>{{app_config('AppName')}} - {{language_data('Salary Statement')}}</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<head>
    <style>
        .help-split {
            display: inline-block;
            width: 30%;
        }
    </style>
</head>
<body class="printable-page">

<main id="wrapper" class="wrapper">
    <div class="container container-printable">
        <div class="p-30 p-t-none p-b-none">

            <div class="p-t-30"></div>

            <table width="100%">
                <tbody>
                <tr>
                    <td style="border: 0;  text-align: left" width="62%">
                        <span style="font-size: 18px;"><strong>{{language_data('Salary Statement')}}</strong></span>
                        <br>
                        <span><strong>{{language_data('Date')}}:</strong> {{get_date_format(date('Y-m-d'))}}</span>
                    </td>
                    <td style="border: 0;  text-align: right" width="62%">
                        <div>
                            <h3>{{app_config('AppName')}}</h3>
                            <div style="height: 15px;"></div>
                            {!!app_config('Address')!!}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="m-b-20"></div>

            <table width="100%">
                <tbody>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>{{language_data('Employee ID')}}:$</strong>
                            </div>
                            <div class="col-xs-6">
                                <span>#{{$payslip->employee_info->employee_code}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>{{language_data('Employee Name')}} :</strong>
                            </div>
                            <div class="col-xs-6">
                                <span>{{$payslip->employee_info->fname}} {{$payslip->employee_info->lname}}</span>
                            </div>
                        </div>

                        @if($payslip->employee_info->phone!='')
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>{{language_data('Phone')}} :</strong>
                            </div>
                            <div class="col-xs-6">
                                <span>{{$payslip->employee_info->phone}}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>{{language_data('Department')}} :</strong>
                            </div>
                            <div class="col-xs-6">
                                <span>{{$payslip->department_name->department}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <strong>{{language_data('Designation')}} :</strong>
                            </div>
                            <div class="col-xs-6">
                                <span>{{$payslip->designation_name->designation}}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-l-100">
                        <table class="table table-condensed table-transparent table-condensed-slim table-bordered">
                            <tr>
                                <td>
                                    <strong>{{language_data('Date From')}} :</strong>
                                </td>
                                <td class="text-right">
                                    <span>{{get_date_format($date_from)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>{{language_data('Date To')}} :</strong>
                                </td>
                                <td class="text-right">
                                    <span>{{get_date_format($date_to)}}</span>
                                </td>
                            </tr>


                            @if($payslip->employee_info->payment_type=='Hourly')


                            <tr>
                                <td>
                                    <strong>{{language_data('Working Hourly Rate')}} :</strong>
                                </td>
                                <td class="text-right">
                                    <span>{{app_config('Currency')}} {{$payslip->employee_info->working_hourly_rate+$payslip->employee_info->working_hourly_increment_rate}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>{{language_data('Overtime Hourly Rate')}} :</strong>
                                </td>
                                <td class="text-right">
                                    <span>{{app_config('Currency')}} {{$payslip->employee_info->overtime_hourly_rate+$payslip->employee_info->overtime_hourly_increment_rate}}</span>
                                </td>
                            </tr>

                            @else


                                <tr>
                                    <td>
                                        <strong>{{language_data('Basic Salary')}} :</strong>
                                    </td>
                                    <td class="text-right">
                                        <span>{{app_config('Currency')}} {{$payslip->employee_info->basic_salary+$payslip->employee_info->basic_salary_increment}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{language_data('Overtime Salary')}} :</strong>
                                    </td>
                                    <td class="text-right">
                                        <span>{{app_config('Currency')}} {{$payslip->employee_info->overtime_salary+$payslip->employee_info->overtime_salary_increment}} ({{language_data('Hourly')}})</span>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="m-b-20"></div>

            <table class="table table-condensed table-transparent table-condensed-slim table-bordered">

                <tbody>

                    <tr>
                        <th width="65%">{{language_data('Item Name')}}</th>
                        <th class="text-right" colspan="3">{{language_data('Total')}}</th>
                    </tr>
                    @foreach($payroll as $p)
                    <tr class="item-row">
                        <td class="description">{{$p->payment_month}}</td>
                        <td align="right" colspan="3">{{app_config('Currency')}} {{$p->total_salary}}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('Net Salary')}}</td>
                        <td align="right" class="td-b-l-none">{{app_config('Currency')}} {{$net_salary}}</td>
                    </tr>

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('Overtime Amount')}}</td>
                        <td align="right" class="td-b-l-none">{{app_config('Currency')}} {{$over_time}}</td>
                    </tr>

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('TAX')}}</td>
                        <td align="right" class="td-b-l-none">(-) {{app_config('Currency')}} {{$tax}}</td>
                    </tr>

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('Provident Fund')}}</td>
                        <td align="right" class="td-b-l-none">(-) {{app_config('Currency')}} {{$provident_fund}}</td>
                    </tr>

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('Loan')}}</td>
                        <td align="right" class="td-b-l-none">(-) {{app_config('Currency')}} {{$loan}}</td>
                    </tr>

                    <tr>
                        <td class="td-b-none"></td>
                        <td align="right" colspan="2" class="td-b-r-none">{{language_data('Grand Total')}}</td>
                        <td align="right" class="td-b-l-none">{{app_config('Currency')}} {{$total_salary}}</td>
                    </tr>

                </tbody>
            </table>
            <div style="height: 60px"></div>
        </div>
    </div>
</main>


</body>
</html>