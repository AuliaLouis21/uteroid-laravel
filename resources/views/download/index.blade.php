@extends('layouts.frontend')

@section('title', 'Download | Utero Advertising')
@section('meta_description', 'Download brosur, katalog, dan file lainnya dari Utero Advertising — Malang, Jawa Timur.')

@section('sidebar-left')
<div class="sidebar-left">
    <div class="sidebar-card">
        <div class="card-header">
            <i class="fas fa-th-large"></i>Product Category
        </div>
        <div class="category-list-scroll">
            <ul class="category-list">
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.category', $cat->slug) }}" title="category: {{ $cat->name }}">
                            <i class="fas fa-chevron-right"></i>{{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="content-card">
        <div class="page-title"><i class="fas fa-download mr-2"></i>Download</div>
        <div class="page-title-bar"></div>

        @if($downloads->count())
            <div class="overflow-x-auto">
                <table class="download-table">
                    <tr class="thead">
                        <td><i class="fas fa-file mr-2"></i>File</td>
                        <td class="w-28">Ukuran</td>
                        <td class="w-20 text-center">Unduh</td>
                    </tr>
                    @foreach($downloads as $dl)
                        <tr class="{{ $loop->even ? 'row-even' : 'row-odd' }}">
                            <td>
                                @if($dl->isFile())
                                    <i class="fa {{ $dl->file_icon }} mr-2 text-brand"></i>
                                    <span class="font-medium">{{ $dl->name }}</span>
                                    <span class="text-gray-400 text-xs ml-1">.{{ $dl->extension }}</span>
                                @else
                                    <i class="fas fa-link mr-2 text-white"></i>
                                    <span class="font-medium">{{ $dl->name }}</span>
                                    <span class="text-gray-400 text-xs ml-1">(Google Drive)</span>
                                @endif
                            </td>
                            <td class="text-gray-500 text-sm">{{ $dl->isFile() ? $dl->formatted_size : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('download.file', $dl->id) }}" title="Download {{ $dl->name }}" class="download-btn">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                <p>Belum ada file yang tersedia untuk diunduh.</p>
            </div>
        @endif
    </div>
</div>
@endsection
