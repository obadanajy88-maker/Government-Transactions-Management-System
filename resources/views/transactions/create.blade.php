<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إرسال معاملة</title>
    <style>
        :root {
            --bg: #f5f8ff;
            --card: #ffffff;
            --text: #16324f;
            --muted: #667085;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --border: #dbe6f7;
            --success: #1f8f5f;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Tahoma, Arial, sans-serif;
            padding: 32px 18px;
            background:
                radial-gradient(circle at top left, #dbeafe, transparent 25%),
                radial-gradient(circle at bottom right, #bfdbfe, transparent 32%),
                var(--bg);
            color: var(--text);
        }

        .container {
            width: min(100%, 760px);
            margin: 0 auto;
            background: rgba(255,255,255,0.96);
            border-radius: 26px;
            padding: 28px;
            box-shadow: 0 18px 45px rgba(20, 53, 116, 0.12);
            border: 1px solid rgba(219,230,247,0.9);
        }

        .header {
            margin-bottom: 22px;
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 1.8rem;
        }

        .header p {
            margin: 0;
            color: var(--muted);
        }

        .notice {
            background: #effbf4;
            border: 1px solid #c6f0d8;
            color: var(--success);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-weight: 700;
        }

        .alert {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 14px;
            background: #fff1f2;
            color: #b91c1c;
            border: 1px solid #fecdd3;
        }

        form {
            display: grid;
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: 700;
        }

        select, textarea, input[type="file"] {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px 14px;
            background: #fff;
            outline: none;
            font-family: inherit;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        select:focus, textarea:focus, input[type="file"]:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
        }

        .btn {
            border: none;
            border-radius: 14px;
            padding: 14px 18px;
            font-weight: 800;
            cursor: pointer;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 12px 24px rgba(29,78,216,0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إرسال معاملة جديدة</h1>
            <p>اختر الخدمة وأرفق المستندات المطلوبة</p>
        </div>

        @if (session('success'))
            <div class="notice">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('citizen.transactions.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label for="service_id">نوع الخدمة</label>
                <select name="service_id" id="service_id" required>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="notes">ملاحظات إضافية</label>
                <textarea name="notes" id="notes" placeholder="اكتب تفاصيل المعاملة أو أي ملاحظات إضافية..."></textarea>
            </div>

            <div class="field">
                <label for="attachments">المرفقات</label>
                <input type="file" name="attachments[]" id="attachments" multiple accept="application/pdf,image/png,image/jpeg,image/jpg">
            </div>

            <button type="submit" class="btn">إرسال المعاملة</button>
        </form>
    </div>
</body>
</html>
