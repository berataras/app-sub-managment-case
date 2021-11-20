<?php

namespace App\Http\Controllers;

use App\Exports\SubReportExport;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function report(){
       return response()->json($this->subscription->subReport());
    }

    public function reportExcel(){
        return Excel::download(new SubReportExport(), 'subscription_report.xlsx');
    }
}
