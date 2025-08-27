<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use Paypack\Paypack;
use Illuminate\Support\Carbon;

class TransactionStatusUpdater extends Component
{
    public $lastRun;

    public function mount(): void
    {
        $this->lastRun = Carbon::now();
    }

    public function updateStatuses(): void
    {
        $paypack = new Paypack();
        $paypack->config([
            'client_id' => config('services.paypack.client_id'),
            'client_secret' => config('services.paypack.client_secret'),
        ]);

        $pendingPayments = Payment::whereNotIn('status', ['successful', 'failed'])
            ->where('ref', '!=', '')
            ->get();

        foreach ($pendingPayments as $payment) {
            $transaction = $paypack->Transaction($payment->ref);
            if ($transaction && isset($transaction['status'])) {
                $oldStatus = $payment->status;
                $payment->update([
                    'status' => $transaction['status'],
                    'amount' => $transaction['amount'] ?? $payment->amount,
                    'kind' => $transaction['kind'] ?? $payment->kind,
                    'merchant' => $transaction['merchant'] ?? $payment->merchant,
                    'timestamp' => isset($transaction['timestamp']) ? \Carbon\Carbon::parse($transaction['timestamp'])->format('Y-m-d H:i:s') : $payment->timestamp,
                    'client' => $transaction['client'] ?? $payment->client,
                ]);
                // If status just became successful, create/update subscription
                if ($oldStatus !== 'successful' && $transaction['status'] === 'successful' && $payment->amount == 100) {
                    $user = $payment->user;
                    if ($user) {
                        $start = now();
                        $end = now()->addDays(31);
                        $user->subscription()->updateOrCreate(
                            ['user_id' => $user->id],
                            [
                                'start_date' => $start,
                                'end_date' => $end,
                            ]
                        );
                        \Log::info('Subscription created/updated by TransactionStatusUpdater', [
                            'user_id' => $user->id,
                            'start_date' => $start,
                            'end_date' => $end,
                            'payment_id' => $payment->id,
                        ]);
                    }
                }
            }
        }
        $this->lastRun = Carbon::now();
    }

    public function render()
    {
        return view('livewire.transaction-status-updater', [
            'lastRun' => $this->lastRun,
        ]);
    }
}
