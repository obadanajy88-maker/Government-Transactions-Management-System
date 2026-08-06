<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitTransactionRequest;
use App\Models\Attachment;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function create(): View
    {
        $services = Service::query()->where('is_active', true)->get();

        if ($services->isEmpty()) {
            $defaults = [
                'إصدار رخصة',
                'تجديد بطاقة',
                'تحديث البيانات',
            ];

            foreach ($defaults as $name) {
                Service::query()->firstOrCreate([
                    'name' => $name,
                ], [
                    'is_active' => true,
                ]);
            }

            $services = Service::query()->where('is_active', true)->get();
        }

        return view('transactions.create', [
            'services' => $services,
        ]);
    }

    public function store(SubmitTransactionRequest $request): RedirectResponse
    {
        $transaction = DB::transaction(function () use ($request) {
            $transaction = Transaction::create([
                'transaction_code' => 'TR-'.Str::upper(Str::uuid()),
                'user_id' => $request->user()->id,
                'service_id' => $request->input('service_id'),
                'status' => 'pending',
                'notes' => $request->input('notes'),
            ]);

            foreach ($request->file('attachments', []) as $file) {
                $storedPath = $file->store('attachments', 'public');

                Attachment::create([
                    'transaction_id' => $transaction->id,
                    'file_path' => $storedPath,
                    'file_type' => $file->getClientMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }

            return $transaction;
        });

        return redirect()->route('citizen.transactions.create')
            ->with('success', 'تم تقديم المعاملة بنجاح. رقم المعاملة: '.$transaction->transaction_code);
    }
}
