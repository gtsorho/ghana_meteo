<?php

namespace App\Http\Controllers;

use App\Models\weatherdata;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\weatherdataimport;
use App\Exports\weatherDataExport;
use Carbon\Carbon;


class weatherdetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(weatherdata::all(), 200);
    }



    public function search($location)
    {
        // return weatherdata::where('location', 'like', '%'.$location.'%')->orderByDesc('datentime')->limit(1)->first()['datentime'];
        // $today = Carbon::today();
        // return $today->toDateString();
        // return  weatherdata::where('location', 'like', '%'.$location.'%')->whereDate('datentime',$today->toDateString())->get();



        for ($x = 0; $x <= 6; $x++) {
            $today = Carbon::today();
            if(!weatherdata::where('location', 'like', '%'.$location.'%')->whereDate('datentime',$today->toDateString())->exists()){
                $today = weatherdata::where('location', 'like', '%'.$location.'%')->orderByDesc('datentime')->limit(1)->first()['datentime']; 
                $today = new Carbon($today); 
            }
            $date = $today->subDay($x)->toDateString();
            $arr[] = weatherdata::where('location', 'like', '%'.$location.'%')->whereDate('datentime',$date)->get();
        }
        // dd(sizeof( $arr[0]));
        foreach ($arr as $key => $value) {
            if(sizeof($value) == 0){
                unset($arr[$key]);
            }
        }
        return response()->json($arr, 200);
    }



    public function searchlocation($location = null)
    {   
        $data = weatherdata::where('location', 'like', '%'.$location.'%')->select('location')->groupBy('location')->get();
        return response()->json($data, 200);
    }

    public function adminsearch(Request $request)
    {   
        // dd(gettype($request->date));

        if(gettype($request->date) == 'array') {
            $from = date($request->date[0]);
            $to = date($request->date[1]);

            if($request->has('location') && $request->has('date')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->whereBetween('datentime', [$from, $to])->latest()->paginate(13);
            }elseif($request->has('date')){
                $data = weatherdata::whereBetween('datentime', [$from, $to])->latest()->paginate(13);
            }elseif($request->has('location')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->latest()->paginate(13);
            }
        }elseif (gettype($request->date) == 'string' || gettype($request->date) == 'NULL') {
            if($request->has('location') && $request->has('date')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->whereDate('datentime', 'like', '%'.$request->date.'%')->latest()->paginate(13);
            }elseif($request->has('date')){
                $data = weatherdata:: whereDate('datentime', 'like', '%'.$request->date.'%')->latest()->paginate(13);
            }elseif($request->has('location')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->latest()->paginate(13);
            }
        }
        return response()->json($data, 200);
    }  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request);
        $fields = $request->validate([
            'location' => 'required|string',
            'temperature' => 'required|string',
            'weather' => 'required|string',
            'datentime'=> 'required|date',
            'timeofday'=> 'required|string'
        ]);
        $data = weatherdata::create([
            'location' => $fields['location'],
            'temperature' => $fields['temperature'],
            'weather' => $fields['weather'],
            'datentime' => $fields['datentime'],
            'timeofday'=> $fields['timeofday'],
        ]);
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'location' => 'nullable|string',
            'temperature' => 'nullable|string',
            'weather' => 'nullable|string',
            'datentime'=> 'nullable|date',
            'timeofday'=> 'nullable|string'
        ]);

        $update = weatherdata::where('id', $id)->update($fields);
        if($update){
            $data = weatherdata::where('id', $id)->first();
        };
            return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = weatherdata::where('id',$id)->delete();
        return $data;
    }

    public function fileImport(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls,csv',
        ]);
    
        $path = $request->file('file');
    
        Excel::import(new weatherdataimport, $path);     
        return  response()->json('Records Imported Successfully', 200);
    }

    public function fileExport(request $request) 
    {
        if(gettype($request->date) == 'array') {
            $from = date($request->date[0]);
            $to = date($request->date[1]);

            if($request->has('location') && $request->has('date')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->whereBetween('datentime', [$from, $to])->latest()->get();
            }elseif($request->has('date')){
                $data = weatherdata::whereBetween('datentime', [$from, $to])->latest()->get();
            }elseif($request->has('location')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->latest()->get();
            }
        }elseif (gettype($request->date) == 'string' || gettype($request->date) == 'NULL') {
            if($request->has('location') && $request->has('date')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->whereDate('datentime', 'like', '%'.$request->date.'%')->latest()->get();
            }elseif($request->has('date')){
                $data = weatherdata:: whereDate('datentime', 'like', '%'.$request->date.'%')->latest()->get();
            }elseif($request->has('location')){
                $data = weatherdata::where('location', 'like', '%'.$request->location.'%')->latest()->get();
            }
        }
        // return response()->json($data, 200);
        // dd($data);->store
        // return Excel::download(new weatherDataExport($data), 'weather-collection.xlsx');
        return (new weatherDataExport($data))->download('weather-collection.xlsx');
    }    
}
