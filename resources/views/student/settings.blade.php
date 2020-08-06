@extends('student.layout.main')
@section('title') Account Settings @endsection

@section('content')
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        <form class="col s12" action="{{ Asset(env('student').'/settings') }}" method="post" autocomplete="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <h4 class="header2">Update Your Login ID (<small style="color:red">First "{{ IMS::generate_student_login_id_prefix($data->id) }}" character will remain same</small>)</h4>

                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="mdi-communication-vpn-key prefix"></i>
                                    <input id="login_id" type="text" placeholder="We need your current login id for update" required name="login_id">
                                    <label for="login_id">Current ID</label>
                                </div>

                                <div class="input-field col s6">
                                    <i class="mdi-communication-vpn-key prefix"></i>
                                    <input id="new_login_id" type="text" placeholder="Enter new login id if you want to change current" name="new_login_id">
                                    <label for="new_login_id">New ID</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <div class="input-field col s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Update <i class="mdi-content-send right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection