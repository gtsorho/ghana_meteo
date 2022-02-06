<template>
            <div class="card  align-self-end">
                <div class="card-header">
                    <form class="row g-3  align-self-start" >
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="inputlocation4" v-model="location" placeholder="Apam">
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" v-show="!dateselector" v-model="date">
                                <date-picker v-show="dateselector" v-model:value="datefrompicker" valueType="format" placeholder="YYYY-MM-DD ~ YYYY-MM-DD" format="YYYY-MM-DD" class="form-control" range></date-picker>
                                <i class="bi bi-search input-group-text bg-warning" @click="adminsearch"></i>
                            </div>
                        </div>
                    </form>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" v-model="dateselector" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">{{!dateselector ? 'Search date by Range': 'search by date instance'}}</label>
                    </div>
                </div>
                <div class="card-body py-0">
                    <a href="#" class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" v-model="selectAll">
                            select all
                    </a>
                    <ul class="list-group" v-for="(item, id) in allsearchdata" :key="id">
                        <label for="date" class="form-label mb-0 mt-2">{{item.date}}</label>
                        <a href="#" class="list-group-item list-group-item-action ms-3" v-for="data in item.weatherdatas" :key="data.id" @click="$emit('datatoupdate', data)">
                            <input class="form-check-input me-3" type="checkbox" :value="data.id" v-model="checkeddata" >
                            <p class="text-capitalize d-inline">{{data.temperature +'° '+ data.weather +' in the '+ data.timeofday +' at '+ data.location}}</p> 
                        </a>
                    </ul>
                </div>
                <div class="card-footer text-muted " height="10%">
                    <nav aria-label="Page navigation example " class="mb-1">
                        <ul class="pagination justify-content-center m-0">
                            <li class="page-item me-3" @click="adminsearch(currentpage < 1 ? currentpage=1 : currentpage--)">
                                <a class="prevNext" href="#" ><i class="bi fs-3 bi-arrow-left-circle"></i></a>
                            </li>
                            <Popper :content="'Page '+currentpage.toString() + '  of '+ last_page.toString()" placement="bottom" :show="true" >
                                <input type="range"  v-model="currentpage" @click="adminsearch" class="form-range px-2 my-auto" :min="firstpage" :max="last_page" id="customRange2">
                            </Popper>
                            <!-- <li class="page-item" v-for="i in AdminSearchArr" :key="i" @click=" currentpage = i,adminsearch(i)" ><a class="prevNext" href="#">{{i}}</a></li> -->
                            <li class="page-item ms-3">
                                <a class="prevNext" href="#" @click="currentpage >= responsedata.last_page ? responsedata.last_page:currentpage++,adminsearch(currentpage)"><i class="bi fs-3 bi-arrow-right-circle"></i></a>
                            </li>
                        </ul>
                    </nav>
                    <button type="button" class="btn btn-danger float-start" :class="delete_display" @click="deletedata">Delete</button>
                    <button type="button" class="btn btn-warning float-end" @click="expertdata">Export</button>
                

                </div>
                
            </div>
            
</template>


<script>


import axios from 'axios'
import Popper from "vue3-popper"
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';

