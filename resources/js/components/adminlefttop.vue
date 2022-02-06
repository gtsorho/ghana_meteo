<template>
    <div class="card  align-self-end">
        <div class="card-body">
        <form class="row g-3  align-self-start" >
            <div class="col-md-6">
                <label for="inputDate4" class="form-label">Date</label>
                <input type="date" class="form-control" id="inputDate4" v-model="updatedata.datentime">
            </div>
            <div class="col-md-6">
                <label for="inputlocation4" class="form-label">Time of Day</label>
                <input type="text" class="form-control" id="inputlocation4"  placeholder="Apam" v-model="updatedata.timeofday">
            </div>
            <div class="col-md-12">
                <label for="inputlocation4" class="form-label">location</label>
                <input type="text" class="form-control" id="inputlocation4"  placeholder="Apam" v-model="updatedata.location">
            </div>
            <div class="col-6">
                <label for="imputTemp" class="form-label text-start">Temperature</label>
                <input type="text" class="form-control" id="imputTemp"  placeholder="28" v-model="updatedata.temperature">
            </div>
            <div class="col-6">
                <label for="imputTemp" class="form-label text-start">Weather</label>
                <select class="form-select" aria-label="Default select example" v-model="updatedata.weather">
                    <option selected>Open this select menu</option>
                    <option value="sunny">sunny</option>
                    <option value="cloudy">cloudy</option>
                    <option value="rainny">rainny</option>
                    <option value="partly cloudy">partly cloudy</option>
                </select>
            </div>
            <div class="col-6">
                <input class="form-check-input me-3" type="checkbox" v-model="checked" @click=" updatedata = []"> 
                <label class="form-check-label" for="flexCheckDefault">Add new data</label>          
            </div>
        </form>
        </div>
        <transition name="fade">
        <div class="card-footer text-muted"> 
            <p class="text-success fs-5" v-show="!successmsgbool"  >{{successmessage}}</p>
            <div class="row" v-show="successmsgbool">
                <div class="col mb-3">
                        <label for="formFileSm" :class="importmesscolor" v-if="importmess? importMessage = 'Import file .Xlsx or .CSV': importMessage" class="form-label">{{importMessage}}</label>
                    
                        <input class="form-control form-control-sm" ref="importfile" type="file" @change="fileimport($event)">
                </div>
                <div class="col mb-3 align-self-end">
                    <button type="button" class="btn btn-info float-end " v-show="test2" @click="updatedatafn">update</button>
                    <button type="button" class="btn btn-success   float-end" v-show="!test2" @click="addData">create</button>
                </div>
            </div>
        </div>
        </transition>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    props:[
        'updatedata'
    ],
    data() {
        return {
            checked:false,
            checkedupdatedint:0,
            checkedupdatedbool:false,
            importmess: true,
            importMessage: '',
            importmesscolor:'',
            successmessage:'',
            successmsgbool:true,
            successmsgclass:''
        }
    },
    methods:{
        delay(time) {
            return new Promise(resolve => setTimeout(resolve, time));
        }, 
        updatedatafn(){
            var datas = Object.assign({},this.updatedata)
            console.log(datas)
            axios.post('/api/updatedata/'+this.updatedata.id ,datas).then(response =>  {
                    console.log(response.status);
                    if(response.status == 200){
                        this.successmsgbool = false
                        this.successmessage = 'Data updated successfully'
                        this.delay(2000).then(() => 
                        {
                            this.successmsgbool = true
                            this.successmessage = ''
                        });
                    }

            }).catch(error => {
                console.log(error);
            }) 
        },
        addData(){
        var datas = Object.assign({},this.updatedata)
        console.log(datas)
        axios.post('/api/storeforcast',datas).then(response =>  {
                console.log(response);
                if(response.status == 200){
                        this.successmsgbool = false
                        this.successmessage = 'Data added successfully'
                        this.delay(2000).then(() => 
                        {
                            this.successmsgbool = true
                            this.successmessage = ''
                        });
                    }
            }).catch(error => {
                console.log(error);
            }) 
        },
        fileimport(event){
            var file = event.target.files[0]
            let formData = new FormData();
            formData.append('file', file);
            console.log(formData)

            var prompt = confirm(`This will import ${file.name} into Database`)
            if(!prompt){
                console.log('cancelled')
            }else{
            axios.post('/api/fileimport', formData)
                .then(response => {
                    if(response.status == 200){
                        this.successmsgbool = false
                        this.successmessage = `${response.data}`
                        this.delay(2000).then(() => 
                        {
                            this.successmsgbool = true
                            this.successmessage = ''
                            this.$refs.importfile.type = 'text'
                            this.$refs.importfile.type = 'file'
                        });
                    }
                })
                .catch (error => {
                    console.log(error)
                });
            }
        }
    },
    computed:{
        // test(){
        //     return this.updatedata.id ? this.checked = false : this.checked = true 
        //     // console.log(this.updatedata)
        // },
        test2(){
            if(this.updatedata.id){
                this.checkedupdatedint = this.updatedata.id
                this.checkedupdatedbool = this.checkedupdatedint > 0
                    console.log(this.updatedata)
                this.checked = !this.checkedupdatedbool
                return this.checkedupdatedbool
            }
            
        }
    }
}
</script>
<style scoped>
select option {
  background-color: #e1e2e2ed;
}
option:hover{
  background-color: #e1e2e2;
}
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
.form-control-sm{
        
        border-bottom: 0px  !important;
}
.form-check-input {
    background-color: #afafaf;
    border: 1px solid rgba(0,0,0,.25);
    
}
.form-select{
        color: #212529;
        background-color: #ffffff00;
        border: none !important;
        border-bottom: 1.5px solid !important;
        border-radius: 0px !important;
    }
form{
    height: 50%;
}
    .card{
        background-color: #e7e7e7db;
        backdrop-filter: blur(7px);
        border:none;
        border-radius: none;
        height: 40%;
        width: 100%;
    }

/* If the screen size is 1000px or more, set the font-size of <div> to 80px */
@media only screen and (max-width: 768px) {
    .card{
        height: 50%;
    }
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 1.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>