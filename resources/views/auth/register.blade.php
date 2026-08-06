<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد</title>
    <style>
        :root {
            --bg: #f4f7ff;
            --card: rgba(255,255,255,0.96);
            --text: #153251;
            --muted: #64748b;
            --primary: #2563eb;
            --primary-dark: #1e3a8a;
            --border: #dce7f8;
            --shadow: 0 18px 40px rgba(20, 53, 116, 0.14);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Tahoma, Arial, sans-serif;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at top right, #dbeafe 0%, transparent 35%),
                radial-gradient(circle at bottom left, #bfdbfe 0%, transparent 30%),
                var(--bg);
            color: var(--text);
        }

        .auth-card {
            width: min(100%, 680px);
            background: var(--card);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .brand-badge {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .title {
            margin: 0;
            font-size: 1.65rem;
        }

        .subtitle {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
            margin-bottom: 16px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 0.92rem;
            font-weight: 700;
        }

        input, select {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px 14px;
            font-size: 0.96rem;
            outline: none;
            background: #fff;
        }

        input:focus, select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
        }

        .alert {
            border-radius: 14px;
            background: #fff1f2;
            color: #b91c1c;
            border: 1px solid #fecdd3;
            padding: 12px 14px;
            margin: 16px 0 20px;
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 14px 18px;
            cursor: pointer;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            font-size: 1rem;
            font-weight: 800;
            box-shadow: 0 12px 24px rgba(29, 78, 216, 0.25);
        }

        .helper {
            margin-top: 14px;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .helper a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand">
            <div class="brand-badge">OB</div>
            <div>
                <h1 class="title">إنشاء حساب جديد</h1>
                <p class="subtitle">املأ البيانات وانضم إلى النظام بسهولة</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf
            <div class="grid">
                <div class="field full">
                    <label for="full_name">الاسم الكامل</label>
                    <input type="text" name="full_name" id="full_name" required autocomplete="name" value="" placeholder="مثال: عبادة أحمد">
                </div>

                <div class="field">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" required autocomplete="email" value="" placeholder="name@example.com">
                </div>

                <div class="field">
                    <label for="national_id">الرقم الوطني</label>
                    <input type="text" name="national_id" id="national_id" required autocomplete="off" value="" placeholder="12345678901234">
                </div>

                <div class="field">
                    <label for="phone_number">رقم الهاتف</label>
                    <input type="text" name="phone_number" id="phone_number" required autocomplete="tel" value="" placeholder="0501234567">
                </div>

                <div class="field">
                    <label for="role">الدور</label>
                    <select name="role" id="role" required>
                        <option value="" selected disabled hidden>اختر دورك</option>
                        <option value="citizen">مواطن</option>
                        <option value="employee">موظف</option>
                        <option value="manager">مدير</option>
                    </select>
                </div>

                <div class="field">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" required autocomplete="new-password" value="" placeholder="••••••••">
                </div>

                <div class="field">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" value="" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn">إنشاء الحساب</button>
        </form>

        <div class="helper">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}">تسجيل الدخول</a>
        </div>
    </div>
</body>
</html>
