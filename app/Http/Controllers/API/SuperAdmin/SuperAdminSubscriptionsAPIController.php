<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Repositories\SubscriptionPlanRepository;
use Illuminate\Http\Request;

class SuperAdminSubscriptionsAPIController extends AppBaseController
{
    private $subscriptionPlanRepository;

    public function __construct(SubscriptionPlanRepository $subscriptionPlanRepo)
    {
        $this->subscriptionPlanRepository = $subscriptionPlanRepo;
    }

    public function showSubscription()
    {
        $query = Subscription::with(['subscriptionPlan', 'user'])->get();
        //  $query = Subscription::all();

        $query->each(function ($subscription) {
            $subscription->makeHidden(['created_at', 'updated_at']);
        });

        return $this->sendResponse($query, 'Subscription Retrieved Successfully');
    }

    public function editSubscriptions($id)
    {
        $subscription = Subscription::find($id);
        if (empty($subscription)) {
            return $this->sendError('Subscription not found');
        }
        return $this->sendResponse($subscription, 'Subscription Retrieved Successfully');
    }

    public function updateSubscriptions(Request $request, $id)
    {
        $input = $request->all();
        $subscription = Subscription::findOrFail($id);

        if ($subscription->status == Subscription::INACTIVE) {
            $input['status'] = Subscription::ACTIVE;
            $subscription->update($input);
        } else {
            $subscription->update($input);
        }

        return $this->sendSuccess('Subscription updated successfully.');
    }
}
