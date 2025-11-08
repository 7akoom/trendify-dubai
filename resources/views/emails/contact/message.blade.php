@component('mail::message')
# رسالة جديدة

**{{__('contact.Name')}}:** {{ $data['name'] }}  
**{{__('contact.Phone')}}:** {{ $data['phone'] }}  
**{{__('contact.Email')}}:** {{ $data['email'] }}

---

{{ $data['message'] }}

@endcomponent
