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
use App\Models\Frontend\Measure;
use App\DTO\Collection;
use App\DTO\MeasureObject;

class MeasureController extends AppBaseController
{
    private $collectionMeasuresDate;

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

    /**
     * This main function, for get the measures data:
     */
    public function showMeasures(Request $request){

        $input = $request->all();
        $variable = $input['variable'];
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $startTime = $input['startTime'];
        $endTime = $input['endTime']; 
        
        $Measures_json = '';

        if($startDate == $endDate){
            if(($startTime == '00:00:00') && ($endTime == '00:00:00')){
                $startTime = '00:00:01';
                $endTime = '23:59:59';
            }

            $measuresDay = $this->getMeasuresDay($variable, $startDate, $startTime, $endTime);

            if(count($measuresDay) > 0){
                // $Measures_json = $measuresDay->toJson();  // de Odjeto a JSON.
                $Measures_json = json_encode($measuresDay);  // de Odjeto a JSON. 
            }       

        } else {

            $measuresDate = $this->getMeasuresDate($variable, $startDate, $endDate);

            if(count($measuresDate) > 0){
                $diffMonth = $this->diff_Month($startDate , $endDate);

                if($diffMonth == 0) {
                    $this->getAverageForDay($measuresDate);             
                } elseif(($diffMonth > 0) && ($diffMonth < 13)) {
                    $this->getAverageForMonths($measuresDate);                      
                } else {
                    $this->getAverageForYears($measuresDate);
                }
            }
        }

        if(isset($this->collectionMeasuresDate) && !empty($this->collectionMeasuresDate)){
            $measuresFinal = (array)$this->collectionMeasuresDate;
            $Measures_json = json_encode($measuresFinal);  // de Odjeto a JSON.

            $Measures_json = substr($Measures_json, 40);
            $Measures_json = substr($Measures_json, 0, -1);
        } elseif(!isset($measuresDate) && !isset($measuresDay)){
            $response = (array)[];
            $Measures_json = json_encode($response);  // de Odjeto a JSON.
        }

        return $Measures_json;        

    }


    /*
        This function take the id variable, start date, start time and end time, 
        return the collection of measures of day.
    */
    private function getMeasuresDay($idVar, $startDate, $startTime, $endTime){

        $Measures = Measure::select('date', 'hour', 'data')
                            ->where('data_variable_id', $idVar)
                            ->where('date', $startDate)
                            ->whereBetween('hour', [$startTime, $endTime])
                            ->orderBy('hour', 'asc')->get();

        return $Measures;
    }    

    /*
        This function take the id variable, start date, and end date, 
        return the collection of measures for a range dates.
    */    
    private function getMeasuresDate($idVar, $startDate, $endDate){
        $Measures = Measure::select('date', 'hour', 'data')
                            ->where('data_variable_id', $idVar)            
                            ->whereBetween('date', [$startDate, $endDate])
                            ->orderBy('date', 'asc')->get();

        return $Measures;                            
    }    

    /*
        This function take two dates and return their difference in month.
    */
    private function diff_Month($dateOne , $dateTwo){
        $diffMonth = 0;

        $ts1 = strtotime($dateOne);
        $ts2 = strtotime($dateTwo);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        if(($year2 == $year1) && ($month2 == $month1)){
            $diffMonth = (($year2 - $year1) * 12) + ($month2 - $month1);
        } elseif(($year2 == $year1) && ($month2 > $month1)){
            $diffMonth = $month2 - $month1;
        } elseif($year2 > $year1){
            $diffMonth = ($year2 - $year1) + 12; 
        }

        return $diffMonth;
    }    


    /*
        This function push the objects with the average for days.
    */
    private function getAverageForDay($measuresDate) : void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxDay = '';

        foreach($measuresDate as $measureDate){
            $components = preg_split("[-]", $measureDate->date);

            if($contData == 0){
                $auxDay = substr($components[2], 0, 2);
            } elseif(substr($components[2], 0, 2) != $auxDay){
                $average = $sumData / $contData;
                $average = number_format($average, 2);
                $average = (float)$average;

                $measure = new MeasureObject($auxDay, $average);
                $this->collectionMeasuresDate->add( $measure);

                $sumData = 0;
                $contData = 0; 
                $auxDay = substr($components[2], 0, 2);                      
            }
            $sumData += $measureDate->data;
            $contData += 1;
        }
        $average = $sumData / $contData;
        $average = number_format($average, 2);
        $average = (float)$average;      

        $measure = new MeasureObject($auxDay, $average);
        $this->collectionMeasuresDate->add( $measure);
    }

    /*
        This function push the objects with the average for months.
    */
    private function getAverageForMonths ($measuresDate) : void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxMonth = '';

        foreach($measuresDate as $measureDate){
            $components = preg_split("[-]", $measureDate->date); 

            if($contData == 0){
                $auxMonth = substr($components[1], 0, 2);

            } elseif(substr($components[1], 0, 2) != $auxMonth){
                $average = $sumData / $contData;
                $average = number_format($average, 2);
                $average = (float)$average;
                
                $measure = new MeasureObject($auxMonth, $average);
                $this->collectionMeasuresDate->add( $measure);

                $sumData = 0;
                $contData = 0; 
                $auxMonth = substr($components[1], 0, 2);                     
            }
            $sumData += $measureDate->data;
            $contData += 1;
        }
        $average = $sumData / $contData;
        $average = number_format($average, 2);
        $average = (float)$average;        

        $measure = new MeasureObject($auxMonth, $average);
        $this->collectionMeasuresDate->add( $measure);         
    }    

    /*
        This function push the objects with the average for years.
    */
    private function getAverageForYears ($measuresDate) : void
    {
        $this->collectionMeasuresDate = new Collection();

        $sumData = 0;
        $contData = 0;
        $average = 0;
        $auxYears = '';

        foreach($measuresDate as $measureDate){
            $components = preg_split("[-]", $measureDate->date);

            if($contData == 0){
                $auxYears = substr($components[0], 0, 4);

            } elseif(substr($components[0], 0, 4) != $auxYears){
                $average = $sumData / $contData;
                $average = number_format($average, 2);
                $average = (float)$average;                

                $measure = new MeasureObject($auxYears, $average);
                $this->collectionMeasuresDate->add( $measure);

                $sumData = 0;
                $contData = 0; 
                $auxYears = substr($components[0], 0, 4);                       
            }
            $sumData += $measureDate->data;
            $contData += 1;
        }
        $average = $sumData / $contData;
        $average = number_format($average, 2);
        $average = (float)$average;                

        $measure = new MeasureObject($auxYears, $average);
        $this->collectionMeasuresDate->add( $measure);     
    } 

}
