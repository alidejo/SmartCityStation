<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateDeviceRequest;
use App\Http\Requests\Backend\UpdateDeviceRequest;
use App\Repositories\Backend\DeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\DTO\Device;

class DeviceController extends AppBaseController
{
    /** @var  DeviceRepository */
    private $deviceRepository;

    public function __construct(DeviceRepository $deviceRepo)
    {
        $this->deviceRepository = $deviceRepo;
    }

    /**
     * Display a listing of the Device.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $devices = $this->deviceRepository->all();

        return view('backend.devices.index')
            ->with('devices', $devices);
    }

    /**
     * Show the form for creating a new Device.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.devices.create');
    }

    /**
     * Store a newly created Device in storage.
     *
     * @param CreateDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateDeviceRequest $request)
    {

        $state = 0;
        if($request->state == "active"){
            $state = 1;
        } else {
            $state= 2;            
        }

        $input = [
            'device_code' => $request->device_code,
            'state' => $state,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // $input = $request->all();

        try {
            $device = $this->deviceRepository->create($input);
            Flash::success('Device saved successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            Flash::success('The Device Code already exists.');
        }

        return redirect(route('admin.devices.index'));
    }

    /**
     * Display the specified Device.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        return view('backend.devices.show')->with('device', $device);
    }

    /**
     * Show the form for editing the specified Device.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        return view('backend.devices.edit')->with('device', $device);
    }

    /**
     * Update the specified Device in storage.
     *
     * @param int $id
     * @param UpdateDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeviceRequest $request)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        $state = 0;
        if($request->state == "active"){
            $state = 1;
        } else {
            $state= 2;            
        }

        $input = [
            'device_code' => $request->device_code,
            'state' => $state,
            'created_at' =>  $request->created_at,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $device->device_code = $input['device_code'];
            $device->state = $input['state'];
            $device->created_at = $input['created_at'];
            $device->created_at = $input['updated_at'];        

            $device->save();

            // $device = $this->deviceRepository->update($request->all(), $id);

            Flash::success('Device updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success('The Device Code already exists.');
        }

        return redirect(route('admin.devices.index'));
    }

    /**
     * Remove the specified Device from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $device = $this->deviceRepository->find($id);

        if (empty($device)) {
            Flash::error('Device not found');

            return redirect(route('admin.devices.index'));
        }

        $this->deviceRepository->delete($id);

        Flash::success('Device deleted successfully.');

        return redirect(route('admin.devices.index'));
    }
}
