@extends('layouts.app_new')

@section('content')
    <div class="craete-form-outer-panel">
        <div class="d-flex justify-content-between align-items-center mb-3 create-heading-con addnewproduct-headings">
            <h2 class="fw-bold text-white">Edit Product</h2>
            <div class="create-form-CTA auto-width"><a href="{{ route('products.index') }}" class="btn btn-secondary create-form-CTA auto-width">
                <img src="{{ asset('images') }}/back-bttn-icon.svg"> Back to Products
            </a></div>
        </div>

        <div class="card shadow products-card product-edit-card-main" >
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <!-- Product Name & Price -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-medium">Product Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                                    required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                           
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Price</label>
                                <input type="number" name="price" class="form-control"
                                    value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Product Type</label>
                                    <div class="d-flex gap-3">
                                        @foreach (['internal', 'external'] as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="internal_external"
                                                    value="{{ $option }}"
                                                    {{ old('internal_external', $product->internal_external) === $option ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ ucfirst($option) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('internal_external')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                           
                        </div>

                        


                        <div class="row">
                            <div class="col-md-4">
                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Quantity</label>
                                    <input type="text" name="quantity" class="form-control"
                                        value="{{ old('quantity', $product->quantity) }}" min="0" required>
                                    @error('quantity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Length Units -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Length Units</label>
                                    <input type="text" name="length_units" class="form-control"
                                        value="{{ old('length_units', $product->length_units) }}" min="0" >
                                    @error('length_units')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Fitment Time</label>
                                    <input type="text" name="fitment_time" class="form-control"
                                        value="{{ old('fitment_time', $product->fitment_time) }}" min="0" required>
                                    @error('fitment_time')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Width, Length, Height -->
                        <div class="row mb-3">
                            @foreach (['width', 'length', 'height'] as $field)
                                <div class="col-md-4">
                                    <label class="form-label fw-medium">{{ ucfirst($field) }}</label>
                                    <input type="number" name="{{ $field }}" class="form-control"
                                        value="{{ old($field, $product->$field) }}">
                                    @error($field)
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                <label>Depends on products:</label>
                                <input type="text" id="depends_on_products" name="depends_on_products" value="{{ old('price', $product->depends_on_products) }}" class="form-control" />
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="col-md-4">
  
                        <div class="mb-3">
                            <label class="form-label fw-medium">Product Image</label>
                            <div class="position-relative">
                                <input type="file" name="image" class="form-control" id="image">
                                @if ($product->image)
                                    <div class="mt-2" id="imagePreview" style="">
                                        <img src="{{ asset($product->image) }}"
                                            style="width: 100%; height: 100%; object-fit: cover;" class="mt-2">
                                    </div>
                                @else
                                    <div class="mt-2" id="imageMessage"
                                        style="">
                                        <small class="text-muted">Select an image</small>
                                    </div>
                                @endif
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                

                <!-- Product Type -->
                

               
                

             


               

                <!-- Submit Button -->
                 <div class="d-grid create-form-CTA mt-5 ">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>



            <div class="d-grid create-form-CTA mt-5 ">
            <button type="button" class="btn product-relation-edit-btn" data-bs-toggle="modal" data-bs-target="#product_relation">
                Add Combination
            </button>
            </div>
            <table class="table table-bordered table-dark mt-5">
                <thead>
                    <tr><th>Products</th><th>Max Allowed</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($productRules as $productRule)
                        <tr>
                            <td>
                                <div class="product-outer-custom">
                                    @foreach ( $allProducts as $selectedProduct )

                                    
                                            @if(in_array($selectedProduct["value"],$productRule->allowed_products))
                                                <div class="product-inner-custom">
                                                    <img src="{{ $selectedProduct["image"] }}" alt="..." class="img-thumbnail-custom" style="">
                                                    <p>{{ $selectedProduct["text"] }}</p>
                                                </div>
                                            @endif
                                    

                                    
                                
                                        
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ $productRule->max_total }}</td>
                            <td>
                                <button type="button" class="btn btn-link text-white product-relation-edit-btn" data-bs-toggle="modal" data-bs-target="#product_relation_{{$productRule->id}}">
                                    Edit
                                </button> | <button type="button" class="btn btn-link text-white product-relation-delete-btn" data-id="{{ $productRule->id }}" >
                                    Delete
                                </button> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           
            @foreach($productRules as $productRule)

                <!-- Modal -->
                <div class="modal fade" id="product_relation_{{$productRule->id}}" tabindex="-1" aria-labelledby="product_relation_{{$productRule->id}}_label" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="product_relation_{{$productRule->id}}_label">Edit Combination</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                <form action="{{ route('products.updateRelation') }}" method="POST" id="updateProductForm_{{$productRule->id}}">

                                    @csrf
                                     <div class="row">
                                        <div class="col-md-12">
                                                <label for="" class="">List of Products</label>
                                                <div class="form-group relation-product-group">
                                                    @foreach ( $allProducts as $selectedProduct )
                                                        <div class="inner-relation-product-group">
                                                             <input type="checkbox" value="{{$selectedProduct["value"]}}" class="form-check-input" name="allowed_products[]" id="allowed_products__{{$productRule->id}}_{{$selectedProduct["value"]}}"
                                                        
                                                                @if(in_array($selectedProduct["value"],$productRule->allowed_products))
                                                                    checked
                                                                @endif

                                                                @if($selectedProduct["value"] == $product->id)
                                                                    onclick="return false;"
                                                                @endif
                                                            > {{$selectedProduct["text"]}}
                                                        </div>
                                                       
                                                    @endforeach
                                                </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="max_total" class="">Max Total</label>
                                            <input type="text" name="max_total" class="form-control" id="max_total_{{$productRule->id}}" value="{{$productRule->max_total }}">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="max_total" class="">Message</label>
                                            <textarea name="message" class="form-control" id="message_{{ $productRule->id }}" cols="30" rows="4">{{$productRule->message}}</textarea>
                                            
                                        </div>
                                    </div>


                                    
                                    <input type="hidden" name="id" class="form-control" id="id_{{$productRule->id}}" value="{{$productRule->id }}">
                                    <div class=" d-grid create-form-CTA mt-3">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <div class="show-message-{{ $productRule->id }}"></div>
                                    </div>

                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

            @endforeach

            


            <!-- Modal -->
                <div class="modal fade" id="product_relation" tabindex="-1" aria-labelledby="product_relation_label" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="product_relation_label">Add Combination </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                               
                                <form action="{{ route('products.storeRelation') }}" method="POST" id="storeRelationForm">

                                    @csrf
                                     <div class="row">
                                        <div class="col-md-12">
                                                <label for="" class="">List of Products</label>
                                                <div class="form-group relation-product-group">
                                                    @foreach ( $allProducts as $selectedProduct )
                                                        <div class="inner-relation-product-group">
                                                             <input type="checkbox" value="{{$selectedProduct["value"]}}" class="form-check-input" name="allowed_products[]" id="allowed_products_{{$selectedProduct["value"]}}"
                                                        
                                                                

                                                                @if($selectedProduct["value"] == $product->id)
                                                                    checked
                                                                    onclick="return false;"
                                                                @endif
                                                            > {{$selectedProduct["text"]}}
                                                        </div>
                                                       
                                                    @endforeach
                                                </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="max_total" class="">Max Total</label>
                                            <input type="text" name="max_total" class="form-control" id="max_total" value="">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="max_total" class="">Message</label>
                                            <textarea name="message" class="form-control" id="message" cols="30" rows="4"></textarea>
                                            
                                        </div>
                                    </div>


                                    
                                    <div class=" d-grid create-form-CTA mt-3">
                                        <button type="submit" class="btn btn-primary">Save Combination</button>
                                        <div class="show-message"></div>
                                    </div>

                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>


        </div>
    </div>

@endsection
@section("customScript")
    

    <script>
        // Show the selected image below the input field using jQuery
        $('#image').on('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#imagePreview').html('<img src="' + reader.result +
                    '" style="width: 100%; height: 100%; object-fit: cover;" class="mt-2">');
            };

            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
                $('#imageMessage').hide(); // Hide the message if an image is selected
            } else {
                $('#imagePreview').html(''); // Hide the preview if no file is selected
                $('#imageMessage').show(); // Show the message
            }
        });

        @php 
        
            $allProductsSearchArray = array_values(array_filter($allProducts, function($item) use ($product) {
                return $item['value'] !== $product->id;
            }));

        
        @endphp

        var items = @json( $allProductsSearchArray);

       

       var task = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: items
        });

        task.initialize();

        var elt = $("#depends_on_products");

        elt.tagsinput({
            itemValue: "value",
            itemText: "text",
            typeaheadjs: {
                name: "task",
                displayKey: "text",
                source: function(query, syncResults) {
                    var selected = elt.tagsinput('items').map(item => item.value);
                    var filteredItems = items.filter(item => !selected.includes(item.value));

                    var filteredTask = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: filteredItems
                    });

                    filteredTask.initialize();
                    filteredTask.search(query, syncResults);
                },
                templates: {
                    suggestion: function(item) {
                        return `
                            <div class="tt-suggestion">
                                <img src="${item.image}" alt="" style="height:20px; margin-right:5px;" />
                                ${item.text}
                            </div>`;
                    }
                }
            }
        });

        // Override tag rendering to include image
        elt.on('itemAdded', function(event) {
            var $tag = elt.siblings('.bootstrap-tagsinput').find('.tag:contains("' + event.item.text + '")');
            var item = items.find(i => i.value == event.item.value);
            if (item) {
                $tag.html(`<img src="${item.image}" style="height:16px; margin-right:5px;" />${item.text} <span data-role="remove"></span>`);
            }
        });

        // Auto-select values from input value
        $(document).ready(function () {
            var initialValues = elt.val().split(','); // e.g. ['1', '6']
            initialValues.forEach(function(val) {
                var matched = items.find(i => i.value == val.trim());
                if (matched) {
                    elt.tagsinput('add', matched);
                }
            });
        });


        @foreach($productRules as $productRule)

        $('#updateProductForm_{{ $productRule->id }}').on('submit', function(e) {
             var $this = $(this);
            e.preventDefault();
           
            $.ajax({
                url: '{{ route('products.updateRelation') }}',
                method: 'POST',
                data: $(this).serialize(), // Serializes the form data
                success: function(response) {
                    console.log('Success:', response);
                        $('.show-message-{{ $productRule->id }}').text(response.message).addClass('text-success');
                    setTimeout(() => {
                        $('.show-message-{{ $productRule->id }}').removeClass('text-success').text('');
                        $('#product_relation_{{ $productRule->id }}').find('.btn-close').trigger('click');
                    }, 1500);
                    
                },
                error: function(xhr) {
                    try {
                        var json = JSON.parse(xhr.responseText);
                        console.log(json.errors.message);

                        var errorHtml = '<ul>';

                        $.each(json.errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });

                        errorHtml += '</ul>';

                        $('.show-message-{{ $productRule->id }}').html(errorHtml).addClass('text-danger');


                        //$('.show-message-{{ $productRule->id }}').text(json.errors.message).addClass('text-danger');
                        setTimeout(() => {
                            $('.show-message-{{ $productRule->id }}').removeClass('text-danger').text('');
                             
                        }, 3000);
                    } catch (e) {
                        console.error("Invalid JSON:", xhr.responseText);
                    }

                    
                    
                    
                }
            });
        });

        @endforeach

        $('#storeRelationForm').on('submit', function(e) {
             var $this = $(this);
            e.preventDefault();
           
            $.ajax({
                url: '{{ route('products.storeRelation') }}',
                method: 'POST',
                data: $(this).serialize(), // Serializes the form data
                success: function(response) {
                    console.log('Success:', response);
                        $('.show-message').text(response.message).addClass('text-success');
                    setTimeout(() => {
                        $('.show-message').removeClass('text-success').text('');
                        $('#product_relation').find('.btn-close').trigger('click');
                    }, 1500);
                    
                },
                error: function(xhr) {
                    try {
                        var json = JSON.parse(xhr.responseText);
                        console.log(json.errors.message);

                        var errorHtml = '<ul>';

                        $.each(json.errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                errorHtml += '<li>' + message + '</li>';
                            });
                        });

                        errorHtml += '</ul>';

                        $('.show-message').html(errorHtml).addClass('text-danger');


                        //$('.show-message').text(json.errors.message).addClass('text-danger');
                        setTimeout(() => {
                            $('.show-message').removeClass('text-danger').text('');
                        }, 3000);
                    } catch (e) {
                        console.error("Invalid JSON:", xhr.responseText);
                    }

                    
                    
                    
                }
            });
        });
        

        $(document).on('click', '.product-relation-delete-btn', function() {
            var ruleId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this rule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("products.deleteRelation", ":id") }}'.replace(':id', ruleId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Optional: reload the page after deletion
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Delete failed',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });


    </script>
@endsection
