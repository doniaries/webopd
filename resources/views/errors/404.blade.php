<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            overflow: hidden;
        }
        
        .fullscreen-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }
        
        .fullscreen-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }
        
        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 2;
            color: white;
            padding: 20px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 20px;
            border: 2px solid transparent;
        }
        
        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .btn svg {
            margin-left: 8px;
            width: 20px;
            height: 20px;
        }
        
        h1 {
            font-size: 5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        p {
            font-size: 1.25rem;
            max-width: 600px;
            line-height: 1.6;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 3.5rem;
            }
            
            h2 {
                font-size: 2rem;
            }
            
            p {
                font-size: 1.1rem;
            }
            
            .btn {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="fullscreen-container">
        <img 
            src="{{ asset('images/404.jpg') }}" 
            alt="404 Not Found" 
            class="fullscreen-image"
            onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\'><rect width=\'100%\' height=\'100%\' fill=\'%23f3f4f6\'/><text x=\'50%\' y=\'50%\' font-family=\'sans-serif\' font-size=\'16\' text-anchor=\'middle\' dominant-baseline=\'middle\' fill=\'%239ca3af\'>404 Image Not Found</text></svg>';"
        >
        <div class="content-overlay">
            <h1>404</h1>
            <h2>Halaman Tidak Ditemukan</h2>
            <p>Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.</p>
            <a href="{{ url('/') }}" class="btn">
                Kembali ke Beranda
                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</body>
</html>
