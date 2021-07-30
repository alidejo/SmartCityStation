<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Requests\API\Backend\CreateLocationDeviceAPIRequest;
use App\Http\Requests\API\Backend\UpdateLocationDeviceAPIRequest;
use App\Models\Backend\LocationDevice;
use App\Repositories\Backend\LocationDeviceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Backend\Area;
use App\Models\Backend\Device;
use Illuminate\Support\Facades\DB;
use Response;


/**
 * Class LocationDeviceController
 * @package App\Http\Controllers\API\Backend
 */

class LocationDeviceAPIController extends AppBaseController
{
    /** @var  LocationDeviceRepository */
    private $locationDeviceRepository;
    private $codeDevice;

    public function __construct(LocationDeviceRepository $locationDeviceRepo)
    {
        $this->locationDeviceRepository = $locationDeviceRepo;
    }

    /**
     * Display a listing of the LocationDevice.
     * GET|HEAD /locationDevices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $locationDevices = $this->locationDeviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($locationDevices->toArray(), 'Location Devices retrieved successfully');
    }

    /**
     * Store a newly created LocationDevice in storage.
     * POST /locationDevices
     *
     * @param CreateLocationDeviceAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationDeviceAPIRequest $request)
    {
        $input = $request->all();

        $locationDevice = $this->locationDeviceRepository->create($input);

        return $this->sendResponse($locationDevice->toArray(), 'Location Device saved successfully');
    }

    public function locationRecord(Request $request)
    {
        // validamos si lo que traiga venga por metodo post
        if ($request->isMethod('post')) {
            // validar el json de lo que traiga
            $result =$this->validateJson($request);
            // si la validacion salio bien
            if ($result == "Ok") {
                // si se hace la insersion a la tabla sacar un 200
                if ($this->insertLocation($request) == 200) {
                    return $this->sendResponse(200, 'Ok');
                }else {
                    // de lo contrario que no se haya podido insertar
                    return $this->sendResponse(501, 'Error: Al ingresar los datos sobre la Base de Datos');
                }
            }else {
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
                    case '509':
                        return $this->sendResponse(509, $result); 
                        break;  
                    case '510':
                        return $this->sendResponse(510, $result); 
                        break;                
                }
            }
        }
    }

    private function validateJson($location)
    {
        $result = "";
        // volvemos la variable locatingData en donde estara todo los datos del json que vamos a validar
        $locatingData = $location->input();
        // ciclo que recorrera el json
        foreach ($locatingData as $key => $value) {
            // validar si esta vacio el campo CODIGO DISPOSITIVO
            if (empty($value['codigo_dispositivo'])) {
                $result = '510 Error: No hay dato en codigo_dispositivo'; 
                break;
            } else {
                // validar si esta vacio el campo  Direccion
                if (empty($value['Direccion'])) {
                    $result = '509 Error: No hay dato en Direccion. '; 
                    break;
                }else {
                     // validar si esta vacio el campo Fecha_ins
                    if (empty($value['Fecha_ins'])) {
                        $result = '508 Error: No hay dato en Fecha_ins. '; 
                        break;
                    }else {
                         // validar si esta vacio el campo Hora_ins
                        if (empty($value['Hora_ins'])) {
                            $result = '507 Error: No hay dato en Hora_ins. ';
                            break;
                        }else {
                            // validar si esta vacio el campo Latitud
                            if ((double)$value['Latitud']== 0) {
                                $result = '506 Error: No hay dato en Latitud ';
                                break;
                            }else {
                                 // validar si esta vacio el campo Longitud
                                if ((double)$value['Longitud']==0) {
                                    $result = '505 Error: No hay dato en Longitud ';
                                    break;
                                }else {
                                    // validar si esta vacio el campo Area
                                    if (empty($value['Area'])) {
                                        $result = '504 Error: No hay dato en Area ';
                                        break;
                                    }else {
                                        // definimos que nuestra variable global va ser igual la
                                        // funcion de la consulta y el reccorrido de dispositivo y que traiga el id
                                        $this->codeDevice =  $this->getIdDevice($value['codigo_dispositivo']);
                                        // si la variable global  esta definida y no es null ni cero
                                        if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                                            // definimos que nuestra variable  va ser igual a la
                                            // funcion de la consulta y el reccorrido de area y que traiga el id
                                            $idArea = $this->getIdArea($value['Area']);
                                            // si la variable  esta definida y no es null ni cero
                                            if (isset($idArea) && ($idArea > 0)) {
                                                //resultado si todas las validaciones han sido exitosas
                                                $result = "Ok";
                                            }else {
                                                // mensaje de error si en la base de datos no existe esta llave foranea con esos datos
                                                $result = '502 Error: el Area ' . $value['Area'] . ' No es valida.';
                                                break;
                                            }
                                        }else {
                                            // mensaje de error si en la base de datos no existe esta llave foranea con esos datos
                                            $result = '503 Error: El codigo_dispositivo ' . $value['codigo_dispositivo'] . ' No es valido.';
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }

    // consulta a la base de datos sobre dispositivo
    private function getIdDevice($codDevice){
        // variable que recorrera el json
        $devId = 0;
        // consulta donde el dispositivo sea igual el nombre y este activo y la fecha de eliminacion sea null
        $deviceId = Device::select('id')
                            ->where('device_code', $codDevice)
                            ->where('state', 1)
                            ->where('deleted_at',null)
                            ->get();
        // haga un conteo de la consulta si es mayoor a 0 osea que es valido el registro
        if(count($deviceId) > 0 ) {
            // ciclo para recorrer el id del dispositivo
            foreach ($deviceId as $codVar) {
                $devId = $codVar->id;
            }
        } 
        // devolver el id
        return $devId;
    }

    private function getIdArea($codArea){
        // variable que recorrera el json
        $AId = 0; 
        $areaId= Area::Select('id')
                        ->where('name',$codArea)
                        ->where('deleted_at',null)
                        ->get();
         // haga un conteo de la consulta si es mayoor a 0 osea que es valido el registro
        if (count($areaId) > 0) {
            // ciclo para recorrer el id del area
            foreach ($areaId as $codeArea) {
            $AId = $codeArea->id;
            }
        }
        // devolver el id
        return $AId;
    }

    // funcion para insertar
    private function insertLocation($inRequest){
        try {
            // traemos valores a locatingndata de inrequest
            $locatingData = $inRequest->input();
           foreach ($locatingData as $key => $value) {
                // hacemos referencia a la tabla de insersion
            $objLocation = new LocationDevice();
            // datos a ingresa
            // direccion
            $objLocation->address = $value['Direccion'];
            // fecha de instalacion
            $objLocation->installation_date = $value['Fecha_ins'];
            // hora instalacion
            $objLocation->installation_hour = $value['Hora_ins'];
            // latitud
            $objLocation->latitude = (double)$value['Latitud'];
            // longitud
            $objLocation->length = (double)$value['Longitud'];
            // dispositivo
            $objLocation->device_id = $this->codeDevice;
            // area
            $objLocation->area_id = $this->getIdArea($value['Area']);
            $objLocation->save();
           }
            
        } catch (\Throwable $th) {
            return 501;
        }
        return 200;
    }

    /**
     * 
     * 
     * Display the specified LocationDevice.
     * GET|HEAD /locationDevices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LocationDevice $locationDevice */
        $locationDevice = $this->locationDeviceRepository->find($id);

