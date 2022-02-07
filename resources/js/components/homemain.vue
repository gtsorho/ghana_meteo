<template>

    <div class="card rounded-pill m-auto">
    <div class="card-body">
            <div class="row">
                <div class="col-4 align-self-center text-center text-md-end">
                    <h1 class="display-1 text-capitalize">{{getdata[0]?.temperature}}°</h1>
                </div>
                <div class="col-4 text-center align-self-center">
                    <h4 class="display-3 text-capitalize">{{getdata[0]?.location}}</h4>
                    <h5 class="fs-6 text-capitalize">{{getday}}</h5>
                </div>
                <div class="col-4  align-self-center text-center text-md-start">
                    <i class="bi display-1" :class="iconclass" ></i>
                    <h5 class="text-capitalize">{{getdata[0]?.weather}}</h5>
                </div>
            </div>
            <hr class="text-light mx-auto w-75">
            <div class="row justify-content-md-center">
                <div class="col text-center" v-for="data in getdatatwo" :key="data.id">
                    <p class="fs-5 text-capitalize text-success fw-bolder">{{data.temperature}}° {{data.weather}}</p>
                    <p class="fs-6 text-capitalize">{{data.timeofday}} </p>
                </div>
            </div>

    </div>
</div>


</template>
<script>
export default { 
    data() {
        return {
            iconclass:null
        }
    },   
    props:[
        'maindata'
    ],
    computed:{
        getdata(){
            switch (this.maindata[0]?.weather) {
                case 'cloudy':
                    this.iconclass =  'bi-clouds'
                break;
                case 'rainny':
                    this.iconclass = 'bi-cloud-rain'
                break;
                case 'sunny':
                    this.iconclass = 'bi-thermometer-sun'
                break;
                case 'partly coludy':
                    this.iconclass = 'bi-cloud-sun'
                break;
                default:
                    break;
            }
            return this.maindata;

        },
        getdatatwo(){
            let maindatatwo = this.getdata
            const size = maindatatwo.length
            const items = maindatatwo.slice(1, size)
            return items
        },


        getday(){
            return  new Date(this.getdata[0]?.datentime).toDateString()
            // const week = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            // const d = new Date(this.getdata[0]?.datentime);
            // let name = week[d.getDay()];
            // return name
        }
    }
    
}
</script>
<style scoped>  
.row div{
    color: rgb(197, 197, 197);
}
.card{
    margin-top: 10rem !important;
    width: 80%;
    overflow-wrap: normal;
    background-color: rgb(0 0 0 / 50%) !important;
    border: 0px solid rgba(255, 255, 255, 0.125) !important;
}
/* If the screen size is 601px or more, set the font-size of <div> to 80px */
/* @media only screen and (min-width: 601px) {
  div.example {
    font-size: 80px;
  }
} */

/* If the screen size is 600px or less, set the font-size of <div> to 30px */
@media only screen and (max-width: 800px) {
    .card{
        width: inherit;
    }
    .display-3 {
        font-size: 1.75rem !important;
        font-weight: 300 !important;
        line-height: 1.0 !important;
    }
    .display-1 {
        font-size: 1.75rem !important;
        font-weight: 200 !important;
        line-height: .50 !important;
    }
    .fs-5 {
        font-size: 1rem !important;
        font-weight: 100 !important;
        line-height: .50 !important;
    }
    .fs-6 {
        font-size: .8rem !important;
        font-weight: 100 !important;
        line-height: 1.2 !important;
    }
}

</style>