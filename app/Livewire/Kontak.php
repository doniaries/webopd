<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class Kontak extends Component
{
    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';
    
    // Form state
    public bool $isSubmitting = false;
    public bool $isSuccess = false;
    public ?string $errorMessage = null;
    
    /**
     * Render the contact page
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        try {
            $pengaturan = Pengaturan::first();
            
            $title = 'Kontak';
            $description = 'Informasi kontak ' . ($pengaturan ? $pengaturan->nama_instansi : config('app.name'));

            return view('livewire.kontak', [
                'pengaturan' => $pengaturan,
                'title' => $title,
                'description' => $description,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error loading contact page: ' . $e->getMessage());
            
            return view('livewire.kontak', [
                'pengaturan' => null,
                'title' => 'Kontak',
                'description' => 'Halaman kontak ' . config('app.name'),
            ])->with('error', 'Terjadi kesalahan saat memuat halaman kontak.');
        }
    }
    
    /**
     * Validation rules for the contact form
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:2000',
        ];
    }
    
    /**
     * Custom error messages for validation
     *
     * @return array
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor telepon wajib diisi',
            'subject.required' => 'Subjek pesan wajib diisi',
            'message.required' => 'Isi pesan wajib diisi',
        ];
    }
    
    /**
     * Handle form submission
     *
     * @return void
     */
    public function submitForm(): void
    {
        try {
            $this->validate();
            $this->isSubmitting = true;
            $this->errorMessage = null;
            
            // Get admin email from settings or use default
            $pengaturan = Pengaturan::first();
            $adminEmail = $pengaturan->email_instansi ?? config('mail.admin_email', 'admin@example.com');
            
            // Send email
            Mail::to($adminEmail)->send(new ContactFormMail([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
            ]));
            
            // Reset form on success
            $this->resetForm();
            $this->isSuccess = true;
            
            // Reset success message after 5 seconds
            $this->dispatch('form-submitted');
            
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            $this->errorMessage = 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.';
        } finally {
            $this->isSubmitting = false;
        }
    }
    
    /**
     * Reset the contact form
     *
     * @return void
     */
    private function resetForm(): void
    {
        $this->reset([
            'name',
            'email',
            'phone',
            'subject',
            'message',
        ]);
    }
}
