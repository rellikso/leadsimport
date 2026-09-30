@extends('layouts.app')

@section('content') <h1 class="mb-4">Import leads</h1>

<form
        method="POST"
        action="{{ route('leads.import.store') }}"
        enctype="multipart/form-data"
        class="card p-4"
        id="import-form"
>
    @csrf

    <div class="mb-3">
        <label for="file" class="form-label">CSV file</label>

        <input
                type="file"
                id="file"
                name="file"
                accept=".csv,text/csv"
                class="form-control"
                required
        >
    </div>

    <div>
        <button type="submit" class="btn btn-primary" id="import-button">
            Import
        </button>

        <span
                class="spinner-border spinner-border-sm text-primary ms-2 d-none"
                id="import-spinner"
                role="status"
                aria-hidden="true"
        ></span>
    </div>
</form>

@if (session('import_error'))
    <div class="alert alert-danger mt-4">
        <strong>Import failed:</strong>
        {{ session('import_error') }}
    </div>
@endif

@if (session('import_result'))
    @php($result = session('import_result'))

    <div class="card mt-4">
        <div class="card-body">
            <h2 class="h5">Import completed</h2>

            <ul class="mb-0">
                <li>Processed: {{ $result['processed'] }}</li>
                <li>Inserted: {{ $result['inserted'] }}</li>
                <li>Time: {{ $result['duration'] }} sec.</li>
            </ul>
        </div>
    </div>
@endif

@endsection

@push('scripts') <script>
    document.getElementById('import-form').addEventListener('submit', function () {
        document.getElementById('import-button').disabled = true;
        document.getElementById('import-spinner').classList.remove('d-none');
    }); </script>
@endpush
