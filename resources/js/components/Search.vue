<template>
  <div class="contsearch"> 
    <input type="text" :placeholder="__('messages.city.title')" v-model="search">
    <ul>
      <li v-for="(item,key) in listcitys" :key="key" @click="select_city(item.json)">
        {{ item.city_name }}
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
        search:function(txt){ 
            if(txt.length>=3){ 
              axios.post('/load/searchcity', {search:txt}).then(res=>{ 
                this.listcitys = res.data;
              }).catch(e=>{ 
                if(e.response.data){
                  this.$notify({
                      text: e.response.data.message,
                      type: 'error'
                  });
              }
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
 