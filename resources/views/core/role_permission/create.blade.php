@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('New user form') }}</h3>
            </div>
            <form action="{{ route('core.role.permission.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body col-md-3" id="role-section">
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
                                <option value="{{ $role->id }}" {{ old('role_id')==$role->id ? "selected" : "" }}>{{
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
                  
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            getRoleWisePermissionList({{old('role_id')}});
            
            $('#role_id').on('change', function () {
                var role_id = $(this).val();
                getRoleWisePermissionList(role_id);
            });

        });
        function getRoleWisePermissionList(role_id){
            $.ajax({
                url: "{{ route('core.role.permission.get-role-wise') }}",
                type: "POST",
                data: {
                    role_id: role_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('.box-footer').empty();
                    $('#role-section').next().empty();
                    $('#role-section').next().append(data.role_page_view);
                }
            });
        }
        
    </script>

@endpush