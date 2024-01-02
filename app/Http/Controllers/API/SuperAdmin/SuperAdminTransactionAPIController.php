<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SuperAdminTransactionAPIController extends AppBaseController
{
    public function showTransaction()
    {
        $query = Transaction::whereHas('user', function ($q) {
            $q->where('department_id', 1);
        })->with(['transactionSubscription.subscriptionPlan', 'user'])->get();

        $query->each(function ($transaction) {
            $transaction->makeHidden(['created_at', 'updated_at', 'theme_mode', 'email_verified_at']);
        });

        if (getLoggedInUser()->hasRole('Admin')) {
            $query->where('user_id', '=', getLoggedInUserId());
        }

        return $this->sendResponse($query, 'Transaction Retrieved Successfully');
    }
}
