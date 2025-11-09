@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')

{{-- Notifications --}}
<div class="container-fluid mt-5">
    @if (count($notifications) > 0 )
      @foreach ($notifications as $key => $q )
      @if($q->notifications_type == 1)
      <a href="{{ url('notifications-details/'.$q->enquiry_id.'/'.$q->id)  }}" class="btn btn-white d-block w-100 p-0 mb-3"  >
            <div class="alert d-flex align-items-center justify-content-between alert-warning alert-dismissible fade show" role="alert">
                <p><strong>New Enquiry with {{ @$q->name }} on  {{ date('d/m/Y', strtotime(@$q->created_at))  }} from {{ @$q->showroom->name }}, assigned to {{ @$q->assign ? @$q->assign_by->name : '' }}, created by {{ @$q->users->name }}</strong></p>
            </div>
        </a>
        @elseif($q->notifications_type == 2)
        <a href="{{ url('notifications-details/'.$q->enquiry_id.'/'.$q->id)  }}" class="btn btn-white d-block w-100 p-0 mb-3"  >
            <div class="alert d-flex align-items-center justify-content-between alert-warning alert-dismissible fade show" role="alert">
                <p><strong>On  {{ date('d/m/Y h:i:s A', strtotime($q->next_follow_up_date))  }} there is a scheduled follow-up (Follow-up method) with {{ $q->name }}</strong></p>
            </div>
         </a>
        @elseif($q->notifications_type == 3)
        <a href="{{ url('notifications-details/'.$q->enquiry_id.'/'.$q->id)  }}" class="btn btn-white d-block w-100 p-0 mb-3"  >
            <div class="alert d-flex align-items-center justify-content-between alert-warning alert-dismissible fade show" role="alert">
                <p><strong>One of the follow-ups was missed for the Enquiry {{ date('d/m/Y h:i:s A', strtotime($q->next_follow_up_date))  }} , assigned to {{ $q->users->name }} at {{ $q->showroom->name }}</strong></p>
            </div>
        </a>
        @endif 

      @endforeach

      <a class="btn btn-sm btn-danger float-right" href="{{ url('clear-all') }}">Clear All</a>
      @else 

      <h2>The notification is currently unavailable</h2>

      @endif
 
</div>

@endsection
