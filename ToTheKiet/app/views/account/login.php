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
  }

  /* Animated background blobs */
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
    background: radial-gradient(circle, #ff6b35, #f7c59f);
    top: -100px; left: -100px;
  }
  .auth-page::after {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #4ecdc4, #1a535c);
    bottom: -80px; right: -80px;
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
    max-width: 420px;
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
    background: linear-gradient(135deg, #ff6b35, #f7c59f);
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(255,107,53,0.4);
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

  /* Alert flash */
  .flash-alert {
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 24px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: slideUp 0.3s ease;
  }
  .flash-alert.error   { background: rgba(255,79,79,0.15); border: 1px solid rgba(255,79,79,0.3); color: #ff9a9a; }
  .flash-alert.success { background: rgba(78,205,196,0.15); border: 1px solid rgba(78,205,196,0.3); color: #7ee8e4; }

  /* Form */
  .form-group {
    margin-bottom: 20px;
  }

  .form-label {
    display: block;
    color: rgba(255,255,255,0.6);
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }

  .form-input {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 14px 16px;
    color: #fff;
    font-size: 15px;
    font-family: 'Be Vietnam Pro', sans-serif;
    transition: all 0.2s ease;
    outline: none;
    box-sizing: border-box;
  }

  .form-input:focus {
    border-color: #ff6b35;
    background: rgba(255,107,53,0.06);
    box-shadow: 0 0 0 3px rgba(255,107,53,0.15);
  }

  .form-input::placeholder { color: rgba(255,255,255,0.25); }

  .input-icon-wrap {
    position: relative;
  }
  .input-icon-wrap .form-input { padding-left: 44px; }
  .input-icon-wrap .icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,0.3);
    font-size: 16px;
    pointer-events: none;
  }

  /* Submit button */
  .btn-auth {
    width: 100%;
    background: linear-gradient(135deg, #ff6b35, #f7c59f);
    border: none;
    border-radius: 12px;
    padding: 15px;
    color: #1a0a00;
    font-size: 15px;
    font-weight: 700;
    font-family: 'Be Vietnam Pro', sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
    letter-spacing: 0.3px;
    margin-top: 8px;
    position: relative;
    overflow: hidden;
  }
  .btn-auth::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0);
    transition: background 0.2s;
  }
  .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(255,107,53,0.45); }
  .btn-auth:hover::after { background: rgba(255,255,255,0.1); }
  .btn-auth:active { transform: translateY(0); }

  .auth-footer {
    text-align: center;
    margin-top: 28px;
    color: rgba(255,255,255,0.4);
    font-size: 14px;
  }
  .auth-footer a {
    color: #ff6b35;
    text-decoration: none;
    font-weight: 600;
    transition: opacity 0.2s;
  }
  .auth-footer a:hover { opacity: 0.8; text-decoration: underline; }

  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
    color: rgba(255,255,255,0.2);
    font-size: 12px;
  }
  .divider::before,
  .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.1);
  }
</style>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-brand">
      <div class="logo-icon">🛍️</div>
      <h1>ToTheKiet Shop</h1>
      <p>Chào mừng trở lại! Vui lòng đăng nhập.</p>
    </div>

    <?php if ($flash): ?>
      <div class="flash-alert <?= $flash['type'] ?>">
        <?= $flash['type'] === 'error' ? '⚠️' : '✅' ?>
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <form action="/ToTheKiet/index.php?url=account/checklogin" method="POST">
      <div class="form-group">
        <label class="form-label">Tên đăng nhập</label>
        <div class="input-icon-wrap">
          <span class="icon">👤</span>
          <input
            type="text"
            name="username"
            class="form-input"
            placeholder="Nhập tên đăng nhập..."
            autocomplete="username"
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
            class="form-input"
            placeholder="Nhập mật khẩu..."
            autocomplete="current-password"
            required
          />
        </div>
      </div>

      <button type="submit" class="btn-auth">Đăng nhập →</button>
    </form>

    <div class="divider">hoặc</div>

    <div class="auth-footer">
      Chưa có tài khoản?
      <a href="/ToTheKiet/account/register">Đăng ký ngay</a>
    </div>
  </div>
</div>

<?php include ROOT_PATH . 'app/views/shares/footer.php'; ?>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Ngăn submit truyền thống
    const formData = new FormData(this);
    const data = {
        username: formData.get('username'),
        password: formData.get('password')
    };
    fetch('/ToTheKiet/account/checkLogin', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success && result.token) {
            localStorage.setItem('jwtToken', result.token);
            // Redirect về trang chủ hoặc profile
            window.location.href = '/ToTheKiet/';
        } else {
            alert(result.message || 'Đăng nhập thất bại');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Lỗi kết nối');
    });
});
</script>