<div class="w-full h-[80vh]">
    @if($url)
        <iframe 
            src="{{ $url }}"
            class="w-full h-full border-0 rounded-lg shadow"
            frameborder="0"
        ></iframe>
    @else
        <div class="text-center p-8 text-gray-500">
            <p>File tidak tersedia</p>
        </div>
    @endif
</div>
