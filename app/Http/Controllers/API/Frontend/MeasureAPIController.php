<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Models\Frontend\Measure;
use App\Repositories\Frontend\MeasureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;

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
        // $input = $request->all();

        // $measure = $this->measureRepository->create($input);

        // return $this->sendResponse($measure->toArray(), 'Measure saved successfully');

        $measures = json_decode($request);

        foreach($measures as $measure){
            if(($measure->codigo_dispositivo != null) || ($measure->codigo_dispositivo != "")){
                if(($measure->Id_registro != null) || ($measure->Id_registro != "")){
                    if(($measure->Fecha_reg != null) || ($measure->Fecha_reg != "")){
                        if(($measure->Hora_reg != null) || ($measure->Hora_reg != "")){
                            if(($measure->Dato_var1 != null) || ($measure->Dato_var1 != "")){
                                $codeDevice = $this->getIdDevice($measure->codigo_dispositivo);
                                if(isset($codeDevice)){
                                    $codeVariable = $this->getIdVariable($measure->Id_registro);
                                    if(isset($codeVariable)){
                                        if( $this->insertMeasure($codeDevice, $codeVariable, $measure->Fecha_reg, $measure->Hora_reg, $measure->Dato_var1) == 200){
                                            return $this->sendResponsegetIdDevice(200, 'Ok');                          
                                        } else {
                                            return $this->sendResponsegetIdDevice(501, 'Error de Base de Datos');
                                        }
                                    } else {
                                        return $this->sendResponse(501, 'Error: La variable ' . $measure->Id_registro . 'No es valida.');
                                    }
                                } else {
                                    return $this->sendResponse(501, 'Error: El código ' . $measure->codigo_dispositivo . 'No es valido.');
                                }
                            } else {
                                return $this->sendResponse(501, 'Error: No hay dato de la variable. ' . $measure->Id_registro);
                            }
                        } else {
                            return $this->sendResponse(501, 'Error: No hay hora de registor para la variable. ' . $measure->Id_registro);                            
                        }
                    } else {
                        return $this->sendResponse(501, 'Error: No hay fecha de registor para la variable. ' . $measure->Id_registro); 
                    }
                } else {
                    return $this->sendResponse(501, 'Error: No hay variable para el dispositivo. ' . $measure->codigo_dispositivo); 
                }
            } else {
                return $this->sendResponse(501, 'Error: No hay código de dispositivo. ' . $measure->codigo_dispositivo); 
            }
        }
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

    /**
     * This function get the id that match with the input parameter.
     */
    private function getIdDevice($codeDevice){
        $codDevice = Device::select('id')
                              ->where('device_code', $codeDevice)
                              ->get();
        return $codDevice;
    }

    /**
     * This function get the id that match with the input parameter.
     */    
    private function getIdVariable($codeVariable){
        $codVariable = DataVariable::select('id')
                              ->where('name ', $codeVariable)
                              ->get();
        return $codVariable;
    }    

    /**
     * This function insert the measere's data.
     */
    private function insertMeasure($codeDevice, $codeVariable, $recordDate, $recordHour, $variableData){
        try {
            Measure::insert([
                'date' => $recordDate,
                'hour' => $recordHour,
                'data' => $variableData,
                'device_id' => $codeDevice,
                'data_variable_id' => $codeVariable
            ]); 
        } catch (\Throwable $th) {
            return 501;
        }

        return 200;
    }
}
