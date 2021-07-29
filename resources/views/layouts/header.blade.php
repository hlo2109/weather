<div class="icomenu" :class="{'active':activeMenu}" @click="activeMenu = !activeMenu" >
  <span></span>
  <span></span>
  <span></span> 
</div>
<div class="divmenu" :class="{'active':activeMenu}">
  <div class="cont"> 
    <h3>{{ __('messages.city.title') }}</h3>
    <div>
      <seach-city v-on:selectity="selectity" />
    </div>
    <a href="{{ route('history') }}" class="link" target="_blank" >{{ __('messages.history') }}</a>
  </div>  
</div>