export default {
    components: {
      Popper,
      DatePicker
    },
    emits:[
        'datatoupdate'
    ],
    mounted(){

    },
    data() {
        return {
            dateselector:false,
            datefrompicker: [''],
            checkeddata : [],
            allSelected: false,
            date:'',
            location:'',
            allsearchdata:[],
            searchresponsedata:[],
            responsedata:{
                'last_page' : 1
            },
            currentpage: 1,
            last_page:5,
            firstpage:1,
            arr:[],
            AdminSearchArr:[]
        }
    },
    methods: {   
        
            deletedata(){
            let arr = []
            let axiosarray = []
            let checkeddata2 = this.checkeddata
            if (confirm('All selection(s) will be deleted/distroyed(Permanently)')){
                checkeddata2.forEach(data => 
                {var newpromise = axios.get('/api/delete/'+ data)
                    axiosarray.push(newpromise)
                })
                axios.all(axiosarray)
                .then(axios.spread((...responses) =>{ 
                    responses.forEach(res =>arr.push(res.data)
                    )
                    if(arr.length == checkeddata2.length){
                        console.log('success')
                        this.adminsearch()
                    }                     
                })).catch(error => {
                    console.log(error);
                }) 
            }else{
                console.log('cancelled')
            }
        },
        expertdata(){
            var postdate
            if(!this.dateselector){
                postdate = this.date
            }else{
                postdate = this.datefrompicker
            }

            var fileDownload = require('js-file-download');
            axios({
            url: '/api/fileexport',
            method: 'post',
            data:{
                location: this.location,
                date: postdate
            },
            responseType: 'blob', // Important
            }).then((response) => {
                fileDownload(response.data, 'weatherData'+new Date().toDateString()+'.xlsx');
            }).catch(error => {
                console.log(error);
            });
        },

        adminsearch(){
            var postdate
            if(!this.dateselector){
                postdate = this.date
            }else{
                postdate = this.datefrompicker
            }

            // console.log(this.datefrompicker)
            // this.currentpage = this.currentpage

            axios.post('/api/adminsearch?page='+ this.currentpage,{
                location: this.location,
                date: postdate
            }).then(response =>  {
                this.responsedata = response.data 
                console.log(this.responsedata)
                this.last_page = response.data.last_page
                this.searchresponsedata = response.data.data
                
                const groups = response.data.data.reduce((groups, weatherdata) => {
                const date = weatherdata.datentime

                if (!groups[date]) {
                    groups[date] = [];
                }
                groups[date].push(weatherdata);
                return groups;
                }, {});

                // Edit: to add it in the array format instead
                const groupArrays = Object.keys(groups).map((date) => {
                return {
                    date,
                    weatherdatas: groups[date]
                };
                });
                this.allsearchdata = groupArrays
                console.log(this.allsearchdata);

            }).catch(error => {
                console.log(error);
            }) 
        }
    },
    computed: {
        delete_display(){
            if(this.checkeddata.length == 0){
                return 'disabled'
            }
        },
        selectAll: {
            get: function () {
                // console.log(this.allsearchdata ? this.checkeddata.length == this.searchresponsedata.length : false, this.checkeddata.length, this.searchresponsedata.length)
                return this.allsearchdata ? this.checkeddata.length == this.searchresponsedata.length : false;
            },
            set: function (value) {
                var checkeddata = [];

                if (value) {
                    // console.log(this.allsearchdata)
                    this.allsearchdata.forEach(function (data) {
                        data.weatherdatas.forEach(function (item){
                            checkeddata.push(item.id);
                        })   
                    });
                }

                this.checkeddata = checkeddata;
            }
        }
    },  
    // methods: {
    //     selectAll: function() {
    //         this.checkeddata = [];

    //         if (!this.allSelected) {
    //             for (var data in this.response) {
    //                 this.checkeddata.push(this.response[data].id);
    //             }
            
    //         }
    //     },
    // }
}
</script>
<style scoped>
   .form-control{
        color: #212529;
        background-color: #ffffff00;
        border: none !important;
        border-bottom: 1.5px solid !important;
        border-radius: 0px !important;
    }
    .form-control:focus {
    background-color: #aaaaaa52 !important;
    border-color: none;
    box-shadow: none !important;
}
    .card{
        height: 100%;
        background-color: #e7e7e7db;
        backdrop-filter: blur(7px);
        border:none;
        border-radius: none;
    }
    .list-group-item {
    border: 0px solid rgba(0,0,0,.125);
    border-bottom: 1px solid rgb(0 0 0 / 20%);
    background-color: #8f8f8f00;
    width: 93%;
    }
    .bi-search:hover{
        background-color: #e2e2e2;
    }
    .prevNext{
        color: #049b55;
    }
    .prevNext:focus {
    color: #0f5132 !important;
    /* background-color: #a1f79e !important; */
    box-shadow: none;
    }
    .inline-block{
    width: -webkit-fill-available !important;
    }
    .form-range{
        vertical-align: -webkit-baseline-middle;
    }
    .form-range::-webkit-slider-thumb {
    background: rgb(51, 155, 19);
    }




</style>