@props([
'title' => null,
])

@php
// Generate title from URL segments if not provided
if (!$title) {
$segments = request()->segments();
$title = end($segments) ?: 'Beranda';
$title = str_replace('-', ' ', $title);
$title = ucwords($title);

// Handle empty segments (homepage)
if (empty($title)) {
$title = 'Beranda';
}
}
@endphp

<!-- Page Header with Animated Bubbles & Brand Style -->
<div class="page-header brand-gradient brand-bar relative overflow-hidden flex items-center justify-center" style="min-height: 80px; padding: 0.5rem 0;">
    <!-- Animated Bubbles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="bubble" style="left: 10%; animation: bubble 15s infinite linear;"></div>
        <div class="bubble" style="left: 20%; animation: bubble 18s infinite linear 2s;"></div>
        <div class="bubble bubble-sm" style="left: 30%; animation: bubble 12s infinite linear 1s;"></div>
        <div class="bubble" style="left: 50%; animation: bubble 20s infinite linear 3s;"></div>
        <div class="bubble bubble-sm" style="left: 70%; animation: bubble 14s infinite linear 4s;"></div>
        <div class="bubble" style="left: 85%; animation: bubble 16s infinite linear 1.5s;"></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight leading-none text-white">{{ $title }}</h1>
    </div>
</div>

<style>
    .page-header {
        border-radius: 0;
        position: relative;
        background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
        /* Blue Gradient */
    }

    .page-header h1 {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        /* Stronger Shadow */
        color: #fff;
        position: relative;
        margin: 0 auto;
    }

    /* Bubbles */
    .bubble {
        position: absolute;
        bottom: -20px;
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 5;
    }

    .bubble-sm {
        width: 6px;
        height: 6px;
        opacity: 0.5;
    }

    /* Bubble Animation */
    @keyframes bubble {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }

        10% {
            opacity: 0.6;
        }

        90% {
            opacity: 0.6;
        }

        100% {
            transform: translateY(-100vh) translateX(20px);
            opacity: 0;
        }
    }
</style>