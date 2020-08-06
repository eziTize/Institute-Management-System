@extends('admin.layout.main')

@section('title') Fee Settings @endsection



@section('content')

<div class="container">

    <div class="section">

        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Fee Type</th>

                                <th >Fee Amount (Rs)</th>

                                <th> Edit </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $exfees)

                            <tr>

                                <td width="45%">{{ $exfees->fee_type }}</td>

                                <td width="35%">{{ $exfees->fee_amount }}</td>

                                <td width="20%">

                                    <a href="{{ Asset($link.$exfees->slug.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit {{ $exfees->fee_type }}" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection