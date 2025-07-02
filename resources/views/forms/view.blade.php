<!DOCTYPE html>
<html>

<head>
    <title>Spare Parts Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">


</head>

<body>
    <!-- <header class="tus-calc-header-outer">
        <div class="container">
            <div class="row">
                <?php
                echo '<pre>';
                //  print_r($form->steps);
                echo '</pre>';

                ?>
            </div>
        </div>
    </header> -->

    <header class="tus-calc-header-outer">
        <div class="container">
            <div class="row">
                <img src="{{ asset('formimages/tus-logo-new.svg') }}" alt="Logo" class="desktop-logo">
                <!-- <img src="{{ asset('formimages/tus-logo-vertical.svg') }}" alt="Logo" class="mobile-logo"> -->

            </div>
        </div>
    </header>
    <div class="tus-calc-form-outer">

        <form id="multiStepForm">

            <div class="container nav-container">
                <ul class="nav nav-tabs d-flex">
                    <?php foreach ($form->steps as $index => $step) : ?>
                    <li class="nav-item">
                        <span
                            class="nav-link <?= $index === 0 ? 'nav-link-active' : '' ?>"><?= strtoupper($step['label']) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= 100 / count($form->steps) ?>%;"
                        aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="container nav-container-mobile d-block d-md-none">
                <!-- Mobile Navigation Tabs -->
                <ul class="nav nav-tabs-mobile d-flex">
                    <?php if (!empty($form->steps)) : ?>
                    <?php foreach ($form->steps as $index => $step) : ?>
                    <li class="nav-item-mobile">
                        <span class="nav-link-mobile <?= $index === 0 ? 'nav-link-active-mobile new' : '' ?>">
                            <?= htmlspecialchars(strtoupper($step['label'])) ?>
                        </span>
                    </li>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <li>No steps available.</li>
                    <?php endif; ?>
                </ul>

                <!-- Mobile Progress Bar -->
                <div class="progress">
                    <div class="progress-bar-mobile" role="progressbar"
                        style="width: <?= !empty($form->steps) ? 100 / count($form->steps) : 0 ?>%;"
                        aria-valuenow="<?= !empty($form->steps) ? 100 / count($form->steps) : 0 ?>" aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </div>




            <!-- Form Steps -->
            <?php foreach ($form->steps as $index => $step) : ?>

            <div class="step step-<?= $index + 1 ?> container steps-outer-main"
                <?= $index === 0 ? '' : 'style="display:none;"' ?>>
                <h2 class="text-center text-white mb-4"><?= $step['mainHeading'] ?></h2>
                <p class="steps-sub-heading text-center text-white"><?= $step['subheading'] ?></p>



                <?php if ($step['template'] == 1) : ?>
                <div class="row align-items-center custom-row-area">
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3><?= $step['sideHeading'] ?></h3>
                        <div class="row">

                            <?php if (isset($step['fields']) && is_array($step['fields'])): ?>
                            <?php foreach ($step['fields'] as $field): ?>
                            <?php if (isset($field['label'], $field['type']) && strtolower(trim($field['label'])) == 'make' && strtolower(trim($field['type'])) == 'select'): ?>
                            <div class="form-group mb-3 col-md-6">
                                <label for="make" class="form-label">Make</label>
                                <select id="make" class="form-select" name="make">
                                    <option value="" disabled selected>Select Make</option>
                                    <?php foreach ($makes as $make): ?>
                                    <option value="<?= htmlspecialchars($make->id) ?>"
                                        data-title="<?= htmlspecialchars($make->name) ?>">
                                        <?= htmlspecialchars($make->name) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>

                            <!-- Model Dropdown -->
                            <?php foreach ($step['fields'] as $field): ?>
                            <!-- Model Dropdown -->
                            <?php if (isset($field['label']) && strtolower(trim($field['label'])) == 'model' && strtolower(trim($field['type'])) == 'select'): ?>
                            <div class="form-group mb-3 col-md-6">
                                <label for="model" class="form-label">Model</label>
                                <select id="model" class="form-select dynamic-select" name="model"
                                    data-field-type="model">
                                    <option value="" disabled selected>Select Model</option>
                                    <!-- You can populate options here dynamically -->
                                </select>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($step['fields'] as $field): ?>
                            <!-- Year Dropdown -->
                            <?php if (isset($field['label']) && strtolower(trim($field['label'])) == 'year' && strtolower(trim($field['type'])) == 'select'): ?>
                            <div class="form-group mb-3 col-md-6">
                                <label for="year" class="form-label">Year</label>
                                <select id="year" class="form-select dynamic-select" name="year"
                                    data-field-type="year">
                                    <option value="" disabled selected>Select Year</option>
                                    <!-- You can populate options here dynamically -->
                                </select>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>



                            <?php foreach ($step['fields'] as $field): ?>
                            <?php if (!empty($field['label']) && !empty($field['type']) && strtolower(trim($field['label'])) == 'modified suspension' && strtolower(trim($field['type'])) == 'select'): ?>
                            <div class="form-group mb-3 col-md-6">
                                <label for="suspension"
                                    class="form-label"><?= htmlspecialchars($field['label']) ?></label>
                                <select id="modified-suspension" class="form-select dynamic-select"
                                    name="modified-suspension" data-field-type="suspension">
                                    <?php
                                    $options = !empty($field['options']) ? explode("\n", $field['options']) : [];
                                    $selectedOption = in_array('no', array_map('strtolower', $options)) ? 'no' : trim($options[0] ?? '');
                                    ?>

                                    <?php if (!empty($options)): ?>
                                    <?php foreach ($options as $option) : ?>
                                    <?php $optionValue = trim($option); ?>
                                    <option value="<?= htmlspecialchars($optionValue) ?>"
                                        <?= strtolower($optionValue) === 'no' ? 'selected' : ($optionValue === $selectedOption ? 'selected' : '') ?>>
                                        <?= ucfirst(htmlspecialchars($optionValue)) ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <option value="" disabled selected>No Options Available</option>
                                    <?php endif; ?>
                                </select>

                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>


                        </div>
                    </div>

                    <div class="col-12 col-md-6 form-right-outer">
                        <div class="form-group" id="car-image">
                            <img src="{{ asset('formimages/vehicle_selector_cycle_fixed.gif') }}" alt="Vehicle">
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="d-flex justify-content-between align-items-center form-buttons-outer-con">
                        <button class="back-btn" type="button">
                            <img src="{{ asset('formimages/white-left-arrow.png') }}" alt="arrow"> Back
                        </button>

                        <?php foreach ($step['fields'] as $field): ?>
                        <?php if (!empty($field['label']) && !empty($field['type']) && strtolower(trim($field['type'])) == 'price_display'): ?>
                        <div class="estimated-price-con text-black text-center">
                            <label class="form-label"><?= htmlspecialchars($field['label']) ?></label>
                            <div class="estimated-price-inn <?= htmlspecialchars($field['css_classes']) ?>">
                                <?= htmlspecialchars($field['currency_symbol']) ?><span
                                    class=""><?= htmlspecialchars($field['initial_value']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>


                        <button class="next-btn" type="button">
                            Next
                            <img src="{{ asset('formimages/black-right-arrow.png') }}" alt="arrow">
                        </button>
                    </div>
                </div>

                <?php elseif ($step['template'] == 2) : ?>

                <?php foreach ($step['fields'] as $field) : ?>
                <?php if ($field['type'] === 'colors' && !empty($field['colors'])) : ?>
                <div class="row align-items-center">
                    <!-- Left Section -->
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3 class="text-left text-white mb-4">Select One</h3>
                        <div class="row color-selction-grid-panel">
                            <?php foreach ($field['colors'] as $color) : ?> <!-- FIX: Loop added -->
                            <div
                                class="form-group col-md-6 d-flex flex-column justify-content-between color-selction-grid select-color-option">
                                <div class="mb-2 d-flex justify-content-between gap-2 color-selction-label">
                                    <label class="form-label"><?= htmlspecialchars($color['label']) ?></label>
                                </div>
                                <div class="color-selection d-flex justify-content-between gap-2 color-<?= htmlspecialchars($color['name']) ?> <?= strtolower($color['name']) === 'black' ? 'selected' : '' ?>"
                                    data-image="<?= htmlspecialchars($color['image_url']) ?>">
                                    <div class="color-gradient-pic">
                                        <p class="d-none"><?= htmlspecialchars($color['label']) ?></p>
                                    </div>
                                    <div class="color-text"><?= htmlspecialchars($color['name']) ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Section (Image Display) -->
                    <div class="col-12 col-md-6 form-right-outer d-flex justify-content-center align-items-center">
                        <div class="form-group from-right-images" id="car-image-color">
                            <img src="{{ asset('formimages/black_textured_powder_coat.png') }}" alt="Car Image"
                                id="colorPreview">
                        </div>
                    </div>
                </div>

                <?php elseif ($field['type'] === 'custom_radio' && strtolower($field['label']) === 'headboard') : ?>

                <div class="row align-items-center custom-row-area">
                    <!-- Left Side: Headboard Selection -->
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3 class="text-left text-white mb-4">Select One</h3>
                        <div class="row headboard-outer">
                            <?php foreach ($field['options'] as $option): ?>
                            <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                                <div class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                    <label class="form-label"><?= htmlspecialchars($option['label']) ?></label>
                                </div>
                                <div class="text-selection headboard-option <?= strtolower($option['text']) === 'no headboard' ? 'no-headboard selected-active' : 'yes-headboard' ?>"
                                    data-black-image="<?= htmlspecialchars($option['black_image_url']) ?>"
                                    data-white-image="<?= htmlspecialchars($option['white_image_url']) ?>"
                                    data-price="<?= htmlspecialchars($option['price']) ?>">
                                    <p class="d-none"><?= htmlspecialchars($option['text']) ?></p>
                                    {{-- <p class="d-none"><?= htmlspecialchars($option['fitment_time']) ?></p> --}}
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="px-2 headboard-text"><?= htmlspecialchars($option['text']) ?>
                                        </div>
                                        <?php if (!empty($option['price'])): ?>
                                        <div class="px-2 d-flex">+$
                                            <div class="headboard-price ms-1">
                                                <?= htmlspecialchars($option['price']) ?></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Side: Image Preview -->
                    <div class="col-12 col-md-6 form-right-outer">
                        <div class="form-group from-right-images" id="car-image-headboard">
                            <img src="{{ asset('formimages/black_textured_powder_coat.png') }}"
                                alt="Headboard Preview" id="headboardPreview">
                        </div>
                    </div>
                </div>

                <?php elseif ($field['type'] === 'custom_radio' && strtolower($field['label']) === 'canopy') : ?>
                <div class="row align-items-center custom-row-area">
                    <!-- Left Side: Canopy Selection -->
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3 class="text-left text-white mb-4">Select One</h3>
                        <div class="row canopy-outer">
                            <?php foreach ($field['options'] as $option): ?>
                            <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                                <div class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                    <label class="form-label"><?= htmlspecialchars($option['label']) ?></label>
                                </div>
                                <div class="text-selection canopy-option <?= strtolower($option['text']) === 'no canopy' ? 'no-canopy selected-active' : 'yes-canopy' ?>"
                                    data-price="<?= !empty($option['price']) ? htmlspecialchars($option['price']) : '0' ?>"
                                    data-black-image="<?= htmlspecialchars($option['black_image_url']) ?>"
                                    data-white-image="<?= htmlspecialchars($option['white_image_url']) ?>">
                                    <p class="d-none"><?= htmlspecialchars($option['text']) ?></p>
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="px-2 canopy-text"><?= htmlspecialchars($option['text']) ?>
                                        </div>
                                        <?php if (!empty($option['price'])): ?>
                                        <div class="px-2 d-flex">+$<span
                                                class="canopy-price-initial"><?= htmlspecialchars($option['price']) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Side: Image Preview -->
                    <div class="col-12 col-md-6 form-right-outer">
                        <div class="form-group from-right-images" id="car-image-canopy">
                            <img src="{{ asset('formimages/black_textured_powder_coat.png') }}" alt="Canopy Preview"
                                id="canopyPreview">
                        </div>
                    </div>
                </div>

                <?php elseif ($field['type'] === 'custom_radio' && strtolower($field['label']) === 'tray sides') : ?>
                <div class="row align-items-center custom-row-area">
                    <!-- Left Side: Canopy Selection -->
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3 class="text-left text-white mb-4">Select One</h3>
                        <div class="row mb-4">
                            <?php foreach ($field['options'] as $option): ?>
                            <div
                                class="form-group tray-choosen hidden col-md-6 d-flex flex-column justify-content-between">
                                <div class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                    <label class="form-label"><?= htmlspecialchars($option['label']) ?></label>
                                </div>
                                <div class="text-selection tray-option <?= strtolower($option['text']) === 'no tray sides' ? 'selected-active' : '' ?>"
                                    data-price="<?= !empty($option['price']) ? htmlspecialchars($option['price']) : '0' ?>"
                                    data-black-image="<?= htmlspecialchars($option['black_image_url']) ?>"
                                    data-white-image="<?= htmlspecialchars($option['white_image_url']) ?>">
                                    <p class="d-none"><?= htmlspecialchars($option['text']) ?></p>
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="px-2 tray-text"><?= htmlspecialchars($option['text']) ?></div>
                                        <?php if (!empty($option['price'])): ?>
                                        <div class="px-2 d-flex">+$<span
                                                class="tray-price-initial"><?= htmlspecialchars($option['price']) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Side: Image Preview -->
                    <div class="col-12 col-md-6 form-right-outer">
                        <div class="form-group from-right-images" id="car-image-tray">
                            <img src="{{ asset('formimages/black_textured_powder_coat.png') }}" alt="tray Preview"
                                id="trayPreview">
                        </div>
                    </div>
                </div>

                <?php elseif ($field['type'] === 'custom_radio' && strtolower($field['label']) === 'trundle') : ?>
                <div class="row align-items-center custom-row-area">
                    <!-- Left Side: trundle Selection -->
                    <div class="col-12 col-md-6 form-left-outer">
                        <h3 class="text-left text-white mb-4">Select One</h3>
                        <div class="row trundle-outer">
                            <?php foreach ($field['options'] as $option): ?>
                            <div class="form-group col-md-6 d-flex flex-column justify-content-between">
                                <div class="mb-2 d-flex justify-content-between gap-2 mobile-none">
                                    <label class="form-label"><?= htmlspecialchars($option['label']) ?></label>
                                </div>
                                <div class="text-selection trundle-option <?= strtolower($option['text']) === 'no trundle' ? 'no-trundle' : 'yes-trundle' ?>
                                                            <?= strtolower($option['text']) === '1100mm trundle draw' ? 'selected-active' : '' ?>"
                                    data-price="<?= !empty($option['price']) ? htmlspecialchars($option['price']) : '0' ?>"
                                    data-black-image="<?= htmlspecialchars($option['black_image_url']) ?>"
                                    data-white-image="<?= htmlspecialchars($option['white_image_url']) ?>">
                                    <p class="d-none"><?= htmlspecialchars($option['text']) ?></p>
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="px-2 trundle-text"><?= htmlspecialchars($option['text']) ?>
                                        </div>
                                        <?php if (!empty($option['price'])): ?>
                                        <div class="px-2 d-flex">+$<span
                                                class="trundle-price-initial"><?= htmlspecialchars($option['price']) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Right Side: Image Preview -->
                    <div class="col-12 col-md-6 form-right-outer">
                        <div class="form-group from-right-images" id="car-image-trundle">
                            <img src="{{ asset('formimages/black_textured_powder_coat.png') }}" alt="trundle Preview"
                                id="trundlePreview">
                        </div>
                    </div>
                </div>


                <?php endif; ?>
                <?php endforeach; ?>

                <!-- Buttons and Price Display -->
                <div class="row align-items-center">
                    <div class="d-flex justify-content-between align-items-center form-buttons-outer-con">
                        <button class="back-btn" type="button">
                            <img src="{{ asset('formimages/white-left-arrow.png') }}" alt="arrow"> Back
                        </button>

                        <?php foreach ($step['fields'] as $field): ?>
                        <?php if (!empty($field['label']) && !empty($field['type']) && strtolower(trim($field['type'])) == 'price_display'): ?>
                        <div class="estimated-price-con text-black text-center">
                            <label class="form-label"><?= htmlspecialchars($field['label']) ?></label>
                            <div class="estimated-price-inn <?= htmlspecialchars($field['css_classes']) ?>">
                                <?= htmlspecialchars($field['currency_symbol']) ?><span
                                    class=""><?= htmlspecialchars($field['initial_value']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <button class="next-btn" type="button">
                            Next
                            <img src="{{ asset('formimages/black-right-arrow.png') }}" alt="arrow">
                        </button>
                    </div>
                </div>


                <?php elseif ($step['template'] == 3) : ?>

                <?php foreach ($step['fields'] as $field) : ?>
                <?php if ($field['type'] === 'slide_options' && strtolower($field['label']) === 'internals') : ?>
                <div class="row align-items-center custom-row-area">
                    <div class="internal-options-section">
                        <div class="d-flex align-items-center">
                            <button type="button" id="prev-bttn" class="btn btn-light mx-2 nav-btn">
                                <img src="{{ asset('images/white-arrow-sided.png') }}" alt="Arrow">
                            </button>
                            <div class="row row-cols-1 d-flex flex-nowrap internal-slider" id="product-container">

                            </div>
                            <button type="button" id="next-bttn" class="btn btn-light mx-2 nav-btn">
                                <img src="{{ asset('images/white-arrow-sided.png') }}" alt="Arrow">
                            </button>
                        </div>
                    </div>
                </div>



                <?php elseif ($field['type'] === 'slide_options' && strtolower($field['label']) === 'externals') : ?>

                <div class="row align-items-center custom-row-area">
                    <div class="external-options-section">
                        <div class="d-flex align-items-center">
                            <button type="button" id="prev-btn-external" class="btn btn-light mx-2 nav-btn"><img
                                    src="images/white-arrow-sided.png" alt="Arrow"></button>
                            <div class="row row-cols-1 d-flex flex-nowrap internal-slider"
                                id="external-product-container">
                                <!-- External Products will be dynamically loaded here -->
                            </div>
                            <button type="button" id="next-btn-external" class="btn btn-light mx-2 nav-btn"><img
                                    src="images/white-arrow-sided.png" alt="Arrow"></button>
                        </div>
                    </div>
                </div>


                <?php endif; ?>
                <?php endforeach; ?>


                <div class="row align-items-center">
                    <div class="d-flex justify-content-between align-items-center form-buttons-outer-con">
                        <button class="back-btn" type="button">
                            <img src="{{ asset('formimages/white-left-arrow.png') }}" alt="arrow"> Back
                        </button>

                        <?php foreach ($step['fields'] as $field): ?>
                        <?php if (!empty($field['label']) && !empty($field['type']) && strtolower(trim($field['type'])) == 'price_display'): ?>
                        <div class="estimated-price-con text-black text-center">
                            <label class="form-label"><?= htmlspecialchars($field['label']) ?></label>
                            <div class="estimated-price-inn <?= htmlspecialchars($field['css_classes']) ?>">
                                <?= htmlspecialchars($field['currency_symbol']) ?><span><?= htmlspecialchars($field['initial_value']) ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <button class="next-btn" type="button">
                            Next
                            <img src="{{ asset('formimages/black-right-arrow.png') }}" alt="arrow">
                        </button>
                    </div>
                </div>

                <?php elseif ($step['template'] == 4) : ?>
                <div class="d-flex flex-column justify-content-center align-items-center sent-form-outer">
                    <div class="user-details">
                        <div class="row mb-3 user-form-fields-con">
                            <?php
                                                        $count = 0;
                                                        foreach ($step['fields'] as $field):
                                                            if ($field['type'] === 'text'):
                                                                if ($count % 2 == 0 && $count != 0) echo '</div><div class="row mb-3 user-form-fields-con">'; // New row every 2 fields
                                                        ?>
                            <div class="col-md-6 user-details-con">
                                <input type="text" id="<?= $field['label'] ?>" name="<?= $field['label'] ?>"
                                    class="form-control <?= $field['label'] ?>"
                                    placeholder="<?= $field['placeholder'] ?>">
                                <div class="error-message text-danger"></div>
                            </div>
                            <?php
                                                                $count++;
                                                            endif;
                                                        endforeach;
                                                        ?>
                        </div>

                        <!-- Interest Buttons -->
                        <h3 class="text-center">Are you interested in</h3>
                        <div class="d-flex justify-content-between interested-values-con">
                            <?php foreach ($step['fields'] as $field): ?>
                            <?php if ($field['type'] === 'radio' && $field['label'] === 'Are you interested in'): ?>
                            <?php foreach ($field['options'] as $option): ?>
                            <button type="button" class="btn btn-outline-primary interest-option"
                                data-value="<?= htmlspecialchars($option['label']) ?>">
                                <?= htmlspecialchars($option['label']) ?>
                                <?php if (!empty($option['text'])): ?>
                                <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?= htmlspecialchars($option['text']) ?>" style="font-size: 12px;"></i>
                                <?php endif; ?>
                            </button>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Terms & Conditions -->
                        <?php foreach ($step['fields'] as $field): ?>
                        <?php if ($field['type'] === 'checkbox'): ?>
                        <div class="form-check mb-3 mt-3">
                            <input class="form-check-input" type="checkbox" id="agree" name="agree">
                            <label class="form-check-label" for="agree">
                                <?= htmlspecialchars($field['label']) ?> <a href="#">Terms and Conditions</a>
                            </label>
                            <div class="error-message text-danger"></div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <input type="hidden" name="total-quote" id="total-quote">

                        <!-- Navigation Buttons -->
                        <div
                            class="d-flex justify-content-between align-items-center form-buttons-outer-con submit-form-outer">
                            <button class="btn btn-primary submit-btn" type="submit">Submit Inquiry</button>
                        </div>
                    </div>
                </div>
                <?php elseif ($step['template'] == 5) : ?>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="table-responsive bg-dark p-3 rounded-3 overflow-hidden">
                            <table class="table table-bordered text-white"
                                style="background-color: #111; max-height:460px">
                                <thead class="table-dark" style="height: 60px;">
                                    <tr>
                                        <th class="py-3 px-3 text-center">Products</th>
                                        <th class="py-3 px-3 text-center">Description</th>
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
                                        <td class="py-3 px-3">Fitment</td>
                                        <td class="py-3 px-3">
                                            <div class="d-flex align-items-center">
                                                <span>Estimated Calculated Fitment Hours*</span>
                                                <i class="fas fa-info-circle ms-2"></i>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">15 Hours</td>
                                        <td class="py-3 px-3 summary-price">+$2350</td>
                                        <td class="py-3 px-3 text-center" colspan="2">
                                            <button type="button"
                                                class="btn btn-light text-dark w-100 h-100 next-btn">Next</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>



                <?php endif; ?>






                <!-- Navigation Buttons -->




            </div>
            <?php endforeach; ?>


            <div class="step step-last container steps-outer-main" style="display:none;">
                <div class="text-center">
                    <div class="poppin-graphic-con"><img src="{{ asset('formimages/poppin-graphic.png') }}"
                            alt="Pic"></div>
                    <h1 class=""> WE DID IT, GREAT WORK!</h1>
                    <p class="mb-4 px-4 max-w-2xl mx-auto">We appreciate you taking the time to complete your Tray
                        &amp; Canopy Builder with us! Your setup is one step closer to hitting the dusty roads, and
                        our team will be in touch soon to go over the details. In the meantime, follow us on socials
                        for the latest builds, updates, and adventure inspiration. If you have any questions or need
                        further assistance, don't hesitate to give us a call—we're always here to help!</p>
                    <p class="mb-8">See you out on the tracks!</p>
                    <div class="flex justify-center space-x-4 mb-8 social-media-icons-con">
                        <a class="text-gray-400 hover:text-white" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="text-gray-400 hover:text-white" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="text-gray-400 hover:text-white" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="text-gray-400 hover:text-white" href="#"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a class="text-gray-400 hover:text-white" href="#"><i
                                class="fab fa-snapchat-ghost"></i></a>
                    </div>

                    <div
                        class="d-flex justify-content-center align-items-center form-buttons-outer-con submit-form-outer Back-home-btn">
                        <button class="back-btn reload-btn" type="button"><img
                                src="{{ asset('formimages/white-left-arrow.png') }}" alt="arrow"> Back
                            Home</button>
                    </div>


                </div>
            </div>




        </form>
    </div>

    <footer class="tus-calc-footer-outer">
        <div class="container">
            <div class="row">
                <p>COPYRIGHT © 2024 TEST.COM. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"
        integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {

            $(document).on('focus', '.number', function() {
                $(this).inputmask("(999) 999-9999");
            });

            // Apply email mask
            $(document).on('focus', '.email', function() {
                $(this).inputmask({
                    alias: "email"
                });
            });

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

            // Initialize Slick on page load
            initializeSlick();


            initializeSlickExternal();

            function initializeSlickExternal() {
                let $slider = $('#external-product-container');

                if ($slider.length === 0 || $slider.children().length === 0) {
                    console.warn(
                        "⚠️ No products found in #product-container-externals! Skipping Slick initialization.");
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
                }, 100); // Small delay ensures elements exist
            }




            let selectedData = {};

            var suspensionText = "";
            // Declare basePrice globally
            var totalPrice = 0;
            var basePrice = 0;
            var colorprice = 0;
            var headboardPrice = 0;
            var canopyPrice = 0;
            var trayPrice = 0;
            var totalinternalPrice = 0;
            var trundlePrice = 0;
            var totalexternalPrice = 0;


            function logPrices() {
                console.log("Base Price:", basePrice);
                console.log("Color Price:", colorprice);
                console.log("Headboard Price:", headboardPrice);
                console.log("canopyprice Price:", canopyPrice);
                console.log("Total Price:", totalPrice);
            }

            function updateTotalPrice() {
                totalPrice = basePrice + colorprice + headboardPrice + canopyPrice + trayPrice + trundlePrice +
                    totalinternalPrice + totalexternalPrice;
                // $('.total-price span').text(totalPrice.toFixed(2)); // Update UI
                // logPrices();

                // console.log("total price",totalPrice);
            }


            let currentStep = 0;
            const steps = $(".steps-outer-main");
            const progressBar = $(".progress-bar");

            function showStep(step) {
                steps.hide();
                $(steps[step]).fadeIn();
                $(".nav-link").removeClass("nav-link-active");
                $(".nav-link").eq(step).addClass("nav-link-active");

                let progressPercentage = ((step + 1) / steps.length) * 100;
                progressBar.css("width", progressPercentage + "%");
            }


            let selectedInterests = [];

            $(".interest-option").click(function() {
                let value = $(this).data("value");

                if ($(this).hasClass("selected-interest")) {
                    $(this).removeClass("selected-interest");
                    selectedInterests = selectedInterests.filter(item => item !== value);
                } else {
                    $(this).addClass("selected-interest");
                    selectedInterests.push(value);
                }
            });

            function addProductRow() {
                var newRow = `
        <tr class="table-dark">
            <td class="py-2 px-3 text-center">
                <img src="{{ asset('formimages/Image Coming Soon.jpg') }}"
                     alt="Product Image"
                     class="rounded img-thumbnail" style="width: 100px; height: 100px;">
            </td>
            <td class="py-2 px-3">${selectedData["make"]} (${selectedData["model"]}) (${selectedData["year"]}) <br>  ${suspensionText}</td>
            <td class="py-3 px-3 text-center">${basePrice}</td>
            <td class="py-2 px-3">
                <div class="d-flex align-items-center">
                    -
                </div>
            </td>
            <td class="py-2 px-3 text-center">${basePrice}</td>
            <td class="py-2 px-3 text-center">
                -
            </td>
        </tr>
    `;

                // Append the new row to the tbody with id "dynamic-summary"
                $("#dynamic-summary").append(newRow);

                let runningTotal = basePrice + colorprice + headboardPrice + canopyPrice + trayPrice + trundlePrice;

                var colorimgSrc = $("#colorPreview").attr("src");
                var headboardimgSrc = $("#headboardPreview").attr("src");
                var canopyimgSrc = $("#canopyPreview").attr("src");
                var trayimgSrc = $("#trayPreview").attr("src");
                var trundleimgSrc = $("#trundlePreview").attr("src");
                var selectionRows = `
    `;

                if (selectedData["COLOUR SELECTION"]) {
                    selectionRows += `
            <tr class="table-dark">
                <td class="py-2 px-3 text-center">
                    <img src="${colorimgSrc}"
                        alt="Product Image"
                        class="rounded img-thumbnail" style="width: 100px; height: 100px;"></td>
                <td class="py-2 px-3">Color Selection: ${selectedData["COLOUR SELECTION"]}</td>
                <td class="py-2 px-3 text-center">${colorprice}</td>
                <td class="py-2 px-3">-</td>
                <td class="py-2 px-3 text-center">${basePrice + colorprice}</td>
                <td class="py-2 px-3 text-center">-</td>
            </tr>
        `;
                }

                if (selectedData["Selected headboard"]) {
                    selectionRows += `
            <tr class="table-dark">
                <td class="py-2 px-3 text-center">
                    <img src="${headboardimgSrc}"
                        alt="Product Image"
                        class="rounded img-thumbnail" style="width: 100px; height: 100px;"></td>
                <td class="py-2 px-3">Selected Headboard: ${selectedData["Selected headboard"]}</td>
                <td class="py-2 px-3 text-center">${headboardPrice}</td>
                <td class="py-2 px-3">-</td>
                <td class="py-2 px-3 text-center">${basePrice + colorprice + headboardPrice}</td>
                <td class="py-2 px-3 text-center">-</td>
            </tr>
        `;
                }

                if (selectedData["Selected Canopy"]) {
                    selectionRows += `
            <tr class="table-dark">
                <td class="py-2 px-3 text-center">
                    <img src="${canopyimgSrc}"
                        alt="Product Image"
                        class="rounded img-thumbnail" style="width: 100px; height: 100px;"></td>
                <td class="py-2 px-3">Selected Canopy: ${selectedData["Selected Canopy"]}</td>
                <td class="py-2 px-3 text-center">${canopyPrice}</td>
                <td class="py-2 px-3">-</td>
                <td class="py-2 px-3 text-center">${basePrice + colorprice + headboardPrice + canopyPrice}</td>
                <td class="py-2 px-3 text-center">-</td>
            </tr>
        `;
                }


                if (selectedData["Selected Tray Sides"]) {
                    selectionRows += `
            <tr class="table-dark">
                <td class="py-2 px-3 text-center">
                    <img src="${trayimgSrc}"
                        alt="Product Image"
                        class="rounded img-thumbnail" style="width: 100px; height: 100px;"></td>
                <td class="py-2 px-3">Selected Tray Sides: ${selectedData["Selected Tray Sides"]}</td>
                <td class="py-2 px-3 text-center">${trayPrice}</td>
                <td class="py-2 px-3">-</td>
                <td class="py-2 px-3 text-center">${basePrice + colorprice + headboardPrice + canopyPrice + trayPrice}</td>
                <td class="py-2 px-3 text-center">-</td>
            </tr>
        `;
                }


                if (selectedData["Selected Trundle"]) {
                    selectionRows += `
            <tr class="table-dark">
                <td class="py-2 px-3 text-center">
                    <img src="${trundleimgSrc}"
                        alt="Product Image"
                        class="rounded img-thumbnail" style="width: 100px; height: 100px;">
                </td>
                <td class="py-2 px-3">Selected Trundle: ${selectedData["Selected Trundle"] || "Not selected"}</td>
                <td class="py-2 px-3 text-center">${trundlePrice}</td>
                <td class="py-2 px-3">-</td>
                <td class="py-2 px-3 text-center">${basePrice + colorprice + headboardPrice + canopyPrice + trayPrice + trundlePrice}</td>
                <td class="py-2 px-3 text-center">-</td>
            </tr>
        `;
                }

                if (selectedData["internal_options"] && selectedData["internal_options"].length > 0) {
                    selectedData["internal_options"].forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        // Find the matching image based on the `data-name` attribute
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('formimages/Image Coming Soon.jpg') }}"; // Default image if no match


                        selectionRows += `
                <tr class="table-dark">
                    <td class="py-2 px-3 text-center">
                        <img src="${matchingImage}"
                            alt="Option Image"
                            class="rounded img-thumbnail" style="width: 100px; height: 100px;">
                    </td>
                    <td class="py-2 px-3">${option.name}</td>
                    <td class="py-2 px-3 text-center">${option.price}</td>
                    <td class="py-2 px-3 text-center">
                                   <button type="button" class="btn btn-sm btn-secondary decrease-quantity">-</button>
                            <span class="quantity">${option.quantity}</span>
                            <button type="button" class="btn btn-sm btn-secondary increase-quantity">+</button>
                            </td>
                    <td class="py-2 px-3 text-center">${runningTotal}</td>
                    <td class="py-2 px-3 text-center"><button type="button" class="btn btn-sm btn-danger remove-item">x</button></td>
                </tr>
            `;
                    });
                }

                if (selectedData["external_options"] && selectedData["external_options"].length > 0) {
                    selectedData["external_options"].forEach(option => {
                        let optionTotal = option.price * option.quantity;
                        runningTotal += optionTotal;

                        // Find the matching image based on the `data-name` attribute
                        let matchingImage = $(".product-card").filter(function() {
                                return $(this).data("name") === option.name;
                            }).find("img").attr("src") ||
                            "{{ asset('formimages/Image Coming Soon.jpg') }}"; // Default image if no match

                        selectionRows += `
                <tr class="table-dark">
                    <td class="py-2 px-3 text-center">
                        <img src="${matchingImage}"
                            alt="Option Image"
                            class="rounded img-thumbnail" style="width: 100px; height: 100px;">
                    </td>
                    <td class="py-2 px-3">${option.name}</td>
                    <td class="py-2 px-3 text-center">${option.price}</td>
                    <td class="py-2 px-3 text-center">
                                   <button type="button" class="btn btn-sm btn-secondary decrease-quantity">-</button>
                            <span class="quantity">${option.quantity}</span>
                            <button type="button" class="btn btn-sm btn-secondary increase-quantity">+</button></td>
                    <td class="py-2 px-3 text-center">${runningTotal}</td>
                    <td class="py-2 px-3 text-center">
                       <button type="button" class="btn btn-sm btn-danger remove-item">x</button>
                       </td>
                </tr>
            `;
                    });
                }

                $(".summary-price").text(`+${runningTotal}`);

                // Append the selection rows to the tbody with id "dynamic-summary"
                $("#dynamic-summary").append(selectionRows);

            }

            $(document).on("click", ".increase-quantity, .decrease-quantity", function() {
                let row = $(this).closest("tr"),
                    quantityElement = row.find(".quantity"),
                    quantity = parseInt(quantityElement.text().trim()) || 0,
                    price = parseFloat(row.find("td:nth-child(3)").text().trim()) || 0,
                    optionName = row.find("td:nth-child(2)").text().trim();

                quantity += $(this).hasClass("increase-quantity") ? 1 : quantity > 1 ? -1 : 0;
                quantityElement.text(quantity);

                ["internal_options", "external_options"].forEach(key =>
                    selectedData[key]?.forEach(opt => opt.name === optionName && (opt.quantity =
                        quantity))
                );

                updatesummaryprice();
                updateTotalPrice();
                collectChangedData();
                updateSummaryTable();
            });

            function updatesummaryprice() {
                totalinternalPrice = totalexternalPrice = 0;
                ["internal_options", "external_options"].forEach(key =>
                    selectedData[key]?.forEach(opt => key === "internal_options" ?
                        totalinternalPrice += opt.price * opt.quantity :
                        totalexternalPrice += opt.price * opt.quantity)
                );
            }





            $(document).on("click", ".remove-item", function() {
                let row = $(this).closest("tr");
                let optionName = row.find("td:nth-child(2)").text()
                    .trim(); // Get the name from the second column
                let price = parseFloat(row.find("td:nth-child(3)").text().trim()) ||
                    0; // Get price from the third column
                let quantity = parseInt(row.find("td:nth-child(4)").text().trim()) ||
                    1; // Get quantity from the fourth column
                let totalPriceToRemove = price * quantity; // Calculate total price to remove

                console.log("Attempting to remove:", optionName, "Price:", price, "Quantity:", quantity);

                // Check if the item exists in internal_options
                let removedItem = selectedData["internal_options"]?.find(option => option.name ===
                    optionName);
                if (removedItem) {
                    totalinternalPrice -= totalPriceToRemove; // Subtract the correct total price
                    selectedData["internal_options"] = selectedData["internal_options"].filter(option =>
                        option.name !== optionName);
                    internal_options = selectedData["internal_options"]; // Update reference
                    console.log("Removed internal option:", removedItem.name, "Price:", removedItem.price,
                        "Quantity:", quantity);
                    console.log("Total removed:", totalPriceToRemove);
                    console.log("Updated totalinternalPrice:", totalinternalPrice);
                }

                // Check if the item exists in external_options
                removedItem = selectedData["external_options"]?.find(option => option.name === optionName);
                if (removedItem) {
                    totalexternalPrice -= totalPriceToRemove;
                    selectedData["external_options"] = selectedData["external_options"].filter(option =>
                        option.name !== optionName);
                    external_options = selectedData["external_options"]; // Update reference
                    console.log("Removed external option:", removedItem.name, "Price:", removedItem.price,
                        "Quantity:", quantity);
                    console.log("Total removed:", totalPriceToRemove);
                    console.log("Updated totalexternalPrice:", totalexternalPrice);
                }

                row.remove();
                collectChangedData(); // Update modified list
                updateSummaryTable(); // Refresh table
                updateTotalPrice();
            });

            function updateSummaryTable() {
                $("#dynamic-summary").empty(); // Clear the table before rebuilding
                addProductRow(); // Rebuild the table with updated data
            }



            function collectChangedData() {

                updateTotalPrice();
                // selectedData["internal_options"] = [];
                // selectedData["external_options"] = [];
                selectedData["interested_options"] = selectedInterests;
                selectedData["total-price"] = totalPrice;
                selectedData["internal_options"] = internal_options;
                selectedData["external_options"] = external_options;

                var selectedMakeTitle = $("#make option:selected").data("title");
                selectedData["make"] = selectedMakeTitle;

                var selectedModelName = $("#model option:selected").text().trim();
                selectedData["model"] = selectedModelName;

                selectedData["year"] = $("#year").val();

                selectedData["modified-suspension"] = $("#modified-suspension").val();
                suspensionText = selectedData["modified-suspension"] === "yes" ? "Modified Suspension: Yes" :
                    "Modified Suspension: No";




                selectedData["name"] = $("#name").val();
                selectedData["location"] = $("#location").val();
                selectedData["email"] = $("#email").val();
                selectedData["number"] = $("#number").val();

                // Iterate over form fields to collect their data
                $("#myForm")
                    .find("input, select, textarea")
                    .each(function() {
                        let fieldName = $(this).attr("name");
                        let fieldValue = $(this).val();
                        if (fieldName) {
                            selectedData[fieldName] = fieldValue; // Store data
                        }
                    });

                // Optional: Update the selected data
                let selectedColor = $(this).find(".color-text").text().trim();
                let stepHeading = $(".step:visible h2").text().trim();

                if (selectedColor && stepHeading) {
                    selectedData[stepHeading] = selectedColor;
                }

                console.log("Collected Data:", selectedData);

            }

            $(".next-btn").prop("disabled", true).css("opacity", "0.5");

            $(".next-btn").click(function() {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    // console.log("Current Step:", currentStep); // Logs the current step in the console
                    showStep(currentStep);
                }

                if (currentStep === 2) {
                    // Check if a color is already selected
                    if (!selectedData["COLOUR SELECTION"] || selectedData["COLOUR SELECTION"].trim() ===
                        "") {
                        selectedData["COLOUR SELECTION"] = "Black"; // Default to Black if no color selected
                        console.log("No color selected, setting to Black.");
                    } else {
                        console.log("User selected color:", selectedData["COLOUR SELECTION"]);
                    }
                }

                if (currentStep === 3) {
                    // Get the selected headboard option
                    let selectedHeadboard = $(".headboard-option.selected-active").find(".headboard-text")
                        .text().trim();

                    // Store the selected headboard in selectedData
                    selectedData["Selected headboard"] = selectedHeadboard ? selectedHeadboard :
                        "no headboard";
                    console.log("Selected headboard:", selectedData["Selected headboard"]);
                }

                if (currentStep === 4) {
                    // Get the selected canopy option
                    let selectedCanopy = $(".canopy-option.selected-active").find(".canopy-text").text()
                        .trim();

                    // Store the selected canopy in selectedData
                    selectedData["Selected Canopy"] = selectedCanopy ? selectedCanopy : "No Canopy";
                    console.log("Selected Canopy:", selectedData["Selected Canopy"]);

                    if (selectedCanopy.toLowerCase() === "no canopy") {
                        let traysToShow = ["no tray sides", "1800mm length"];

                        $(".tray-option").each(function() {
                            let trayText = $(this).find("p").text().trim().toLowerCase();

                            if (traysToShow.includes(trayText)) {
                                $(this).parent().removeClass("tray-choosen").show();
                                // console.log(`✅ Showing Tray: ${trayText}`);
                            } else {
                                $(this).parent().addClass("tray-choosen").hide();
                                // console.log(`❌ Hiding Tray: ${trayText}`);
                            }
                        });
                    }

                }





                if (currentStep == 5) {
                    initializeSlick();
                    console.log("Slick initialized on step 5");

                    let selectedTray = $(".tray-option.selected-active").find(".tray-text").text().trim();

                    console.log("the tray from the div", selectedTray);
                    // Store the selected tray in selectedData
                    selectedData["Selected Tray Sides"] = selectedTray ? selectedTray : "No Tray Sides";
                    console.log("Selected Tray:", selectedData["Selected Tray Sides"]);
                }

                if (currentStep == 7) {
                    initializeSlickExternal();
                    // console.log("slick intialized");
                    let selectedTrundle = $(".trundle-option.selected-active").find(".trundle-text").text()
                        .trim();
                    // Store the selected trundle in selectedData
                    selectedData["Selected Trundle"] = selectedTrundle ? selectedTrundle :
                        "No Trundle Selected";
                    console.log("Selected Trundle:", selectedData["Selected Trundle"]);
                }
                if (currentStep == 8) {
                    $("#dynamic-summary").empty(); // Clears all rows in the table body
                    // console.log("Table cleared for step 8");
                    addProductRow();
                }
                collectChangedData();
            });


            $(".back-btn").click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);


            $('#make').change(function() {
                var makeId = $(this).val(); // Get selected Make ID

                if (makeId) {
                    $.ajax({
                        url: "<?= route('get.models') ?>", // Update with your route
                        type: "GET",
                        data: {
                            make_id: makeId
                        },
                        success: function(response) {
                            // console.log("Models Response:", response); // Log response to console

                            $('#model').empty().append(
                                '<option value="" disabled selected>Select Model</option>');
                            $.each(response.models, function(key, model) {
                                $('#model').append('<option value="' + model.id +
                                    '" data-years="' + model.years +
                                    '" data-truck-type="' + model.truck_type +
                                    '" data-price="' + model.price + '">' + model
                                    .model_name + '</option>');
                            });

                            // Reset Year dropdown when Make changes
                            $('#year').empty().append(
                                '<option value="" disabled selected>Select Year</option>');
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", xhr.responseText);
                        }
                    });
                } else {
                    $('#model').empty().append('<option value="" disabled selected>Select Model</option>');
                    $('#year').empty().append('<option value="" disabled selected>Select Year</option>');
                }
                $(".next-btn").prop("disabled", true).css("opacity", "0.5");
            });

            // Handle Model Change to Populate Years
            $('#model').change(function() {
                var selectedModel = $(this).find(':selected'); // Get selected model
                var years = selectedModel.data('years'); // Get years from data attribute

                $('#year').empty().append('<option value="" disabled selected>Select Year</option>');

                if (years) {
                    years = String(years); // Convert to string if it's not
                    var yearsArray = years.indexOf(',') !== -1 ? years.split(',') : [
                        years
                    ]; // Handle both single and multiple years

                    $.each(yearsArray, function(index, year) {
                        $('#year').append('<option value="' + year.trim() + '">' + year.trim() +
                            '</option>');
                    });
                }
                $(".next-btn").prop("disabled", true).css("opacity", "0.5");

            });


            $('#year').change(function() {
                var selectedYear = $(this).val();
                var selectedModel = $('#model').find(':selected'); // Get selected model
                var truckType = selectedModel.data('truck-type'); // Get truck type from model data
                var modelPrice = selectedModel.data('price');

                // Check if truck type exists in the priceMap and set the price
                if (modelPrice) {
                    basePrice = parseFloat(modelPrice); // Set price from the selected model
                } else {
                    basePrice = 0; // Default price if no price found
                }

                // console.log(selectedYear, truckType );

                // Update the UI
                $('.make-price span').text(basePrice.toFixed(2));
                $('.color-price span').text(basePrice.toFixed(2));
                $('.headboard-price span').text(basePrice.toFixed(2));

                updateTotalPrice();
                // Save price in the hidden input field
                $(".next-btn").prop("disabled", false).css("opacity",
                    "1"); // Enable next button and reset opacity otherwise

            });

            $(".color-selection").click(function() {
                var imgSrc = $(this).data("image");

                // Update the right section image
                $("#colorPreview").attr("src", imgSrc);

                // Remove active class from all and add to clicked one
                $(".color-selection").removeClass("selected");
                $(this).addClass("selected");

                // Optional: Update the selected data
                let selectedColor = $(this).find(".color-text").text().trim();
                let stepHeading = $(".step:visible h2").text().trim();

                if (selectedColor && stepHeading) {
                    selectedData[stepHeading] = selectedColor;
                }
            });


            $('.headboard-option').on('click', function() {
                let price = parseFloat($(this).find('.headboard-price').text()) || 0; // Get headboard price

                headboardPrice = price; // Store price globally

                var totalheadboardPrice = basePrice + price;

                let selectedOption = $(this);
                let blackImageUrl = selectedOption.data('black-image'); // Get black image URL
                let whiteImageUrl = selectedOption.data('white-image');

                if ($(".color-selection.selected").hasClass("color-Black")) {
                    $('#headboardPreview').attr('src', blackImageUrl); // Show black image
                } else if ($(".color-selection.selected").hasClass("color-White")) {
                    $('#headboardPreview').attr('src', whiteImageUrl); // Show white image
                } else {
                    $('#headboardPreview').attr('src',
                        blackImageUrl); // Default to black if no color selected
                }


                // **Update the displayed headboard price**
                $('.headboard-price span').text(totalheadboardPrice.toFixed(2));
                $('.canopy-price span').text(totalheadboardPrice.toFixed(2));



                let selectedHeadboard = $(this).find('.headboard-text').text().trim();
                let stepHeading = "Selected headboard";

                // console.log(" selectedHeadboard:", selectedHeadboard);
                // console.log("Step Heading:", stepHeading);

                // Save the selected headboard option and its price in the selectedData object
                if (stepHeading) {
                    selectedData[stepHeading] = selectedHeadboard;
                }

                // Update total price
                updateTotalPrice();
                $(".headboard-option").removeClass("selected-active");

                // Add 'selected-active' class to the clicked headboard option
                $(this).addClass("selected-active");
            });


            $('.canopy-option').on('click', function() {
                let blackImageUrl = $(this).data('black-image'); // Get black image URL
                let whiteImageUrl = $(this).data('white-image'); // Get white image URL
                let price = parseFloat($(this).data('price')) || 0; // Get price of selected canopy

                canopyPrice = price; // Store the canopy price globally

                var totalcanopyPrice = basePrice + colorprice + headboardPrice + price;

                // console.log("Selected Canopy Price:", canopyPrice);

                // Check selected color and update image accordingly
                if ($(".color-selection.selected").hasClass("color-Black")) {
                    $('#canopyPreview').attr('src', blackImageUrl); // Show black image
                } else if ($(".color-selection.selected").hasClass("color-White")) {
                    $('#canopyPreview').attr('src', whiteImageUrl); // Show white image
                } else {
                    $('#canopyPreview').attr('src', blackImageUrl); // Default to black if no color selected
                }

                $(".tray-option").parent().addClass("tray-choosen")
                    .hide(); // Initially hide all tray options

                let selectedCanopyText = $(this).find("p").text().trim().toLowerCase();
                // console.log("🔹 Selected Canopy:", selectedCanopyText); // Debugging

                let traysToShow = [];

                $(".tray-option").each(function() {
                    let trayText = $(this).find("p").text().trim().toLowerCase();
                    // console.log("🔍 Checking Tray:", trayText); // Debugging

                    if (selectedCanopyText === "no canopy") {
                        if (trayText === "no tray sides" || trayText === "1800mm length") {
                            traysToShow.push(trayText);
                        }
                    } else if (selectedCanopyText === "800mm long canopy") {
                        if (trayText === "no tray sides" || trayText === "1000mm length") {
                            traysToShow.push(trayText);
                        }
                    } else if (selectedCanopyText === "1200mm long canopy") {
                        if (trayText === "no tray sides" || trayText === "600mm length") {
                            traysToShow.push(trayText);
                        }
                    } else if (selectedCanopyText === "1650mm long canopy") {
                        if (trayText === "no tray sides") {
                            traysToShow.push(trayText);
                        }
                    }
                });

                // console.log("✅ Trays to Show:", traysToShow); // Debugging

                // Show only the matched trays
                $(".tray-option").each(function() {
                    let trayText = $(this).find("p").text().trim().toLowerCase();

                    if (traysToShow.includes(trayText)) {
                        $(this).parent().removeClass("tray-choosen").show();
                        // console.log(`✅ Showing Tray: ${trayText}`);
                    } else {
                        $(this).parent().addClass("tray-choosen").hide();
                        // console.log(`❌ Hiding Tray: ${trayText}`);
                    }
                });


                // Update the displayed price for the canopy option
                $('.canopy-price span').text(totalcanopyPrice.toFixed(2));
                $('.tray-price span').text(totalcanopyPrice.toFixed(2));

                // Recalculate total price
                updateTotalPrice();

                let selectedcanopy = $(this).find('.canopy-text').text().trim();
                let stepHeadingcanopy = "Selected Canopy";

                // console.log(" selectedcanopy:", selectedcanopy);
                // console.log("Step Heading:", stepHeadingcanopy);

                // Save the selected headboard option and its price in the selectedData object
                if (stepHeadingcanopy) {
                    selectedData[stepHeadingcanopy] = selectedcanopy;
                }

                // Remove 'selected-active' class from all other canopy options
                $(".canopy-option").removeClass("selected-active");

                // Add 'selected-active' class to the clicked canopy option
                $(this).addClass("selected-active");
            });


            $(".tray-option").on("click", function() {
                let blackImageUrl = $(this).data("black-image"); // Get black image URL
                let whiteImageUrl = $(this).data("white-image"); // Get white image URL
                let price = parseFloat($(this).data("price")) || 0; // Get price of selected option

                trayPrice = price; // Store the selected price globally

                var totaltrayPrice = basePrice + colorprice + headboardPrice + canopyPrice + price;

                // Check selected color and update image accordingly
                if ($(".color-selection.selected").hasClass("color-Black")) {
                    $("#trayPreview").attr("src", blackImageUrl); // Show black image
                } else if ($(".color-selection.selected").hasClass("color-White")) {
                    $("#trayPreview").attr("src", whiteImageUrl); // Show white image
                } else {
                    $("#trayPreview").attr("src", blackImageUrl); // Default to black if no color selected
                }




                // Update the displayed price
                $(".tray-price span").text(totaltrayPrice.toFixed(2));
                $(".internals-price span").text(totaltrayPrice.toFixed(2));
                $(".trundle-price span").text(totaltrayPrice.toFixed(2));

                // Recalculate total price
                updateTotalPrice();

                let selectedtraysides = $(this).find('.tray-text').text().trim();
                let stepHeadingtray = "Selected Tray Sides";

                // console.log(" selectedtraysides:", selectedtraysides);
                // console.log("Step Heading:", stepHeadingtray);

                // Save the selected headboard option and its price in the selectedData object
                if (stepHeadingtray) {
                    selectedData[stepHeadingtray] = selectedtraysides;
                }

                // Remove 'selected-active' class from all other tray options
                $(".tray-option").removeClass("selected-active");

                // Add 'selected-active' class to the clicked option
                $(this).addClass("selected-active");
            });


            $('.trundle-option').on('click', function() {
                let price = parseFloat($(this).find('.trundle-price-initial').text()) ||
                    0; // Get trundle price
                // console.log("Selected Trundle Price:", price);
                trundlePrice = price; // Store price globally

                var totaltrundlePrice = basePrice + colorprice + headboardPrice + canopyPrice + trayPrice +
                    totalinternalPrice + trundlePrice;

                // updatePreviewImage($(this), '#trundlePreview'); // Update trundle image
                $(".trundle-price span").text(totaltrundlePrice.toFixed(2));
                $(".external-price span").text(totaltrundlePrice.toFixed(2));

                updateTotalPrice();

                let selectedtrundle = $(this).find('.trundle-text').text().trim();
                let stepHeadingtrundle = "Selected Trundle";

                // console.log(" selectedtrundle:", selectedtrundle);
                // console.log("stepHeadingtrundle:", stepHeadingtrundle);

                // Save the selected headboard option and its price in the selectedData object
                if (stepHeadingtrundle) {
                    selectedData[stepHeadingtrundle] = selectedtrundle;
                }

                $(".trundle-option").removeClass("selected-active");
                $(this).addClass("selected-active");
            });





            // Event listener using event delegation for dynamically generated submit button
            $(document).on("click", ".submit-btn", function(e) {
                e.preventDefault(); // Prevent form submission if inside a form
                // console.log("Submit button clicked!"); // Debugging log

                // Collect form data
                // Log data before submission
                if (!validateStep9()) {
                    return; // Stop execution if validation fails
                }
                collectChangedData();

                $(".submit-btn").prop("disabled", true).text("Submitting...");

                // console.log("Collected Data:", selectedData);

                // Optionally hide Step 9 and show Step 10
                // $(".nav-container").css("display", "none");
                // $(".step-10").css("display", "block"); // Make sure it gets displayed properly
                $(".step:visible").last().hide();
                // Show the final step
                $(".step-last").show();


            });



            function validateStep9() {
                let isValid = true;

                // Clear previous errors
                $(".error-message").text(""); // Remove all error messages before validation

                // Validate each dynamically generated field
                $("input[type='text']").each(function() {
                    let input = $(this);
                    let value = input.val().trim();
                    if (value === "") {
                        showError(input, "This field is required.");
                        isValid = false;
                    }
                });

                if (!$("#agree").is(":checked")) {
                    showError("#agree", "You must agree to the terms and conditions.");
                    isValid = false;
                }

                return isValid;
            }

            // Function to display error messages under the input field
            function showError(inputSelector, message) {
                let inputField = $(inputSelector);

                // Find or create an error message span
                let errorMessage = inputField.siblings(".error-message");

                if (errorMessage.length === 0) {
                    errorMessage = $("<span class='error-message'></span>").css("color", "red");
                    inputField.after(errorMessage); // Add error message right after the input field
                }

                errorMessage.text(message); // Set the error message
            }

            // Clear error on input change
            $(document).on("input", "input", function() {
                $(this).siblings(".error-message").text(""); // Remove error when user types
            });

            $(document).on("click", ".back-btn.reload-btn", function() {
                location.reload(); // Reload the current page
            });








            let products = <?php echo json_encode($products); ?>;

            let internal_options = [];

            function renderProducts() {
                const container = $("#product-container");
                container.empty(); // Clear previous items before rendering

                let filteredProducts = products.filter(product => product.internal_external === "internal");

                filteredProducts.forEach((product, index) => {
                    let existingProduct = internal_options.find(opt => opt.name === product.name);
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
                        <div class="card bg-secondary text-white product-card" data-name="${product.name}" data-max="${maxQuantity}">
                            <p class="card-title mb-0">${product.name}</p>
                            <div class="product-image-con product-image-con02">
                            <img src="{{ asset('${product.image}') }}" class="card-img-top" alt="${product.name}">
                                <span class="product-price-con card-text fw-bold me-2">+$${product.price}</span>
                            </div>
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

                // $(".product-card").off("click").on("click", function(e) {
                //     // Prevent event from firing when clicking inside buttons
                //     if ($(e.target).is("button")) return;

                //     let card = $(this);
                //     let productName = card.data("name");
                //     let product = filteredProducts.find(p => p.name === productName);
                //     let maxQuantity = product.quantity;
                //     let index = internal_options.findIndex(opt => opt.name === productName);
                //     let quantityDisplay = card.find(".quantity-display");
                //     let optionsContainer = card.find(".options-container");
                //     let addBtn = card.find(".add-btn");
                //     let removeBtn = card.find(".remove-btn");

                //     if (index === -1) {
                //         internal_options.push({
                //             name: productName,
                //             price: product.price,
                //             quantity: 1
                //         });

                //         if (maxQuantity === 1) {
                //             addBtn.addClass("d-none");
                //             removeBtn.removeClass("d-none");
                //         } else {
                //             addBtn.addClass("d-none");
                //             optionsContainer.removeClass("d-none");
                //             quantityDisplay.text(1);
                //         }
                //     } else {
                //         internal_options.splice(index, 1);
                //         addBtn.removeClass("d-none");
                //         removeBtn.addClass("d-none");
                //         optionsContainer.addClass("d-none");
                //     }
                // });

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

                    if (index === -1) {
                        internal_options.push({
                            name: productName,
                            price: product.price,
                            quantity: 1
                        });

                        $(this).addClass("d-none"); // Hide "Add"
                        if (maxQuantity === 1) {
                            removeBtn.removeClass("d-none"); // Show "Remove"
                        } else {
                            optionsContainer.removeClass("d-none"); // Show `- 1 +`
                            quantityDisplay.text(1);
                        }
                    }
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
                    }
                });

                // ✅ Increment Quantity (Respect DB Limit)
                $(".increment").off("click").on("click", function() {
                    let card = $(this).closest(".product-card");
                    let productName = card.data("name");
                    let index = internal_options.findIndex(opt => opt.name === productName);
                    let quantityDisplay = card.find(".quantity-display");
                    let maxQuantity = parseInt(card.data("max"), 10);

                    if (index !== -1 && internal_options[index].quantity < maxQuantity) {
                        internal_options[index].quantity += 1;
                        quantityDisplay.text(internal_options[index].quantity);
                    }
                });

                // ✅ Decrement Quantity
                $(".decrement").off("click").on("click", function() {
                    let card = $(this).closest(".product-card");
                    let productName = $(this).data("name");
                    let index = internal_options.findIndex(opt => opt.name === productName);
                    let quantityDisplay = card.find(".quantity-display");
                    let optionsContainer = card.find(".options-container");
                    let addBtn = card.find(".add-btn");

                    if (index !== -1) {
                        if (internal_options[index].quantity > 1) {
                            internal_options[index].quantity -= 1;
                            quantityDisplay.text(internal_options[index].quantity);
                        }

                        if (internal_options[index].quantity === 1) {
                            optionsContainer.addClass("d-none"); // Hide `- 1 +`
                            addBtn.removeClass("d-none"); // Show "Add"
                            internal_options.splice(index, 1); // Remove from array
                        }
                    }
                });
            }


            $(document).ready(function() {
                renderProducts(); // Render products on page load
            });

            function updateInternalPrice() {
                totalinternalPrice = internal_options.reduce((total, product) => {
                    return total + product.price * product.quantity;
                }, 0);

                // Calculate total before showing it
                let finalPrice = basePrice + colorprice + headboardPrice + canopyPrice + trayPrice +
                    totalinternalPrice;


                $(".internals-price span").text(finalPrice.toFixed(2));
                $(".trundle-price span").text(finalPrice.toFixed(2));
            }

            $(document).on("click", ".add-btn, .remove-btn, .increment, .decrement", function() {
                updateInternalPrice();
            });







            let external_options = []; // Store selected external options

            function renderExternalProducts() {
                const container = $("#external-product-container");
                container.empty(); // Clear previous items before rendering

                let filteredProducts = products.filter(product => product.internal_external === "external");

                filteredProducts.forEach((product, index) => {
                    let existingProduct = external_options.find(opt => opt.name === product.name);
                    let selectedQuantity = existingProduct ? existingProduct.quantity : 0;
                    let maxQuantity = product.quantity || 1;
                    let showQuantityControls = selectedQuantity > 1 && maxQuantity > 1 ? "" : "d-none";
                    let showRemoveButton = selectedQuantity === 1 && maxQuantity === 1 ? "" : "d-none";
                    let showAddButton = selectedQuantity === 0 ? "" : "d-none";

                    let productHTML = `
            <div class="col product-item" data-index="${index}">
                <div class="card bg-secondary text-white product-card" data-name="${product.name}" data-max="${maxQuantity}">
                    <p class="card-title mb-0">${product.name}</p>
                    <div class="product-image-con product-image-con02">
                        <img src="{{ asset('${product.image}') }}" class="card-img-top" alt="${product.name}">
                        <span class="product-price-con card-text fw-bold me-2">+$${product.price}</span>
                    </div>
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

                // ✅ Add Button Click
                $(".add-btn-external").off("click").on("click", function() {
                    let card = $(this).closest(".product-card");
                    let productName = card.data("name");
                    let product = filteredProducts.find(p => p.name === productName);
                    let maxQuantity = parseInt(card.data("max"), 10);
                    let index = external_options.findIndex(opt => opt.name === productName);
                    let quantityDisplay = card.find(".quantity-display");
                    let optionsContainer = card.find(".options-container");
                    let removeBtn = card.find(".remove-btn-external");

                    if (index === -1) {
                        external_options.push({
                            name: productName,
                            price: product.price,
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
                    updateExternalPrice();
                });

                // ✅ Remove Button Click
                $(".remove-btn-external").off("click").on("click", function() {
                    let card = $(this).closest(".product-card");
                    let productName = card.data("name");
                    let index = external_options.findIndex(opt => opt.name === productName);
                    let addBtn = card.find(".add-btn-external");
                    let optionsContainer = card.find(".options-container");

                    if (index !== -1) {
                        external_options.splice(index, 1);
                        $(this).addClass("d-none");
                        addBtn.removeClass("d-none");
                        optionsContainer.addClass("d-none"); // Hide quantity controls
                    }
                    updateExternalPrice();
                });

                // ✅ Increment Quantity (Respect DB Limit)
                $(".increment-external").off("click").on("click", function() {
                    let card = $(this).closest(".product-card");
                    let productName = card.data("name");
                    let index = external_options.findIndex(opt => opt.name === productName);
                    let quantityDisplay = card.find(".quantity-display");
                    let maxQuantity = parseInt(card.data("max"), 10);

                    if (index !== -1 && external_options[index].quantity < maxQuantity) {
                        external_options[index].quantity += 1;
                        quantityDisplay.text(external_options[index].quantity);
                    }
                    updateExternalPrice();
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

                        if (external_options[index].quantity === 1) {
                            optionsContainer.addClass("d-none");
                            addBtn.removeClass("d-none");
                            external_options.splice(index, 1);
                        }
                    }
                    updateExternalPrice();
                });
            }

            $(document).ready(function() {
                renderExternalProducts(); // Render external products on page load
            });

            function updateExternalPrice() {
                totalexternalPrice = external_options.reduce((total, product) => {
                    return total + product.price * product.quantity;
                }, 0);

                let finalPrice = basePrice + colorprice + headboardPrice + canopyPrice + trayPrice + trundlePrice +
                    totalinternalPrice + totalexternalPrice;

                $(".external-price span").text(finalPrice.toFixed(2));

            }

            // ✅ Ensure price updates after every relevant action
            $(document).on("click",
                ".add-btn-external, .remove-btn-external, .increment-external, .decrement-external",
                function() {
                    updateExternalPrice();
                });



        });
    </script>
</body>

</html>
