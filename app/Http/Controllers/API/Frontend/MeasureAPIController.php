<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Models\Frontend\Measure;
use App\Repositories\Frontend\MeasureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MeasureController
 * @package App\Http\Controllers\API\Frontend
 */

class MeasureAPIController extends AppBaseController
{
    /** @var  MeasureRepository */
    private $measureRepository;

    public function __construct(MeasureRepository $measureRepo)
    {
        $this->measureRepository = $measureRepo;
    }

    /**
     * Display a listing of the Measure.
     * GET|HEAD /measures
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $measures = $this->measureRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($measures->toArray(), 'Measures retrieved successfully');
    }

    /**
     * Store a newly created Measure in storage.
     * POST /measures
     *
     * @param CreateMeasureAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMeasureAPIRequest $request)
    {
        $input = $request->all();

        $measure = $this->measureRepository->create($input);

        return $this->sendResponse($measure->toArray(), 'Measure saved successfully');
    }

    /**
     * Display the specified Measure.
     * GET|HEAD /measures/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        return $this->sendResponse($measure->toArray(), 'Measure retrieved successfully');
    }

    /**
     * Update the specified Measure in storage.
     * PUT/PATCH /measures/{id}
     *
     * @param int $id
     * @param UpdateMeasureAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMeasureAPIRequest $request)
    {
        $input = $request->all();

        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        $measure = $this->measureRepository->update($input, $id);

        return $this->sendResponse($measure->toArray(), 'Measure updated successfully');
    }

    /**
     * Remove the specified Measure from storage.
     * DELETE /measures/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Measure $measure */
        $measure = $this->measureRepository->find($id);

        if (empty($measure)) {
            return $this->sendError('Measure not found');
        }

        $measure->delete();

        return $this->sendSuccess('Measure deleted successfully');
    }
}
