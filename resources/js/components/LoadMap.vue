<template>
    <div class="conmap">
          <l-map 
            ref="myMap" 
            style="width:100%; height:100%" @ready="doSomethingOnReady()"
            :zoom="zoom"
            :center="center"
            @update:zoom="zoomUpdated"
            @update:center="centerUpdated"
            @update:bounds="boundsUpdated"
            >
                <l-tile-layer 
                    :url="url"
                    name="hlo21.com"
                    :visible="true"
                    attribution="&copy; <a target='_blank' href='https://hlo21.com'>hlo21.com</a>"
                
                ></l-tile-layer>
                <l-marker v-for="(item,key) in markers" :key="key" 
                :lat-lng="item"   
                > 
                    <l-icon
                            :iconSize="item.icon.iconSize"
                            :iconAnchor="item.icon.iconAnchor"
                            :iconUrl="item.icon.iconUrl" 
                            className="icosClimas"
                            >
                    </l-icon>
                    <l-popup :lat-lng="item"  :content="`<strong>${__('messages.city')}</strong>: ${item.name} <br> <strong>${__('messages.humidity')}</strong>:${item.humidity} <br> <strong>${__('messages.weather')}</strong> ${item.tiempo.description}`"/>
                </l-marker>
                
            </l-map>
          <notifications />
    </div>
</template>

<script> 
    // Ejemplo markets
    /*markers:[
        {
            name:'',
            humidity:'',
            tiempo:[],
            LatLng:[48.29060365031643,-4.885634707031241]
        }, 
    ]*/

    import L  from 'leaflet';
  

    import { LMap, LTileLayer, LMarker, LPopup, LIcon } from 'vue2-leaflet';
    import 'leaflet/dist/leaflet.css';
 
    export default {
        props:['cityload'],
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup,
            LIcon
        },
        data(){
            return{ 
                map:null,
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                zoom: 5,
                center: [33.30298618122413,-81.27685546875001],
                bounds: null,
                markers:[],
                citysDefault:[
                    4164138,
                    4167147,
                    5128581
                ],
                countCitys:0,
                tileProviders: [
                    {
                    name: 'OpenStreetMap',
                    visible: true,
                    attribution:
                        '&copy; <a target="_blank" href="https://hlo21.com">hlo21.com</a>',
                    url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    }
                ],
            }
        },
        watch:{
            'cityload':function(res){  
                // Consultamos si la ciudad ya existe en ciudades por defecto
                const exist = this.citysDefault.indexOf(res.id);
                // Si no existe la agregamos
                if(exist == -1){ 
                    this.citysDefault.push(res.id); 
                } 

                this.loadData(res.id, (data)=>{
                    //Cuando termine la carga de la ciudad seleccionada cargamos la posición para quedar cerca de la misma.
                    this.center = [data.coord.lat, data.coord.lon]; 
                }); 
            }
        },
        mounted() {            
            // Carga de datos de ciudades por defecto
            if(this.markers.length == 0){
                this.loadcitys();    
            }
            // Carga ciudades por defecto cada 20 segundos para actualizar sus datos
            setInterval(() => {                
                this.loadcitys();    
            }, 20000);
            
            // this.loadData(3682385);
        },
        methods: {
            loadData(id, rollback ){
                axios.post('/load/weatherload',{'cityid':id})
                .then(res=>{
                    // Capturamos datos de la ciudad 
                    const city = res.data;  
                    // Armamos url icono según documentación de la api
                    const iconurl = "https://openweathermap.org/img/w/" + city.weather[0].icon + ".png"; 

                    //Consultamos si ya ahí un icono existen y si es verdadero lo eliminamos para actualizar la información, de manera no tenemos que eliminar todo el vector y vamos cargando uno a uno.                    
                    const exist = this.markers.findIndex(res=> res.id==id);                     
                    if(exist !== -1){ 
                        this.markers.splice(exist, 1); 
                    }
                    this.markers.push({
                        id:city.id,
                        name:city.name,
                        humidity:city.main.humidity,
                        tiempo:city.weather[0],
                        lat:city.coord.lat, 
                        lng:city.coord.lon,
                        icon: {
                            iconUrl: iconurl,
                            iconSize: [50, 50],
                            iconAnchor: [50, 50]
                        },
                    });                    
                    return rollback(city); 
                })
                .catch((e)=>{
                    if(e.response.data){   
                        this.$notify(e.response.data.message);                        
                    }
                    return rollback(true);
                })
            },
            loadcitys(){
                const id = this.citysDefault[this.countCitys];
                this.loadData(id, (res)=>{
                    this.countCitys++;
                    if(this.countCitys<this.citysDefault.length){
                        setTimeout(this.loadcitys(), 1000)
                    } else{
                        this.countCitys = 0;
                    }
                })
            },
            doSomethingOnReady() {
                this.map = this.$refs.myMap.mapObject 
            },
            zoomUpdated (zoom) { 
                this.zoom = zoom; 
            },
            centerUpdated (center) { 
                this.center = center; 
            },
            boundsUpdated (bounds) {
                this.bounds = bounds;
            }
        },
        computed:{

        }
        
    }
</script>
