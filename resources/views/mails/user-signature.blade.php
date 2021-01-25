@component('mail::message')
@if (! empty($title))
<h3 style="text-align: center;">{{ $title }}</h3>
@endif

@foreach ($introLines as $line)
<div>{{ $line }}</div>
@endforeach
<br/>

<div style="display: flex;  align-items: center; justify-content: center; height: 100%; flex-direction: column;">
<table>
<tbody>
<tr>
<td width="130" style="padding-right: 15px;">

@if($avatarUrl)
<p>
<img width="120"
style="border-radius: 50%;
border-width: 5px;
border-color:{{ $color }};
border-style: solid;"
src="{{ $avatarUrl }}" alt="">
</p>
@endif

@if($companyLogoUrl)
<p style="text-align: center; margin-top: 20px;">
<img width="100" src="{{ $companyLogoUrl }}" alt="">
</p>
@endif

</td>
<td width="250" valign="top">
<h3 style="font-size: 18px; color: rgb(0, 0, 0); font-weight: bold; margin-bottom: 5px; margin-top: 0;
font-family: Arial, sans-serif;
">
{{ $user->name }} {{ $user->surname }}
</h3>

<p style="font-size: 14px;
font-family: Arial, sans-serif;
margin-bottom: 2px;
margin-top: 0;
padding-top: 2px;
color: #fff;
padding-bottom: 2px;
">
<span style="background-color: {{ $color }}; padding-left: 5px; padding-top: 4px; padding-bottom: 4px; font-weight: bold;
padding-right: 5px;">
{{ $user->position }}
</span>
</p>
<p style="margin-top: 25px; margin-bottom: 25px; width: 100%; height: 3px; border-bottom: 1px solid {{ $color }};">
</p>

<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; font-family: Arial, sans-serif">
@if($user->phone)
<a href="tel:+998 93 835-88-88" style="text-decoration: none; color: #000;">
<img width="14px" src="{{ $icons['phone'] }}" alt="" style="margin-bottom: -1px;">
{{ $user->phone }}</a>
@endif
</p>
<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
<a style="text-decoration: none; color: #000;">
@if($user->phone)
<img width=14px" src="{{ $icons['telegram'] }}" alt="" style="margin-bottom: -1px;">
{{ $user->phone }}</a>
@endif
</p>
<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
@if($user->email)
<a href="mailto:{{ $user->email}}" style="text-decoration: none; color: #000;">
<img width="14px" src="{{ $icons['mail'] }}" alt="" style="margin-bottom: -1px;">
{{ $user->email}}
</a>
@endif
</p>
<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
@if($company->website)
<a href="{{ $company->website  }}" style="text-decoration: none; color: #000;">
<img width="14px" src="{{ $icons['web'] }}" alt="" style="margin-bottom: -1px;">
{{ $company->website }}
</a>
</p>
@endif
<p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
@if($company->address)
<a style="text-decoration: none; color: #000;">
<img width="14px" src="{{ $icons['map'] }}" alt="" style="margin-bottom: -1px;">
{{ $company->address }}
</a>
@endif
</p>
</td>
</tr>
</tbody>
</table>
</div>
@endcomponent
<br/>
