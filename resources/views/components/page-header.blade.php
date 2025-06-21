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

<!-- Page Header with Water Background -->
<div class="page-header relative overflow-hidden flex items-center justify-center"
    style="min-height: 80px; padding: 0.5rem 0;">
    <!-- Background Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900 to-blue-700 opacity-90"></div>
    <!-- Animated Bubbles -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Multiple bubbles with different sizes and speeds -->
        <div class="bubble" style="left: 10%; animation: bubble 15s infinite linear;"></div>
        <div class="bubble" style="left: 20%; animation: bubble 18s infinite linear 2s;"></div>
        <div class="bubble bubble-sm" style="left: 30%; animation: bubble 12s infinite linear 1s;"></div>
        <div class="bubble" style="left: 50%; animation: bubble 20s infinite linear 3s;"></div>
        <div class="bubble bubble-sm" style="left: 70%; animation: bubble 14s infinite linear 4s;"></div>
        <div class="bubble" style="left: 85%; animation: bubble 16s infinite linear 1.5s;"></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10 flex flex-col items-center justify-center" style="min-height: 80px;">
        <!-- Page Title -->
        <div class="text-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white tracking-tight leading-none">
                {{ $title }}
            </h1>
        </div>
    </div>
</div>

<style>
    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Bubbles */
    .bubble {
        position: absolute;
        bottom: -20px;
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        animation-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 5;
    }

    .bubble-sm {
        width: 6px;
        height: 6px;
        opacity: 0.4;
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

    /* Background pattern removed */

    .page-header h1 {
        position: relative;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .page-header .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .page-header .breadcrumb-item {
        color: rgba(255, 255, 255, 0.8);
    }

    .page-header .breadcrumb-item a {
        color: #bfdbfe;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .page-header .breadcrumb-item a:hover {
        color: #ffffff;
        text-decoration: none;
    }

    .page-header .breadcrumb-item.active {
        color: #ffffff;
    }

    .page-header .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
        content: ">";
        padding: 0 0.5rem;
    }
</style>
