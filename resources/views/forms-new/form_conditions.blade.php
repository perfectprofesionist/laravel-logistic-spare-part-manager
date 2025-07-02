@extends('layouts.app_new')

@section('content')


    <div class="tusform-inner-right-bar">

             <!--Create Form Screen -->
              <!--div class="create-form-outer">
                  <div class="create-form-left"><img src="images/form-pic.png" alt="Form Icon"></div>
                  <div class="create-form-right">
                    <h2>Create Form <span><img src="images/create-form-icon.png" alt="arrow"></span></h2>
                  </div>
              </div-->


              <!--Create Form Screen 02 -->
              <div class="craete-form-outer-panel">
                  <div class="col-12 pade-none create-heading-con">
                    <h2>{{ $form->name ?? '' }} <a href="{{ route('forms-new.edit', ['id' => $form->id]) }}"><img src="{{ asset('images') . '/edit-aarow.svg' }}" alt="icon"></a></h2>
                    <div class="create-form-CTA auto-width"><a href="{{ route('forms-new.index') }}"><img src="{{ asset('images') . '/back-bttn-icon.svg' }} " alt="Plus"> Back</a></div>
                  </div>
                  <div class="col-12 pade-none cont-conditions-added">
                      <h3>Conditions already added on this form are:</h3>
                      <ul class="otr-conditions-list">
                         @forelse($logics as $index => $logic)
                            <li><a href="{{ route('form.logic.edit', $logic->id) }}">
                              {{-- Condition{{ $index + 1 }} — ID: {{ $logic->id }} — --}} {{ $logic->name ?? "Condition ". ($index + 1) }}</a>
                                <form action="{{ route('form.logic.delete', $logic->id) }}" class="delete-logic-form" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:white;cursor:pointer;">
                                        <img src="{{ asset('images') . '/dele.svg' }}" alt="icon">
                                    </button>
                                </form>
                            </li>
                        @empty
                            <!-- <li>No conditions found.</li> -->
                        @endforelse
                    </ul>
                      @if(session('success'))
                          <div id="success-message" class="fw-bold py-2 pr-4 mb-3 d-inline-block" style="font-size: 18px; color: #155724;">
                              {{ session('success') }}
                          </div>
                      @endif




                      <div class="create-form-CTA"><a href="{{ route('form.conditions.add', $form->id) }}"><img src="{{ asset('images') . '/plus-icon.png' }}" alt="Plus"> Add Condition</a></div>
                  </div>
                </div>

              <!--Create Form Screen 03 -->


          </div>

@endsection

@section('customScript')
<script>
    $(document).ready(function () {
         $('form.delete-logic-form').on('submit', function (e) {
            e.preventDefault(); // Prevent default submission initially
            const form = this;

            Swal.fire({
                title: "Do you want to delete condition?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: `Don't delete`
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    // Optional: Show a success message before submitting
                }
                // else: do nothing (form will not be submitted)
            });
        });
    });
</script>

@endsection



