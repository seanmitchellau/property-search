<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\PropertiesImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPropertiesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('properties.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|between:0,99999999.99',
            'bedrooms' => 'required|between:1,15',
            'bathrooms' => 'required|between:1,15',
            'images.*' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('images')) {
            $property = Properties::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));

            $images = $request->file('images');
            foreach ($images as $image) {
                $filename = $image->store('public');

                $pathParts = explode("/", $filename);
                $filename = $pathParts[count($pathParts) - 1];

                PropertiesImage::create([
                    'properties_id' => $property->id,
                    'user_id' => Auth::user()->id,
                    'filename' => $filename
                ]);
            }
        }

        return redirect()->route('properties.edit', ['property' => $property])
            ->with('success', 'Property was created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function edit(Properties $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Properties $property)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|between:0,99999999.99',
            'bedrooms' => 'required|between:1,15',
            'bathrooms' => 'required|between:1,15',
            'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $property->update($request->all());

        /** 
         * Process and remove any existing images the user wnats to remove 
         */
        $existingImages = $request->input('existing_images'); // get the remaining images from the user
        foreach ($property->images as $image) {
            if (empty($existingImages[$image->id])) { // if not present, user wants to delete
                $image->delete();
            }
        }

        /**
         * Add new images 
         */
        if ($request->hasFile('images')) {

            $images = $request->file('images');
            foreach ($images as $image) {
                $filename = $image->store('public');

                $pathParts = explode("/", $filename);
                $filename = $pathParts[count($pathParts) - 1];

                PropertiesImage::create([
                    'properties_id' => $property->id,
                    'user_id' => Auth::user()->id,
                    'filename' => $filename
                ]);
            }
        }

        return redirect()->route('properties.edit', ['property' => $property])
            ->with('success', 'The property has been updated successfully.');
    }

    /**
     * Toggle whether the Property is published or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function togglePublished(Request $request, Properties $property)
    {
        $property->published = !($property->published);
        $property->save();

        return redirect()->route('dashboard')
            ->with('success', 'The Property published status has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function destroy(Properties $property)
    {
        $property->delete();

        return redirect()->route('dashboard')
            ->with('success', 'The Property has been deleted.');
    }
}
