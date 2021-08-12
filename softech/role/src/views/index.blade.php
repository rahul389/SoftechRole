{{--
  |  Role Index Page
  |
  |  @package resources/views/admin/role/index
  |
  |  @author Rahul Sharma <rahul.sharma@surmountsoft.in>
  |
  |  @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
  |
--}}

@extends('role::layouts.app')
@section('content')
    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">
                <!-- Users -->
                <div class="card create-role-wrapper">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">@lang('views.roles')</h5>
                          <div class="header-elements">
                              <div class="text-right add-btn-wrapper">
                                  <a href="{{route('roles.create')}}"
                                     class="btn btn-primary create-role">@lang('views.add_role')</a>
                              </div>
                          </div>
                    </div>
                    <table class="table custom-roles-tbl" id="roles-table" style="width:100%">
                        <thead>
                        <tr>
                            <th>@lang('views.role_name')</th>
                            <th style="padding-left: 30px !important;">@lang('views.status')</th>
                            <th style="padding-left: 35px !important;">@lang('views.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /Users -->

            </div>
        </div>
        <!-- /dashboard content -->

    </div>
    <!-- /content area -->
@endsection
@section('scripts')
    @include('role::scripts.common')
@endsection
