<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateType_variableRequest;
use App\Http\Requests\Backend\UpdateType_variableRequest;
use App\Repositories\Backend\Type_variableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

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

        $typeVariable = $this->typeVariableRepository->create($input);

        Flash::success('Type Variable saved successfully.');

        return redirect(route('backend.typeVariables.index'));
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

            return redirect(route('backend.typeVariables.index'));
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

            return redirect(route('backend.typeVariables.index'));
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

            return redirect(route('backend.typeVariables.index'));
        }

        $typeVariable = $this->typeVariableRepository->update($request->all(), $id);

        Flash::success('Type Variable updated successfully.');

        return redirect(route('backend.typeVariables.index'));
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

            return redirect(route('backend.typeVariables.index'));
        }

        $this->typeVariableRepository->delete($id);

        Flash::success('Type Variable deleted successfully.');

        return redirect(route('backend.typeVariables.index'));
    }
}
