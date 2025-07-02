<!DOCTYPE html>
<html>

<head>
    <title>Spare Parts Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



    <link rel="stylesheet" href="{{ asset('css/style2.css') }}?ver={{ time() }}">


    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '290733187388983');
      fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" style="display:none" 
           src="https://www.facebook.com/tr?id=290733187388983&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body>
    @php
        use Illuminate\Support\Str;
    @endphp


    <header class="tus-calc-header-outer">
        <div class="container">
            <div class="row">
                <img src="{{ asset('images/site-logo.png') }}" alt="Logo" class="desktop-logo">
                <img src="{{ asset('images/site-logo.png') }}" alt="Logo" class="mobile-logo">
            </div>
        </div>
    </header>
    <div class="tus-calc-form-outer">

        <form id="multiStepForm">

            <div class="container nav-container">
                <ul class="nav nav-tabs d-flex">
                    @foreach ($form->steps as $index => $step)
                        <li class="nav-item">
                            <span
                                class="nav-link {{ $index === 0 ? 'nav-link-active' : '' }}">{{ strtoupper($step['label']) }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ count($form->steps) > 0 ? (100 / count($form->steps)) . '%' : '0%' }}%;"
                        aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>


            <div class="container nav-container-mobile d-block d-md-none">
                <!-- Mobile Navigation Tabs -->
                <ul class="nav nav-tabs-mobile d-flex">
                    @if (!empty($form->steps))
                        @foreach ($form->steps as $index => $step)
                            <li class="nav-item-mobile">
                                <span class="nav-link-mobile {{ $index === 0 ? 'nav-link-active-mobile new' : '' }}">
                                    {{ strtoupper($step['label']) }}
                                </span>
                            </li>
                        @endforeach
                    @else
                        <li>No steps available.</li>
                    @endif
                </ul>

                <!-- Mobile Progress Bar -->
                <div class="progress">
                    <div class="progress-bar-mobile" role="progressbar" style="width: 4%;" aria-valuenow="4"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>

            @php
                $noOfItems = count($form->steps);
                $counter = 0;
            @endphp

            <!-- Form Steps -->
            @foreach ($form->steps as $index => $step)
                @php
                    $counter++;
                @endphp
                <div class="step {{ $step['id'] }} container steps-outer-main"
                    {{ $index === 0 ? '' : 'style="display:none;"' }}>
                    {{--<h2 class="text-center text-white mb-4">{{ $step['mainHeading'] }}</h2>
                    <p class="steps-sub-heading text-center text-white">{{ $step['subheading'] }}</p>--}}

                    @if ($step['template'] == '0')
                        <div class="row align-items-start-1 custom-row-area">
                            <div class="col-md-6 text-start">
                                <h2 class="text-white mb-4 p-0">{{ $step['mainHeading'] }}</h2>
                                <p class="steps-sub-heading text-white">{{ $step['subheading'] }}</p>
                            </div>
                            <div class="col-md-6 text-end desktopViewBtn ">
                                <!-- Top: Download PDF button -->
                                <button type="button" class="btn btn-primary  download-pdf-btn">
                                    <i class="fas fa-file-pdf"></i> Download PDF
                                </button>
                                <!-- Spacer -->
                               
                                <!-- Bottom: Print Summary button -->
                                <button type="button" class="btn btn-secondary print-summary-btn">
                                    <i class="fas fa-print"></i> Print Summary
                                </button>
                            </div>
                        </div>
                    @else
                        <h2 class="text-center text-white mb-4">{{ $step['mainHeading'] }}</h2>
                        <p class="steps-sub-heading text-center text-white">{{ $step['subheading'] }}</p>
                    @endif


                    @if ($step['template'] == 1 || $step['template'] == 2)
                        <div class="row align-items-center custom-row-area">
                            <div class="col-12 col-md-6 form-left-outer">
                                <h3>{{ $step['sideHeading'] }}</h3>
                                <div class="row new-class">

                                    @if (isset($step['fields']) && is_array($step['fields']))
                                        @foreach ($step['fields'] as $field)
                                            @php
                                                $fieldLabel = strtolower(trim($field['label'] ?? ''));
                                                $fieldType = strtolower(trim($field['type'] ?? ''));
                                            @endphp

                                            @if ($fieldType == 'select')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ ucfirst($fieldLabel) }}"
                                                        data-field-type="{{ $fieldType  }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($fieldLabel) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}
                                                        @if ($fieldLabel == 'make')
                                                            @foreach ($makes as $make)
                                                                <option value="{{ $make->name }}"
                                                                    data-title="{{ $make->name }}"
                                                                    data-id="{{ $make->id }}">
                                                                    {{ $make->name }}</option>
                                                            @endforeach

                                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}
                                                        @elseif (in_array($fieldLabel, ['model', 'series']))
                                                            <!-- Model & Year options will be populated dynamically via JS -->
                                                        @else
                                                            @php
                                                                $options = !empty($field['options'])
                                                                    ? explode("\n", $field['options'])
                                                                    : [];
                                                            @endphp

                                                            @foreach ($options as $option)
                                                                @php $optionValue = trim($option); @endphp
                                                                <option value="{{ $optionValue }}"
                                                                    {{ strtolower($optionValue) === 'no' ? 'selected' : '' }}>
                                                                    {{ ucfirst(htmlspecialchars($optionValue)) }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            @elseif ($fieldType == 'make')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $fieldLabel }}"
                                                        data-field-type="{{ $fieldLabel }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($fieldLabel) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}

                                                        @foreach ($makes as $make)
                                                            <option value="{{ $make->name }}"
                                                                data-title="{{ $make->name }}"
                                                                data-id="{{ $make->id }}">
                                                                {{ $make->name }}</option>
                                                        @endforeach

                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                    </select>
                                                </div>
                                            @elseif ($fieldType == 'model')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $fieldLabel }}"
                                                        data-field-type="{{ $fieldLabel }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($fieldLabel) }}</option>

                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                        {{-- @foreach ($models as $model)
                                                            <option value="{{ $model->model_name }}"
                                                                data-title="{{ $model->model_name }}"
                                                                data-id="{{ $model->id }}">
                                                                {{ $model->model_name }}</option>
                                                        @endforeach --}}

                                                    </select>
                                                </div>
                                            @elseif ($fieldType == 'series')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $fieldLabel }}"
                                                        data-field-type="{{ $fieldLabel }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($fieldLabel) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}

                                                        {{-- @for ($y = 2000; $y <= 2025; $y++)
                                                            <option value="{{ $y }}">{{ $y }}
                                                            </option>
                                                        @endfor --}}


                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                    </select>
                                                </div>
                                            @elseif ($fieldType == 'radio_old')
                                                <!-- <div class="form-group  mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select name="{{ $fieldLabel }}" id="{{ $field['id'] }}"
                                                        class="form-select dynamic-select">
                                                        @foreach ($field['options'] as $option)
                                                            <option value="{{ $option['text'] }}"
                                                                {{ strtolower($option['text']) === 'no' ? 'selected' : '' }}>
                                                                {{ $option['text'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> -->
                                            @elseif ($fieldType == 'radio')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <div id="{{ $field['id'] }}">
                                                        @foreach ($field['options'] as $option)
                                                            <label class="interest-option" data-value="{{ $option['text'] }}">
                                                                <input type="radio" name="{{ $field['id'] }}" value="{{ $option['label'] }}"
                                                                    {{ $option['isActive'] ? 'checked' : '' }}>
                                                                {{ $option['label'] }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif ($fieldType == 'checkbox')
                                                <div class="form-check col-md-6 mb-3 mt-3 ml-3 t1_Field">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $field['id'] }}" name="{{ $fieldLabel }}"
                                                        {{ !empty($field['checked']) && $field['checked'] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $field['id'] }}">
                                                        {!! $field['label'] !!} 
                                                    </label>
                                                </div>
                                            @elseif ($fieldType == 'text')

                                                
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <input type="text" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                </div>
                                            @elseif ($fieldType == 'email')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <input type="email" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                </div>
                                            @elseif ($fieldType == 'phone')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <input type="phone" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                </div>
                                            @elseif ($fieldType == 'textarea')
                                                <div class="form-group col-md-12 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <textarea id="{{ $field['id'] }}" class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}" ></textarea>
                                                </div>
                                            @elseif ($fieldType == 'date')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <input type="date" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $fieldLabel }}">
                                                </div>
                                            @elseif ($fieldType == 'colors')
                                                {{-- <div class="col-12 col-md-6 form-left-outer">
                                                        <h3 class="text-left text-white mb-4">Select One</h3>
                                                        <div class="row color-selction-grid-panel"> --}}
                                                @php
                                                    $colorsCounter = 0;
                                                @endphp
                                                @foreach ($field['colors'] as $color)
                                                    <!-- FIX: Loop added -->
                                                    @php
                                                        $colorsCounter++;
                                                    @endphp
                                                    <div
                                                        class="form-group col-md-6 d-flex flex-column justify-content-between color-selction-grid select-color-option">
                                                        <div
                                                            class="mb-2 d-flex justify-content-between gap-2 color-selction-label">
                                                            <label class="form-label">{{ $color['label'] }}</label>
                                                        </div>
                                                        <div class="color-selection d-flex justify-content-between gap-2 color-{{ $color['name'] }}"
                                                            data-image="{{ $color['image_url'] }}"
                                                            data-label="{{ $color['label'] }}"  data-field-label="{{ $field['label'] }}"
                                                            data-step="{{ strtolower($step['id']) }}"
                                                            id="{{ $field['id'] }}-{{ $colorsCounter }}">
                                                            <div class="color-gradient-pic">
                                                                <p class="d-none">{{ $color['label'] }}</p>
                                                            </div>
                                                            <div class="color-text">{{ $color['name'] }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{-- </div>
                                                    </div> --}}
                                            @elseif (
                                                $fieldType == 'custom_radio' ||
                                                    $fieldType == 'headboard_radio' ||
                                                    $fieldType == 'canopy_radio' ||
                                                    $fieldType == 'tray_sides_radio')
                                                @php
                                                    $fieldUniqueId = Str::uuid();
                                                    $optionCounter = 0;
                                                @endphp
                                                @foreach ($field['options'] as $option)
                                                    @php
                                                        $optionCounter++;
                                                    @endphp
                                                    <div
                                                        class="form-group col-md-6 flex-column justify-content-between headboard-outer">
                                                        <div
                                                            class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                                            <label class="form-label">{{ $option['label'] }}</label>
                                                        </div>
                                                        {{-- <pre>
                                                            @php
                                                                print_r($option);
                                                            @endphp
                                                            </pre> --}}

                                                        <div class="text-selection custom_radio_option {{ isset($field['id']) ? $field['id'] . '-options' : '' }}"
                                                            data-title="{{ isset($field['label']) ? $field['label'] : '' }}"
                                                            data-black-image="{{ isset($option['blackImage']) ? $option['blackImage'] : '' }}"
                                                            data-white-image="{{ isset($option['whiteImage']) ? $option['whiteImage'] : '' }}"
                                                            data-black-image-withheadboard="{{ isset($option['blackImage_withHeadboard']) ? $option['blackImage_withHeadboard'] : '' }}"
                                                            data-white-image-withheadboard="{{ isset($option['whiteImage_withHeadboard']) ? $option['whiteImage_withHeadboard'] : '' }}"
                                                            data-fitment-time="{{ isset($option['fitment_time']) ? $option['fitment_time'] : '' }}"
                                                            data-uid="{{ isset($fieldUniqueId) ? $fieldUniqueId : '' }}"
                                                            data-mid-sized-price="{{ isset($option['mid_sized_price']) ? $option['mid_sized_price'] : '' }}"
                                                            data-toyota-79-price="{{ isset($option['toyota_79_price']) ? $option['toyota_79_price'] : '' }}"
                                                            data-usa-truck-price="{{ isset($option['usa_truck_price']) ? $option['usa_truck_price'] : '' }}"
                                                            data-length="{{ isset($option['length']) ? $option['length'] : '' }}"
                                                            data-step="{{ isset($step['id']) ? $step['id'] : '' }}"
                                                            data-price="{{ isset($option['price']) ? $option['price'] : '' }}"
                                                            id="{{ isset($field['id']) && isset($optionCounter) ? $field['id'] . '-' . $optionCounter : '' }}">

                                                            <p class="d-none">{{ isset($option['text']) ? $option['text'] : '' }}</p>

                                                            <div class="d-flex justify-content-between gap-2">
                                                                <div class="px-2 {{ isset($step['label']) ? strtolower(trim($step['label'])) . '-text' : '' }}">
                                                                    {{ isset($option['text']) ? $option['text'] : '' }}
                                                                </div>
                                                                <div class="px-2 d-flex">+$
                                                                    <div class="{{ isset($step['label']) ? strtolower(trim($step['label'])) . '-price' : '' }} ms-1 updated_price updated_price_2"> 
                                                                        {{ isset($option['price']) ? $option['price'] : 0 }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            @if ($step['template'] == 1)
                                <div class="col-12 col-md-6 form-right-outer">
                                    <div class="form-group" id="car-image">
                                        <img src="{{ asset('images/site-logo.png') }}"
                                            alt="Vehicle" id="imagePreview-{{ strtolower(trim($step['id'])) }}">

                                    </div>
                                </div>
                            @elseif ($step['template'] == 2)
                                <div class="col-12 col-md-6 form-right-outer">
                                    <div class="form-group" id="car-image">
                                        <img src="" alt="Vehicle"
                                            id="imagePreview-{{ strtolower(trim($step['id'])) }}">
                                    </div>
                                </div>
                            @endif

                        </div>
                    @elseif ($step['template'] == 3)
                        @foreach ($step['fields'] as $field)
                            @if ($field['type'] === 'products' && strtolower($field['productType']) === 'internals')
                                <div class="row align-items-center custom-row-area slide-gap"
                                    id="{{ $field['id'] }}">
                                    <div class="internal-options-section">
                                        <div class="d-flex align-items-center">
                                            <button type="button" id="prev-bttn" class="btn btn-light mx-2 nav-btn">
                                                <img src="{{ asset('images/white-arrow-sided.png') }}"
                                                    alt="Arrow">
                                            </button>
                                            <div class="row row-cols-1 d-flex flex-nowrap internal-slider"
                                                id="product-container">

                                            </div>
                                            <button type="button" id="next-bttn" class="btn btn-light mx-2 nav-btn">
                                                <img src="{{ asset('images/white-arrow-sided.png') }}"
                                                    alt="Arrow">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($field['type'] === 'products' && strtolower($field['productType']) === 'external')
                                <div class="row align-items-center custom-row-area slide-gap"
                                    id="{{ $field['id'] }}">
                                    <div class="external-options-section">
                                        <div class="d-flex align-items-center">
                                            <button type="button" id="prev-btn-external"
                                                class="btn btn-light mx-2 nav-btn"><img
                                                    src="{{ asset('images/white-arrow-sided.png') }}"
                                                    alt="Arrow"></button>
                                            <div class="row row-cols-1 d-flex flex-nowrap internal-slider"
                                                id="external-product-container">
                                                <!-- External Products will be dynamically loaded here -->
                                            </div>
                                            <button type="button" id="next-btn-external"
                                                class="btn btn-light mx-2 nav-btn"><img
                                                    src="{{ asset('images/white-arrow-sided.png') }}"
                                                    alt="Arrow"></button>
                                        </div>
                                    </div>

                                    @foreach ($step['fields'] as $field)
                                        @if ($field['type'] === 'text' && strtolower($field['label']) === 'notice')
                                            <!-- Hidden div for Notice field -->
                                            <div class="none" style="display: none;">
                                                <div class="notice-label">{{ $field['label'] ?? '' }}</div>
                                                <div class="notice-placeholder">{{ $field['placeholder'] ?? '' }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @elseif ($field['type'] == 'select')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $field['label'] }}"
                                                        data-field-type="{{ $field['label'] }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($field['label']) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}
                                                        @if ($field['label'] == 'make')
                                                            @foreach ($makes as $make)
                                                                <option value="{{ $make->name }}"
                                                                    data-title="{{ $make->name }}"
                                                                    data-id="{{ $make->id }}">
                                                                    {{ $make->name }}</option>
                                                            @endforeach

                                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}
                                                        @elseif (in_array($field['label'], ['model', 'series']))
                                                            <!-- Model & Year options will be populated dynamically via JS -->
                                                        @else
                                                            @php
                                                                $options = !empty($field['options'])
                                                                    ? explode("\n", $field['options'])
                                                                    : [];
                                                            @endphp

                                                            @foreach ($options as $option)
                                                                @php $optionValue = trim($option); @endphp
                                                                <option value="{{ $optionValue }}"
                                                                    {{ strtolower($optionValue) === 'no' ? 'selected' : '' }}>
                                                                    {{ ucfirst(htmlspecialchars($optionValue)) }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            @elseif ($field['type'] == 'make')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $field['label'] }}"
                                                        data-field-type="{{ $field['label'] }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($field['label']) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}

                                                        @foreach ($makes as $make)
                                                            <option value="{{ $make->name }}"
                                                                data-title="{{ $make->name }}"
                                                                data-id="{{ $make->id }}">
                                                                {{ $make->name }}</option>
                                                        @endforeach

                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                    </select>
                                                </div>
                                            @elseif ($field['type'] == 'model')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $field['label'] }}"
                                                        data-field-type="{{ $field['label'] }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($field['label']) }}</option>

                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                        @foreach ($models as $model)
                                                            <option value="{{ $model->model_name }}"
                                                                data-title="{{ $model->model_name }}"
                                                                data-id="{{ $model->id }}">
                                                                {{ $model->model_name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            @elseif ($field['type'] == 'series')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                        name="{{ $field['label'] }}"
                                                        data-field-type="{{ $field['label'] }}">
                                                        <option value="" disabled selected>Select
                                                            {{ ucfirst($field['label']) }}</option>

                                                        {{-- Make Dropdown (Populated from Database) --}}

                                                        {{-- @for ($y = 2000; $y <= 2025; $y++)
                                                            <option value="{{ $y }}">{{ $y }}
                                                            </option>
                                                        @endfor --}}


                                                        {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                    </select>
                                                </div>
                                            @elseif ($field['type'] == 'radio_old')
                                                <!-- <div class="form-group  mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                    <select name="{{ $fieldLabel }}" id="{{ $field['id'] }}"
                                                        class="form-select dynamic-select">
                                                        @foreach ($field['options'] as $option)
                                                            <option value="{{ $option['text'] }}"
                                                                {{ strtolower($option['text']) === 'no' ? 'selected' : '' }}>
                                                                {{ $option['text'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> -->
                                            @elseif ($field['type'] == 'radio')
                                                <div class="form-group mb-3 col-md-6 t1_Field">
                                                    <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <div id="{{ $field['id'] }}">
                                                        @foreach ($field['options'] as $option)
                                                            <label class="interest-option" data-value="{{ $option['text'] }}">
                                                                <input type="radio" name="{{ $field['id'] }}" value="{{ $option['label'] }}"
                                                                    {{ $option['isActive'] ? 'checked' : '' }}>
                                                                {{ $option['label'] }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif ($field['type'] == 'checkbox')
                                                <div class="form-check col-md-6 mb-3 mt-3 ml-3 t1_Field">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $field['id'] }}" name="{{ $field['label'] }}"
                                                        {{ !empty($field['checked']) && $field['checked'] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $field['id'] }}">
                                                        {!! $field['label'] !!} 
                                                    </label>
                                                </div>
                                            @elseif ($field['type'] == 'text')
                                                
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <input type="text" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $field['default_value']  ?? '' }}">
                                                </div>
                                            @elseif ($field['type'] == 'email')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <input type="email" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                </div>
                                            @elseif ($field['type'] == 'phone')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <input type="phone" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                </div>
                                            @elseif ($field['type'] == 'textarea')
                                                <div class="form-group col-md-12 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <textarea id="{{ $field['id'] }}" class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" ></textarea>
                                                </div>
                                            @elseif ($field['type'] == 'date')
                                                <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                    <label for="{{ $field['id'] }}"
                                                        class="form-label">{{ ucfirst($field['label']) }}</label>
                                                    <input type="date" id="{{ $field['id'] }}"
                                                        class="form-control form-text-box" name="{{ $field['label'] }}">
                                                </div>
                                            @elseif ($field['type'] == 'colors')
                                                {{-- <div class="col-12 col-md-6 form-left-outer">
                                                        <h3 class="text-left text-white mb-4">Select One</h3>
                                                        <div class="row color-selction-grid-panel"> --}}
                                                @php
                                                    $colorsCounter = 0;
                                                @endphp
                                                @foreach ($field['colors'] as $color)
                                                    <!-- FIX: Loop added -->
                                                    @php
                                                        $colorsCounter++;
                                                    @endphp
                                                    <div
                                                        class="form-group col-md-6 d-flex flex-column justify-content-between color-selction-grid select-color-option">
                                                        <div
                                                            class="mb-2 d-flex justify-content-between gap-2 color-selction-label">
                                                            <label class="form-label">{{ $color['label'] }}</label>
                                                        </div>
                                                        <div class="color-selection d-flex justify-content-between gap-2 color-{{ $color['name'] }}"
                                                            data-image="{{ $color['image_url'] }}"
                                                            data-label="{{ $color['label'] }}"
                                                            data-step="{{ strtolower($step['id']) }}"
                                                            id="{{ $field['id'] }}-{{ $colorsCounter }}">
                                                            <div class="color-gradient-pic">
                                                                <p class="d-none">{{ $color['label'] }}</p>
                                                            </div>
                                                            <div class="color-text">{{ $color['name'] }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{-- </div>
                                                    </div> --}}
                                            @elseif (
                                                $field['type'] == 'custom_radio' ||
                                                    $field['type'] == 'headboard_radio' ||
                                                    $field['type'] == 'canopy_radio' ||
                                                    $field['type'] == 'tray_sides_radio')
                                                @php
                                                    $fieldUniqueId = Str::uuid();
                                                    $optionCounter = 0;
                                                @endphp
                                                @foreach ($field['options'] as $option)
                                                    @php
                                                        $optionCounter++;
                                                    @endphp
                                                    <div
                                                        class="form-group col-md-6 flex-column justify-content-between headboard-outer">
                                                        <div
                                                            class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                                            <label class="form-label">{{ $option['label'] }}</label>
                                                        </div>
                                                        {{-- <pre>
                                                            @php
                                                                print_r($option);
                                                            @endphp
                                                            </pre> --}}

                                                        <div class="text-selection custom_radio_option {{ $field['id'] }}-options"
                                                            data-title="{{ $field['label'] }}"
                                                            data-black-image="{{ $option['black_image_url'] }}"
                                                            data-white-image="{{ $option['white_image_url'] }}"
                                                            data-fitment-time="{{ $option['fitment_time'] }}"
                                                            data-uid="{{ $fieldUniqueId }}"
                                                            data-mid-sized-price="{{ $option['mid_sized_price'] }}"
                                                            data-toyota-79-price="{{ $option['toyota_79_price'] }}"
                                                            data-usa-truck-price="{{ $option['usa_truck_price'] }}"
                                                            data-length="{{ $option['length'] }}"
                                                            data-step="{{ $step['id'] }}"
                                                            data-price="{{ $option['price'] }}"
                                                            id="{{ $field['id'] }}-{{ $optionCounter }}">
                                                            <p class="d-none">{{ $option['text'] }}</p>
                                                            {{-- <p class="d-none">{{ $option['fitment_time'] ?? '' }}</p> --}}
                                                            <div class="d-flex justify-content-between gap-2">
                                                                <div
                                                                    class="px-2 {{ strtolower(trim($step['label'])) }}-text">
                                                                    {{ $option['text'] }}
                                                                </div>
                                                                <div class="px-2 d-flex">+$
                                                                    <div
                                                                        class="{{ strtolower(trim($step['label'])) }}-price ms-1 updated_price updated_price_3">
                                                                        
                                                                        {{ $option['price'] ?? 0 }}</div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                            
                        @endforeach


                        {{-- <div class="row align-items-center">
                            <div class="d-flex justify-content-between align-items-center form-buttons-outer-con">
                                <button class="back-btn" type="button">
                                    <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow"> Back
                                </button>

                                @foreach ($step['fields'] as $field)
                                    @if (!empty($field['label']) && !empty($field['type']) && strtolower(trim($field['type'])) == 'price_display')
                                        <div class="estimated-price-con text-black text-center">
                                            <label class="form-label">{{ $field['label'] }}</label>
                                            <div
                                                class="estimated-price-inn <?= htmlspecialchars($field['css_classes']) ?>">
                                                <?= htmlspecialchars($field['currency_symbol']) ?><span><?= htmlspecialchars($field['initial_value']) ?></span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                <button class="next-btn" type="button" disabled style="opacity: 0.5;"
                                    id="{{ $step['id'] }}">
                                    Next
                                    <img src="{{ asset('images/black-right-arrow.png') }}" alt="arrow">
                                </button>
                            </div>
                        </div> --}}
                    @elseif ($step['template'] == 4)
                        <div class="d-flex flex-column justify-content-center align-items-center sent-form-outer">
                            <div class="user-details">
                            @php
                                $count = 0;
                            @endphp

                            @foreach ($step['fields'] as $field)
                                @if (in_array($field['type'], ['text', 'email']))
                                    @if ($count % 2 == 0)
                                        <div class="row mb-3 user-form-fields-con">
                                    @endif
                                    
                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                        <input 
                                            type="{{ $field['type'] }}" 
                                            id="{{ $field['id'] }}" 
                                            class="form-control" 
                                            name="{{ $field['label'] }}" 
                                            placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ $field['default_value']  ?? '' }}"   >
                                        <div class="error-message text-danger small"></div>
                                    </div>

                                    @php $count++; @endphp

                                    @if ($count % 2 == 0)
                                        </div>
                                    @endif

                                @elseif ($field['type'] === 'radio')
                                    <h3 class="text-center">{{ $field['label'] }}</h3>
                                    <div class="d-flex justify-content-between interested-values-con mb-3" id="{{ $field['id'] }}">
                                        @foreach ($field['options'] as $option)
                                            <button type="button" class="btn btn-outline-primary interest-option"
                                                data-value="{{ $option['label'] }}">
                                                {{ $option['label'] }}
                                                @if (!empty($option['text']))
                                                    <i class="fas fa-info-circle" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $option['text'] }}"
                                                        style="font-size: 14px;"></i>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>

                                @elseif ($field['type'] === 'checkbox')
                                    <div class="form-check mb-3 mt-3">
                                        <input class="form-check-input" type="checkbox" id="{{ $field['id'] }} " name="{{ $field['label'] }}" data-terms="terms-checkbox">
                                        <label class="form-check-label" for="agree">
                                            {!! $field['label'] !!} 
                                        </label>
                                        <div class="error-message text-danger"></div>
                                    </div>

                                    
                                @elseif ($field['type'] == 'select')
                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                            name="{{ $field['label'] }}"
                                            data-field-type="{{ $field['label'] }}">
                                            <option value="" disabled selected>Select
                                                {{ ucfirst($field['label']) }}</option>

                                            {{-- Make Dropdown (Populated from Database) --}}
                                            @if ($field['label'] == 'make')
                                                @foreach ($makes as $make)
                                                    <option value="{{ $make->name }}"
                                                        data-title="{{ $make->name }}"
                                                        data-id="{{ $make->id }}">
                                                        {{ $make->name }}</option>
                                                @endforeach

                                                {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}
                                            @elseif (in_array($field['label'], ['model', 'series']))
                                                <!-- Model & Year options will be populated dynamically via JS -->
                                            @else
                                                @php
                                                    $options = !empty($field['options'])
                                                        ? explode("\n", $field['options'])
                                                        : [];
                                                @endphp

                                                @foreach ($options as $option)
                                                    @php $optionValue = trim($option); @endphp
                                                    <option value="{{ $optionValue }}"
                                                        {{ strtolower($optionValue) === 'no' ? 'selected' : '' }}>
                                                        {{ ucfirst(htmlspecialchars($optionValue)) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @elseif ($field['type'] == 'make')
                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                            name="{{ $field['label'] }}"
                                            data-field-type="{{ $field['label'] }}">
                                            <option value="" disabled selected>Select
                                                {{ ucfirst($field['label']) }}</option>

                                            {{-- Make Dropdown (Populated from Database) --}}

                                            @foreach ($makes as $make)
                                                <option value="{{ $make->name }}"
                                                    data-title="{{ $make->name }}"
                                                    data-id="{{ $make->id }}">
                                                    {{ $make->name }}</option>
                                            @endforeach

                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                        </select>
                                    </div>
                                @elseif ($field['type'] == 'model')
                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                            name="{{ $field['label'] }}"
                                            data-field-type="{{ $field['label'] }}">
                                            <option value="" disabled selected>Select
                                                {{ ucfirst($field['label']) }}</option>

                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                            {{-- @foreach ($models as $model)
                                                <option value="{{ $model->model_name }}"
                                                    data-title="{{ $model->model_name }}"
                                                    data-id="{{ $model->id }}">
                                                    {{ $model->model_name }}</option>
                                            @endforeach --}}

                                        </select>
                                    </div>
                                @elseif ($field['type'] == 'series')
                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                            name="{{ $field['label'] }}"
                                            data-field-type="{{ $field['label'] }}">
                                            <option value="" disabled selected>Select
                                                {{ ucfirst($field['label']) }}</option>

                                            {{-- Make Dropdown (Populated from Database) --}}

                                            {{-- @for ($y = 2000; $y <= 2025; $y++)
                                                <option value="{{ $y }}">{{ $y }}
                                                </option>
                                            @endfor --}}


                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                        </select>
                                    </div>
                                @elseif ($field['type'] == 'phone')
                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <input type="phone" id="{{ $field['id'] }}"
                                            class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                    </div>
                                @elseif ($field['type'] == 'textarea')
                                    <div class="form-group col-md-12 flex-column justify-content-between headboard-outer t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <textarea id="{{ $field['id'] }}" class="form-control form-text-box" name="{{ $field['label'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" ></textarea>
                                    </div>
                                @elseif ($field['type'] == 'date')
                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                        <label for="{{ $field['id'] }}"
                                            class="form-label">{{ ucfirst($field['label']) }}</label>
                                        <input type="date" id="{{ $field['id'] }}"
                                            class="form-control form-text-box" name="{{ $field['label'] }}">
                                    </div>
                                @elseif ($field['type'] == 'colors')
                                    {{-- <div class="col-12 col-md-6 form-left-outer">
                                            <h3 class="text-left text-white mb-4">Select One</h3>
                                            <div class="row color-selction-grid-panel"> --}}
                                    @php
                                        $colorsCounter = 0;
                                    @endphp
                                    @foreach ($field['colors'] as $color)
                                        <!-- FIX: Loop added -->
                                        @php
                                            $colorsCounter++;
                                        @endphp
                                        <div
                                            class="form-group col-md-6 d-flex flex-column justify-content-between color-selction-grid select-color-option">
                                            <div
                                                class="mb-2 d-flex justify-content-between gap-2 color-selction-label">
                                                <label class="form-label">{{ $color['label'] }}</label>
                                            </div>
                                            <div class="color-selection d-flex justify-content-between gap-2 color-{{ $color['name'] }}"
                                                data-image="{{ $color['image_url'] }}"
                                                data-label="{{ $color['label'] }}"
                                                data-step="{{ strtolower($step['id']) }}"
                                                id="{{ $field['id'] }}-{{ $colorsCounter }}">
                                                <div class="color-gradient-pic">
                                                    <p class="d-none">{{ $color['label'] }}</p>
                                                </div>
                                                <div class="color-text">{{ $color['name'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- </div>
                                        </div> --}}
                                @elseif (
                                    $fieldType == 'custom_radio' ||
                                        $fieldType == 'headboard_radio' ||
                                        $fieldType == 'canopy_radio' ||
                                        $fieldType == 'tray_sides_radio')
                                    @php
                                        $fieldUniqueId = Str::uuid();
                                        $optionCounter = 0;
                                    @endphp
                                    @foreach ($field['options'] as $option)
                                        @php
                                            $optionCounter++;
                                        @endphp
                                        <div
                                            class="form-group col-md-6 flex-column justify-content-between headboard-outer">
                                            <div
                                                class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                                <label class="form-label">{{ $option['label'] }}</label>
                                            </div>
                                            {{-- <pre>
                                                @php
                                                    print_r($option);
                                                @endphp
                                                </pre> --}}

                                            <div class="text-selection custom_radio_option {{ isset($field['id']) ? $field['id'] . '-options' : '' }}"
                                                data-title="{{ isset($field['label']) ? $field['label'] : '' }}"
                                                data-black-image="{{ isset($option['blackImage']) ? $option['blackImage'] : '' }}"
                                                data-white-image="{{ isset($option['whiteImage']) ? $option['whiteImage'] : '' }}"
                                                data-black-image-withheadboard="{{ isset($option['blackImage_withHeadboard']) ? $option['blackImage_withHeadboard'] : '' }}"
                                                data-white-image-withheadboard="{{ isset($option['whiteImage_withHeadboard']) ? $option['whiteImage_withHeadboard'] : '' }}"
                                                data-fitment-time="{{ isset($option['fitment_time']) ? $option['fitment_time'] : '' }}"
                                                data-uid="{{ isset($fieldUniqueId) ? $fieldUniqueId : '' }}"
                                                data-mid-sized-price="{{ isset($option['mid_sized_price']) ? $option['mid_sized_price'] : '' }}"
                                                data-toyota-79-price="{{ isset($option['toyota_79_price']) ? $option['toyota_79_price'] : '' }}"
                                                data-usa-truck-price="{{ isset($option['usa_truck_price']) ? $option['usa_truck_price'] : '' }}"
                                                data-length="{{ isset($option['length']) ? $option['length'] : '' }}"
                                                data-step="{{ isset($step['id']) ? $step['id'] : '' }}"
                                                data-price="{{ isset($option['price']) ? $option['price'] : '' }}"
                                                id="{{ isset($field['id']) && isset($optionCounter) ? $field['id'] . '-' . $optionCounter : '' }}">

                                                <p class="d-none">{{ isset($option['text']) ? $option['text'] : '' }}</p>

                                                <div class="d-flex justify-content-between gap-2">
                                                    <div class="px-2 {{ isset($step['label']) ? strtolower(trim($step['label'])) . '-text' : '' }}">
                                                        {{ isset($option['text']) ? $option['text'] : '' }}
                                                    </div>
                                                    <div class="px-2 d-flex">+$
                                                        <div class="{{ isset($step['label']) ? strtolower(trim($step['label'])) . '-price' : '' }} ms-1 updated_price updated_price_4">
                                                            
                                                            {{ isset($option['price']) ? $option['price'] : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($count % 2 != 0)
                                </div> {{-- Close any unclosed row --}}
                            @endif


                                <input type="hidden" name="total-quote" id="total-quote">


                                <!-- Navigation Buttons -->
                                <div
                                    class="mb-4 d-flex justify-content-between align-items-center form-buttons-outer-con submit-form-outer">
                                    <button class="back-btn back-button-submit" type="button"
                                        data-target-step="{{ $step['id'] }}"
                                        @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                        <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow">
                                        Back
                                    </button>
                                    @if($index !== count($form->steps) - 1)
                                        <button class="next-btn" type="button"  style="opacity: 1;"
                                            data-target-step="{{ $step['id'] }}"
                                            @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                            Next
                                            <img src="{{ asset('images/black-right-arrow.png') }}" alt="arrow">
                                        </button>
                                    @else
                                        <button class="btn btn-primary submit-btn" type="submit">Submit Inquiry</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif ($step['template'] == '0')
                        <div class="row align-items-center">
                            <div class="row form-left-outer">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <h3>{{ $step['sideHeading'] }}</h3>
                                    <div class="row new-class">

                                        @if (isset($step['fields']) && is_array($step['fields']))
                                            @foreach ($step['fields'] as $field)
                                                @php
                                                    $fieldLabel = strtolower(trim($field['label'] ?? ''));
                                                    $fieldType = strtolower(trim($field['type'] ?? ''));
                                                @endphp

                                                @if ($fieldType == 'select')
                                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                            name="{{ $fieldLabel }}"
                                                            data-field-type="{{ $fieldLabel }}">
                                                            <option value="" disabled selected>Select
                                                                {{ ucfirst($fieldLabel) }}</option>

                                                            {{-- Make Dropdown (Populated from Database) --}}
                                                            @if ($fieldLabel == 'make')
                                                                @foreach ($makes as $make)
                                                                    <option value="{{ $make->name }}"
                                                                        data-title="{{ $make->name }}"
                                                                        data-id="{{ $make->id }}">
                                                                        {{ $make->name }}</option>
                                                                @endforeach

                                                                {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}
                                                            @elseif (in_array($fieldLabel, ['model', 'series']))
                                                                <!-- Model & Year options will be populated dynamically via JS -->
                                                            @else
                                                                @php
                                                                    $options = !empty($field['options'])
                                                                        ? explode("\n", $field['options'])
                                                                        : [];
                                                                @endphp

                                                                @foreach ($options as $option)
                                                                    @php $optionValue = trim($option); @endphp
                                                                    <option value="{{ $optionValue }}"
                                                                        {{ strtolower($optionValue) === 'no' ? 'selected' : '' }}>
                                                                        {{ ucfirst(htmlspecialchars($optionValue)) }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                @elseif ($fieldType == 'make')
                                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                            name="{{ $fieldLabel }}"
                                                            data-field-type="{{ $fieldLabel }}">
                                                            <option value="" disabled selected>Select
                                                                {{ ucfirst($fieldLabel) }}</option>

                                                            {{-- Make Dropdown (Populated from Database) --}}

                                                            @foreach ($makes as $make)
                                                                <option value="{{ $make->name }}"
                                                                    data-title="{{ $make->name }}"
                                                                    data-id="{{ $make->id }}">
                                                                    {{ $make->name }}</option>
                                                            @endforeach

                                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                        </select>
                                                    </div>
                                                @elseif ($fieldType == 'model')
                                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                            name="{{ $fieldLabel }}"
                                                            data-field-type="{{ $fieldLabel }}">
                                                            <option value="" disabled selected>Select
                                                                {{ ucfirst($fieldLabel) }}</option>

                                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                            @foreach ($models as $model)
                                                                <option value="{{ $model->model_name }}"
                                                                    data-title="{{ $model->model_name }}"
                                                                    data-id="{{ $model->id }}">
                                                                    {{ $model->model_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                @elseif ($fieldType == 'series')
                                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <select id="{{ $field['id'] }}" class="form-select dynamic-select"
                                                            name="{{ $fieldLabel }}"
                                                            data-field-type="{{ $fieldLabel }}">
                                                            <option value="" disabled selected>Select
                                                                {{ ucfirst($fieldLabel) }}</option>

                                                            {{-- Make Dropdown (Populated from Database) --}}

                                                            @for ($y = 2000; $y <= 2025; $y++)
                                                                <option value="{{ $y }}">{{ $y }}
                                                                </option>
                                                            @endfor


                                                            {{-- Model & Year Dropdown (Dynamically Populated via JS) --}}

                                                        </select>
                                                    </div>
                                                @elseif ($fieldType == 'radio_old')
                                                    <!-- <div class="form-group  mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <select name="{{ $fieldLabel }}" id="{{ $field['id'] }}"
                                                            class="form-select dynamic-select">
                                                            @foreach ($field['options'] as $option)
                                                                <option value="{{ $option['text'] }}"
                                                                    {{ strtolower($option['text']) === 'no' ? 'selected' : '' }}>
                                                                    {{ $option['text'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
                                                @elseif ($fieldType == 'radio')
                                                    <div class="form-group mb-3 col-md-6 t1_Field">
                                                        <label for="{{ $field['id'] }}" class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <div id="{{ $field['id'] }}">
                                                            @foreach ($field['options'] as $option)
                                                                <label class="interest-option" data-value="{{ $option['text'] }}">
                                                                    <input type="radio" name="{{ $field['id'] }}" value="{{ $option['label'] }}"
                                                                        {{ $option['isActive'] ? 'checked' : '' }}>
                                                                    {{ $option['label'] }}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @elseif ($fieldType == 'checkbox')
                                                    <div class="form-check col-md-6 mb-3 mt-3 ml-3 t1_Field">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="{{ $field['id'] }}" name="{{ $fieldLabel }}"
                                                            {{ !empty($field['checked']) && $field['checked'] ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $field['id'] }}">
                                                            {!! $field['label'] !!} 
                                                        </label>
                                                    </div>
                                                @elseif ($fieldType == 'text')
                                                
                                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <input type="text" id="{{ $field['id'] }}"
                                                            class="form-control form-text-box" name="{{ $fieldLabel }}"  placeholder="{{ $field['placeholder']  ?? '' }}" value="{{ $field['default_value']  ?? '' }}">
                                                    </div>
                                                @elseif ($fieldType == 'email')
                                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <input type="email" id="{{ $field['id'] }}"
                                                            class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                    </div>
                                                @elseif ($fieldType == 'phone')
                                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <input type="phone" id="{{ $field['id'] }}"
                                                            class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"  value="{{ $field['default_value'] ?? '' }}">
                                                    </div>
                                                @elseif ($fieldType == 'textarea')
                                                    <div class="form-group col-md-12 flex-column justify-content-between headboard-outer t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <textarea id="{{ $field['id'] }}" class="form-control form-text-box" name="{{ $fieldLabel }}" placeholder="{{ $field['placeholder'] ?? '' }}"></textarea>
                                                    </div>
                                                @elseif ($fieldType == 'date')
                                                    <div class="form-group col-md-6 flex-column justify-content-between headboard-outer t1_Field">
                                                        <label for="{{ $field['id'] }}"
                                                            class="form-label">{{ ucfirst($fieldLabel) }}</label>
                                                        <input type="date" id="{{ $field['id'] }}"
                                                            class="form-control form-text-box" name="{{ $fieldLabel }}">
                                                    </div>
                                                @elseif ($fieldType == 'colors')
                                                    {{-- <div class="col-12 col-md-6 form-left-outer">
                                                            <h3 class="text-left text-white mb-4">Select One</h3>
                                                            <div class="row color-selction-grid-panel"> --}}
                                                    @php
                                                        $colorsCounter = 0;
                                                    @endphp
                                                    @foreach ($field['colors'] as $color)
                                                        <!-- FIX: Loop added -->
                                                        @php
                                                            $colorsCounter++;
                                                        @endphp
                                                        <div
                                                            class="form-group col-md-6 d-flex flex-column justify-content-between color-selction-grid select-color-option">
                                                            <div
                                                                class="mb-2 d-flex justify-content-between gap-2 color-selction-label">
                                                                <label class="form-label">{{ $color['label'] }}</label>
                                                            </div>
                                                            <div class="color-selection d-flex justify-content-between gap-2 color-{{ $color['name'] }}"
                                                                data-image="{{ $color['image_url'] }}"
                                                                data-label="{{ $color['label'] }}"
                                                                data-step="{{ strtolower($step['id']) }}"
                                                                id="{{ $field['id'] }}-{{ $colorsCounter }}">
                                                                <div class="color-gradient-pic">
                                                                    <p class="d-none">{{ $color['label'] }}</p>
                                                                </div>
                                                                <div class="color-text">{{ $color['name'] }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    {{-- </div>
                                                        </div> --}}
                                                @elseif (
                                                    $fieldType == 'custom_radio' ||
                                                        $fieldType == 'headboard_radio' ||
                                                        $fieldType == 'canopy_radio' ||
                                                        $fieldType == 'tray_sides_radio')
                                                    @php
                                                        $fieldUniqueId = Str::uuid();
                                                        $optionCounter = 0;
                                                    @endphp
                                                    @foreach ($field['options'] as $option)
                                                        @php
                                                            $optionCounter++;
                                                        @endphp
                                                        <div
                                                            class="form-group col-md-6 flex-column justify-content-between headboard-outer">
                                                            <div
                                                                class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                                                <label class="form-label">{{ $option['label'] }}</label>
                                                            </div>
                                                            {{-- <pre>
                                                                @php
                                                                    print_r($option);
                                                                @endphp
                                                                </pre> --}}

                                                            <div class="text-selection custom_radio_option {{ $field['id'] }}-options"
                                                                data-title="{{ $field['label'] }}"
                                                                data-black-image="{{ $option['black_image_url'] }}"
                                                                data-white-image="{{ $option['white_image_url'] }}"
                                                                data-black-image-withheadboard="{{ $option['black_image_url'] }}"
                                                                data-white-image-withheadboard="{{ $option['white_image_url'] }}"
                                                                data-fitment-time="{{ $option['fitment_time'] }}"
                                                                data-uid="{{ $fieldUniqueId }}"
                                                                data-mid-sized-price="{{ $option['mid_sized_price'] }}"
                                                                data-toyota-79-price="{{ $option['toyota_79_price'] }}"
                                                                data-usa-truck-price="{{ $option['usa_truck_price'] }}"
                                                                data-length="{{ $option['length'] }}"
                                                                data-step="{{ $step['id'] }}"
                                                                data-price="{{ $option['price'] }}"
                                                                id="{{ $field['id'] }}-{{ $optionCounter }}">
                                                                <p class="d-none">{{ $option['text'] }}</p>
                                                                {{-- <p class="d-none">{{ $option['fitment_time'] ?? '' }}</p> --}}
                                                                <div class="d-flex justify-content-between gap-2">
                                                                    <div
                                                                        class="px-2 {{ strtolower(trim($step['label'])) }}-text">
                                                                        {{ $option['text'] }}
                                                                    </div>
                                                                    <div class="px-2 d-flex">+$
                                                                        <div
                                                                            class="{{ strtolower(trim($step['label'])) }}-price ms-1 updated_price updated_price_5">
                                                                            {{ $option['price'] ?? 0 }}</div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 desktop-view mb-4">
                                <div class="summary-table table-responsive bg-dark p-3 rounded-3 overflow-hidden">
                                    <div class="main-table">
                                        <div class="thead-blk"></div>
                                        <div class="the-table">
                                            <table class="table table-bordered text-white"
                                                style="background-color: #111; max-height:460px">
                                                <thead class="table-dark" style="height: 60px;">
                                                    <tr>
                                                        <th class="py-3 px-3 text-center">Products</th>
                                                        <th class="py-3 px-3 text-center description-cls">Description
                                                        </th>
                                                        <th class="py-3 px-3 text-center">Price</th>
                                                        <th class="py-3 px-3 text-center">QTY</th>
                                                        <th class="py-3 px-3 text-center">Total</th>
                                                        <th class="py-3 px-3 text-center">Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="" id="dynamic-summary"
                                                    style="background-color: #111; max-height:460px">
                                                    <!-- Additional Product Rows -->
                                                </tbody>
                                                <tfoot class="table-dark" style="height: 60px;">
                                                    <tr>
                                                        <td class="py-3 px-3">
                                                        <button class="back-btn" type="button" data-target-step="{{ $step['id'] }}"
                                                            @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                                            <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow">
                                                            Back
                                                        </button>
                                                        </td>
                                                        <td class="py-3 px-3">
                                                            <div class="d-flex align-items-center">
                                                                <span>Estimated Calculated Fitment Hours*</span>
                                                                <i class="fas fa-info-circle ms-2"></i>
                                                            </div>
                                                        </td>
                                                        <td class="py-3 px-3 summaryFitmentHours">0 Hours</td>
                                                        <td class="py-3 px-3 summary-price">$0</td>
                                                        <td class="py-3 px-3 text-center" colspan="2">
                                                        @if($index !== count($form->steps) - 1)
                                                            <button type="button"
                                                                class="btn btn-light text-dark w-100 h-100 next-btn">Next</button>
                                                        @else
                                                            <button class="btn btn-primary submit-btn" type="submit">Submit Inquiry</button>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-buttons-summary">
                                    <button class="back-btn" type="button" data-target-step="{{ $step['id'] }}"
                                        @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                        <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow">
                                        Back
                                    </button>
                                </div> -->
                            </div>
                            <div class="col-md-12 mobile-view mb-4">
                                <div class="summary-mobile-card">
                                    <div id="dynamic-summary-card">

                                    </div>
                                    <div class="mobileViewBtn">
                                            <button type="button" class="btn btn-primary  download-pdf-btn">
                                            <i class="fas fa-file-pdf"></i> Download PDF
                                            </button>
                                        <!-- Bottom: Print Summary button -->
                                        <button type="button" class="btn btn-secondary print-summary-btn">
                                                <i class="fas fa-print"></i> Print Summary
                                        </button>
                                    </div>
                                    <div class="estimate-card">
                                        <div class="calculat-sum">
                                            <div class="calculated">
                                                <h2>Estimated Calculated Fitment Hours*</h2>
                                                <p class="summaryFitmentHours">0 Hours</p>
                                                <!-- <i class="fa fa-info-circle info-icon"></i> -->
                                            </div>
                                            <div class="calculated-wrap">
                                                <div class="cal-price">
                                                    <p class="summary-price-heading">Est. price</p>
                                                    <p class="summary-price">$0</p>
                                                </div>
                                                <div class="cal-btn">
                                                    <button class="back-btn" type="button"
                                                        data-target-step="{{ $step['id'] }}"
                                                        @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                                        <img src="{{ asset('images/white-left-arrow.png') }}"
                                                            alt="arrow">
                                                        Back
                                                    </button>
                                                    @if($index !== count($form->steps) - 1)
                                                    <button class="next-btn" type="button" disabled
                                                        style="opacity: 0.5;" data-target-step="{{ $step['id'] }}"
                                                        @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                                        Next
                                                        <img src="{{ asset('images/black-right-arrow.png') }}"
                                                            alt="arrow">
                                                    </button>
                                                    @else
                                                    <button class="btn btn-primary submit-btn" type="submit">Submit Inquiry</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sum-copyright tus-calc-footer-outer">
                                            <p>COPYRIGHT © {{ date('Y')}} TEST.COM. ALL RIGHTS RESERVED.</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- !empty($step['fields']) &&  -->
                    @if ($step['template'] != '0' && $step['template'] != '4')
                        <div class="row align-items-center">
                            <div class="d-flex justify-content-between align-items-center form-buttons-outer-con">

                                <button class="back-btn" type="button" data-target-step="{{ $step['id'] }}"
                                    @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                    <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow">
                                    Back
                                </button>

                               
                                @if($index !== count($form->steps) - 1 || count($form->steps) == 1)
                                <div class="estimated-price-con text-black text-center">
                                    <label class="form-label">Est. price</label>
                                    <div class="estimated-price-inn fw-bold fs-4 color-price"> $ <span
                                            class="est-price">0</span>
                                    </div>
                                </div>
                                <button class="next-btn" type="button"  style="opacity: 1;"
                                    data-target-step="{{ $step['id'] }}"
                                    @if (isset($form->steps[$index + 1]['id'])) data-next-step="{{ $form->steps[$index + 1]['id'] }}" @endif>
                                    Next
                                    <img src="{{ asset('images/black-right-arrow.png') }}" alt="arrow">
                                </button>
                                @else
                                <button class="btn btn-primary submit-btn" type="submit">Submit Inquiry</button>
                                @endif
                            </div>
                        </div>
                    @endif
                    



                </div>
            @endforeach

            <input type="hidden" name="form_slug" id="form-slug" value="{{ $form->slug ?? '' }}">


            <div class="great-work container steps-outer-main" style="display:none;">
                <div class="text-center">
                    <div class="poppin-graphic-con"><img src="{{ asset('images/poppin-graphic.png') }}"
                            alt="Pic"></div>
                    <h1 class=""> WE DID IT, GREAT WORK!</h1>
                    <p class="mb-4 px-4 max-w-2xl mx-auto">We appreciate you taking the time to complete your Tray
                        &amp; Canopy Builder with us! Your setup is one step closer to hitting the dusty roads, and
                        our team will be in touch soon to go over the details. In the meantime, follow us on socials
                        for the latest builds, updates, and adventure inspiration. If you have any questions or need
                        further assistance, don't hesitate to give us a call—we're always here to help!</p>
                    <p class="mb-8">See you out on the tracks!</p>
                    <div class="flex justify-center space-x-4 mb-8 social-media-icons-con">
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                        <a class="text-gray-400 hover:text-white" href="#">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>

                    <div
                        class="d-flex justify-content-center align-items-center form-buttons-outer-con submit-form-outer Back-home-btn">
                        <a href="{{ url()->current() }}" class="thankyou-back-btn"
                            type="button">
                            <img src="{{ asset('images/white-left-arrow.png') }}" alt="arrow">
                            Back Home
                        </a>
                    </div>


                </div>
            </div>




        </form>
    </div>


    <footer class="tus-calc-footer-outer">
        <div class="container">
            <div class="row">
                <p>COPYRIGHT © {{ date('Y')}} TEST.COM. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </footer>


    <!-- jQuery (Must Load First) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap (If Needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Slick Carousel (Before script2.js) -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- InputMask Plugin (If Required) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"
        integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Custom Scripts (Must Load Last) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <script>
        let products = <?php echo json_encode($products); ?>;

            var headboard_option = "";

            var $makes = {!! json_encode($makes)!!};

            var $models = {!! json_encode($models)!!};

            function enableNext(step_id) {  
                
                //console.log("step_id ", step_id);
                let allFilled = true;
                var nextbtnObject = $('.' + step_id).find('.next-btn');

                @foreach ($form->steps as $index => $step)
                    if ("{{ $step['id'] }}" === step_id) {

                        let hasMake = false;
                        let hasModel = false;
                        let hasSeries = false;

                        @foreach ($step['fields'] as $field)
                            @if ($field['type'] === 'colors')
                                nextbtnObject.removeAttr("disabled").css("opacity", "1");
                                return true;
                            @endif

                            @if ($field['type'] === 'products' && strtolower($field['productType']) === 'internals')
                                nextbtnObject.removeAttr("disabled").css("opacity", "1");
                                return true;
                            @endif

                            @if ($field['type'] === 'products' && strtolower($field['productType']) === 'external')
                                nextbtnObject.removeAttr("disabled").css("opacity", "1");
                                return true;
                            @endif

                            // var fieldElement = $('#{{ $field['id'] }}');
                            // if (fieldElement.val() === "" || fieldElement.val() === null) {
                            //     if (fieldElement.parent().css("display") !== "none") {
                            //         nextbtnObject.attr("disabled", "disabled").css("opacity", "0.5");
                            //         return false;
                            //     }
                            // }
                            @if ($field['type'] === 'make')
                                hasMake = true;
                            @endif

                            @if ($field['type'] === 'model')
                                hasModel = true;
                            @endif

                            @if ($field['type'] === 'series')
                                hasSeries = true;
                            @endif

                        @endforeach

                        // console.log( 2673,  hasMake && hasModel && hasSeries);
                        if (hasMake && hasModel && hasSeries) {
                            const makeVal = $('select[data-field-type="make"]').val();
                            const modelVal = $('select[data-field-type="model"]').val();
                            const yearVal = $('select[data-field-type="series"]').val();

                            // // console.log("makeVal", makeVal);
                            // // console.log("modelVal", modelVal);
                            // // console.log("yearVal", yearVal);
                            // // console.log( 2678, makeVal=="" || modelVal=="" || yearVal=="");
                            if (makeVal=="" || makeVal==null || modelVal=="" || modelVal==null || yearVal=="" || yearVal==null) {
                                nextbtnObject.attr("disabled", "disabled").css("opacity", "0.5");
                                return false;
                            }
                        }
                    }
                @endforeach

                nextbtnObject.removeAttr("disabled").css("opacity", "1");
                return true;
            }
        $(document).ready(function() {
            enableNext("step-1");
    
      
            //$(".next-btn").prop("disabled", true).css("opacity", "0.5");

            @php

                $formLogics = $logics;
                // print_r($formLogics);
            @endphp


            var formSelectedData = [];
            var totalPrice = 0;
            var internal_options = [];
            var external_options = [];
            var suspensionText = "Modified Suspension: No";

            var selectedInterests = [];

            var options = [];

            var formId = {{ $form->id }};
            var submitguid = '{{ $submitguid }}';

            // Initialize back button state - hide on first step
            $(".back-btn").not(".reload-btn").css("visibility", "hidden");



            function updateProgressMobile(currentStep) {
                const $steps = $(".nav-tabs-mobile .nav-link-mobile");
                const totalMobileSteps = $steps.length - 1;

                let mobileProgress = Math.min(4 + currentStep * (96 / totalMobileSteps), 100);

                $(".progress-bar-mobile")
                    .css("width", mobileProgress + "%")
                    .attr("aria-valuenow", mobileProgress);

                $steps.removeClass("nav-link-active-mobile new");
                $steps.slice(0, currentStep + 1).addClass("nav-link-active-mobile");
                $steps.eq(currentStep).addClass("new");
            }



            // Add a centralized price calculation function
            function updateTotalPrice() {
                let calculatedPrice = 0;

                // Sum up prices from selected options
                if (formSelectedData.basePrice) calculatedPrice += parseFloat(formSelectedData.basePrice);
                if (formSelectedData.headboard && formSelectedData.headboard.price) calculatedPrice += parseFloat(
                    formSelectedData.headboard.price);
                if (formSelectedData.canopy && formSelectedData.canopy.price) calculatedPrice += parseFloat(
                    formSelectedData.canopy.price);
                if (formSelectedData.tray && formSelectedData.tray.price) calculatedPrice += parseFloat(
                    formSelectedData.tray.price);
                if (formSelectedData.custom_radio && formSelectedData.custom_radio.price) calculatedPrice +=
                    parseFloat(formSelectedData.custom_radio.price);
                // Add prices from internal options
                if (internal_options && internal_options.length > 0) {
                    internal_options.forEach(option => {
                        calculatedPrice += parseFloat(option.price) * option.quantity;
                    });
                }

                // Add prices from external options
                if (external_options && external_options.length > 0) {
                    external_options.forEach(option => {
                        calculatedPrice += parseFloat(option.price) * option.quantity;
                    });
                }

                // Update the price display
                let formattedPrice = calculatedPrice.toLocaleString();

                $('.est-price').text(formattedPrice);
                $('#total-quote').val(formattedPrice);
                totalPrice = calculatedPrice;

                return calculatedPrice;
            }


            // Add a centralized price calculation function
            function updateTotalTime() {
                let calculatedTime = 0;

                // Sum up prices from selected options
                if (formSelectedData.basePrice) calculatedTime += parseFloat(formSelectedData.baseTime || 0);
                if (formSelectedData.headboard && formSelectedData.headboard.fitmentTime) calculatedTime +=
                    parseFloat(
                        formSelectedData.headboard.fitmentTime);
                if (formSelectedData.canopy && formSelectedData.canopy.fitmentTime) calculatedTime += parseFloat(
                    formSelectedData.canopy.fitmentTime);
                if (formSelectedData.tray && formSelectedData.tray.fitmentTime) calculatedTime += parseFloat(
                    formSelectedData.tray.fitmentTime);
                if (formSelectedData.custom_radio && formSelectedData.custom_radio.fitmentTime) calculatedTime +=
                    parseFloat(formSelectedData.custom_radio.fitmentTime);
                // Add fitmentTime from internal options
                if (internal_options && internal_options.length > 0) {
                    internal_options.forEach(option => {
                        calculatedTime += parseFloat(option.fitmentTime) * option.quantity;
                    });
                }

                // Add prices from external options
                if (external_options && external_options.length > 0) {
                    external_options.forEach(option => {
                        calculatedTime += parseFloat(option.fitmentTime) * option.quantity;
                    });
                }

                //adding vehicle fitment time
                calculatedTime +=4;
                
                // // Update the price display
                $('.summaryFitmentHours').text(calculatedTime + " Hours");
                // $('#total-quote').val(calculatedTime.toFixed(2));
                // // // console.log(calculatedTime);


                return calculatedTime;
            }

            // Functions for the summary table
            function updateSummaryTable() {
                $("#dynamic-summary").empty(); // Clear the table before rebuilding
                $("#dynamic-summary-card").empty(); // Clear the table before rebuilding
                addProductRow(); // Rebuild the table with updated data
                addProductRowmobile();
            }


            $('body').on('change', 'select[data-field-type="make"]', function() {
                        var makeId = $(this).children('option:selected').data('id');
                        var makeTitle = $(this).children('option:selected').data('title');
                        // // // console.log(makeId);

                        formSelectedData['make'] = makeTitle;
            });

            $('body').on('change', 'select[data-field-type="series"]', function() {
                        var series = $(this).children('option:selected').val();
                        // // // console.log(makeId);

                        formSelectedData['series'] = series;
            });

            $('body').on('change', 'select[data-field-type="select"]', function() {
                var selectName = $(this).attr('name');
                var selectType = $(this).attr( 'data-field-type');
                var selectVal = $(this).children('option:selected').val();
                console.log(selectName, selectVal);
 
                formSelectedData[selectType] = {label: selectName, value: selectVal };
                console.log(formSelectedData);
            });

            function addProductRow() {

                //console.log("formSelectedData",formSelectedData);
                let basePrice = formSelectedData.basePrice || 0;
                let colorPrice = 0;
                let headboardPrice = formSelectedData.headboard ? formSelectedData.headboard.price : 0;
                let canopyPrice = formSelectedData.canopy ? formSelectedData.canopy.price : 0;
                let trayPrice = formSelectedData.tray ? formSelectedData.tray.price : 0;
                let customRadioPrice = formSelectedData.custom_radio ? formSelectedData.custom_radio.price : 0;

                //console.log(formSelectedData);

                // Base vehicle row
                var newRow = `
                    <tr class="table-dark">
                        <td class="py-2 px-3 text-center">
                            <img src="{{ asset('images/site-logo.png') }}"
                                alt="Product Image"
                                class="rounded img-thumbnail">
                        </td>
                        <td class="py-2 px-3 description-cls">${formSelectedData.make || ''} (${formSelectedData.model || ''}) (${formSelectedData.series || ''}) <br> ${formSelectedData.select?.label ? formSelectedData.select.label + ':' : ''} ${formSelectedData.select?.value || ''}</td>
                        <td class="py-3 px-3 text-center"> $ ${basePrice}</td>
                        <td class="py-2 px-3">-</td>
                        <td class="py-2 px-3 text-center"> $ ${basePrice}</td>
                        <td class="py-2 px-3 fitmentTime-cls d-none">4</td> 
                        <td class="py-2 px-3 text-center">-</td>
                    </tr>
                `;

                // Append the base vehicle row
                $("#dynamic-summary").append(newRow);

                let runningTotal = basePrice;

                // Color selection row
                if (formSelectedData.color) {
                    let colorImgSrc = formSelectedData.color.image || '';
                    runningTotal += colorPrice;

                    let colorRow = `
                        <tr class="table-dark">
                            <td class="py-2 px-3 text-center">
                                <img src="${colorImgSrc}"
                                    alt="Color Selection"
                                    class="rounded img-thumbnail">
                            </td>
                            <td class="py-2 px-3 description-cls">Color Selection: ${formSelectedData.color.name || ''}</td>
                            <td class="py-2 px-3 text-center"> $ ${colorPrice}</td>
                            <td class="py-2 px-3">-</td>
                            <td class="py-2 px-3 text-center"> $ ${colorPrice}</td>
                            <td class="py-2 px-3 text-center">-</td>
                        </tr>
                    `;
                    $("#dynamic-summary").append(colorRow);
                }

                // Headboard row
                if (formSelectedData.headboard) {
                    let headboardImgSrc = formSelectedData.headboard.image || '';
                    runningTotal += headboardPrice;

                    let headboardRow = `
                        <tr class="table-dark">
                            <td class="py-2 px-3 text-center">
                                <img src="${headboardImgSrc}"
                                    alt="Headboard"
                                    class="rounded img-thumbnail">
                            </td>
                            <td class="py-2 px-3 description-cls">Selected Headboard: ${formSelectedData.headboard.name || ''}</td>
                            <td class="py-2 px-3 text-center"> $ ${headboardPrice}</td>
                            <td class="py-2 px-3">-</td>
                            <td class="py-2 px-3 text-center"> $ ${headboardPrice}</td>
                            <td class="py-2 px-3 fitmentTime-cls d-none">${formSelectedData.headboard.fitmentTime || ''}</td> 
                            <td class="py-2 px-3 text-center">-</td>
                        </tr>
                    `;
                    $("#dynamic-summary").append(headboardRow);
                }

                // Canopy row
                if (formSelectedData.canopy) {
                    let canopyImgSrc = formSelectedData.canopy.image || '';
                    runningTotal += canopyPrice;

                    let canopyRow = `
                        <tr class="table-dark">
                            <td class="py-2 px-3 text-center">
                                <img src="${canopyImgSrc}"
                                    alt="Canopy"
                                    class="rounded img-thumbnail">
                            </td>
                            <td class="py-2 px-3 description-cls">Selected Canopy: ${formSelectedData.canopy.name || ''}</td>
                            <td class="py-2 px-3 text-center"> $ ${canopyPrice}</td>
                            <td class="py-2 px-3">-</td>
                            <td class="py-2 px-3 text-center"> $ ${canopyPrice}</td>
                             <td class="py-2 px-3 fitmentTime-cls d-none">${formSelectedData.canopy.fitmentTime || ''}</td> 
                            <td class="py-2 px-3 text-center">-</td>
                        </tr>
                    `;
                    $("#dynamic-summary").append(canopyRow);
                }

                // Tray sides row
                if (formSelectedData.tray) {
                    let trayImgSrc = formSelectedData.tray.image || '';
                    runningTotal += trayPrice;

                    let trayRow = `
                        <tr class="table-dark">
                            <td class="py-2 px-3 text-center">
                                <img src="${trayImgSrc}"
                                    alt="Tray Sides"
                                    class="rounded img-thumbnail">
                            </td>
                            <td class="py-2 px-3 description-cls">Selected Tray Sides: ${formSelectedData.tray.name || ''}</td>
                            <td class="py-2 px-3 text-center"> $ ${trayPrice}</td>
                            <td class="py-2 px-3">-</td>
                            <td class="py-2 px-3 text-center"> $ ${trayPrice}</td>
                            <td class="py-2 px-3 fitmentTime-cls d-none"> ${formSelectedData.tray.fitmentTime || ''}</td> 
                            <td class="py-2 px-3 text-center">-</td>
                        </tr>
                    `;
                    $("#dynamic-summary").append(trayRow);
                }

                // Custom Radio sides row
                if (formSelectedData.custom_radio) {
                    let customRadioImgSrc = formSelectedData.custom_radio.image || '';
                    runningTotal += customRadioPrice;

                    let customRadioRow = `
                        <tr class="table-dark">
                            <td class="py-2 px-3 text-center">
                                <img src="${customRadioImgSrc}"
                                    alt="${formSelectedData.custom_radio.name} Image"
                                    class="rounded img-thumbnail">
                            </td>
                            <td class="py-2 px-3 description-cls">Selected ${formSelectedData.custom_radio.title || 'item'}: ${formSelectedData.custom_radio.name || ''}</td>
                            <td class="py-2 px-3 text-center"> $ ${customRadioPrice}</td>
                            <td class="py-2 px-3">-</td>
                            <td class="py-2 px-3 text-center"> $ ${customRadioPrice}</td>
                            <td class="py-2 px-3 fitmentTime-cls d-none">${formSelectedData.custom_radio.fitmentTime || ''}</td> 
                            <td class="py-2 px-3 text-center">-</td>
                        </tr>
                    `;
                    $("#dynamic-summary").append(customRadioRow);
                }


                // Internal options rows
                if (internal_options && internal_options.length > 0) {
                    internal_options.forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        let originalProduct = products.find(p => p.name === option.name && p
                            .internal_external === "internal");
                        let maxQuantity = originalProduct?.quantity || 1;


                        // Find matching image
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('images/site-logo.png') }}";

                        let internalRow = `
                            <tr class="table-dark">
                                <td class="py-2 px-3 text-center">
                                    <img src="${matchingImage}"
                                        alt="Option Image"
                                        class="rounded img-thumbnail">
                                </td>
                                <td class="py-2 px-3 description-cls">${option.name}</td>
                                <td class="py-2 px-3 text-center"> $ ${option.price}</td>
                                 <td class="py-2 px-3 text-center">
                                    <span class="quantity mx-2">${option.quantity}</span>
                                </td>
                                <td class="py-2 px-3 text-center"> $ ${optionTotal}</td>
                                <td class="py-2 px-3 fitmentTime-cls d-none">${option.fitmentTime || ''}</td>
                                <td class="py-2 px-3 text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove-item" data-name="${option.name}">x</button>
                                </td>
                            </tr>
                        `;
                        $("#dynamic-summary").append(internalRow);
                    });
                }

                // <button type="button" class="btn btn-sm btn-secondary qty decrease-quantity" data-name="${option.name}" ${option.quantity <= 1 ? 'disabled' : ''}>-</button>
                // <button type="button" class="btn btn-sm btn-secondary qty increase-quantity" data-name="${option.name}" ${option.quantity >= maxQuantity ? 'disabled' : ''}>+</button>


                // External options rows
                if (external_options && external_options.length > 0) {
                    external_options.forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        let originalProduct = products.find(p => p.name === option.name && p
                            .internal_external === "external");
                        let maxQuantity = originalProduct?.quantity || 1;

                        let disableMinus = option.quantity <= 1 ? 'disabled' : '';
                        let disablePlus = option.quantity >= maxQuantity ? 'disabled' : '';


                        // Find matching image
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('images/site-logo.png') }}";

                        let externalRow = `
                            <tr class="table-dark">
                                <td class="py-2 px-3 text-center">
                                    <img src="${matchingImage}"
                                        alt="Option Image"
                                        class="rounded img-thumbnail">
                                </td>
                                <td class="py-2 px-3 description-cls">${option.name}</td>
                                <td class="py-2 px-3 text-center"> $ ${option.price}</td>
                                <td class="py-2 px-3 text-center">
                                    <span class="quantity">${option.quantity}</span>
                                </td>

                                <td class="py-2 px-3 text-center"> $ ${optionTotal}</td>
                                 <td class="py-2 px-3 fitmentTime-cls d-none">${option.fitmentTime || ''}</td>
                                <td class="py-2 px-3 text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove-item" data-name="${option.name}">x</button>
                                </td>
                            </tr>
                        `;
                        $("#dynamic-summary").append(externalRow);
                    });
                }

                // <button type="button" class="btn btn-sm btn-secondary qty decrease-quantity" data-name="${option.name}" ${disableMinus}>-</button>
                // <button type="button" class="btn btn-sm btn-secondary qty increase-quantity" data-name="${option.name}" ${disablePlus}>+</button>



                // Update the summary price
                $(".summary-price").text(`$ ${runningTotal}`);

                // // Set total fitment hours
                // let totalFitmentHours = 0;
                // if (formSelectedData.headboard && formSelectedData.headboard.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.headboard.attributes.fitmentTime || 0);
                // }
                // if (formSelectedData.canopy && formSelectedData.canopy.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.canopy.attributes.fitmentTime || 0);
                // }
                // if (formSelectedData.tray && formSelectedData.tray.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.tray.attributes.fitmentTime || 0);
                // }
                // $(".summaryFitmentHours").text(totalFitmentHours + " Hours");



            }


            function addProductRowmobile() {
                let basePrice = formSelectedData.basePrice || 0;
                let colorPrice = 0;
                let headboardPrice = formSelectedData.headboard ? formSelectedData.headboard.price : 0;
                let canopyPrice = formSelectedData.canopy ? formSelectedData.canopy.price : 0;
                let trayPrice = formSelectedData.tray ? formSelectedData.tray.price : 0;
                let customRadioPrice = formSelectedData.custom_radio ? formSelectedData.custom_radio.price : 0;

                // Base vehicle row
                var newRow = `
                    <div class="summary-card">
                        <div class="sum-grid">
                            <div class="sum-img">
                                <img src="{{ asset('images/site-logo.png') }}" alt="">
                            </div>
                             <div class="sum-title">
                                <h4>${formSelectedData.make || ''}  ${formSelectedData.model || ''}  <br>
                                    ${formSelectedData.series || ''} )<br> ${formSelectedData.select?.label ? formSelectedData.select.label + ':' : ''} ${formSelectedData.select?.value || ''}</h4>
                                
                            </div>
                        </div>
                        <div class="sum-price sum-bg">
                            <p>Price</p>
                            <p>QTY</p>
                            <p>Total</p>
                        </div>
                        <div class="sum-price">
                            <p> $ ${basePrice}</p>
                            <p>-</p>
                            <p> $ ${basePrice}</p>
                        </div>
                    </div>
                `;

                // Append the base vehicle row
                $("#dynamic-summary-card").append(newRow);

                let runningTotal = basePrice;

                // Color selection row
                if (formSelectedData.color) {
                    let colorImgSrc = formSelectedData.color.image || '';
                    runningTotal += colorPrice;

                    let colorRow = `
                            <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${colorImgSrc}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Selected Color :</h4>
                                        <p>${formSelectedData.color.name || ''}</p>
                                    </div>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${colorPrice}</p>
                                    <p>-</p>
                                    <p> $ ${colorPrice}</p>
                                </div>
                            </div>
                    `;
                    $("#dynamic-summary-card").append(colorRow);
                }

                // Headboard row
                if (formSelectedData.headboard) {
                    let headboardImgSrc = formSelectedData.headboard.image || '';
                    runningTotal += headboardPrice;

                    let headboardRow = `
                            <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${headboardImgSrc}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Selected Headboard :</h4>
                                        <p>${formSelectedData.headboard.name || ''}</p>
                                    </div>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${headboardPrice}</p>
                                    <p>-</p>
                                    <p> $ ${headboardPrice}</p>
                                </div>
                            </div>
                    `;
                    $("#dynamic-summary-card").append(headboardRow);
                }

                // Canopy row
                if (formSelectedData.canopy) {
                    let canopyImgSrc = formSelectedData.canopy.image || '';
                    runningTotal += canopyPrice;

                    let canopyRow = `
                            <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${canopyImgSrc}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Selected Canopy :</h4>
                                        <p>${formSelectedData.canopy.name || ''}</p>
                                    </div>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${canopyPrice}</p>
                                    <p>-</p>
                                    <p> $ ${canopyPrice}</p>
                                </div>
                            </div>
                    `;
                    $("#dynamic-summary-card").append(canopyRow);
                }

                // Tray sides row
                if (formSelectedData.tray) {
                    let trayImgSrc = formSelectedData.tray.image || '';
                    runningTotal += trayPrice;

                    let trayRow = `
                        <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${trayImgSrc}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Selected Tray Sides :</h4>
                                        <p>${formSelectedData.tray.name || ''}</p>
                                    </div>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${trayPrice}</p>
                                    <p>-</p>
                                    <p> $ ${trayPrice}</p>
                                </div>
                            </div>
                    `;
                    $("#dynamic-summary-card").append(trayRow);
                }

                if (formSelectedData.custom_radio) {
                    let customRadioImgSrc = formSelectedData.custom_radio.image || '';
                    runningTotal += customRadioPrice;

                    let customRadioRow = `
                        <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${customRadioImgSrc}" alt="${formSelectedData.custom_radio.name}">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Selected ${formSelectedData.custom_radio.title || 'item'}:</h4>
                                        <p>${formSelectedData.custom_radio.name || ''}</p>
                                    </div>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${customRadioPrice}</p>
                                    <p>-</p>
                                    <p> $ ${customRadioPrice}</p>
                                </div>
                            </div>
                    `;
                    $("#dynamic-summary-card").append(customRadioRow);
                }

                // Internal options rows
                if (internal_options && internal_options.length > 0) {
                    internal_options.forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        let originalProduct = products.find(p => p.name === option.name && p
                            .internal_external === "internal");
                        let maxQuantity = originalProduct?.quantity || 1;

                        // Find matching image
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('images/site-logo.png') }}";

                        let internalRow = `
                              <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${matchingImage}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Internals :</h4>
                                        <p>${option.name}</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-item" data-name="${option.name}"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${option.price}</p>
                                    <p>
                                        <span class="quantity mx-2">${option.quantity}</span>
                                    </p>
                                    <p> $ ${optionTotal}</p>
                                </div>
                            </div>
                        `;
                        $("#dynamic-summary-card").append(internalRow);
                    });
                }

                // <button type="button" class="btn btn-sm btn-secondary qty decrease-quantity-mobile" data-name="${option.name}" ${option.quantity <= 1 ? 'disabled' : ''}>-</button>
                // <button type="button" class="btn btn-sm btn-secondary qty increase-quantity-mobile" data-name="${option.name}" ${option.quantity >= maxQuantity ? 'disabled' : ''}>+</button>



                // External options rows
                if (external_options && external_options.length > 0) {
                    external_options.forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        let originalProduct = products.find(p => p.name === option.name && p
                            .internal_external === "external");
                        let maxQuantity = originalProduct?.quantity || 1;

                        let disableMinus = option.quantity <= 1 ? 'disabled' : '';
                        let disablePlus = option.quantity >= maxQuantity ? 'disabled' : '';


                        // Find matching image
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('images/site-logo.png') }}";

                        let externalRow = `
                            <div class="summary-card">
                                <div class="sum-grid">
                                    <div class="sum-img">
                                        <img src="${matchingImage}" alt="">
                                    </div>
                                    <div class="sum-title">
                                        <h4>Externals :</h4>
                                        <p>${option.name}</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-item" data-name="${option.name}"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="sum-price sum-bg">
                                    <p>Price</p>
                                    <p>QTY</p>
                                    <p>Total</p>
                                </div>
                                <div class="sum-price">
                                    <p> $ ${option.price}</p>
                                    <p>
                                        <span class="quantity">${option.quantity}</span>
                                    </p>
                                    <p> $ ${optionTotal}</p>
                                </div>
                            </div>
                        `;
                        $("#dynamic-summary-card").append(externalRow);
                    });
                }

                // <button type="button" class="btn btn-sm btn-secondary qty decrease-quantity-mobile" data-name="${option.name}" ${disableMinus}>-</button>
                // <button type="button" class="btn btn-sm btn-secondary qty increase-quantity-mobile" data-name="${option.name}" ${disablePlus}>+</button>


                // Update the summary price
                $(".summary-price-card").text(`$ ${runningTotal}`);

                // // Set total fitment hours
                // let totalFitmentHours = 0;
                // if (formSelectedData.headboard && formSelectedData.headboard.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.headboard.attributes.fitmentTime || 0);
                // }
                // if (formSelectedData.canopy && formSelectedData.canopy.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.canopy.attributes.fitmentTime || 0);
                // }
                // if (formSelectedData.tray && formSelectedData.tray.attributes) {
                //     totalFitmentHours += parseFloat(formSelectedData.tray.attributes.fitmentTime || 0);
                // }
                // $(".summaryFitmentHours").text(totalFitmentHours + " Hours");



            }

            $(document).on("click", ".increase-quantity-mobile, .decrease-quantity-mobile", function() {
                let card = $(this).closest(".summary-card"); // Updated from 'tr'
                let quantityElement = card.find(".quantity");
                let quantity = parseInt(quantityElement.text().trim()) || 0;
                let optionName = $(this).data("name");

                if ($(this).hasClass("increase-quantity-mobile")) {
                    quantity += 1;
                } else if (quantity > 1) {
                    quantity -= 1;
                }

                quantityElement.text(quantity);

                // Update internal_options or external_options arrays
                let internalIndex = internal_options.findIndex(opt => opt.name === optionName);
                if (internalIndex !== -1) {
                    internal_options[internalIndex].quantity = quantity;
                }

                let externalIndex = external_options.findIndex(opt => opt.name === optionName);
                if (externalIndex !== -1) {
                    external_options[externalIndex].quantity = quantity;
                }

                updateTotalPrice();
                updateTotalTime();
                updateSummaryTable(); // This will rebuild the summary with updated values
            });

            // Event handlers for the summary table
            $(document).on("click", ".increase-quantity, .decrease-quantity", function() {
                let row = $(this).closest("tr");
                let quantityElement = row.find(".quantity");
                let quantity = parseInt(quantityElement.text().trim()) || 0;
                let optionName = $(this).data("name");

                if ($(this).hasClass("increase-quantity")) {
                    quantity += 1;
                } else if (quantity > 1) {
                    quantity -= 1;
                }

                quantityElement.text(quantity);

                // Update internal_options or external_options arrays
                let internalIndex = internal_options.findIndex(opt => opt.name === optionName);
                if (internalIndex !== -1) {
                    internal_options[internalIndex].quantity = quantity;
                }

                let externalIndex = external_options.findIndex(opt => opt.name === optionName);
                if (externalIndex !== -1) {
                    external_options[externalIndex].quantity = quantity;
                }

                updateTotalPrice();
                updateTotalTime();
                updateSummaryTable();
            });

            $(document).on("click", ".remove-item", function() {
                let optionName = $(this).data("name");

                // Remove from internal_options
                let internalIndex = internal_options.findIndex(opt => opt.name === optionName);
                if (internalIndex !== -1) {
                    internal_options.splice(internalIndex, 1);
                }

                // Remove from external_options
                let externalIndex = external_options.findIndex(opt => opt.name === optionName);
                if (externalIndex !== -1) {
                    external_options.splice(externalIndex, 1);
                }

                updateTotalPrice();
                updateTotalTime();
                updateSummaryTable();
            });

            function validateEnableBtn(field_id) {
                var fieldId = "";
                var step_id = "";
                // // // console.log('validate');

                @foreach ($form->steps as $index => $step)

                    @foreach ($step['fields'] as $field)

                        fieldId = "{{ $field['id'] }}";

                        step_id = "{{ $step['id'] }}"

                        if (fieldId == field_id) {
                            enableNext(step_id);
                        }
                    @endforeach
                @endforeach
            }

            @foreach ($formLogics as $formLogic)

                @php
                    $formLogicParams = json_decode($formLogic->parameters, true);

                @endphp

                @if ($formLogic->recipe->title == 'make_model_dependancy')

                    $('body').on('change', '#{{ $formLogicParams[1] }}', function() {
                        var makeId = $(this).children('option:selected').data('id');
                        var makeTitle = $(this).children('option:selected').data('title');
                        // // // console.log(makeId);

                        formSelectedData['make'] = makeTitle;
                        // // // console.log(formSelectedData);

                        /*$.ajax({
                            type: "GET",
                            url: "/getModel/" + makeId,
                            success: function(response) {
                                $('#{{ $formLogicParams[2] }}').html(response);

                                validateEnableBtn("{{ $formLogicParams[1] }}");

                            }
                        });*/
                        
                        $html = "<option value=\"\">Select Model</option>";
                        $.each($makes, function($key, $value){
                            if($value.id == makeId) {
                               
                                $.each($value.models, function($key,$value){
                                    $html += " <option value=\""+ $value.model_name +"\" data-id=\""+ $value.id +"\">"+ $value.model_name +"</option>";
                                });
                                
                            }
                        });
                        
                        $('#{{ $formLogicParams[2] }}').html($html);

                        validateEnableBtn("{{ $formLogicParams[1] }}");

                        @foreach ($formLogics as $formLogicInner) 
                            @if ($formLogicInner->recipe->title == 'model_year_dependancy')
                                @php
                                    $formLogicParamsInner = json_decode($formLogicInner->parameters, true);
                                @endphp
                                $html_year = "<option value=\"\">Select Series</option>" ;

                                $('#{{ $formLogicParamsInner[2] }}').html($html_year);
                                formSelectedData['basePrice']= 0;
                                updateTotalPrice();
                            @endif
                        @endforeach

                    });
                @elseif ($formLogic->recipe->title == 'model_year_dependancy')
                    $('body').on('change', '#{{ $formLogicParams[1] }}', function() {
                        var modelId = $(this).children('option:selected').data('id');
                        var model_value = $(this).children('option:selected').val();
                        // // // console.log(modelId);

                        formSelectedData['model'] = model_value;

                        /*$.ajax({
                            type: "GET",
                            url: "/getYear/" + modelId,
                            success: function(response) {
                                $('#{{ $formLogicParams[2] }}').html(response);
                                validateEnableBtn("{{ $formLogicParams[1] }}");
                            }
                        });*/
                        
                        
                         $html = "<option value=\"\">Select Series</option>";
                        $.each($models, function($key, $value){
                            if($value.id == modelId) {
                                var $years = $value.years.split(',');
                              
                                $.each($years, function($yKey,$yValue) {
                                    $html += " <option value=\"" + $yValue + "\" data-truck-type=\""+ $value.truck_type +"\" data-price=\"" + $value.price + "\">" + $yValue + "</option>";
                                })
                                    //$html += " <option value=\""2023"\" data-truck-type=\""Mid-Sized"\" data-price=\""6490.00"\">\"2023\"</option>";
                                
                                
                            }
                        });
                        $('#{{ $formLogicParams[2] }}').html($html);
                        validateEnableBtn("{{ $formLogicParams[1] }}");

                        formSelectedData['basePrice']= 0;
                                updateTotalPrice();

                    });
                @elseif ($formLogic->recipe->title == 'length_dependancy')
                    // // // console.log("length_dependancy");
                @elseif ($formLogic->recipe->title == 'selective_field_change')

                    var fieldParent = $('#{{ $formLogicParams[4] }}').parent();

                    if ("{{ $formLogicParams[3] }}" == "show") {
                        fieldParent.hide();
                    } else {
                        fieldParent.show();
                    }

                    $('#{{ $formLogicParams[1] }}').change(function() {

                        if ($('#{{ $formLogicParams[1] }}').val() == '{{ $formLogicParams[2] }}') {
                            if ("{{ $formLogicParams[3] }}" == "show") {
                                fieldParent.show();
                            } else {
                                fieldParent.hide();
                            }
                        } else {
                            if ("{{ $formLogicParams[3] }}" == "show") {
                                fieldParent.hide();
                            } else {
                                fieldParent.show();
                            }
                        }
                        validateEnableBtn("{{ $formLogicParams[1] }}");
                    });

                    // // // console.log("selective_field_change");
                @elseif ($formLogic->recipe->title == 'show_hide_step')


                    // // // console.log({formLogicParams: {!! json_encode($formLogicParams) !!} });


                    // const $formLogicParams = @json($formLogicParams);
                    formLogicParams = {!! json_encode($formLogicParams) !!};

                    // // // console.log("formLogicParams:", $formLogicParams);

                    [optionClass, expectedText, action, stepId] = [
                        formLogicParams[1],
                        formLogicParams[2],
                        formLogicParams[3],
                        formLogicParams[4]
                    ];

                    fieldStep = $('.' + stepId);
                    fieldOptions = $('.' + optionClass + '-options');

                    fieldStep.addClass('logic-step');

                    // Default hidden (optional, will toggle based on initial value too)
                    fieldStep.css('visibility', 'hidden');

                    $(document).on('click', '.' + optionClass + '-options', function() {
                        const selectedText = $(this).find('.d-none').text().trim();
                        // // // console.log('Selected Option:', selectedText);

                        const match = selectedText === expectedText;

                        if ((action === 'show' && match) || (action === 'hide' && !match)) {
                            fieldStep.css('visibility', 'visible').removeClass('logic-step');
                        } else {
                            fieldStep.css('visibility', 'hidden').addClass('logic-step');
                        }

                        validateEnableBtn(optionClass);
                    });

                    // // // console.log("show_hide_step");
                @elseif ($formLogic->recipe->title == 'show_hide_internal')
                
                
                
                @endif
            @endforeach

            $('body').on('change', 'select[data-field-type="make"]', function(){
                var $this = $(this);
                var makeId = $(this).children('option:selected').data('id');
                var makeTitle = $(this).children('option:selected').data('title');
                $html = "<option value=\"\">Select Model</option>";
                        $.each($makes, function($key, $value){
                            if($value.id == makeId) {
                               
                                $.each($value.models, function($key,$value){
                                    $html += " <option value=\""+ $value.model_name +"\" data-id=\""+ $value.id +"\">"+ $value.model_name +"</option>";
                                });
                                
                            }
                        });
                
                if($('select[data-field-type="model"]').length > 0) {
                    $('select[data-field-type="model"]').html($html);
                }
                if($('select[data-field-type="series"]').length > 0) {
                    $('select[data-field-type="series"]').html("<option value=\"\">Select Series</option>");
                }
                formSelectedData['basePrice']= 0;
                updateTotalPrice();

                $this.closest('.step').find('.next-btn').attr('disabled', "disabled").css('opacity', '0.5');
                
            });


            $('body').on('change', 'select[data-field-type="model"]', function() {
                        var modelId = $(this).children('option:selected').data('id');
                        var model_value = $(this).children('option:selected').val();
                        // // // console.log(modelId);

                        formSelectedData['model'] = model_value;

                        
                        
                        
                         $html = "<option value=\"\">Select Series</option>";
                        $.each($models, function($key, $value){
                            if($value.id == modelId) {
                                var $years = $value.years.split(',');
                              
                                $.each($years, function($yKey,$yValue) {
                                    $html += " <option value=\"" + $yValue + "\" data-truck-type=\""+ $value.truck_type +"\" data-price=\"" + $value.price + "\">" + $yValue + "</option>";
                                })
                                    //$html += " <option value=\""2023"\" data-truck-type=\""Mid-Sized"\" data-price=\""6490.00"\">\"2023\"</option>";
                                
                                
                            }
                        });
                        if($('select[data-field-type="series"]').length > 0) {
                            $('select[data-field-type="series"]').html($html);
                        }
                       
                        formSelectedData['basePrice']= 0;
                                updateTotalPrice();

                    });


              $('body').on('change', 'select[data-field-type="series"]', function() { 
                var pricing = $(this).children('option:selected').attr('data-price');
                var truckType = $(this).children('option:selected').attr('data-truck-type');
                formSelectedData['truckType'] = truckType;
                // // console.log('2613');

                // console.log('2699',formSelectedData.truckType)
                        formSelectedData['basePrice']= parseFloat(pricing);

                         

                        // // console.log("pricing", pricing);
                        updateTotalPrice();

                        initializeSlick();
                            renderProducts();
              });       

            @foreach ($formLogics as $formLogic)
                @php
                    $formLogicParams = json_decode($formLogic->parameters, true);
                    $recipeTitle = $formLogic->recipe->title;
                @endphp
                @foreach ($form->steps as $index => $step)

                    enableNext("{{ $step['id'] }}");


                    @foreach ($step['fields'] as $field)

                        @if ($recipeTitle == 'make_model_dependancy' || $recipeTitle == 'model_year_dependancy')

                            $('#{{ $field['id'] }}').change(function() {


                                var truckType = $('#{{ $formLogicParams[2] }}').children(
                                        'option:selected')
                                    .data(
                                        'truck-type');
                                // // // console.log('truckType', truckType);
                                var price = $('#{{ $formLogicParams[2] }}').children('option:selected')
                                    .data(
                                        'price');
                                // // // console.log('base price', price);
                                formSelectedData['{{ $field['type'] }}'] = $(this).val();
                                formSelectedData['truckType'] = truckType;
                                formSelectedData['basePrice'] = parseFloat(price || 0);

                                // Check if this is the modified-suspension field
                                if ('{{ $field['id'] }}' === 'modified-suspension') {
                                    suspensionText = $(this).val() === 'yes' ? "Modified Suspension: Yes" :
                                        "Modified Suspension: No";
                                }

                                updateTotalPrice(); // Update price when base vehicle is selected
                                enableNext("{{ $step['id'] }}");
                            });
                        @else
                            enableNext("{{ $step['id'] }}");
                        @endif
                    @endforeach
                @endforeach
            @endforeach

            
            

            


            $('body').on('change', '[name="series"]', function () {
                // Find the nearest step container and enable its next button
                $(this).closest('.step').find('.next-btn').removeAttr('disabled').css('opacity', '1');
            });

            var current_image = '';
            var selected_color = '';
            var has_headboard = '';
            var has_canopy = '';
            var canopy_length = '';
            var has_tray = '';
            let selectedValues = [];



            @foreach ($form->steps as $index => $step)
                @foreach ($step['fields'] as $field)
                    @if (in_array($field['type'], ['make', 'model', 'series', 'select']))

                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ strtoupper($field['label']) }}';

                            $('#' + fieldId).on('change', function() {
                                const selectedOption = $(this).find('option:selected');
                                const selectedValue = selectedOption.val();

                                if (!selectedValue) return;

                                const newOption = {
                                    feild_id: fieldId,
                                    value: selectedValue,
                                    label: label
                                };

                                // // // console.log("new option select" , newOption)

                                const existingIndex = options.findIndex(opt => opt.feild_id ===
                                    fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                additionalData[label] = selectedValue;

                                formSelectedData[label.toLowerCase()] = selectedValue;
                                autoSaveOptions(options, submitguid, formId);

                                // // // console.log("options for all", options)
                            });
                        })();
                    @endif

                    {{--@if ($field['type'] === 'series')
                        $('select[name="series"]').on('change', function() {
                            initializeSlick();
                            renderProducts();
                        });
                    @endif--}}


                    @if ($field['type'] === 'colors')
                        @php $colorsCounter = 0; @endphp
                        @foreach ($field['colors'] as $color)
                            @php $colorsCounter++; @endphp

                            $(document).on('click', '#{{ $field['id'] }}-{{ $colorsCounter }}', function() {
                                var $this = $(this);
                                var step = $this.attr('data-step');
                                var label = $this.attr('data-label');
                                var label_parent = $this.attr('data-field-label');
                                
                                $('#imagePreview-' + step).attr('src', $this.attr('data-image'));
                                $('.color-selection').removeClass('selected');
                                $this.addClass('selected');
                                current_image = $this.attr('data-image');
                                selected_color = $('.color-selection.selected .color-text').text()
                                    .toLowerCase();

                                // Store all data attributes in selected data
                                var dataAttributes = {};
                                $.each(this.dataset, function(key, value) {
                                    dataAttributes[key] = value;
                                });

                                // Store full field data in selected data
                                formSelectedData['color'] = {
                                    name: selected_color,
                                    image: current_image,
                                    id: '{{ $field['id'] }}-{{ $colorsCounter }}',
                                    attributes: dataAttributes // Include all data attributes
                                };

                                const fieldId = '{{ $field['id'] }}';

                                const newOption = {
                                    feild_id: fieldId,
                                    value: selected_color,
                                    label: label_parent
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                autoSaveOptions(options, submitguid, formId);

                                updateTotalPrice(); // Update price after selection
                                enableNext('{{ $step['id'] }}');
                            });
                        @endforeach
                    @endif

                    @if ($field['type'] === 'headboard_radio')
                        @php $optionCounter = 0; @endphp
                        @foreach ($field['options'] as $option)
                            @php $optionCounter++; @endphp

                            $(document).on('click', '#{{ $field['id'] }}-{{ $optionCounter }}', function() {
                                var $this = $(this);
                                var title = $this.attr('data-title');
                                var step = $this.attr('data-step');
                                var color = $('.color-selection.selected .color-text').text().toLowerCase();
                                headboard_option = $this.find(".headboard-text").text();
                                has_headboard = $this.find('p').text();
                                // // console.log('has_headboard:', has_headboard); 
                                var imageContainer = $('#imagePreview-' + $this.attr('data-step'));

                                
                                if (!color || color === '') {
                                    color = 'black';
                                }
                                imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                $('.{{ $field['id'] }}-options').removeClass('selected-active');
                                $this.addClass('selected-active');

                                // Determine the correct price based on truck type
                                let selectedPrice = 0;
                                var truckType = formSelectedData['truckType'];
                                // console.log(truckType);

                                if (truckType === 'Mid-Sized') {
                                    selectedPrice = parseFloat($this.attr('data-mid-sized-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else if (truckType.toLowerCase() === 'Toyota-79'.toLowerCase()) {
                                    // console.log("2904");
                                    selectedPrice = parseFloat($this.attr('data-toyota-79-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else if (truckType === 'USA-Truck') {
                                    selectedPrice = parseFloat($this.attr('data-usa-truck-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else {
                                    selectedPrice = parseFloat($this.attr('data-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                }

                                has_headboard = $this.find('p').text();
                                current_image = $this.attr('data-' + color + '-image');

                                // Store all data attributes in selected data
                                var dataAttributes = {};
                                $.each(this.dataset, function(key, value) {
                                    dataAttributes[key] = value;
                                });

                                formSelectedData['headboard'] = {
                                    name: has_headboard,
                                    image: current_image,
                                    id: '{{ $field['id'] }}-{{ $optionCounter }}',
                                    step: $this.attr('data-step'),
                                    price: selectedPrice,
                                    attributes: dataAttributes, // Include all data attributes
                                    fitmentTime: parseFloat($this.attr('data-fitment-time') || 0)
                                };
                                // // // console.log(formSelectedData);

                                const fieldId = '{{ $field['id'] }}';
                                const newOption = {
                                    feild_id: fieldId,
                                    value: has_headboard,
                                    label: title
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                autoSaveOptions(options, submitguid, formId);

                                updateTotalPrice(); // Update price after selection
                                updateTotalTime();
                                enableNext('{{ $step['id'] }}');

                                 if (typeof renderExternalProducts === 'function') {
                                    renderExternalProducts();
                                }
                                initializeSlickExternal();
                            });

                            // @if ($optionCounter === 1)
                            //     $('#{{ $field['id'] }}-{{ $optionCounter }}').trigger('click');
                            // @endif
                        @endforeach
                    @endif

                    @if ($field['type'] === 'canopy_radio')
                        @php $optionCounter = 0; @endphp
                        @foreach ($field['options'] as $option)
                            @php $optionCounter++; @endphp

                            $(document).on('click', '#{{ $field['id'] }}-{{ $optionCounter }}', function() {
                                var $this = $(this);
                                var title = $this.attr('data-title');
                                var step = $this.attr('data-step');
                                var color = $('.color-selection.selected .color-text').text().toLowerCase();
                                var imageContainer = $('#imagePreview-' + $this.attr('data-step'));

                                // Determine the correct price based on truck type
                                let selectedPrice = 0;
                                var truckType = formSelectedData['truckType'];

                                // console.log("truckType: ",truckType );

                                if (truckType === 'Mid-Sized') {
                                    selectedPrice = parseFloat($this.attr('data-mid-sized-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else if (truckType.toLowerCase() === 'Toyota-79'.toLowerCase()) {
                                    selectedPrice = parseFloat($this.attr('data-toyota-79-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else if (truckType === 'USA-Truck') {
                                    selectedPrice = parseFloat($this.attr('data-usa-truck-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                } else {
                                    selectedPrice = parseFloat($this.attr('data-price') || 0);
                                    $this.attr('data-price', selectedPrice);
                                    $this.closest('.text-selection').find('.updated_price').text(
                                        selectedPrice);
                                }



                                // if (has_headboard == 'Yes, include Headboard' && (has_canopy == "" ||
                                //         ($this.find('p').text() == "No Canopy" && has_canopy == "No Canopy")
                                //     )) {
                                //     $this.attr('data-' + color + '-image', current_image);
                                //     imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                //     canopy_length = $this.attr('data-length');
                                //     // // // console.log(canopy_length);
                                // } else {
                                //     imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                //     canopy_length = $this.attr('data-length');
                                //     // // // console.log(canopy_length);
                                // }


                                // Determine the correct image key based on color and headboard
                                let imageKey = '';

                                if (!color || color === '') {
                                    color = 'black';
                                }
                                if (!has_headboard || has_headboard === '') {
                                    has_headboard = 'No Headboard';
                                }
 
 
                                    


                                if (color === 'black') {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'black-image-withheadboard' : 'black-image';
                                } else {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'white-image-withheadboard' : 'white-image';
                                }
                                // If headboard is included and either:
                                if (has_canopy === "" || ($this.find('p').text() === "No Canopy" && has_canopy === "No Canopy")) {

                                    if (!current_image || current_image === '') {
                                        current_image = $this.attr('data-' + imageKey);
                                    }
                                    // // console.log("image", current_image)
                                    $this.attr('data-' + imageKey, current_image);
                                    let selectedImage = $this.attr('data-' + imageKey);
                                    imageContainer.attr('src', selectedImage);
                                    canopy_length = $this.attr('data-length');
                                    current_image = selectedImage;

                                    // // // console.log('✅ Condition: current_image');
                                    // // // console.log('current_image image:', current_image);

                                } else {
                                    let selectedImage = $this.attr('data-' + imageKey);
                                    imageContainer.attr('src', selectedImage);
                                    canopy_length = $this.attr('data-length');
                                    current_image = selectedImage;

                                    // // // console.log('⚠️ Condition: condition new image');
                                    // // // console.log('Color:', color);
                                    // // // console.log('Has Headboard:', has_headboard);
                                    // // // console.log('Checking data attribute:', 'data-' + imageKey);
                                    // // // console.log('current_image image:', current_image);
                                }
                                // // // console.log("current image  in canopy", current_image);



                                $('.{{ $field['id'] }}-options').removeClass('selected-active');
                                $this.addClass('selected-active');

                                has_canopy = $this.find('p').text();
                                // // // console.log(has_canopy);
                                // current_image = $this.attr('data-' + color + '-image');

                                // Store the canopy selection with its price
                                formSelectedData['canopy'] = {
                                    name: has_canopy,
                                    image: current_image,
                                    id: '{{ $field['id'] }}-{{ $optionCounter }}',
                                    length: canopy_length,
                                    price: selectedPrice,
                                    fitmentTime: parseFloat($this.attr('data-fitment-time') || 0)
                                };

                                const fieldId = '{{ $field['id'] }}';
                                const newOption = {
                                    feild_id: fieldId,
                                    value: has_canopy,
                                    label: title
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                autoSaveOptions(options, submitguid, formId);

                             
                                

                                updateTotalPrice(); // Update price after selection
                                updateTotalTime();

                                initializeSlick();
                                renderProducts();


                                if (typeof initializeSlickExternal === 'function') {
                                    initializeSlickExternal();
                                }


                                if (typeof renderExternalProducts === 'function') {
                                    renderExternalProducts();
                                }


                                enableNext('{{ $step['id'] }}');


                            });
                        @endforeach
                    @endif


                    @if ($field['type'] === 'products' && strtolower($field['productType']) === 'internals')


                        // // // console.log("products",products);
                        // let internal_options = [];



                        initializeSlick();
                        renderProducts();
                        
                        const fieldId = "{{ $field['id'] }}";
                        const label = "{{ $field['label'] }}";
                       
                        function renderProducts() {
                            const container = $("#product-container");
                            container.empty(); // Clear previous items before rendering

                            let filteredProducts = products.filter(product => product.internal_external ===
                                "internal");

                            @php
                                $showHideLogics = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_hide_internal')->map(fn($logic) => json_decode($logic->parameters, true))->values();

                                $externalShowHideLogics = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_hide_external')->map(fn($logic) => json_decode($logic->parameters, true))->values();

                                $externalShowNotice = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_notice_external')->map(fn($logic) => json_decode($logic->parameters, true))->values();
                            @endphp

                            let showHideLogics = @json($showHideLogics);

                            // // // console.log('logics',showHideLogics);
                            let externalShowHideLogics = @json($externalShowHideLogics);
                            // // // console.log('logics',externalShowHideLogics);

                            let externalShowNotice = @json($externalShowNotice);

                            var canopyname = formSelectedData.canopy?.name || '';

                            
                           

                            // // // console.log("canopy name", canopyname)

                            let trucktype = formSelectedData['truckType'] || '';
                            // console.log(3170, "formSelectedData", formSelectedData);
                            // console.log(3171, "type- formSelectedData - canopyname", formSelectedData['canopyname'] );

                            // console.log(Object.keys(formSelectedData));



                            trucktype = trucktype.toLowerCase();
                            
                            
                            
                            // console.log(3189, "canopyname: " , canopyname, formSelectedData.canopy?.name || '');


                            filteredProducts.forEach((product, index) => {

                                let productName = product.name.toLowerCase();
                                let canopy = (canopyname || "").toLowerCase();
                                let shouldDisplay = true; // default to show
                                // // // console.log("Processing product:", productName);

                                const productLogics = showHideLogics.filter(logic => {
                                    const logicProductType = (logic[3] || "").toLowerCase();
                                    const logicProductName = (logic[4] || "").toLowerCase();
                                    return logicProductType === "internal" && logicProductName ===
                                        productName;
                                });

                                // console.log("productLogics", productLogics);

                                // If there's a "show" logic, default to HIDE unless truck type matches
                                const hasShowLogic = productLogics.some(logic => (logic[2] || "")
                                    .toLowerCase() === "show");

                                // console.log("hasShowLogic", hasShowLogic);
                                
                                if (hasShowLogic) {
                                    
                                    
                                    shouldDisplay = false; // Hide by default
                                    productLogics.forEach(logic => {
                                        let logicTruckType = (logic[1] || "").toLowerCase();
                                        let logicAction = (logic[2] || "").toLowerCase();
                                        // console.log(3201, "logicAction", logicAction);
                                         // console.log(3202, "logicTruckType", logicTruckType);
                                          // console.log(3203, "trucktype", trucktype);
                                        if (logicAction === "show" && logicTruckType ===
                                            trucktype) {
                                            shouldDisplay = true;
                                            // console.log(` Show ${productName} for truck type "${trucktype}"`);
                                        }
                                    });
                                } else {
                                    // If there's no "show" logic, check for "hide"
                                    productLogics.forEach(logic => {
                                        let logicTruckType = (logic[1] || "").toLowerCase();
                                        let logicAction = (logic[2] || "").toLowerCase();
                                        if (logicAction === "hide" && logicTruckType ===
                                            trucktype) {
                                            shouldDisplay = false;
                                             // console.log(` Hide ${productName} for truck type "${trucktype}"`);
                                        }
                                    });
                                }

                                if (!shouldDisplay) return;


                                // hide/show according to canopy
                                const productLogicscanopy = externalShowHideLogics.filter(logic => {
                                    const logicProductType = (logic[3] || "")
                                        .toLowerCase(); // NOTE: this is logic[3] not logic[2] in your structure
                                    const logicProductName = (logic[4] || "")
                                        .toLowerCase(); // and this is logic[4]
                                    return logicProductType === "internal" && logicProductName ===
                                        productName;
                                });

                                const showLogics = productLogicscanopy.filter(logic => (logic[2] || "")
                                    .toLowerCase() === "show");
                                const hideLogics = productLogicscanopy.filter(logic => (logic[2] || "")
                                    .toLowerCase() === "hide");

                                if (showLogics.length > 0) {
                                    // If any "show" logics exist, hide by default unless matched
                                    shouldDisplay = false;
                                    showLogics.forEach(logic => {
                                        const logicCanopy = (logic[1] || "").toLowerCase();
                                        if (logicCanopy === canopy) {
                                            shouldDisplay = true;
                                            // // // console.log(`✅ Show ${productName} for canopy "${canopy}"`);
                                        }
                                    });
                                } else {
                                    // No "show" logic, check for hide
                                    hideLogics.forEach(logic => {
                                        const logicCanopy = (logic[1] || "").toLowerCase();
                                        if (logicCanopy === canopy) {
                                            shouldDisplay = false;
                                            // // // console.log(`⛔ Hide ${productName} for canopy "${canopy}"`);
                                        }
                                    });
                                }

                                if (!shouldDisplay) return;


                                let matchingNotices = externalShowNotice.filter(notice => {
                                    const noticeCanopy = (notice[1] || "").toLowerCase();
                                    const noticeProduct = (notice[3] || "").toLowerCase();
                                    return noticeCanopy === canopy && noticeProduct === productName;
                                });

                                let noticeHTML = "";
                                if (matchingNotices.length > 0) {
                                    noticeHTML = `<div class="mb-2">`;
                                    matchingNotices.forEach(notice => {
                                        noticeHTML += `<p class="notice-card">${notice[2]}</p>`;
                                    });
                                    noticeHTML += `</div>`;
                                }



                                let existingProduct = internal_options.find(opt => opt.name === product
                                    .name);
                                let selectedQuantity = existingProduct ? existingProduct.quantity : 0;
                                let maxQuantity = product.quantity ||
                                    1; // ✅ Get max quantity from DB, default to 1 if NULL
                                let showQuantityControls = selectedQuantity > 1 && maxQuantity > 1 ? "" :
                                    "d-none"; // ✅ Show `- 1 +` only if max > 1
                                let showRemoveButton = selectedQuantity === 1 && maxQuantity === 1 ? "" :
                                    "d-none"; // ✅ Show "Remove" only if max = 1
                                let showAddButton = selectedQuantity === 0 ? "" :
                                    "d-none"; // ✅ Show "Add" when quantity is 0

                                let productHTML = `
                                    <div class="col product-item" data-index="${index}">
                                    <div class="card bg-secondary text-white product-card" data-name="${product.name}" data-fitment-time="${product.fitment_time}" data-max="${maxQuantity}">
                                        <p class="card-title mb-0">${product.name}</p>
                                        <div class="product-image-con product-image-con02">
                                        <img src="{{ asset('${product.image}') }}" class="card-img-top" alt="${product.name}">
                                            <span class="product-price-con card-text fw-bold me-2">+$${product.price}</span>
                                        </div>
                                         ${noticeHTML}
                                        <div class="select-quantity card-body text-center d-flex flex-column justify-content-between">
                                            <div class="d-flex align-items-center justify-content-center internal-increment-con">
                                                <div class="options-container ${showQuantityControls}">
                                                    <div class="quantity-control mt-2 d-flex justify-content-center align-items-center">
                                                        <button type="button" class="btn btn-sm btn-danger decrement" data-name="${product.name}"><span>-</span></button>
                                                        <span class="mx-2 fw-bold quantity-display">${selectedQuantity}</span>
                                                        <button type="button" class="btn btn-sm btn-success increment" data-name="${product.name}"><span>+</span></button>
                                                    </div>
                                                </div>
                                                <div class="add-remove-btn-outer">
                                                    <button type="button" class="btn btn-sm btn-info add-remove-btn add-btn ${showAddButton}" data-name="${product.name}">Add</button>
                                                    <button type="button" class="btn btn-sm btn-danger add-remove-btn remove-btn ${showRemoveButton}" data-name="${product.name}">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    `;

                                container.append(productHTML);
                            });


                            var canopySize = "";
                            var internalProductFields = [];
                            var canopyFields = [];
                            var logic_params = [];
                            @foreach ($formLogics as $formLogic)

                                @php
                                    $formLogicParams = json_decode($formLogic->parameters, true);

                                @endphp

                                @if ($formLogic->recipe->title == 'Canopy Length Capacity')

                                    logic_params = {!! $formLogic->parameters !!};
                                    internalProductFields = [];
                                    canopyFields = [];
                                    // console.log("logic: ", logic_params);
                                    // console.log("Canopy Length Capacity Logic exists in form");
                                    @php 
                                        $internalProductFields = [];
                                        $canopyFields =[];
                                    @endphp
                                    @foreach ($form->steps as $index => $step)
                                        @foreach ($step['fields'] as $field)
                                            @if($field["type"] == "canopy_radio") 
                                                canopyFields.push({!! json_encode($field) !!});
                                                @php
                                                    $canopyFields[] = $field;
                                                @endphp
                                                // console.log( @json($field));
                                            @elseif($field["type"] == "products" && $field["productType"] == "internals") 
                                                internalProductFields.push({!! json_encode($field) !!});
                                                // console.log( @json($field));
                                                @php
                                                    $internalProductFields[] = $field;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach

                                   
                                    @foreach($canopyFields as $canopyField)
                                        canopySize = $('.{{ $canopyField["id"] }}-options').first().find(".canopy-text").text().trim();
                                        // console.log(canopySize);
                                        $('body').on('click', `.{{ $canopyField["id"] }}-options`, function() {
                                            var $this = $(this);
                                            canopySize = $this.find(".canopy-text").text().trim();
                                             console.log(3400, canopySize);

                                            
                                        })
                                    @endforeach
                                
                                @endif
                            @endforeach


                            // ✅ Add Button Click
                            $(".add-btn").off("click").on("click", function() {

                               

                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                                let product = filteredProducts.find(p => p.name === productName);
                                let maxQuantity = parseInt(card.data("max"), 10);
                                let index = internal_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let optionsContainer = card.find(".options-container");
                                let removeBtn = card.find(".remove-btn");
                                var permittedLength = logic_params[formSelectedData.canopy.name];
                                var productLength = 0;
                                var depends_on_products = [];
                                var dependency_found = false;
                                
                                //depends_on_products
                                // console.log('3374', product);

                                if(product.depends_on_products == "" || product.depends_on_products == null) {

                                } else {
                                    depends_on_products = product.depends_on_products.split(",");
                                    // console.log('depends_on_products', depends_on_products);

                                    
                                    internal_options.forEach(function(value, key){
                                     
                                        // console.log('value.id', value.id);


                                       if (depends_on_products.includes(value.id.toString())) {
                                           dependency_found =  true;
                                        }
                                    });

                                    if(dependency_found == false) {
                                          Swal.fire({
                                                icon: '',
                                                title: '',
                                                text: 'You haven\'t selected a Fridge yet. Please choose a fridge  before adding '+product.name+'.',
                                                confirmButtonColor: '#3085d6'
                                            });

                                        return false
                                    }
                                }
                                
                                //foreach here...
                                internal_options.forEach(function(value, key){
                                    productLength += ((isNaN(value.length_units) ? 0 : parseFloat(value.length_units))  * value.quantity);
                                });

                                if(permittedLength <=0) {
                                    
                                    Swal.fire({
                                        icon: '',
                                        title: '',
                                        // text: {!! json_encode($messages[1]) !!},
                                        text: {!! json_encode($messages[1] ?? 'You are not allowed to add this product.') !!},

                                        confirmButtonColor: '#3085d6'
                                    });
                                    return false;
                                }
                                // console.log("permittedLength: ", permittedLength);
                                console.log ("productLength: ", productLength + parseFloat(product.length_units));
                                if(product.length_units == "" || product.length_units == null){
                                } else if(productLength + (isNaN(parseFloat(product.length_units)) ? 0 : parseFloat(product.length_units)) > permittedLength) {
                                    Swal.fire({
                                        icon: '',
                                        title: '',
                                        text: {!! json_encode($messages[2]) !!},
                                        confirmButtonColor: '#3085d6'
                                    });
                                    return false;
                                }

                                if (index === -1) {
                                    internal_options.push({
                                        name: productName,
                                        price: product.price,
                                        id: product.id,
                                        fitmentTime: product.fitment_time,
                                        quantity: 1,
                                        depends_on_products: product.depends_on_products,
                                        length_units: parseFloat(product.length_units),
                                    });

                                    $(this).addClass("d-none"); // Hide "Add"
                                    if (maxQuantity === 1) {
                                        removeBtn.removeClass("d-none"); // Show "Remove"
                                    } else {
                                        optionsContainer.removeClass("d-none"); // Show `- 1 +`
                                        quantityDisplay.text(1);
                                    }

                                    updateTotalPrice(); // Update price when adding internal product
                                    updateTotalTime(); // Update price when adding external product
                                }

                                // console.log(internal_options);
                                saveInternalOptions();
                            });

                            // ✅ Remove Button Click
                            $(".remove-btn").off("click").on("click", function() {
                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                                let index = internal_options.findIndex(opt => opt.name === productName);
                                let addBtn = card.find(".add-btn");

                                if (index !== -1) {
                                    internal_options.splice(index, 1);
                                    $(this).addClass("d-none"); // Hide "Remove"
                                    addBtn.removeClass("d-none"); // Show "Add"

                                    // Extract all existing IDs
                                    var existingIds = internal_options.map(function(item) {
                                        return item.id;
                                    });

                                    internal_options = $.grep(internal_options, function(item) {
                                        
                                        if (item.depends_on_products) {
                                            var requiredIds = item.depends_on_products.split(',').map(Number);
                                            for (var i = 0; i < requiredIds.length; i++) {
                                                if ($.inArray(requiredIds[i], existingIds) === -1) {
                                                    $(`.remove-btn[data-name="${item.name}"]`).addClass("d-none");
                                                    $(`.add-btn[data-name="${item.name}"]`).removeClass("d-none");
                                                    return false; // Exclude this item
                                                }
                                            }
                                        }
                                        return true; // Include this item
                                    });

                                    updateTotalPrice(); // Update price when removing internal product
                                    updateTotalTime(); // Update price when adding external product

                                    // console.log("3477",internal_options);
                                }
                                saveInternalOptions();
                            });

                            // ✅ Increment Quantity (Respect DB Limit)
                            $(".increment").off("click").on("click", function() {
                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                                let index = internal_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let maxQuantity = parseInt(card.data("max"), 10);

                                var permittedLength = logic_params[formSelectedData.canopy.name];
                                var productLength = 0;
                                // console.log(permittedLength);

                                

                                internal_options.forEach(function(value, key){
                                    productLength += (isNaN(value.length_units) ? 0 : parseFloat(value.length_units)) * value.quantity;
                                });

                                // console.log("productLength", productLength);
                                // console.log("internal_options[index].length_units: ", internal_options[index].length_units);
                                if(permittedLength <=0) {
                                    Swal.fire({
                                        icon: '',
                                        title: '',
                                        text: 'You haven\'t selected a canopy yet. Please choose a canopy before adding internal products.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                    return false;
                                }
                                if(internal_options[index].length_units == "" || internal_options[index].length_units == null){
                                } else if(productLength + parseFloat(internal_options[index].length_units) > permittedLength) {
                                    Swal.fire({
                                        icon: '',
                                        title: '',
                                        text: 'You have reached the maximum internal product capacity for your selected canopy. Please remove or reduce some internal products to add more.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                    return false;
                                }

                                

                                if (index !== -1 && internal_options[index].quantity < maxQuantity) {
                                    internal_options[index].quantity += 1;
                                    quantityDisplay.text(internal_options[index].quantity);

                                    updateTotalPrice(); // Update price when incrementing quantity
                                    updateTotalTime(); // Update price when adding external product
                                }
                                saveInternalOptions();
                            });

                            // ✅ Decrement Quantity
                            $(".decrement").off("click").on("click", function() {

                                // console.log(3487);
                                let card = $(this).closest(".product-card");
                                let productName = $(this).data("name");
                                let index = internal_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let optionsContainer = card.find(".options-container");
                                let addBtn = card.find(".add-btn");

                                if (index !== -1) {
                                    // console.log(3496);
                                    if (internal_options[index].quantity > 1) {
                                        // console.log(3498);
                                        internal_options[index].quantity -= 1;
                                        quantityDisplay.text(internal_options[index].quantity);

                                        updateTotalPrice(); // Update price when decrementing quantity
                                        updateTotalTime(); // Update price when adding external product
                                    }

                                    else if (internal_options[index].quantity === 1) {
                                        // console.log(3507);
                                        optionsContainer.addClass("d-none"); // Hide `- 1 +`
                                        addBtn.removeClass("d-none"); // Show "Add"
                                        var existingIds = internal_options.map(function(item) {
                                            return item.id;
                                        });


                                        // Filter the array and remove any element with unmet dependencies
                                        internal_options = $.grep(internal_options, function(item) {
                                            if (item.depends_on_products) {
                                                var requiredIds = item.depends_on_products.split(',').map(Number);
                                                // Check if all requiredIds are present in existingIds
                                                for (var i = 0; i < requiredIds.length; i++) {
                                                    if ($.inArray(requiredIds[i], existingIds) === -1) {
                                                        $(`.remove-btn[data-name="${item.name}"]`).addClass("d-none");
                                                        $(`.add-btn[data-name="${item.name}"]`).removeClass("d-none");
                                                        return false; // Remove this item
                                                    }
                                                }
                                            }
                                            return true; // Keep this item
                                        });


                                        index = internal_options.findIndex(opt => opt.name === productName);
                                        internal_options.splice(index, 1); // Remove from array


                                        
                                        updateTotalPrice(); // Update price when removing product
                                        updateTotalTime(); // Update price when adding external product
                                    }
                                }
                                saveInternalOptions();
                            });
                        }

                        renderProducts(); // Render products on page load

                        function saveInternalOptions() {
                            

                            // Remove previous entries for this field
                            options = options.filter(opt => opt.feild_id !== fieldId);

                            // Add one entry per product
                            internal_options.forEach(opt => {
                                options.push({
                                    feild_id: fieldId,
                                    label: label,
                                    value: `${opt.name} (${opt.quantity})`
                                });
                            });

                            autoSaveOptions(options, submitguid, formId);
                            // // // console.log("Options after internal update:", options);
                        }


                        function initializeSlick() {
                            let $slider = $('.internal-slider');

                            if ($slider.hasClass('slick-initialized')) {
                                $slider.slick('unslick'); // Destroy existing instance
                            }


                            setTimeout(function() {
                                $slider.slick({
                                    dots: false,
                                    infinite: false,
                                    loop: false,
                                    arrows: true,
                                    speed: 300,
                                    slidesToShow: 5,
                                    autoplay: false,
                                    slidesToScroll: 1,
                                    centerMode: false,
                                    centerPadding: '0',
                                    variableWidth: false, // Ensure full slides are shown
                                    responsive: [{
                                            breakpoint: 1200,
                                            settings: {
                                                centerMode: false,
                                                centerPadding: '0',
                                                slidesToShow: 3,
                                                variableWidth: false,
                                            }
                                        },
                                        {
                                            breakpoint: 991,
                                            settings: {
                                                slidesToShow: 2,
                                            }
                                        },
                                        {
                                            breakpoint: 768,
                                            settings: {
                                                slidesToShow: 1.5,
                                            }
                                        }
                                    ]
                                });
                            });
                        }
                    @endif

                    @if ($field['type'] === 'products' && strtolower($field['productType']) === 'external')

 
                        if (typeof renderExternalProducts === 'function') {
                            renderExternalProducts();
                        }
                        initializeSlickExternal();

                        // let external_options = []; // Store selected external options

                        function renderExternalProducts() {

                            
                            const container = $("#external-product-container");
                            container.empty(); // Clear previous items before rendering

                            let filteredProducts = products.filter(product => product.internal_external ===
                                "external");

                            @php
                                $externalShowHideLogics = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_hide_external')->map(fn($logic) => json_decode($logic->parameters, true))->values();

                                $externalShowNotice = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_notice_external')->map(fn($logic) => json_decode($logic->parameters, true))->values();

                                $showHideLogics = $formLogics->filter(fn($logic) => $logic->recipe->title === 'show_hide_internal')->map(fn($logic) => json_decode($logic->parameters, true))->values();
                            @endphp

                            let showHideLogics = @json($showHideLogics);
                            // // // console.log('logics',showHideLogics);

                            let trucktype = formSelectedData['truckType'] || '';
                            trucktype = trucktype.toLowerCase();
                            // // // console.log("🚚 Selected Truck Type:", trucktype);

                            let externalShowHideLogics = @json($externalShowHideLogics);
                            // // // console.log('logics',externalShowHideLogics);

                            let externalShowNotice = @json($externalShowNotice);
                            // // // console.log('logics',externalShowNotice);



                            let canopyname = formSelectedData.canopy?.name || '';
                            //    // // console.log("canopy name", canopyname)


                            filteredProducts.forEach((product, index) => {

                                
                                let productName = product.name.toLowerCase();
                                let canopy = (canopyname || "").toLowerCase();
                                let shouldDisplay = true;

                                if(productName == "headboard mounted spare wheel holder" && headboard_option.trim() != "Yes, include Headboard" ) {
                                    return;
                                }


                                // // // console.log("Processing product:", productName);

                                const productLogicshideshow = showHideLogics.filter(logic => {
                                    const logicProductType = (logic[3] || "").toLowerCase();
                                    const logicProductName = (logic[4] || "").toLowerCase();
                                    return logicProductType === "external" && logicProductName ===
                                        productName;
                                });

                                // If there's a "show" logic, default to HIDE unless truck type matches
                                const hasShowLogic = productLogicshideshow.some(logic => (logic[2] || "")
                                    .toLowerCase() === "show");

                                if (hasShowLogic) {
                                    shouldDisplay = false; // Hide by default
                                    productLogicshideshow.forEach(logic => {
                                        let logicTruckType = (logic[1] || "").toLowerCase();
                                        let logicAction = (logic[2] || "").toLowerCase();
                                        if (logicAction === "show" && logicTruckType ===
                                            trucktype) {
                                            shouldDisplay = true;
                                            // // // console.log(` Show ${productName} for truck type "${trucktype}"`);
                                        }
                                    });
                                } else {
                                    // If there's no "show" logic, check for "hide"
                                    productLogicshideshow.forEach(logic => {
                                        let logicTruckType = (logic[1] || "").toLowerCase();
                                        let logicAction = (logic[2] || "").toLowerCase();
                                        if (logicAction === "hide" && logicTruckType ===
                                            trucktype) {
                                            shouldDisplay = false;
                                            // // // console.log(` Hide ${productName} for truck type "${trucktype}"`);
                                        }
                                    });
                                }

                                if (!shouldDisplay) return;



                                const productLogics = externalShowHideLogics.filter(logic => {
                                    const logicProductType = (logic[3] || "")
                                        .toLowerCase(); // NOTE: this is logic[3] not logic[2] in your structure
                                    const logicProductName = (logic[4] || "")
                                        .toLowerCase(); // and this is logic[4]
                                    return logicProductType === "external" && logicProductName ===
                                        productName;
                                });

                                const showLogics = productLogics.filter(logic => (logic[2] || "")
                                    .toLowerCase() === "show");
                                const hideLogics = productLogics.filter(logic => (logic[2] || "")
                                    .toLowerCase() === "hide");

                                if (showLogics.length > 0) {
                                    // If any "show" logics exist, hide by default unless matched
                                    shouldDisplay = false;
                                    showLogics.forEach(logic => {
                                        const logicCanopy = (logic[1] || "").toLowerCase();
                                        if (logicCanopy === canopy) {
                                            shouldDisplay = true;
                                            // // // console.log(`✅ Show ${productName} for canopy "${canopy}"`);
                                        }
                                    });
                                } else {
                                    // No "show" logic, check for hide
                                    hideLogics.forEach(logic => {
                                        const logicCanopy = (logic[1] || "").toLowerCase();
                                        if (logicCanopy === canopy) {
                                            shouldDisplay = false;
                                            // // // console.log(` Hide ${productName} for canopy "${canopy}"`);
                                        }
                                    });
                                }

                                if (!shouldDisplay) return;


                                //notices
                                let matchingNotices = externalShowNotice.filter(notice => {
                                    const noticeCanopy = (notice[1] || "").toLowerCase();
                                    const noticeProduct = (notice[3] || "").toLowerCase();
                                    return noticeCanopy === canopy && noticeProduct === productName;
                                });

                                let noticeHTML = "";
                                if (matchingNotices.length > 0) {
                                    noticeHTML = `<div class="mb-2">`;
                                    matchingNotices.forEach(notice => {
                                        noticeHTML += `<p class="notice-card">${notice[2]}</p>`;
                                    });
                                    noticeHTML += `</div>`;
                                }


                                

                                let existingProduct = external_options.find(opt => opt.name === product
                                    .name);
                                let selectedQuantity = existingProduct ? existingProduct.quantity : 0;
                                let maxQuantity = product.quantity || 1;
                                let showQuantityControls = selectedQuantity > 1 && maxQuantity > 1 ? "" :
                                    "d-none";
                                let showRemoveButton = selectedQuantity === 1 && maxQuantity === 1 ? "" :
                                    "d-none";
                                let showAddButton = selectedQuantity === 0 ? "" : "d-none";

                                let productHTML = `
                                <div class="col product-item" data-index="${index}">
                                    <div class="card bg-secondary text-white product-card" data-name="${product.name}" data-fitment-time="${product.fitment_time}" data-max="${maxQuantity}">
                                        <p class="card-title mb-0">${product.name}</p>
                                        <div class="product-image-con product-image-con02">
                                            <img src="{{ asset('${product.image}') }}" class="card-img-top" alt="${product.name}">
                                            <span class="product-price-con card-text fw-bold me-2">+$${product.price}</span>
                                        </div>
                                          ${noticeHTML}
                                        <div class="select-quantity card-body text-center d-flex flex-column justify-content-between">
                                            <div class="d-flex align-items-center justify-content-center external-increment-con">
                                                <div class="options-container ${showQuantityControls}">
                                                    <div class="quantity-control mt-2 d-flex justify-content-center align-items-center">
                                                        <button type="button" class="btn btn-sm btn-danger decrement-external" data-name="${product.name}"><span>-</span></button>
                                                        <span class="mx-2 fw-bold quantity-display">${selectedQuantity}</span>
                                                        <button type="button" class="btn btn-sm btn-success increment-external" data-name="${product.name}"><span>+</span></button>
                                                    </div>
                                                </div>
                                                <div class="add-remove-btn-outer">
                                                    <button type="button" class="btn btn-sm btn-info add-remove-btn add-btn-external ${showAddButton}" data-name="${product.name}">Add</button>
                                                    <button type="button" class="btn btn-sm btn-danger add-remove-btn remove-btn-external ${showRemoveButton}" data-name="${product.name}">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;

                                container.append(productHTML);
                            });

                            var productRules = [];
                            @if(isset($productRules))
                                productRules = @json($productRules);
                            @endif

                            
                            // ✅ Add Button Click
                            $(document).off("click", ".add-btn-external").on("click", ".add-btn-external", function() {


                                console.log('3945');
                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                                let product = filteredProducts.find(p => p.name === productName);
                                let maxQuantity = parseInt(card.data("max"), 10);
                                let index = external_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let optionsContainer = card.find(".options-container");
                                let removeBtn = card.find(".remove-btn-external");
                                var productExists = false;
                                var exitQuery = false;

                                productRules.forEach(function(value, key){
                                    var quantity = 0;
                                    var allowed_products = value.allowed_products;
                                    /*// console.log('external_options', external_options);
                                    // console.log("product", product);
                                    // console.log("value", value);*/

                                    if (allowed_products.includes(product.id)) {
                                        // console.log("allowed_products", allowed_products);
                                        // console.log('Value exists');

                                        external_options.forEach(function(value1, key1){
                                            if(allowed_products.includes(value1.id)) {
                                                // console.log("value1: ", value1);
                                                quantity += value1.quantity;
                                                productExists = true;
                                            }
                                           
                                            
                                        });
                                    }

                                    if(productExists == true && value.max_total <= quantity ) {
                                        Swal.fire({
                                                icon: '',
                                                title: '',
                                                text: value.message,
                                                confirmButtonColor: '#3085d6'
                                            });
                                        $(this).removeClass("d-none");
                                        optionsContainer.addClass("d-none");
                                        exitQuery = true;
                                        throw 'exit';
                                        return false;
                                        
                                    }
                                });


                                // REAR LADDER RACK

                                // ROOF RACK WITHOUT ROPE RAILS
                                // ROOF RACK WITH ROPE RAILS
                                
                                if(exitQuery) {
                                    return false;
                                }


                                // console.log(3930, "has_canopy", has_canopy);

                                if(has_canopy == '800mm Long Canopy' || has_canopy == '1200mm Long Canopy' ) {

                                    if(productName == 'ROOF RACK WITHOUT ROPE RAILS' || productName == 'ROOF RACK WITH ROPE RAILS') {

                                        // console.log("external_options", external_options);

                                        //$needed_product = external_options.find(p => p.name === "REAR LADDER RACK");

                                        $needed_product =  external_options.find(
                                            p => p.name === "REAR LADDER RACK" || p.name === "REAR LADDER RACK (950mm High)"
                                        );
                                        if($needed_product == undefined) {

                                            Swal.fire({
                                                icon: '',
                                                title: '',
                                                text: `Please select the Rear Ladder Rack to add roof rack options for ${has_canopy}.`,
                                                confirmButtonColor: '#3085d6'
                                            });
                                            return false;
                                        }


                                    } else {
                                        
                                    }
                                    

                                } else if (has_canopy == '1650mm Long Canopy') {

                                } else {
                                   //return false; 
                                }

                                // console.log(3875);

                                if (index === -1) {
                                    external_options.push({
                                        name: productName,
                                        price: product.price,
                                        id: product.id,
                                        fitmentTime: product.fitment_time,
                                        quantity: 1
                                    });

                                    $(this).addClass("d-none");
                                    if (maxQuantity === 1) {
                                        removeBtn.removeClass("d-none");
                                    } else {
                                        optionsContainer.removeClass("d-none");
                                        quantityDisplay.text(1);
                                    }
                                }
                                updateTotalPrice(); // Update price when adding external product
                                updateTotalTime(); // Update price when adding external product
                                saveExternalOptions();
                            });
                        
                            // ✅ Remove Button Click
                          
                            $(document).off("click", ".remove-btn-external").on("click", ".remove-btn-external", function() {
                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                               
                                let index = external_options.findIndex(opt => opt.name === productName);
                                let addBtn = card.find(".add-btn-external");
                                let optionsContainer = card.find(".options-container");

                                if (index !== -1) {
                                    external_options.splice(index, 1);
                                    $(this).addClass("d-none");
                                    addBtn.removeClass("d-none");
                                    optionsContainer.addClass("d-none");
                                }

                                if(productName == 'REAR LADDER RACK') {
                                    $conditionalproduct = external_options.findIndex(p => p.name === "REAR LADDER RACK (950mm High)");
                                    if($conditionalproduct !== -1) {
                                    // console.log(4005, productName);
                                     $needed_product_1 = external_options.findIndex(p => p.name === "ROOF RACK WITHOUT ROPE RAILS");
                                     
                                     if($needed_product_1  >= 0) {
                                            external_options.splice($needed_product_1, 1);
                                            // console.log("$needed_product_1", $needed_product_1)
                                            $(`.add-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).removeClass("d-none");
                                            $(`.remove-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).addClass("d-none");
                                     }
                                    $needed_product_2 = external_options.findIndex(p => p.name === "ROOF RACK WITH ROPE RAILS");
                                      if($needed_product_2 >= 0) {
                                        external_options.splice($needed_product_2, 1);
                                        // console.log("$needed_product_2", $needed_product_2);
                                        $(`.add-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).removeClass("d-none");
                                        $(`.remove-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).addClass("d-none");
                                     }

                                     // ROOF RACK WITHOUT ROPE RAILS
                                    // ROOF RACK WITH ROPE RAILS

                                    }
                                }

                                 if(productName == 'REAR LADDER RACK (950mm High)') {
                                    $conditionalproduct = external_options.findIndex(p => p.name === "REAR LADDER RACK");
                                    if($conditionalproduct !== -1) {
                                    // console.log(4005, productName);
                                     $needed_product_1 = external_options.findIndex(p => p.name === "ROOF RACK WITHOUT ROPE RAILS");
                                     
                                     if($needed_product_1  >= 0) {
                                            external_options.splice($needed_product_1, 1);
                                            // console.log("$needed_product_1", $needed_product_1)
                                            $(`.add-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).removeClass("d-none");
                                            $(`.remove-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).addClass("d-none");
                                     }
                                    $needed_product_2 = external_options.findIndex(p => p.name === "ROOF RACK WITH ROPE RAILS");
                                      if($needed_product_2 >= 0) {
                                        external_options.splice($needed_product_2, 1);
                                        // console.log("$needed_product_2", $needed_product_2);
                                        $(`.add-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).removeClass("d-none");
                                        $(`.remove-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).addClass("d-none");
                                     }

                                     // ROOF RACK WITHOUT ROPE RAILS
                                    // ROOF RACK WITH ROPE RAILS

                                    }
                                }
                                updateTotalPrice();
                                updateTotalTime();
                                saveExternalOptions();
                            });

                            // ✅ Increment Quantity (Respect DB Limit)
                            $(".increment-external").off("click").on("click", function() {
                                let card = $(this).closest(".product-card");
                                let productName = card.data("name");
                                 let product = filteredProducts.find(p => p.name === productName);
                                let index = external_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let maxQuantity = parseInt(card.data("max"), 10);

                                var productExists = false;

                                if(has_canopy == '800mm Long Canopy' || has_canopy == '1200mm Long Canopy' ) {

                                    if(productName == 'ROOF RACK WITHOUT ROPE RAILS' || productName == 'ROOF RACK WITH ROPE RAILS') {

                                        // console.log("external_options", external_options);

                                        $needed_product = external_options.find(p => p.name === "REAR LADDER RACK");
                                        if($needed_product == undefined) {

                                            Swal.fire({
                                                icon: '',
                                                title: '',
                                                text: `Please select the Rear Ladder Rack to add roof rack options for ${has_canopy}.`,
                                                confirmButtonColor: '#3085d6'
                                            });
                                            return false;
                                        }


                                    } else {
                                        
                                    }
                                    

                                } else if (has_canopy == '1650mm Long Canopy') {

                                } else {
                                   return false; 
                                }

                                

                                productRules.forEach(function(value, key){
                                    var quantity = 0;
                                    var allowed_products = value.allowed_products;
                                    // console.log('external_options', external_options);
                                    // console.log("product", product);
                                    // console.log("value", value);

                                    if (allowed_products.includes(product.id)) {
                                        // console.log('Value exists');

                                        external_options.forEach(function(value1, key1){
                                            if(allowed_products.includes(value1.id)) {
                                                // console.log("value1: ", value1);
                                                quantity += value1.quantity;
                                                productExists = true;
                                            }
                                            
                                        });
                                    }

                                    if(productExists == true && value.max_total <= quantity ) {
                                        Swal.fire({
                                                icon: '',
                                                title: '',
                                                text: value.message,
                                                confirmButtonColor: '#3085d6'
                                            });

                                            throw 'exit';
                                        return false;
                                    }
                                });

                                // console.log(3957);

                                // console.log("$productRules", @json($productRules));

                                if (index !== -1 && external_options[index].quantity < maxQuantity) {
                                    external_options[index].quantity += 1;
                                    quantityDisplay.text(external_options[index].quantity);
                                }
                                updateTotalPrice();
                                updateTotalTime();
                                saveExternalOptions();
                            });

                            // ✅ Decrement Quantity
                            $(".decrement-external").off("click").on("click", function() {
                                let card = $(this).closest(".product-card");
                                let productName = $(this).data("name");
                                let index = external_options.findIndex(opt => opt.name === productName);
                                let quantityDisplay = card.find(".quantity-display");
                                let optionsContainer = card.find(".options-container");
                                let addBtn = card.find(".add-btn-external");
                                if (index !== -1) {
                                    if (external_options[index].quantity > 1) {
                                        external_options[index].quantity -= 1;
                                        quantityDisplay.text(external_options[index].quantity);
                                    }

                                    else if (external_options[index].quantity === 1) {
                                        optionsContainer.addClass("d-none");
                                        addBtn.removeClass("d-none");
                                        external_options.splice(index, 1);
                                    }
                                }


                                if(productName == 'REAR LADDER RACK') {

                                    // console.log(4005, productName);
                                     $needed_product_1 = external_options.findIndex(p => p.name === "ROOF RACK WITHOUT ROPE RAILS");
                                     
                                     if($needed_product_1  >= 0) {
                                            external_options.splice($needed_product_1, 1);
                                            // console.log("$needed_product_1", $needed_product_1)
                                            $(`.add-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).removeClass("d-none");
                                            $(`.remove-btn-external[data-name="ROOF RACK WITHOUT ROPE RAILS"]`).addClass("d-none");
                                     }
                                    $needed_product_2 = external_options.findIndex(p => p.name === "ROOF RACK WITH ROPE RAILS");
                                      if($needed_product_2 >= 0) {
                                        external_options.splice($needed_product_2, 1);
                                        // console.log("$needed_product_2", $needed_product_2);
                                        $(`.add-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).removeClass("d-none");
                                        $(`.remove-btn-external[data-name="ROOF RACK WITH ROPE RAILS"]`).addClass("d-none");
                                     }

                                     // ROOF RACK WITHOUT ROPE RAILS
                                    // ROOF RACK WITH ROPE RAILS


                                }

                                
                                updateTotalPrice();
                                updateTotalTime();
                                saveExternalOptions();
                            });
                        }

                        if (typeof renderExternalProducts === 'function') {
                            renderExternalProducts();
                        }

                        function saveExternalOptions() {
                            const fieldId = "{{ $field['id'] }}";
                            const label = "{{ $field['label'] }}";

                            // Remove previous entries for this field
                            options = options.filter(opt => opt.feild_id !== fieldId);

                            // Add one entry per product
                            external_options.forEach(opt => {
                                options.push({
                                    feild_id: fieldId,
                                    label: label,
                                    value: `${opt.name} (${opt.quantity})`
                                });
                            });

                            autoSaveOptions(options, submitguid, formId);
                            // // // console.log("Options after external update:", options);
                        }



                        function initializeSlickExternal() {
                            let $slider = $('#external-product-container');

                            if ($slider.length === 0 || $slider.children().length === 0) {
                                console.warn(
                                    "⚠️ No products found in #product-container-externals! Skipping Slick initialization."
                                );
                                return;
                            }

                            if ($slider.hasClass('slick-initialized')) {
                                $slider.slick('unslick'); // Destroy existing instance
                            }

                            setTimeout(function() {
                                $slider.slick({
                                    dots: false,
                                    infinite: false,
                                    arrows: true,
                                    speed: 300,
                                    slidesToShow: 5,
                                    autoplay: false,
                                    slidesToScroll: 1,
                                    centerMode: false,
                                    centerPadding: '0',
                                    variableWidth: false,
                                    responsive: [{
                                            breakpoint: 1200,
                                            settings: {
                                                centerMode: false,
                                                centerPadding: '0',
                                                slidesToShow: 3,
                                                variableWidth: false,
                                            }
                                        },
                                        {
                                            breakpoint: 991,
                                            settings: {
                                                slidesToShow: 2,
                                            }
                                        },
                                        {
                                            breakpoint: 768,
                                            settings: {
                                                slidesToShow: 1.5,
                                            }
                                        }
                                    ]
                                });
                            }); // Small delay ensures elements exist
                        }
                    @endif


                    @if ($field['type'] === 'tray_sides_radio')
                        @php $optionCounter = 0; @endphp
                        @foreach ($field['options'] as $option)
                            @php $optionCounter++; @endphp


                            $(document).on('click', '#{{ $field['id'] }}-{{ $optionCounter }}', function() {
                                var $this = $(this);
                                var title = $this.attr('data-title');
                                var step = $this.attr('data-step');
                                $('.{{ $field['id'] }}-options').each(function() {
                                    $(this).parent().hide();
                                });

                                var color = $('.color-selection.selected .color-text').text().toLowerCase();
                                var imageContainer = $('#imagePreview-' + $this.attr('data-step'));
                                // Determine image key
                                let imageKey = '';
                                if (color === 'black') {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'black-image-withheadboard' : 'black-image';
                                } else {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'white-image-withheadboard' : 'white-image';
                                }
                                let selectedImage = $this.attr('data-' + imageKey);

                                // // Update image
                                // imageContainer.attr('src', selectedImage);
                                // canopy_length = $this.attr('data-length');
                                // current_image = selectedImage;

                                // // // console.log('Color:', color);
                                // // // console.log('Has Headboard:', has_headboard);
                                // // // console.log('Image Key:', imageKey);
                                // // // console.log('current_image image:', current_image);

                                // // // console.log(3507, "text", $this.find('p').text());
                                // // // console.log(3508, "has_tray", has_tray);
                                // // // console.log(3509, "has_canopy", has_canopy);

                                has_tray = $this.find('p').text();
                                // // // console.log(3510, "condition check  ", has_canopy == '1200mm Long Canopy' && (has_canopy == "" ||
                                //         ($this.find('p').text() == "No Tray Sides" && has_tray == "No Tray Sides")
                                //         ));

                                if (has_canopy == 'No Canopy' && (has_canopy == "" ||
                                        ($this.find('p').text() == "No Tray Sides" && has_tray == "No Tray Sides")
                                        )) {

                                    // // // console.log(3513, "current_image", current_image);
                                    // $this.attr('data-' + color + '-image', current_image);
                                    imageContainer.attr('src', current_image);
                                    // // // console.log("current image  in tray", current_image);
                                    // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                    //imageContainer.attr('src', selectedImage);
                                    // let selectedImage = $this.attr('data-' + imageKey);
                                    // // Update image
                                    // imageContainer.attr('src', selectedImage);
                                    // canopy_length = $this.attr('data-length');
                                    // current_image = selectedImage;

                                    $('.{{ $field['id'] }}-options').each(function() {
                                        if ($(this).attr('data-length') == "0") {
                                            $(this).parent().show();

                                        } else if ($(this).attr('data-length') == "1800") {
                                            //// console.log('has_headboard: ',has_headboard);
                                            if(has_headboard == "Yes, include Headboard") {
                                                $(this).parent().show();
                                            }
                                            
                                        }
                                    });
                               
                                } else if (has_canopy == '800mm Long Canopy' && (has_canopy == "" ||
                                        ($this.find('p').text() == "No Tray Sides" && has_tray == "No Tray Sides")
                                        )) {
                                            
                                            imageContainer.attr('src', current_image);
                                    $this.attr('data-' + color + '-image', current_image);
                                    // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                    //imageContainer.attr('src', selectedImage);
                                    $('.{{ $field['id'] }}-options').each(function() {
                                        if ($(this).attr('data-length') == "0") {
                                            $(this).parent().show();

                                        } else if ($(this).attr('data-length') == "1000") {
                                            $(this).parent().show();
                                        }

                                    });
                            
                                } else if (has_canopy == '1200mm Long Canopy' && (has_canopy == "" ||
                                        ($this.find('p').text() == "No Tray Sides" && has_tray == "No Tray Sides")
                                        )) {
                                    imageContainer.attr('src', current_image);
                                    // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                    //imageContainer.attr('src', selectedImage);
                                    $('.{{ $field['id'] }}-options').each(function() {
                                        if ($(this).attr('data-length') == "0") {
                                            $(this).parent().show();

                                        } else if ($(this).attr('data-length') == "600") {
                                            $(this).parent().show();
                                        }

                                    });
                                } else if (has_canopy == '1650mm Long Canopy' && (has_canopy == "" ||
                                        ($this.find('p').text() == "No Tray Sides" && has_tray == "No Tray Sides")
                                        )) {
                                            imageContainer.attr('src', current_image);
                                    $this.attr('data-' + color + '-image', current_image);
                                    //imageContainer.attr('src', selectedImage);
                                    // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                    $('.{{ $field['id'] }}-options').each(function() {
                                        if ($(this).attr('data-length') == "0") {
                                            $(this).parent().show();

                                        }

                                    });
                                } else {
                                    // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                    imageContainer.attr('src', selectedImage);
                                    // // // console.log($this.attr(('data-' + color + '-image')));
                                    $('.{{ $field['id'] }}-options').each(function() {
                                        if (canopy_length == '0') {
                                            if ($(this).attr('data-length') == "0") {
                                                $(this).parent().show();

                                            } else if ($(this).attr('data-length') == "1800") {
                                                $(this).parent().show();
                                            }
                                        } else if (canopy_length == '800') {
                                            if ($(this).attr('data-length') == "0") {
                                                $(this).parent().show();

                                            } else if ($(this).attr('data-length') == "1000") {
                                                $(this).parent().show();
                                            }
                                        } else if (canopy_length == '1200') {
                                            if ($(this).attr('data-length') == "0") {
                                                $(this).parent().show();

                                            } else if ($(this).attr('data-length') == "600") {
                                                $(this).parent().show();
                                            }
                                        } else if (canopy_length == '1650') {
                                            if ($(this).attr('data-length') == "0") {
                                                $(this).parent().show();

                                            }
                                        }

                                    });

                                }
                                // // // console.log('Color:', color);
                                // // // console.log('Has Headboard:', has_headboard);
                                // // // console.log('Image Key:', imageKey);
                                // // // console.log('Selected image:', selectedImage);
                              

                                $('.{{ $field['id'] }}-options').removeClass('selected-active');
                                $this.addClass('selected-active');

                                has_tray = $this.find('p').text();
                                // Store the tray selection with its price based on truck type
                                let selectedPrice = 0;
                                var truckType = formSelectedData['truckType'];

                                if (truckType === 'Mid-Sized') {
                                    selectedPrice = parseFloat($this.attr('data-mid-sized-price') || 0);
                                } else if (truckType.toLowerCase() === 'Toyota-79'.toLowerCase()) {
                                    selectedPrice = parseFloat($this.attr('data-toyota-79-price') || 0);
                                } else if (truckType === 'USA-Truck') {
                                    selectedPrice = parseFloat($this.attr('data-usa-truck-price') || 0);
                                } else {
                                    selectedPrice = parseFloat($this.attr('data-price') || 0);
                                }

                                formSelectedData['tray'] = {
                                    name: has_tray,
                                    image: $this.attr('data-' + color + '-image'),
                                    id: '{{ $field['id'] }}-{{ $optionCounter }}',
                                    length: $this.attr('data-length'),
                                    price: selectedPrice, // Using the selected price based on truck type
                                    fitmentTime: parseFloat($this.attr('data-fitment-time') || 0)
                                };

                                const fieldId = '{{ $field['id'] }}';
                                const newOption = {
                                    feild_id: fieldId,
                                    value: has_tray,
                                    label: title
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                autoSaveOptions(options, submitguid, formId);

                                updateTotalPrice(); // Update price after selection
                                updateTotalTime();
                                enableNext('{{ $step['id'] }}');
                            });
                        @endforeach
                    @endif


                    @if ($field['type'] === 'custom_radio')
                        @php $optionCounter = 0; @endphp
                        @foreach ($field['options'] as $option)
                            @php $optionCounter++; @endphp

                            $(document).on('click', '#{{ $field['id'] }}-{{ $optionCounter }}', function() {
                                var $this = $(this);
                                var step = $this.attr('data-step');
                                var color = $('.color-selection.selected .color-text').text().toLowerCase();
                                var imageContainer = $('#imagePreview-' + $this.attr('data-step'));
                                // imageContainer.attr('src', $this.attr('data-' + color + '-image'));
                                $('.{{ $field['id'] }}-options').removeClass('selected-active');
                                $this.addClass('selected-active');
                                // // // console.log('custom radio');

                                let imageKey = '';
                                if (color === 'black') {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'black-image-withheadboard' : 'black-image';
                                } else {
                                    imageKey = (has_headboard === 'Yes, include Headboard') ? 'white-image-withheadboard' : 'white-image';
                                }

                                // // // console.log('Color:', color);
                                // // // console.log('Has Headboard:', has_headboard);
                                // // // console.log('Image Key:', imageKey);
                                // // // console.log('Checking data attribute:', 'data-' + imageKey);

                                // ✅ Get image source from the selected element
                                let selectedImage = $this.attr('data-' + imageKey);

                                if (!current_image || current_image === '') {
                                    current_image = selectedImage; // ✅ Fallback if not set
                                }

                                // ✅ Apply the image and other attributes
                                imageContainer.attr('src', selectedImage);
                                canopy_length = $this.attr('data-length');
                                current_image = selectedImage;

                                // // // console.log('Selected image:', selectedImage);

                                // Store the selected price based on truck type
                                let selectedPrice = 0;
                                var truckType = formSelectedData['truckType'];

                                if (truckType === 'Mid-Sized') {
                                    selectedPrice = parseFloat($this.attr('data-mid-sized-price') || 0);
                                } else if (truckType.toLowerCase() === 'Toyota-79'.toLowerCase()) {
                                    selectedPrice = parseFloat($this.attr('data-toyota-79-price') || 0);
                                } else if (truckType === 'USA-Truck') {
                                    selectedPrice = parseFloat($this.attr('data-usa-truck-price') || 0);
                                } else {
                                    selectedPrice = parseFloat($this.attr('data-price') || 0);
                                }

                                formSelectedData['custom_radio'] = {
                                    title: $this.attr('data-title'),
                                    name: $this.find('p').text(),
                                    image: $this.attr('data-' + color + '-image'),
                                    id: '{{ $field['id'] }}-{{ $optionCounter }}',
                                    price: selectedPrice, // Using the selected price based on truck type
                                    fitmentTime: parseFloat($this.attr('data-fitment-time') || 0)
                                };

                                const fieldId = '{{ $field['id'] }}';
                                const newOption = {
                                    feild_id: fieldId,
                                    value: $this.find('p').text(),
                                    label: $this.attr('data-title')
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                autoSaveOptions(options, submitguid, formId);

                                updateTotalPrice(); // Update price after selection
                                updateTotalTime();
                                enableNext('{{ $step['id'] }}');
                            });
                        @endforeach
                    @endif


                    @if ($field['type'] === 'text'  || $field['type'] === 'email')
                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ $field['label'] }}';

                            $('#' + fieldId).on('input', function() {
                                const inputValue = $(this).val().trim();
                                // // console.log('Input Value:', inputValue); 

                                const newOption = {
                                    feild_id: fieldId,
                                    value: inputValue,
                                    label: label
                                };

                                formSelectedData[fieldId] = {
                                    name: label,
                                    id: fieldId,
                                    value: inputValue, // Initial value will be empty
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id ===
                                    fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                    // ✅ Add/update field in additionalData
                                additionalData[label] = inputValue;

                                autoSaveOptions(options, submitguid, formId);
                                // // // console.log("Text field option updated:", newOption);
                                // // // console.log("Form Selected Data Updated:", formSelectedData);
                                // // // console.log("Additional Data Updated:", additionalData);
                            });
                        })();
                    @endif

                    @if ($field['type'] === 'textarea')
                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ $field['label'] }}';


                            $('#' + fieldId).on('input', function() {
                                const inputValue = $(this).val().trim();
                                // // // console.log('Input Value:', inputValue); 
                                if (!inputValue) return;

                                const newOption = {
                                    feild_id: fieldId,
                                    value: inputValue,
                                    label: label
                                };

                                
                                formSelectedData[fieldId] = {
                                    name: label,
                                    id: fieldId,
                                    value: inputValue, // Initial value will be empty
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id ===
                                    fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                additionalData[label] = inputValue;

                                autoSaveOptions(options, submitguid, formId);
                                // // // console.log("Text field option updated:", newOption);
                                // // // console.log("Form Selected Data Updated:", formSelectedData);
                                // // console.log("Additional Data Updated:", additionalData);
                            });
                        })();
                    @endif

                    @if ($field['type'] === 'checkbox')
                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ $field['label'] }}';

                            // Handle the checkbox change event
                            $('#' + fieldId).on('change', function() {
                                const isChecked = $(this).prop('checked'); // Get the checked status
                                // // // console.log('Checkbox checked:', isChecked);

                                // Initialize formSelectedData for the checkbox field if not already initialized
                                if (!formSelectedData[fieldId]) {
                                    formSelectedData[fieldId] = {
                                        name: label,
                                        id: fieldId,
                                        value: isChecked, // Set the initial value to the current checked status
                                    };
                                }
                                // // // console.log("Form Selected Data Updated:", formSelectedData);

                                // Update the formSelectedData with the new value (true or false)
                                formSelectedData[fieldId].value = isChecked;

                                // Prepare the new option data
                                const newOption = {
                                    feild_id: fieldId,
                                    value: isChecked ? 'checked' : 'unchecked', // Store as 'checked' or 'unchecked'
                                    label: label
                                };

                                additionalData[label] = isChecked ? 'Checked' : 'Unchecked';
                                // // console.log("Additional Data:", additionalData);

                                // Update or add the option to the options array
                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }
                                

                                // Auto-save the options after the checkbox value has changed
                                autoSaveOptions(options, submitguid, formId);

                                // Log the updated new option and formSelectedData for debugging
                                // // // console.log("Checkbox field option updated:", newOption);
                                // // // console.log("Form Selected Data Updated:", formSelectedData);
                            });
                        })();
                    @endif


                    @if ($field['type'] === 'radio')
                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ $field['label'] }}'; 

                            $('#' + fieldId).on('click', '.interest-option', function () {
                                const $thisButton = $(this);
                                const value = $thisButton.attr("data-value")?.trim();

                                if (!value) {
                                    console.warn("No value found on clicked button!");
                                    return;
                                }

                                // Toggle selected state
                                $thisButton.toggleClass('selected-interest');

                                // Get selected values inside this container
                                const $container = $('#' + fieldId);
                                const selectedValues = [];

                                $container.find('.interest-option.selected-interest').each(function () {
                                    const val = $(this).attr("data-value")?.trim();
                                    if (val && !selectedValues.includes(val)) {
                                        selectedValues.push(val);
                                    }
                                });

                                // Update formSelectedData
                                formSelectedData[fieldId] = {
                                    name: label,
                                    id: fieldId,
                                    value: selectedValues
                                };

                                // Update options
                                const newOption = {
                                    feild_id: fieldId,
                                    value: selectedValues.join(', '),
                                    label: label
                                };

                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                // Update additionalData
                                additionalData[label] = selectedValues;

                                // Auto-save
                                autoSaveOptions(options, submitguid, formId);

                                // // console.log("Selected in " + fieldId + ":", selectedValues);
                            });
                        })();
                    @endif

                    @if ($field['type'] === 'date')
                        (function() {
                            const fieldId = '{{ $field['id'] }}';
                            const label = '{{ $field['label'] }}';

                            // Handle the date input change event
                            $('#' + fieldId).on('input', function() {
                                let selectedDate = $(this).val(); // Get the selected date value
                                // // console.log('Selected Date:', selectedDate);

                                // If no date is selected, exit early
                                if (!selectedDate) return;

                                // Convert selectedDate to a Date object
                                const dateObj = new Date(selectedDate);

                                // Format the date as "DD-MMM-YYYY" with lowercase month
                                const formattedDate = dateObj.toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric'
                                }).replace(/([A-Z]+)/, function(match) {
                                    return match.toLowerCase();
                                }).replace(/ /g, '-');;

                                // // console.log('Formatted Date:', formattedDate);

                                // Initialize formSelectedData for the date field if not already initialized
                                if (!formSelectedData[fieldId]) {
                                    formSelectedData[fieldId] = {
                                        name: label,
                                        id: fieldId,
                                        value: formattedDate, // Set the formatted date value
                                    };
                                }

                                // // console.log("Form Selected Data Updated:", formSelectedData);

                                // Update the formSelectedData with the new formatted date
                                formSelectedData[fieldId].value = formattedDate;

                                // Prepare the new option data
                                const newOption = {
                                    feild_id: fieldId,
                                    value: formattedDate, // Store the formatted date
                                    label: label
                                };

                                // Update or add the option to the options array
                                const existingIndex = options.findIndex(opt => opt.feild_id === fieldId);
                                if (existingIndex !== -1) {
                                    options[existingIndex] = newOption;
                                } else {
                                    options.push(newOption);
                                }

                                additionalData[label] = formattedDate;
                                // // console.log("Additional Data Updated:", additionalData);
                                // Auto-save the options after the date value has changed
                                autoSaveOptions(options, submitguid, formId);

                                // Log the updated new option and formSelectedData for debugging
                                // // console.log("Date field option updated:", newOption);
                                // // console.log("Form Selected Data Updated:", formSelectedData);
                            });
                        })();
                    @endif


                @endforeach
            @endforeach



            $(document).on('focus', '.number', function() {
                $(this).inputmask("(999) 999-9999");
            });

            // Apply email mask
            $(document).on('focus', '.email', function() {
                $(this).inputmask({
                    alias: "email"
                });
            });

      



            let currentStep = 0;
            const steps = $(".steps-outer-main");
            const progressBar = $(".progress-bar");

            function showStep(step) {
                steps.hide();
                $(steps[step]).fadeIn();
                $(".nav-link").removeClass("nav-link-active");
                $(".nav-link").eq(step).addClass("nav-link-active");

                var totalWidth = 0;

                $(".nav-link").each(function() {
                    totalWidth += $(this).outerWidth(true); // true includes margin
                    if ($(this).hasClass('nav-link-active')) {
                        return false;
                    }
                });

                //// // console.log("totalWidth", totalWidth);
                var progressPercentage = (((step + 1) / steps.length) * 100) + 0.5;
                //progressBar.css("width", progressPercentage + "%");
                progressBar.css("width", totalWidth + "px");


                if (step === 0) {
                    $(".back-btn").not(".reload-btn").css("visibility", "hidden");
                } else {
                    $(".back-btn").not(".reload-btn").css("visibility", "visible");
                }

            }

               


            $(".next-btn").click(function() {

                    if($('.internal-slider').length > 0) {
                         initializeSlick();
                            if (typeof initializeSlickExternal === 'function') {
                                initializeSlickExternal();
                            }
                    }
                

                // // console.log(4328)
                var $this = $(this);
                var target_step = $this.data("target-step");
                var next_step = $this.data("next-step");
                // // // console.log(target_step);
                // // // console.log("options",options);
                // // // console.log(formSelectedData);


                if (currentStep < steps.length - 1) {
                    let nextStep = currentStep + 1;

                    while (nextStep < steps.length && $(steps[nextStep]).hasClass('logic-step')) {
                        nextStep++;
                    }

                    if (nextStep < steps.length) {
                        currentStep = nextStep;
                        showStep(currentStep);
                        updateProgressMobile(currentStep);
                    }
                }

                //    autoSaveOptions(options, submitguid, formId);

                //initializeSlick();
                //initializeSlickExternal();
                // // console.log("4353");
                // For each step, check and update relevant data
                @foreach ($form->steps as $index => $step)
                    @foreach ($step['fields'] as $field)
                        @if ($field['type'] === 'summary')
                            // When going to summary page
                            if (next_step == '{{ $step['id'] }}') {
                                $("#dynamic-summary").empty(); // Clear the table
                                $("#dynamic-summary-card").empty(); // Clear the table
                                updateSummaryTable(); // Populate with current data
                            }
                        @endif
                    @endforeach
                @endforeach

                @foreach ($form->steps as $index => $step)
                    @foreach ($step['fields'] as $field)


                        @if ($field['type'] == 'colors')
                            if (next_step == '{{ $step['id'] }}') {
                                @php
                                    $optionCounter = 0;
                                @endphp
                                @foreach ($field['colors'] as $option)
                                    @php $optionCounter++; @endphp

                                    @if ($optionCounter === 1)
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}').trigger('click');
                                    @endif
                                @endforeach
                            }
                        @endif


                        @if ($field['type'] == 'headboard_radio')
                            if (next_step == '{{ $step['id'] }}') {
                                @php
                                    $optionCounter = 0;
                                    // print_r($field);
                                    // die();
                                @endphp
                                var priceAttribute = '';
                                @foreach ($field['options'] as $option)
                                    @php $optionCounter++; @endphp

                                    @if ($optionCounter === 1)
                                        // // // console.log(
                                        //     '{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options'
                                        // );
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options')
                                            .trigger('click');
                                    @endif

                                    // // // console.log(formSelectedData['truckType']);


                                    priceAttribute = formSelectedData['truckType'] === 'Mid-Sized' ?
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-mid-sized-price') :
                                        formSelectedData['truckType'].toLowerCase() === 'Toyota-79'.toLowerCase() ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-toyota-79-price') :
                                        formSelectedData['truckType'] === 'USA-Truck' ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-usa-truck-price') : null;


                                    $('#{{ $field['id'] }}-{{ $optionCounter }}').closest(
                                        '.text-selection').find('.updated_price').text(priceAttribute);
                                @endforeach
                            }
                        @endif

                        @if ($field['type'] === 'canopy_radio')
                            if (next_step == '{{ $step['id'] }}') {

                                @php $optionCounter = 0; @endphp
                                var priceAttribute = '';
                                
                                @foreach ($field['options'] as $option)
                                
                                    @php $optionCounter++; @endphp
                                    @if ($optionCounter === 1)
                                        // // // console.log(
                                        //     '{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options'
                                        // );

                                        $('#{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options')
                                            .trigger('click');

                                        
                                    @endif

                                    

                                    priceAttribute = formSelectedData['truckType'] === 'Mid-Sized' ?
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-mid-sized-price') :
                                        formSelectedData['truckType'].toLowerCase() === 'Toyota-79'.toLowerCase() ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-toyota-79-price') :
                                        formSelectedData['truckType'] === 'USA-Truck' ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-usa-truck-price') : null;


                                    $('#{{ $field['id'] }}-{{ $optionCounter }}').closest(
                                        '.text-selection').find('.updated_price').text(priceAttribute);
                                @endforeach
                            }
                        @endif


                        @if ($field['type'] === 'tray_sides_radio')
                            if (next_step == '{{ $step['id'] }}') {

                                @php $optionCounter = 0; @endphp
                                var priceAttribute = '';

                                @foreach ($field['options'] as $option)
                                    @php $optionCounter++; @endphp
                                    @if ($optionCounter === 1)
                                        // // // console.log(
                                        //     '{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options'
                                        // );

                                        $('#{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options')
                                            .trigger('click');
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options')
                                            .trigger('click');
                                    @endif


                                    priceAttribute = formSelectedData['truckType'] === 'Mid-Sized' ?
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-mid-sized-price') :
                                        formSelectedData['truckType'].toLowerCase() === 'Toyota-79'.toLowerCase() ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-toyota-79-price') :
                                        formSelectedData['truckType'] === 'USA-Truck' ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-usa-truck-price') : null;


                                    $('#{{ $field['id'] }}-{{ $optionCounter }}').closest(
                                        '.text-selection').find('.updated_price').text(priceAttribute);
                                @endforeach
                            }
                        @endif

                        @if ($field['type'] == 'custom_radio')
                            if (next_step == '{{ $step['id'] }}') {
                                @php
                                    $optionCounter = 0;

                                @endphp
                                var priceAttribute = '';

                                @foreach ($field['options'] as $option)
                                    @php $optionCounter++; @endphp
                                    @if ($optionCounter === 1)
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}.{{ $field['id'] }}-options')
                                            .trigger('click');
                                    @endif

                                    priceAttribute = formSelectedData['truckType'] === 'Mid-Sized' ?
                                        $('#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-mid-sized-price') :
                                        formSelectedData['truckType'].toLowerCase() === 'Toyota-79'.toLowerCase() ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-toyota-79-price') :
                                        formSelectedData['truckType'] === 'USA-Truck' ? $(
                                            '#{{ $field['id'] }}-{{ $optionCounter }}').attr(
                                            'data-usa-truck-price') : null;

                                    $('#{{ $field['id'] }}-{{ $optionCounter }}').closest(
                                        '.text-selection').find('.updated_price').text(priceAttribute);
                                @endforeach
                            }
                        @endif
                    @endforeach
                @endforeach
            });


            $(".back-btn").click(function() {
                var $this = $(this);
                var target_step = $this.data("target-step");
                var next_step = $this.data("next-step");
                if (currentStep > 0) {
                    let prevStep = currentStep - 1;

                    while (prevStep >= 0 && $(steps[prevStep]).hasClass('logic-step')) {
                        prevStep--;
                    }

                    if (prevStep >= 0) {
                        currentStep = prevStep;
                        showStep(currentStep);
                        updateProgressMobile(currentStep);
                    };
                }
                initializeSlick();
                initializeSlickExternal();


                @foreach ($form->steps as $index => $step)
                    @foreach ($step['fields'] as $field)

                        @if ($field['type'] == 'headboard_radio')
                            if (target_step == '{{ $step['id'] }}') {

                                var priceAttribute = '';
                                @foreach ($field['options'] as $option)

                                    formSelectedData['headboard'] = {};

                                    updateTotalPrice();
                                @endforeach
                            }
                        @endif

                        @if ($field['type'] === 'canopy_radio')
                            if (target_step == '{{ $step['id'] }}') {

                                @foreach ($field['options'] as $option)

                                    formSelectedData['canopy'] = {};

                                    updateTotalPrice();
                                @endforeach
                            }
                        @endif


                        @if ($field['type'] === 'tray_sides_radio')
                            if (target_step == '{{ $step['id'] }}') {

                                @foreach ($field['options'] as $option)
                                    formSelectedData['tray'] = {};

                                    updateTotalPrice();
                                @endforeach
                            }
                        @endif

                        @if ($field['type'] === 'products' && strtolower($field['productType']) === 'internals')
                            if (target_step == '{{ $step['id'] }}') {

                                internal_options = [];

                                updateTotalPrice();
                                initializeSlick();
                                renderProducts();
                            }
                        @endif


                        @if ($field['type'] === 'products' && strtolower($field['productType']) === 'external')
                            if (target_step == '{{ $step['id'] }}') {

                                external_options = [];

                                updateTotalPrice();

                                if (typeof initializeSlickExternal === 'function') {
                                    initializeSlickExternal();
                                }


                                if (typeof renderExternalProducts === 'function') {
                                    renderExternalProducts();
                                }
                            }
                        @endif

                        @if ($field['type'] == 'custom_radio')
                            if (target_step == '{{ $step['id'] }}') {


                                @foreach ($field['options'] as $option)
                                    formSelectedData['custom_radio'] = {};

                                    updateTotalPrice();
                                @endforeach
                            }
                        @endif
                    @endforeach
                @endforeach

            });

            showStep(currentStep);

            let additionalData = {};

            // $(document).ready(function () {
            //                 const fieldIdradio = "{{-- $field['id'] --}}";
            //                 const labelradio = "{{-- $field['label'] --}}";
            //                 const containerradio = $('div[data-field-id="{{-- $field['id'] --}}"]'); // scoped container


            //                 containerradio.on('click', '.interest-option', function () {
            //                     $(this).toggleClass('selected-interest');

            //                     let value = $(this).attr("data-value")?.trim();
            //                     if (!value) {
            //                         console.warn("No value found on clicked button!");
            //                         return;
            //                     }

            //                     selectedValues = [];
            //                     containerradio.find('.interest-option.selected-interest').each(function () {
            //                         let val = $(this).attr("data-value")?.trim();
            //                         if (val && !selectedValues.includes(val)) {
            //                             selectedValues.push(val);
            //                         }
            //                     });

            //                     selectedInterests = selectedValues;

            //                     const newOption = {
            //                         feild_id: fieldIdradio,
            //                         value: selectedValues.join(', '),
            //                         label: labelradio
            //                     };

            //                     additionalData[labelradio] = selectedValues.join(', ');

            //                     const existingIndex = options.findIndex(opt => opt.feild_id === fieldIdradio);
            //                     if (existingIndex !== -1) {
            //                         options[existingIndex] = newOption;
            //                     } else {
            //                         options.push(newOption);
            //                     }

            //                     autoSaveOptions(options, submitguid, formId);
            //                     // // console.log("Selected values:", selectedValues);
            //                     // // console.log("Options:", options);
            //                 });
            //             });

        

            $(".submit-btn").click(function(e) {
            
                e.preventDefault(); // prevent form submission
                $('.loader-outer').show();
                let summaryData = [];
                
                $("#dynamic-summary tr").each(function() {
                    let $row = $(this);

                    let image = $row.find("img").attr("src") || "";
                    let description = $row.find(".description-cls").text().trim();
                    let price = $row.find("td").eq(2).text().trim();
                    let quantity = $row.find(".quantity").text().trim() || "1";
                    let total = $row.find("td").eq(4).text().trim();
                    let fitmentTime = $row.find(".fitmentTime-cls").text().trim();

                    summaryData.push({
                        description: description,
                        price: price,
                        quantity: quantity,
                        total: total,
                        fitmentTime: fitmentTime
                    });
                });

                // // // console.log("Summary Data:", summaryData);

                // let additionalData = {};

                // $("input, textarea, select, input[type='radio']").each(function() {

                //     if ($(this).is(":hidden")) {
                //         return true; // Skip this iteration for hidden elements
                //     }

                //     let name = $(this).attr("name");
                //     let value = $(this).val();

                //     // For <select> elements, skip if no value is selected or if value is empty
                //     if ($(this).is("select") && (value === null || value === undefined || value === "")) {
                //         return true; // Skip this iteration for unselected <select> elements
                //     }

                //     // Safely apply trim to non-null and non-undefined values
                //     if (value !== null && value !== undefined) {
                //         value = value.trim();
                //     }

                //     // For checkboxes, handle checked state
                //     if ($(this).is(":checkbox")) {
                //         value = $(this).is(":checked") ? "Checked" : "Unchecked"; // 'on' if checked, 'off' if not
                //     }

                //     if ($(this).is(":radio") && $(this).is(":checked")) {
                //         let mainLabel = $("label[for='" + $(this).attr('name') + "']").first().text().trim();
                //         let selectedOptionLabel = $(this).closest("label").text().trim();
                //         additionalData[mainLabel] = selectedOptionLabel;
                //     }

                //     // Add the field's data to additionalData if a value exists (except for radio buttons)
                //     if (value && !$(this).is(":radio")) {
                //         additionalData[name] = value;
                //     }
                // });


                // // console.log("📋 Additional Data:", additionalData);

                //     // ✅ Console the selected interests separately (if exists)
                // // // console.log("options", options);

                // // Output the JSON
                // // // console.log(JSON.stringify(summaryData, null, 4));

                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                let isValid = true;
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Clear all previous errors
                $(".error-message").text("");
                $(".is-invalid").removeClass("is-invalid");

                // ✅ Validate all input, textarea, and select fields except make/model/year
                $(".user-form-fields-con input, .user-form-fields-con textarea").each(function () {
                    const $el = $(this);
                    const name = $el.attr("name")?.toLowerCase();
                    const value = $el.val()?.trim();
                    const tag = $el.prop("tagName").toLowerCase();
                    const type = $el.attr("type");

                    // Skip checkboxes (handled separately)
                    if (type === 'checkbox') return;

                    // Skip make/model/year selects
                    if (tag === 'select' && ['make', 'model', 'series'].includes(name)) return;

                    // Validate empty fields
                    if (!value) {
                        isValid = false;
                        $el.addClass("is-invalid");
                        $el.closest(".form-group").find(".error-message").text("This field is required.");
                        return;
                    } else {
                        $el.removeClass("is-invalid");
                        $el.closest(".form-group").find(".error-message").text("");
                    }

                    // Email-specific format validation
                    if (type === 'email' || name === 'email') {
                        if (!emailRegex.test(value)) {
                            isValid = false;
                            $el.addClass("is-invalid");
                            $el.closest(".form-group").find(".error-message").text("Please enter a valid email address.");
                        }
                    }
                });

                // Validate Terms & Conditions checkbox IF it exists
                //const checkbox = $("input[name='agree']");
                const checkbox = $("input[data-terms='terms-checkbox']");
                if (checkbox.length) {
                    if (!checkbox.is(":checked")) {
                        isValid = false;
                        checkbox.addClass("is-invalid");
                        checkbox.closest(".form-check").find(".error-message").text("You must agree to the Terms and Conditions.");
                    } else {
                        checkbox.removeClass("is-invalid");
                        checkbox.closest(".form-check").find(".error-message").text("");
                    }
                }


                if (!isValid) {
                    $('.loader-outer').hide();
                    return;
                }


                // // console.log("clcik worked") ;

                var formSlug = $('#form-slug').val();

                var email = additionalData.email || $('input[type="email"]').val() || null;
                // // console.log("Email:", email);


                // Create a complete payload with all data
                const payload = {
                    summary: summaryData,
                    // summary: encodeURIComponent(JSON.stringify(summaryData)),
                    interests: selectedInterests,
                    additional_data: additionalData,
                    email: email,
                    form_slug: formSlug,
                    // formId: formId,
                    submitguid: submitguid,
                    // options: options
                };
                autoSaveOptions(options, submitguid, formId);


                // Stringify the entire payload
                const stringifiedPayload = JSON.stringify(payload);

                // // // console.log("Payload being sent:", stringifiedPayload);



                
                $.ajax({
                    // url: '/send-summary-email',
                    url: "{{ route('send.summary.email') }}",
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        // "Content-Type": "application/json" // Important when sending JSON data

                    },
                    // data: {
                    //     summary: summaryData,
                    //     interests: selectedInterests,
                    //     additional_data: additionalData,
                    //     email: additionalData.email, // or wherever email is in your form
                    //     form_slug: formSlug,
                    //     formId: formId,
                    //     submitguid: submitguid,
                    //     options: options,
                    // },
                    data: payload,

                    success: function(res) {

                        $('.step').hide();
                        $('.nav-container').hide();
                        $('.great-work').show();
                        $('.loader-outer').hide();
                        
                        
                        //console.log('est-price: ' ,totalPrice);
                        
                        
                        fbq('track', 'Builder Purchase', {
                            eventID : 'builder_' + Date.now(),  // simple unique ID
                            value   : totalPrice || 0, // if your API returns a price
                            currency: 'AUD'
                        });
                        /*Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '✅ Email sent successfully!',
                            confirmButtonColor: '#3085d6'
                        });*/


                    },
                    error: function(err) {
                        $('.loader-outer').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '❌ Failed to send email. Please try again.',
                            confirmButtonColor: '#d33'
                        });
                        console.error(err);
                    }

                });

                


                // Optional: Display in an alert or modal
                // alert(JSON.stringify(summaryData, null, 4));

                // If you want to also show it inside a div:
                // $("#json-output").text(JSON.stringify(summaryData, null, 4));
            });

            // Reload button only - prevent it from triggering back button logic
            $(".reload-btn").click(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                location.reload();
            });


            function autoSaveOptions(options, submitguid, formid) {
                $.ajax({
                    url: '/form/autosave',
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        options: options,
                        submitguid: submitguid,
                        formId: formId
                    },
                    success: function(response) {
                        // // // console.log('Auto-saved:', response);
                    },
                    error: function(err) {
                        console.error('Auto-save failed:', err);
                    }
                });
            }

            // $(".download-pdf-btn").on("click", async function () {
            //     const $btn = $(this);
            //     const originalText = $btn.html();
            //     $btn.prop("disabled", true).css("opacity", "0.6").html('<i class="fas fa-file-pdf"></i> Downloading...');

            //     const { jsPDF } = window.jspdf;
            //     const doc = new jsPDF();

            //     // Step 1: Extract and preload image data + dimensions
            //     const summaryData = await Promise.all(
            //         $("#dynamic-summary tr").map(async function () {
            //             const $row = $(this);

            //             const imageSrc = $row.find("img").attr("src") || "";
            //             let base64Image = "";
            //             let imgWidth = 1, imgHeight = 1;

            //             if (imageSrc) {
            //                 try {
            //                     const result = await toBase64WithSize(imageSrc);
            //                     base64Image = result.base64;
            //                     imgWidth = result.width;
            //                     imgHeight = result.height;
            //                 } catch (err) {
            //                     console.warn("Image load failed", imageSrc, err);
            //                 }
            //             }

            //             const description = $row.find(".description-cls").text().trim();
            //             const price = $row.find("td").eq(2).text().trim();
            //             const quantity = $row.find(".quantity").text().trim() || "1";
            //             const total = $row.find("td").eq(4).text().trim();
            //             const fitmentTime = $row.find(".fitmentTime-cls").text().trim();

            //             if (description) {
            //                 return {
            //                     imageSrc: base64Image,
            //                     imgWidth,
            //                     imgHeight,
            //                     description,
            //                     price,
            //                     quantity,
            //                     total,
            //                     fitmentTime
            //                 };
            //             }

            //             return null;
            //         }).get()
            //     ).then(rows => rows.filter(Boolean));

            //     // Step 2: Prepare table data
            //     const body = summaryData.map(item => [
            //         '', // image placeholder
            //         item.description,
            //         item.price.replace(/\$\s*/g, '$').replace(/\.00\b/, ''),
            //         item.quantity,
            //         item.total.replace(/\$\s*/g, '$'),
            //         item.fitmentTime
            //     ]);

            //     let totalPrice = 0;
            //     let totalFitment = 0;
            //     let totalFinal = 0;

            //     summaryData.forEach(item => {
            //         const price = parseFloat(item.price.replace(/[^0-9.]/g, '')) || 0;
            //         const final = parseFloat(item.total.replace(/[^0-9.]/g, '')) || 0;
            //         const fitment = parseFloat(item.fitmentTime.replace(/[^0-9.]/g, '')) || 0;

            //         totalPrice += price;
            //         totalFinal += final;
            //         totalFitment += fitment;
            //     });

            //     const logoBase64 = await convertSvgToPngBase64("{{ asset('images/tus-logo-new.svg') }}");

            //     // Step 3: Draw PDF
            //     doc.autoTable({
            //         head: [['Image', 'Description', 'Price', 'Quantity', 'Total', 'Fitment Time']],
            //         body: body,
            //         foot: [[
            //             'Total', '', '', '',
            //             `$${totalFinal.toFixed(2)}`,
            //             `${totalFitment.toFixed(2)} Hrs`
            //         ]],
            //         showFoot: 'lastPage',
            //         theme: 'grid',
            //         startY: 20,
            //         styles: {
            //             fontSize: 10,
            //             cellPadding: 3,
            //             minCellHeight: 25,
            //             halign: 'center',
            //             valign: 'middle',
            //             fillColor: [255, 255, 255],
            //             textColor: 0
            //         },
            //         headStyles: {
            //             fillColor: [240, 240, 240],
            //             textColor: 0,
            //             lineWidth: 0.1,
            //             lineColor: [220, 220, 220]
            //         },
            //         footStyles: {
            //             fillColor: [240, 240, 240],
            //             textColor: 0,
            //             lineWidth: 0.1,
            //             lineColor: [220, 220, 220]
            //         },
            //         columnStyles: {
            //             0: { cellWidth: 25 },
            //         },
            //         didDrawCell: function (data) {
            //             if (
            //                 data.section === 'body' &&
            //                 data.column.index === 0 &&
            //                 summaryData[data.row.index]
            //             ) {
            //                 const { imageSrc, imgWidth, imgHeight } = summaryData[data.row.index];

            //                 const cellX = data.cell.x;
            //                 const cellY = data.cell.y;
            //                 const cellW = data.cell.width;
            //                 const cellH = data.cell.height;

            //                 // Background: Full cell fill
            //                 doc.setFillColor(200, 200, 200); // #c8c8c8
            //                 doc.rect(cellX, cellY, cellW, cellH, 'F');

            //                 if (imageSrc) {
            //                     // Fit image into cell, maintaining aspect ratio
            //                     const aspectRatio = imgWidth / imgHeight;

            //                     let drawW = cellW;
            //                     let drawH = drawW / aspectRatio;

            //                     if (drawH > cellH) {
            //                         drawH = cellH;
            //                         drawW = drawH * aspectRatio;
            //                     }

            //                     const x = cellX + (cellW - drawW) / 2;
            //                     const y = cellY + (cellH - drawH) / 2;

            //                     // doc.addImage(imageSrc, 'JPEG', x, y, drawW, drawH);
            //                     doc.addImage(imageSrc, 'PNG', x, y, drawW, drawH);

            //                 }
            //             }
            //         },
            //         didDrawPage: function (data) {
            //             const pageHeight = doc.internal.pageSize.height;
            //             const footerHeight = 20;
            //             const footerY = pageHeight - footerHeight;

            //             doc.setFillColor(0, 0, 0);
            //             doc.rect(0, footerY, doc.internal.pageSize.width, footerHeight, 'F');
                        

            //             const logoHeight = 4;
            //             const logoWidth = 40;
            //             const logoX = doc.internal.pageSize.width - logoWidth - 10;
            //             const logoY = footerY + (footerHeight - logoHeight) / 2;

            //             doc.addImage(logoBase64, 'PNG', logoX, logoY, logoWidth, logoHeight);
            //         },
            //     });

            //     doc.save("summary.pdf");

            //     $btn.prop("disabled", false).css("opacity", "1").html(originalText);
            // });

            $(".download-pdf-btn").on("click", async function () {
                const $btn = $(this);
                const originalText = $btn.html();
                $btn.prop("disabled", true).css("opacity", "0.6").html('<i class="fas fa-file-pdf"></i> Downloading...');

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Step 1: Extract data
                const summaryData = await Promise.all(
                    $("#dynamic-summary tr").map(async function () {
                        const $row = $(this);
                        const imageSrc = $row.find("img").attr("src") || "";
                        let base64Image = "";
                        let imgWidth = 1, imgHeight = 1;

                        if (imageSrc) {
                            try {
                                const result = await toBase64WithSize(imageSrc);
                                base64Image = result.base64;
                                imgWidth = result.width;
                                imgHeight = result.height;
                            } catch (err) {
                                console.warn("Image load failed", imageSrc, err);
                            }
                        }

                        const description = $row.find(".description-cls").text().trim();
                        const price = $row.find("td").eq(2).text().trim();
                        const quantity = $row.find(".quantity").text().trim() || "1";
                        const total = $row.find("td").eq(4).text().trim();
                        const fitmentTime = $row.find(".fitmentTime-cls").text().trim();

                        if (description) {
                            return {
                                imageSrc: base64Image,
                                imgWidth,
                                imgHeight,
                                description,
                                price,
                                quantity,
                                total,
                                fitmentTime
                            };
                        }

                        return null;
                    }).get()
                ).then(rows => rows.filter(Boolean));

                // Totals
                let totalFinal = 0;
                let totalFitment = 0;
                summaryData.forEach(item => {
                    totalFinal += parseFloat(item.total.replace(/[^0-9.]/g, '')) || 0;
                    totalFitment += parseFloat(item.fitmentTime.replace(/[^0-9.]/g, '')) || 0;
                });

                const logoBase64 = await convertSvgToPngBase64("{{ asset('images/tus-logo-new.svg') }}");

                const chunkSize = 7;
                const chunks = [];
                for (let i = 0; i < summaryData.length; i += chunkSize) {
                    chunks.push(summaryData.slice(i, i + chunkSize));
                }

                for (let pageIndex = 0; pageIndex < chunks.length; pageIndex++) {
                    const pageData = chunks[pageIndex];
                    const body = pageData.map(item => [
                        '',
                        item.description,
                        item.price.replace(/\$\s*/g, '$').replace(/\.00\b/, ''),
                        item.quantity,
                        item.total.replace(/\$\s*/g, '$'),
                        item.fitmentTime
                    ]);

                    doc.autoTable({
                        startY: 20,
                        head: [['Image', 'Description', 'Price', 'Quantity', 'Total', 'Fitment Time']],
                        body: body,
                        theme: 'grid',
                        foot: pageIndex === chunks.length - 1 ? [[
                            'Total', '', '', '',
                            `$${totalFinal.toFixed(2)}`,
                            `${totalFitment.toFixed(2)} Hrs`
                        ]] : [],
                        showFoot: 'lastPage',
                        styles: {
                            fontSize: 10,
                            cellPadding: 3,
                            minCellHeight: 25,
                            halign: 'center',
                            valign: 'middle'
                        },
                        headStyles: {
                            fillColor: [240, 240, 240],
                            textColor: 0,
                            lineWidth: 0.1,
                            lineColor: [220, 220, 220]
                        },
                        footStyles: {
                            fillColor: [240, 240, 240],
                            textColor: 0,
                            lineWidth: 0.1,
                            lineColor: [220, 220, 220]
                        },
                        columnStyles: {
                            0: { cellWidth: 25 }
                        },
                        didDrawCell: function (data) {
                            if (
                                data.section === 'body' &&
                                data.column.index === 0 &&
                                pageData[data.row.index]
                            ) {
                                const { imageSrc, imgWidth, imgHeight } = pageData[data.row.index];

                                const cellX = data.cell.x;
                                const cellY = data.cell.y;
                                const cellW = data.cell.width;
                                const cellH = data.cell.height;

                                doc.setFillColor(200, 200, 200);
                                doc.rect(cellX, cellY, cellW, cellH, 'F');

                                if (imageSrc) {
                                    const aspectRatio = imgWidth / imgHeight;
                                    let drawW = cellW;
                                    let drawH = drawW / aspectRatio;

                                    if (drawH > cellH) {
                                        drawH = cellH;
                                        drawW = drawH * aspectRatio;
                                    }

                                    const x = cellX + (cellW - drawW) / 2;
                                    const y = cellY + (cellH - drawH) / 2;
                                    doc.addImage(imageSrc, 'PNG', x, y, drawW, drawH);
                                }
                            }
                        },
                        didDrawPage: function () {
                            const pageHeight = doc.internal.pageSize.height;
                            const footerHeight = 20;
                            const footerY = pageHeight - footerHeight;

                            doc.setFillColor(0, 0, 0);
                            doc.rect(0, footerY, doc.internal.pageSize.width, footerHeight, 'F');

                            const logoHeight = 4;
                            const logoWidth = 40;
                            const logoX = doc.internal.pageSize.width - logoWidth - 10;
                            const logoY = footerY + (footerHeight - logoHeight) / 2;

                            doc.addImage(logoBase64, 'PNG', logoX, logoY, logoWidth, logoHeight);
                        }
                    });

                    if (pageIndex !== chunks.length - 1) {
                        doc.addPage();
                    }
                }

                doc.save("summary.pdf");
                $btn.prop("disabled", false).css("opacity", "1").html(originalText);
            });


            function toBase64WithSize(url) {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.crossOrigin = "Anonymous";

                    img.onload = function () {
                        let [width, height] = [img.width, img.height];
                        const max = 300;

                        // Resize proportionally if too large
                        if (width > max || height > max) {
                            const scale = Math.min(max / width, max / height);
                            width = Math.round(width * scale);
                            height = Math.round(height * scale);
                        }

                        const canvas = document.createElement("canvas");
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext("2d");
                        ctx.fillStyle = "#c8c8c8";
                        ctx.fillRect(0, 0, width, height);
                        ctx.drawImage(img, 0, 0, width, height);

                        const base64 = canvas.toDataURL("image/jpeg", 1); // much smaller
                        resolve({ base64, width, height });
                    };

                    img.onerror = reject;
                    img.src = url;
                });
            }

            async function convertSvgToPngBase64(svgUrl, width = 300, height = 60) {
                const response = await fetch(svgUrl);
                const svgText = await response.text();

                const svgBlob = new Blob([svgText], { type: 'image/svg+xml' });
                const svgUrlObject = URL.createObjectURL(svgBlob);

                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.crossOrigin = "anonymous";
                    img.onload = function () {
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = "#000"; // if you want a fallback background
                        ctx.fillRect(0, 0, width, height);
                        ctx.drawImage(img, 0, 0, width, height);

                        const base64 = canvas.toDataURL('image/png');
                        resolve(base64);
                    };
                    img.onerror = reject;
                    img.src = svgUrlObject;
                });
            }



            // function toBase64WithSize(url) {
            //     return new Promise((resolve, reject) => {
            //         console.log("[toBase64WithSize] Starting image load:", url);

            //         const img = new Image();
            //         img.crossOrigin = "Anonymous";

            //         img.onload = function () {
            //             console.log("[toBase64WithSize] Image loaded:", url);
            //             console.log("→ Image natural size:", img.width, "x", img.height);

            //             const width = img.width;
            //             const height = img.height;

            //             const canvas = document.createElement("canvas");
            //             canvas.width = width;
            //             canvas.height = height;

            //             const ctx = canvas.getContext("2d");

            //             // Fill canvas with gray background
            //             ctx.fillStyle = "#c8c8c8";
            //             ctx.fillRect(0, 0, width, height);
            //             console.log("[toBase64WithSize] Filled gray background");

            //             // Draw image on top
            //             ctx.drawImage(img, 0, 0, width, height);
            //             console.log("[toBase64WithSize] Drew image on canvas");

            //             // Export to base64
            //             const base64 = canvas.toDataURL("image/png");
            //             console.log("[toBase64WithSize] Base64 length:", base64.length);
            //             console.log("[toBase64WithSize] Base64 sample:", base64.slice(0, 100) + "...");

            //             resolve({
            //                 base64,
            //                 width,
            //                 height
            //             });
            //         };

            //         img.onerror = function (err) {
            //             console.error("[toBase64WithSize] Image failed to load:", url, err);
            //             reject(err);
            //         };

            //         img.src = url;
            //     });
            // }

            // Convert image URL to base64 (Promise-based)

                    

            $(".print-summary-btn").on("click", function () {
                const printWindow = window.open('', '', 'height=' + screen.height + ',width=' + screen.width + ',top=0,left=0');
                printWindow.moveTo(0, 0);
                printWindow.resizeTo(screen.width, screen.height);

                let summaryData = [];
                let totalAmount = 0;
                let totalFitment = 0;

                $("#dynamic-summary tr").each(function () {
                    const $row = $(this);
                    const imageSrc = $row.find("img").attr("src") || "";
                    const description = $row.find(".description-cls").text().trim();
                    const price = $row.find("td").eq(2).text().trim();
                    const quantity = $row.find(".quantity").text().trim() || "1";
                    const total = $row.find("td").eq(4).text().trim();
                    const fitmentTime = $row.find(".fitmentTime-cls").text().trim();

                    if (description) {
                        const rowTotal = parseFloat(total.replace(/[^0-9.]/g, '')) || 0;
                        const fitment = parseFloat(fitmentTime.replace(/[^0-9.]/g, '')) || 0;
                        totalAmount += rowTotal;
                        totalFitment += fitment;
                        summaryData.push([imageSrc, description, price, quantity, total, fitmentTime]);
                    }
                });

                const rowsPerPage = 6;
                const remainder = summaryData.length % rowsPerPage;
                const addTotalToLastPage = remainder !== 0 && remainder < rowsPerPage;

                // Add total row directly to the data if last page has space
                if (addTotalToLastPage) {
                    summaryData.push([
                        "", "Total", "", "", `$${totalAmount.toFixed(2)}`, `${totalFitment.toFixed(2)} Hrs`, true
                    ]);
                }

                const totalPages = Math.ceil(summaryData.length / rowsPerPage);

                let htmlContent = `
                    <html>
                    <head>
                        <title>Print Summary</title>
                        <style>
                            @page { margin: 20mm 10mm 30mm 10mm; }
                            body {
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 0;
                                padding-bottom: 80px;
                            }
                            .container { padding: 20px; }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                page-break-inside: auto;
                            }
                            th, td {
                                border: 1px solid #000;
                                padding: 8px;
                                text-align: center;
                            }
                            thead {
                                display: table-header-group;
                                background: #eee;
                            }
                            tr {
                                page-break-inside: avoid;
                                height: 100px;
                            }
                            .footer {
                                position: fixed;
                                bottom: 0;
                                left: 0;
                                width: 100%;
                                height: 70px;
                                background: black;
                                color: white;
                                display: flex;
                                justify-content: flex-end;
                                align-items: center;
                                padding-right: 20px;
                                border-top: 2px solid white;
                                z-index: 9999;
                            }
                            .footer img {
                                height: 40px;
                                width: auto;
                                padding-right: 20px;
                            }
                            .total-row td {
                                font-weight: bold;
                                background-color: #f0f0f0;
                                height: 100px;
                            }
                            .page-break {
                                page-break-after: always;
                            }
                            @media print {
                                html, body {
                                    -webkit-print-color-adjust: exact !important;
                                    print-color-adjust: exact !important;
                                }
                            }
                        </style>
                    </head>
                    <body>
                `;

                for (let i = 0; i < totalPages; i++) {
                    const pageRows = summaryData.slice(i * rowsPerPage, (i + 1) * rowsPerPage);
                    const isLastPage = i === totalPages - 1;

                    htmlContent += `
                        <div class="container">
                            <h2>Summary Report</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Fitment Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    pageRows.forEach(row => {
                        const isTotalRow = row[6] === true;
                        htmlContent += `
                            <tr class="${isTotalRow ? "total-row" : ""}">
                                <td style="width: 97px; height: 98px; padding: 0;">
                                    ${isTotalRow ? "" : `<img src="${row[0]}" style="width: 99%; height: 99%; object-fit: contain; background-color: #c8c8c8; border-radius: 0 !important; border: 0.5px transparent; padding: 0;" />`}
                                </td>
                                <td>${row[1]}</td>
                                <td>${row[2]}</td>
                                <td>${row[3]}</td>
                                <td>${row[4]}</td>
                                <td>${row[5]}</td>
                            </tr>`;
                    });

                    htmlContent += `</tbody></table></div>`;

                    if (!isLastPage) {
                        htmlContent += `<div class="page-break"></div>`;
                    }
                }

                // If last page was full, we couldn't add the total — so add it here
                if (!addTotalToLastPage) {
                    htmlContent += `
                        <div class="page-break"></div>
                        <div class="container">
                            <h2>Total Summary</h2>
                            <table>
                                <tbody>
                                    <tr class="total-row">
                                        <td colspan="2">Total</td>
                                        <td></td>
                                        <td></td>
                                        <td>$${totalAmount.toFixed(2)}</td>
                                        <td>${totalFitment.toFixed(2)} Hrs</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `;
                }

                htmlContent += `
                    <div class="footer">
                        <img src="{{ asset('images/site-logo.png') }} alt="Logo">
                    </div>
                    </body></html>`;

                printWindow.document.write(htmlContent);
                printWindow.document.close();

                printWindow.onload = function () {
                    setTimeout(() => {
                        printWindow.focus();
                        printWindow.print();
                    }, 500);
                };
            });


        


        });
    </script>
    <div class="loader-outer">
        <div class="loader-inner">
            <div class="loader"></div>
        </div>
    </div>


    <style>
        .loader-outer {
            position: fixed;
            top: 0;
            left: 0;
            background: #000000cc;
            width: 100%;
            height: 100%;
            z-index: 99;
            display: none;
        }

        .loader-inner {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .loader {
            width: 50px;
            aspect-ratio: 1;
            border-radius: 50%;
            border: 8px solid #9a9a9a;
            animation:
                l20-1 0.8s infinite linear alternate,
                l20-2 1.6s infinite linear;
        }

        @keyframes l20-1 {
            0% {
                clip-path: polygon(50% 50%, 0 0, 50% 0%, 50% 0%, 50% 0%, 50% 0%, 50% 0%)
            }

            12.5% {
                clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 0%, 100% 0%, 100% 0%)
            }

            25% {
                clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 100%, 100% 100%, 100% 100%)
            }

            50% {
                clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 100%, 50% 100%, 0% 100%)
            }

            62.5% {
                clip-path: polygon(50% 50%, 100% 0, 100% 0%, 100% 0%, 100% 100%, 50% 100%, 0% 100%)
            }

            75% {
                clip-path: polygon(50% 50%, 100% 100%, 100% 100%, 100% 100%, 100% 100%, 50% 100%, 0% 100%)
            }

            100% {
                clip-path: polygon(50% 50%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 0% 100%)
            }
        }

        @keyframes l20-2 {
            0% {
                transform: scaleY(1) rotate(0deg)
            }

            49.99% {
                transform: scaleY(1) rotate(135deg)
            }

            50% {
                transform: scaleY(-1) rotate(0deg)
            }

            100% {
                transform: scaleY(-1) rotate(-135deg)
            }
        }

        .error-message {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 4px;
        }
    </style>

</body>

</html>
