<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->get('per_page', 10), 50));
        $testimonials = Testimonial::where('status', 'approved')
            ->latest()
            ->paginate($perPage);

        return TestimonialResource::collection($testimonials);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial = Testimonial::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        return response()->json([
            'message' => 'Testimonial submitted successfully. It will be visible after approval.',
            'data' => new TestimonialResource($testimonial),
        ], 201);
    }
}
