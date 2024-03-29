@if ($row->isExpired())
    <div class="badge bg-light-danger">
        <div class="mb-2">{{ \Carbon\Carbon::parse($row->ends_at)->isoFormat('LT') }}</div>
        <div>{{ \Carbon\Carbon::parse($row->ends_at)->isoFormat('Do MMM, Y') }}</div>
    </div>
@else
    <div class="badge bg-light-info">
        <div class="mb-2">{{ \Carbon\Carbon::parse($row->ends_at)->isoFormat('LT') }}</div>
        <div>{{ \Carbon\Carbon::parse($row->ends_at)->isoFormat('Do MMM, Y') }}</div>
    </div>
@endif
