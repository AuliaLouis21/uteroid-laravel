@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <h1>Settings</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" name="settings[site_name]" id="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="site_email" class="form-label">Site Email</label>
                        <input type="email" name="settings[site_email]" id="site_email" class="form-control" value="{{ $settings['site_email'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">Site Description</label>
                    <textarea name="settings[site_description]" id="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="site_phone" class="form-label">Phone</label>
                        <input type="text" name="settings[site_phone]" id="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="site_whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" name="settings[site_whatsapp]" id="site_whatsapp" class="form-control" value="{{ $settings['site_whatsapp'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="site_address" class="form-label">Address</label>
                    <textarea name="settings[site_address]" id="site_address" class="form-control" rows="3">{{ $settings['site_address'] ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="site_instagram" class="form-label">Instagram</label>
                        <input type="text" name="settings[site_instagram]" id="site_instagram" class="form-control" value="{{ $settings['site_instagram'] ?? '' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="google_analytics_id" class="form-label">Google Analytics 4 ID</label>
                        <input type="text" name="settings[google_analytics_id]" id="google_analytics_id" class="form-control" placeholder="G-XXXXXXXXXX" value="{{ $settings['google_analytics_id'] ?? '' }}">
                        <small class="text-muted">Format: G-XXXXXXXXXX</small>
                    </div>
                </div>

                <hr>
                <h5>reCAPTCHA v3</h5>
                <p class="text-muted small">Isi hanya jika ingin mengaktifkan proteksi reCAPTCHA pada form publik.</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="recaptcha_site_key" class="form-label">reCAPTCHA Site Key</label>
                        <input type="text" name="settings[recaptcha_site_key]" id="recaptcha_site_key" class="form-control" value="{{ $settings['recaptcha_site_key'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="recaptcha_secret_key" class="form-label">reCAPTCHA Secret Key</label>
                        <input type="password" name="settings[recaptcha_secret_key]" id="recaptcha_secret_key" class="form-control" value="{{ $settings['recaptcha_secret_key'] ?? '' }}">
                    </div>
                </div>

                <hr>
                <h5>WhatsApp API</h5>
                <p class="text-muted small">Konfigurasi untuk notifikasi WhatsApp otomatis ke admin.</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp_api_url" class="form-label">API URL</label>
                        <input type="url" name="settings[whatsapp_api_url]" id="whatsapp_api_url" class="form-control" placeholder="https://api.fonnte.com/send" value="{{ $settings['whatsapp_api_url'] ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="whatsapp_api_token" class="form-label">API Token</label>
                        <input type="password" name="settings[whatsapp_api_token]" id="whatsapp_api_token" class="form-control" value="{{ $settings['whatsapp_api_token'] ?? '' }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
@endsection
