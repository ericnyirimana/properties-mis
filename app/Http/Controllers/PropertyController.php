<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    
    public function validation(Request $request)
    {
        $validation = [
            'county' => ['required'],
            'country' => ['required'],
            'town' => ['required'],
            'description' => ['required'],
            'address' => ['required'],
            'image_full' => ['required'],
            'num_bedrooms' => ['required', 'integer'],
            'num_bathrooms' => ['required', 'integer'],
            'media' => ['required'],
            'price' => ['required', 'integer'],
            'type' => ['required'],
            'property_type' => ['required'],
        ];

        $request->validate(
            $validation
        );

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAllProperties = Property::all();
        return view('properties.index')->with([
            'properties' => $getAllProperties,
        ]
    );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('property.part.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        try {
            DB::beginTransaction();
            //code...
            DB::commit();
        } catch (\Throwable $th) {

            DB::rollback();
            //throw $th;
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update a property info
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $this->validation($request);
        try {
            DB::beginTransaction();
            //code...
            DB::commit();
        } catch (\Throwable $th) {

            DB::rollback();
            //throw $th;
        }
    }

    /**
     * Delete one property
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        Property::where('uuid',$uuid)->delete();
        return redirect()->route('properties.index');

    }

    /**
     * Filter properties
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $field = $request->all();
        $getProperties = [];
        if($field['key_search']){
            $getProperties = Property::whereHas('property_types', function($q) use($field) {
                $q->where('title', 'like', '%' . $field['key_search'] . '%');
            })
            ->orWhere('num_bedrooms', $field['key_search'])
            ->orWhere('price',$field['key_search'])
            ->orWhere('type', 'like', '%' . $field['key_search'] . '%')
            ->get();
        }
        return view('properties.index')->with([
            'properties' => $getProperties,
        ]);

    }
}
