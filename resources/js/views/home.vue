<template >
    <Homeheader/>
    <Homemain :maindata="weatherdatamain"  />
    <Homefooter :weekdata="weatherdataweek" 
        @getLocationDatas="getLocationData($event)" 
        @populatemain="weatherdatamain = $event"
    />
    
</template>
<script>
import Homefooter from '../components/homefooter.vue'
import Homeheader from '../components/homeheader.vue'
import Homemain from '../components/homemain.vue'
import axios from 'axios'
export default {
    components:{
        Homefooter,
        Homeheader,
        Homemain
    },
    data() {
        return {
            weatherdatamain: '',
            weatherdataweek: ''
        }
    },
    mounted() {
        axios.get('/api/searchlocation/brekum')
        .then(response =>  {
            this.weatherdatamain = response.data[0]
            const size = response.data.length
            const items = response.data.slice(1, size)

            this.weatherdataweek = items


            // delete response.data[0]
            // var newresponse = {}
            // Object.values(response.data).forEach(item => newresponse[item.id] = item)
            // this.weatherdataweek = response.data
        })
        .catch(error => {
            console.log(error);
        }) 
    },
    methods:{
        getLocationData(data){
            this.weatherdatamain = data[0]
        }
    }
    
}
</script>
<style scoped>
</style>