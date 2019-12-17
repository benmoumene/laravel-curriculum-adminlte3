@extends('layouts.master')
@section('title')
    {{ trans('global.organizationtype.title_singular') }} {{ trans('global.list') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="/">Home</a></li>
    <li class="breadcrumb-item active">{{ trans('global.organizationtype.title_singular') }} {{ trans('global.list') }}</li>
    <li class="breadcrumb-item "> <i class="fas fa-question-circle"></i></li>
@endsection
@section('content')
<div class="row">
    <div class="col-4">
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-11">
                        <h5 class="m-0">
                            <i class="fas fa-city"></i> {{ $organizationtype->title }}
                        </h5>
                    </div>
                    <div>
                        @can('organization_type_edit')
                        <a href="{{ route('organizationtypes.edit', $organizationtype->id) }}" >
                            <i class="far fa-edit"></i>
                        </a> 
                        @endcan 
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-external-link-alt"></i> {{ trans('global.organizationtype.fields.external_id') }}</strong>
                <p class="text-muted">
                    {{ $organizationtype->external_id }}
                </p>
                
                <hr>

                <strong><i class="fa fa-map-marker mr-1"></i> {{ trans('global.region') }}</strong>
                <p class="text-muted">
                    {{ $organizationtype->state->lang_de }}, {{ $organizationtype->country->lang_de }}
                </p>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="float-left"></div>
                <small class="float-right">
                    {{ $organizationtype->updated_at }}
                </small> 
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active show" href="#activity" data-toggle="tab">Settings</a></li>

                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="settings">
                        <!-- Settings -->
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div><!-- /.nav-tabs-custom -->
    </div>
</div>
@endsection
