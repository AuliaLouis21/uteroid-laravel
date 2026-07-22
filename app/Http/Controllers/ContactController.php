<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(ContactRequest $request)
    {
        Mail::to(config('mail.from.address'))->queue(
            new ContactMessageMail(
                $request->name,
                $request->email,
                $request->subject,
                $request->message, // mapped to $body in ContactMessageMail
                $request->phone
            )
        );

        return redirect()->route('contact.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera merespon.');
    }
}
