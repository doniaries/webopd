@props([
    'title' => '',
    'breadcrumbs' => [],
])

<div class="page-header py-4 bg-gradient-primary text-white">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3 text-white">{{ $title }}</h1>
                @if (!empty($breadcrumbs))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}" class="text-white text-decoration-none">
                                    <i class="bi bi-house-door-fill me-1"></i> Beranda
                                </a>
                            </li>
                            @php
                                $breadcrumbCount = count($breadcrumbs);
                                $currentIndex = 0;
                            @endphp
                            @foreach ($breadcrumbs as $label => $url)
                                @php $currentIndex++; @endphp
                                @if ($currentIndex === $breadcrumbCount)
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span class="text-white">{{ $label }}</span>
                                    </li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $url }}" class="text-white text-decoration-none">{{ $label }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endif
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        background: linear-gradient(135deg, #082a5e 0%, #031c42 100%);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h100v100H0V0zm5 5v90h90V5H5z' fill='rgba(255,255,255,0.1)' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .page-header h1 {
        position: relative;
        font-size: 2.25rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.7);
        content: ">";
    }

    .breadcrumb-item a {
        transition: all 0.2s ease;
    }

    .breadcrumb-item a:hover {
        opacity: 0.9;
        text-decoration: underline !important;
    }

    .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.9);
    }
</style>
