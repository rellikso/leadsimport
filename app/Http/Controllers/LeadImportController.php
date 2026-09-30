<?php

namespace App\Http\Controllers;

use App\Services\LeadImportService;
use Illuminate\Http\Request;

class LeadImportController extends Controller
{
    public function __construct(
        private readonly LeadImportService $importService,
    ) {
    }

    public function create()
    {
        return view('leads.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        try {
            $result = $this->importService->import(
                $request->file('file')
            );
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('import_error', $e->getMessage());
        }

        return back()->with('import_result', $result);
    }
}
