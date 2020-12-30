@extends('layouts.app')

@section('title', __( 'lang_v1.view_user' ))

@section('content')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang( 'lang_v1.view_user' )</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                {!! Form::select('user_id', $users, $user->id , ['class' => 'form-control select2', 'id' => 'user_id']); !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                            <a href="#user_info_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-user" aria-hidden="true"></i> @lang( 'lang_v1.user_info')</a>
                        </li>
                        
                        <li>
                            <a href="#documents_and_notes_tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-paperclip" aria-hidden="true"></i> @lang('lang_v1.documents_and_notes')</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="user_info_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <h3 class="profile-username">{{$user->user_full_name}}</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>@lang( 'business.email' ): </strong> {{$user->email}}</p>
                                        <p><strong>@lang( 'user.role' ): </strong> {{$user->role_name}}</p>
                                        <p><strong>@lang( 'business.username' ): </strong> {{$user->username}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>@lang( 'lang_v1.cmmsn_percent' ): </strong> {{$user->cmmsn_percent}}%</p>
                                        <p>@if($user->status == 'active') <span class="label label-success">@lang('business.is_active')</span> @else <span class="label label-danger">@lang('business.inactive')</span> @endif</p>
                                        <p><strong>@lang( 'lang_v1.cmmsn_percent' ): </strong> {{$user->cmmsn_percent}}%</p>
                                        @php
                                            $selected_contacts = ''
                                        @endphp
                                        @if(count($user->contactAccess)) 
                                            @php
                                                $selected_contacts_array = [];
                                            @endphp
                                            @foreach($user->contactAccess as $contact) 
                                                @php
                                                    $selected_contacts_array[] = $contact->name; 
                                                @endphp
                                            @endforeach 
                                            @php
                                                $selected_contacts = implode(', ', $selected_contacts_array);
                                            @endphp
                                        @else 
                                            @php
                                                $selected_contacts = __('lang_v1.all'); 
                                            @endphp
                                        @endif
                                        <p><strong>@lang( 'lang_v1.allowed_contacts' ): </strong> {{$selected_contacts}}</p>
                                    </div>
                                </div>
                            </div>
                            @include('user.show_details')
                        </div>
                        <div class="tab-pane" id="documents_and_notes_tab">
                            <!-- model id like project_id, user_id -->
                            <input type="hidden" name="notable_id" id="notable_id" value="{{$user->id}}">
                            <!-- model name like App\User -->
                            <input type="hidden" name="notable_type" id="notable_type" value="App\User">
                            <div class="document_note_body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>    
@endsection
@section('javascript')
    <!-- document & note.js -->
    @include('documents_and_notes.document_and_note_js')

    <script type="text/javascript">
        $(document).ready( function(){
            $('#user_id').change( function() {
                if ($(this).val()) {
                    window.location = "{{url('/users')}}/" + $(this).val();
                }
            });
        });
    </script>
@endsection