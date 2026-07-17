<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('testimonials.index', compact('testimonials'));
    }

    public function store(TestimonialRequest $request)
    {
        Testimonial::create(array_merge($request->validated(), [
            'status' => 'pending',
        ]));

        return redirect()->route('testimonials.index')
            ->with('success', 'Terima kasih! Testimonial Anda akan ditampilkan setelah disetujui.');
    }
}
