<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateLocationDeviceAPIRequest;
use App\Http\Requests\API\Backend\UpdateLocationDeviceAPIRequest;
use App\Models\Backend\LocationDevice;
use App\Repositories\Backend\LocationDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LocationDeviceController
 * @package App\Http\Controllers\API\Backend
 */

class LocationDeviceAPIController extends AppBaseController
{
    /** @var  LocationDeviceRepository */
    private $locationDeviceRepository;

    public function __construct(LocationDeviceRepository $locationDeviceRepo)
    {
        $this->locationDeviceRepository = $locationDeviceRepo;
    }

    /**
     * Display a listing of the LocationDevice.
     * GET|HEAD /locationDevices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $locationDevices = $this->locationDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($locationDevices->toArray(), 'Location Devices retrieved successfully');
    }

    /**
     * Store a newly created LocationDevice in storage.
     * POST /locationDevices
     *
     * @param CreateLocationDeviceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationDeviceAPIRequest $request)
    {
        $input = $request->all();

        $locationDevice = $this->locationDeviceRepository->create($input);

        return $this->sendResponse($locationDevice->toArray(), 'Location Device saved successfully');
    }

    /**
     * Display the specified LocationDevice.
     * GET|HEAD /locationDevices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LocationDevice $locationDevice */
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            return $this->sendError('Location Device not found');
        }

        return $this->sendResponse($locationDevice->toArray(), 'Location Device retrieved successfully');
    }

    /**
     * Update the specified LocationDevice in storage.
     * PUT/PATCH /locationDevices/{id}
     *
     * @param int $id
     * @param UpdateLocationDeviceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationDeviceAPIRequest $request)
    {
        $input = $request->all();

        /** @var LocationDevice $locationDevice */
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            return $this->sendError('Location Device not found');
        }

        $locationDevice = $this->locationDeviceRepository->update($input, $id);

        return $this->sendResponse($locationDevice->toArray(), 'LocationDevice updated successfully');
    }

    /**
     * Remove the specified LocationDevice from storage.
     * DELETE /locationDevices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LocationDevice $locationDevice */
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            return $this->sendError('Location Device not found');
        }

        $locationDevice->delete();

        return $this->sendSuccess('Location Device deleted successfully');
    }
}
