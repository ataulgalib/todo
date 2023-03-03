
@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Edit User form') }}</h3>
            </div>
            <form action="{{ route('core.user.update',$data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="box-body col-md-6">
                    <div class="form-group">
                        <label for="email"> {{ __('Email address') }}</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder=" {{ __('Enter Email') }}" value="{{ old('email', $data->email) }}">
                        @error('email')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <span class="error-text">{{ __('Application Defult Password
                            is'.config('configuration.application_defult_password')) }}</span>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="{{ __('If you want to change password, enter new password here.') }}"
                            value="{{ old('password') }}">
                        @error('password')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="box-body col-md-6">
                    <div class="form-group">
                        <label for="name">{{ __('User Name') }}</label>
                        <input type="name" name="name" class="form-control" id="name" placeholder="{{ __('User Name') }}"
                            value="{{ old('name', $data->name) }}">
                        @error('name')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{-- <select class="form-control selectpicker" name="role_id" id="role_id"
                            data-live-search="true" style="width: 100%;" data-hide-disabled="true" multiple
                            data-actions-box="true"> --}}
                            <label for="role">{{ __('Role') }}</label>
                            <select class="form-control selectpicker" name="role_id" id="role_id"
                                data-live-search="true">
                                @if(sizeof($roles) > 0)
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ (old('role_id') || $data->role_id) ==$role->id ? "selected" : "" }}>{{
                                    $role->name }}</option>
                                @endforeach
                                @endif

                            </select>
                            @error('role_id')
                            <span class="error-text">{{ $role_id }}</span>
                            @enderror
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary pull-right form-submit-btn">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
