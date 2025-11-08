<?php

namespace App\Http\Controllers\Front;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Mail\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(ContactRequest $request)
    {
        $validated = $request->validated();

        Mail::to('info@trendify-dubai.com')->send(new ContactMessage($validated));

        return back()->with('success', __('contact.sent_successfully'));
    }
}
