@if(count($data) > 0)
<div class="table-responsive">
<table id="table-kpiofdep" class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>รหัส</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $value)
        <tr data-id="{{ $value->id }}">
            <td>{{ $value->code }}</td>
            <td>
                <a onclick="delkpitodep('{{ Crypt::encrypt($value->id) }}')" class="btn btn-link btn-sm" href="javascript:void(0)"><i class="fa fa-remove" aria-hidden="true"></i> ลบ</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> 
</div>
@endif     
