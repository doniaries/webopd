<?php

namespace App\Http\View\Composers;

use App\Models\Pengaturan;
use Illuminate\View\View;

class PengaturanComposer
{
    /**
     * The pengaturan model implementation.
     *
     * @var \App\Models\Pengaturan
     */
    protected $pengaturan;

    /**
     * Create a new pengaturan composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Get the first settings record
        $this->pengaturan = Pengaturan::first();
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('pengaturan', $this->pengaturan);
    }
}
