@extends('backEnd.master')
@section('title') 
@lang('bulkprint::bulk.generate_id_card')
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-20 up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1> @lang('bulkprint::bulk.generate_id_card')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('bulkprint::bulk.bulkprint')</a>
                <a href="#">@lang('bulkprint::bulk.generate_id_card')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-id-card-bulk-print-search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        <div class="row">
            <div class="col-lg-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="main-title">
                            <h3 class="mb-15">@lang('common.select_criteria') </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            <div class="col-lg-4 mt-30-md">
                                <label class="primary_input_label" for="">@lang('common.select_role')  <span class="text-danger"> *</span></label>
                                <select class="primary_select form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role_id">
                                   
                                    <option data-display="@lang('common.select_role') *" value="">@lang('common.select_role') *</option>
                                    @foreach($roles as $role)
                                    <option value="{{@$role->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{@$role->name}}</option>
                                    @endforeach
                                </select>
                               
                                @if ($errors->has('role'))
                                <span class="text-danger">
                                    {{ @$errors->first('role') }}
                                </span>
                                @endif
                            </div>
                            
                            
                            <div class="col-lg-4 mt-30-md" id="id-card-div">
                                <label class="primary_input_label" for="">@lang('common.select_id_card')  <span class="text-danger"> *</span></label>
                                <select class="primary_select  form-control{{ $errors->has('id_card') ? ' is-invalid' : '' }}" id="id_card_list" name="id_card">
                                   
                                    <option data-display=" @lang('common.select_id_card') *" value=""> @lang('common.select_id_card') *</option>
                                  
                                </select>
                                <div class="pull-right loader loader_style" id="select_id_card_loader">
                                    <img class="loader_img_style" src="{{asset('/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('id_card'))
                                <span class="text-danger ">
                                    {{ @$errors->first('id_card') }}
                                </span>
                                @endif
                            </div>

                            <div class="col-lg-4 mt-30-md">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">@lang('bulkprint::bulk.grid_gap') (px) <span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control{{ $errors->has('grid_gap') ? ' is-invalid' : '' }}" type="number" name="grid_gap" autocomplete="off" value="{{old('grid_gap')}}">
                                    
                                    
                                    @if ($errors->has('grid_gap'))
                                    <span class="text-danger" >
                                        {{ $errors->first('grid_gap') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>


@if(isset($students))
 <section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">

        <div class="row mt-40">  
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-2 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">@lang('common.student_list')</h3>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <a href="javascript:;" id="genearte-id-card-print-button" class="primary-btn small fix-gr-bg" >
                                @lang('bulkprint::bulk.generate')
                            </a>
                        </div>
                    </div>
    
    
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table school-table-style" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">
                                            <input type="checkbox" id="checkAll" class="common-checkbox generate-id-card-print-all" name="checkAll" value="">
                                            <label for="checkAll">@lang('common.all')</label>
                                        </th>
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('common.class_Sec')</th>
                                        <th>@lang('student.father_name')</th>
                                        <th>@lang('common.date_of_birth')</th>
                                        <th>@lang('common.gender')</th>
                                        <th>@lang('common.mobile')</th>
                                    </tr>
                                </thead>
    
                                <tbody>
                                   @foreach($students as $student)
                                   <tr>
                                        <td>
                                            <input type="checkbox" id="student.{{@$student->id}}" class="common-checkbox generate-id-card-print" name="student_checked[]" value="{{@$student->id}}">
                                                <label for="student.{{@$student->id}}"></label>
                                            </td>
                                        <td>
                                            {{@$student->admission_no}}
                                        </td>
                                        <td>{{@$student->full_name}}</td>
                                        <td>{{@$student->class !=""?@$student->class->class_name:""}} ({{@$student->section!=""?@$student->section->section_name:""}})</td>
                                        <td>{{@$student->parents !=""?@$student->parents->fathers_name:""}}</td>
                                        <td> 
                                            {{@$student->date_of_birth != ""? dateConvert(@$student->date_of_birth):''}}
                                        </td>
                                        <td>{{@$student->gender!=""?@$student->gender->base_setup_name:""}}</td>
                                        <td>{{@$student->mobile}}</td>
                                    </tr>
                                   @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@section('script')
<script>
$(document).ready(function() {
    $("#role_id").on("change", function() {
        var url = $("#url").val();
        var i = 0;

        var formData = {
            role_id: $(this).val(),
          
        };
     
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/bulkprint/" + "ajaxIdCard",
            beforeSend: function() {
                $('#select_id_card_loader').addClass('pre_loader');
                $('#select_id_card_loader').removeClass('loader');
            },
            success: function(data) {            
                $.each(data, function(i, item) {
                    if (item.length) {
                        $("#id_card_list").find("option").not(":first").remove();
                        $("#id-card-div ul").find("li").not(":first").remove();

                        $.each(item, function(i, idcard) {
                            $("#id_card_list").append(
                                $("<option>", {
                                    value: idcard.id,
                                    text: idcard.title,
                                })
                            );

                            $("#id-card-div ul").append(
                                "<li data-value='" +
                                idcard.id +
                                "' class='option'>" +
                                idcard.title +
                                "</li>"
                            );
                        });
                    } else {
                        $("#id-card-div .current").html("ID Card *");
                        $("#id_card_list").find("option").not(":first").remove();
                        $("#id-card-div ul").find("li").not(":first").remove();
                    }
                });
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                i--;
                if (i <= 0) {
                    $('#select_id_card_loader').removeClass('pre_loader');
                    $('#select_id_card_loader').addClass('loader');
                }
            }
        });
    });
});
</script>
@endsection
@endsection
