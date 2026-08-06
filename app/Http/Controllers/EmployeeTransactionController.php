<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeTransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::query()
            ->with(['user', 'service', 'currentHandler'])
            ->whereIn('status', ['pending', 'in_progress', 'accepted', 'rejected', 'transferred'])
            ->orderByDesc('created_at')
            ->get();

        return view('transactions.employee-dashboard', [
            'transactions' => $transactions,
        ]);
    }

    public function process(ProcessTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $action = $request->input('action');

        DB::transaction(function () use ($request, $transaction, $action) {
            if ($action === 'claim') {
                $transaction->update([
                    'current_handler_id' => $request->user()->id,
                    'status' => 'in_progress',
                ]);

                return;
            }

            if ($action === 'accept') {
                $transaction->update([
                    'current_handler_id' => $request->user()->id,
                    'status' => 'accepted',
                    'notes' => $request->input('notes', $transaction->notes),
                ]);

                return;
            }

            if ($action === 'reject') {
                $transaction->update([
                    'current_handler_id' => $request->user()->id,
                    'status' => 'rejected',
                    'notes' => $request->input('reason'),
                ]);

                return;
            }

            if ($action === 'transfer') {
                $transaction->update([
                    'current_handler_id' => $request->input('transfer_to_user_id', $request->user()->id),
                    'status' => 'transferred',
                    'notes' => $request->input('reason'),
                ]);

                return;
            }

            $transaction->update([
                'current_handler_id' => $request->user()->id,
                'status' => 'completed',
            ]);
        });

        return redirect()->back()->with('success', 'تم تحديث المعاملة بنجاح.');
    }
}
