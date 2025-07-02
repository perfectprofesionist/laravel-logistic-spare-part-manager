{{--
    Edit Make Page (make/edit.blade.php)
    
    This template provides a form for editing an existing car make.
    Includes a single input for the make name and a submit button.
--}}

@extends('layouts.app_new')

@section('content')
 <div class="craete-form-outer-panel">
    {{-- Page title and back button --}}
   <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
        <h2>Edit Form</h2>
        <div class="create-form-CTA auto-width"><a href="{{ route('make.index') }}" class="btn btn-secondary create-form-CTA auto-width">
            <img src="{{ asset('images') }}/back-bttn-icon.svg"> Back to make
        </a>
        </div>
    </div>

    <div class="d-flex">
        {{-- Form card --}}
        <div class="card shadow-lg w-100 makes1-card card-margin-outer create-make-name-con">
            
            {{-- Make edit form --}}
            <form action="{{ route('make.update', $make->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Make name input --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-medium">Make Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control"
                        placeholder="Enter updated make name..." 
                        value="{{ old('name', $make->name) }}" 
                        required
                    />
                    @error('name') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                {{-- Submit button --}}
                <div class="d-grid create-form-CTA">
                    <button type="submit" class="btn btn-primary">
                        Update Make
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
