<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateDataVariableRequest;
use App\Http\Requests\Backend\UpdateDataVariableRequest;
use App\Repositories\Backend\DataVariableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Backend\Type_variable;
use App\Models\Backend\DataVariable;

class DataVariableController extends AppBaseController
{
    /** @var  DataVariableRepository */
    private $dataVariableRepository;

    public function __construct(DataVariableRepository $dataVariableRepo)
    {
        $this->dataVariableRepository = $dataVariableRepo;
    }

    /**
     * Display a listing of the DataVariable.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $dataVariables = $this->dataVariableRepository->all();

        return view('backend.data_variables.index')
            ->with('dataVariables', $dataVariables);
    }

    /**
     * Show the form for creating a new DataVariable.
     *
     * @return Response
     */
    public function create()
    {
        $tipyVariables = Type_variable::pluck('name', 'id');
        return view('backend.data_variables.create')->with(compact('tipyVariables'));
        // return view('backend.data_variables.create');
    }

    /**
     * Store a newly created DataVariable in storage.
     *
     * @param CreateDataVariableRequest $request
     *
     * @return Response
     */
    public function store(CreateDataVariableRequest $request)
    {
        $input = $request->all();

        try {
            $dataVariable = $this->dataVariableRepository->create($input);
            Flash::success('Datos de la Variable Guardado con Exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success('Error: already a varible with this name or error to conect with database');            
        }

        return redirect(route('admin.dataVariables.index'));
    }

    /**
     * Display the specified DataVariable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        return view('backend.data_variables.show')->with('dataVariable', $dataVariable);
    }

    /**
     * Show the form for editing the specified DataVariable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tipyVariables = Type_variable::pluck('name', 'id');

        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        return view('backend.data_variables.edit')->with(compact('dataVariable','tipyVariables'));
        // return view('backend.data_variables.edit')->with('dataVariable', $dataVariable);
    }

    /**
     * Update the specified DataVariable in storage.
     *
     * @param int $id
     * @param UpdateDataVariableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDataVariableRequest $request)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }
        
        try {
            $dataVariable = $this->dataVariableRepository->update($request->all(), $id);

            Flash::success('Datos de Variable Actualizado con Exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success('Error: already a varible with this name or error to conect with database');             
        }

        return redirect(route('admin.dataVariables.index'));
    }

    /**
     * Remove the specified DataVariable from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dataVariable = $this->dataVariableRepository->find($id);

        if (empty($dataVariable)) {
            Flash::error('Data Variable not found');

            return redirect(route('admin.dataVariables.index'));
        }

        $this->dataVariableRepository->delete($id);

        Flash::success('Datos de Variable Eliminado con Exito.');

        return redirect(route('admin.dataVariables.index'));
    }

    /**
     *  This méthod, get the variable data tha to be equeal to id of type variable.
     */
    public function getVariableData(Request $request){
        $input = $request->all();
        $variableTypeId = $input['variableTypeId']; 

        $variableData = DataVariable::select('id', 'name')
                                      ->where('type_variable_id', $variableTypeId)
                                      ->get();

        $variableData_json = $variableData->toJson();  // de Odjeto a JSON.

        return $variableData_json;        
    }
}
