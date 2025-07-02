<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SummaryMail;
 
class SummaryController extends Controller
{
    public function sendSummaryEmail(Request $request)
    {
        $email = $request->email ?? $request->additional_data['email']; // Get from the form
        $summary = $request->summary;
        $interests = $request->interests;
        $additionalData = $request->additional_data;
 
        Mail::to($email)->send(new SummaryMail($summary, $interests, $additionalData));
 
        return response()->json(['message' => 'Email sent successfully']);
    }
}

?>