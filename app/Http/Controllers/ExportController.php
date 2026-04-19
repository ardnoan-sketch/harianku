<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function trigger(Request $request)
    {
        $user = auth()->user();
        $format = $request->input('format', 'csv'); // leave room for excel
        
        \App\Jobs\ExportTransactionsJob::dispatch($user->id, $format);

        // Normally we save the job status to DB to show a progress bar.
        return back()->with('status', 'Export started in background. You will be notified when it is ready.');
    }

    public function download($filename)
    {
        $path = storage_path('app/exports/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        }
        return abort(404, 'File not found or still processing.');
    }
}