        if (empty($locationDevice)) {
            return $this->sendError('Location Device not found');
        }

        return $this->sendResponse($locationDevice->toArray(), 'Location Device retrieved successfully');
    }
    
/*------------------------------------------------------------------------------------------------------------*/
    

    public function locationUpdate(Request $request)
    {
        if ($request->isMethod('put')) {
             // validar el json de lo que traiga
            $result =$this->validateJsonRemove($request);
            if ($result == "Ok") {
                 // si se hace la insersion a la tabla sacar un 200
                $updateResult = $this->updateLocation($request);
                if ($updateResult == "200") {
                    return $this->sendResponse(200, 'Ok');
                }elseif ($updateResult == "512") {
                    return  $this->sendResponse(512, 'Error: El Dispositivo ya ha sido removido.');
                } else {
                     // de lo contrario que no se haya podido insertar
                    return $this->sendResponse(501, 'Error: Al ingresar los datos sobre la Base de Datos');
                }
            }else {
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
                    case '509':
                        return $this->sendResponse(509, $result); 
                        break;  
                    case '510':
                        return $this->sendResponse(510, $result); 
                        break;
                    case '511':
                        return $this->sendResponse(511, $result); 
                        break;                
                }
            }
        }
    }
    private function validateJsonRemove($location){
        $result="";
        $locationRules= $location->input();
        foreach ($locationRules as  $value) {
            $result=$value['codigo_dispositivo'];
                if (empty($value['codigo_dispositivo'])) {
                    $result = '510 Error: No hay dato en codigo_dispositivo'; 
                    break;
                } else {
                    if (empty($value['Fecha_ret'])) {
                        $result = '511 Error: No hay dato en Fecha_ret'; 
                        break;
                    }else {
                        $this->codeDevice =  $this->getIdDevice($value['codigo_dispositivo']);
                        if (isset($this->codeDevice) && ($this->codeDevice > 0)) {
                            $result="Ok";
                        }
                        else {
                            $result = '503 Error: El codigo_dispositivo ' . $value['codigo_dispositivo'] . ' No es valido.';
                            break;
                        }
                    }
                }
        }
        return $result;
    }
    // funcion para insertar
    private function updateLocation($inRequest){
        $iddevice= 0;
        $result = "200";
        try {
            // traemos valores a locatingndata de inrequest
                // hacemos referencia a la tabla de insersion
            $objLocation = LocationDevice::select('id')
                                        ->where('device_id',$this->codeDevice)
                                        ->whereNull('remove_date')
                                        ->get();
            if (count($objLocation) > 0) {
                foreach ($objLocation as $objloc) {
                    $iddevice = $objloc->id;
                }
                $removeDate= $inRequest->input();
                foreach ($removeDate as $value) {
                $objLocation= LocationDevice::find($iddevice);
                $objLocation->remove_date = $value['Fecha_ret'];
                $objLocation->update();
                }
            }else {
                $result = "512";
            }
            
        } catch (\Throwable $th) {
            $result = "501";
            return $result;
        }
        return $result;
    }
    

}