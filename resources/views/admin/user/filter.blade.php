<?php $i=1;?>
@foreach($users as $list)
@php
    $getgroups = \App\Models\UserGroup::leftJoin('groups', 'user_groups.group_id', '=', 'groups.id')
        ->where('user_groups.user_id', $list->id)
        ->select('user_groups.*', 'groups.description')
        ->get();
    $descriptions = $getgroups->pluck('description')->implode(', ');
    $status = $list->status == "1" ? "Active" : "Inactive";
    $statuscss = $list->status == "1" ? "active" : "inactive";
@endphp
<tr>
    <td class="small_td"><span class="number_text">{{ $i }}</span></td>
    <td>
        <span class="name_text">
            <div class="icon">
                @if($list->user_image)
                <img src="{{ url('public/user_image/' . $list->user_image) }}" alt="">
                @endif
                
            </div>
            <div class="text_box">
                <h4>{{ $list->name }}</h4>
                <p>{{ $list->phone }}</p>
            </div>
        </span>
    </td>  
    <td><span class="table_text">{{ $list->email }}</span></td>  
    <td><span class="table_text">{{ $descriptions }}</span></td>   
    <td><span class="status_btn {{ $statuscss }}">{{ $status }}</span></td>    
    <td>
        <div class="d-flex align-items-center">
            <a class="mx-2" href="{{url('admin/user/manage-user/')}}/{{$list->id}}"><img src="{{ url('public/admin/images/edit_icon.svg') }}" alt=""></a>
            <a class="mx-2 del_popup2" href="javascript:void(0)" data-id="{{$list->id}}"><img src="{{ url('public/admin/images/delete_icon.svg') }}" alt=""></a>
            <a class="mx-2" href="#"><img src="{{ url('public/admin/images/location_icon.svg') }}" alt=""></a>
        </div>
    </td>  
</tr> 
<?php $i++; ?>
@endforeach