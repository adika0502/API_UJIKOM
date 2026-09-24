<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — Alatin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --ink: #0F1216;
    --surface: #171B21;
    --surface2: #1E232B;
    --line: #2B323D;
    --amber: #DFA23C;
    --amber-soft: rgba(223,162,60,0.12);
    --amber-hover: #EBB158;
    --rust: #B4573F;
    --leaf: #5AA579;
    --steel: #4C8FBD;
    --text: #EDEAE0;
    --muted: #7C8492;
  }

  *{ box-sizing: border-box; }

  html, body{
    margin: 0;
    min-height: 100vh;
    background: var(--ink);
    color: var(--text);
    font-family: 'IBM Plex Mono', monospace;
  }

  h1, .brand-name, .btn-primary{
    font-family: 'Space Grotesk', sans-serif;
  }

  .bg-grid{
    position: fixed;
    inset: 0;
    background-image:
      radial-gradient(circle, rgba(255,255,255,0.035) 1px, transparent 1.4px);
    background-size: 26px 26px;
    z-index: 0;
  }

  .bg-glow{
    position: fixed;
    inset: 0;
    background:
      radial-gradient(560px 420px at 18% 12%, rgba(223,162,60,0.10), transparent 60%),
      radial-gradient(520px 460px at 88% 92%, rgba(90,165,121,0.08), transparent 60%);
    z-index: 0;
    pointer-events: none;
  }

  .screen{
    position: relative;
    z-index: 1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }

  .brand{
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
  }

  .brand-icon{
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: var(--surface2);
    border: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    flex-shrink: 0;
  }

  .brand-icon .pulse{
    position: absolute;
    top: -3px;
    right: -3px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--amber);
    box-shadow: 0 0 0 0 rgba(223,162,60,0.6);
    animation: pulse 2s infinite;
  }

  @keyframes pulse{
    0%{ box-shadow: 0 0 0 0 rgba(223,162,60,0.55); }
    70%{ box-shadow: 0 0 0 7px rgba(223,162,60,0); }
    100%{ box-shadow: 0 0 0 0 rgba(223,162,60,0); }
  }

  .brand-name{
    font-size: 17px;
    font-weight: 600;
    color: var(--text);
    letter-spacing: 0.01em;
  }

  .brand-tag{
    display: block;
    font-size: 10.5px;
    color: var(--muted);
    margin-top: 1px;
    letter-spacing: 0.02em;
  }

  .card{
    width: 100%;
    max-width: 380px;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 36px 32px 30px;
    box-shadow: 0 30px 60px -20px rgba(0,0,0,0.55);
  }

  h1{
    font-size: 22px;
    font-weight: 600;
    margin: 0 0 6px;
    color: var(--text);
    letter-spacing: -0.01em;
  }

  .lede{
    font-size: 13px;
    color: var(--muted);
    margin: 0 0 26px;
    line-height: 1.55;
  }

  form{
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .field{
    position: relative;
  }

  .field-label{
    display: block;
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 6px;
  }

  .field-box{
    position: relative;
    display: flex;
    align-items: center;
  }

  .field-icon{
    position: absolute;
    left: 13px;
    color: var(--muted);
    display: flex;
    pointer-events: none;
    transition: color 0.15s ease;
  }

  .field input{
    width: 100%;
    padding: 12px 14px 12px 40px;
    font-size: 14px;
    font-family: 'IBM Plex Mono', monospace;
    color: var(--text);
    background: var(--surface2);
    border: 1.5px solid var(--line);
    border-radius: 10px;
    outline: none;
    transition: border-color 0.15s ease, background 0.15s ease;
  }

  .field.pw-field input{ padding-right: 42px; }

  .field input::placeholder{ color: #4B5563; }

  .field input:focus{
    border-color: var(--amber);
    background: #22272F;
  }

  .field input:focus ~ .field-icon,
  .field-box:has(input:focus) .field-icon{
    color: var(--amber);
  }

  .pw-toggle{
    position: absolute;
    right: 4px;
    width: 32px;
    height: 32px;
    border: none;
    background: transparent;
    color: var(--muted);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 6px;
  }

  .pw-toggle:hover{ color: var(--text); }

  .pw-toggle:focus-visible{
    outline: 2px solid var(--amber);
    outline-offset: 1px;
  }

  .row-between{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12.5px;
    margin-top: 2px;
  }

  .checkbox{
    display: flex;
    align-items: center;
    gap: 7px;
    color: var(--muted);
    font-weight: 400;
    cursor: pointer;
  }

  .checkbox input{
    width: 14px;
    height: 14px;
    accent-color: var(--amber);
  }

  .link{
    color: var(--amber);
    text-decoration: none;
    font-weight: 500;
  }

  .link:hover{ text-decoration: underline; }

  .btn-primary{
    margin-top: 10px;
    padding: 13px;
    font-size: 14.5px;
    font-weight: 600;
    color: var(--ink);
    background: var(--amber);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.18s ease, box-shadow 0.18s ease, transform 0.1s ease;
  }

  .btn-primary:hover{
    background: var(--amber-hover);
    box-shadow: 0 10px 26px -8px rgba(223,162,60,0.45);
  }

  .btn-primary:active{ transform: translateY(1px); }

  .btn-primary:focus-visible{
    outline: 2px solid var(--amber);
    outline-offset: 2px;
  }

  .divider{
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 24px 0 18px;
    color: var(--muted);
    font-size: 10.5px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
  }

  .divider::before, .divider::after{
    content: '';
    flex: 1;
    height: 1px;
    background: var(--line);
  }

  .role-chips{
    display: flex;
    gap: 8px;
  }

  .role-chip{
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 10px 6px;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: var(--surface2);
  }

  .role-chip .dot{
    width: 7px;
    height: 7px;
    border-radius: 50%;
  }

  .role-chip span{
    font-size: 10px;
    color: var(--muted);
    letter-spacing: 0.02em;
  }

  .dot-amber{ background: var(--amber); }
  .dot-steel{ background: var(--steel); }
  .dot-leaf{ background: var(--leaf); }

  .footnote{
    text-align: center;
    margin-top: 22px;
    font-size: 12px;
    color: var(--muted);
  }

  .footnote a{
    color: var(--text);
    font-weight: 500;
    text-decoration: none;
    border-bottom: 1px solid var(--line);
  }

  .footnote a:hover{ border-color: var(--amber); color: var(--amber); }

  .errors{
    background: rgba(180,87,63,0.12);
    border: 1px solid rgba(180,87,63,0.3);
    color: #E08A75;
    font-size: 12.5px;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 16px;
    line-height: 1.5;
  }

  @media (prefers-reduced-motion: reduce){
    *{ transition: none !important; animation: none !important; }
  }
</style>
</head>
<body>

<div class="bg-grid"></div>
<div class="bg-glow"></div>

<div class="screen">

  <div class="brand">
    <div class="brand-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M12.6 2.6l8.8 8.8c.8.8.8 2 0 2.8l-7.2 7.2c-.8.8-2 .8-2.8 0l-8.8-8.8c-.4-.4-.6-.9-.6-1.4V3.6c0-.6.4-1 1-1h7.6c.5 0 1 .2 1.4.6z" stroke="#EDEAE0" stroke-width="1.6" stroke-linejoin="round"/>
        <circle cx="7" cy="7.4" r="1.4" fill="#DFA23C"/>
      </svg>
      <span class="pulse"></span>
    </div>
    <div>
      <span class="brand-name">Alatin</span>
      <span class="brand-tag">Sistem Peminjaman Alat</span>
    </div>
  </div>

  <div class="card">
    <h1>Selamat datang kembali</h1>
    <p class="lede">Masuk dengan akun yang sudah terdaftar untuk melanjutkan.</p>

    @if($errors->any())
      <div class="errors">
        @foreach($errors->all() as $error)
          {{ $error }}@if(!$loop->last)<br>@endif
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="field">
        <label class="field-label" for="email">Email</label>
        <div class="field-box">
          <span class="field-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2.5"/>
              <path d="m3 6 9 7 9-7"/>
            </svg>
          </span>
          <input id="email" name="email" type="email" placeholder="nama@contoh.com" autocomplete="username" required autofocus value="{{ old('email') }}">
        </div>
      </div>

      <div class="field pw-field">
        <label class="field-label" for="password">Kata sandi</label>
        <div class="field-box">
          <span class="field-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="10.5" width="16" height="10" rx="2"/>
              <path d="M7.5 10.5V7a4.5 4.5 0 0 1 9 0v3.5"/>
            </svg>
          </span>
          <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
          <button type="button" class="pw-toggle" id="pwToggle" aria-label="Tampilkan kata sandi">
            <svg id="eyeIcon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="row-between">
        <label class="checkbox">
          <input type="checkbox" name="remember">
          Ingat saya
        </label>
        <a href="#" class="link">Lupa kata sandi?</a>
      </div>

      <button type="submit" class="btn-primary">Masuk</button>
    </form>

    <div class="divider">Akses berdasarkan peran</div>

    <div class="role-chips">
      <div class="role-chip"><span class="dot dot-amber"></span><span>Admin</span></div>
      <div class="role-chip"><span class="dot dot-steel"></span><span>Petugas</span></div>
      <div class="role-chip"><span class="dot dot-leaf"></span><span>Peminjam</span></div>
    </div>
  </div>

  <p class="footnote">Belum punya akun? <a href="#">Hubungi admin gudang</a> untuk didaftarkan.</p>
</div>

<script>
  const pwInput = document.getElementById('password');
  const pwToggle = document.getElementById('pwToggle');
  const eyeIcon = document.getElementById('eyeIcon');

  const eyeOpen = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/>';
  const eyeClosed = '<path d="M3 3l18 18"/><path d="M10.6 5.1A11 11 0 0 1 12 5c7 0 11 7 11 7a17.9 17.9 0 0 1-4 4.6M6.6 6.6C3.7 8.4 1 12 1 12s4 7 11 7a10.6 10.6 0 0 0 4.2-.9"/><path d="M9.5 9.5a3 3 0 0 0 4.2 4.2"/>';

  pwToggle.addEventListener('click', () => {
    const isPassword = pwInput.type === 'password';
    pwInput.type = isPassword ? 'text' : 'password';
    eyeIcon.innerHTML = isPassword ? eyeClosed : eyeOpen;
    pwToggle.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
  });
</script>

</body>
</html>