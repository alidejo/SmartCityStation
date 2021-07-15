<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CreateMeasureRequest;
use App\Http\Requests\Frontend\UpdateMeasureRequest;
use App\Repositories\Frontend\MeasureRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;

class MeasureController extends AppBaseController
{
    /** @var  MeasureRepository */
    private $measureRepository;

    public function __construct(MeasureRepository $measureRepo)
    {
        $this->measureRepository = $measureRepo;
    }

    /**
     * Display a listing of the Measure.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $measures = $this->measureRepository->all();

        return view('frontend.measures.index')
            ->with('measures', $measures);
    }

    /**
     * Show the form for creating a new Measure.
     *
     * @return Response
     */
    public function create()
    {
        $devices = Device::pluck('device_code', 'id');
        $dataVariables = DataVariable::pluck('name', 'id');        

        return view('frontend.measures.create')->with(compact('devices', 'dataVariables'));
        // return view('frontend.measures.create');
    }

    /**
     * Store a newly created Measure in storage.
     *
     * @param CreateMeasureRequest $request
     *
     * @return Response
     */
    public function store(CreateMeasureRequest $request)
    {
        $input = $request->all();

        $measure = $this->measureRepository->create($input);

        Flash::success('Measure saved successfully.');

        return redirect(route('frontend.measures.index'));
    }

    /**
     * Display the specified Measure.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        return view('frontend.measures.show')->with('measure', $measure);
    }

    /**
     * Show the form for editing the specified Measure.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $devices = Device::pluck('device_code', 'id');
        $dataVariables = DataVariable::pluck('name', 'id');        

        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        return view('frontend.measures.edit')->with(compact('measure', 'devices', 'dataVariables'));        
        // return view('frontend.measures.edit')->with('measure', $measure);
    }

    /**
     * Update the specified Measure in storage.
     *
     * @param int $id
     * @param UpdateMeasureRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMeasureRequest $request)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        $measure = $this->measureRepository->update($request->all(), $id);

        Flash::success('Measure updated successfully.');

        return redirect(route('frontend.measures.index'));
    }

    /**
     * Remove the specified Measure from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            Flash::error('Measure not found');

            return redirect(route('frontend.measures.index'));
        }

        $this->measureRepository->delete($id);

        Flash::success('Measure deleted successfully.');

        return redirect(route('frontend.measures.index'));
    }

    public function measureIndex(Request $request){
        return view('frontend.measures.query_measure');
    }



}
