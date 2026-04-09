<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekapitulasi | Pilih Tahun Data</title>

  <!-- Google Font: Inter / Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- Custom Modern UI Styles -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f1f5f9; /* Slate 100 */
      color: #334155;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      overflow: hidden;
    }
    
    /* Elegant Top Background Pattern */
    .bg-shape {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 45vh;
      background: linear-gradient(135deg, #132b4b 0%, #1e3a5f 100%);
      border-bottom-left-radius: 50% 15%;
      border-bottom-right-radius: 50% 15%;
      z-index: -1;
      box-shadow: 0 10px 30px rgba(45, 106, 79, 0.2);
    }

    .modern-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 40px;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 1px 3px rgba(0,0,0,0.05);
      border: 1px solid rgba(255,255,255,0.7);
      animation: floatUp 0.6s ease-out forwards;
    }

    @keyframes floatUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .header-text {
      text-align: center;
      margin-bottom: 30px;
    }
    
    .header-text h5 {
      font-weight: 700;
      color: #1e293b; /* Slate 800 */
      font-size: 1.4rem;
      margin-bottom: 5px;
    }

    .header-text p {
      color: #64748b; /* Slate 500 */
      font-size: 0.95rem;
      font-weight: 400;
    }

    /* Custom Form Select */
    .custom-select-wrapper {
      position: relative;
      margin-bottom: 25px;
    }
    
    .custom-select-wrapper i {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 1.1rem;
      pointer-events: none;
    }

    .form-control-modern {
      display: flex;
      align-items: center;
      width: 100%;
      padding: 14px 16px 14px 45px;
      font-size: 1rem;
      font-weight: 500;
      color: #334155;
      background-color: #f8fafc;
      background-clip: padding-box;
      border: 1.5px solid #e2e8f0;
      border-radius: 12px;
      transition: all .2s ease-in-out;
      cursor: pointer;
      user-select: none;
    }

    .form-control-modern.dropdown-active {
      border-color: #1e3a5f;
      background-color: #ffffff;
      box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.25);
    }

    /* Custom Dropdown Content Styling */
    .custom-options-container {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background-color: #ffffff;
      border-radius: 12px;
      margin-top: 6px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
      border: 1px solid #e2e8f0;
      z-index: 100;
      overflow: hidden;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.2s ease;
    }

    .custom-options-container.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .custom-option {
      padding: 12px 16px 12px 45px;
      font-size: 1rem;
      font-weight: 500;
      color: #334155;
      cursor: pointer;
      transition: all 0.15s ease;
    }

    /* Inilah Kunci dari Efek Hover HIJAU yang diminta Ã°Å¸ËœÂ */
    .custom-option:hover {
      background-color: #1e3a5f;
      color: #ffffff;
      padding-left: 50px; /* Slight indent effect */
    }

    .custom-option.selected {
      background-color: #e5ffe5;
      color: #1e3a5f;
      font-weight: 700;
    }

    /* Modern Dropdown Arrow */
    .dropdown-arrow {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      font-size: 1.1rem;
      transition: transform 0.3s ease;
      pointer-events: none;
    }

    .form-control-modern.dropdown-active .dropdown-arrow {
      transform: translateY(-50%) rotate(180deg);
    }

    /* Buttons */
    .btn-modern {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      padding: 14px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 12px;
      border: none;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-primary-custom {
      background-color: #1e3a5f;
      color: white;
      box-shadow: 0 4px 14px rgba(45, 106, 79, 0.25);
      margin-bottom: 15px;
    }

    .btn-primary-custom:hover {
      background-color: #132b4b;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(45, 106, 79, 0.3);
      color: white;
    }

    .btn-danger-custom {
      background-color: #fff1f2;
      color: #e11d48;
      border: 1px solid #ffe4e6;
    }

    .btn-danger-custom:hover {
      background-color: #ffe4e6;
      color: #be123c;
    }

    /* Avatar Icon */
    .avatar-wrapper {
      width: 80px;
      height: 80px;
      background-color: #ffffff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px auto;
      box-shadow: 0 8px 24px rgba(0,0,0,0.06);
      border: 3px solid #1e3a5f;
    }
    
    .avatar-wrapper i {
      font-size: 35px;
      color: #1e3a5f;
    }

  </style>
</head>
<body>

<div class="bg-shape"></div>

<div class="modern-card">
  <div class="avatar-wrapper">
    <i class="fas fa-user-circle"></i>
  </div>
  
  <div class="header-text">
    <h5>Selamat Datang, {{ Auth::user()->name }}!</h5>
    <p>Silakan tentukan tahun data yang ingin Anda kelola untuk melanjutkan ke Dasbor.</p>
  </div>

  <form action="{{ route('tahun-data-store') }}" method="post" id="tahunForm">
    {{ csrf_field() }}
    
    <div class="custom-select-wrapper" id="tahunDropdown">
      <i class="fas fa-calendar-alt"></i>
      
      <!-- Input asli disembunyikan -->
      <input type="hidden" name="tahun" id="tahun-input" required>
      
      <!-- Custom Select Trigger -->
      <div class="form-control-modern" id="selectedText">
        Pilih Tahun Validata
        <i class="fas fa-chevron-down dropdown-arrow"></i>
      </div>

      <!-- Custom Options Berwarna Hijau -->
      <div class="custom-options-container" id="optionsContainer">
        @for($t=date('Y')-2; $t<=date('Y')+1; $t++)
            <div class="custom-option" data-value="{{ $t }}">{{ $t }}</div>
        @endfor
      </div>
    </div>

    <!-- Error message for manual validation -->
    <div id="error-message" style="display: none; color: #e11d48; font-size: 0.85rem; margin-top: -15px; margin-bottom: 15px; padding-left: 5px;">
      <i class="fas fa-exclamation-circle mr-1"></i> Mohon pilih tahun terlebih dahulu.
    </div>

    <button type="submit" class="btn-modern btn-primary-custom" id="submitBtn">
      Lanjutkan <i class="fas fa-arrow-right ml-2"></i>
    </button>
  </form>

  <form method="POST" action="{{ route('logout') }}" class="mt-3">
    @csrf
    <button type="submit" class="btn-modern btn-danger-custom">
      <i class="fas fa-sign-out-alt mr-2"></i> Keluar
    </button>
  </form>
</div>

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Logika JS Untuk Custom Dropdown Hijau -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('tahunDropdown');
    const selectTrigger = document.getElementById('selectedText');
    const optionsContainer = document.getElementById('optionsContainer');
    const options = document.querySelectorAll('.custom-option');
    const hiddenInput = document.getElementById('tahun-input');
    const form = document.getElementById('tahunForm');
    const errorMessage = document.getElementById('error-message');

    // Toggle dropdown saat diklik
    selectTrigger.addEventListener('click', function(e) {
      e.stopPropagation();
      selectTrigger.classList.toggle('dropdown-active');
      optionsContainer.classList.toggle('show');
    });

    // Pilih spesifik tahun (hover dan klik akan hijau!)
    options.forEach(option => {
      option.addEventListener('click', function() {
        // Hapus status terpilih dari semua opsi
        options.forEach(opt => opt.classList.remove('selected'));
        
        // Buat opsi ini menjadi hijau
        this.classList.add('selected');
        
        // Terapkan tahun yang dpilih
        const val = this.getAttribute('data-value');
        hiddenInput.value = val;
        
        // Ganti text dan tutup dropdown
        // (Kita hapus icon dari innerHTML supaya text saja yang brubah)
        selectTrigger.innerHTML = val + '<i class="fas fa-chevron-down dropdown-arrow"></i>';
        selectTrigger.classList.remove('dropdown-active');
        optionsContainer.classList.remove('show');
      });
    });

    // Menutup box saat klik diluar area
    document.addEventListener('click', function() {
      selectTrigger.classList.remove('dropdown-active');
      optionsContainer.classList.remove('show');
    });

    // Validasi pencegat jika kosong
    form.addEventListener('submit', function(e) {
      if(hiddenInput.value === '') {
        e.preventDefault();
        errorMessage.style.display = 'block';
        selectTrigger.style.borderColor = '#e11d48'; // Jadi merah error
      } else {
        errorMessage.style.display = 'none';
      }
    });
  });
</script>
</body>
</html>