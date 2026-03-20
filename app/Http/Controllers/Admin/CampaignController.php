<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Mail\CampaignMessage;
use Mail;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function index()
    {
        return view('admin.campaign.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'recipient_type' => 'required|in:jobseeker,employer,both',
        ]);

        $subject = $request->input('subject');
        $messageText = $request->input('message');
        $recipientType = $request->input('recipient_type');

        $recipients = collect();

        if ($recipientType == 'jobseeker' || $recipientType == 'both') {
            $recipients = $recipients->merge(User::where('is_active', 1)->get(['email', 'name']));
        }

        if ($recipientType == 'employer' || $recipientType == 'both') {
            $recipients = $recipients->merge(Company::where('is_active', 1)->get(['email', 'name']));
        }

        $count = 0;
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new CampaignMessage($subject, $messageText, $recipient->name));
                $count++;
            } catch (\Exception $e) {
                \Log::error("Campaign Send Error: " . $e->getMessage());
            }
        }

        flash(__(':count adet e-posta başarıyla gönderildi!', ['count' => $count]))->success();
        return redirect()->route('admin.campaign.index');
    }
}
