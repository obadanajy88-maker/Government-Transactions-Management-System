<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        :root {
            --bg: #f3f7ff;
            --card: rgba(255,255,255,0.92);
            --text: #16324f;
            --muted: #64748b;
            --primary: #1d4ed8;
            --primary-dark: #1e3a8a;
            --border: #dbe5f6;
            --shadow: 0 18px 45px rgba(28, 53, 116, 0.14);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Tahoma, Arial, sans-serif;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top right, #dbeafe 0%, transparent 32%),
                radial-gradient(circle at bottom left, #bfdbfe 0%, transparent 28%),
                var(--bg);
            color: var(--text);
            padding: 24px;
        }

        .auth-card {
            width: min(100%, 460px);
            background: var(--card);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .brand-badge {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .title {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .subtitle {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .alert {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            border-radius: 14px;
            padding: 12px 14px;
            margin: 18px 0;
        }

        .field {
            display: grid;
            gap: 8px;
            margin-bottom: 16px;
        }

        label {
            font-size: 0.92rem;
            font-weight: 700;
        }

        input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px 14px;
            font-size: 0.98rem;
            outline: none;
            transition: 0.2s ease;
            background: #fff;
        }

        input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
        }

        .btn {
            border: none;
            border-radius: 14px;
            width: 100%;
            padding: 14px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 12px 25px rgba(29, 78, 216, 0.25);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(29, 78, 216, 0.3);
        }

        .helper {
            margin-top: 16px;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .helper a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand">
            <div class="brand-badge">OB</div>
            <div>
                <h1 class="title">تسجيل الدخول</h1>
                <p class="subtitle">مرحبًا بك في نظام المعاملات</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf
            <div class="field">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" placeholder="example@domain.com" required autocomplete="off" value="">
            </div>

            <div class="field">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required autocomplete="new-password" value="">
            </div>

            <button type="submit" class="btn">دخول</button>
        </form>

        <div class="helper">
            ليس لديك حساب؟
            <a href="{{ route('register') }}">أنشئ حسابًا جديدًا</a>
        </div>
    </div>
</body>
</html>
