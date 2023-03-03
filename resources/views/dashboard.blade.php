<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">

                <div class="flex items-center justify-end">

                    <a href="{{ route('properties.create') }}" class="btn btn-primary mb-2">
                        Add Property
                    </a>
                </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <table class="table table-bordered table-responsive-lg mt-4">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Published</th>
                        <th>Images</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Edit/Delete</th>
                    </tr>
                    @foreach ($properties as $property)
                    <tr>
                        <td>{{ $property->id }}</td>
                        <td>{{ $property->name }}</td>
                        <td>{{ $property->price }}</td>
                        <td>{{ $property->bedrooms }}</td>
                        <td>{{ $property->bathrooms }}</td>
                        <td>
                            @if($property->published) Yes @else No @endif

                            <form action="{{ route('properties.togglePublished', $property->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-secondary ml-2">Toggle</button>
                            </form>
                        </td>
                        <td>@if ($property->images->count() != 0) {{ $property->images->count() }} @endif</td>
                        <td>{{ date_format($property->created_at, 'jS M Y') }}</td>
                        <td>{{ date_format($property->updated_at, 'jS M Y') }}</td>
                        <td>
                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST">
                                <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-secondary">Edit</a>

                                @csrf
                                @method('DELETE')
                                <button type="submit" title="delete" class="btn btn-sm btn-danger confirm-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>