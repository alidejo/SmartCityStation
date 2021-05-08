<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateVariableDeviceRequest;
use App\Http\Requests\Backend\UpdateVariableDeviceRequest;
use App\Repositories\Backend\VariableDeviceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;

class VariableDeviceController extends AppBaseController
{
    /** @var  VariableDeviceRepository */
    private $variableDeviceRepository;

    public function __construct(VariableDeviceRepository $variableDeviceRepo)
    {
        $this->variableDeviceRepository = $variableDeviceRepo;
    }

    /**
     * Display a listing of the VariableDevice.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $variableDevices = $this->variableDeviceRepository->all();

        return view('backend.variable_devices.index')
            ->with('variableDevices', $variableDevices);
    }

    /**
     * Show the form for creating a new VariableDevice.
     *
     * @return Response
     */
    public function create()
    {
        $devicies = Device::pluck('device_code', 'id');
        $variables = DataVariable::pluck('name', 'id');

        return view('backend.variable_devices.create')->with(compact('devicies', 'variables'));        
        // return view('backend.variable_devices.create');
    }

    /**
     * Store a newly created VariableDevice in storage.
     *
     * @param CreateVariableDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateVariableDeviceRequest $request)
    {
        $input = $request->all();

        $variableDevice = $this->variableDeviceRepository->create($input);

        Flash::success('Variable Device saved successfully.');

        return redirect(route('backend.variableDevices.index'));
    }

    /**
     * Display the specified VariableDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            Flash::error('Variable Device not found');

            return redirect(route('backend.variableDevices.index'));
        }

        return view('backend.variable_devices.show')->with('variableDevice', $variableDevice);
    }

    /**
     * Show the form for editing the specified VariableDevice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $devicies = Device::pluck('device_code', 'id');
        $variables = DataVariable::pluck('name', 'id');

        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            Flash::error('Variable Device not found');

            return redirect(route('backend.variableDevices.index'));
        }

        return view('backend.variable_devices.edit')->with(compact('variableDevice', 'devicies', 'variables'));          
        // return view('backend.variable_devices.edit')->with('variableDevice', $variableDevice);
    }

    /**
     * Update the specified VariableDevice in storage.
     *
     * @param int $id
     * @param UpdateVariableDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVariableDeviceRequest $request)
    {
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            Flash::error('Variable Device not found');

            return redirect(route('backend.variableDevices.index'));
        }

        $variableDevice = $this->variableDeviceRepository->update($request->all(), $id);

        Flash::success('Variable Device updated successfully.');

        return redirect(route('backend.variableDevices.index'));
    }

    /**
     * Remove the specified VariableDevice from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $variableDevice = $this->variableDeviceRepository->find($id);

        if (empty($variableDevice)) {
            Flash::error('Variable Device not found');

            return redirect(route('backend.variableDevices.index'));
        }

        $this->variableDeviceRepository->delete($id);

        Flash::success('Variable Device deleted successfully.');

        return redirect(route('backend.variableDevices.index'));
    }
}
