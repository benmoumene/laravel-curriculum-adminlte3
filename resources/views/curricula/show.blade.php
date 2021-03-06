@extends((Auth::user()->id == env('GUEST_USER')) ? 'layouts.contentonly' : 'layouts.master')

@section('title')
    {{ $curriculum->title }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        @if (Auth::user()->id == env('GUEST_USER'))
            <a href="/navigators/{{Auth::user()->organizations()->where('organization_id', '=',  Auth::user()->current_organization_id)->first()->navigators()->first()->id}}">Home</a>
        @else
        <a href="/"><i class="fa fa-home"></i></a>
        @endif
    </li>
    @if(isset($course))
        @can('achievement_access')
            <li class="breadcrumb-item "><a href="/curricula/{{ $course->curriculum_id }}">{{ trans('global.curriculum.title_singular') }}</a></li>
        @endcan
    @else
        <li class="breadcrumb-item "><a href="/curricula/{{$curriculum->id}}">{{ trans('global.curriculum.title_singular') }}</a></li>
    @endif
    <li class="breadcrumb-item "><a href="/documentation" class="text-black-50"><i class="fas fa-question-circle"></i></a></li>
@endsection

@section('content')

<div id="content_top_placeholder" ></div>
@can('achievement_access')
    @if(isset(json_decode($settings)->achievements))
    <table id="users-datatable" class="table table-hover datatable">
        <thead>
            <tr>
                <th width="10"></th>
                <th>{{ trans('global.user.fields.username') }}</th>
                <th>{{ trans('global.user.fields.lastname') }}</th>
                <th>{{ trans('global.user.fields.firstname') }}</th>
                <th>{{ trans('global.role.fields.title') }}</th>
                <th>{{ trans('global.progress.title_singular') }}</th>
            </tr>
        </thead>
    </table>
    @endif
@endcan

<div id="curriculum_view_content" class="row">
   {{--  <div class="col-12">


    @if(!isset(json_decode($settings)->course))

        @include ('forms.input.select',
                   ["model" => "curriculum",
                   "field" => "id",
                   "css" => "pull-right m-0",
                   "style" => "float:left; width:200px",
                   "options"=> auth()->user()->currentCurriculaEnrolments(),
                   "placeholder" => trans('global.curricula_cross_references'),
                   "option_label" => "title",
                   "onchange"=> "triggerSetCrossReferenceCurriculumId(this.value)",
                   "value" =>  old('current_curriculum_cross_reference_id', isset(auth()->user()->current_curriculum_cross_reference_id) ? auth()->user()->current_curriculum_cross_reference_id : '')])
    @endif
    </div>--}}

    <curriculum-view
        ref="curriculumView"
        @if(isset($course))
            :course="{{ $course }}"
        @endif

        @if(isset($logbook))
            :logbook="{{ $logbook }}"
        @endif
        :curriculum="{{ $curriculum }}"
        :objectivetypes="{{ $objectiveTypes }}"
        :settings="{{ $settings }}">
    </curriculum-view>
</div>
<terminal-objective-modal></terminal-objective-modal>
<enabling-objective-modal></enabling-objective-modal>
<content-modal></content-modal>
<content-create-modal></content-create-modal>
<objective-medium-modal></objective-medium-modal>
<medium-modal></medium-modal>
<medium-create-modal></medium-create-modal>
@if(isset($certificates))
    <certificate-generate-modal  :certificates="{{ $certificates }}" ></certificate-generate-modal>
@endif
@endsection
@section('scripts')
@parent
{{--<script>
function triggerSetCrossReferenceCurriculumId(curriculum_id){
    app.__vue__.$refs.curriculumView.setCrossReferenceCurriculumId(curriculum_id);
}
</script>--}}
@if(isset(json_decode($settings)->achievements))
    <script>

function getDatatablesIds(selector){
    return $(selector).DataTable().rows({ selected: true }).ids().toArray();
}

function triggerVueEvent(type){
    if ( type === 'row' ) {
        app.__vue__.$refs.curriculumView.externalEvent(getDatatablesIds('#users-datatable')); //pass Ids to vue component
    }
}

function isElementInViewport (el) {
    //special bonus for those using jQuery
    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }

    var rect = el.getBoundingClientRect();

    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
        rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
    );
}

$(document).ready( function () {
    //let dtButtons = false;//$.extend(true, [], $.fn.dataTable.defaults.buttons)

    table = $('#users-datatable').DataTable({
        ajax: "/courses/list?course_id={{ $course->id }}",
        columns: [
                 { data: 'check'},
                 { data: 'username' },
                 { data: 'lastname' },
                 { data: 'firstname' },
                 { data: 'role' },
                 { data: 'progress' },
                ],
        buttons: [],
    });



    table.on( 'select', function ( e, dt, type, indexes ) { //on select event
        triggerVueEvent(type);
    });
    table.on( 'deselect', function ( e, dt, type, indexes ) { //on deselect event
        triggerVueEvent(type);
    });

    $(window).on("scroll", function(table) {
        if (!isElementInViewport($("#content_top_placeholder"))){
            $("#users-datatable_wrapper").appendTo("#menu_top_placeholder");
            $("#menu_top_placeholder").css({'background-color': '#ecf0f5',  'webkit-transform':'translate3d(0,0,0)'});
            $("#curriculum_view_content").css({'padding-top': '100px'});
            $('.dataTables_length').hide();
            $('.dataTables_filter').hide();
            $('.dataTables_info').hide();
        } else {
            if (isElementInViewport($("#content_top_placeholder"))){
                $("#users-datatable_wrapper").appendTo("#content_top_placeholder");
                $("#menu_top_placeholder").css({'background-color': 'transparent', 'webkit-transform':'translate3d(0,0,0)'});
                $("#curriculum_view_content").css({'padding-top': '0px'});
                $('.dataTables_length').show();
                $('.dataTables_filter').show();
                $('.dataTables_info').show();
            }
        }
    });

 });

    </script>
@endif

@endsection
