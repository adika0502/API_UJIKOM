<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — Alatin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --navy-deep: #0f1522;
    --navy-panel: #182036;
    --navy-line: #2a3550;
    --paper: #faf7f0;
    --paper-line: #e3ddcd;
    --ink: #171b26;
    --muted: #767c8c;
    --amber: #e8973a;
    --amber-dark: #c67a22;
    --kraft: #efe2c2;
    --kraft-ink: #5a4f30;
    --green: #3f8f5f;
    --red: #c1553d;
  }

  *{ box-sizing: border-box; }

  html, body{
    margin: 0;
    padding: 0;
    min-height: 100vh;
    background: var(--paper);
    color: var(--ink);
    font-family: 'IBM Plex Sans', sans-serif;
  }

  h1, h2, .brand-name, .ticket-item{
    font-family: 'Space Grotesk', sans-serif;
  }

  a{ color: inherit; }

  .screen{
    display: grid;
    grid-template-columns: minmax(340px, 480px) 1fr;
    min-height: 100vh;
  }

  /* ---------- LEFT: form panel ---------- */

  .panel-form{
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 32px;
  }

  .form-wrap{
    width: 100%;
    max-width: 350px;
  }

  .brand{
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 48px;
  }

  .brand-name{
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.01em;
  }

  h1{
    font-size: 33px;
    font-weight: 600;
    line-height: 1.15;
    letter-spacing: -0.01em;
    margin: 0 0 12px;
  }

  .lede{
    font-size: 14.5px;
    line-height: 1.6;
    color: var(--muted);
    margin: 0 0 34px;
    max-width: 34ch;
  }

  form{
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .field{
    position: relative;
  }

  .field input{
    width: 100%;
    padding: 22px 14px 8px 42px;
    font-size: 14.5px;
    font-family: inherit;
    color: var(--ink);
    background: #fff;
    border: 1.5px solid var(--paper-line);
    border-radius: 9px;
    outline: none;
    transition: border-color 0.15s ease;
  }

  .field.pw-field input{
    padding-right: 44px;
  }

  .field input:focus-visible{
    border-color: var(--amber);
  }

  .field label{
    position: absolute;
    left: 42px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14.5px;
    color: #a8a29a;
    pointer-events: none;
    transition: all 0.15s ease;
  }

  .field input:focus + label,
  .field input:not(:placeholder-shown) + label{
    top: 11px;
    transform: translateY(0);
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: 0.01em;
    color: var(--amber-dark);
  }

  .field-icon{
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #a8a29a;
    display: flex;
    pointer-events: none;
    transition: color 0.15s ease;
  }

  .field input:focus ~ .field-icon{
    color: var(--amber-dark);
  }

  .pw-toggle{
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    width: 34px;
    height: 34px;
    border: none;
    background: transparent;
    color: var(--muted);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 6px;
  }

  .pw-toggle:hover{ color: var(--ink); }

  .pw-toggle:focus-visible{
    outline: 2px solid var(--amber);
    outline-offset: 1px;
  }

  .row-between{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13.5px;
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
    width: 15px;
    height: 15px;
    accent-color: var(--amber);
  }

  .link{
    color: var(--amber-dark);
    text-decoration: none;
    font-weight: 500;
  }

  .link:hover{ text-decoration: underline; }

  .btn-primary{
    margin-top: 8px;
    padding: 13px;
    font-family: inherit;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(180deg, #1a2338, var(--navy-deep));
    border: none;
    border-radius: 9px;
    cursor: pointer;
    box-shadow: 0 1px 0 rgba(255,255,255,0.05) inset;
    transition: box-shadow 0.2s ease, background 0.2s ease, transform 0.1s ease;
  }

  .btn-primary:hover{
    background: linear-gradient(180deg, #212c47, #0c111d);
    box-shadow: 0 10px 22px rgba(226,148,53,0.2);
  }

  .btn-primary:active{ transform: translateY(1px); }

  .btn-primary:focus-visible{
    outline: 2px solid var(--amber);
    outline-offset: 2px;
  }

  .footnote{
    margin: 28px 0 0;
    font-size: 13px;
    color: var(--muted);
  }

  .footnote a{
    color: var(--ink);
    font-weight: 500;
    text-decoration: none;
    border-bottom: 1px solid var(--paper-line);
  }

  /* ---------- RIGHT: visual panel ---------- */

  .panel-visual{
    background-color: var(--navy-deep);
    background-image: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1.6px);
    background-size: 22px 22px;
    color: #fff;
    padding: 56px 60px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .panel-visual::before{
    content: '';
    position: absolute;
    inset: 0;
    background:
      radial-gradient(560px 380px at 30% 20%, rgba(232,151,58,0.14), transparent 62%),
      radial-gradient(480px 400px at 90% 90%, rgba(63,143,95,0.09), transparent 60%);
    pointer-events: none;
  }

  .visual-inner{
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 430px;
  }

  /* ticket / equipment tag stack */

  .ticket-stack{
    position: relative;
    width: 300px;
    height: 190px;
    margin-bottom: 44px;
  }

  .ticket{
    position: absolute;
    inset: 0;
    border-radius: 11px;
  }

  .ticket-back{
    background: #cbb98c;
    opacity: 0.5;
    transform: rotate(7deg);
    top: 8px;
    left: 12px;
  }

  .ticket-front{
    background: var(--kraft);
    color: var(--kraft-ink);
    transform: rotate(-3deg);
    display: flex;
    box-shadow: 0 20px 38px rgba(0,0,0,0.4);
    animation: settle 0.6s ease-out;
  }

  @keyframes settle{
    from{ opacity: 0; transform: rotate(-11deg) translateY(16px); }
    to{ opacity: 1; transform: rotate(-3deg) translateY(0); }
  }

  .ticket-hole{
    position: absolute;
    top: 15px;
    left: 15px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--navy-deep);
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
  }

  .ticket-main{
    flex: 1;
    padding: 20px 16px 18px 36px;
    position: relative;
  }

  .ticket-label{
    margin: 0 0 12px;
    font-size: 11px;
    color: #8a7c52;
    font-weight: 600;
  }

  .ticket-item{
    margin: 0 0 16px;
    font-weight: 600;
    font-size: 16.5px;
    line-height: 1.3;
  }

  .ticket-due{
    margin: 0;
    font-size: 12px;
    color: #6b5f3d;
  }

  .ticket-stamp{
    position: absolute;
    right: 12px;
    bottom: 10px;
    width: 68px;
    height: 68px;
    border: 2px dashed var(--amber-dark);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 10.5px;
    color: var(--amber-dark);
    transform: rotate(-14deg);
    letter-spacing: 0.03em;
    line-height: 1.25;
  }

  .ticket-perf{
    width: 0;
    border-left: 2px dashed #c8b98c;
    position: relative;
  }

  .ticket-perf::before,
  .ticket-perf::after{
    content: '';
    position: absolute;
    left: -6px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--navy-deep);
  }

  .ticket-perf::before{ top: -6px; }
  .ticket-perf::after{ bottom: -6px; }

  .ticket-stub{
    width: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ticket-stub span{
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    font-weight: 600;
    font-size: 12px;
    letter-spacing: 0.09em;
    color: #6b5f3d;
  }

  h2{
    font-size: 23px;
    font-weight: 600;
    line-height: 1.35;
    letter-spacing: -0.005em;
    margin: 0 0 30px;
    max-width: 22ch;
  }

  /* ledger list */

  .ledger{
    border: 1px solid var(--navy-line);
    border-radius: 12px;
    background: var(--navy-panel);
    overflow: hidden;
  }

  .ledger-row{
    display: flex;
    align-items: baseline;
    gap: 8px;
    padding: 13px 16px;
  }

  .ledger-row + .ledger-row{
    border-top: 1px solid var(--navy-line);
  }

  .dot{
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    transform: translateY(-1px);
  }

  .dot-green{ background: var(--green); }
  .dot-amber{ background: var(--amber); }
  .dot-red{ background: var(--red); }

  .ledger-name{
    font-size: 13.5px;
    font-weight: 500;
    color: #fff;
    white-space: nowrap;
  }

  .ledger-leader{
    flex: 1;
    border-bottom: 1px dotted #3b4763;
    margin-bottom: 4px;
    min-width: 12px;
  }

  .ledger-status{
    font-size: 12.5px;
    color: #9aa1b4;
    white-space: nowrap;
  }

  /* ---------- responsive ---------- */

  @media (max-width: 900px){
    .screen{
      grid-template-columns: 1fr;
      grid-template-rows: auto auto;
    }

    .panel-visual{
      order: -1;
      padding: 40px 24px 44px;
    }

    .visual-inner{ max-width: 100%; }

    .ticket-stack{ margin: 0 auto 34px; }

    h2{ font-size: 20px; margin-bottom: 24px; }

    .panel-form{ padding: 40px 24px 56px; }
  }

  @media (prefers-reduced-motion: reduce){
    *{ transition: none !important; animation: none !important; }
  }
</style>
</head>
<body>

<div class="screen">

  <section class="panel-form">
    <div class="form-wrap">

      <div class="brand">
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M3 3h9l9 9-9 9-9-9V3Z" fill="#121a2c"/>
          <circle cx="8" cy="8" r="1.6" fill="#e8973a"/>
        </svg>
        <span class="brand-name">Alatin</span>
      </div>

      <h1>Masuk ke akun</h1>
      <p class="lede">Sistem peminjaman alat internal. Masuk dengan akun Admin, Petugas, atau Peminjam yang sudah terdaftar.</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
          <input id="email" name="email" type="email" placeholder=" " autocomplete="username" required autofocus>
          <label for="email">Email</label>
          <span class="field-icon" aria-hidden="true">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2.5"/>
              <path d="m3 6 9 7 9-7"/>
            </svg>
          </span>
        </div>

        <div class="field pw-field">
          <input id="password" name="password" type="password" placeholder=" " autocomplete="current-password" required>
          <label for="password">Kata sandi</label>
          <span class="field-icon" aria-hidden="true">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="10.5" width="16" height="10" rx="2"/>
              <path d="M7.5 10.5V7a4.5 4.5 0 0 1 9 0v3.5"/>
            </svg>
          </span>
          <button type="button" class="pw-toggle" id="pwToggle" aria-label="Tampilkan kata sandi">
            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
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

      <p class="footnote">Belum punya akun? <a href="#">Hubungi admin gudang</a> untuk didaftarkan.</p>
    </div>
  </section>

  <section class="panel-visual" aria-hidden="true">
    <div class="visual-inner">

      <div class="ticket-stack">
        <div class="ticket ticket-back"></div>
        <div class="ticket ticket-front">
          <div class="ticket-hole"></div>
          <div class="ticket-main">
            <p class="ticket-label">Kartu peminjaman</p>
            <p class="ticket-item">Kamera Mirrorless<br>EOS R Series</p>
            <p class="ticket-due">Kembali 5 Sep 2026</p>
          </div>
          <div class="ticket-stamp">DIPINJAM</div>
          <div class="ticket-perf"></div>
          <div class="ticket-stub"><span>AST 0142</span></div>
        </div>
      </div>

      <h2>Setiap alat punya kode. Setiap pinjaman tercatat rapi.</h2>

      <div class="ledger">
        <div class="ledger-row">
          <span class="dot dot-green"></span>
          <span class="ledger-name">Kamera Mirrorless EOS R</span>
          <span class="ledger-leader"></span>
          <span class="ledger-status">Tersedia</span>
        </div>
        <div class="ledger-row">
          <span class="dot dot-amber"></span>
          <span class="ledger-name">Proyektor Epson EB-X06</span>
          <span class="ledger-leader"></span>
          <span class="ledger-status">Kembali 5 Sep</span>
        </div>
        <div class="ledger-row">
          <span class="dot dot-red"></span>
          <span class="ledger-name">Bor Listrik Bosch GSB 13</span>
          <span class="ledger-leader"></span>
          <span class="ledger-status">Perbaikan</span>
        </div>
      </div>

    </div>
  </section>

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