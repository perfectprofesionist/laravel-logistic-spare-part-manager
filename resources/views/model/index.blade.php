{{--
    File: resources/views/model/index.blade.php
    Purpose: List and manage car models. Displays all models in a table with options to add, import, export, edit, or delete. Shows model details, series, and provides pagination.
    Features:
    - Table of models with make, name, truck type, price, and series
    - Action buttons for CRUD, import/export, and template download
    - Series displayed as badges
    - Pagination and user feedback
    - CSRF and method spoofing for security
--}}

@extends('layouts.app_new')

@section('content')
<div class="product-model-outer-right product-space-right">
    <!-- Page Header and Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-3 n-main-header  create-form-heading-main">
        <div class="col-12 pade-none create-heading-con makemodelproduct-headings">
            <h2>Model</h2>
            <div class="create-form-CTA-outer">
                <!-- Download Excel template for model import -->
                <div class="n-header-buttons create-form-CTA download-temp-btn">
                    <a href="{{ asset('templates/template_model.xlsx') }}" download class="btn btn-success">Download Template Model </a>
                </div>
                <!-- Export all model data -->
                <div class="n-header-buttons create-form-CTA">
                    <a href="{{ route('model.export') }}" class="btn btn-success fw-bold rounded shadow"><i class="fas fa-file-export me-2"></i> Export Data</a>
                </div>
                <!-- Import model data from Excel/CSV -->
                <div class="n-header-buttons create-form-CTA">
                    <a href="{{ route('model.import') }}" class="btn btn-success fw-bold rounded shadow"><i class="fas fa-file-import me-2"></i> Import Data</a>
                </div>
                <!-- Add a new model -->
                <div class="n-header-buttons create-form-CTA">
                    <a href="{{ route('model.create') }}" class="btn btn-primary"><img src="{{ asset('images') }}/plus-icon.png"> Add New model</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Models Table Card -->
    <div class="card shadow-sm n-card product-space-right">
        <div class="card-body">
            <!-- Makes Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr class="text-start">
                            <!-- <th>#</th> -->
                            <th>Make</th> <!-- Car make -->
                            <th>Model Name</th> <!-- Model name -->
                            <th>Truck Type</th> <!-- Truck type -->
                            <th>Model price</th> <!-- Model price -->
                            <th>Series</th> <!-- Series/years as badges -->
                            <th>Actions</th> <!-- Edit/Delete actions -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($model as $index => $item)
                            <tr class="text-start">
                                <!-- <td>{{ $index + 1 }}</td> -->
                                <td>{{ $item->make->name}}</td>
                                <td>{{ $item->model_name }}</td>
                                <td>{{ $item->truck_type ?? 'N/A' }}</td>
                                <td>${{ $item->price }}</td>
                                <td style="width: 28%;">
                                    @php
                                        // Split years/series into array for badge display
                                        $years = isset($item->years) && !empty($item->years) ? explode(',', $item->years) : [];
                                    @endphp
                                    @if(count($years) > 0)
                                        <div class="d-flex flex-wrap">
                                            @foreach($years as $key => $year)
                                                @if(!empty(trim($year)))  {{-- Ensure no empty badges --}}
                                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1 me-1 mb-1" style="font-size: 15px; min-width: 60px; text-align: left; width:100%">
                                                        {{ $year }}
                                                    </span>
                                                    @if(($key + 1) % 4 == 0) 
                                                        </div><div class="d-flex flex-wrap"> 
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- No series/years available -->
                                    @endif
                                </td>

                                <td style="width:25%;">
                                    <!-- Edit model button -->
                                    <a href="{{ route('model.edit', $item->id) }}" class="btn btn-sm btn-info product-action-icons"><img src="{{ asset('images') }}/edit-icon.svg"></a>
                                    <!-- Delete model form/button (with CSRF and method spoofing) -->
                                    <form action="{{ route('model.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger deleteButton product-action-icons"><img src="{{ asset('images') }}/trash-icon.svg"></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No model found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $model->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
