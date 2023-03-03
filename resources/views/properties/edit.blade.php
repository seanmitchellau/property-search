<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Property') }} - #{{ $property->id }} - @if(!$property->published) Not @endif Published
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">

                @if ($property->images->count() == 0)
                <div class="alert alert-warning">
                    <strong>Note:</strong> This Property has no images, and won't be shown in the front end.
                    <br/><br/>Please add at least one image.
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error: There were some issues with the form.</strong>
                    <br /><br />
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Published</strong><br />
                                <input type="checkbox" name="published" value="1" @if($property->published) checked @endif/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name</strong>
                                <input type="text" name="name" class="form-control" value="{{ $property->name }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Price ($)</strong>
                                <input type="number" name="price" min="0" class="form-control" value="{{ $property->price }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Description</strong>
                                <textarea class="form-control" rows="4" name="description" required>{{ $property->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Bedrooms</strong>
                                <input type="number" name="bedrooms" min="0" max="15" class="form-control" value="{{ $property->bedrooms }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Bathrooms</strong>
                                <input type="number" name="bathrooms" min="0" max="15" class="form-control" value="{{ $property->bathrooms }}" required />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Add Images</strong>
                                <input type="file" class="form-control" name="images[]" multiple />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Current Images (click to delete)</strong>
                                <div class="row">
                                    @foreach ($property->images as $image)
                                    <div class="col-sm-12 col-lg-2 property-image">
                                        <input type="hidden" name="existing_images[{{ $image->id }}]" value="1" />
                                        <img src="{{ asset('storage/'.$image->filename) }}" class="img-responsive" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary mr-4">Update</button>
                            <a href="{{ route('dashboard') }}">Cancel</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>