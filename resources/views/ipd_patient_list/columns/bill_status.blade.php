<div class="d-flex align-items-center mt-2">
    @if ($row->bill_status == 1 && $row->bill)
        @if ($row->bill->net_payable_amount <= 0)
            <span class="badge bg-light-success">{{ __('messages.invoice.paid') }}</span>
        @else
            <span class="badge bg-light-danger">{{ __('messages.employee_payroll.unpaid') }}</span>
        @endif
    @else
        <span class="badge bg-light-danger">{{ __('messages.employee_payroll.unpaid') }}</span>
    @endif
</div>
