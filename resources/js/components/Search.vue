<template>
  <div class="contsearch"> 
    <input type="text" :placeholder="__('messages.city.title')" v-model="search">
    <ul>
      <li v-for="(item,key) in listcitys" :key="key" @click="select_city(item)">
        {{ item.name }}
      </li>
    </ul> 
  </div>
</template>
<script>
export default {
  data(){
        return{
            search:'',
            listcitys:[],

        }
    },
    watch: {
        search:function(res){ 
            if(res.length>=3){
              axios.post('/load/searchcity', {search:res}).then(res=>{
                this.listcitys = res.data;
              }).catch(e=>{

              })
            } else{
              this.listcitys=[];
            }
        }        
    },
    methods:{
      select_city(item){ 
          this.search = '';
          this.listcitys=[];
          this.$emit('selectity', item)
        }
    }
}
</script>
 