<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import leads</title>
</head>
<body>
<h1>Import leads</h1>

<form method="POST" action="{{ route('leads.import.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file" accept=".csv,text/csv" required>

    <button type="submit">Import</button>
</form>

@if (session('import_result'))
    @php($result = session('import_result'))

    <h2>Import completed</h2>

    <ul>
        <li>Processed: {{ $result['processed'] }}</li>
        <li>Inserted: {{ $result['inserted'] }}</li>
        <li>Errors: {{ $result['errors'] }}</li>
        <li>Time: {{ $result['duration'] }} sec.</li>
    </ul>
@endif
</body>
</html>
