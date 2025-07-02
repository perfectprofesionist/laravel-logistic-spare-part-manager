<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FormController;

use App\Http\Controllers\FormNewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ColorSelectionController;
use App\Http\Controllers\DraftFormController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;

// Public home route (shows home form)
Route::get('/', [FormController::class, 'homeform'])->name('forms.homeform');

// Authentication routes (login, register, etc.)
Auth::routes();

// Custom login route: redirects logged-in users to forms-new index
Route::get('/login', function () {
    return Auth::check()
        ? redirect()->route('forms-new.index') // Redirect if already logged in
        : view('auth.login'); // Otherwise, show login view
})->name('login');

// Back-office redirect helper
Route::get('/back', function () {
    return Auth::check()
        ? redirect('/back/forms-new')
        : redirect()->route('login');
});

// All admin/back-office routes (require authentication)
Route::middleware(['auth'])->prefix('back')->group(function () {
    // --- Forms Section ---
    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
    Route::post('/forms/store', [FormController::class, 'store'])->name('forms.store');
    Route::get('/forms/{id}/form-builder', [FormController::class, 'form_builder'])->name('forms.form_builder');
    Route::get('/forms/{id}/edit', [FormController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{id}', [FormController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{id}', [FormController::class, 'destroy'])->name('forms.destroy');
    Route::post('/forms/{id}/publish', [FormController::class, 'publish'])->name('forms.publish');
    Route::post('/forms/{id}/duplicate', [FormController::class, 'duplicate'])->name('forms.duplicate');
    Route::post('/forms/set-as-home', [FormController::class, 'setAsHome'])->name('forms.setAsHome');
    Route::get('/get-models', [FormController::class, 'getModels'])->name('get.models');
    Route::get('/forms/{slug}', [FormController::class, 'show'])->name('forms.show');

    // --- Products Section ---
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/save-logic',[ProductController::class, 'storeRelation'])->name('products.storeRelation');
    Route::post('/products/update-logic',[ProductController::class, 'updateRelation'])->name('products.updateRelation');
    Route::delete('/products/delete-relation/{id}', [ProductController::class, 'deleteRelation'])->name('products.deleteRelation');

    // --- Make Section ---
    Route::get('/make', [MakeController::class, 'index'])->name('make.index');
    Route::get('/make/create', [MakeController::class, 'create'])->name('make.create');
    Route::post('/make', [MakeController::class, 'store'])->name('make.store');
    Route::get('/make/edit/{id}', [MakeController::class, 'edit'])->name('make.edit');
    Route::put('/make/update/{id}', [MakeController::class, 'update'])->name('make.update');
    Route::delete('/make/delete/{id}', [MakeController::class, 'destroy'])->name('make.destroy');

    // --- Model Section ---
    Route::get('/model', [ModelController::class, 'index'])->name('model.index');
    Route::get('/model/create', [ModelController::class, 'create'])->name('model.create');
    Route::post('/model', [ModelController::class, 'store'])->name('model.store');
    Route::get('/model/edit/{id}', [ModelController::class, 'edit'])->name('model.edit');
    Route::put('/model/update/{id}', [ModelController::class, 'update'])->name('model.update');
    Route::delete('/model/delete/{id}', [ModelController::class, 'destroy'])->name('model.destroy');

    // --- Color Selection Section ---
    Route::get('color_selection', [ColorSelectionController::class, 'index'])->name('color_selection.index');
    Route::get('color_selection/create', [ColorSelectionController::class, 'create'])->name('color_selection.create');
    Route::post('color_selection', [ColorSelectionController::class, 'store'])->name('color_selection.store');
    Route::get('color_selection/{color_selection}/edit', [ColorSelectionController::class, 'edit'])->name('color_selection.edit');
    Route::put('color_selection/{color_selection}', [ColorSelectionController::class, 'update'])->name('color_selection.update');
    Route::delete('color_selection/{color_selection}', [ColorSelectionController::class, 'destroy'])->name('color_selection.destroy');

    // --- Import/Export Section ---
    Route::get('/model/import', [ExcelImportController::class, 'importModel'])->name('model.import');
    Route::get('/make/import', [ExcelImportController::class, 'importMake'])->name('make.import');
    Route::get('/model/export', [ExcelImportController::class, 'exportModel'])->name('model.export');
    Route::get('/import', [ExcelImportController::class, 'importView'])->name('import.view');
    Route::post('/import', [ExcelImportController::class, 'import'])->name('model.excel');
    Route::post('/import/make', [ExcelImportController::class, 'makeimport'])->name('make.excel');

    // --- Recipe & Logic Section ---
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/getRecipe/{id}', [RecipeController::class, 'getRecipe'])->name('recipes.getRecipe');
    Route::post('/logics', [LogicController::class, 'storeOrUpdate'])->name('logics.storeOrUpdate');
    Route::get('/form/logics/{formId}', [LogicController::class, 'getLogicsForForm'])->name('logics.getFormLogics');
    Route::get('/getPrice', [ModelController::class, 'getPrice'])->name('model.getprice');

    // --- Admin/Settings Section ---
    Route::post('/forms/save-admin-emails', [FormController::class, 'saveAdminEmails'])->name('forms.saveAdminEmails');
    Route::post('/forms/{id}/toggle-status', [FormController::class, 'toggleStatus'])->name('forms.toggleStatus');
    Route::get('/forms/{form}/submissions', [FormSubmissionController::class, 'formSubmissions'])->name('forms.submissions');
    Route::get('/form-submissions', [FormSubmissionController::class, 'index'])->name('form-submissions.index');
    Route::get('/form-submissions/{id}', [FormSubmissionController::class, 'show'])->name('form-submissions.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- File Uploads ---
    Route::post('/upload/color-image', [FormController::class, 'uploadColorImage'])->name('upload.color-image');
    Route::post('/upload/white-image', [FormController::class, 'uploadWhiteImage'])->name('upload.white-image');
    Route::post('/upload/black-image', [FormController::class, 'uploadBlackImage'])->name('upload.black-image');
    Route::post('/upload/slide-image', [FormController::class, 'uploadSlideImage'])->name('upload.slide-image');
    Route::post('/delete/black-image', [FormController::class, 'deleteBlackImage'])->name('delete.image');
    Route::post('/delete/white-image', [FormController::class, 'deleteWhiteImage'])->name('delete.white.image');

    /** New form layouts (FormNewController) */
    Route::get('/forms-new', [FormNewController::class, 'index'])->name('forms-new.index');
    Route::get('/forms-new/create', [FormNewController::class, 'create'])->name('forms-new.create');
    Route::post('/forms-new/store', [FormNewController::class, 'store'])->name('forms-new.store');
    Route::get('/forms-new/{id}/form-builder', [FormNewController::class, 'form_builder'])->name('forms-new.form_builder');
    Route::get('/forms-new/{id}/edit', [FormNewController::class, 'edit'])->name('forms-new.edit');
    Route::put('/forms-new/{id}', [FormNewController::class, 'update'])->name('forms-new.update');
    Route::delete('/forms-new/{id}', [FormNewController::class, 'destroy'])->name('forms-new.destroy');
    Route::post('/forms-new/{id}/publish', [FormNewController::class, 'publish'])->name('forms-new.publish');
    Route::post('/forms-new/{id}/duplicate', [FormNewController::class, 'duplicate'])->name('forms-new.duplicate');
    Route::post('/forms-new/saveSteps', [FormNewController::class, 'storeOnlyFormSteps'])->name('forms-new.storeOnlyFormSteps');
    Route::get('/form-new/{id}/conditions', [FormNewController::class, 'showConditions'])->name('form.conditions');
    Route::get('/form-new/{id}/conditions/add', [FormNewController::class, 'addCondition'])->name('form.conditions.add');
    Route::get('/form/logic/edit/{id}', [FormNewController::class, 'editlogic'])->name('form.logic.edit');
    Route::post('/form/logic/update/{id}', [FormNewController::class, 'updatelogic'])->name('form.logic.update');
    Route::post('/form-logic-store', [FormNewController::class, 'storelogic'])->name('form.logic.store');
    Route::delete('/form/logic/{id}', [FormNewController::class, 'deletelogic'])->name('form.logic.delete');
    Route::get('/forms-new/edit', [FormNewController::class, 'editopen'])->name('forms-new.editformdata');
    Route::post('/forms-new/{id}/edit', [FormNewController::class, 'editform'])->name('forms-new.editform');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::put('/messages/{id}', [MessageController::class, 'update'])->name('messages.update');
});

// --- Public AJAX and Form Submission Routes ---
// Get models and years for dropdowns (AJAX)
Route::get('/getModel/{makeId}', [ModelController::class, 'getModel'])->name('model.getmodel');
Route::get('/getYear/{modelId}', [ModelController::class, 'getYear'])->name('model.getyear');

// Public form submission and summary email
Route::post('/send-summary-email', [FormNewController::class, 'sendSummaryEmail'])->name('send.summary.email');

// Show a public form by slug (for users)
Route::get('/{slug}', [FormController::class, 'showForm'])->name('forms.showForm');

// Form auto-save (AJAX)
Route::post('/form/autosave', [FormController::class, 'autoSave']);
