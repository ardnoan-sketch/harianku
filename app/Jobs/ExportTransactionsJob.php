<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExportTransactionsJob implements ShouldQueue
{
    use Queueable;

    protected $userId;
    protected $format;
    protected $filename;

    public function __construct($userId, $format = 'csv')
    {
        $this->userId = $userId;
        $this->format = $format;
        // filename can be logged or saved to DB if we want user notification, but for now we just save it.
        $this->filename = 'export_user_' . $userId . '_' . time() . '.' . $format;
    }

    public function handle(): void
    {
        if ($this->format === 'csv') {
            $this->exportCsv();
        }
    }

    protected function exportCsv()
    {
        $path = 'exports/' . $this->filename;
        \Illuminate\Support\Facades\Storage::disk('local')->put($path, '');
        $file = fopen(storage_path('app/' . $path), 'w');

        fputcsv($file, ['ID', 'Date', 'Type', 'Category', 'Amount', 'Description']);

        // Chunking data so it's very memory efficient (Ringan)
        \App\Models\Transaction::where('user_id', $this->userId)
            ->with('category')
            ->orderBy('date', 'desc')
            ->chunk(1000, function ($transactions) use ($file) {
                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->id,
                        $transaction->date,
                        $transaction->type,
                        $transaction->category->name ?? '-',
                        $transaction->amount,
                        $transaction->description
                    ]);
                }
            });

        fclose($file);
    }
}
