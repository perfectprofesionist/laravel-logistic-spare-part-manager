{{--
    Create Make Page (make/create.blade.php)
    
    This template provides a form for creating a new car make.
    Includes a single input for the make name and a submit button.
--}}

@extends('layouts.app_new')

@section('content')

 <div class="craete-form-outer-panel">
<div class="d-flex flex-column justify-content-start ">
    {{-- Page title and back button --}}
   <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
        <h2 class="fw-bold mb-0">Create New make</h2>
        <div class="create-form-CTA auto-width">
            <a href="{{ route('make.index') }}" class="btn btn-secondary">
                <img src="{{ asset('images') }}/back-bttn-icon.svg"> Back to make
            </a>
        </div>
    </div>

    <div class="d-flex">
        {{-- Form card --}}
        <div class="w-100 card shadow-lg  makes1-card create-make-name-con card-margin-outer">
            
            {{-- Make creation form --}}
            <form action="{{ route('make.store') }}" method="POST">
                @csrf

                {{-- Make name input --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-medium">Make Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control"
                        placeholder="Enter new make name..." 
                        value="{{ old('name') }}" 
                        required
                    />
                    @error('name') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                {{-- Submit button --}}
                <div class="d-grid create-form-CTA">
                    <button type="submit" class="btn btn-primary">
                        Create Make
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
