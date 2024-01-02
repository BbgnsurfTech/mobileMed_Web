<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHospitalRequest;
use App\Models\User;
use App\Repositories\HospitalRepository;
use App\Http\Requests\UpdateHospitalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperAdminHospitalAPIController extends AppBaseController
{
    /** @var HospitalRepository */
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepo)
    {
        $this->hospitalRepository = $hospitalRepo;
    }

    public function createHospital(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospital_name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'city' => 'required',
            'hospital_type_id' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = $request->all();
        $this->hospitalRepository->store($input);

        return response()->json([
            'data' => $input,
            'message' => 'Hospital created successfully',
        ], JsonResponse::HTTP_CREATED);
    }

    public function showHospital()
    {
        $query = User::with(['department', 'media', 'hospitalType']);

        if (getLoggedInUser()->hasRole('Super Admin')) {
            $query->where('department_id', '=', User::USER_ADMIN)->whereNotNull('hospital_name')->whereNotNull('username');
        }

        $query->each(function ($hospital) {
            $hospital->makeHidden(['created_at', 'updated_at']);
        });

        return $this->sendResponse($query->get(), 'Hospital retrieved successfully');
    }

    public function editHospital(int $id)
    {
        $hospital = User::find($id);
        if (empty($hospital) || ! $hospital->hasRole('Admin')) {
            return $this->sendSuccess('Hospital not found');
        }

        $data = $this->hospitalRepository->getSyncList();

        return  $this->sendSuccess($hospital, 'Hospital retrieve successfully.');
    }

    public function updateHospital(Request $request,  $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Hospital not found.');
        }

        $input = $request->all();
        if (array_key_exists('hospital_name', $input)) {
            $this->hospitalRepository->updateHospital($input, $user);
        }

        return $this->sendSuccess('Hospital updated successfully.');
    }

    public function deleteHospital(int $id): JsonResponse
    {
        $hospital = User::find($id);

        if (empty($hospital) || ! $hospital->hasRole('Admin')) {
            return $this->sendSuccess('Hospital not found');
        }

        $this->hospitalRepository->deleteHospital($id);

        return $this->sendSuccess('Hospital deleted successfully');
    }
}
