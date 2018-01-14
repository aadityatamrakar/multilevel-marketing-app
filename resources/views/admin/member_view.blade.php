@extends('template.admin')

@section('content')
    <div class="container">
        <h3>Member Details, PCW{{ $member->id }}
            <a href="{{ route('admin.member.edit', ['id'=>$member->id]) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
            <a target="_blank" href="{{ route('member.dashboard') }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-folder-open"></i> Member Dashboard</a>
        </h3>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#basic" aria-controls="home" role="tab" data-toggle="tab">Basic Details</a></li>
            <li role="presentation"><a href="#nominee" aria-controls="profile" role="tab" data-toggle="tab">Nominee Details</a></li>
            <li role="presentation"><a href="#bank" aria-controls="messages" role="tab" data-toggle="tab">Bank Details</a></li>
            <li role="presentation"><a href="#uploaded" aria-controls="settings" role="tab" data-toggle="tab">Uploaded Docs</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="basic">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>PCW{{ $member->id }} <span onclick="this.innerHTML='{{ $member->password }}'" class="btn btn-xs btn-default">Show Password</span></td>
                    </tr>
                    <tr>
                        <th>Sponsor</th>
                        <td>PCW{{ $member->s_id }}, <button class="btn btn-xs btn-primary"><i class="glyphicon-folder-open glyphicon"></i> {{ ($member->sponsor)?$member->sponsor->name:"" }}</button></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $member->name }}</td>
                    </tr>
                    <tr>
                        <th>Father/Husband Name</th>
                        <td>{{ $member->father_name }}</td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td>{{ $member->dob_d . '/'. $member->dob_m . '/'. $member->dob_y }}, {{ ($member->dob_y!==''&&$member->dob_m!==''&&$member->dob_d!=='')?\Carbon\Carbon::create($member->dob_y, $member->dob_m, $member->dob_d)->diffForHumans():'' }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $member->mobile }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $member->address }}<br>City: {{ $member->city }}, PIN: {{ $member->pincode }}<br>District: {{ $member->district }}<br>State: {{ $member->state }}</td>
                    </tr>
                    <tr>
                        <th>PAN Card</th>
                        <td>{{ $member->pancard }} {{ $member->applied_pan == 'Yes'?"Applied for PAN Card.":'' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="nominee">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Nominee Name</th>
                        <td>{{ $member->nominee_name }}</td>
                    </tr>
                    <tr>
                        <th>Nominee Relation</th>
                        <td>{{ $member->nominee_relation }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="bank">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Bank Name</th>
                        <td>{{ $member->bank }}</td>
                    </tr>
                    <tr>
                        <th>Account No</th>
                        <td>{{ $member->account_no }}</td>
                    </tr>
                    <tr>
                        <th>Bank IFSC</th>
                        <td>{{ $member->ifsc }}</td>
                    </tr>
                    <tr>
                        <th>Branch</th>
                        <td>{{ $member->branch }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="uploaded">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>ID Proof ({{ $kyc['id'] }})</th>
                        <td>
                            {!! $kyc['apf']?'<a target="new" href="/uploads/member/apf_'.$member->id.'.jpg" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-folder-open"></i> View Front</a>':'NA'  !!}
                            {!! $kyc['apb']?'<a target="new" href="/uploads/member/apb_'.$member->id.'.jpg" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-folder-open"></i> View Back</a>':'NA'  !!}
                        </td>
                    </tr>
                    <tr>
                        <th>Pancard</th>
                        <td>{!! $kyc['ip']?'<a target="new" href="/uploads/member/ip_'.$member->id.'.jpg"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-folder-open"></i> View</a>':'NA' !!}</td>
                    </tr>
                    <tr>
                        <th>Bank ({{ $kyc['bank'] }})</th>
                        <td>{!! $kyc['c']?'<a target="new" href="/uploads/member/c_'.$member->id.'.jpg"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-folder-open"></i> View</a>':'NA' !!}</td>
                    </tr>
                    <tr>
                        <th>KYC</th>
                        <td>
                            @if($member->kyc == 0 || $member->kyc == null)
                                <button class="btn btn-primary btn-xs" data-target="{{ $member->id }}" id="approve_kyc">Approve</button>
                            @else
                                <button class="btn btn-primary btn-xs" data-target="{{ $member->id }}" id="unapprove_kyc">Un-Approve</button>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $("#unapprove_kyc").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var id = btn.data('target');
            $.ajax({
                url: "{{ route('admin.member.kyc_update') }}",
                type: "POST",
                async: true,
                data: {id: id, 'do': 'unapprove'}
            }).done(function (e){
                if(e.status == 'done'){
                    alert("KYC Done.");
                    btn.html("Done.");
                }
            });
        });
        $("#approve_kyc").click(function (){
            var btn = $(this);
            btn.attr('disabled', '');
            var id = btn.data('target');
            $.ajax({
                url: "{{ route('admin.member.kyc_update') }}",
                type: "POST",
                async: true,
                data: {id: id, 'do': 'approve'}
            }).done(function (e){
                if(e.status == 'done'){
                    alert("KYC Done.");
                    btn.html("Done.");
                }
            });
        })
    </script>
@endsection