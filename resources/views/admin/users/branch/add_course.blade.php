@extends('admin.layout.main')

@section('title') Add Course to {{ $branch->name }} @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>

        @endsection



        <div id="striped-table">

            {!! Form::model($data, ['url' => [env('admin').'/branch/'.$branch->id.'/add_course'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Course</th>

                                <th>Fee(Rs)</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($courses as $course)

                            <tr>

                                <td width="50%">

                                    <input type="hidden" name="course_id[{{ $course->id }}]" value="N">

                                    <input type="checkbox" class="filled-in" id="course_id_{{ $course->id }}" name="course_id[{{ $course->id }}]" value="Y" {{ Old('course_id.'.$course->id) === 'Y' ? 'checked' : '' }}>

                                    <label for="course_id_{{ $course->id }}">{{ $course->name }} (Duration: {{ $course->duration }} Months)</label>

                                </td>

                                <td width="50%">

                                    <input type="number" id="fee_{{ $course->id }}" name="fee[{{ $course->id }}]" step="0.01" value="{{ Old('fee.'.$course->id) ?? '0.00' }}">

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>



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

@endsection



@section('js')

<script>

    window.onload = function(){

        @foreach($data as $course_batch)

        $('#course_id_'+{{ $course_batch->course_id }}).prop('checked',"{{ ($course_batch->status == 'Y') }}");

        $('#fee_'+{{ $course_batch->course_id }}).val("{{ $course_batch->fee }}");

        @endforeach

    };

</script>

@endsection