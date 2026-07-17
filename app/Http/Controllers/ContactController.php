<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(ContactRequest $request)
    {
        return redirect()->route('contact.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan segera merespon.');
    }
}
