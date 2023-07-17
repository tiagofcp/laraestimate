<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Estimate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\EstimateStoreRequest;
use App\Http\Requests\EstimateUpdateRequest;

class EstimateController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $estimatesAll = Estimate::search('')->latest()->paginate();
        $estimates = Estimate::search($search)->latest()->paginate(10);
        $tags = array();

        $authors = User::find($estimatesAll->map(function ($estimate) {
        return collect($estimate->toArray())
            ->only('created_by')
            ->all();
        })->whereNotNull('created_by')->unique('created_by'))->sortBy('name');

        //dd($estimatesAll);
        $tagsEstimate = $estimatesAll->map(function ($estimate) {
            return collect($estimate->toArray())
                ->only('tags')
                ->all();
            })->whereNotNull('tags')->unique('tags');
        

        // Get tags --> Temporary solution
        foreach ($tagsEstimate as $tag){
            foreach(explode(',',$tag['tags']) as $subtag){
                
                
                if(!in_array($subtag, $tags) && !empty($subtag)){
                    

                    //Check if first character is a space
                    if($subtag[0]==' ')
                        $subtag = substr($subtag, 1);
                    
                    $tags= array_merge($tags, array($subtag));
                }           
            }
        }

        //dd($tags);

        return view('estimates.index', compact('estimates', 'search', 'authors','tags'));
        
    }

    public function create()
    {
        $setting = Setting::first();
        return view('estimates.create', compact('setting'));
    }

    public function store(EstimateStoreRequest $request)
    {
        $data = $request->all();
        //dd($data);

        if(is_null($data['currency_thousands_separator'])){
            $data['currency_thousands_separator'] = $this->debug_null();
        }
              
        $data = array_merge($data, array('created_by' => $request->user()->id, 'updated_by' => $request->user()->id));

        $estimate = Estimate::create($data);

        return redirect()
            ->route('estimates.edit', $estimate)
            ->withSuccess(trans('app.estimate_created_successfully'));
    }

    public function show(Request $request, Estimate $estimate)
    {
        $canShareEmail = true;
        
        return view('estimates.show', compact('estimate', 'canShareEmail'));
    }

    public function edit(Estimate $estimate)
    {
        return view('estimates.edit', compact('estimate'));
    }

    public function update(EstimateUpdateRequest $request, Estimate $estimate)
    {
        $data = $request->all();

        $estimate->update($data);
        $estimate->saveSectionsPositions($data['sections_positions']);

        return response()->json(true);
    }

    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        
        return redirect()->route('estimates.index')
            ->withSuccess(trans('app.deleted_successfully'));
    }

    public function duplicate(Request $request, Estimate $estimate)
    {
        $duplicated = $estimate->duplicate();
        
        return redirect()->route('estimates.edit', $duplicated);
    }


    public function fetch(Request $request){
        
        $search = $request->get('search', '');
        $authorValue = $request->get('created_by');
        //$tagValue = $request->get('tag');

        if($authorValue != ""){

            $estimates = Estimate::search($search)->where('created_by', $authorValue)->latest()->paginate(10);
            
        }
        else{
            $estimates = Estimate::search($search)->latest()->paginate(10);
        }
        

        return view('estimates.fetch', compact('estimates'))->render();
    }

    /* If variable is null, becomes empty*/
    private function debug_null(){
        
        return '';
    

    }


}
