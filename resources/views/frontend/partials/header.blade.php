<header>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ $settings->app_icon ?? asset('asset/image/01_app_icon.png') }}" alt="{{ $settings->app_name ?? 'Alfa Mobiles' }}">
        </a>
    </div>
    <div class="header-right">
        <a href="{{ route('track') }}" class="btn-track-main">
            <i class="fas fa-truck"></i> <span>Track</span>
        </a>
        <div class="contact-box-header">
            <span class="contact-label-main">CONTACT US</span>
            <div class="contact-circles-flex">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->contact_number ?? '') }}" class="contact-circle-btn bg-whatsapp" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="mailto:{{ $settings->contact_email ?? 'info@alfamobiles.com' }}" class="contact-circle-btn bg-mail" target="_blank">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>
</header>
