<div class="bg-white rounded-lg shadow-sm p-4">
    <div class="d-flex align-items-center mb-3">
        <div class="border-start border-3 border-success me-2" style="height: 24px;"></div>
        <h3 class="h6 fw-bold mb-0">Statistik Pengunjung</h3>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">Hari Ini</div>
                <div class="h5 mb-0 fw-semibold">{{ number_format($today) }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">Bulan Ini</div>
                <div class="h5 mb-0 fw-semibold">{{ number_format($month) }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">Online</div>
                <div class="h5 mb-0 fw-semibold">{{ number_format($online) }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">IP Anda</div>
                <div class="h6 mb-0 fw-semibold">{{ $ip }}</div>
            </div>
        </div>
    </div>
</div>
