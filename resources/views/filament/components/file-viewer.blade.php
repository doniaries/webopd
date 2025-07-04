<div class="space-y-4">
    @foreach ($files as $file)
        <div class="p-4 bg-white rounded-lg shadow">
            <div class="mb-2 text-sm font-medium">{{ $file['filename'] }}</div>
            @if (Str::endsWith(strtolower($file['filename']), ['.pdf']))
                <iframe src="{{ $file['url'] }}" width="100%" height="500px" frameborder="0"></iframe>
            @elseif(Str::endsWith(strtolower($file['filename']), ['.jpg', '.jpeg', '.png', '.gif']))
                <img src="{{ $file['url'] }}" alt="{{ $file['filename'] }}" class="h-auto max-w-full">
            @else
                <div class="p-4 bg-gray-100 rounded">
                    <a href="{{ $file['url'] }}" target="_blank" class="text-primary-600 hover:text-primary-500">
                        Download File
                    </a>
                </div>
            @endif
        </div>
    @endforeach
</div>
