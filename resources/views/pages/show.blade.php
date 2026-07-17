@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-brand">Beranda</a></li>
                <li>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </li>
                <li class="text-gray-900 font-medium">{{ $page->title }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $page->content !!}
            </div>
        </div>

    </div>
</section>
@endsection
