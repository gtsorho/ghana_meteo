<template>

            <footer class="row fixed-bottom mt-5">
                <div class="col-lg-4 col-sm-8 px-5 py-2 ">
                    <div class="input-group mb-3">
                        <input class="form-control d-inline" type="text" v-model="searchdata" @keyup="search(searchdata)" placeholder="Search">
                        <button type="button" class="btn btn-warning d-inline" @click="search()">All locations</button>
                    </div>

                    <div class="list-group mt-2 text-sm-center text-lg-start">
                        <a href="#" @click="getLocationData(locationData.location)"  class="text-capitalize list-group-item ps-3 list-group-item-action"
                            v-for="locationData in searchdatares" 
                            :key="locationData.id"  >
                            {{locationData.location}}
                        </a>
                    </div>
                </div>
                
                
                
                <div class="col p-5 align-items-center" @click="$emit('populatemain',daydata)" v-for="(daydata, id) in getdata" :key="id">
                    <span class="badge rounded-pill  p-2 fw-light" :class="badgecolors()">{{getday(daydata[0].datentime)}}</span>
                    <ul class="nav flex-column">
                        <li class="nav-item my-2"><h1>{{daydata[0].temperature}}°</h1></li>
                        <li class="nav-item mb-2">
                            <i class="bi fs-1" :class="geticonclass(daydata[0].weather)"></i>
                            <h5 >{{daydata[0].weather}}</h5>
                        </li>
                    </ul>
                </div>
            </footer>
            
</template>
<script>
import axios from 'axios'

export default {
    props:[
        'weekdata'
    ],
    emits:[
        'getLocationDatas',
        'populatemain'
    ],
    data() {
        return {
            reusltdata:null,
            searchdata:'',
            searchdatares:null,
        }
    },
    computed:{
            getdata:{
                get(){
                    if(this.reusltdata){
                    console.log(this.reusltdata) 
                        return this.reusltdata
                    }else{
                        return this.weekdata
                    }
                },
                set(newValue) {
                    this.reusltdata = newValue
                }
            },            
    },
    created(){
        
    },
    methods: {
        badgecolors(){
                const colors = ["primary","success","warning","danger","dark","info"];
                var x = Math.floor(Math.random() * 5);
                let name = 'bg-' + colors[x];
                return name                
        },
        geticonclass(data){
            switch (data) {
                case 'cloudy':
                    return  'bi-clouds'
                
                case 'rainny':
                    return 'bi-cloud-rain'
                
                case 'sunny':
                    return 'bi-thermometer-sun'
                
                case 'partly coludy':
                    return 'bi-cloud-sun'
                default:
                    break;
            }
        },
        getday(date){
            const week = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            const d = new Date(date);
            let name = week[d.getDay()];
            return name
        },
        search(location = null){
            var url = `/api/searcharea/${location}`
            if(!location){
                url = `/api/searcharea/`
            }
            axios.get(url)
                .then(response =>  {
                    this.searchdatares = response.data
                })
                .catch(error => {
                    console.log(error);
            })            
        },
        getLocationData(location){
            axios.get(`/api/searchlocation/${location}`)
                .then(response =>  {
                    this.$emit('getLocationDatas', response.data);

                    const size = response.data.length
                    const items = response.data.slice(1, size)
                    this.reusltdata = items                   
                })
                .catch(error => {
                    console.log(error);
            })    
        }
    },
}
</script>
<style scoped>

    .col{
        transition: transform .4s linear; /* Animation */
    }
    .col:hover {
        /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
        transform: scale(1.1);
        opacity: 0.8;
        margin-top: 1%;
    }
    
    .fixed-bottom{
    background-size: cover;
    box-shadow: 0 15px 25px rgba(129, 124, 124, 0.2);
    height: 30%;
    border-radius: 5px;
    backdrop-filter: blur(14px);
    background-color: rgb(1, 0, 0, 0.6);
    text-align: center;
    color: aliceblue;
    } 
    .row>div{
        border-right: 1px solid rgba(90, 90, 90, 0.6);
    }
    .badge{
        letter-spacing: 1px;
    }
    input{
        background-color: #e9ecef00;
        border: none;
        border-radius: 0px;
        border-bottom:1px solid #f0f8ff75;
    }
    .form-control:focus {
        color: #ffffff;
        background-color: #ffffff12;
        border-color: #9595958c;
        outline: 0;
        border-radius: 5px 5px 0px 0px;
        box-shadow: none;
    }
    /* width */
        ::-webkit-scrollbar {
        width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #fff !important; 
        }
        
        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: rgb(160, 123, 0); 
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: rgb(222, 226, 0); 
        }
    .list-group{  
    height: 1.8in;
    overflow-y: scroll;
    }
    .list-group-item {
    position: relative;
    display: block;
    padding: .5rem 1rem;
    color: #f8f9fa;
    text-decoration: none;
    background: none !important;
    border: none !important;
    }
    .list-group-item-action:focus, .list-group-item-action:hover {
    color: #c0910e !important;
    border-radius: 51px;
    border: 10px !important;
    background-color: #6c757d29 !important;
    }
    /* If the screen size is 1000px or more, set the font-size of <div> to 80px */
    @media only screen and (max-width: 1000px) {
        .fixed-bottom {
            position: relative !important;
        }
    }
</style>

