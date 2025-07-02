@extends('layouts.app_new')

@section('content')
<div class="">
    <div class="craete-form-outer-panel">
        <div class="col-12 pade-none create-heading-con">
            <h2>Messages</h2>
            
        </div>
    </div>

    <!-- Success Message -->
    {{--@if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif --}}

     <div class="col-12 pade-none cont-conditions-added">
        <div class="col-12 pade-none cont-new-condition">

            @foreach ($messages as $message)
                <form action="{{ route('messages.update', $message->id) }}" method="POST" class="mb-4 border-dark p-3 rounded shadow-sm bg-dark">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="text-{{ $message->id }}" class="form-label">
                            <strong>Message ID {{ $message->id }}:</strong>
                        </label>
                        <textarea
                            name="text"
                            id="text-{{ $message->id }}"
                            class="form-control"
                            rows="3"
                        >{{ old('text', $message->text) }}</textarea>
                    </div>

                    <div class="d-flex align-items-start gap-4 save-form-bttn">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            @endforeach
            
        </div>
    </div>
</div>

    
@endsection