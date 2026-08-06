<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المعاملات</title>
    <style>
        body { font-family: Tahoma, Arial, sans-serif; background:#f5f7fb; color:#16324f; margin:0; padding:24px; }
        .container { max-width:1100px; margin:0 auto; }
        .card { background:#fff; border:1px solid #dbe5f6; border-radius:16px; padding:20px; margin-bottom:16px; box-shadow:0 6px 18px rgba(22,50,79,0.06); }
        .title { font-size:24px; font-weight:700; margin-bottom:8px; }
        .muted { color:#64748b; margin-bottom:12px; }
        .row { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:8px; }
        .label { font-weight:700; color:#1d4ed8; }
        .badge { display:inline-block; padding:6px 10px; border-radius:999px; background:#e0f2fe; color:#0369a1; font-size:13px; }
        .actions { display:flex; flex-wrap:wrap; gap:10px; margin-top:14px; }
        .panel { background:#f8fbff; border:1px solid #e2e8f0; border-radius:12px; padding:12px; margin-top:10px; }
        .panel-title { font-weight:700; margin-bottom:8px; color:#16324f; }
        input, textarea { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:10px; margin-top:6px; }
        button { border:none; padding:10px 14px; border-radius:10px; cursor:pointer; font-weight:700; color:#fff; background:#2563eb; }
        .btn-secondary { background:#64748b; }
        .btn-danger { background:#dc2626; }
        .btn-success { background:#16a34a; }
        .alert { background:#e8f5e9; padding:12px; margin-bottom:16px; border-radius:10px; color:#166534; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">لوحة المعاملات</h1>
        <p class="muted">راجع المعاملات الحالية وابدأ متابعة كل طلب بشكل واضح ومنظم.</p>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="actions" style="margin-bottom: 16px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-danger">تسجيل الخروج</button>
            </form>
        </div>

        @foreach ($transactions as $transaction)
            <div class="card">
                <div class="row"><span class="label">رمز المعاملة:</span> <span>{{ $transaction->transaction_code }}</span></div>
                <div class="row"><span class="label">الخدمة:</span> <span>{{ $transaction->service->name }}</span></div>
                <div class="row"><span class="label">الحالة:</span> <span class="badge">{{ $transaction->status }}</span></div>
                <div class="row"><span class="label">المواطن:</span> <span>{{ $transaction->user->full_name ?? $transaction->user->name }}</span></div>

                <div class="panel">
                    <div class="panel-title">متابعة المعاملة</div>
                    <div class="actions">
                        <form method="POST" action="{{ route('employee.transactions.process', $transaction) }}">
                            @csrf
                            <input type="hidden" name="action" value="claim">
                            <button type="submit">استلام</button>
                        </form>

                        <form method="POST" action="{{ route('employee.transactions.process', $transaction) }}">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="btn-success">قبول</button>
                        </form>

                        <form method="POST" action="{{ route('employee.transactions.process', $transaction) }}">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <textarea name="reason" placeholder="اكتب سبب الرفض" required></textarea>
                            <button type="submit" class="btn-danger">رفض</button>
                        </form>

                        <form method="POST" action="{{ route('employee.transactions.process', $transaction) }}">
                            @csrf
                            <input type="hidden" name="action" value="transfer">
                            <textarea name="reason" placeholder="اكتب سبب التحويل" required></textarea>
                            <input type="text" name="transfer_to_user_id" placeholder="معرف الموظف الهدف">
                            <button type="submit" class="btn-secondary">تحويل</button>
                        </form>

                        <form method="POST" action="{{ route('employee.transactions.process', $transaction) }}">
                            @csrf
                            <input type="hidden" name="action" value="complete">
                            <button type="submit">إنهاء</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
