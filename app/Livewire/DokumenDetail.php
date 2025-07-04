<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Dokumen;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class DokumenDetail extends Component
{
    public $dokumen;
    public $relatedDocuments = [];

    public function mount($slug)
    {
        // Load the document with proper error handling
        $this->dokumen = Dokumen::where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->first();

        // If document not found, abort with 404
        if (!$this->dokumen) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        // Add file info to the document
        $this->dokumen->file_info = $this->getFileInfo($this->dokumen->file);

        // Safely increment view count
        try {
            $this->dokumen->increment('views');
        } catch (\Exception $e) {
            // Log the error but don't break the page
            \Log::error('Gagal menambah hit dokumen: ' . $e->getMessage());
        }

        // Get latest documents as related (excluding current document)
        $this->relatedDocuments = Dokumen::where('id', '!=', $this->dokumen->id)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get()
            ->map(function($doc) {
                $doc->file_info = $this->getFileInfo($doc->file);
                return $doc;
            });
    }

    protected function getFileInfo($filePath)
    {
        $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));
        
        $info = [
            'extension' => pathinfo($filePath, PATHINFO_EXTENSION),
            'exists' => false,
            'size' => 0,
            'size_formatted' => '0 KB',
            'path' => $filePath
        ];

        if (file_exists($fullPath)) {
            $size = filesize($fullPath);
            $info['exists'] = true;
            $info['size'] = $size;
            $info['size_formatted'] = $this->formatFileSize($size);
        }

        return $info;
    }

    protected function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
    }

    public function download()
    {
        $this->dokumen->increment('downloads');
        return response()->download(storage_path('app/public/' . $this->dokumen->file));
    }

    #[Title('Detail Dokumen')]
    public function render()
    {
        return view('livewire.dokumen-detail', [
            'dokumen' => $this->dokumen,
            'relatedDocuments' => $this->relatedDocuments
        ]);
    }
}
