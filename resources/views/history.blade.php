@extends('layouts.interna')
@section('content')
<div class="conthistorial">
  <div class="container">
    <h1>
      {{__('messages.historytitle')}} 
      <a href="{{route('home')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
          <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
        </svg>
      </a>
    </h1>
    <table>
      <thead>
        <th>ID</th>
        <th>{{__('messages.city.name')}}</th>
        <th>{{__('messages.humidity')}}</th>
        <th>{{__('messages.weather')}}</th> 
        <th></th>
        <th></th>
      </thead>
      <tbody>
        @foreach ($history as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->city_name}} ({{$item->json['sys']['country']}})</td> 
            <td>{{$item->json['main']['humidity']}}</td>
            <td>{{$item->json['weather'][0]['description']}}</td> 
            <td>{{ \helper::dateLetter($item->created_at, true) }}</td>
            <td><div class="ico" style="background-image: url({{"https://openweathermap.org/img/w/" . $item->json['weather'][0]['icon'] . ".png"}})"></div></td>
          </tr>    
        @endforeach 
      </tbody>
    </table>
    <div class="paginate"> 
      <ul>
        @if($history->previousPageUrl())
        <li>
          <a href="{{$history->previousPageUrl()}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
              <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
            </svg>
          </a>
        </li>
        @endif
        @for ($i = 1; $i <= $history->lastPage(); $i++)                             
        <li>
            @if($history->currentPage()==$i)
              <span>{{$i}}</span>
            @else
              <a href="{{ route('history',['page'=>$i]) }}" class="item">{{$i}}</a>
            @endif
        </li>
        @endfor
        @if($history->nextPageUrl())
        <li>
          
          <a href="{{$history->nextPageUrl()}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
              <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
            </svg>
          </a>
         
        </li>
        @endif
      </ul>
    </div>
  </div>
</div>
@endsection()
