<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateType_variableRequest;
use App\Http\Requests\Backend\UpdateType_variableRequest;
use App\Repositories\Backend\Type_variableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Backend\Type_variable;

class Type_variableController extends AppBaseController
{
    /** @var  Type_variableRepository */
    private $typeVariableRepository;

    public function __construct(Type_variableRepository $typeVariableRepo)
    {
        $this->typeVariableRepository = $typeVariableRepo;
    }

    /**
     * Display a listing of the Type_variable.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $typeVariables = $this->typeVariableRepository->all();

        return view('backend.type_variables.index')
            ->with('typeVariables', $typeVariables);
    }

    /**
     * Show the form for creating a new Type_variable.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.type_variables.create');
    }

    /**
     * Store a newly created Type_variable in storage.
     *
     * @param CreateType_variableRequest $request
     *
     * @return Response
     */
    public function store(CreateType_variableRequest $request)
    {
        $input = $request->all();

        try {
            $typeVariable = $this->typeVariableRepository->create($input);
            Flash::success('Tipo de Variable Creada con exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success('Error: already a varible type with this name or error to conect with database');
        }

        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * Display the specified Type_variable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        return view('backend.type_variables.show')->with('typeVariable', $typeVariable);
    }

    /**
     * Show the form for editing the specified Type_variable.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        return view('backend.type_variables.edit')->with('typeVariable', $typeVariable);
    }

    /**
     * Update the specified Type_variable in storage.
     *
     * @param int $id
     * @param UpdateType_variableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateType_variableRequest $request)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        try {
            $typeVariable = $this->typeVariableRepository->update($request->all(), $id);

            Flash::success('Tipo de Variable actualizada con exito.');
        } catch (\Throwable $th) {
            //throw $th;
            Flash::success('Error: already a varible type with this name or error to conect with database');            
        }

        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * Remove the specified Type_variable from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $typeVariable = $this->typeVariableRepository->find($id);

        if (empty($typeVariable)) {
            Flash::error('Type Variable not found');

            return redirect(route('admin.typeVariables.index'));
        }

        $this->typeVariableRepository->delete($id);

        Flash::success('Tipo de Variable Eliminada con exito.');

        return redirect(route('admin.typeVariables.index'));
    }

    /**
     * This méthod, get the id and name of talbe Tipo_variable.
     */
    public function getVariableType(){
        $variablesType = Type_variable::select('id', 'name')
                                        ->orderBy('id')
                                        ->get();

        // $tipoVaribles_json = json_encode($variablesType);  // de Odjeto a JSON.
        $variablesType_json = $variablesType->toJson();  // de Odjeto a JSON.

        return $variablesType_json;
    }

}
