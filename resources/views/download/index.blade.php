@extends('layouts.frontend')

@section('title', 'Download | Utero Advertising')
@section('meta_description', 'Download brosur, katalog, dan file lainnya dari Utero Advertising — Malang, Jawa Timur.')

@section('sidebar-left')
<div class="sidebar-left">
    <div class="label-title">Product Category</div>
    <div class="sidebar-left-scroll">
        <ul class="category-list">
            @foreach($categories as $cat)
                <li><a href="{{ route('products.category', $cat->slug) }}" title="category: {{ $cat->name }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="main-content">
    <div class="detail-section">
        <h1 style="border-bottom:1px solid #999; padding-bottom:4px; margin-bottom:8px;">
            Download
        </h1>
    </div>

    @if($downloads->count())
        <div class="detail-section">
            <table style="width:100%; border-collapse:collapse;">
                <tr style="background:#222; color:#FFF;">
                    <td style="padding:6px 8px; font-weight:bold;">File</td>
                    <td style="padding:6px 8px; font-weight:bold; width:80px;">Ukuran</td>
                    <td style="padding:6px 8px; font-weight:bold; width:60px;">Unduh</td>
                </tr>
                @foreach($downloads as $dl)
                    <tr style="border-bottom:1px solid #EFEFEF; {{ $loop->even ? 'background:#FAFAFA;' : '' }}">
                        <td style="padding:6px 8px;">
                            @if($dl->isFile())
                                <i class="fa {{ $dl->file_icon }}" style="margin-right:6px; color:#666;"></i>
                                {{ $dl->name }}
                                <span style="color:#999; font-size:11px;">.{{ $dl->extension }}</span>
                            @else
                                <i class="fa fa-link" style="margin-right:6px; color:#666;"></i>
                                {{ $dl->name }}
                                <span style="color:#999; font-size:11px;">(Google Drive)</span>
                            @endif
                        </td>
                        <td style="padding:6px 8px; color:#666; font-size:12px;">{{ $dl->isFile() ? $dl->formatted_size : '-' }}</td>
                        <td style="padding:6px 8px;">
                            <a href="{{ route('download.file', $dl->id) }}" title="Download {{ $dl->name }}" style="color:#09F;">
                                <i class="fa fa-download"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="detail-section">
            <p style="color:#999; text-align:center; padding:20px 0;">Belum ada file yang tersedia untuk diunduh.</p>
        </div>
    @endif
</div>
@endsection
