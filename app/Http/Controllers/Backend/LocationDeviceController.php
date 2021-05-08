<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateLocationDeviceRequest;
use App\Http\Requests\Backend\UpdateLocationDeviceRequest;
use App\Repositories\Backend\LocationDeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\Area;
use App\Models\Backend\LocationDevice;

class LocationDeviceController extends AppBaseController
{
    /** @var  LocationDeviceRepository */
    private $locationDeviceRepository;

    public function __construct(LocationDeviceRepository $locationDeviceRepo)
    {
        $this->locationDeviceRepository = $locationDeviceRepo;
    }

    /**
     * Display a listing of the LocationDevice.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $locationDevices = $this->locationDeviceRepository->all();

        return view('backend.location_devices.index')
            ->with('locationDevices', $locationDevices);
    }

    /**
     * Show the form for creating a new LocationDevice.
     *
     * @return Response
     */
    public function create()
    {
        $devices = Device::pluck('device_code', 'id');
        $areas = Area::pluck('name', 'id');

        $desde = "Create";

        return view('backend.location_devices.create')->with(compact('devices', 'areas', 'desde'));

        // return view('backend.location_devices.create');
    }

    /**
     * Store a newly created LocationDevice in storage.
     *
     * @param CreateLocationDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationDeviceRequest $request)
    {
        /*
        $validated = $request->validate([
            'latitude' => 'numeric',
            'length' => 'numeric',
        ]); */

        $today = date("Y-m-d H:i:s");

        try {
            $LocationDevice = new LocationDevice;

            $LocationDevice->address =  $request->address;
            $LocationDevice->installation_date =  $request->installation_date;
            $LocationDevice->installation_hour =  $request->installation_hour;
            $LocationDevice->remove_date =  null;
            // $LocationDevice->remove_date =  date('Y-m-d', strtotime($today));
            $LocationDevice->remove_hour =  null;
            $LocationDevice->latitude =  $request->latitude;
            $LocationDevice->length =  $request->length;
            $LocationDevice->device_id =  $request->device_id;
            $LocationDevice->area_id =  $request->area_id;
            $LocationDevice->created_at =  $request->created_at;
            $LocationDevice->updated_at =  $request->updated_at;    
            
            $LocationDevice->save();

            Flash::success('Location Device saved successfully.');

        } catch (\Throwable $th) {
            // throw $th;
            Flash::success('Error to save Location Device');
        }

        // $input = $request->all();

        // $locationDevice = $this->locationDeviceRepository->create($input);

        // Flash::success('Location Device saved successfully.');

        return redirect(route('backend.locationDevices.index'));
    }

    /**
     * Display the specified LocationDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('backend.locationDevices.index'));
        }

        return view('backend.location_devices.show')->with('locationDevice', $locationDevice);
    }

    /**
     * Show the form for editing the specified LocationDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $devices = Device::pluck('device_code', 'id');
        $areas = Area::pluck('name', 'id');    
        $desde = "Edit";

        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('backend.locationDevices.index'));
        }


        session(['removeDate' => $locationDevice->remove_date]);  // Set, Session Variable

        return view('backend.location_devices.edit')->with(compact('locationDevice', 'devices', 'areas', 'desde'));        
        // return view('backend.location_devices.edit')->with('locationDevice', $locationDevice);
    }

    /**
     * Update the specified LocationDevice in storage.
     *
     * @param int $id
     * @param UpdateLocationDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationDeviceRequest $request)
    {
        /*
        $validated = $request->validate([
            'latitude' => 'numeric',
            'length' => 'numeric',
        ]); */

        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('backend.locationDevices.index'));
        }

        $locationDevice->address =  $request->address;      
        $locationDevice->installation_date =  $request->installation_date;
        $locationDevice->installation_hour =  $request->installation_hour;
        
        
        if($request->remove_date == null){
            $locationDevice->remove_date =  session('removeDate');  // Get, Session Variable)
        } else {
            $locationDevice->remove_date =  $request->remove_date;           
        }
        $locationDevice->remove_hour = null; 
        $locationDevice->latitude =  $request->latitude;
        $locationDevice->length =  $request->length;
        $locationDevice->device_id =  $request->device_id;
        $locationDevice->area_id =  $request->area_id;
        $locationDevice->created_at =  $request->created_at;
        $locationDevice->updated_at =  $request->updated_at;

        $locationDevice->save();

        // $locationDevice = $this->locationDeviceRepository->update($request->all(), $id);

        Flash::success('Location Device updated successfully.');

        return redirect(route('backend.locationDevices.index'));
    }

    /**
     * Remove the specified LocationDevice from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            Flash::error('Location Device not found');

            return redirect(route('backend.locationDevices.index'));
        }

        $this->locationDeviceRepository->delete($id);

        Flash::success('Location Device deleted successfully.');

        return redirect(route('backend.locationDevices.index'));
    }
}
