@extends('branch.layout.main')
@section('title') Change Course of {{ $data->name }} @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
        @endsection
        
        <div class="row">
            <div class="col s12 m12 l12">
                {!! Form::model($data, ['url' => [env('branch').'/student/changeCourse/'.$data->id],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                <h4 class="header2">Change Course</h4>

                <div class="col s12 m12 l12">
                    <div class="card-panel">
                        <div class="row">
                            <div class="input-field col s12 l4">
                                <select class="browser-default" name="branch_course" required onchange="getBatch(this.value)">
                                    <option value="">Select Course</option>
                                    @foreach($branch_course as $brn_crs)
                                    @if($curr_student_course->branch_course_id != $brn_crs->id)
                                    <option value="{{ $brn_crs->id }}">
                                        {{ $course->find($brn_crs->course_id)->name }} - Fee: {{ $brn_crs->fee }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-field col s12 l4">
                                <select class="browser-default" name="batch" required>
                                    <option value="">Select Batch</option>
                                </select>
                            </div>

                            <div class="input-field col s12 l4">
                                {!! Form::date('course_join',null,['id' => 'course_join','required' => 'required','placeholder' => 'Date Added','class' => 'datepicker']) !!}
                                <label for="course_join" class="active">Course Joining</label>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="header2">Your Course List</h4>

                
                @foreach($student_course as $std_crs)
                <div class="col s12 m12 l12">
                    <div class="card-panel">
                        <div class="row">
                            <div class="input-field col s12 l3">
                                <label class="active">Course</label>
                                {{ $course->find($single_branch_course->find($std_crs->branch_course_id)->course_id)->name }}
                                @if($std_crs->course_join <= $today && $std_crs->course_complete > $today)
                                (Ongoing)
                                @elseif($std_crs->course_complete > $today)
                                (Upcoming)
                                @else
                                (Complete)
                                @endif
                            </div>

                            <div class="input-field col s12 l3">
                                <label class="active">Batch</label>
                                {{ $batch->find($std_crs->batch_id)->name }}
                            </div>

                            <div class="input-field col s12 l3">
                                <label class="active">Course Joining</label>
                                {{ $std_crs->course_join }}
                            </div>

                            <div class="input-field col s12 l3">
                                <label class="active">Course Complete</label>
                                {{ $std_crs->course_complete }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="row">
                    <div class="input-field col s12">
                        <div class="input-field col s12">
                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function getBatch(course_id){
        if(course_id){
            $.get("{{ Asset(env('branch').'/course/getBatch') }}/"+course_id, function(data){
                var html = "<option value=\"\">Select Batch</option>";
                data.forEach(function(bat){
                    html += "<option value=\""+bat.id+"\">"+bat.name+"</option>";
                });
                $('[name="batch"]').html(html);
                $('[name="batch"]').val("{{ Old('batch') ?? '' }}");
            });
        }else{
            var html = "<option value=\"\">Select Batch</option>";
            $('[name="batch"]').html(html);
            $('[name="batch"]').val("");
        }
    }

    @if(Old('branch_course'))
    $('[name="branch_course"]').val("{{ Old('branch_course') ?? '' }}");
    getBatch("{{ Old('branch_course') }}");
    @endif
</script>
@endsection