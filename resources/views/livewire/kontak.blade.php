<div>
    <x-page-header title="Kontak Kami" :subtitle="$description" />
    
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 md:p-8">
                        
                        @if($pengaturan)
                        <div class="flex flex-wrap -mx-4 mb-7">
                            <div class="flex-shrink max-w-full px-4 w-full md:w-1/2 mb-6">
                                <div class="p-6 bg-gray-50 rounded-lg h-full">
                                    <h3 class="text-2xl font-bold mb-4">Informasi Kontak</h3>
                                    <ul class="space-y-4">
                                        <li class="flex items-start">
                                            <span class="mr-3 text-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                </svg>
                                            </span>
                                            <div>
                                                <h4 class="font-semibold">Alamat</h4>
                                                <p>{{ $pengaturan->alamat_instansi }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-3 text-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                </svg>
                                            </span>
                                            <div>
                                                <h4 class="font-semibold">Telepon</h4>
                                                <p>{{ $pengaturan->no_telp_instansi }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-3 text-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                                </svg>
                                            </span>
                                            <div>
                                                <h4 class="font-semibold">Email</h4>
                                                <p>{{ $pengaturan->email_instansi }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex-shrink max-w-full px-4 w-full md:w-1/2 mb-6">
                                <div class="p-6 bg-gray-50 rounded-lg h-full">
                                    <h3 class="text-2xl font-bold mb-4">Kirim Pesan</h3>
                                    <form>
                                        <div class="mb-4">
                                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama Anda">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@example.com">
                                        </div>
                                        <div class="mb-4">
                                            <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subjek</label>
                                            <input type="text" id="subject" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Subjek pesan">
                                        </div>
                                        <div class="mb-4">
                                            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Pesan</label>
                                            <textarea id="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis pesan Anda di sini"></textarea>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Kirim Pesan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="p-6 bg-yellow-50 rounded-lg mb-7">
                            <p class="text-yellow-700">Informasi kontak belum tersedia. Silakan hubungi administrator untuk mengatur informasi kontak.</p>
                        </div>
                        @endif
                        
                        <div class="mb-7">
                            <h3 class="text-2xl font-bold mb-4">Lokasi Kami</h3>
                            <div class="rounded-lg overflow-hidden h-96 bg-gray-100">
                                @if($pengaturan && $pengaturan->latitude && $pengaturan->longitude)
                                    <iframe 
                                        width="100%" 
                                        height="100%" 
                                        frameborder="0" 
                                        style="border:0" 
                                        referrerpolicy="no-referrer-when-downgrade"
                                        src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_key') }}&q={{ $pengaturan->latitude }},{{ $pengaturan->longitude }}&zoom=15&maptype=roadmap"
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <p class="text-gray-500">Koordinat lokasi belum diatur</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Maps API is loaded via the iframe embed -->
</div>