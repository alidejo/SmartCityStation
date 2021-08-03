<?php

namespace App\Http\Controllers\API\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Requests\API\Frontend\CreateMeasureAPIRequest;
use App\Http\Requests\API\Frontend\UpdateMeasureAPIRequest;
use App\Models\Frontend\Measure;
use App\Repositories\Frontend\MeasureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Mail\sendEmail as MailSendEmail;
use App\Mail\sendEmail2;
use App\Mail\sendEmailNew;
use Response;
use App\Models\Backend\Device;
use App\Models\Backend\DataVariable;
use App\Notifications\sendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class MeasureController
 * @package App\Http\Controllers\API\Frontend
 */

class MeasureAPIController extends AppBaseController
{
    /** @var  MeasureRepository */
    private $measureRepository;

    private $codeDevice;
    private $measuresAlerts = array(array());

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

/**
 * This function save a json of the measures for minutes.
 */
    public function measureRecord(Request $request){ 
        if($request->isMethod('post')){
            $result = $this->validateJson($request);
            if($result == "Ok"){
                if( $this->insertMeasure($request) == 200) {
                //    if there date in the global variable elder a 1 (should be elder 1 for array initial in 0)
                    if(sizeof($this->measuresAlerts) > 1){
                        // function send email
                        $this->userEmail();
                    }
                    return $this->sendResponse(200, 'Ok');                      
                } else {
                    return $this->sendResponse(501, 'Error: Al ingresar los datos sobre la Base de Datos');
                }
            } else {
                $reply = substr($result, 0, 3);
                switch ($reply) {
                    case '502':
                        return $this->sendResponse(502, $result);    
                        break;
                    case '503':
                        return $this->sendResponse(503, $result); 
                        break; 
                    case '504':
                        return $this->sendResponse(504, $result); 
                        break;     
                    case '505':
                        return $this->sendResponse(505, $result); 
                        break;      
                    case '506':
                        return $this->sendResponse(506, $result); 
                        break;                                                                                       
                    case '507':
                        return $this->sendResponse(507, $result); 
                        break;   
                    case '508':
                        return $this->sendResponse(508, $result); 
                        break;            
                }
            }
        }
    }

    /**
     * This functión valide the información send in the json.
     */
    private function validateJson($Measures){
        $result = "";
        
        $measuringData = $Measures->input();
        foreach($measuringData as $value){
           if(empty($value['codigo_dispositivo'])){
                $result = '508 Error: No hay dato en codigo_dispositivo'; 
                break;
            } else {
                if(empty($value['Id_registro'])){
                    $result = '507 Error: No hay dato en Id_registro. '; 
                    break;
                } else {
                    if(empty($value['Fecha_reg'])){
                        $result = '506 Error: No hay dato en Fecha_reg. '; 
                        break;
                    } else {
                        if(empty($value['Hora_reg'])){
                            $result = '505 Error: No hay dato en Hora_reg. ';
                            break;
                        } else {
                            if((double)$value['Dato_var1'] == 0){ 
                                $result = '504 Error: No hay dato en Dato_var1. ';
                                break;
                            } else {
                                $this->codeDevice = $this->getIdDevice($value['codigo_dispositivo']);
                                if(isset($this->codeDevice) && ($this->codeDevice > 0)){
                                    $codeVariable = $this->getIdVariable($value['Id_registro']);
                                    if(isset($codeVariable) && ( $codeVariable > 0)){
                                        $result = "Ok";
                                        // call function lookinforalert for send the valor by defect of what it brings this json.
                                        $this->lookinForAlert($value['codigo_dispositivo'],$value['Fecha_reg'],$value['Hora_reg'],$value['Id_registro'],$value['Dato_var1']);
                                    
                                    } else {
                                        $result = '502 Error: el Id_registro ' . $value['Id_registro'] . ' No es valida.';
                                        break;
                                    }
                                } else {
                                    $result = '503 Error: El codigo_dispositivo ' . $value['codigo_dispositivo'] . ' No es valido.';
                                    break;
                                }
                            }
                        }
                        
                    }
                }
            }
        }  
        return $result; 
    }

    /**
     * This function get the id that match with the input parameter.
     */
    private function getIdDevice($codDevice){
        $devId = 0;
        $deviceId = Device::select('id')
                            ->where('device_code', $codDevice)
                            ->where('state', 1)
                            ->get();

        if(count($deviceId) > 0 ) {
            foreach ($deviceId as $codVar) {
                $devId = $codVar->id;
            }
        } 
        return $devId;
    }

    /**
     * This function get the id that match with the input parameter.
     */    
    private function getIdVariable($codVariable){
        $varId = 0;
        $variableId = DataVariable::select('id')
                            ->where('name', $codVariable)
                            ->get();

        if(count($variableId) > 0 ) {
            foreach ($variableId as $vbleId) {
                $varId = $vbleId->id;
            }
        }
        return $varId; 
    }    

    /**
     * this function get the alert with respective variables, make push array a global variables , response void this function
     */
    private function lookinForAlert($deviceCode, $date, $hour, $variable, $data) : void {
        $alertVar = 0;
        $alertVariable = DataVariable::select('alert_threshold')
                                    ->where('name', $variable)
                                    ->where('alert_threshold', '<' , $data)
                                    ->get();

        if(count($alertVariable) > 0 ) {
            foreach ($alertVariable as $alert) {

                $alertVar = $alert->alert_threshold;
                $diff = $data - $alertVar;  
                array_push($this->measuresAlerts, array($deviceCode, $date, $hour,$variable, $data, $alertVar,$diff));
                
            }
        }
    }

    /**
     * this function send email towards the mailabler sendEmailNew.php, send global variable 
     */

    private function userEmail()
    {
        $userEmail = User::select('email')
                        ->where('type','admin')
                        ->first();
        
        Mail::to($userEmail)->send(new sendEmailNew($this->measuresAlerts));
    }
    
    /**
     * This function insert the measere's data.
     */
    private function insertMeasure($inRequest){
        try {
            $measuringData = $inRequest->input();
            foreach($measuringData as $value){
                $objMeasure = new Measure();
                $objMeasure->date = $value['Fecha_reg'];
                $objMeasure->hour = $value['Hora_reg'];           
                $objMeasure->data = (double)$value['Dato_var1'];   
                $objMeasure->device_id = $this->codeDevice; 
                $objMeasure->data_variable_id = $this->getIdVariable($value['Id_registro']);    
                $objMeasure->save();                      
            }
        } catch (\Throwable $th) {
            return 501;
        }

        return 200;
    }
}
