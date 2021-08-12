{{--
  |  Role Create Page
  |
  |  @package resources/views/admin/role/create
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content role-new-wrapper">
        <div class="card card-margin">
            {!! Form::open(['route' => 'roles.store', 'method' => 'post', 'id'=>'create-role']) !!}
            @csrf
            <div class="card-header header-elements-inline">
                <h5 class="card-title">@lang('views.add_role')</h5>
                <div class="header-elements">
                    <a href="{{url()->previous()}}" class="btn btn-danger btn-submit-cancel"> @lang('views.cancel')</a>
                    <button type="submit" class="btn btn-primary ml-2 btn-submit-cancel">@lang('views.submit')</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="font-weight-semibold text-default">@lang('views.attribute_name', ['attribute' => Lang::get('views.role')])</label>
                                        <input type="text" placeholder="@lang('views.attribute_name', ['attribute' => Lang::get('views.role')])" class="form-control" name="name">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <fieldset class="custom-border">
                            <legend class="custom-border">@lang('views.permissions')</legend>

                            <div class="row checkbox-parent">
                                <div class="form-group mb-12 mb-md-12">
                                    <div class="form-check form-check-inline select-all-wrapper">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input-styled select-all" data-fouc>
                                            @lang('views.check_all')
                                        </label>

                                    </div>
                                </div>
                            <div class="col-md-12">
                                           @foreach($permissions as $key => $permissionGroup)
                                                @if($permissionGroup->count() > 0)
                                                <div class="row role-full-wrapper">
                                                    <div class="col-12 role-type-wrapper">
                                                        <div class="role-type-txt">
                                                        <p>@if(isset($permissionsGroup[$key])) 
                                                            {{$permissionsGroup[$key] }}
                                                            
                                                        @endif</p>
                                                    </div>
                                                    </div>
                                                <div class="form-group create-role-form">
                                                    <?php 
                                                      $sortedPermissionArray  = [];
                                                      foreach ($permissionGroup as $key => $value) {
                                                          $sortedPermissionArray[$value->id] = $value;
                                                      }
                                                      ksort($sortedPermissionArray);
                                                    ?>
                                                @foreach($sortedPermissionArray as $permission)
                                                <div class="col-md-2 margin-bottom-10 form-check form-check-inline create-role-wrapper">
                                                    <input type="checkbox" class="form-check-input-styled checkbox"
                                                           name="permissions[]" value="{{ $permission->id}}" data-fouc>
                                                    {{$permission->name}}
                                                </div>
                                            @endforeach
                                            </div>
                                            </div>
                                                @endif
                                             @endforeach
                                    </div>
                                <label class="form-check-label"></label>
                            </div>
                        </fieldset>
                    </div>

                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
<!-- /content area -->
@endsection
@section('scripts')
    @include('role::scripts.common')
    {!! JsValidator::formRequest('Softech\Role\Http\Requests\RoleRequest', '#create-role') !!}
@endsection
