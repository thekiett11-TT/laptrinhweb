<?php include ROOT_PATH . 'app/views/shares/header.php'; ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap');

  .auth-page {
    min-height: 100vh;
    background: #0a0a0f;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Be Vietnam Pro', sans-serif;
    position: relative;
    overflow: hidden;
    padding: 40px 16px;
  }

  .auth-page::before,
  .auth-page::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.15;
    animation: float 8s ease-in-out infinite;
  }
  .auth-page::before {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #4ecdc4, #1a535c);
    top: -100px; right: -100px;
  }
  .auth-page::after {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #ff6b35, #f7c59f);
    bottom: -80px; left: -80px;
    animation-delay: -4s;
  }

  @keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50%       { transform: translate(30px, 20px) scale(1.05); }
  }

  .auth-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 48px 40px;
    width: 100%;
    max-width: 440px;
    position: relative;
    z-index: 1;
    box-shadow: 0 32px 64px rgba(0,0,0,0.5);
    animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
  }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .auth-brand {
    text-align: center;
    margin-bottom: 36px;
  }

  .auth-brand .logo-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #4ecdc4, #44a8a0);
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(78,205,196,0.4);
  }

  .auth-brand h1 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -0.5px;
  }

  .auth-brand p {
    color: rgba(255,255,255,0.45);
    font-size: 14px;
    margin: 0;
  }

  .flash-alert {
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 24px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .flash-alert.error   { background: rgba(255,79,79,0.15); border: 1px solid rgba(255,79,79,0.3); color: #ff9a9a; }
  .flash-alert.success { background: rgba(78,205,196,0.15); border: 1px solid rgba(78,205,196,0.3); color: #7ee8e4; }

  .form-group { margin-bottom: 18px; }

  .form-label {
    display: block;
    color: rgba(255,255,255,0.6);
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 8px;
    letter-spacing: 0.6px;
    text-transform: uppercase;
  }

  .form-input {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 13px 16px 13px 44px;
    color: #fff;
    font-size: 15px;
    font-family: 'Be Vietnam Pro', sans-serif;
    transition: all 0.2s ease;
    outline: none;
    box-sizing: border-box;
  }

  .form-input:focus {
    border-color: #4ecdc4;
    background: rgba(78,205,196,0.06);
    box-shadow: 0 0 0 3px rgba(78,205,196,0.15);
  }

  .form-input::placeholder { color: rgba(255,255,255,0.25); }

  .input-icon-wrap { position: relative; }
  .input-icon-wrap .icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.3);
    font-size: 16px;
    pointer-events: none;
  }

  /* Password strength indicator */
  .strength-bar {
    height: 3px;
    border-radius: 3px;
    margin-top: 8px;
    background: rgba(255,255,255,0.08);
    overflow: hidden;
  }
  .strength-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.3s, background 0.3s;
    width: 0%;
  }

  .btn-auth {
    width: 100%;
    background: linear-gradient(135deg, #4ecdc4, #44a8a0);
    border: none;
    border-radius: 12px;
    padding: 15px;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Be Vietnam Pro', sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 8px;
  }
  .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(78,205,196,0.4); }
  .btn-auth:active { transform: translateY(0); }

  .auth-footer {
    text-align: center;
    margin-top: 24px;
    color: rgba(255,255,255,0.4);
    font-size: 14px;
  }
  .auth-footer a {
    color: #4ecdc4;
    text-decoration: none;
    font-weight: 600;
  }
  .auth-footer a:hover { text-decoration: underline; }

  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
    color: rgba(255,255,255,0.2);
    font-size: 12px;
  }
  .divider::before, .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.1);
  }

  .hint-text {
    font-size: 11px;
    color: rgba(255,255,255,0.3);
    margin-top: 5px;
  }
</style>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-brand">
      <div class="logo-icon">✨</div>
      <h1>Tạo tài khoản</h1>
      <p>Đăng ký để bắt đầu mua sắm tại ToTheKiet!</p>
    </div>

    <?php if ($flash): ?>
      <div class="flash-alert <?= $flash['type'] ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?>
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <form action="/ToTheKiet/index.php?url=account/doregister" method="POST">
      <div class="form-group">
        <label class="form-label">Tên đăng nhập</label>
        <div class="input-icon-wrap">
          <span class="icon">👤</span>
          <input
            type="text"
            name="username"
            class="form-input"
            placeholder="vd: nguyenvan_a"
            autocomplete="username"
            required
          />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Họ và tên</label>
        <div class="input-icon-wrap">
          <span class="icon">📝</span>
          <input
            type="text"
            name="fullname"
            class="form-input"
            placeholder="Nguyễn Văn A"
            required
          />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Mật khẩu</label>
        <div class="input-icon-wrap">
          <span class="icon">🔒</span>
          <input
            type="password"
            name="password"
            id="password"
            class="form-input"
            placeholder="Tối thiểu 6 ký tự"
            autocomplete="new-password"
            required
            oninput="checkStrength(this.value)"
          />
        </div>
        <div class="strength-bar">
          <div class="strength-fill" id="strengthFill"></div>
        </div>
        <p class="hint-text" id="strengthText">Nhập mật khẩu để kiểm tra độ mạnh</p>
      </div>

      <div class="form-group">
        <label class="form-label">Xác nhận mật khẩu</label>
        <div class="input-icon-wrap">
          <span class="icon">🔐</span>
          <input
            type="password"
            name="confirm_password"
            id="confirm_password"
            class="form-input"
            placeholder="Nhập lại mật khẩu"
            autocomplete="new-password"
            required
          />
        </div>
      </div>

      <button type="submit" class="btn-auth">Tạo tài khoản →</button>
    </form>

    <div class="divider">hoặc</div>

    <div class="auth-footer">
      Đã có tài khoản?
      <a href="/ToTheKiet/account/login">Đăng nhập</a>
    </div>
  </div>
</div>

<script>
function checkStrength(val) {
  const fill = document.getElementById('strengthFill');
  const text = document.getElementById('strengthText');
  let score = 0;
  if (val.length >= 6)  score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  const levels = [
    { pct: '0%',   color: 'transparent', label: 'Nhập mật khẩu để kiểm tra độ mạnh' },
    { pct: '25%',  color: '#ff4f4f',     label: '⚠️ Rất yếu' },
    { pct: '50%',  color: '#ff9a00',     label: '🔸 Yếu' },
    { pct: '75%',  color: '#f7c59f',     label: '🔶 Trung bình' },
    { pct: '90%',  color: '#4ecdc4',     label: '✅ Mạnh' },
    { pct: '100%', color: '#44d66a',     label: '💪 Rất mạnh' },
  ];

  const lv = levels[score] || levels[0];
  fill.style.width = lv.pct;
  fill.style.background = lv.color;
  text.textContent = lv.label;
}
</script>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>